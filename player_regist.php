<?php
// player_regist.php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

// no-cache
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
    <title>Player Registration | KCTMS</title>
    <link href="css/login.css" rel="stylesheet">
</head>
<body class="d-flex flex-column">
<?php include('nav_header.php'); ?>

<div class="container form-signin mt-auto">
    <?php
    if (isset($_SESSION['error'])) { echo '<div class="alert alert-danger mt-2">'.htmlspecialchars($_SESSION['error']).'</div>'; unset($_SESSION['error']); }
    if (isset($_SESSION['success'])) { echo '<div class="alert alert-success mt-2">'.htmlspecialchars($_SESSION['success']).'</div>'; unset($_SESSION['success']); }
    ?>
    <form method="POST" action="add_player.php" class="form-floating" autocomplete="off">
        <h2 class="mt-4 mb-3 fw-normal">Sign Up</h2>

        <div class="form-floating mb-2">
            <input type="text" name="username" class="form-control" id="username" placeholder="Username" minlength="5" maxlength="45" required autocomplete="off">
            <label for="username">Username</label>
        </div>

        <div class="form-floating mb-2">
            <input type="password" name="pwd" class="form-control" id="pwd" placeholder="Password" minlength="8" maxlength="45" required autocomplete="new-password">
            <label for="pwd">Password</label>
        </div>

        <div class="form-floating mb-2">
            <input type="password" name="cfpwd" class="form-control" id="cfpwd" placeholder="Confirm Password" minlength="8" maxlength="45" required autocomplete="new-password">
            <label for="cfpwd">Confirm Password</label>
        </div>

        <div class="form-floating mb-2">
            <input type="text" name="firstname" class="form-control" id="firstname" placeholder="First Name" required>
            <label for="firstname">First Name</label>
        </div>

        <div class="form-floating mb-2">
            <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Last Name" required>
            <label for="lastname">Last Name</label>
        </div>

        <div class="form-floating mb-2">
            <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" required>
            <label for="email">E-mail</label>
        </div>

        <div class="mb-2 form-check">
            <input type="checkbox" class="form-check-input" id="tandc" name="tandc" required>
            <label class="form-check-label small" for="tandc">I agree to terms & privacy</label>
        </div>

        <button class="w-100 btn btn-success mb-3" type="submit">Sign Up</button>
    </form>
</div>

<?php include('footer.php'); ?>

<script>
  if (window.history && window.history.replaceState) { window.history.replaceState(null, document.title, window.location.href); }
  window.addEventListener('pageshow', function (event) {
    if (event.persisted) {
      document.querySelectorAll('input[type="password"]').forEach(i=>i.value='');
    }
  });
</script>
</body>
</html>
