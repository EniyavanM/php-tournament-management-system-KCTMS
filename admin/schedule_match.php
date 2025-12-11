<?php
session_start();
include("../conn_db.php");

if (!isset($_SESSION['aid'])) {
    header("Location: ../player_login.php");
    exit();
}

// Check if sport_id is provided in the URL
if (!isset($_GET['sport_id']) || !is_numeric($_GET['sport_id'])) {
    die("Invalid Sport ID. Please go back and select a sport.");
}

$sport_id = intval($_GET['sport_id']);

// Fetch teams registered for this sport
$sql = "SELECT t.team_id, t.team_name, p.c_firstname AS captain_name 
        FROM teams t 
        JOIN player p ON t.c_id = p.c_id 
        WHERE t.s_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $sport_id);
$stmt->execute();
$result = $stmt->get_result();
$teams = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Handle match scheduling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $team1_id = intval($_POST['team1']);
    $team2_id = intval($_POST['team2']);
    $match_date = $_POST['match_date'];
    $match_time = $_POST['match_time'];
    $venue = trim($_POST['venue']);

    // Validate inputs
    if ($team1_id == $team2_id) {
        $error = "A team cannot play against itself.";
    } elseif (empty($match_date) || empty($match_time) || empty($venue)) {
        $error = "All fields are required.";
    } else {
        // Check if the match is already scheduled
        $check_sql = "SELECT * FROM scheduled_matches WHERE s_id = ? AND team1_id = ? AND team2_id = ?";
        $stmt = $mysqli->prepare($check_sql);
        $stmt->bind_param("iii", $sport_id, $team1_id, $team2_id);
        $stmt->execute();
        $check_result = $stmt->get_result();
        if ($check_result->num_rows > 0) {
            $error = "This match is already scheduled.";
        } else {
            // Insert the scheduled match into the database
            $insert_sql = "INSERT INTO scheduled_matches (s_id, team1_id, team2_id, match_date, match_time, venue, status) 
                           VALUES (?, ?, ?, ?, ?, ?, 'Scheduled')";
            $stmt = $mysqli->prepare($insert_sql);
            $stmt->bind_param("iiisss", $sport_id, $team1_id, $team2_id, $match_date, $match_time, $venue);

            if ($stmt->execute()) {
                $success = "Match successfully scheduled!";
            } else {
                $error = "Error scheduling match.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Match</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- NAV HEADER -->
<header class="navbar navbar-expand-md navbar-light fixed-top bg-light shadow-sm mb-auto">
    <div class="container-fluid mx-4">
        <a href="admin_home.php">
            <img src="../img/kct.jpg" width="70" class="me-2" alt="kctms Logo">
        </a>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item"><a class="nav-link px-2 text-dark" href="admin_home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link px-2 text-dark" href="admin_matches_list.php">Matches</a></li>
                <li class="nav-item"><a class="nav-link px-2 text-dark" href="admin_Tournament_list.php">Tournaments</a></li>
            </ul>
            <div class="d-flex">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a href="admin_ply_detail.php?c_id=<?= $_SESSION['aid'] ?>" class="nav-link px-2 text-dark">
                            Welcome, <?= $_SESSION['firstname'] ?> <i class="bi bi-person-circle"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="mx-2 mt-1 mt-md-0 btn btn-outline-danger" href="../logout.php">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<div class="container mt-5 pt-5">
    <h2 class="text-center">Schedule Match</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="team1" class="form-label">Select Team 1</label>
            <select class="form-select" name="team1" required>
                <option value="">-- Select Team 1 --</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= $team['team_id'] ?>"><?= $team['team_name'] ?> (Captain: <?= $team['captain_name'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="team2" class="form-label">Select Team 2</label>
            <select class="form-select" name="team2" required>
                <option value="">-- Select Team 2 --</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= $team['team_id'] ?>"><?= $team['team_name'] ?> (Captain: <?= $team['captain_name'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="match_date" class="form-label">Match Date</label>
            <input type="date" class="form-control" name="match_date" required>
        </div>

        <div class="mb-3">
            <label for="match_time" class="form-label">Match Time</label>
            <input type="time" class="form-control" name="match_time" required>
        </div>

        <div class="mb-3">
            <label for="venue" class="form-label">Venue</label>
            <input type="text" class="form-control" name="venue" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Schedule Match</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
