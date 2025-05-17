<?php
$page_title = "Accueil";
$css_file = "index";
$js_file = "index";

// Sample dynamic content
$featured_vehicles = [
    [
        'image' => 'img/clio.png',
        'name' => 'Renault Clio',
        'description' => 'Citadine économique'
    ],
    [
        'image' => 'img/VOL.png',
        'name' => 'VOLKSWAGEN TOUAREG',
        'description' => 'Berline confortable'
    ],
    [
        'image' => 'img/bmw.png',
        'name' => 'BMW Série 3',
        'description' => 'Berline premium'
    ]
];
?>

<!-- Navigation -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CARMOTORS - Accueil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/index.css" rel="stylesheet">
</head>
</html>
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
          <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="vehicules.php">Nos Véhicules</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="reservation.php">Réservation</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<div class="hero text-center py-5">
  <div class="container">
    <h2 class="display-4 mb-3">Louez votre voiture de rêve</h2>
    <p class="lead mb-4">Des véhicules de qualité pour tous vos voyages</p>
    <a href="reservation.php" class="btn btn-dark btn-lg">Réserver Maintenant</a>
  </div>
</div>

<!-- Services Section -->
<div class="container mt-5">
  <div class="row services">
    <div class="col-md-4 mb-4">
      <div class="card service-card text-center p-4">
        <i class="fas fa-car text-dark mb-3 fa-3x"></i>
        <h3 class="h4">Large Gamme</h3>
        <p>Découvrez notre flotte variée de véhicules modernes et confortables</p>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card service-card text-center p-4">
        <i class="fas fa-tags text-dark mb-3 fa-3x"></i>
        <h3 class="h4">Tarifs Compétitifs</h3>
        <p>Des prix attractifs sans compromettre la qualité</p>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card service-card text-center p-4">
        <i class="fas fa-headset text-dark mb-3 fa-3x"></i>
        <h3 class="h4">Service Client</h3>
        <p>Une équipe à votre écoute pour un service personnalisé</p>
      </div>
    </div>
  </div>

  <!-- Vehicle Preview Section -->
  <div class="row vehicle-preview mt-4">
    <?php foreach ($featured_vehicles as $vehicle): ?>
    <div class="col-md-4 mb-4">
      <div class="card vehicle-preview-card text-center">
        <img src="<?php echo $vehicle['image']; ?>" alt="<?php echo $vehicle['name']; ?>" class="card-img-top">
        <div class="card-body">
          <h3 class="card-title"><?php echo $vehicle['name']; ?></h3>
          <p class="card-text"><?php echo $vehicle['description']; ?></p>
          <a href="reservation.php" class="btn btn-dark">Réserver</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include 'footer.php'; ?>