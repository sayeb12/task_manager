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
    // Get and sanitize form data
    $title = trim($_POST['title']);
    $description = trim($_POST['description'] ?? '');
    $due_date = !empty($_POST['due_date']) ? $_POST['due_date'] : null;
    
    // Validate required fields
    if (empty($title)) {
        $_SESSION['message'] = "Task title is required.";
        header("Location: index.php");
        exit();
    }
    
    try {
        // Create and save task
        $task = new Task();
        $task->user_id = $_SESSION['user_id'];
        $task->title = $title;
        $task->description = $description;
        $task->due_date = $due_date;
        $task->status = 'pending';
        
        if ($task->create()) {
            $_SESSION['message'] = "Task added successfully!";
        } else {
            $_SESSION['message'] = "Failed to add task. Please try again.";
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
    }
    
    header("Location: index.php");
    exit();
} else {
    // If not POST request, redirect back
    header("Location: index.php");
    exit();
}
?>