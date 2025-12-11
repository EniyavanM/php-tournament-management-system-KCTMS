<?php
// auth_check.php
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// No cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Require login
if (empty($_SESSION['cid'])) {
    header("Location: player_login.php", true, 303);
    exit();
}

// Idle timeout (15 minutes)
$timeout_duration = 15 * 60;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset(); session_destroy();
    header("Location: player_login.php?session=expired", true, 303);
    exit();
}

// Refresh timestamp
$_SESSION['last_activity'] = time();
