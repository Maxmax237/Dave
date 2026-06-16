<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: SignIn.php");
    exit();
}

require_once 'config.php';
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Récupérer les données de progression pour le graphique
// Exemple de données statiques (à remplacer par vos données réelles)
$days = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
$hours = [2.5, 3.0, 1.5, 4.0, 2.0, 0.5, 1.0];
$weekly_total = array_sum($hours);
$daily_average = round($weekly_total / 7, 1);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Progression - Mon LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
        }
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
        }
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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
            <h1><i class="fas fa-chart-line text-primary me-2"></i>Ma Progression</h1>
            <a href="StudentDash.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Retour</a>
        </div>

        <!-- Statistiques -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-clock fa-2x text-primary mb-2"></i>
                    <div class="stat-number"><?php echo $weekly_total; ?>h</div>
                    <p class="text-muted">Temps total cette semaine</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-calendar-day fa-2x text-success mb-2"></i>
                    <div class="stat-number"><?php echo $daily_average; ?>h</div>
                    <p class="text-muted">Moyenne par jour</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-fire fa-2x text-warning mb-2"></i>
                    <div class="stat-number">5</div>
                    <p class="text-muted">Jours actifs</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-trophy fa-2x text-danger mb-2"></i>
                    <div class="stat-number">3</div>
                    <p class="text-muted">Objectifs atteints</p>
                </div>
            </div>
        </div>

        <!-- Graphique d'effort -->
        <div class="row g-4">
            <div class="col-md-8">
                <div class="chart-container">
                    <h5 class="mb-3"><i class="fas fa-chart-bar me-2"></i>Temps d'étude par jour (heures)</h5>
                    <canvas id="effortChart"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-container">
                    <h5 class="mb-3"><i class="fas fa-percent me-2"></i>Effort par jour</h5>
                    <canvas id="doughnutChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Détail des efforts -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="chart-container">
                    <h5 class="mb-3"><i class="fas fa-list me-2"></i>Détail des efforts quotidiens</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Jour</th>
                                    <th>Temps étudié</th>
                                    <th>Niveau d'effort</th>
                                    <th>Objectif</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $efforts = [
                                    ['Lundi', 2.5, 'bon', '✅ Atteint'],
                                    ['Mardi', 3.0, 'excellent', '✅ Atteint'],
                                    ['Mercredi', 1.5, 'moyen', '❌ Non atteint'],
                                    ['Jeudi', 4.0, 'excellent', '✅ Atteint'],
                                    ['Vendredi', 2.0, 'bon', '✅ Atteint'],
                                    ['Samedi', 0.5, 'faible', '❌ Non atteint'],
                                    ['Dimanche', 1.0, 'faible', '❌ Non atteint']
                                ];
                                foreach ($efforts as $effort):
                                    $badgeClass = $effort[1] >= 3 ? 'success' : ($effort[1] >= 2 ? 'warning' : 'danger');
                                ?>
                                    <tr>
                                        <td><?php echo $effort[0]; ?></td>
                                        <td><?php echo $effort[1]; ?> heures</td>
                                        <td><span class="badge bg-<?php echo $badgeClass; ?>"><?php echo $effort[2]; ?></span></td>
                                        <td><?php echo $effort[3]; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Graphique en barres
        const ctx = document.getElementById('effortChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($days); ?>,
                datasets: [{
                    label: 'Heures d\'étude',
                    data: <?php echo json_encode($hours); ?>,
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.7)',
                        'rgba(72, 187, 120, 0.7)',
                        'rgba(237, 137, 54, 0.7)',
                        'rgba(66, 153, 225, 0.7)',
                        'rgba(159, 122, 234, 0.7)',
                        'rgba(245, 101, 101, 0.7)',
                        'rgba(113, 128, 150, 0.7)'
                    ],
                    borderColor: [
                        '#667eea', '#48bb78', '#ed8936', '#4299e1', '#9f7aea', '#f56565', '#718096'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' heures';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + 'h';
                            }
                        }
                    }
                }
            }
        });

        // Graphique en camembert (effort)
        const ctx2 = document.getElementById('doughnutChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Excellent (3h+)', 'Bon (2-3h)', 'Moyen (1-2h)', 'Faible (<1h)'],
                datasets: [{
                    data: [2, 2, 1, 2],
                    backgroundColor: ['#48bb78', '#4299e1', '#ed8936', '#f56565'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
