<?php
session_start();

// Connexion PDO
$pdo = new PDO('mysql:host=localhost;dbname=carmotors;charset=utf8', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Suppression (via POST)
if (isset($_POST['delete_id'])) {
    $deleteId = (int)$_POST['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
    $stmt->execute([$deleteId]);
    $_SESSION['message'] = "Réservation supprimée.";
    header("Location: admin.php");
    exit;
}

// Mise à jour (via POST)
if (isset($_POST['update_id'])) {
    $id = (int)$_POST['update_id'];
    $pickup_location = $_POST['pickup_location'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $rental_duration = (int)($_POST['rental_duration'] ?? 1);
    $vehicule_id = (int)($_POST['vehicule_id'] ?? 0);
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    $stmt = $pdo->prepare("UPDATE reservations SET pickup_location = ?, start_date = ?, rental_duration = ?, vehicule_id = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->execute([$pickup_location, $start_date, $rental_duration, $vehicule_id, $email, $phone, $id]);

    $_SESSION['message'] = "Réservation mise à jour.";
    header("Location: admin.php");
    exit;
}

// Récupérer les réservations
$sql = "SELECT r.id, r.email, r.phone, r.pickup_location, r.start_date, r.rental_duration, 
               r.vehicule_id, v.make, v.model, v.year, v.image_url, v.price_per_day
        FROM reservations r
        LEFT JOIN vehicules v ON r.vehicule_id = v.id
        ORDER BY r.start_date DESC";
$stmt = $pdo->query($sql);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer tous les véhicules pour le select modification
$vehicules = $pdo->query("SELECT id, make, model, year FROM vehicules ORDER BY make, model")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Admin - Gestion des Réservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .vehicle-img { width: 80px; height: auto; border-radius: 5px; }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>Gestion des Réservations</h1>

    <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']); ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <table class="table table-striped table-bordered mt-4 align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Véhicule</th>
                <th>Image</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Lieu de Retrait</th>
                <th>Date de début</th>
                <th>Durée (jours)</th>
                <th>Prix/jour (€)</th>
                <th>Prix total (€)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!$reservations): ?>
            <tr><td colspan="11" class="text-center">Aucune réservation trouvée.</td></tr>
        <?php else: ?>
            <?php foreach ($reservations as $res): ?>
            <tr>
                <td><?= htmlspecialchars($res['id']) ?></td>
                <td><?= htmlspecialchars($res['make'] . ' ' . $res['model'] . ' (' . $res['year'] . ')') ?></td>
                <td>
                    <?php if ($res['image_url']): ?>
                        <img src="<?= htmlspecialchars($res['image_url']) ?>" alt="Image véhicule" class="vehicle-img">
                    <?php else: ?> -
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($res['email']) ?></td>
                <td><?= htmlspecialchars($res['phone']) ?></td>
                <td><?= htmlspecialchars($res['pickup_location']) ?></td>
                <td><?= htmlspecialchars($res['start_date']) ?></td>
                <td><?= htmlspecialchars($res['rental_duration']) ?></td>
                <td><?= number_format($res['price_per_day'], 2, ',', ' ') ?></td>
                <td><?= number_format($res['price_per_day'] * $res['rental_duration'], 2, ',', ' ') ?></td>
                <td>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" 
                            data-id="<?= $res['id'] ?>"
                            data-pickup="<?= htmlspecialchars($res['pickup_location']) ?>"
                            data-start="<?= $res['start_date'] ?>"
                            data-duration="<?= $res['rental_duration'] ?>"
                            data-vehicule="<?= $res['vehicule_id'] ?>"
                            data-email="<?= htmlspecialchars($res['email']) ?>"
                            data-phone="<?= htmlspecialchars($res['phone']) ?>">
                        Modifier
                    </button>
                    <form method="POST" style="display:inline-block" onsubmit="return confirm('Confirmer la suppression ?');">
                        <input type="hidden" name="delete_id" value="<?= $res['id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Modification -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Modifier la Réservation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="update_id" id="update_id">

          <div class="mb-3">
              <label for="pickup_location" class="form-label">Lieu de Retrait</label>
              <select name="pickup_location" id="pickup_location" class="form-select" required>
                  <option value="paris">Paris</option>
                  <option value="lyon">Lyon</option>
                  <option value="marseille">Marseille</option>
                  <option value="nice">Nice</option>
              </select>
          </div>

          <div class="mb-3">
              <label for="start_date" class="form-label">Date de début</label>
              <input type="date" name="start_date" id="start_date" class="form-control" required>
          </div>

          <div class="mb-3">
              <label for="rental_duration" class="form-label">Durée (jours)</label>
              <select name="rental_duration" id="rental_duration" class="form-select" required>
                  <option value="1">1 jour</option>
                  <option value="3">3 jours</option>
                  <option value="7">1 semaine</option>
                  <option value="14">2 semaines</option>
              </select>
          </div>

          <div class="mb-3">
              <label for="vehicule_id" class="form-label">Véhicule</label>
              <select name="vehicule_id" id="vehicule_id" class="form-select" required>
                  <?php foreach ($vehicules as $v): ?>
                  <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['make'] . ' ' . $v['model'] . ' (' . $v['year'] . ')') ?></option>
                  <?php endforeach; ?>
              </select>
          </div>

          <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control" required>
          </div>

          <div class="mb-3">
              <label for="phone" class="form-label">Téléphone</label>
              <input type="tel" name="phone" id="phone" class="form-control" required>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success">Sauvegarder</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Remplir le formulaire modal avec les données de la ligne sélectionnée
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        var id = button.getAttribute('data-id');
        var pickup = button.getAttribute('data-pickup');
        var start = button.getAttribute('data-start');
        var duration = button.getAttribute('data-duration');
        var vehicule = button.getAttribute('data-vehicule');
        var email = button.getAttribute('data-email');
        var phone = button.getAttribute('data-phone');

        document.getElementById('update_id').value = id;
        document.getElementById('pickup_location').value = pickup;
        document.getElementById('start_date').value = start;
        document.getElementById('rental_duration').value = duration;
        document.getElementById('vehicule_id').value = vehicule;
        document.getElementById('email').value = email;
        document.getElementById('phone').value = phone;
    });
</script>
</body>
</html>
