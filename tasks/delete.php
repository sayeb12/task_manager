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

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $task_id = intval($_GET['id']);
    
    if ($task_id == 0) {
        $_SESSION['message'] = "Invalid task ID.";
        header("Location: index.php");
        exit();
    }
    
    try {
        $task = new Task();
        $task->id = $task_id;
        $task->user_id = $_SESSION['user_id'];
        
        if ($task->delete()) {
            $_SESSION['message'] = "Task deleted successfully!";
        } else {
            $_SESSION['message'] = "Failed to delete task.";
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
    }
}

header("Location: index.php");
exit();
?>