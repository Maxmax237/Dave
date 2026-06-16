<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon LMS - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }
        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .feature-icon {
            font-size: 2.5rem;
            color: #667eea;
        }
        .btn-primary {
            background: #667eea;
            border: none;
            padding: 12px 30px;
        }
        .btn-primary:hover {
            background: #5a67d8;
            transform: scale(1.05);
            transition: all 0.3s ease;
        }
        .footer {
            background: #2d3748;
            color: #a0aec0;
            padding: 40px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="#" style="color: #667eea;">Mon LMS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="SignIn.php">Connexion</a></li>
                <li class="nav-item"><a class="nav-link btn btn-primary text-white px-4 ms-2" href="Register.php">Inscription</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1>Compétences dont vous avez besoin pour un avenir réussi</h1>
                <p class="lead mt-3">Plateforme d'apprentissage en ligne moderne et interactive</p>
                <a href="Register.php" class="btn btn-light btn-lg mt-3 fw-bold text-primary">Commencer maintenant →</a>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-graduation-cap" style="font-size: 200px; opacity: 0.8;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<div class="container py-5">
    <h2 class="text-center mb-5 fw-bold">Nos Services</h2>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card card-hover h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-user-graduate feature-icon mb-3"></i>
                    <h5 class="card-title fw-bold">Étudiants</h5>
                    <p class="card-text text-muted">Inscrivez-vous et commencez à apprendre dès maintenant</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-hover h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-briefcase feature-icon mb-3"></i>
                    <h5 class="card-title fw-bold">Employeurs</h5>
                    <p class="card-text text-muted">Formez vos équipes avec des compétences de demain</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-hover h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-book feature-icon mb-3"></i>
                    <h5 class="card-title fw-bold">Cours</h5>
                    <p class="card-text text-muted">Accédez à des formations de haute qualité</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-hover h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-certificate feature-icon mb-3"></i>
                    <h5 class="card-title fw-bold">Certification</h5>
                    <p class="card-text text-muted">Obtenez vos certificats à la fin de chaque formation</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5 class="text-white">Mon LMS</h5>
                <p>Plateforme d'apprentissage en ligne</p>
            </div>
            <div class="col-md-4">
                <h5 class="text-white">Liens rapides</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none text-secondary">À propos</a></li>
                    <li><a href="#" class="text-decoration-none text-secondary">Contact</a></li>
                    <li><a href="#" class="text-decoration-none text-secondary">FAQ</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="text-white">Contact</h5>
                <p><i class="fas fa-envelope me-2"></i>ikenghengadavid@gmail.com</p>
                <p><i class="fas fa-phone me-2"></i>+237 692 03 09 89</p>
            </div>
        </div>
        <div class="text-center mt-3 pt-3 border-top border-secondary">
            <p>&copy; 2026 Mon LMS. Tous droits réservés.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
