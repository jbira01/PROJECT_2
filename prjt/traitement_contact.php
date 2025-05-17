<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header("Location: contact.php?error=" . urlencode("Erreur de sécurité, veuillez réessayer."));
        exit;
    }

    // Récupération des données
    $firstName = trim($_POST['firstName']);
    $lastName  = trim($_POST['lastName']);
    $email     = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $phone     = trim($_POST['phone']);
    $subject   = trim($_POST['subject']);
    $message   = trim($_POST['message']);

    // Validation
    if (!$firstName || !$lastName || !$email || !$subject || !$message) {
        header("Location: contact.php?error=" . urlencode("Veuillez remplir tous les champs requis."));
        exit;
    }

    // Envoi du mail
    $to = "contact@carmotors.fr";
    $sujet = "Message de contact - $subject";
    $contenu = "Nom : $firstName $lastName\nEmail : $email\nTéléphone : $phone\nSujet : $subject\n\nMessage :\n$message";
    $headers = "From: $firstName $lastName <$email>\r\nReply-To: $email\r\nContent-Type: text/plain; charset=utf-8";

    if (mail($to, $sujet, $contenu, $headers)) {
        header("Location: contact.php?success=1");
        exit;
    } else {
        header("Location: contact.php?error=" . urlencode("Erreur lors de l'envoi du message."));
        exit;
    }

} else {
    header("Location: contact.php");
    exit;
}
