<?php
// Tournament_page.php
// Full, self-contained page - safe to copy/paste

// start session & includes
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'conn_db.php';    // expects $mysqli
@include_once 'nav_header.php'; // header (safe if missing)

// get s_id from query string
$s_id = isset($_GET['s_id']) ? intval($_GET['s_id']) : 0;
if ($s_id <= 0) {
    // invalid id, show friendly message and stop
    http_response_code(400);
    echo "<!doctype html><html><head><meta charset='utf-8'><title>Tournament</title></head><body>";
    echo "<h2>Invalid tournament id</h2>";
    echo "<p>Please go back and select a valid tournament.</p>";
    echo "</body></html>";
    exit;
}

// Fetch tournament details safely
$stmt = $mysqli->prepare("SELECT s_id, s_name, s_desc, s_pic FROM tournament WHERE s_id = ? LIMIT 1");
if ($stmt === false) {
    // SQL prepare failed
    error_log("Prepare failed: " . $mysqli->error);
    http_response_code(500);
    echo "Internal error.";
    exit;
}
$stmt->bind_param("i", $s_id);
$stmt->execute();
$result = $stmt->get_result();
$tournament = $result->fetch_assoc();
$stmt->close();

if (!$tournament) {
    http_response_code(404);
    echo "<!doctype html><html><head><meta charset='utf-8'><title>Not found</title></head><body>";
    echo "<h2>Tournament not found</h2>";
    echo "</body></html>";
    exit;
}

// Check if user already has team/registered (optional - adjust to your schema)
// Example: check teams table where c_id (player id) and s_id match
$canRegister = true;
$alreadyRegistered = false;
if (!empty($_SESSION['cid'])) {
    $c_id = intval($_SESSION['cid']);

    // change this query to match your real registration schema/table
    $q = "SELECT 1 FROM teams WHERE c_id = ? AND s_id = ? LIMIT 1";
    $st = $mysqli->prepare($q);
    if ($st) {
        $st->bind_param("ii", $c_id, $s_id);
        $st->execute();
        $st->store_result();
        $alreadyRegistered = ($st->num_rows > 0);
        $st->close();
    }
    // if already registered, user cannot re-register
    if ($alreadyRegistered) $canRegister = false;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo htmlspecialchars($tournament['s_name']); ?> — Tournament</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php
// nav_header included earlier; if not included, include here
if (!function_exists('htmlspecialchars')) { /* noop */ }
?>
<main class="container py-4">
  <div class="row">
    <div class="col-md-8">
      <h1><?php echo htmlspecialchars($tournament['s_name']); ?></h1>
      <p><?php echo nl2br(htmlspecialchars($tournament['s_desc'])); ?></p>

      <?php if (!empty($tournament['s_pic'])): ?>
        <img src="<?php echo 'img/'.htmlspecialchars($tournament['s_pic']); ?>" alt="" style="max-width:100%;height:auto;border-radius:6px;">
      <?php else: ?>
        <img src="img/default.png" alt="" style="max-width:100%;height:auto;border-radius:6px;">
      <?php endif; ?>

      <hr>

      <?php if (empty($_SESSION['cid'])): ?>
        <p class="alert alert-info">You must <a href="player_login.php">log in</a> to register for this tournament.</p>
      <?php else: ?>
        <?php if ($alreadyRegistered): ?>
          <p class="alert alert-success">You have already created/joined a team for this tournament.</p>
        <?php else: ?>
          <form method="POST" action="register_for_tournament.php">
            <input type="hidden" name="s_id" value="<?php echo (int)$s_id; ?>">
            <button class="btn btn-primary" type="submit">Register for this tournament</button>
          </form>
        <?php endif; ?>
      <?php endif; ?>

    </div>

    <aside class="col-md-4">
      <div class="card p-3">
        <h5>Details</h5>
        <ul>
          <li><strong>Sport ID:</strong> <?php echo (int)$tournament['s_id']; ?></li>
          <li><strong>Name:</strong> <?php echo htmlspecialchars($tournament['s_name']); ?></li>
        </ul>
      </div>
    </aside>
  </div>
</main>

<?php @include('footer.php'); ?>
</body>
</html>
