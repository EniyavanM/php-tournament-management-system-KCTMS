<?php
include("../conn_db.php"); // Ensure database connection is included
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoreboard | KCTMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Include Admin Navigation Header -->
<?php include("nav_header_admin.php"); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Live Scoreboard Management</h2>

    <!-- Select Match to Update Scores -->
    <form method="POST" action="update_score.php" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label for="schedule_id" class="form-label"><strong>Select Match:</strong></label>
            <select class="form-select" name="schedule_id" id="schedule_id" required>
                <option value="" selected disabled>Choose a Match</option>
                <?php
                $matches = $mysqli->query("SELECT sm.schedule_id, t1.team_name AS team1, t2.team_name AS team2, sm.match_date 
                                           FROM scheduled_matches sm
                                           JOIN teams t1 ON sm.team1_id = t1.team_id
                                           JOIN teams t2 ON sm.team2_id = t2.team_id
                                           WHERE sm.status = 'Scheduled'");

                while ($row = $matches->fetch_assoc()) {
                    echo "<option value='{$row['schedule_id']}' data-team1='{$row['team1']}' data-team2='{$row['team2']}'>
                            {$row['team1']} vs {$row['team2']} - {$row['match_date']}
                          </option>";
                }
                ?>
            </select>
        </div>

        <!-- Score Input Fields -->
        <div class="row">
            <div class="col-md-6">
                <label for="team1_score" class="form-label"><strong>Team 1 Score:</strong></label>
                <input type="number" class="form-control score-input" name="team1_score" id="team1_score" min="0" required>
            </div>
            <div class="col-md-6">
                <label for="team2_score" class="form-label"><strong>Team 2 Score:</strong></label>
                <input type="number" class="form-control score-input" name="team2_score" id="team2_score" min="0" required>
            </div>
        </div>

        <!-- Auto-Select Winner Based on Score -->
        <div class="mb-3 mt-3">
            <label for="winner_team" class="form-label"><strong>Winner:</strong></label>
            <select class="form-select" name="winner_team" id="winner_team" required>
                <option value="" selected disabled>Choose Winner</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Update Score & Complete Match</button>
    </form>

    <!-- Scoreboard Table -->
    <h3 class="text-center mt-5">Scoreboard</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Schedule ID</th>
                    <th>Sport</th>
                    <th>Team 1</th>
                    <th>Team 2</th>
                    <th>Score (T1 - T2)</th>
                    <th>Winner</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $scoreboard = $mysqli->query("SELECT sm.schedule_id, s.f_name, t1.team_name AS team1, t2.team_name AS team2, 
                                                     sm.team1_score, sm.team2_score, w.team_name AS winner, sm.status 
                                              FROM scheduled_matches sm
                                              JOIN teams t1 ON sm.team1_id = t1.team_id
                                              JOIN teams t2 ON sm.team2_id = t2.team_id
                                              JOIN matches s ON sm.s_id = s.s_id
                                              LEFT JOIN teams w ON sm.winner_team_id = w.team_id
                                              ORDER BY sm.match_date, sm.match_time");

                while ($row = $scoreboard->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['schedule_id']}</td>
                            <td>{$row['f_name']}</td>
                            <td>{$row['team1']}</td>
                            <td>{$row['team2']}</td>
                            <td>{$row['team1_score']} - {$row['team2_score']}</td>
                            <td>". ($row['winner'] ? $row['winner'] : "N/A") ."</td>
                            <td>{$row['status']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const matchSelect = document.getElementById("schedule_id");
    const team1ScoreInput = document.getElementById("team1_score");
    const team2ScoreInput = document.getElementById("team2_score");
    const winnerSelect = document.getElementById("winner_team");

    matchSelect.addEventListener("change", function() {
        const selectedOption = matchSelect.options[matchSelect.selectedIndex];
        const team1 = selectedOption.getAttribute("data-team1");
        const team2 = selectedOption.getAttribute("data-team2");

        if (team1 && team2) {
            winnerSelect.innerHTML = `
                <option value="" selected disabled>Choose Winner</option>
                <option value="${team1}">${team1}</option>
                <option value="${team2}">${team2}</option>
            `;
        } else {
            winnerSelect.innerHTML = `<option value="" selected disabled>No teams found</option>`;
        }
    });

    // Auto-Select Winner
    function updateWinnerSelection() {
        const team1Score = parseInt(team1ScoreInput.value) || 0;
        const team2Score = parseInt(team2ScoreInput.value) || 0;
        const selectedOption = matchSelect.options[matchSelect.selectedIndex];
        const team1 = selectedOption.getAttribute("data-team1");
        const team2 = selectedOption.getAttribute("data-team2");

        if (team1 && team2) {
            if (team1Score > team2Score) {
                winnerSelect.value = team1;
            } else if (team2Score > team1Score) {
                winnerSelect.value = team2;
            } else {
                winnerSelect.value = "";
            }
        }
    }

    team1ScoreInput.addEventListener("input", updateWinnerSelection);
    team2ScoreInput.addEventListener("input", updateWinnerSelection);
});
</script>

</body>
</html>
