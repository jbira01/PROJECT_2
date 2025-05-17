<?php
// Connexion à la BDD (à adapter avec vos infos)
$host = 'localhost';
$dbname = 'carmotors';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Initialisation des variables
$message = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $pickupLocation = $_POST['pickupLocation'] ?? '';
    $startDate = $_POST['startDate'] ?? '';
    $rentalDuration = (int)($_POST['rentalDuration'] ?? 0);
    $vehicleId = (int)($_POST['vehicle'] ?? 0);
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $phone = trim($_POST['phone'] ?? '');

    // Validation simple
    if (!$pickupLocation) $errors[] = "Le lieu de retrait est obligatoire.";
    if (!$startDate) $errors[] = "La date de début est obligatoire.";
    if ($rentalDuration <= 0) $errors[] = "La durée de location est obligatoire.";
    if ($vehicleId <= 0) $errors[] = "Vous devez sélectionner un véhicule.";
    if (!$email) $errors[] = "Email invalide.";
    if (!$phone) $errors[] = "Le téléphone est obligatoire.";
    
    // Vérifier que la date n'est pas dans le passé
    if ($startDate && strtotime($startDate) < strtotime(date('Y-m-d'))) {
        $errors[] = "La date de début ne peut pas être dans le passé.";
    }

    // Vérifier que le véhicule existe
    $stmt = $pdo->prepare("SELECT * FROM vehicles WHERE id = ?");
    $stmt->execute([$vehicleId]);
    $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$vehicle) $errors[] = "Véhicule sélectionné invalide.";

    // Si pas d'erreur, insertion en base
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO reservations 
            (pickup_location, start_date, rental_duration, vehicle_id, email, phone) 
            VALUES (?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([
            $pickupLocation,
            $startDate,
            $rentalDuration,
            $vehicleId,
            $email,
            $phone
        ]);

        if ($success) {
            $message = "Réservation confirmée avec succès !";
            // Reset post data pour vider le formulaire
            $_POST = [];
        } else {
            $errors[] = "Erreur lors de l'enregistrement de la réservation.";
        }
    }
}

// Récupérer les véhicules pour affichage dynamique
$stmt = $pdo->query("SELECT * FROM vehicles");
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Débogage: Afficher la structure d'un véhicule pour comprendre les noms des colonnes
// if (!empty($vehicles)) {
//     echo '<pre>';
//     print_r($vehicles[0]);
//     echo '</pre>';
// }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CARMOTORS - Réservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/reservation.css" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img src="img/image.png" alt="Logo" height="60" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav fs-5">
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="vehicules.php">Nos Véhicules</a></li>
                <li class="nav-item"><a class="nav-link active" href="reservation.php">Réservation</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container text-center py-4">
    <h2 class="display-5 mb-3">Réservation de Véhicule</h2>
    <p class="lead">Personnalisez votre location</p>
</div>

