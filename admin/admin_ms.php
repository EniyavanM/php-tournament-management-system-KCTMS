<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <?php 
        session_start(); 
        include("../conn_db.php"); 
        include('../head.php');
        if($_SESSION["utype"]!="ADMIN"){
            header("location: ../restricted.php");
            exit(1);
        }
    ?>
    <meta charset="UTF-8">
     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../img/ICON_F.png" rel="icon">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../img/Color Icon with background.png" rel="icon">
    <title>Match Scheduling | KCTMS</title>
</head>

<body class="d-flex flex-column h-100">

    <?php include('nav_header_admin.php')?>
    <form action="save_match.php" method="post">
    <label for="team1">Team 1:</label>
    <select name="team1" required>
        <?php
        $teams = mysqli_query($conn, "SELECT team_name FROM teams");
        while ($row = mysqli_fetch_assoc($teams)) {
            echo "<option value='{$row['team_name']}'>{$row['team_name']}</option>";
        }
        ?>
    </select>

    <label for="team2">Team 2:</label>
    <select name="team2" required>
        <?php
        $teams = mysqli_query($conn, "SELECT team_name FROM teams");
        while ($row = mysqli_fetch_assoc($teams)) {
            echo "<option value='{$row['team_name']}'>{$row['team_name']}</option>";
        }
        ?>
    </select>

    <label for="date">Match Date:</label>
    <input type="date" name="date" required>

    <label for="time">Match Time:</label>
    <input type="time" name="time" required>

    <label for="venue">Venue:</label>
    <input type="text" name="venue" required>

    <button type="submit">Schedule Match</button>
</form>

    <?php include('admin_footer.php')?>
</body>

</html>