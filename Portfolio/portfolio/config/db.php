<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'portfolio_db';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // In a real environment, you might want to log this or show a user-friendly message
    // die("Connection failed: " . $e->getMessage());
}
?>
