<?php
// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle CORS Preflight Request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Include Database Connection & Model
require_once(__DIR__ . "/../../database/db.php");
require_once(__DIR__ . "/../../models/questions.php");

// Initialize FAQ Model
$faqModel = new Question($conn);

// Handle GET Request - Fetch FAQs
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $faqs = $faqModel->getAllFAQs();
    echo json_encode($faqs);
    exit();
}

// Handle POST Request - Add New FAQ
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get raw input
    $data = json_decode(file_get_contents("php://input"), true);

    // Validate Input
    if (!isset($data['question'], $data['answer'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data. Question & answer required."]);
        exit();
    }

    // Insert into database
    $result = $faqModel->addFAQ($data['question'], $data['answer']);

    if ($result) {
        echo json_encode(["message" => "FAQ added successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to add FAQ"]);
    }
    exit();
}

// If Not GET or POST, Return Error
http_response_code(405);
echo json_encode(["error" => "Method not allowed"]);
exit();
