<?php
session_start();
require_once '../config/database.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Get counts from database
$userCount = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$bookingCount = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];
$tourCount = $conn->query("SELECT COUNT(*) as count FROM tours")->fetch_assoc()['count'];
$feedbackCount = $conn->query("SELECT COUNT(*) as count FROM feedback")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TourismPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            padding-top: 20px;
        }
        .main-content {
            flex: 1;
            background: #f8f9fa;
        }
        .nav-link {
            color: rgba(255,255,255,.8);
            padding: 15px 20px;
        }
        .nav-link:hover {
            color: white;
            background: rgba(255,255,255,.1);
        }
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h4 class="text-center mb-4">Admin Panel</h4>
            <nav class="nav flex-column">
                <a class="nav-link active" href="dashboard.php">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a class="nav-link" href="users.php">
                    <i class="bi bi-people"></i> Users
                </a>
                <a class="nav-link" href="bookings.php">
                    <i class="bi bi-calendar-check"></i> Bookings
                </a>
                <a class="nav-link" href="tour-packages.php">
                    <i class="bi bi-map"></i> Tour Packages
                </a>
                <a class="nav-link" href="feedback.php">
                    <i class="bi bi-chat-dots"></i> Feedback
                </a>
                <a class="nav-link" href="logout.php">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content p-4">
            <h2 class="mb-4">Dashboard Overview</h2>
            
            <div class="row">
                <!-- Users Stats -->
                <div class="col-md-3 mb-4">
                    <div class="stat-card">
                        <h3 class="fs-2 mb-3 text-primary"><?php echo $userCount; ?></h3>
                        <p class="text-muted mb-0">Total Users</p>
                    </div>
                </div>

                <!-- Bookings Stats -->
                <div class="col-md-3 mb-4">
                    <div class="stat-card">
                        <h3 class="fs-2 mb-3 text-success"><?php echo $bookingCount; ?></h3>
                        <p class="text-muted mb-0">Total Bookings</p>
                    </div>
                </div>

                <!-- Tours Stats -->
                <div class="col-md-3 mb-4">
                    <div class="stat-card">
                        <h3 class="fs-2 mb-3 text-info"><?php echo $tourCount; ?></h3>
                        <p class="text-muted mb-0">Tour Packages</p>
                    </div>
                </div>

                <!-- Feedback Stats -->
                <div class="col-md-3 mb-4">
                    <div class="stat-card">
                        <h3 class="fs-2 mb-3 text-warning"><?php echo $feedbackCount; ?></h3>
                        <p class="text-muted mb-0">Total Feedback</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activities Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Recent Activities</h5>
                        </div>
                        <div class="card-body">
                            <!-- Add your recent activities content here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
