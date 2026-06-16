<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuration
require_once 'config.php';

// Connexion
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupérer les données
$user_type = $_POST['user_type'] ?? 'student';
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$mobile = trim($_POST['mobile'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Vérifications
if (empty($first_name) || empty($last_name) || empty($mobile) || empty($email) || empty($password)) {
    header("Location: Register.php?error=Tous les champs sont obligatoires");
    exit();
}

// Vérifier si l'email existe déjà
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    header("Location: Register.php?error=Cet email est déjà utilisé");
    exit();
}
$check->close();

// Hacher le mot de passe (l'étudiant choisit son mot de passe)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insérer l'utilisateur
$sql = "INSERT INTO users (user_type, first_name, last_name, mobile, email, password) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $user_type, $first_name, $last_name, $mobile, $email, $hashed_password);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        header("Location: SignIn.php?success=Compte créé avec succès ! Connectez-vous avec votre mot de passe.");
    } else {
        header("Location: Register.php?error=Erreur lors de la création du compte");
    }
} else {
    header("Location: Register.php?error=Erreur SQL : " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
