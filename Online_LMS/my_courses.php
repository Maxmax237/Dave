<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: SignIn.php");
    exit();
}

require_once 'config.php';
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Ajouter un nouveau cours
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_course'])) {
    $course_name = trim($_POST['course_name'] ?? '');
    $course_description = trim($_POST['course_description'] ?? '');
    $teacher_name = trim($_POST['teacher_name'] ?? '');
    
    if (!empty($course_name) && !empty($course_description)) {
        // Insérer dans la base (à adapter selon votre structure)
        $insert = $conn->prepare("INSERT INTO courses (name, description, teacher, student_id) VALUES (?, ?, ?, ?)");
        $insert->bind_param("sssi", $course_name, $course_description, $teacher_name, $_SESSION['user_id']);
        $insert->execute();
        $success = "✅ Cours ajouté avec succès !";
    } else {
        $error = "⚠️ Veuillez remplir tous les champs.";
    }
}

// Récupérer les cours de l'étudiant
$courses = [];
$result = $conn->query("SELECT * FROM courses WHERE student_id = " . $_SESSION['user_id'] . " ORDER BY created_at DESC");
if ($result && $result->num_rows > 0) {
    $courses = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Cours - Mon LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .course-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .btn-add-course {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }
        .btn-add-course:hover {
            transform: scale(1.05);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="StudentDash.php"><i class="fas fa-graduation-cap me-2"></i>Mon LMS</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><span class="navbar-text text-white">👋 <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Étudiant'); ?></span></li>
                    <li class="nav-item"><a class="nav-link text-white" href="SignOut.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-book text-primary me-2"></i>Mes Cours</h1>
            <div>
                <button class="btn btn-add-course me-2" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                    <i class="fas fa-plus me-1"></i>Ajouter un cours
                </button>
                <a href="StudentDash.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Retour</a>
            </div>
        </div>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="row g-4">
            <?php if (empty($courses)): ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                    <h3 class="text-muted">Aucun cours pour le moment</h3>
                    <p>Commencez par ajouter votre premier cours !</p>
                </div>
            <?php else: ?>
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-4">
                        <div class="card course-card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($course['name']); ?></h5>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($course['description']); ?></p>
                                <?php if (!empty($course['teacher'])): ?>
                                    <span class="badge bg-info"><i class="fas fa-user-tie me-1"></i><?php echo htmlspecialchars($course['teacher']); ?></span>
                                <?php endif; ?>
                                <span class="badge bg-success ms-2"><i class="fas fa-check-circle me-1"></i>En cours</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Ajout de cours -->
    <div class="modal fade" id="addCourseModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Ajouter un nouveau cours</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nom du cours *</label>
                            <input type="text" class="form-control" name="course_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description *</label>
                            <textarea class="form-control" name="course_description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Enseignant (facultatif)</label>
                            <input type="text" class="form-control" name="teacher_name" placeholder="Nom de l'enseignant">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="add_course" class="btn btn-primary">Ajouter le cours</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
