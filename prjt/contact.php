<?php

require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARMOTORS - Contact</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/index.css" rel="stylesheet">
    <link href="assets/css/contact.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="img/image.png" alt="Logo" height="60">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav fs-5">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vehicules.php">Nos Véhicules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reservation.php">Réservation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="contact.php">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contact Hero Section -->
    <div class="contact-hero text-center">
        <div class="container">
            <h1 class="display-4 mb-3">Contactez-nous</h1>
            <p class="lead">Notre équipe est à votre disposition pour répondre à toutes vos questions</p>
        </div>
    </div>

    <!-- Contact Info Section -->
    <div class="container mb-5">
        <div class="row g-4">
            <!-- Adresse -->
            <div class="col-md-4">
                <div class="card contact-card text-center p-4">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt fa-2x text-dark"></i>
                    </div>
                    <h3 class="h4 mb-3">Notre Adresse</h3>
                    <p class="mb-1">123 Avenue Victor Hugo</p>
                    <p>75016 Paris, France</p>
                </div>
            </div>
            
            <!-- Téléphone -->
            <div class="col-md-4">
                <div class="card contact-card text-center p-4">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt fa-2x text-dark"></i>
                    </div>
                    <h3 class="h4 mb-3">Téléphone</h3>
                    <p class="mb-1">Service client: 01 23 45 67 89</p>
                    <p>Assistance: 01 23 45 67 90</p>
                </div>
            </div>
            
            <!-- Email -->
            <div class="col-md-4">
                <div class="card contact-card text-center p-4">
                    <div class="contact-icon">
                        <i class="fas fa-envelope fa-2x text-dark"></i>
                    </div>
                    <h3 class="h4 mb-3">Email</h3>
                    <p class="mb-1">contact@carmotors.fr</p>
                    <p>support@carmotors.fr</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de contact -->
    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="mb-4">Envoyez-nous un message</h2>
                <form id="contactForm" method="post" action="traitement_contact.php">
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
                    <iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>                
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

    <!-- FAQ -->
    <div class="container mb-5">
        <h2 class="text-center mb-4">Questions Fréquentes</h2>
        <div class="accordion" id="faqAccordion">
            <!-- FAQ Items -->
            <?php
            $faq = [
                ["question" => "Comment puis-je réserver un véhicule ?", "reponse" => "Vous pouvez réserver un véhicule en ligne via notre page de réservation..."],
                ["question" => "Quels documents sont nécessaires pour louer un véhicule ?", "reponse" => "Permis de conduire valide, pièce d'identité, carte bancaire..."],
                ["question" => "Comment fonctionne l'assurance des véhicules ?", "reponse" => "Tous nos véhicules sont assurés avec une couverture de base..."],
                ["question" => "Est-il possible d'annuler ou de modifier ma réservation ?", "reponse" => "Oui, jusqu'à 48 heures avant la prise en charge..."]
            ];

            foreach ($faq as $index => $item) {
                echo <<<HTML
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading$index">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse$index">
                            {$item['question']}
                        </button>
                    </h2>
                    <div id="collapse$index" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">{$item['reponse']}</div>
                    </div>
                </div>
                HTML;
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p class="mb-0">&copy; 2024 CARMOTORS - Tous droits réservés.</p>
    </footer>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/contact.js"></script>
</body>
</html>
