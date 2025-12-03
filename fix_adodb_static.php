<?php
$file = 'inc/adodb/adodb.inc.php';
$content = file_get_contents($file);
if ($content === false) {
    die("Failed to read file.\n");
}

$count = 0;
// Use regex to match function definition with potential whitespace
$new_content = preg_replace('/function\s+outp\s*\(/i', 'static function outp(', $content, -1, $count);

if ($count > 0) {
    $result = file_put_contents($file, $new_content);
    if ($result !== false) {
        echo "Successfully replaced $count occurrence(s).\n";
    } else {
        echo "Failed to write file.\n";
    }
} else {
    echo "No occurrences found.\n";
}
?>
