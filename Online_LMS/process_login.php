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
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header("Location: SignIn.php?error=Email et mot de passe obligatoires");
    exit();
}

// Rechercher l'utilisateur
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['logged_in'] = true;
        
        // Redirection selon le type
        switch($user['user_type']) {
            case 'student':
                header("Location: StudentDash.php");
                break;
            case 'teacher':
                header("Location: TeacherDash.php");
                break;
            case 'employer':
                header("Location: AdminDash.php");
                break;
            default:
                header("Location: index.php");
                break;
        }
        exit();
    } else {
        header("Location: SignIn.php?error=Mot de passe incorrect");
        exit();
    }
} else {
    header("Location: SignIn.php?error=Email non trouvé");
    exit();
}

$stmt->close();
$conn->close();
?>
