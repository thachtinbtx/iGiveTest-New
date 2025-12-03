<?php
function search_files($dir, $search) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() == 'php') {
            $content = file_get_contents($file->getPathname());
            if (stripos($content, $search) !== false) {
                echo "Found in: " . $file->getPathname() . "\n";
                // Optional: print line number
                $lines = file($file->getPathname());
                foreach ($lines as $line_num => $line) {
                    if (stripos($line, $search) !== false) {
                        echo "  Line " . ($line_num + 1) . ": " . trim($line) . "\n";
                    }
                }
            }
        }
    }
}

search_files('inc/adodb', 'ADOConnection::outp');
?>
