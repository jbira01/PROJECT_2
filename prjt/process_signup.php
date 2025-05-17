<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    
    // Validate data
    if ($password !== $confirmPassword) {
        header('Location: signup.php?error=password_mismatch');
        exit;
    }
    
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert into database
    try {
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$firstName, $lastName, $email, $phone, $hashedPassword]);
        
        // Redirect to login page
        header('Location: login.php?signup=success');
        exit;
    } catch (PDOException $e) {
        header('Location: signup.php?error=database_error');
        exit;
    }
} else {
    header('Location: signup.php');
    exit;
}
?>