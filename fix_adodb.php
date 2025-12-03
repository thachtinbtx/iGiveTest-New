<?php
$file = 'inc/adodb/adodb.inc.php';
$content = file_get_contents($file);
if ($content === false) {
    die("Failed to read file.\n");
}

$count = 0;
$new_content = str_replace('ADOConnection::outp', '$this->outp', $content, $count);

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
