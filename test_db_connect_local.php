<?php
$mysqli = new mysqli("localhost", "root", "", "testbtx2025");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
echo "Connected successfully";
$mysqli->close();
?>
