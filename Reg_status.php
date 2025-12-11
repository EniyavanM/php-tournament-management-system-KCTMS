<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();
    if (!isset($_SESSION["cid"])) {
        header("location: restricted.php");
        exit(1);
    }
    include("conn_db.php");
    include('head.php');
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/ply.css" rel="stylesheet">
    <title>REGISTRATION STATUS | KCTMS</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header.php') ?>

    <div class="container px-5 py-4" id="tournament-body">
        <a class="nav nav-item text-decoration-none text-muted mb-3" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i> Go back
        </a>
        <div class="mb-3 text-wrap" id="tournament-header">
            <h2 class="display-6 strong fw-normal">Registration History</h2>
        </div>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active px-4" id="ongoing-tab" data-bs-toggle="tab" data-bs-target="#nav-ongoing"
                    type="button" role="tab" aria-controls="nav-ongoing" aria-selected="true">Status</button>
                <button class="nav-link px-4" id="scheduled-tab" data-bs-toggle="tab" data-bs-target="#nav-scheduled"
                    type="button" role="tab" aria-controls="nav-scheduled" aria-selected="false">Scheduled Matches</button>
                <button class="nav-link px-4" id="completed-tab" data-bs-toggle="tab" data-bs-target="#nav-completed"
                    type="button" role="tab" aria-controls="nav-completed" aria-selected="false">Completed Matches</button>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            <!-- Status Tab -->
            <div class="tab-pane fade show active p-3" id="nav-ongoing" role="tabpanel" aria-labelledby="ongoing-tab">
                <?php
                $ongoing_query = "SELECT ms.*, t.s_name AS tournament_name, m.f_name AS sport_name 
                                  FROM mreg_status ms 
                                  JOIN mreg_detail md ON ms.orh_id = md.orh_id 
                                  JOIN matches m ON md.f_id = m.f_id 
                                  JOIN tournament t ON ms.s_id = t.s_id 
                                  WHERE ms.c_id = {$_SESSION['cid']} AND ms.orh_orderstatus <> 'FNSH';";
                $ongoing_result = $mysqli->query($ongoing_query);
                if ($ongoing_result->num_rows > 0) {
                ?>
                    <div class="row row-cols-1 row-cols-md-3">
                        <?php while ($og_row = $ongoing_result->fetch_array()) { ?>
                            <div class="col">
                                <div class="card mb-3">
                                    <div class="card-header bg-secondary text-dark">
                                        <small><?php echo $og_row["orh_orderstatus"] == "ACPT" ? "Accepted your Registration" : "Verifying your Registration"; ?></small>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-text row row-cols-1 small">
                                            <div class="col"><strong>Tournament:</strong> <?php echo $og_row["tournament_name"]; ?></div>
                                            <div class="col"><strong>Sport:</strong> <?php echo $og_row["sport_name"]; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

            <!-- Scheduled Matches Tab -->
            <div class="tab-pane fade p-3" id="nav-scheduled" role="tabpanel" aria-labelledby="scheduled-tab">
                <?php
                $scheduled_query = "SELECT sm.match_date, sm.match_time, sm.venue, t.s_name AS tournament_name, m.f_name AS sport_name 
                                    FROM scheduled_matches sm 
                                    JOIN tournament t ON sm.s_id = t.s_id 
                                    JOIN matches m ON sm.s_id = m.s_id 
                                    WHERE sm.status = 'Scheduled';";
                $scheduled_result = $mysqli->query($scheduled_query);
                if ($scheduled_result->num_rows > 0) {
                ?>
                    <div class="row row-cols-1 row-cols-md-3">
                        <?php while ($match = $scheduled_result->fetch_array()) { ?>
                            <div class="col">
                                <div class="card mb-3">
                                    <div class="card-header bg-primary text-white">
                                        <small>Scheduled Match</small>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Tournament:</strong> <?php echo $match["tournament_name"]; ?></p>
                                        <p><strong>Sport:</strong> <?php echo $match["sport_name"]; ?></p>
                                        <p><strong>Date:</strong> <?php echo $match["match_date"]; ?></p>
                                        <p><strong>Time:</strong> <?php echo $match["match_time"]; ?></p>
                                        <p><strong>Venue:</strong> <?php echo $match["venue"]; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

            <!-- Completed Matches Tab -->
            <div class="tab-pane fade p-3" id="nav-completed" role="tabpanel" aria-labelledby="completed-tab">
                <?php
                $completed_query = "SELECT sm.match_date, sm.match_time, sm.venue, 
                                           t.s_name AS tournament_name, m.f_name AS sport_name, 
                                           sm.team1_score, sm.team2_score, tm.team_name AS winner 
                                    FROM scheduled_matches sm 
                                    JOIN tournament t ON sm.s_id = t.s_id 
                                    JOIN matches m ON sm.s_id = m.s_id 
                                    LEFT JOIN teams tm ON sm.winner_team_id = tm.team_id 
                                    WHERE sm.status = 'Completed' 
                                      AND sm.s_id IN (SELECT ms.s_id FROM mreg_status ms WHERE ms.c_id = {$_SESSION['cid']});";
                $completed_result = $mysqli->query($completed_query);
                if ($completed_result->num_rows > 0) {
                ?>
                    <div class="row row-cols-1 row-cols-md-3">
                        <?php while ($match = $completed_result->fetch_array()) { ?>
                            <div class="col">
                                <div class="card mb-3">
                                    <div class="card-header bg-success text-white">
                                        <small>Completed Match</small>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Tournament:</strong> <?php echo $match["tournament_name"]; ?></p>
                                        <p><strong>Sport:</strong> <?php echo $match["sport_name"]; ?></p>
                                        <p><strong>Team 1 Score:</strong> <?php echo $match["team1_score"]; ?></p>
                                        <p><strong>Team 2 Score:</strong> <?php echo $match["team2_score"]; ?></p>
                                        <p><strong>Winner:</strong> <?php echo $match["winner"] ?? "TBD"; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
