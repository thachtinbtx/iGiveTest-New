$file = 'inc/adodb/adodb.inc.php';
$search = 'class ADORecordSet';
$lines = file($file);
foreach ($lines as $line_num => $line) {
    if (stripos($line, $search) !== false) {
        echo "Line " . ($line_num + 1) . ": " . trim($line) . "\n";
    }
}

$search2 = 'function ADORecordSet';
foreach ($lines as $line_num => $line) {
    if (stripos($line, $search2) !== false) {
        echo "Line " . ($line_num + 1) . ": " . trim($line) . "\n";
    }
}
