<?php
// Database Connection - PDO with prepared statements (Secure)
// Achievers Academy CMS

$host = 'localhost';
$dbname = 'achievers_cms';
$username = 'root';   // Change in production
$password = '';       // Change in production

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Helper function for safe queries
function db_query($sql, $params = []) {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

// Get single row
function db_get_row($sql, $params = []) {
    return db_query($sql, $params)->fetch();
}

// Get all rows
function db_get_all($sql, $params = []) {
    return db_query($sql, $params)->fetchAll();
}

// Get setting value
function get_setting($key, $default = '') {
    global $pdo;
    $row = db_get_row("SELECT setting_value FROM settings WHERE setting_key = ?", [$key]);
    return $row ? $row['setting_value'] : $default;
}
?>