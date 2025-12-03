<?php
// Load config to get credentials (or use hardcoded if config fails)
require_once('inc/config.inc.php');

$host = '127.0.0.1'; // Force IPv4
$user = $srv_settings['db_user'];
$pass = $srv_settings['db_password'];
$db   = $srv_settings['db_db'];

echo "Connecting to database $db at $host...<br>";

// Use mysqli as it is used in the app
$mysqli = new mysqli($host, $user, $pass, $db, 3306);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
echo "Connected!<br>";

$schema = "generator client {\n  provider = \"prisma-client-js\"\n}\n\n";
$schema .= "datasource db {\n  provider = \"mysql\"\n  url      = env(\"DATABASE_URL\")\n}\n\n";

function mapType($type) {
    if (strpos($type, 'int') !== false) return 'Int';
    if (strpos($type, 'char') !== false || strpos($type, 'text') !== false || strpos($type, 'enum') !== false) return 'String';
    if (strpos($type, 'datetime') !== false || strpos($type, 'timestamp') !== false) return 'DateTime';
    if (strpos($type, 'float') !== false || strpos($type, 'double') !== false || strpos($type, 'decimal') !== false) return 'Float';
    if (strpos($type, 'bool') !== false || strpos($type, 'tinyint(1)') !== false) return 'Boolean';
    return 'String';
}

$tables = $mysqli->query("SHOW TABLES");
if (!$tables) {
    die("Error fetching tables: " . $mysqli->error);
}

while ($row = $tables->fetch_array()) {
    $tableName = $row[0];
    $modelName = ucfirst($tableName);
    if (strpos($modelName, 'Srv_') === 0) {
        $modelName = substr($modelName, 4);
    }
    
    $schema .= "model $tableName {\n";
    
    $columns = $mysqli->query("DESCRIBE $tableName");
    $primaryKeys = [];
    
    while ($col = $columns->fetch_assoc()) {
        $field = $col['Field'];
        $type = $col['Type'];
        $null = $col['Null'] === 'YES';
        $key = $col['Key'];
        $extra = $col['Extra'];
        
        $prismaType = mapType($type);
        $attributes = "";
        
        if ($key === 'PRI') {
            $attributes .= " @id";
            if ($extra === 'auto_increment') {
                $attributes .= " @default(autoincrement())";
            }
            $primaryKeys[] = $field;
        }
        
        if ($key === 'UNI') {
            $attributes .= " @unique";
        }
        
        if ($null && $key !== 'PRI') {
            $prismaType .= "?";
        }
        
        $schema .= "  $field $prismaType$attributes\n";
    }
    
    $schema .= "  @@map(\"$tableName\")\n";
    $schema .= "}\n\n";
}

// Write to absolute path
$outputPath = 'C:/xampp/htdocs/next-app/prisma/schema.prisma';
if (file_put_contents($outputPath, $schema)) {
    echo "Schema generated successfully to $outputPath";
} else {
    echo "Failed to write schema to $outputPath";
}
?>
