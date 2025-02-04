<?php
session_start();
require_once '../config/database.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = "Dashboard";
$currentPage = "dashboard";

// Get counts from database
$userCount = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$bookingCount = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];
$tourCount = $conn->query("SELECT COUNT(*) as count FROM tours")->fetch_assoc()['count'];
$feedbackCount = $conn->query("SELECT COUNT(*) as count FROM feedback")->fetch_assoc()['count'];

include 'includes/header.php';
?>

<div class="dashboard-container">
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content p-4">
        <!-- Your existing dashboard content here -->


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
</div>

<?php include 'includes/footer.php'; ?>