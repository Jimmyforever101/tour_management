<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT b.*, u.username, u.email, t.name as tour_name, t.price 
                       FROM bookings b 
                       JOIN users u ON b.user_id = u.id 
                       JOIN tours t ON b.tour_id = t.id 
                       WHERE b.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

$pageTitle = "View Booking";
$currentPage = "bookings";
include '../includes/header.php';
?>

<div class="dashboard-container">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content p-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Booking Details #<?php echo $booking['id']; ?></h3>
                <div>
                    <a href="edit_booking.php?id=<?php echo $booking['id']; ?>" class="btn btn-primary">Edit Booking</a>
                    <a href="bookings.php" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Customer Information</h4>
                        <table class="table">
                            <tr>
                                <th>Name:</th>
                                <td><?php echo $booking['username']; ?></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?php echo $booking['email']; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4>Booking Information</h4>
                        <table class="table">
                            <tr>
                                <th>Tour Package:</th>
                                <td><?php echo $booking['tour_name']; ?></td>
                            </tr>
                            <tr>
                                <th>Number of Travelers:</th>
                                <td><?php echo $booking['number_of_travelers']; ?></td>
                            </tr>
                            <tr>
                                <th>Price per Person:</th>
                                <td>$<?php echo number_format($booking['price'], 2); ?></td>
                            </tr>
                            <tr>
                                <th>Total Amount:</th>
                                <td>$<?php echo number_format($booking['total_amount'], 2); ?></td>
                            </tr>
                            <tr>
                                <th>Booking Date:</th>
                                <td><?php echo date('F d, Y', strtotime($booking['booking_date'])); ?></td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $booking['status'] == 'confirmed' ? 'success' : 
                                            ($booking['status'] == 'pending' ? 'warning' : 'danger'); 
                                    ?>">
                                        <?php echo ucfirst($booking['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
