<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Mon LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .login-card h2 {
            color: #2d3748;
            font-weight: 700;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            width: 100%;
        }
        .btn-login:hover {
            transform: scale(1.02);
            transition: all 0.3s ease;
        }
        .input-group-text {
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-radius: 10px 0 0 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="login-card">
                <div class="text-center mb-4">
                    <i class="fas fa-graduation-cap" style="font-size: 50px; color: #667eea;"></i>
                    <h2 class="mt-3">Bienvenue</h2>
                    <p class="text-muted">Connectez-vous à votre compte</p>
                </div>
                
                <form action="process_login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" placeholder="votre@email.com" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="••••••••" required>
                        </div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Se souvenir de moi</label>
                    </div>
                    
                    <button type="submit" class="btn-login">Se connecter</button>
                </form>
                
                <div class="text-center mt-3">
                    <p class="text-muted">Pas encore de compte ? <a href="Register.php" class="text-decoration-none fw-bold" style="color: #667eea;">S'inscrire</a></p>
                    <a href="#" class="text-decoration-none" style="color: #667eea;">Mot de passe oublié ?</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
