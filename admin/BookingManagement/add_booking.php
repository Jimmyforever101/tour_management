<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $tour_id = $_POST['tour_id'];
    $number_of_travelers = $_POST['number_of_travelers'];
    $booking_date = date('Y-m-d');
    
    // Get tour price
    $tour_query = $conn->prepare("SELECT price FROM tours WHERE id = ?");
    $tour_query->bind_param("i", $tour_id);
    $tour_query->execute();
    $tour_price = $tour_query->get_result()->fetch_assoc()['price'];
    
    // Calculate total amount
    $total_amount = $tour_price * $number_of_travelers;
    
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, tour_id, number_of_travelers, total_amount, booking_date, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("iiids", $user_id, $tour_id, $number_of_travelers, $total_amount, $booking_date);

    if ($stmt->execute()) {
        header('Location: bookings.php');
        exit();
    }
}

$pageTitle = "Add New Booking";
$currentPage = "bookings";
include '../includes/header.php';
?>

<div class="dashboard-container">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content p-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Booking</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Select Customer</label>
                        <select class="form-select" name="user_id" required>
                            <?php
                            $users = $conn->query("SELECT id, username FROM users WHERE role = 'customer'");
                            while($user = $users->fetch_assoc()) {
                                echo "<option value='{$user['id']}'>{$user['username']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Tour Package</label>
                        <select class="form-select" name="tour_id" required>
                            <?php
                            $tours = $conn->query("SELECT id, name, price FROM tours");
                            while($tour = $tours->fetch_assoc()) {
                                echo "<option value='{$tour['id']}'>{$tour['name']} - ${$tour['price']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Number of Travelers</label>
                        <input type="number" class="form-control" name="number_of_travelers" min="1" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Create Booking</button>
                        <a href="bookings.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
