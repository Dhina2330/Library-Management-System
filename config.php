<?php
/**
 * Database connection settings.
 * Update these values to match your local MySQL setup.
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');        // XAMPP/WAMP default is an empty password
define('DB_NAME', 'library_db');

// Create connection using mysqli
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Ensure consistent character encoding
$conn->set_charset('utf8mb4');
?>
