<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/Task.php';

// Check authentication
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Please login first.";
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $task_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $title = isset($_POST['title']) ? sanitizeInput($_POST['title']) : '';
    $description = isset($_POST['description']) ? sanitizeInput($_POST['description']) : '';
    $due_date = isset($_POST['due_date']) && !empty($_POST['due_date']) ? $_POST['due_date'] : null;
    $status = isset($_POST['status']) ? sanitizeInput($_POST['status']) : 'pending';
    
    // Validate required fields
    if (empty($title) || $task_id == 0) {
        $_SESSION['message'] = "Task title and ID are required.";
        header("Location: index.php");
        exit();
    }
    
    try {
        // Update task
        $task = new Task();
        $task->id = $task_id;
        $task->user_id = $_SESSION['user_id'];
        $task->title = $title;
        $task->description = $description;
        $task->due_date = $due_date;
        $task->status = $status;
        
        if ($task->update()) {
            $_SESSION['message'] = "Task updated successfully!";
        } else {
            $_SESSION['message'] = "Failed to update task. Please try again.";
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
    }
    
    header("Location: index.php");
    exit();
} else {
    // If not POST request, redirect back
    $_SESSION['message'] = "Invalid request method.";
    header("Location: index.php");
    exit();
}
?>