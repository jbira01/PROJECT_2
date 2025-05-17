<?php
session_start();
require_once 'config.php';

// Générer un token CSRF unique
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = $_GET['error'] ?? null;
$success = isset($_GET['success']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARMOTORS - Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/index.css" rel="stylesheet">
    <link href="assets/css/contact.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img src="img/image.png" alt="Logo" height="60"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav fs-5">
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="vehicules.php">Nos Véhicules</a></li>
                <li class="nav-item"><a class="nav-link" href="reservation.php">Réservation</a></li>
                <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : '' ?>" href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Déconnexion</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-success" href="login.php">Connexion</a>
                    </li>
                <?php endif; ?>

            </ul>

            
        </div>
    </div>
</nav>

<!-- HERO -->
<div class="contact-hero text-center">
    <div class="container">
        <h1 class="display-4 mb-3">Contactez-nous</h1>
        <p class="lead">Notre équipe est à votre disposition pour répondre à toutes vos questions</p>
    </div>
</div>

<!-- INFOS -->
<div class="container mb-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card contact-card text-center p-4">
                <div class="contact-icon"><i class="fas fa-map-marker-alt fa-2x text-dark"></i></div>
                <h3 class="h4 mb-3">Notre Adresse</h3>
                <p>123 Avenue Victor Hugo<br>75016 Paris, France</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card contact-card text-center p-4">
                <div class="contact-icon"><i class="fas fa-phone-alt fa-2x text-dark"></i></div>
                <h3 class="h4 mb-3">Téléphone</h3>
                <p>Service client: 01 23 45 67 89<br>Assistance: 01 23 45 67 90</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card contact-card text-center p-4">
                <div class="contact-icon"><i class="fas fa-envelope fa-2x text-dark"></i></div>
                <h3 class="h4 mb-3">Email</h3>
                <p>contact@carmotors.fr<br>support@carmotors.fr</p>
            </div>
        </div>
    </div>
</div>

<!-- MESSAGES -->
<div class="container mb-3">
    <?php if ($success): ?>
        <div class="alert alert-success">Merci pour votre message, nous vous répondrons bientôt !</div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
</div>

<!-- FORMULAIRE -->
<div class="container mb-5">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <h2 class="mb-4">Envoyez-nous un message</h2>
            <form method="post" action="traitement_contact.php">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Téléphone</label>
                    <input type="tel" class="form-control" id="phone" name="phone">
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Sujet</label>
                    <select class="form-select" id="subject" name="subject" required>
                        <option value="" selected disabled>Choisissez un sujet</option>
                        <option value="reservation">Réservation</option>
                        <option value="information">Demande d'information</option>
                        <option value="support">Support technique</option>
                        <option value="partnership">Partenariat</option>
                        <option value="other">Autre</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-dark">Envoyer le message</button>
            </form>
        </div>
        <div class="col-lg-6">
            <h2 class="mb-4">Notre Emplacement</h2>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="450" style="border:0;" allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="mt-4">
                <h3 class="h5 mb-3">Heures d'ouverture</h3>
                <ul class="list-unstyled">
                    <li><strong>Lundi - Vendredi:</strong> 9h00 - 19h00</li>
                    <li><strong>Samedi:</strong> 10h00 - 17h00</li>
                    <li><strong>Dimanche:</strong> Fermé</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    <p class="mb-0">&copy; 2024 CARMOTORS - Tous droits réservés.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
