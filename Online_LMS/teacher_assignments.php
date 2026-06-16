<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'teacher') {
    header("Location: SignIn.php");
    exit();
}

require_once 'config.php';
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Ajouter un devoir
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_assignment'])) {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $deadline = trim($_POST['deadline'] ?? '');
    
    if (!empty($title) && !empty($description) && !empty($deadline)) {
        $stmt = $conn->prepare("INSERT INTO assignments (student_id, title, description, deadline, teacher, status) VALUES (0, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("ssss", $title, $description, $deadline, $_SESSION['user_name']);
        $stmt->execute();
        $success = "✅ Devoir créé !";
    }
}

// Corriger un devoir
if (isset($_GET['grade'])) {
    $id = intval($_GET['grade']);
    $grade = trim($_GET['note'] ?? '');
    if (!empty($grade)) {
        $conn->query("UPDATE assignments SET status = 'graded', grade = '$grade' WHERE id = $id");
        $success = "✅ Devoir noté !";
    }
}

$assignments = $conn->query("SELECT * FROM assignments WHERE teacher = '" . $_SESSION['user_name'] . "' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Devoirs - Enseignant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="TeacherDash.php"><i class="fas fa-arrow-left me-2"></i>Retour</a>
            <span class="navbar-text text-white">👨‍🏫 <?php echo $_SESSION['user_name']; ?></span>
        </div>
    </nav>

    <div class="container mt-4">
        <h2><i class="fas fa-tasks me-2"></i>Devoirs</h2>
        
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAssignmentModal">
            <i class="fas fa-plus me-1"></i>Créer un devoir
        </button>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>Titre</th><th>Description</th><th>Étudiant</th><th>Statut</th><th>Note</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php while ($ass = $assignments->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ass['title']); ?></td>
                            <td><?php echo htmlspecialchars($ass['description']); ?></td>
                            <td><?php echo $ass['student_id'] ? 'Étudiant #' . $ass['student_id'] : 'Non attribué'; ?></td>
                            <td>
                                <span class="badge bg-<?php echo $ass['status'] == 'pending' ? 'warning' : ($ass['status'] == 'submitted' ? 'info' : 'success'); ?>">
                                    <?php echo $ass['status']; ?>
                                </span>
                            </td>
                            <td><?php echo $ass['grade'] ?? '-'; ?></td>
                            <td>
                                <?php if ($ass['status'] == 'submitted'): ?>
                                    <div class="d-flex gap-1">
                                        <input type="number" id="grade_<?php echo $ass['id']; ?>" class="form-control form-control-sm" style="width:70px;" placeholder="Note">
                                        <a href="?grade=<?php echo $ass['id']; ?>&note=" class="btn btn-success btn-sm" onclick="this.href += document.getElementById('grade_<?php echo $ass['id']; ?>').value">Noter</a>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addAssignmentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header"><h5>Nouveau devoir</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="mb-3"><input type="text" class="form-control" name="title" placeholder="Titre" required></div>
                        <div class="mb-3"><textarea class="form-control" name="description" placeholder="Description" required></textarea></div>
                        <div class="mb-3"><input type="date" class="form-control" name="deadline" required></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="add_assignment" class="btn btn-primary">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
