<?php
require_once('inc/init.inc.php');
$sql = "ALTER TABLE ".$srv_settings['table_prefix']."results ADD COLUMN result_time_away INT DEFAULT 0";
$g_db->Execute($sql);
echo "Column added.";
?>
