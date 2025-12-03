<?php
require_once('inc/init.inc.php');

$resultid = 4;
echo "Checking resultid: $resultid\n";

// Check if result exists
$rSet = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."results WHERE resultid=$resultid");
if ($rSet && !$rSet->EOF) {
    echo "Result found. UserID: " . $rSet->fields['userid'] . "\n";
    echo "Test ID: " . $rSet->fields['testid'] . "\n";
} else {
    echo "Result NOT found.\n";
}

// Check answers
$rSet2 = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."results_answers WHERE resultid=$resultid");
if ($rSet2) {
    $count = $rSet2->RecordCount();
    echo "Answers found: $count\n";
    while(!$rSet2->EOF) {
        echo "Answer ID: " . $rSet2->fields['result_answerid'] . " - Question ID: " . $rSet2->fields['questionid'] . "\n";
        $rSet2->MoveNext();
    }
} else {
    echo "Error checking answers.\n";
}
?>
