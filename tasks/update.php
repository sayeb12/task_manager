<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/Task.php';

// Check authentication
if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.1 401 Unauthorized');
    echo 'Unauthorized';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = new Task();
    $task->id = $_POST['id'];
    $task->user_id = $_SESSION['user_id'];
    $task->status = $_POST['status'];

    if ($task->updateStatus()) {
        echo 'success';
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo 'Error updating task';
    }
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Method not allowed';
}
?>