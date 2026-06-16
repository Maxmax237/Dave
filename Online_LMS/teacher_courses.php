<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'teacher') {
    header("Location: SignIn.php");
    exit();
}

require_once 'config.php';
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Ajouter un cours
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_course'])) {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    if (!empty($name) && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO courses (name, description, teacher, student_id) VALUES (?, ?, ?, 0)");
        $stmt->bind_param("sss", $name, $description, $_SESSION['user_name']);
        $stmt->execute();
        $success = "✅ Cours ajouté !";
    }
}

// Supprimer un cours
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM courses WHERE id = $id");
    $success = "✅ Cours supprimé !";
}

$courses = $conn->query("SELECT * FROM courses WHERE teacher = '" . $_SESSION['user_name'] . "' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Cours - Enseignant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="TeacherDash.php"><i class="fas fa-arrow-left me-2"></i>Retour</a>
            <span class="navbar-text text-white">👨‍🏫 <?php echo $_SESSION['user_name']; ?></span>
        </div>
    </nav>

    <div class="container mt-4">
        <h2><i class="fas fa-book me-2"></i>Mes Cours</h2>
        
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCourseModal">
            <i class="fas fa-plus me-1"></i>Ajouter un cours
        </button>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="row">
            <?php while ($course = $courses->fetch_assoc()): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5><?php echo htmlspecialchars($course['name']); ?></h5>
                            <p class="text-muted"><?php echo htmlspecialchars($course['description']); ?></p>
                            <a href="?delete=<?php echo $course['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addCourseModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header"><h5>Nouveau cours</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="mb-3"><input type="text" class="form-control" name="name" placeholder="Nom du cours" required></div>
                        <div class="mb-3"><textarea class="form-control" name="description" placeholder="Description" required></textarea></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="add_course" class="btn btn-success">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
