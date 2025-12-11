<?php
// player_login.php
// session cookie params (set before session_start)
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => false,    // set true if using HTTPS
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

// If already logged in, redirect to index
if (!empty($_SESSION['cid'])) {
    header("Location: index.php", true, 303);
    exit();
}

// No-cache for login page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

include("conn_db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head.php'); ?>
    <meta charset="UTF-8">
    <title>Player Login | KCTMS</title>
    <link href="css/login.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">
<?php include('nav_header.php'); ?>

<div class="container form-signin mt-auto">
    <?php
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger mt-2">'.htmlspecialchars($_SESSION['error']).'</div>';
        unset($_SESSION['error']);
    }
    if (isset($_GET['session']) && $_GET['session'] === 'expired') {
        echo '<div class="alert alert-warning mt-2">Your session has expired. Please log in again.</div>';
    }
    if (isset($_GET['logout'])) {
        echo '<div class="alert alert-info mt-2">You have been logged out.</div>';
    }
    ?>
    <form method="POST" action="check_login.php" class="form-floating" autocomplete="off">
        <h2 class="mt-4 mb-3 fw-normal text-bold">Log In</h2>

        <div class="form-floating mb-2">
            <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Username"
                   required autocomplete="username">
            <label for="floatingInput">Username</label>
        </div>

        <div class="form-floating mb-2">
            <input type="password" name="pwd" class="form-control" id="floatingPassword" placeholder="Password"
                   required autocomplete="current-password">
            <label for="floatingPassword">Password</label>
        </div>

        <button class="w-100 btn btn-success mb-3" type="submit">Log In</button>
        <a href="player_regist.php" class="d-block">Create new account</a>
    </form>
</div>

<?php include('footer.php'); ?>

<script>
  // Remove POST entry from history and clear sensitive fields from bfcache
  if (window.history && window.history.replaceState) {
    window.history.replaceState(null, document.title, window.location.href);
  }
  window.addEventListener('pageshow', function (event) {
    if (event.persisted) {
      var pwd = document.querySelector('input[type="password"]');
      if (pwd) pwd.value = '';
      var user = document.querySelector('input[name="username"]');
      if (user) user.value = '';
    }
  });
</script>
</body>
</html>
