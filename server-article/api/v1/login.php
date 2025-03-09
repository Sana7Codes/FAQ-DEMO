<?php
// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle CORS Preflight Request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Include Database & User Model
require_once(__DIR__ . "/../../database/db.php");
require_once(__DIR__ . "/../../models/User.php");

// Ensure Only POST Requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit();
}

// Read JSON Request
$data = json_decode(file_get_contents("php://input"), true);

// Debugging - Show received data
error_log("🔍 Received Login Data: " . json_encode($data));

// Validate Input
if (!isset($data['username'], $data['password'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid login data"]);
    exit();
}

// Hash the input password inside SQL query
$stmt = $conn->prepare("SELECT id FROM users WHERE name = ? AND password = SHA2(?, 256)");
$stmt->bind_param("ss", $data['username'], $data['password']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Debugging - Check if user exists
if (!$result) {
    http_response_code(401);
    echo json_encode(["error" => "Invalid username or password"]);
    exit();
}

// Generate Authentication Token
$token = bin2hex(random_bytes(32));

echo json_encode([
    "message" => "Login successful",
    "token" => $token
]);

exit();
