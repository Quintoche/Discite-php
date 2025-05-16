<?php

$mysqli = new mysqli('localhost', 'root', '', 'test_db');

if ($mysqli->connect_error) {
    die('Database connection error: ' . $mysqli->connect_error);
}

$sqlFile = 'fakeItems_table.sql';

if (!file_exists($sqlFile)) {
    die("SQL file not found: $sqlFile");
}

$sql = file_get_contents($sqlFile);

$queries = array_filter(array_map('trim', explode(';', $sql)));

foreach ($queries as $query) {
    if (!empty($query)) {
        if (!$mysqli->query($query)) {
            echo "Query error: " . $mysqli->error . "\n";
        }
    }
}

echo "Import completed successfully.\n";

$mysqli->close();



require dirname(__DIR__, 2).'/discite-php/vendor/autoload.php';



?>