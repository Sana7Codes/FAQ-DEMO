<?php
// Allow CORS for frontend requests
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

// Debugging Log
error_log(" Received Signup Data: " . json_encode($data));

// Validate Input
if (!isset($data['username'], $data['email'], $data['password'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid signup data"]);
    exit();
}

// Process Signup
$userModel = new User($conn);
$hashedPassword = hash("sha256", $data['password']);
$signupResponse = $userModel->registerUser($data['username'], $data['email'], $hashedPassword);

if (isset($signupResponse["error"])) {
    http_response_code(400);
}

// Ensure CORS Headers Are Sent in Response
header("Access-Control-Allow-Origin: *");

echo json_encode($signupResponse);
exit();
