<?php

$databaseHost = getenv('DB_HOST');
$databaseName = getenv('DB_NAME');
$databaseUser = getenv('DB_USER');
$databasePassword = getenv('DB_PASSWORD');

if ($databaseHost === false || $databaseHost === '' ||
    $databaseName === false || $databaseName === '' ||
    $databaseUser === false || $databaseUser === '' ||
    $databasePassword === false) {
    throw new RuntimeException('Configure DB_HOST, DB_NAME, DB_USER and DB_PASSWORD environment variables.');
}

$pdo = new PDO(
    "mysql:host={$databaseHost};dbname={$databaseName}",
    $databaseUser,
    $databasePassword
);

?>
