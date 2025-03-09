<?php
class UserSkeleton
{
    protected $conn;
    protected $table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create User 
    public function createUser($name, $email, $password)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        return $stmt->execute();
    }

    // Get User by Email
    public function getUserByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Check if Email Exists 
    public function emailExists($email)
    {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}
