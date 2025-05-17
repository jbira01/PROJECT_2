<?php
require_once 'config.php'; // contient la connexion PDO $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et nettoyer les données
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validation basique
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        die("Tous les champs obligatoires doivent être remplis.");
    }
    if ($password !== $confirmPassword) {
        die("Les mots de passe ne correspondent pas.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email invalide.");
    }

    // Vérifier que l’email n’est pas déjà pris
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        die("Cet email est déjà utilisé.");
    }

    // Hasher le mot de passe
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Générer un token vide ou null pour remember_token
    $rememberToken = null;

    // Insérer dans la base
    $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, phone, password, remember_token, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $result = $stmt->execute([$firstName, $lastName, $email, $phone, $passwordHash, $rememberToken]);

    if ($result) {
        // Redirection ou message de succès
        header('Location: login.php?signup=success');
        exit();
    } else {
        die("Erreur lors de l'inscription.");
    }
} else {
    die("Méthode HTTP non autorisée.");
}
