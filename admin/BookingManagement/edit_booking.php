<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number_of_travelers = $_POST['number_of_travelers'];
    $status = $_POST['status'];
    
    // Get tour price
    $booking_query = $conn->prepare("SELECT tour_id FROM bookings WHERE id = ?");
    $booking_query->bind_param("i", $id);
    $booking_query->execute();
    $tour_id = $booking_query->get_result()->fetch_assoc()['tour_id'];
    
    $tour_query = $conn->prepare("SELECT price FROM tours WHERE id = ?");
    $tour_query->bind_param("i", $tour_id);
    $tour_query->execute();
    $tour_price = $tour_query->get_result()->fetch_assoc()['price'];
    
    // Calculate new total
    $total_amount = $tour_price * $number_of_travelers;
    
    $stmt = $conn->prepare("UPDATE bookings SET number_of_travelers=?, total_amount=?, status=? WHERE id=?");
    $stmt->bind_param("idsi", $number_of_travelers, $total_amount, $status, $id);

    if ($stmt->execute()) {
        header('Location: bookings.php');
        exit();
    }
}

$stmt = $conn->prepare("SELECT b.*, u.username, t.name as tour_name, t.price 
                       FROM bookings b 
                       JOIN users u ON b.user_id = u.id 
                       JOIN tours t ON b.tour_id = t.id 
                       WHERE b.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

$pageTitle = "Edit Booking";
$currentPage = "bookings";
include '../includes/header.php';
?>

<div class="dashboard-container">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content p-4">
        <div class="card">
            <div class="card-header">
                <h3>Edit Booking #<?php echo $booking['id']; ?></h3>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Customer</label>
                        <input type="text" class="form-control" value="<?php echo $booking['username']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tour Package</label>
                        <input type="text" class="form-control" value="<?php echo $booking['tour_name']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Number of Travelers</label>
                        <input type="number" class="form-control" name="number_of_travelers" 
                               value="<?php echo $booking['number_of_travelers']; ?>" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="pending" <?php echo $booking['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="confirmed" <?php echo $booking['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                            <option value="cancelled" <?php echo $booking['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Booking</button>
                        <a href="bookings.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
