<?php
session_start();
include("../conn_db.php");

if ($_SESSION["utype"] != "ADMIN") {
    header("location: ../restricted.php");
    exit();
}

// Fetch available sports from the teams table
$sports_query = "SELECT DISTINCT s_id, f_name FROM matches";
$sports_result = $mysqli->query($sports_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Scheduling | Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/main1.css">
    <style>
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .sport-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: left;
            transition: 0.3s;
            cursor: pointer;
        }
        .sport-card:hover {
            background: #e9ecef;
        }
    </style>
</head>
<body>

    <!-- Manually Added NAV HEADER -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_home.php">
                <img src="../img/kct.jpg" width="50" alt="KCTMS Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin_home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_ply_list.php">Players</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_Tournament_list.php">Tournament</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_matches_list.php">Matches</a></li>
                    <?php if(isset($_SESSION['aid'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link text-primary" href="admin_ply_detail.php?c_id=<?=$_SESSION['aid']?>">Welcome, <?=$_SESSION['firstname']?></a>
                        </li>
                        <li class="nav-item"><a class="nav-link text-danger" href="../logout.php">Log Out</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Select a Sport to Schedule Matches</h2>
        <div class="sport-list">
            <?php while ($sport = $sports_result->fetch_assoc()) { ?>
                <div class="sport-card" onclick="redirectToSchedule(<?= $sport['s_id'] ?>)">
                    <h4><?= $sport['f_name'] ?></h4>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
        function redirectToSchedule(sportId) {
            window.location.href = "schedule_match.php?sport_id=" + sportId;
        }
    </script>
</body>
</html>
