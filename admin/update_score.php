<?php
include("../conn_db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $schedule_id = $_POST['schedule_id'];
    $team1_score = $_POST['team1_score'];
    $team2_score = $_POST['team2_score'];
    $winner_team_name = $_POST['winner_team'];  // Winner received as name

    // Validate input
    if (empty($schedule_id) || $team1_score === "" || $team2_score === "" || empty($winner_team_name)) {
        die("Error: Missing required fields.");
    }

    // Fetch the team ID from the team name
    $team_query = "SELECT team_id FROM teams WHERE team_name = ?";
    if ($stmt = $mysqli->prepare($team_query)) {
        $stmt->bind_param("s", $winner_team_name);
        $stmt->execute();
        $stmt->bind_result($winner_team_id);
        
        if ($stmt->fetch()) {
            $stmt->close();
        } else {
            die("Error: Winner team not found in the database.");
        }
    } else {
        die("Error preparing team query: " . $mysqli->error);
    }

    // Update the match result
    $update_query = "UPDATE scheduled_matches 
                     SET team1_score = ?, team2_score = ?, winner_team_id = ?, status = 'Completed'
                     WHERE schedule_id = ?";

    if ($stmt = $mysqli->prepare($update_query)) {
        $stmt->bind_param("iiii", $team1_score, $team2_score, $winner_team_id, $schedule_id);

        if ($stmt->execute()) {
            $stmt->close();
            
            // Redirect back to the matches page with success message
            header("Location: admin_scheduled_matches.php?success=1");
            exit;
        } else {
            die("Error updating match: " . $stmt->error);
        }
    } else {
        die("Error preparing update query: " . $mysqli->error);
    }
}
?>
