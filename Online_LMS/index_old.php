<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon LMS - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <!-- Navbar Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Mon LMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="SignIn.php">Connexion</a></li>
                    <li class="nav-item"><a class="nav-link" href="Register.php">Inscription</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-light py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold">Apprenez à votre rythme</h1>
                    <p class="lead">Plateforme d'apprentissage en ligne moderne et interactive</p>
                    <a href="Register.php" class="btn btn-primary btn-lg">Commencer maintenant</a>
                </div>
                <div class="col-lg-6">
                    <img src="https://via.placeholder.com/600x400" alt="Learning" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div class="container py-5">
        <h2 class="text-center mb-4">Nos Services</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-user-graduate fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Inscription</h5>
                        <p class="card-text">Créez votre compte en quelques clics</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-book fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Cours</h5>
                        <p class="card-text">Accédez à des cours de qualité</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-tasks fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">Devoirs</h5>
                        <p class="card-text">Soumettez vos devoirs en ligne</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2026 Mon LMS. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
