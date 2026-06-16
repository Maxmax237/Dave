<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'teacher') {
    header("Location: SignIn.php?error=Accès réservé aux enseignants");
    exit();
}

require_once 'config.php';
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Statistiques
$stats = [
    'courses' => 0,
    'students' => 0,
    'assignments' => 0,
    'pending' => 0
];

// Compter les cours
$result = $conn->query("SELECT COUNT(*) as count FROM courses WHERE teacher = '" . $_SESSION['user_name'] . "'");
if ($result && $row = $result->fetch_assoc()) {
    $stats['courses'] = $row['count'];
}

// Compter les étudiants
$result = $conn->query("SELECT COUNT(DISTINCT student_id) as count FROM assignments WHERE teacher = '" . $_SESSION['user_name'] . "'");
if ($result && $row = $result->fetch_assoc()) {
    $stats['students'] = $row['count'];
}

// Compter les devoirs
$result = $conn->query("SELECT COUNT(*) as count FROM assignments WHERE teacher = '" . $_SESSION['user_name'] . "'");
if ($result && $row = $result->fetch_assoc()) {
    $stats['assignments'] = $row['count'];
}

// Compter les devoirs en attente
$result = $conn->query("SELECT COUNT(*) as count FROM assignments WHERE teacher = '" . $_SESSION['user_name'] . "' AND status = 'pending'");
if ($result && $row = $result->fetch_assoc()) {
    $stats['pending'] = $row['count'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Enseignant</title>
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
        .action-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-chalkboard-teacher me-2"></i>Mon LMS - Enseignant</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><span class="navbar-text text-white">👨‍🏫 <?php echo htmlspecialchars($_SESSION['user_name']); ?></span></li>
                    <li class="nav-item"><a class="nav-link text-white" href="SignOut.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1><i class="fas fa-chalkboard-teacher text-success me-2"></i>Tableau de bord Enseignant</h1>
        <p class="text-muted">Gérez vos cours, vos étudiants et les devoirs.</p>

        <!-- Statistiques -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-book fa-2x text-success mb-2"></i>
                    <div class="stats-number" style="color: #48bb78;"><?php echo $stats['courses']; ?></div>
                    <p class="text-muted">Mes cours</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                    <div class="stats-number" style="color: #4299e1;"><?php echo $stats['students']; ?></div>
                    <p class="text-muted">Étudiants</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-tasks fa-2x text-warning mb-2"></i>
                    <div class="stats-number" style="color: #ed8936;"><?php echo $stats['assignments']; ?></div>
                    <p class="text-muted">Devoirs</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-clock fa-2x text-danger mb-2"></i>
                    <div class="stats-number" style="color: #f56565;"><?php echo $stats['pending']; ?></div>
                    <p class="text-muted">En attente</p>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card action-card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-plus-circle fa-3x text-success mb-3"></i>
                        <h5>Créer un cours</h5>
                        <p class="text-muted">Ajouter un nouveau cours</p>
                        <a href="teacher_courses.php" class="btn btn-success">Gérer</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card action-card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-file-alt fa-3x text-primary mb-3"></i>
                        <h5>Devoirs</h5>
                        <p class="text-muted">Créer et corriger des devoirs</p>
                        <a href="teacher_assignments.php" class="btn btn-primary">Gérer</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card action-card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-user-graduate fa-3x text-warning mb-3"></i>
                        <h5>Étudiants</h5>
                        <p class="text-muted">Suivre vos étudiants</p>
                        <a href="teacher_students.php" class="btn btn-warning">Voir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
