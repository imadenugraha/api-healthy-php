<?php

header("Content-Type: application/json");

require "../vendor/autoload.php";

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable("..");
$dotenv->load();

$PG_HOST = $_ENV["POSTGRESS_HOST"];
$PG_PORT = $_ENV["POSTGRESS_PORT"];
$PG_USER = $_ENV["POSTGRESS_USER"];
$PG_PASS = $_ENV["POSTGRESS_PASS"];
$DB_NAME = $_ENV["POSTGRESS_DB_NAME"];

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

http_response_code($response["status"] === "healty" ? 200 : 500);
echo json_encode($response, JSON_PRETTY_PRINT);
