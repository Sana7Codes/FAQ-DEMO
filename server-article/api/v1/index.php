<?php
//  Include Config File (CORS, Debugging, DB Connection)
require_once("config.php");

//  Get the request URI
$requestUri = $_SERVER['REQUEST_URI'];
$basePath = "/FAQ-DEMO/server-article/api/v1/";

//  Routing Logic
if (strpos($requestUri, $basePath . "auth") !== false) {
    require_once("auth.php");
    exit;
} elseif (strpos($requestUri, $basePath . "faq") !== false) {
    require_once("faq.php");
    exit;
}

//  Invalid Endpoint
http_response_code(404);
echo json_encode(["error" => "Invalid API endpoint"]);
exit;
