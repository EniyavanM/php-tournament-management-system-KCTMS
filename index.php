<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    session_start(); 
    include("conn_db.php"); 
    include("head.php");

    // Initialize variables
    $registration_accepted = false;
    $has_team = false;
    $match_scheduled = false;

    // Check if the user is logged in
    if (isset($_SESSION['cid'])) {
        $c_id = $_SESSION['cid'];
        
        // Check if the player's registration is accepted
        $query = "SELECT orh_orderstatus FROM mreg_status WHERE c_id = ? AND orh_orderstatus = 'ACPT' LIMIT 1";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $c_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $registration_accepted = ($result->num_rows > 0);
        $stmt->close();

        // Check if the player has already created a team
        $query = "SELECT team_id, s_id FROM teams WHERE c_id = ? LIMIT 1";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $c_id);
        $stmt->execute();
        $stmt->bind_result($team_id, $s_id);
        $stmt->fetch();
        $has_team = !is_null($team_id);
        $stmt->close();

        // Check if a match has been scheduled for the player's sport
        if ($has_team) {
            $query = "SELECT sm.s_id FROM scheduled_matches sm WHERE sm.s_id = ? LIMIT 1";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("i", $s_id);
            $stmt->execute();
            $stmt->store_result();
            $match_scheduled = ($stmt->num_rows > 0);
            $stmt->close();
        }
    }
    ?>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/main1.css">
</head>
<body class="d-flex flex-column h-100">
    <?php include('nav_header.php'); ?>

    <!-- Welcome Message -->
    <div class="d-flex text-center text-white position-relative promo-banners-bg py-3">
        <div class="p-lg-2 mx-auto my-5">
            <h1 class="display-5 fw-normal">Welcome to KCT Inter College Tournament</h1>
            <p class="lead fw-normal">A place where talents meet opportunities</p>
        </div>
    </div>

    <div class="container p-5">
        <!-- Display appropriate messages -->
        <?php if ($registration_accepted && !$has_team): ?>
            <div class="alert alert-success text-center" role="alert">
                ✅ Your registration is accepted successfully. Now you can create a team.
            </div>
        <?php elseif ($has_team && !$match_scheduled): ?>
            <div class="alert alert-info text-center" role="alert">
                🎉 Thank you for creating a team! A match will be scheduled soon, and we will notify you.
            </div>
        <?php elseif ($match_scheduled): ?>
            <div class="alert alert-warning text-center" role="alert">
                ⚡ Your match has been scheduled! You can check the details in the status section.
            </div>
        <?php endif; ?>

        <!-- Display "Create a Team" button only if the player hasn't created a team -->
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="border-bottom pb-2"><i class="bi bi-bookmarks align-top"></i> Upcoming Tournaments</h2>

            <?php if ($registration_accepted && !$has_team): ?>
                <a href="create_team.php" class="btn btn-primary">Create a Team</a>
            <?php endif; ?>
        </div>

        <!-- Tournament List -->
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-3">
            <?php
            $query = "SELECT s_id, s_name, s_pic FROM tournament";
            $result = $mysqli->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_array()) {
            ?>
                <div class="col">
                    <a href="Tournament_page.php?s_id=<?php echo $row["s_id"] ?>" class="text-decoration-none text-dark">
                        <div class="card rounded-25">
                            <img src="<?php echo is_null($row["s_pic"]) ? 'img/default.png' : "img/{$row['s_pic']}" ?>" 
                                 style="width:100%; height:175px; object-fit:cover;" 
                                 class="card-img-top rounded-25 img-fluid" 
                                 alt="<?php echo $row["s_name"] ?>">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $row["s_name"] ?></h4>
                                <div class="text-end">
                                    <a href="Tournament_page.php?s_id=<?php echo $row["s_id"] ?>" 
                                       class="btn btn-sm btn-outline-dark">Register</a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php 
                }
            } else { ?>
                <div class="row row-cols-1 w-100">
                    <div class="col mt-4 pt-3 px-3 bg-danger text-white rounded text-center">
                        <i class="bi bi-x-circle-fill"></i>
                        <p class="ms-2 mt-2">No tournaments currently available, please stay tuned.</p>
                    </div>
                </div>
            <?php 
            }
            $result->free_result();
            ?>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
