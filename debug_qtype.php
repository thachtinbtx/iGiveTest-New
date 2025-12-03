<?php
require_once('inc/init.inc.php');

$questionid = 64;
$rSet = $g_db->Execute("SELECT * FROM ".$srv_settings['table_prefix']."questions WHERE questionid=$questionid");

if ($rSet && !$rSet->EOF) {
    echo "Question Type: " . $rSet->fields['question_type'] . "\n";
    echo "Question Text: " . $rSet->fields['question_text'] . "\n";
} else {
    echo "Question not found.\n";
}
flush();
?>
