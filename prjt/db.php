<?php
$host = 'localhost';
$dbname = 'carmotors'; // Replace with your actual DB name
$username = 'root';             // Default for XAMPP is 'root'
$password = '';                 // Default is empty for root

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
