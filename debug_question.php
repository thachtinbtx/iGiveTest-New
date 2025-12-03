<?php
require_once('inc/init.inc.php');

$resultid = 12;
$answerid = 3;

// Get question ID from result
$rSet3 = $g_db->Execute("SELECT questionid FROM ".$srv_settings['table_prefix']."results_answers WHERE resultid=$resultid AND result_answerid=$answerid");
if ($rSet3 && !$rSet3->EOF) {
    $questionid = $rSet3->fields['questionid'];
    echo "QuestionID from Result: $questionid\n";
    
    // Check question details
    $rSet4 = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."questions WHERE questionid=$questionid");
    if ($rSet4 && !$rSet4->EOF) {
        echo "Question Text: " . $rSet4->fields['question_text'] . "\n";
        echo "Question Type: " . $rSet4->fields['question_type'] . "\n";
    }
    
    // Check answers table directly
    $rSet5 = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."answers WHERE questionid=$questionid");
    echo "Direct Answer Count: " . $rSet5->RecordCount() . "\n";
}
?>
