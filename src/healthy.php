<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

header("Content-Type: application/json");

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$PG_HOST = $_ENV["POSTGRES_HOST"];
$PG_PORT = $_ENV["POSTGRES_PORT"];
$PG_USER = $_ENV["POSTGRES_USER"];
$PG_PASS = $_ENV["POSTGRES_PASS"];
$DB_NAME = $_ENV["POSTGRES_DB_NAME"];

$conn = pg_connect("host=$PG_HOST port=$PG_PORT dbname=$DB_NAME user=$PG_USER password=$PG_PASS");

$response = [
    "status" => "healthy",
    "php_version" => PHP_VERSION,
    "server_time" => date("Y-m-d H:i:s"),
    "database" => $conn ? "connected" : "failed"
];

if(!$conn) {
    $response["status"] = "unhealthy";
}

if($conn) {
    pg_close($conn);
}

http_response_code($response["status"] === "healthy" ? 200 : 500);
echo json_encode($response, JSON_PRETTY_PRINT);
