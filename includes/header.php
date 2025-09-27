<?php
// Start session first
session_start();

// Include all required files
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/functions.php';

// Include Task class if we're in the tasks directory
if (isset($_SESSION['user_id']) && basename(dirname($_SERVER['PHP_SELF'])) == 'tasks') {
    require_once __DIR__ . '/Task.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a class="navbar-brand" href="index.php">
            <?php else: ?>
                <a class="navbar-brand" href="../index.php">
            <?php endif; ?>
                <i class="fas fa-tasks"></i> Task Manager
            </a>
            
            <?php if (isset($_SESSION['user_id'])): ?>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
                <a class="nav-link" href="../auth/logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
            <?php endif; ?>
        </div>
    </nav>
    
    <div class="container mt-4">