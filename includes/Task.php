<?php
require_once __DIR__ . '/../config/database.php';

class Task {
    private $conn;
    private $table_name = "tasks";

    public $id;
    public $user_id;
    public $title;
    public $description;
    public $status;
    public $due_date;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . " 
                     (user_id, title, description, due_date, status) 
                     VALUES (:user_id, :title, :description, :due_date, :status)";
            
            $stmt = $this->conn->prepare($query);
            
            // Bind parameters
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":due_date", $this->due_date);
            $stmt->bindParam(":status", $this->status);
            
            // Execute query
            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Task creation failed: " . implode(", ", $stmt->errorInfo()));
                return false;
            }
        } catch (PDOException $exception) {
            error_log("Database error: " . $exception->getMessage());
            return false;
        }
    }

    public function readAll($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE user_id = :user_id 
                 ORDER BY 
                    CASE WHEN status = 'pending' THEN 1 ELSE 2 END,
                    due_date ASC, 
                    created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE id = :id AND user_id = :user_id 
                 LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->title = $row['title'];
            $this->description = $row['description'];
            $this->status = $row['status'];
            $this->due_date = $row['due_date'];
            return true;
        }
        return false;
    }

public function update() {
    try {
        $query = "UPDATE " . $this->table_name . " 
                 SET title = :title, description = :description, 
                     status = :status, due_date = :due_date 
                 WHERE id = :id AND user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":due_date", $this->due_date);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Task update failed: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    } catch (PDOException $exception) {
        error_log("Database error in update: " . $exception->getMessage());
        return false;
    }
}

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " 
                 WHERE id = :id AND user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);
        
        return $stmt->execute();
    }

    public function updateStatus() {
        $query = "UPDATE " . $this->table_name . " 
                 SET status = :status 
                 WHERE id = :id AND user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);
        
        return $stmt->execute();
    }
}
?>