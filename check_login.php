<?php
// check_login.php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();
require 'conn_db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: player_login.php', true, 303);
    exit();
}

$username = trim($_POST['username'] ?? '');
$pwd      = $_POST['pwd'] ?? '';

if ($username === '' || $pwd === '') {
    $_SESSION['error'] = "Please enter both username and password.";
    header("Location: player_login.php", true, 303);
    exit();
}

$stmt = $mysqli->prepare("SELECT c_id, c_username, c_pwd, c_type, c_firstname FROM player WHERE c_username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $dbPwd = $row['c_pwd'];

    // hashed password
    if (password_verify($pwd, $dbPwd)) {
        session_regenerate_id(true);

        $_SESSION['cid']           = $row['c_id'];
        $_SESSION['user_id']       = $row['c_id'];
        $_SESSION['username']      = $row['c_username'];
        $_SESSION['c_username']    = $row['c_username'];
        $_SESSION['firstname']     = $row['c_firstname'];
        $_SESSION['type']          = $row['c_type'];
        $_SESSION['last_activity'] = time();

        header("Location: index.php", true, 303);
        exit();
    }

    // plain text (old) password — upgrade automatically
    if ($pwd === $dbPwd) {
        $newHash = password_hash($pwd, PASSWORD_DEFAULT);
        $update = $mysqli->prepare("UPDATE player SET c_pwd = ? WHERE c_id = ?");
        $update->bind_param("si", $newHash, $row['c_id']);
        $update->execute();

        session_regenerate_id(true);

        $_SESSION['cid']           = $row['c_id'];
        $_SESSION['user_id']       = $row['c_id'];
        $_SESSION['username']      = $row['c_username'];
        $_SESSION['c_username']    = $row['c_username'];
        $_SESSION['firstname']     = $row['c_firstname'];
        $_SESSION['type']          = $row['c_type'];
        $_SESSION['last_activity'] = time();

        header("Location: index.php", true, 303);
        exit();
    }
}

$_SESSION['error'] = "Invalid username or password.";
header("Location: player_login.php", true, 303);
exit();
