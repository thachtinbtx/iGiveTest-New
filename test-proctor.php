<?php
require_once('inc/init.inc.php');

// Ensure user is logged in and taking a test
if(!isset($G_SESSION['userid']) || !isset($G_SESSION['resultid'])) {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid session'));
    exit;
}

$action = readPostVar('action');

if($action == 'log_away') {
    $time_away = (int)readPostVar('time_away');
    
    if($time_away > 0) {
        // Update the result_time_away in the database
        // We add the new time to the existing time
        $sql = "UPDATE ".$srv_settings['table_prefix']."results SET result_time_away = result_time_away + $time_away WHERE resultid = " . $G_SESSION['resultid'];
        $g_db->Execute($sql);
        
        echo json_encode(array('status' => 'success', 'message' => 'Time logged'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid time'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid action'));
}
?>
