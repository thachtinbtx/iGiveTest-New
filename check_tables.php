<?php
// Define constants
define('IGT_DB_DEBUG_MODE', true);
define('DB_DRIVER_MYSQL', 'mysql');
define('DB_DRIVER_MYSQLI', 'mysqli');
define('ADODB_FETCH_BOTH', 3);

// Load config and ADODB
require_once('inc/config.inc.php');
require_once('inc/const.inc.php');
$lngstr['sql_charset'] = "'utf8'";
require_once('inc/adodb/adodb.inc.php');

// Connect
$i_dns = sprintf($g_db_connectionsettings[$srv_settings['db_driver']]['dns'], $srv_settings['db_driver'], $srv_settings['db_host'], $srv_settings['db_user'], $srv_settings['db_password'], $srv_settings['db_db']);
$g_db = ADONewConnection($i_dns);
$g_db->Connect($srv_settings['db_host'], $srv_settings['db_user'], $srv_settings['db_password'], $srv_settings['db_db']);

echo "Direct SHOW TABLES:\n";
$rs = $g_db->Execute("SHOW TABLES");
if ($rs) {
    while (!$rs->EOF) {
        print_r($rs->fields);
        $rs->MoveNext();
    }
} else {
    echo "SHOW TABLES failed: " . $g_db->ErrorMsg() . "\n";
}

echo "\nDESCRIBE users:\n";
$rs = $g_db->Execute("DESCRIBE ".$srv_settings['table_prefix']."users");
if ($rs) {
    while (!$rs->EOF) {
        print_r($rs->fields);
        $rs->MoveNext();
    }
} else {
    echo "DESCRIBE users failed: " . $g_db->ErrorMsg() . "\n";
}
?>
