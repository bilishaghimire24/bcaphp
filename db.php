<?php
// db.php
// Connects to the database. Every other page includes this at the top
// so they all share one connection.

$host = "localhost";
$dbname = "bilisha";
$username = "root";   // default XAMPP username
$password = "";       // default XAMPP password (blank)

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception($conn->connect_error);
    }
} catch (Exception $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// small helper: prints text safely so weird characters in a title
// (like < or ") can't break the page
function e($text) {
    return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
}

function safe($text) {
    return e($text);
}
?>
