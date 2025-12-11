<?php
session_start();
include("conn_db.php");
require 'auth_check.php';

// Check if player is logged in
if (!isset($_SESSION['cid'])) {
    echo "<script>alert('Unauthorized Access! Please log in.'); window.location='index.php';</script>";
    exit();
}

$player_id = $_SESSION['cid']; // Logged-in player's ID

// Fetch sport ID for the logged-in player
$query = "SELECT s_id FROM mreg_status WHERE c_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $player_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$sport_id = $row['s_id'] ?? null;

// Define player count based on sport
$player_count = ($sport_id == 2) ? 15 : (($sport_id == 8) ? 12 : 0);

if (!$sport_id || $player_count == 0) {
    echo "<script>alert('You have not registered for any sport!'); window.location='index.php';</script>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $team_name = $_POST['team_name'];
    $college_name = $_POST['college_name'];
    $players = [];

    for ($i = 1; $i <= $player_count; $i++) {
        $player_name = trim($_POST["player_$i"]);
        if (!empty($player_name)) {
            $players[] = $player_name;
        }
    }

    if (count($players) < $player_count) {
        echo "<script>alert('Please enter all $player_count player names!'); history.back();</script>";
        exit();
    }

    // Insert team into 'teams' table
    $query = "INSERT INTO teams (team_name, s_id, c_id) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sii", $team_name, $sport_id, $player_id);

    if ($stmt->execute()) {
        $team_id = $stmt->insert_id;

        // Insert players into 'team_players' table
        foreach ($players as $player) {
            $query = "INSERT INTO team_players (team_id, player_name) VALUES (?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("is", $team_id, $player);
            $stmt->execute();
        }

        // Redirect to the team details page instead of showing an alert
        header("Location: team_details.php?team_id=" . $team_id);
        exit();
    } else {
        echo "<script>alert('Error creating team. Please try again.'); history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Team</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/main1.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-back {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #ccc;
            width: 100%;
            margin-bottom: 10px;
        }
        h2 {
            color: #343a40;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .player-list {
            max-height: 300px;
            overflow-y: auto;
            padding-right: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        <a class="btn-back" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i> Go Back
        </a>
        <h2>Create Your Team</h2>
        <form method="POST">
            <label for="team_name"><strong>Team Name:</strong></label>
            <input type="text" class="form-control" id="team_name" name="team_name" required>

            <label for="college_name"><strong>College Name:</strong></label>
            <input type="text" class="form-control" id="college_name" name="college_name" required>

            <h4 class="mt-4">Players List:</h4>
            <div class="player-list">
                <?php for ($i = 1; $i <= $player_count; $i++): ?>
                    <label for="player_<?= $i ?>"><strong>Player <?= $i ?> Name</strong></label>
                    <input type="text" class="form-control" id="player_<?= $i ?>" name="player_<?= $i ?>" required>
                <?php endfor; ?>
            </div>
            <button type="submit" class="btn-primary mt-3">Create Team</button>
        </form>
    </div>

</body>
</html>
