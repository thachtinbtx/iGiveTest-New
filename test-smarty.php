<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('inc/init.inc.php');

echo "DEBUG: Starting test-smarty.php<br>";
echo "DEBUG: Calling displayTemplate('_header')<br>";
displayTemplate('_header');
echo "DEBUG: Returned from displayTemplate<br>";
?>
