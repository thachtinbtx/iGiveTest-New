<?php
require_once('inc/config.inc.php');

echo "Connecting to DB: " . $srv_settings['db_db'] . " on " . $srv_settings['db_host'] . "\n";

$mysqli = new mysqli($srv_settings['db_host'], $srv_settings['db_user'], $srv_settings['db_password'], $srv_settings['db_db']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}
echo "Connected successfully (Native MySQLi).\n";

echo "Tables:\n";
$result = $mysqli->query("SHOW TABLES");
if ($result) {
    echo "Rows: " . $result->num_rows . "\n";
    while ($row = $result->fetch_row()) {
        echo " - " . $row[0] . "\n";
    }
    $result->free();
} else {
    echo "SHOW TABLES failed: " . $mysqli->error . "\n";
}

echo "\nUsers:\n";
$result = $mysqli->query("SELECT * FROM " . $srv_settings['table_prefix'] . "users");
if ($result) {
    echo "Count: " . $result->num_rows . "\n";
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
    $result->free();
} else {
    echo "SELECT failed: " . $mysqli->error . "\n";
}

$mysqli->close();
?>
