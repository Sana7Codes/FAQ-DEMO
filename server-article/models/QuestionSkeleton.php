<?php
class QuestionSkeleton
{
    protected $conn;
    protected $table = "faqs";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //  Create FAQ 
    public function create($question, $answer)
    {
        $stmt = $this->conn->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
        $stmt->bind_param("ss", $question, $answer);
        return $stmt->execute();
    }

    //  Read FAQs 
    public function getAll()
    {
        $result = $this->conn->query("SELECT id, question, answer FROM faqs");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT id, question, answer FROM faqs WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    //  Update FAQ 
    public function update($id, $question, $answer)
    {
        $stmt = $this->conn->prepare("UPDATE faqs SET question = ?, answer = ? WHERE id = ?");
        $stmt->bind_param("ssi", $question, $answer, $id);
        return $stmt->execute();
    }

    //  Delete FAQ
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM faqs WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
