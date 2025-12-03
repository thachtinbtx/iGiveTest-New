<?php
require_once('inc/init.inc.php');
$tables = $g_db->MetaTables('TABLES');
echo "Tables:\n";
print_r($tables);

echo "\nColumns in answers table:\n";
$columns = $g_db->MetaColumns($srv_settings['table_prefix'].'answers');
print_r($columns);
?>
