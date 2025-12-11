<!--    NAV HEADER FOR ADMIN SIDE PAGE   -->

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
                <li class="nav-item">
                    <a class="nav-link px-2 text-dark" href="admin_home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a href="admin_ply_list.php" class="nav-link px-2 text-dark"> Players</a>
                </li>
                <li class="nav-item">
                    <a href="admin_Tournament_list.php" class="nav-link px-2 text-dark">Tournament</a>
                </li>
                <li class="nav-item">
                    <a href="admin_scheduled_matches.php" class="nav-link px-2 text-dark">Matches</a>
                </li>
                <li class="nav-item">
                    <a href="admin_ply_list.php" class="nav-link px-2 text-dark"></a>
                </li>
            </ul>
            <div class="d-flex">
                <?php if(!isset($_SESSION['aid'])){ ?>
                <a class="btn btn-outline-secondary me-2" href="../cust_regist.php">Sign Up</a>
                <a class="btn btn-success" href="../player_login.php">Log In</a>
                <?php }else{ ?>
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a href="admin_ply_detail.php?c_id=<?php echo $_SESSION["aid"]?>" class="nav-link px-2 text-dark">
                            Welcome, <?=$_SESSION['firstname']?>
                            <i class="bi bi-person-circle"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="mx-2 mt-1 mt-md-0 btn btn-outline-danger" href="../logout.php">Log Out</a>
                    </li>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</header>