<?php
require_once('inc/init.inc.php');
$columns = $g_db->MetaColumns($srv_settings['table_prefix'].'results');
foreach($columns as $c) {
    echo $c->name . "\n";
}
?>
