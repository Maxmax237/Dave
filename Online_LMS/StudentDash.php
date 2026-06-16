<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: SignIn.php?error=Veuillez vous connecter");
    exit();
}

// Vérifier si c'est un étudiant
if ($_SESSION['user_type'] != 'student') {
    header("Location: " . ucfirst($_SESSION['user_type']) . "Dash.php");
    exit();
}

// Récupérer les infos de session
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: #f4f6f9;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-dash {
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        .card-dash:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="my_courses.php">
                <i class="fas fa-graduation-cap me-2"></i>Mon LMS
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text text-white me-3">
                            <i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($user_name); ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="SignOut.php">
                            <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Bienvenue -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="display-6">👋 Bonjour, <?php echo htmlspecialchars($user_name); ?> !</h1>
                <p class="text-muted">Bienvenue sur votre espace étudiant</p>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-book fa-2x" style="color: #667eea;"></i>
                    <div class="stats-number">12</div>
                    <p class="text-muted">Cours inscrits</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-tasks fa-2x" style="color: #48bb78;"></i>
                    <div class="stats-number">5</div>
                    <p class="text-muted">Devoirs à rendre</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-check-circle fa-2x" style="color: #4299e1;"></i>
                    <div class="stats-number">8</div>
                    <p class="text-muted">Devoirs complétés</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-certificate fa-2x" style="color: #ed8936;"></i>
                    <div class="stats-number">3</div>
                    <p class="text-muted">Certificats</p>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-dash h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-book-open fa-3x mb-3" style="color: #667eea;"></i>
                        <h5 class="card-title">Mes Cours</h5>
                        <p class="card-text text-muted">Voir tous vos cours et leçons</p>
                        <a href="my_courses.php" class="btn btn-outline-primary">Accéder</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-dash h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-file-alt fa-3x mb-3" style="color: #48bb78;"></i>
                        <h5 class="card-title">Mes Devoirs</h5>
                        <p class="card-text text-muted">Consulter et soumettre vos devoirs</p>
                        <a href="my_courses.php" class="btn btn-outline-success">Accéder</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-dash h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-3x mb-3" style="color: #ed8936;"></i>
                        <h5 class="card-title">Ma Progression</h5>
                        <p class="card-text text-muted">Suivre votre avancement</p>
                        <a href="my_courses.php" class="btn btn-outline-warning">Accéder</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
