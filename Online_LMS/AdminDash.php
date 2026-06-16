<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'employer') {
    header("Location: SignIn.php?error=Accès réservé aux administrateurs");
    exit();
}

require_once 'config.php';
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Statistiques globales
$stats = [
    'students' => $conn->query("SELECT COUNT(*) FROM users WHERE user_type = 'student'")->fetch_row()[0],
    'teachers' => $conn->query("SELECT COUNT(*) FROM users WHERE user_type = 'teacher'")->fetch_row()[0],
    'courses' => $conn->query("SELECT COUNT(*) FROM courses")->fetch_row()[0],
    'assignments' => $conn->query("SELECT COUNT(*) FROM assignments")->fetch_row()[0]
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Mon LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-3px);
        }
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark" style="background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-user-cog me-2"></i>Admin LMS</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><span class="navbar-text text-white">👑 <?php echo htmlspecialchars($_SESSION['user_name']); ?></span></li>
                    <li class="nav-item"><a class="nav-link text-white" href="SignOut.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1><i class="fas fa-chart-pie text-danger me-2"></i>Tableau de bord Administrateur</h1>
        <p class="text-muted">Vue d'ensemble de la plateforme.</p>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                    <div class="stats-number" style="color: #4299e1;"><?php echo $stats['students']; ?></div>
                    <p class="text-muted">Étudiants</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-chalkboard-teacher fa-2x text-success mb-2"></i>
                    <div class="stats-number" style="color: #48bb78;"><?php echo $stats['teachers']; ?></div>
                    <p class="text-muted">Enseignants</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-book fa-2x text-warning mb-2"></i>
                    <div class="stats-number" style="color: #ed8936;"><?php echo $stats['courses']; ?></div>
                    <p class="text-muted">Cours</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-file-alt fa-2x text-danger mb-2"></i>
                    <div class="stats-number" style="color: #f56565;"><?php echo $stats['assignments']; ?></div>
                    <p class="text-muted">Devoirs</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <a href="admin_users.php" class="text-decoration-none">
                    <div class="card action-card">
                        <div class="card-body text-center">
                            <i class="fas fa-user-cog fa-3x text-primary mb-3"></i>
                            <h5>Gérer les utilisateurs</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="admin_courses.php" class="text-decoration-none">
                    <div class="card action-card">
                        <div class="card-body text-center">
                            <i class="fas fa-book fa-3x text-warning mb-3"></i>
                            <h5>Gérer les cours</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="admin_reports.php" class="text-decoration-none">
                    <div class="card action-card">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-bar fa-3x text-danger mb-3"></i>
                            <h5>Rapports</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
