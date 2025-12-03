<?php
require_once('inc/init.inc.php');

$resultid = 12;
$answerid = 3;
echo "Checking resultid: $resultid, answerid: $answerid\n";

// Check if result exists
$rSet = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."results WHERE resultid=$resultid");
if ($rSet && !$rSet->EOF) {
    echo "Result found. UserID: " . $rSet->fields['userid'] . "\n";
} else {
    echo "Result NOT found.\n";
}

// Check specific answer
$rSet3 = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."results_answers WHERE resultid=$resultid AND result_answerid=$answerid");
if ($rSet3 && !$rSet3->EOF) {
    echo "Answer found.\n";
    echo "QuestionID: " . $rSet3->fields['questionid'] . "\n";
    echo "Answer Text: " . $rSet3->fields['result_answer_text'] . "\n";
    echo "Points: " . $rSet3->fields['result_answer_points'] . "\n";
    
    $questionid = $rSet3->fields['questionid'];
    
    // Check question
    $rSet4 = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."questions WHERE questionid=$questionid");
    if ($rSet4 && !$rSet4->EOF) {
        echo "Question found: " . $rSet4->fields['question_text'] . "\n";
        echo "Question Type: " . $rSet4->fields['question_type'] . "\n";
    } else {
        echo "Question NOT found.\n";
    }
    
    // Check answers
    $rSet5 = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."answers WHERE questionid=$questionid");
    if ($rSet5) {
        echo "Answers found: " . $rSet5->RecordCount() . "\n";
        while (!$rSet5->EOF) {
            echo "ID: " . $rSet5->fields['answerid'] . " - " . $rSet5->fields['answer_text'] . "\n";
            $rSet5->MoveNext();
        }
    }
} else {
    echo "Answer NOT found in results_answers.\n";
}
?>
