<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'teacher') {
    header("Location: SignIn.php");
    exit();
}

require_once 'config.php';
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

$students = $conn->query("SELECT * FROM users WHERE user_type = 'student' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-warning">
        <div class="container">
            <a class="navbar-brand text-dark" href="TeacherDash.php"><i class="fas fa-arrow-left me-2"></i>Retour</a>
            <span class="navbar-text text-dark">👨‍🏫 <?php echo $_SESSION['user_name']; ?></span>
        </div>
    </nav>

    <div class="container mt-4">
        <h2><i class="fas fa-users me-2"></i>Mes Étudiants</h2>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>#</th><th>Nom</th><th>Email</th><th>Téléphone</th><th>Inscrit le</th></tr>
                </thead>
                <tbody>
                    <?php $i = 1; while ($student = $students->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($student['email']); ?></td>
                            <td><?php echo htmlspecialchars($student['mobile']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($student['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
