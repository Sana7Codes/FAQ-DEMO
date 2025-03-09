<?php
//  Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

//  Handle Preflight
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Handle login/signup
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

//  Enable error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);

//  Include database & user model
require_once(__DIR__ . "/../../database/db.php");
require_once(__DIR__ . "/../../models/User.php");

//  Initialize User Model
$userModel = new User($conn);

//  Read JSON Data
$data = json_decode(file_get_contents("php://input"), true);

//  Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit;
}

//  No input received
if (!$data) {
    http_response_code(400);
    echo json_encode(["error" => "No input received"]);
    exit;
}

//  Handle Signup
if (isset($data['action']) && $data['action'] === "signup") {
    if (!isset($data['username'], $data['email'], $data['password'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid signup data"]);
        exit;
    }

    // Process signup
    $signupResponse = $userModel->registerUser($data['username'], $data['email'], $data['password']);

    if (isset($signupResponse["error"])) {
        http_response_code(400);
    }
    echo json_encode($signupResponse);
    exit;
}

//  Handle Login
if (isset($data['action']) && $data['action'] === "login") {
    if (!isset($data['username'], $data['password'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid login data"]);
        exit;
    }

    // Debugging
    error_log("🔍 Login Attempt: " . json_encode($data));

    // Query the user by username
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE name = ?");
    $stmt->bind_param("s", $data['name']);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    // Verify password
    if ($result && hash("sha256", $data['password']) === $result['password']) {
        $token = bin2hex(random_bytes(32));

        echo json_encode([
            "message" => "Login successful",
            "token" => $token
        ]);
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Invalid username or password"]);
    }

    $stmt->close();
    exit;
}

//  If no valid action provided
http_response_code(400);
echo json_encode(["error" => "Invalid request"]);
exit;
