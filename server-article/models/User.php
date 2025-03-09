<?php
require_once(__DIR__ . "/UserSkeleton.php");

class User extends UserSkeleton
{
    public function registerUser($username, $email, $password)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            return ["message" => "User registered successfully"];
        } else {
            return ["error" => "Failed to register user"];
        }
    }

    public function loginUser($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT id, password FROM users WHERE name = ?");
        if (!$stmt) {
            return ["error" => "Failed to prepare statement: " . $this->conn->error];
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        // Verify password
        if ($result && hash("sha256", $password) === $result['password']) {
            $token = bin2hex(random_bytes(32));
            return ["message" => "Login successful", "token" => $token];
        } else {
            return ["error" => "Invalid username or password"];
        }
    }
}
