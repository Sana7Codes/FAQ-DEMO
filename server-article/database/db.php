<?php
require_once(__DIR__ . "/../connection/connection.php");

if (!isset($conn) || $conn->connect_error) {
    die("❌ Database connection not established.");
}
