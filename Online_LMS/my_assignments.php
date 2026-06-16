<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: SignIn.php");
    exit();
}

require_once 'config.php';
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Ajouter un nouveau devoir
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_assignment'])) {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $deadline = trim($_POST['deadline'] ?? '');
    $teacher = trim($_POST['teacher'] ?? '');
    
    if (!empty($title) && !empty($description) && !empty($deadline)) {
        $insert = $conn->prepare("INSERT INTO assignments (student_id, title, description, deadline, teacher, status, created_at) VALUES (?, ?, ?, ?, ?, 'pending', NOW())");
        $insert->bind_param("issss", $_SESSION['user_id'], $title, $description, $deadline, $teacher);
        $insert->execute();
        $success = "✅ Devoir ajouté avec succès !";
    } else {
        $error = "⚠️ Veuillez remplir tous les champs.";
    }
}

// Récupérer les devoirs de l'étudiant
$assignments = [];
$result = $conn->query("SELECT * FROM assignments WHERE student_id = " . $_SESSION['user_id'] . " ORDER BY created_at DESC");
if ($result && $result->num_rows > 0) {
    $assignments = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Devoirs - Mon LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .assignment-card {
            transition: transform 0.3s ease;
        }
        .assignment-card:hover {
            transform: translateY(-3px);
        }
        .status-pending { background-color: #ffc107; color: #856404; }
        .status-submitted { background-color: #28a745; color: white; }
        .status-graded { background-color: #17a2b8; color: white; }
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
            <h1><i class="fas fa-tasks text-primary me-2"></i>Mes Devoirs</h1>
            <div>
                <button class="btn btn-add-course me-2" data-bs-toggle="modal" data-bs-target="#addAssignmentModal" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; border: none;">
                    <i class="fas fa-plus me-1"></i>Ajouter un devoir
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
            <?php if (empty($assignments)): ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                    <h3 class="text-muted">Aucun devoir pour le moment</h3>
                    <p>Créez votre premier devoir à soumettre à votre enseignant !</p>
                </div>
            <?php else: ?>
                <?php foreach ($assignments as $assignment): 
                    $statusClass = '';
                    $statusText = '';
                    switch($assignment['status']) {
                        case 'pending':
                            $statusClass = 'status-pending';
                            $statusText = 'En attente';
                            break;
                        case 'submitted':
                            $statusClass = 'status-submitted';
                            $statusText = 'Soumis';
                            break;
                        case 'graded':
                            $statusClass = 'status-graded';
                            $statusText = 'Noté';
                            break;
                        default:
                            $statusClass = 'status-pending';
                            $statusText = 'En attente';
                    }
                ?>
                    <div class="col-md-6">
                        <div class="card assignment-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="card-title"><?php echo htmlspecialchars($assignment['title']); ?></h5>
                                    <span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                </div>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($assignment['description']); ?></p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <?php if (!empty($assignment['teacher'])): ?>
                                            <small class="text-muted"><i class="fas fa-user-tie me-1"></i><?php echo htmlspecialchars($assignment['teacher']); ?></small>
                                        <?php endif; ?>
                                        <small class="text-muted ms-2"><i class="far fa-calendar-alt me-1"></i>📅 <?php echo date('d/m/Y', strtotime($assignment['deadline'])); ?></small>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Ajout de devoir -->
    <div class="modal fade" id="addAssignmentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Ajouter un nouveau devoir</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Titre du devoir *</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description *</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Enseignant (facultatif)</label>
                            <input type="text" class="form-control" name="teacher" placeholder="Nom de l'enseignant">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date limite *</label>
                            <input type="date" class="form-control" name="deadline" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="add_assignment" class="btn btn-success">Ajouter le devoir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
