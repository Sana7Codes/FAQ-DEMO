<?php
require_once(__DIR__ . "/QuestionSkeleton.php");

class Question extends QuestionSkeleton
{
    public function __construct($db)
    {
        parent::__construct($db);
    }

    // Get All FAQs
    public function getAllFAQs()
    {
        return $this->getAll();
    }

    // Add New FAQ 
    public function addFAQ($question, $answer)
    {
        return $this->create($question, $answer);
    }
}
