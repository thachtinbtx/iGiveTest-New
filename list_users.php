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

// List tables
echo "Tables:\n";
$tables = $g_db->MetaTables();
print_r($tables);

// List users
echo "\nUsers:\n";
$sql = "SELECT * FROM ".$srv_settings['table_prefix']."users";
$rs = $g_db->Execute($sql);
if ($rs) {
    echo "Count: " . $rs->RecordCount() . "\n";
    while (!$rs->EOF) {
        print_r($rs->fields);
        $rs->MoveNext();
    }
} else {
    echo "Query failed: " . $g_db->ErrorMsg() . "\n";
}
?>
