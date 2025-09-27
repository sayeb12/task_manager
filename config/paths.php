<?php
function base_url($path = '') {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $project_path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    
    return $protocol . "://" . $host . $project_path . '/' . ltrim($path, '/');
}

function require_once_safe($path) {
    $full_path = __DIR__ . '/../' . ltrim($path, '/');
    if (file_exists($full_path)) {
        require_once $full_path;
    } else {
        throw new Exception("File not found: " . $full_path);
    }
}
?>