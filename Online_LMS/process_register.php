<?php
// process_register.php - Traitement de l'inscription

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lms_db";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$user_type = $_POST['user_type'] ?? 'student';
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Vérifier que tous les champs sont remplis
if (empty($first_name) || empty($last_name) || empty($mobile) || empty($email) || empty($password)) {
    header("Location: Register.php?error=Tous les champs sont obligatoires");
    exit();
}

// Hacher le mot de passe
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Préparer la requête SQL
$sql = "INSERT INTO users (user_type, first_name, last_name, mobile, email, password) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $user_type, $first_name, $last_name, $mobile, $email, $hashed_password);

if ($stmt->execute()) {
    // Redirection vers la page de connexion avec succès
    header("Location: SignIn.php?success=Compte créé avec succès ! Connectez-vous.");
} else {
    // Erreur d'insertion
    header("Location: Register.php?error=Erreur lors de la création du compte : " . $conn->error);
}

$stmt->close();
$conn->close();
?>
