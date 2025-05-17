<?php 
require_once 'config.php';
session_start(); // Start the session

include 'header.php'; 

// Display error message if exists
if (isset($_GET['error'])) {
    echo '<div class="alert alert-danger">Identifiants incorrects</div>';
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        // Store user information in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect to the main page
        header('Location: index.php');
        exit;
    } else {
        // Redirect to login page with error
        header('Location: login.php?error=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARMOTORS - Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/login.css" rel="stylesheet">
</head>
<body>
<div class="login-card">
  <div class="logo-container">
    <img src="img/image.png" alt="CARMOTORS Logo" height="80">
  </div>
  
  <div class="text-center mb-4">
    <h2 class="h3 fw-bold">Connexion à votre compte</h2>
    <p class="text-muted">Accédez à votre espace client CARMOTORS</p>
  </div>
  
  <form id="loginForm" action="" method="post">
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <div class="input-group">
        <span class="input-group-text bg-dark text-white">
          <i class="fas fa-envelope"></i>
        </span>
        <input type="email" class="form-control" id="email" name="email" placeholder="exemple@email.com" required>
      </div>
    </div>
    
    <div class="mb-3">
      <label for="password" class="form-label">Mot de passe</label>
      <div class="input-group">
        <span class="input-group-text bg-dark text-white">
          <i class="fas fa-lock"></i>
        </span>
        <input type="password" class="form-control" id="password" name="password" required>
        <button class="btn btn-outline-secondary" type="button" id="showPassword">
          <i class="fas fa-eye"></i>
        </button>
      </div>
    </div>
    
    <div class="d-flex justify-content-between mb-4">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="rememberMe">
        <label class="form-check-label" for="rememberMe">Se souvenir de moi</label>
      </div>
      <a href="#" class="text-decoration-none text-dark">Mot de passe oublié?</a>
    </div>
    
    <button type="submit" class="btn btn-dark w-100 py-2 mb-3">Se connecter</button>
    
    <div class="text-center">
      <span>Vous n'avez pas de compte?</span>
      <a href="signup.php" class="text-decoration-none fw-bold text-dark">S'inscrire</a>
    </div>
  </form>
  
  <div class="divider">
    <div class="divider-line"></div>
    <span class="divider-text">OU</span>
    <div class="divider-line"></div>
  </div>
  
  <div class="text-center social-buttons">
    <p class="mb-3">Connexion avec</p>
    <a href="#" class="btn btn-outline-dark">
      <i class="fab fa-google"></i>
    </a>
    <a href="#" class="btn btn-outline-dark">
      <i class="fab fa-facebook-f"></i>
    </a>
    <a href="#" class="btn btn-outline-dark">
      <i class="fab fa-apple"></i>
    </a>
  </div>
</div>
</body>
<script>
// Toggle password visibility
document.getElementById('showPassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
</script>
</html>