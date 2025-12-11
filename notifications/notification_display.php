<?php
require_once '../conn_db.php';
require_once 'get_notifications.php';

function displayNotificationBell($c_id) {
    $unread = getUnreadNotifications($c_id);
    $count = $unread->num_rows;
    
    echo '<div class="notification-bell">
            <i class="fas fa-bell"></i>
            <span class="badge">'.$count.'</span>
          </div>';
}

function displayNotificationDropdown($c_id) {
    $notifications = getAllNotifications($c_id, 5);
    
    echo '<div class="notification-dropdown">
            <h4>Notifications</h4>';
    
    if ($notifications->num_rows > 0) {
        while ($row = $notifications->fetch_assoc()) {
            $class = $row['is_read'] ? '' : 'unread';
            echo '<div class="notification-item '.$class.'" data-id="'.$row['notification_id'].'">
                    <strong>'.$row['title'].'</strong>
                    <p>'.$row['message'].'</p>
                    <small>'.time_elapsed_string($row['created_at']).'</small>
                  </div>';
        }
    } else {
        echo '<p>No notifications</p>';
    }
    
    echo '<a href="notifications/view_all.php" class="see-all">See All</a>
          </div>';
}

// Helper function
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>