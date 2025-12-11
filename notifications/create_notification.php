<?php
require_once '../conn_db.php';

function createNotification($c_id, $schedule_id, $type, $title, $message) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO notifications 
                          (c_id, schedule_id, notification_type, title, message, sent_at) 
                          VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iisss", $c_id, $schedule_id, $type, $title, $message);
    return $stmt->execute();
}

// Example usage (uncomment when needed):
// createNotification(8, 3, 'match_reminder', 'Upcoming Match', 'Your match starts in 1 hour');
?>