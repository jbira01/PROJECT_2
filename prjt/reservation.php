<?php
session_start();

// Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Connexion à la BDD
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

// Initialisation
$message = '';
$errors = [];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pickupLocation = $_POST['pickupLocation'] ?? '';
    $startDate = $_POST['startDate'] ?? '';
    $rentalDuration = (int)($_POST['rentalDuration'] ?? 0);
    $vehiculeId = (int)($_POST['vehicle'] ?? 0);
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $phone = trim($_POST['phone'] ?? '');

    // Validation
    if (!$pickupLocation) $errors[] = "Le lieu de retrait est obligatoire.";
    if (!$startDate) $errors[] = "La date de début est obligatoire.";
    if ($rentalDuration <= 0) $errors[] = "La durée de location est obligatoire.";
    if ($vehiculeId <= 0) $errors[] = "Vous devez sélectionner un véhicule.";
    if (!$email) $errors[] = "Email invalide.";
    if (!$phone) $errors[] = "Le téléphone est obligatoire.";

    // Date future
    if ($startDate && strtotime($startDate) < strtotime(date('Y-m-d'))) {
        $errors[] = "La date de début ne peut pas être dans le passé.";
    }

    // Vérifier que le véhicule existe
    $stmt = $pdo->prepare("SELECT * FROM vehicules WHERE id = ?");
    $stmt->execute([$vehiculeId]);
    $vehicule = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$vehicule) $errors[] = "Véhicule sélectionné invalide.";

    // Insertion en base
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO reservations 
            (pickup_location, start_date, rental_duration, vehicule_id, email, phone) 
            VALUES (?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([
            $pickupLocation,
            $startDate,
            $rentalDuration,
            $vehiculeId,
            $email,
            $phone
        ]);

        if ($success) {
            $message = "Réservation confirmée avec succès !";
            $_POST = [];
        } else {
            $errors[] = "Erreur lors de l'enregistrement de la réservation.";
        }
    }
}

// Récupérer les véhicules
$stmt = $pdo->query("SELECT * FROM vehicules");
$vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Déconnexion</a></li>
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

                    <!-- Formulaire -->
                    <form method="post" action="">
                        <!-- Lieu de retrait -->
                        <div class="mb-3">
                            <label class="form-label">Lieu de Retrait</label>
                            <select name="pickupLocation" class="form-select" required>
                                <option value="">Sélectionnez un lieu</option>
                                <?php
                                $villes = ['paris', 'lyon', 'marseille', 'nice'];
                                foreach ($villes as $ville) {
                                    $selected = ($_POST['pickupLocation'] ?? '') === $ville ? 'selected' : '';
                                    echo "<option value=\"$ville\" $selected>" . ucfirst($ville) . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Date & Durée -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Date de Début</label>
                                <input type="date" name="startDate" class="form-control" value="<?= htmlspecialchars($_POST['startDate'] ?? '') ?>" min="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Durée</label>
                                <select name="rentalDuration" id="rentalDuration" class="form-select" required>
                                    <option value="">Durée</option>
                                    <?php
                                    $durees = [1 => '1 jour', 3 => '3 jours', 7 => '1 semaine', 14 => '2 semaines'];
                                    foreach ($durees as $val => $label) {
                                        $selected = ($_POST['rentalDuration'] ?? '') == $val ? 'selected' : '';
                                        echo "<option value=\"$val\" $selected>$label</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Véhicules -->
                        <h3 class="mb-3">Sélectionnez votre véhicule</h3>
                        <div class="row g-3 mb-4">
                            <?php foreach ($vehicules as $v): ?>
                                <div class="col-md-4">
                                    <div class="card">
                                        <img src="img/<?= htmlspecialchars($v['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($v['make'] . ' ' . $v['model']) ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($v['make'] . ' ' . $v['model']) ?></h5>
                                            <p class="card-text"><?= htmlspecialchars($v['price_per_day']) ?> € / jour</p>
                                            <input type="radio" name="vehicle" value="<?= $v['id'] ?>" class="vehicle-radio" <?= ($_POST['vehicle'] ?? '') == $v['id'] ? 'checked' : '' ?> required>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Prix -->
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

                        <!-- Coordonnées -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Prix dynamique JS
const vehicules = <?= json_encode($vehicules) ?>;
const radios = document.querySelectorAll('.vehicle-radio');
const durationSelect = document.getElementById('rentalDuration');
const priceDisplay = document.getElementById('selectedVehiclePrice');
const durationDisplay = document.getElementById('rentalDurationDisplay');
const totalDisplay = document.getElementById('totalPrice');

function updatePrice() {
    const selectedRadio = document.querySelector('input[name="vehicle"]:checked');
    const duration = parseInt(durationSelect.value) || 0;
    if (!selectedRadio || !duration) {
        priceDisplay.textContent = durationDisplay.textContent = totalDisplay.textContent = '-';
        return;
    }
    const vehicle = vehicules.find(v => v.id == selectedRadio.value);
    priceDisplay.textContent = `${vehicle.price_per_day} € / jour`;
    durationDisplay.textContent = `${duration} ${duration > 1 ? 'jours' : 'jour'}`;
    totalDisplay.textContent = (vehicle.price_per_day * duration).toFixed(2);
}

radios.forEach(r => r.addEventListener('change', updatePrice));
durationSelect.addEventListener('change', updatePrice);
document.addEventListener('DOMContentLoaded', updatePrice);
</script>
</body>
</html>
