<?php
// config.php

$host = 'localhost';           // Adresse du serveur MySQL
$dbname = 'carmotors';    // Nom de ta base de données
$user = 'root';     // Ton utilisateur MySQL
$password = ''; // Le mot de passe MySQL

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