<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <?php if ($message): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form id="reservationForm" method="post" action="">
                        <div class="mb-3">
                            <label for="pickupLocation" class="form-label">Lieu de Retrait</label>
                            <select id="pickupLocation" name="pickupLocation" class="form-select" required>
                                <option value="">Sélectionnez un lieu</option>
                                <option value="paris" <?= (($_POST['pickupLocation'] ?? '') === 'paris') ? 'selected' : '' ?>>Paris</option>
                                <option value="lyon" <?= (($_POST['pickupLocation'] ?? '') === 'lyon') ? 'selected' : '' ?>>Lyon</option>
                                <option value="marseille" <?= (($_POST['pickupLocation'] ?? '') === 'marseille') ? 'selected' : '' ?>>Marseille</option>
                                <option value="nice" <?= (($_POST['pickupLocation'] ?? '') === 'nice') ? 'selected' : '' ?>>Nice</option>
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Date de Début</label>
                                <input type="date" id="startDate" name="startDate" class="form-control" 
                                        value="<?= htmlspecialchars($_POST['startDate'] ?? '') ?>" 
                                        min="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Durée</label>
                                <select id="rentalDuration" name="rentalDuration" class="form-select" required>
                                    <option value="">Durée</option>
                                    <option value="1" <?= (($_POST['rentalDuration'] ?? '') === '1') ? 'selected' : '' ?>>1 jour</option>
                                    <option value="3" <?= (($_POST['rentalDuration'] ?? '') === '3') ? 'selected' : '' ?>>3 jours</option>
                                    <option value="7" <?= (($_POST['rentalDuration'] ?? '') === '7') ? 'selected' : '' ?>>1 semaine</option>
                                    <option value="14" <?= (($_POST['rentalDuration'] ?? '') === '14') ? 'selected' : '' ?>>2 semaines</option>
                                </select>
                            </div>
                        </div>

                        <h3 class="mb-3">Sélectionnez votre véhicule</h3>
                        <div class="row g-3 mb-4" id="vehicleSelection">
                            <?php foreach ($vehicles as $v): ?>
                                <div class="col-md-4">
                                    <div class="card">
                                        <img src="<?= htmlspecialchars($v['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($v['name']) ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($v['name']) ?></h5>
                                            <p class="card-text"><?= htmlspecialchars($v['price_per_day']) ?> € / jour</p>
                                            <input type="radio" name="vehicle" value="<?= htmlspecialchars($v['id']) ?>" 
                                                class="vehicle-radio" 
                                                <?= (($_POST['vehicle'] ?? '') == $v['id']) ? 'checked' : '' ?> required>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h4 class="card-title">Récapitulatif du Prix</h4>
                                <div class="row">
                                    <div class="col-6">Véhicule :</div>
                                    <div class="col-6 text-end" id="selectedVehiclePrice">-</div>
                                </div>
                                <div class="row">
                                    <div class="col-6">Durée :</div>
                                    <div class="col-6 text-end" id="rentalDurationDisplay">-</div>
                                </div>
                                <hr>
                                <div class="row fw-bold">
                                    <div class="col-6">Total :</div>
                                    <div class="col-6 text-end"><span id="totalPrice">-</span>€</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required placeholder="Votre email">
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="tel" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required placeholder="Votre numéro de téléphone">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark btn-lg w-100">Confirmer la Réservation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    <p class="mb-0">&copy; 2024 CARMOTORS - Tous droits réservés.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script>
// JS pour mettre à jour le récapitulatif du prix en live
const vehicles = <?= json_encode($vehicles) ?>;
const vehicleRadios = document.querySelectorAll('.vehicle-radio');
const rentalDurationSelect = document.getElementById('rentalDuration');
const selectedVehiclePrice = document.getElementById('selectedVehiclePrice');
const rentalDurationDisplay = document.getElementById('rentalDurationDisplay');
const totalPrice = document.getElementById('totalPrice');

function updatePrice() {
    const selectedVehicle = [...document.querySelectorAll('input[name="vehicle"]')].find(r => r.checked);
    const duration = parseInt(rentalDurationSelect.value) || 0;

    if (!selectedVehicle || !duration) {
        selectedVehiclePrice.textContent = '-';
        rentalDurationDisplay.textContent = '-';
        totalPrice.textContent = '-';
        return;
    }

    const vehicle = vehicles.find(v => v.id == selectedVehicle.value);
    if (!vehicle) return;

    selectedVehiclePrice.textContent = vehicle.price_per_day + ' € / jour';
    rentalDurationDisplay.textContent = duration + (duration === 1 ? ' jour' : ' jours');
    totalPrice.textContent = (vehicle.price_per_day * duration).toFixed(2);
}

// Attacher les écouteurs d'événements à tous les boutons radio
vehicleRadios.forEach(radio => {
    radio.addEventListener('change', updatePrice);
});

// Écouteur d'événement pour la durée
rentalDurationSelect.addEventListener('change', updatePrice);

// Mise à jour initiale si valeurs déjà sélectionnées (ex: après erreur)
document.addEventListener('DOMContentLoaded', function() {
    updatePrice();
});
</script>

</body>
</html>