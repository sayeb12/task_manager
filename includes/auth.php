<?php

require_once __DIR__ . '/../config/database.php';

class Auth {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

   public function register($username, $email, $password) {
    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        return "All fields are required.";
    }

    // Check if user exists
    $query = "SELECT id FROM users WHERE username = :username OR email = :email";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return "Username or email already exists.";
    }

    // Hash password and create user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hashed_password);

    if ($stmt->execute()) {
        return true;
    }
    return "Registration failed. Please try again.";
}


    public function login($username, $password) {
        if (empty($username) || empty($password)) {
            return "Username and password are required.";
        }

        $query = "SELECT id, username, password FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                return true;
            }
        }
        return "Invalid username or password.";
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        session_destroy();
        header("Location: login.php");
        exit();
    }

    public function getCurrentUserId() {
        return $_SESSION['user_id'] ?? null;
    }
}

$auth = new Auth();
?>