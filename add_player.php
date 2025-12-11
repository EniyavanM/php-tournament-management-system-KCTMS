<?php
// add_player.php
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
    header('Location: player_regist.php', true, 303);
    exit();
}

$username   = trim($_POST['username'] ?? '');
$pwd        = $_POST['pwd'] ?? '';
$cfpwd      = $_POST['cfpwd'] ?? '';
$firstname  = trim($_POST['firstname'] ?? '');
$lastname   = trim($_POST['lastname'] ?? '');
$email      = trim($_POST['email'] ?? '');
$gender     = $_POST['gender'] ?? '-';
$type       = $_POST['type'] ?? 'PLY';

if ($pwd !== $cfpwd) {
    $_SESSION['error'] = "Passwords do not match.";
    header("Location: player_regist.php", true, 303);
    exit();
}

if (strlen($pwd) < 8) {
    $_SESSION['error'] = "Password must be at least 8 characters.";
    header("Location: player_regist.php", true, 303);
    exit();
}

// check username
$stmt = $mysqli->prepare("SELECT c_id FROM player WHERE c_username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close();
    $_SESSION['error'] = "Username already exists.";
    header("Location: player_regist.php", true, 303);
    exit();
}
$stmt->close();

$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("INSERT INTO player (c_username, c_pwd, c_firstname, c_lastname, c_email, c_gender, c_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $username, $hashedPwd, $firstname, $lastname, $email, $gender, $type);

if ($stmt->execute()) {
    $stmt->close();
    $_SESSION['success'] = "Account created. Please log in.";
    header("Location: player_login.php", true, 303);
    exit();
} else {
    $stmt->close();
    $_SESSION['error'] = "Something went wrong. Try again.";
    header("Location: player_regist.php", true, 303);
    exit();
}
