<?php
session_start();
include("conn_db.php");

// Check if the user is logged in
if (!isset($_SESSION['cid'])) {
    echo "<script>alert('Unauthorized access! Please log in first.'); window.location='player_login.php';</script>";
    exit();
}

// Check if team_id is provided in the URL
if (!isset($_GET['team_id']) || empty($_GET['team_id'])) {
    echo "<script>alert('Invalid Access!'); window.location='index.php';</script>";
    exit();
}

$team_id = intval($_GET['team_id']); // Convert to integer for security
$user_id = $_SESSION['cid']; // Logged-in user ID

// Check database connection
if (!$mysqli) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Fetch team details (Only if the user owns the team)
$query = "SELECT teams.team_name, matches.f_name FROM teams 
          JOIN matches ON teams.s_id = matches.s_id 
          WHERE teams.team_id = ? AND teams.c_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ii", $team_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$team = $result->fetch_assoc();

// If no team found, prevent unauthorized access
if (!$team) {
    echo "<script>alert('Invalid Team or Unauthorized Access!'); window.location='index.php';</script>";
    exit();
}

// Fetch team players
$query = "SELECT player_id, player_name FROM team_players WHERE team_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $team_id);
$stmt->execute();
$players = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Details</title>
    <link rel="stylesheet" href="css/main.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #343a40;
            font-size: 30px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .team-info {
            font-size: 22px;
            color: #007bff;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .player-list {
            text-align: left;
            margin-top: 20px;
            padding: 0;
        }
        .player-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: #e9ecef;
            margin-bottom: 10px;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
        }
        .btn-edit {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-edit:hover {
            background-color: #218838;
        }
        .btn-back {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>🏆 <?= htmlspecialchars($team['team_name']) ?> 🏆</h2>
        <p class="team-info">Sport: <?= htmlspecialchars($team['f_name']) ?></p>

        <h3>Team Players</h3>
        <div class="player-list">
            <?php while ($player = $players->fetch_assoc()): ?>
                <div class="player-item">
                    <span>👤 <?= htmlspecialchars($player['player_name']) ?></span>
                    <a href="edit_player.php?player_id=<?= urlencode($player['player_id']); ?>">Edit</a>

                </div>
            <?php endwhile; ?>
        </div>

        <a class="btn-back" href="index.php">🏠 Go to Home</a>
    </div>

</body>
</html>
