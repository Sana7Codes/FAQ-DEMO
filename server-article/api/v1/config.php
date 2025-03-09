<?php
//  Enable error reporting 
error_reporting(E_ALL);
ini_set('display_errors', 1);

//  CORS Headers 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

//  Handle preflight 
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

//  Include database connection
require_once(__DIR__ . "/../../database/db.php");

//  Debugging log 
error_log("✅ API Debug: config.php loaded");
