<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('inc/init.inc.php');

echo "<h1>Smarty Delimiter Test</h1>";

// Test 1: String rendering
echo "<h2>Test 1: String Rendering</h2>";
$g_smarty->assign('foo', 'bar');
$template_string = 'Value of foo is: <{$foo}>';
// Create a temporary template file for testing string
$temp_tpl = 'temp_test.tpl.html';
file_put_contents($g_smarty->template_dir . $temp_tpl, $template_string);

echo "Template content: " . htmlspecialchars($template_string) . "<br>";
echo "Rendered output: ";
$g_smarty->display($temp_tpl);
echo "<br>";

// Test 2: Header rendering
echo "<h2>Test 2: Header Rendering</h2>";
echo "Rendered output (first 500 chars): <br>";
ob_start();
$g_smarty->display('_header.tpl.html');
$output = ob_get_clean();
echo htmlspecialchars(substr($output, 0, 500));


// Test 3: lngstr debugging
echo "<h2>Test 3: lngstr Debugging</h2>";
global $lngstr;
echo "lngstr type: " . gettype($lngstr) . "<br>";
echo "lngstr count: " . count($lngstr) . "<br>";
echo "text_direction value: " . (isset($lngstr['text_direction']) ? $lngstr['text_direction'] : 'NOT SET') . "<br>";

$g_smarty->assign('lngstr', $lngstr); // Re-assign to be sure
$template_string = 'Direction: <{$lngstr.text_direction}>';
$temp_tpl = 'temp_test_lng.tpl.html';
file_put_contents($g_smarty->template_dir . $temp_tpl, $template_string);
echo "Template content: " . htmlspecialchars($template_string) . "<br>";
echo "Rendered output: ";
$g_smarty->display($temp_tpl);
echo "<br>";
unlink($g_smarty->template_dir . $temp_tpl);
?>
