<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <?php 
        session_start(); 
        include("../conn_db.php"); 
        include('../head.php');
        if($_SESSION["utype"]!="ADMIN"){
            header("location: ../restricted.php");
            exit(1);
        }
    ?>
    <meta charset="UTF-8">
     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../img/Color Icon with background.png" rel="icon">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/main1.css" rel="stylesheet">
    <title>Admin Dashboard | KCTMS</title>
</head>

<body class="d-flex flex-column">

    <?php include('nav_header_admin.php')?> 

    <div class="d-flex text-center text-black promo-banners-bg py-3">
        <div class="p-lg-2 mx-auto my-3">
            <h1 class="display-5 fw-normal">ADMIN DASHBOARD</h1>
            <p class="lead fw-normal">Inter-College Tournament Event</p>
        </div>
    </div>

    <div class="container p-5" id="admin-dashboard">
        <h2 class="border-bottom pb-2"><i class="bi bi-graph-up"></i> System Status</h2>

        <!-- ADMIN GRID DASHBOARD -->
        <div class="row row-cols-1 row-cols-lg-2 align-items-stretch g-4 py-3">

            <!-- GRID OF Player -->
            <div class="col">
                <a href="admin_ply_list.php" class="text-decoration-none text-dark">
                    <div class="card rounded-5 border-danger p-2">
                        <div class="card-body">
                            <h4 class="card-title"><i class="bi bi-person-fill"></i> Players</h4>
                            <p class="card-text my-2">
                                <span class="h5">
                                    <?php
                                    $cust_query = "SELECT COUNT(*) AS cnt FROM player WHERE c_type != 'ADM';";
                                    $cust_arr = $mysqli -> query($cust_query) -> fetch_array();
                                    echo $cust_arr["cnt"];
                                    ?>
                                </span> Players in the system
                            </p>
                            <div class="text-end">
                                <a href="admin_ply_list.php" class="btn btn-sm btn-outline-dark">Go to Player List</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- GRID OF Tournament -->
            <div class="col">
                <a href="admin_Tournament_list.php" class="text-decoration-none text-dark">
                    <div class="card rounded-5 border-success p-2">
                        <div class="card-body">
                            <h4 class="card-title"><i class="bi bi-trophy"></i> Tournament Creation</h4>
                            <p class="card-text my-2">
                                <span class="h5">
                                    <?php
                                    $tour_query = "SELECT COUNT(*) AS cnt FROM tournament;";
                                    $tour_arr = $mysqli->query($tour_query)->fetch_array();
                                    echo $tour_arr["cnt"];
                                    ?>
                                </span> Tournaments created
                            </p>
                            <div class="text-end">
                                <a href="admin_Tournament_list.php" class="btn btn-sm btn-outline-dark">Go to Tournament List</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- GRID OF Matches -->
            <div class="col">
                <a href="admin_matches_list.php" class="text-decoration-none text-dark">
                    <div class="card rounded-5 border-primary p-2">
                        <div class="card-body">
                            <h4 class="card-title"><i class="bi bi-card-list"></i> Matches</h4>
                            <p class="card-text my-2">
                                <span class="h5">
                                    <?php
                                    $match_query = "SELECT COUNT(*) AS cnt FROM matches;";
                                    $match_arr = $mysqli->query($match_query)->fetch_array();
                                    echo $match_arr["cnt"];
                                    ?>
                                </span> Matches in the system
                            </p>
                            <div class="text-end">
                                <a href="admin_matches_list.php" class="btn btn-sm btn-outline-dark">Go to Matches List</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- GRID OF Registration Verification -->
            <div class="col">
                <a href="admin_Reg_list.php" class="text-decoration-none text-dark">
                    <div class="card rounded-5 border-warning p-2">
                        <div class="card-body">
                            <h4 class="card-title"><i class="bi bi-card-list"></i> Registration Verification</h4>
                            <p class="card-text my-2">
                                <span class="h5">
                                    <?php
                                    $reg_query = "SELECT COUNT(*) AS cnt FROM mreg_status;";
                                    $reg_arr = $mysqli->query($reg_query)->fetch_array();
                                    echo $reg_arr["cnt"];
                                    ?>
                                </span> Registrations in the system
                            </p>
                            <div class="text-end">
                                <a href="admin_Reg_list.php" class="btn btn-sm btn-outline-dark">Go</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Match Scheduling -->
            <div class="col">
                <a href="match_scheduling.php" class="text-decoration-none text-dark">
                    <div class="card rounded-5 border-danger p-2">
                        <div class="card-body">
                            <h4 class="card-title"><i class="bi bi-calendar-event"></i> Match Scheduling</h4>
                            <p class="card-text my-2">Schedule upcoming matches in the system</p>
                            <div class="text-end">
                                <a href="match_scheduling.php" class="btn btn-sm btn-outline-dark">Go to Match Scheduling</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Scoreboard -->
            <div class="col">
                <a href="admin_Tournament_list.php" class="text-decoration-none text-dark">
                    <div class="card rounded-5 border-success p-2">
                        <div class="card-body">
                            <h4 class="card-title"><i class="bi bi-trophy"></i> ScoreBoard</h4>
                            <p class="card-text my-2">
                                <span class="h5">
                                    <?php
                                    $tournament_query = "SELECT COUNT(*) AS cnt FROM tournament;";
                                    $tournament_arr = $mysqli->query($tournament_query)->fetch_array();
                                    echo $tournament_arr["cnt"];
                                    ?>
                                </span> Tournaments created
                            </p>
                            <div class="text-end">
                                <a href="scoreboard.php" class="btn btn-sm btn-outline-dark">Go to ScoreBoard</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Scheduled Matches -->
            <div class="col">
                <a href="admin_scheduled_matches.php" class="text-decoration-none text-dark">
                    <div class="card rounded-5 border-info p-2">
                        <div class="card-body">
                            <h4 class="card-title"><i class="bi bi-clock-history"></i> Scheduled Matches</h4>
                            <p class="card-text my-2">View all upcoming matches categorized by sport.</p>
                            <div class="text-end">
                                <a href="admin_scheduled_matches.php" class="btn btn-sm btn-outline-dark">View Matches</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <?php include('admin_footer.php')?>
</body>
</html>
