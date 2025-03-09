<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "faq_community";

// Establish Connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check Connection
if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}
