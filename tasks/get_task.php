<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/Task.php';

// Check authentication
if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    echo "Unauthorized";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $task_id = intval($_GET['id']);
    
    $task = new Task();
    $task->id = $task_id;
    $task->user_id = $_SESSION['user_id'];
    
    if ($task->readOne()) {
        // Return task data as JSON
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'due_date' => $task->due_date,
                'status' => $task->status
            ]
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Task not found']);
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    echo "Invalid request";
}
?>