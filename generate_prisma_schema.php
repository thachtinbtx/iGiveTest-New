<?php
echo "Starting schema generation...\n";

// Hardcoded credentials to avoid including config file
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'testbtx2025';

echo "Connecting to database...\n";
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
echo "Connected!\n";

$schema = "generator client {\n  provider = \"prisma-client-js\"\n}\n\n";
$schema .= "datasource db {\n  provider = \"mysql\"\n  url      = env(\"DATABASE_URL\")\n}\n\n";

// Map MySQL types to Prisma types
function mapType($type) {
    if (strpos($type, 'int') !== false) return 'Int';
    if (strpos($type, 'char') !== false || strpos($type, 'text') !== false || strpos($type, 'enum') !== false) return 'String';
    if (strpos($type, 'datetime') !== false || strpos($type, 'timestamp') !== false) return 'DateTime';
    if (strpos($type, 'float') !== false || strpos($type, 'double') !== false || strpos($type, 'decimal') !== false) return 'Float';
    if (strpos($type, 'bool') !== false || strpos($type, 'tinyint(1)') !== false) return 'Boolean';
    return 'String'; // Default
}

echo "Fetching tables...\n";
$tables = $mysqli->query("SHOW TABLES");
if (!$tables) {
    die("Error fetching tables: " . $mysqli->error);
}

while ($row = $tables->fetch_array()) {
    $tableName = $row[0];
    echo "Processing table: $tableName\n";
    
    $modelName = ucfirst($tableName);
    if (strpos($modelName, 'Srv_') === 0) {
        $modelName = substr($modelName, 4);
    }
    
    $schema .= "model $tableName {\n";
    
    $columns = $mysqli->query("DESCRIBE $tableName");
    if (!$columns) {
        echo "Error describing table $tableName: " . $mysqli->error . "\n";
        continue;
    }
    
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

file_put_contents('next-app/prisma/schema.prisma', $schema);
echo "Schema generated successfully to next-app/prisma/schema.prisma!\n";
?>
