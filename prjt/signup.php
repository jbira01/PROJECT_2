<?php 
require_once 'config.php';
$css_file = "signup";
$js_file = "signup";
include 'header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARMOTORS - Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/signup.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="signup-card">
  <div class="text-center mb-4">
    <img src="img/image.png" height="60" alt="Logo" />
    <h2 class="mt-2">Créer un compte</h2>
  </div>

  <form id="signupForm" action="process_signup.php" method="post">
    <div class="mb-3">
      <label class="form-label">Prénom</label>
      <input type="text" class="form-control" name="firstName" required />
    </div>
    <div class="mb-3">
      <label class="form-label">Nom</label>
      <input type="text" class="form-control" name="lastName" required />
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" class="form-control" name="email" required />
    </div>
    <div class="mb-3">
      <label class="form-label">Téléphone</label>
      <input type="tel" class="form-control" name="phone" />
    </div>
    <div class="mb-3">
      <label class="form-label">Mot de passe</label>
      <div class="input-group">
        <input type="password" class="form-control" name="password" id="password" required />
        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
          <i class="fas fa-eye"></i>
        </button>
      </div>
      <div class="password-requirements mt-2">
        <ul class="list-unstyled mb-0">
          <li id="req-length">• 8 caractères</li>
          <li id="req-upper">• 1 majuscule</li>
          <li id="req-lower">• 1 minuscule</li>
          <li id="req-number">• 1 chiffre</li>
        </ul>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Confirmer le mot de passe</label>
      <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" required />
      <small id="matchMsg" class="form-text"></small>
    </div>
    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" name="agreeTerms" id="agreeTerms" required />
      <label class="form-check-label">
        J'accepte les <a class="text-decoration-none fw-bold text-dark" href="#">conditions</a> et 
        <a class="text-decoration-none fw-bold text-dark" href="#">la politique</a>
      </label>
    </div>
    <button type="submit" class="btn btn-dark w-100">Créer mon compte</button>
    <div class="text-center mt-3">
      <span>Déjà inscrit ? <a class="text-decoration-none fw-bold text-dark" href="login.php">Se connecter</a></span>
    </div>
  </form>
</div>
<script>
      // Password visibility toggle and validation
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    const togglePassword = document.getElementById('togglePassword');
    const requirements = {
      length: document.getElementById('req-length'),
      upper: document.getElementById('req-upper'),
      lower: document.getElementById('req-lower'),
      number: document.getElementById('req-number')
    };
    const matchMsg = document.getElementById('matchMsg');

    togglePassword.addEventListener('click', () => {
      password.type = password.type === 'password' ? 'text' : 'password';
      togglePassword.querySelector('i').classList.toggle('fa-eye');
      togglePassword.querySelector('i').classList.toggle('fa-eye-slash');
    });

    function updateReq(el, valid) {
      el.classList.toggle('valid', valid);
      el.classList.toggle('invalid', !valid);
    }

    password.addEventListener('input', () => {
      const val = password.value;
      updateReq(requirements.length, val.length >= 8);
      updateReq(requirements.upper, /[A-Z]/.test(val));
      updateReq(requirements.lower, /[a-z]/.test(val));
      updateReq(requirements.number, /[0-9]/.test(val));
      checkMatch();
    });

    confirmPassword.addEventListener('input', checkMatch);

    function checkMatch() {
      if (confirmPassword.value === '') return matchMsg.textContent = '';
      const match = password.value === confirmPassword.value;
      matchMsg.textContent = match ? "✓ Les mots de passe correspondent" : "❌ Les mots de passe ne correspondent pas";
      matchMsg.className = match ? "form-text text-success" : "form-text text-danger";
    }

    document.getElementById('signupForm').addEventListener('submit', (e) => {
      e.preventDefault(); // Prevent form submission
      if (password.value !== confirmPassword.value) return alert("Les mots de passe ne correspondent pas.");
      if (!document.getElementById('agreeTerms').checked) return alert("Veuillez accepter les conditions.");
      window.location.href = 'login.php'; // Redirect to the main page after login
    });
</script>
</body>
</html>
