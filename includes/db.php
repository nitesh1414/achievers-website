<?php
// Database Connection - PDO with prepared statements (Secure)
// Achievers Academy CMS

$host = "localhost";
$dbname = "achievers_cms";
$username = "root"; // Change in production
$password = ""; // Change in production

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function db_query($sql, $params = [])
{
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

function db_get_row($sql, $params = [])
{
    return db_query($sql, $params)->fetch();
}

function db_get_all($sql, $params = [])
{
    return db_query($sql, $params)->fetchAll();
}

/**
 * Get a CMS setting. A per-request cache keeps templates fast when shared
 * settings are used in the header, footer and page content.
 */
function get_setting($key, $default = "")
{
    static $settings = null;
    if ($settings === null) {
        $settings = [];
        try {
            foreach (
                db_get_all("SELECT setting_key, setting_value FROM settings")
                as $row
            ) {
                $settings[$row["setting_key"]] = $row["setting_value"];
            }
        } catch (Throwable $e) {
            return $default;
        }
    }
    return array_key_exists($key, $settings) && $settings[$key] !== ""
        ? $settings[$key]
        : $default;
}
?>
