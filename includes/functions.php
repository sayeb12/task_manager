<?php
function sanitizeInput($data) {
    if (!isset($data)) return '';
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function redirect($url) {
    header("Location: " . $url);
    exit();
}

function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        redirect('../auth/login.php');
    }
}
?>