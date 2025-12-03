<?php
require_once('inc/init.inc.php');

$resultid = 5;
echo "Checking resultid: $resultid\n";

// Check if result exists
$rSet = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."results WHERE resultid=$resultid");
if ($rSet && !$rSet->EOF) {
    echo "Result found. UserID: " . $rSet->fields['userid'] . "\n";
} else {
    echo "Result NOT found.\n";
}

// Check answers
$rSet2 = $g_db->Execute("SELECT count(*) as cnt FROM ".$srv_settings['table_prefix']."results_answers WHERE resultid=$resultid");
if ($rSet2 && !$rSet2->EOF) {
    echo "Answers count: " . $rSet2->fields['cnt'] . "\n";
} else {
    echo "No answers found.\n";
}

// Check current user
echo "Current UserID: " . $G_SESSION['userid'] . "\n";
echo "Access Level: " . $G_SESSION['access_reportsmanager'] . "\n";
?>
