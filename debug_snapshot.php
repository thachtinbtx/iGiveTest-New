<?php
require_once('inc/init.inc.php');

$resultid = 12;
$answerid = 3;

// Check results_answers for snapshot data
$rSet = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."results_answers WHERE resultid=$resultid AND result_answerid=$answerid");

if ($rSet && !$rSet->EOF) {
    echo "Snapshot Data:\n";
    echo "Question ID: " . $rSet->fields['questionid'] . "\n";
    echo "Test Question ID: " . $rSet->fields['test_questionid'] . "\n";
    echo "Result Answer Text: " . $rSet->fields['result_answer_text'] . "\n";
    // Check if question text is stored in results_answers (unlikely based on schema, but checking)
    // Based on previous file view, it joins with questions table, which is why it fails.
}
?>
