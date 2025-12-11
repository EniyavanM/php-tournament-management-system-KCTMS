<?php
require_once '../conn_db.php';

function markNotificationAsRead($notification_id) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE notification_id = ?");
    $stmt->bind_param("i", $notification_id);
    return $stmt->execute();
}

// For marking all as read
function markAllAsRead($c_id) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE c_id = ?");
    $stmt->bind_param("i", $c_id);
    return $stmt->execute();
}
?>