<?php
// Mock session before init
$_SESSION = array();

require_once('inc/init.inc.php');

// Mock logged in user with admin access
$G_SESSION['userid'] = 1;
$G_SESSION['access_users'] = 4; // Full access
$G_SESSION['config_itemsperpage'] = 10;

// Mock Smarty session for template
$_SESSION['MAIN'] = $G_SESSION;

// Define required variables that might be expected
$g_vars['page']['title'] = 'Test User Management';

echo "<h1>Testing Manage Users Rendering</h1>";

// Include the page logic directly
include('inc/pages/manageusers-1.inc.php');

?>
