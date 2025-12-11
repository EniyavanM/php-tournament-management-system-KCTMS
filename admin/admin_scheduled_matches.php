<?php
session_start();
include("../conn_db.php");
include('../head.php');

if ($_SESSION["utype"] != "ADMIN") {
    header("location: ../restricted.php");
    exit(1);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduled Matches | KCTMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="../css/main.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .match-container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
        }
        .match-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            transition: 0.3s;
        }
        .match-card:hover {
            transform: scale(1.02);
        }
        .match-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .match-time {
            font-size: 14px;
            color: gray;
        }
        .match-venue {
            font-size: 14px;
            font-weight: bold;
            color: #007bff;
        }
        .winner {
            font-size: 16px;
            font-weight: bold;
            color: green;
        }
        .sport-header {
            font-size: 20px;
            font-weight: bold;
            margin: 20px 0 10px;
            color: #343a40;
            border-bottom: 3px solid #007bff;
            display: inline-block;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>

<?php include('nav_header_admin.php'); ?>

<div class="match-container">
    <h2 class="text-center mb-4"><i class="fa-solid fa-calendar-days"></i> Scheduled Matches</h2>

    <?php
    $sport_query = "SELECT DISTINCT t.s_id, t.s_name 
                    FROM tournament t
                    JOIN scheduled_matches s ON t.s_id = s.s_id
                    WHERE s.match_date IS NOT NULL
                    ORDER BY s.match_date ASC";
    $sport_result = $mysqli->query($sport_query);

    if ($sport_result->num_rows > 0) {
        while ($sport_row = $sport_result->fetch_assoc()) {
            $sport_id = $sport_row['s_id'];
            $sport_name = $sport_row['s_name'];

            echo "<h3 class='sport-header'>$sport_name</h3>";

            $match_query = "SELECT s.match_date, s.match_time, s.venue, 
                                   t1.team_name AS team1, t2.team_name AS team2, w.team_name AS winner
                            FROM scheduled_matches s
                            JOIN teams t1 ON s.team1_id = t1.team_id
                            JOIN teams t2 ON s.team2_id = t2.team_id
                            LEFT JOIN teams w ON s.winner_team_id = w.team_id
                            WHERE s.s_id = ?
                            ORDER BY s.match_date, s.match_time";

            $stmt = $mysqli->prepare($match_query);
            $stmt->bind_param("i", $sport_id);
            $stmt->execute();
            $match_result = $stmt->get_result();

            if ($match_result->num_rows > 0) {
                while ($match_row = $match_result->fetch_assoc()) {
                    echo "<div class='match-card'>";
                    echo "<div class='match-info'>";
                    echo "<div>";
                    echo "<strong>{$match_row['team1']} vs {$match_row['team2']}</strong>";
                    echo "<div class='match-time'><i class='fa-regular fa-clock'></i> {$match_row['match_date']} | {$match_row['match_time']}</div>";
                    echo "<div class='match-venue'><i class='fa-solid fa-location-dot'></i> {$match_row['venue']}</div>";
                    if ($match_row['winner']) {
                        echo "<div class='winner'><i class='fa-solid fa-trophy'></i> Winner: {$match_row['winner']}</div>";
                    }
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-muted'>No scheduled matches for this sport.</p>";
            }

            $stmt->close();
        }
    } else {
        echo "<p class='text-muted text-center'>No scheduled matches available.</p>";
    }
    ?>
</div>

<?php include('admin_footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
