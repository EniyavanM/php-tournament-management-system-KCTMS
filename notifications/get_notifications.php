<?php
require_once '../conn_db.php';

function getUnreadNotifications($c_id, $limit = 5) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM notifications 
                          WHERE c_id = ? AND is_read = 0 
                          ORDER BY created_at DESC 
                          LIMIT ?");
    $stmt->bind_param("ii", $c_id, $limit);
    $stmt->execute();
    return $stmt->get_result();
}

function getAllNotifications($c_id, $limit = 10) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM notifications 
                          WHERE c_id = ? 
                          ORDER BY created_at DESC 
                          LIMIT ?");
    $stmt->bind_param("ii", $c_id, $limit);
    $stmt->execute();
    return $stmt->get_result();
}
?>