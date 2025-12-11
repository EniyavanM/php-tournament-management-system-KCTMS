<?php
// nav_header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// By default we show the user status. Individual pages can set $hide_header_user = true;
// before including this file to suppress showing the logged-in name.
$hide = !empty($hide_header_user);

$display_name = '';
if (!empty($_SESSION['firstname'])) {
    $display_name = $_SESSION['firstname'];
} elseif (!empty($_SESSION['username'])) {
    $display_name = $_SESSION['username'];
}
?>
<header class="navbar navbar-light bg-light shadow-sm mb-3">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="img/kct.jpg" width="60" alt="KCTMS Logo" class="me-2">
            <span class="fw-bold">KCTMS</span>
        </a>

        <div class="d-flex align-items-center">
            <?php if (!$hide && !empty($_SESSION['cid'])): ?>
                <span class="me-3">Welcome, <?php echo htmlspecialchars($display_name); ?></span>
                <a class="btn btn-outline-danger btn-sm" href="logout.php">Log Out</a>
            <?php else: ?>
                <a class="btn btn-success btn-sm me-2" href="player_login.php">Login</a>
                <a class="btn btn-outline-primary btn-sm" href="player_regist.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>
