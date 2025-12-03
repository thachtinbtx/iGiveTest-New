<?php
require_once('inc/init.inc.php');

$resultid = 5;
echo "Checking resultid: $resultid\n";

// Check total answers in table
$rSetTotal = $g_db->Execute("SELECT count(*) as cnt FROM ".$srv_settings['table_prefix']."results_answers");
if ($rSetTotal && !$rSetTotal->EOF) {
    echo "Total answers in DB: " . $rSetTotal->fields['cnt'] . "\n";
}

// Check if any answers exist for other results
$rSetAny = $g_db->Execute("SELECT resultid, count(*) as cnt FROM ".$srv_settings['table_prefix']."results_answers GROUP BY resultid LIMIT 5");
if ($rSetAny) {
    while (!$rSetAny->EOF) {
        echo "ResultID: " . $rSetAny->fields['resultid'] . " has " . $rSetAny->fields['cnt'] . " answers.\n";
        $rSetAny->MoveNext();
    }
}
?>
