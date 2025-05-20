<?php


$host = 'localhost';         
$dbname = 'carmotors';
$user = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4", 
        $user, 
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Active les exceptions PDO
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Mode de récupération par défaut
            PDO::ATTR_EMULATE_PREPARES => false, // Désactive l’émulation des requêtes préparées
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

define('SITE_NAME', 'CARMOTORS');