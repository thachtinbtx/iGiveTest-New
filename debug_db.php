<?php
// Define constants to mimic init.inc.php environment
// define('IGT_DB_DEBUG_MODE', true); // Already in const.inc.php
// define('DB_DRIVER_MYSQL', 'mysql'); // Already in const.inc.php
// define('DB_DRIVER_MYSQLI', 'mysqli'); // Already in const.inc.php
// define('ADODB_FETCH_BOTH', 3); // Already in adodb.inc.php

// Load config
require_once('inc/config.inc.php');
require_once('inc/const.inc.php'); // Need this for $g_db_connectionsettings

// Mock $lngstr for connect.inc.php
$lngstr['sql_charset'] = "'utf8'";

// Load ADODB
require_once('inc/adodb/adodb.inc.php');

echo "Testing Database Connection...\n";
echo "Driver: " . $srv_settings['db_driver'] . "\n";
echo "Host: " . $srv_settings['db_host'] . "\n";
echo "User: " . $srv_settings['db_user'] . "\n";
echo "DB: " . $srv_settings['db_db'] . "\n";

// Replicate connect.inc.php logic
$i_dns = sprintf($g_db_connectionsettings[$srv_settings['db_driver']]['dns'], $srv_settings['db_driver'], $srv_settings['db_host'], $srv_settings['db_user'], $srv_settings['db_password'], $srv_settings['db_db']);
echo "DSN: " . $i_dns . "\n";

$g_db = ADONewConnection($i_dns);
if (!$g_db) {
    die("ADONewConnection failed.\n");
}

$g_db->debug = true;
$connected = $g_db->Connect($srv_settings['db_host'], $srv_settings['db_user'], $srv_settings['db_password'], $srv_settings['db_db']);

if ($connected) {
    echo "Connection Successful!\n";
    
    // Test a simple query
    echo "Running test query...\n";
    $rs = $g_db->Execute("SELECT 1");
    if ($rs) {
        echo "Query Successful. Result: " . print_r($rs->fields, true) . "\n";
    } else {
        echo "Query Failed: " . $g_db->ErrorMsg() . "\n";
    }

    // Test signinUser query logic
    $username = 'admin';
    $sql = "SELECT * FROM ".$srv_settings['table_prefix']."users WHERE user_name='admin'";
    echo "Testing user query: $sql\n";
    $rs_user = $g_db->Execute($sql);
    if ($rs_user) {
        echo "User Query Successful. Rows: " . $rs_user->RecordCount() . "\n";
        if (!$rs_user->EOF) {
            print_r($rs_user->fields);
        }
    } else {
        echo "User Query Failed: " . $g_db->ErrorMsg() . "\n";
    }

} else {
    echo "Connection Failed: " . $g_db->ErrorMsg() . "\n";
}
?>
