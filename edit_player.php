<?php
session_start();
include("conn_db.php");

// Check if user is logged in
if (!isset($_SESSION['cid'])) {
    echo "<script>alert('Unauthorized Access! Please log in.'); window.location='index.php';</script>";
    exit();
}

// Validate if player_id is provided
if (!isset($_GET['player_id']) || !is_numeric($_GET['player_id'])) {
    echo "<script>alert('Invalid Access! Missing Player ID.'); window.location='index.php';</script>";
    exit();
}

$player_id = intval($_GET['player_id']); // Convert to integer for security

// Fetch player details securely
$query = "SELECT * FROM team_players WHERE player_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $player_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Invalid Player! Player not found.'); window.location='index.php';</script>";
    exit();
}

$player = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $player_name = trim($_POST['player_name']);

    if (empty($player_name)) {
        echo "<script>alert('Player name cannot be empty!'); history.back();</script>";
        exit();
    }

    // Update player in database
    $update_query = "UPDATE team_players SET player_name = ? WHERE player_id = ?";
    $update_stmt = $mysqli->prepare($update_query);
    $update_stmt->bind_param("si", $player_name, $player_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Player updated successfully!'); window.location='team_details.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating player. Try again!'); history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Player</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/main1.css">
</head>
<body>

    <div class="container">
        <a class="btn-back" href="team_details.php">🔙 Go Back</a>
        <h2>Edit Player</h2>
        <form method="POST">
            <label for="player_name"><strong>Player Name:</strong></label>
            <input type="text" class="form-control" id="player_name" name="player_name" value="<?= htmlspecialchars($player['player_name']); ?>" required>

            <button type="submit" class="btn-primary mt-3">Update Player</button>
        </form>
    </div>

</body>
</html>
