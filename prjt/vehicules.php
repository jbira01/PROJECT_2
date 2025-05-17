<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CARMOTORS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/vehicules.css">
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARMOTORS - Nos Véhicules</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/vehicule.css" rel="stylesheet">
</head>

</html>
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
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link active" href="vehicules.php">Nos Véhicules</a></li>
                <li class="nav-item"><a class="nav-link" href="reservation.php">Réservation</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Title -->
<div class="container text-center py-4">
    <h2 class="display-5 mb-3">Nos Véhicules</h2>
    <p class="lead">Trouvez la voiture parfaite pour votre voyage</p>
</div>

<!-- Filters -->
<div class="container mt-3">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <div class="btn-group" role="group">
                <button class="btn btn-dark active filter-btn" data-category="all">Tous</button>
                <button class="btn btn-dark filter-btn" data-category="compact">Compact</button>
                <button class="btn btn-dark filter-btn" data-category="berline">Berline</button>
                <button class="btn btn-dark filter-btn" data-category="suv">SUV</button>
                <button class="btn btn-dark filter-btn" data-category="luxe">Luxe</button>
            </div>
        </div>
    </div>

    <!-- Vehicle Grid -->
    <div class="row" id="vehicleGrid">
        <?php
        $stmt = $pdo->query("SELECT * FROM vehicles WHERE available = 1");
        while ($vehicle = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="col-md-4 mb-4 vehicle-item" data-category="' . $vehicle['category'] . '">
                    <div class="card h-100">
                        <img src="' . htmlspecialchars($vehicle['image']) . '" class="card-img-top" alt="' . htmlspecialchars($vehicle['name']) . '">
                        <div class="card-body">
                            <h5 class="card-title">' . htmlspecialchars($vehicle['name']) . '</h5>
                            <p class="card-text">Catégorie : ' . htmlspecialchars($vehicle['category']) . '</p>
                            <p class="card-text">À partir de <strong>' . $vehicle['price_per_day'] . '€/jour</strong></p>
                            <a href="reservation.php?id=' . $vehicle['id'] . '" class="btn btn-dark">Réserver</a>
                        </div>
                    </div>
                  </div>';
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
<script>
    // Filter script
    const filterButtons = document.querySelectorAll('.filter-btn');
    const vehicles = document.querySelectorAll('.vehicle-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            const category = button.dataset.category;

            vehicles.forEach(vehicle => {
                if (category === 'all' || vehicle.dataset.category === category) {
                    vehicle.style.display = 'block';
                } else {
                    vehicle.style.display = 'none';
                }
            });
        });
    });
</script>
</body>
</html>
