<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'employer') {
    header("Location: SignIn.php");
    exit();
}

require_once 'config.php';
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Statistiques
$total_users = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$total_courses = $conn->query("SELECT COUNT(*) FROM courses")->fetch_row()[0];
$total_assignments = $conn->query("SELECT COUNT(*) FROM assignments")->fetch_row()[0];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="AdminDash.php"><i class="fas fa-arrow-left me-2"></i>Retour</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2><i class="fas fa-chart-bar me-2"></i>Rapports</h2>
        
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h3><?php echo $total_users; ?></h3>
                        <p>Utilisateurs</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h3><?php echo $total_courses; ?></h3>
                        <p>Cours</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h3><?php echo $total_assignments; ?></h3>
                        <p>Devoirs</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <canvas id="usersChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        new Chart(document.getElementById('usersChart'), {
            type: 'doughnut',
            data: {
                labels: ['Étudiants', 'Enseignants', 'Employeurs'],
                datasets: [{
                    data: [
                        <?php echo $conn->query("SELECT COUNT(*) FROM users WHERE user_type = 'student'")->fetch_row()[0]; ?>,
                        <?php echo $conn->query("SELECT COUNT(*) FROM users WHERE user_type = 'teacher'")->fetch_row()[0]; ?>,
                        <?php echo $conn->query("SELECT COUNT(*) FROM users WHERE user_type = 'employer'")->fetch_row()[0]; ?>
                    ],
                    backgroundColor: ['#4299e1', '#48bb78', '#f56565']
                }]
            }
        });

        new Chart(document.getElementById('activityChart'), {
            type: 'bar',
            data: {
                labels: ['Cours', 'Devoirs'],
                datasets: [{
                    label: 'Total',
                    data: [<?php echo $total_courses; ?>, <?php echo $total_assignments; ?>],
                    backgroundColor: ['#ed8936', '#9f7aea']
                }]
            },
            options: { responsive: true }
        });
    </script>
</body>
</html>
