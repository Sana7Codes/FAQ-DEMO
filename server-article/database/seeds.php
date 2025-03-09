<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once(__DIR__ . "/../connection/connection.php");

// Check if connection exists
if (!isset($conn)) {
    die("❌ Database connection not established.");
}

// Insert thoughtful FAQs (No categories)
$faqs = [
    ['What is this study about?', 'This study analyzes how OpenAI’s O1 model reasons through complex problems compared to other test-time compute methods.'],
    ['What is a Large Language Model (LLM)?', 'A Large Language Model (LLM) is an AI trained on vast amounts of text data to generate human-like responses and solve problems.'],
    ['What are test-time compute methods?', 'These methods improve AI performance at inference time (when generating answers) instead of during training.'],
    ['How is OpenAI’s O1 model different from other AI models?', 'O1 is designed to reason more deeply before answering, making it better at complex problem-solving.'],
    ['What tasks does the study focus on?', 'The study evaluates commonsense reasoning, coding, and math problem-solving using different datasets.'],
    ['What is “Systematic Analysis” in AI reasoning?', 'It means carefully analyzing a problem before answering, ensuring structured and logical thinking.'],
    ['What is “Method Reuse”?', 'If AI sees a familiar problem, it reuses a known method instead of solving from scratch.'],
    ['What does “Divide and Conquer” mean?', 'AI breaks down complex problems into smaller subproblems and solves each separately.'],
    ['What is “Self-Refinement”?', 'AI checks its own work, fixing mistakes before presenting the final answer.'],
    ['What is “Context Identification”?', 'AI extracts key details from multiple sources before answering.'],
    ['What is “Emphasizing Constraints”?', 'AI follows strict rules such as formatting requirements, syntax rules, or math constraints.'],
    ['Why do some AI methods perform worse?', 'Some methods generate too many intermediate steps, making mistakes more likely. Others rely on weak reward models.'],
    ['Why is O1 better than the Best-of-N (BoN) method?', 'BoN generates multiple answers and picks one, while O1 reasons more deeply before answering.'],
    ['Does increasing AI parameters improve reasoning?', 'Not always. Smarter reasoning (like O1’s structured methods) is often better than just making models bigger.'],
    ['How can AI reasoning models be improved?', 'Better reward models, optimized step-wise reasoning, and more diverse reasoning techniques can enhance AI performance.'],
    ['How can this research help developers?', 'Developers can build AI that reasons better, optimizes test-time compute, and applies structured problem-solving.'],
    ['How can this research be applied to real-world AI tasks?', 'It can improve AI tutors, AI-assisted coding tools, and AI-driven scientific research.']
];

// Prepare statement
$stmt = $conn->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
if (!$stmt) {
    die("❌ Failed to prepare statement: " . $conn->error);
}

// Execute each insert
foreach ($faqs as $faq) {
    $stmt->bind_param("ss", $faq[0], $faq[1]);
    if (!$stmt->execute()) {
        die("❌ Failed to insert FAQ: " . $stmt->error);
    }
}

// Close connection
$stmt->close();
$conn->close();
