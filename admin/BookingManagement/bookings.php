<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

$pageTitle = "Booking Management";
$currentPage = "bookings";

$query = "SELECT b.*, u.username, t.name as tour_name, t.price 
          FROM bookings b 
          JOIN users u ON b.user_id = u.id 
          JOIN tours t ON b.tour_id = t.id 
          ORDER BY b.booking_date DESC";
$result = $conn->query($query);

include '../includes/header.php';
?>

<div class="dashboard-container">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Booking Management</h2>
            <a href="add_booking.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Booking
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Tour Package</th>
                            <th>Travelers</th>
                            <th>Total Amount</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($booking = $result->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $booking['id']; ?></td>
                            <td><?php echo $booking['username']; ?></td>
                            <td><?php echo $booking['tour_name']; ?></td>
                            <td><?php echo $booking['number_of_travelers']; ?></td>
                            <td>$<?php echo number_format($booking['total_amount'], 2); ?></td>
                            <td><?php echo date('d M Y', strtotime($booking['booking_date'])); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo $booking['status'] == 'confirmed' ? 'success' : 
                                        ($booking['status'] == 'pending' ? 'warning' : 'danger'); 
                                ?>">
                                    <?php echo ucfirst($booking['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="view_booking.php?id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="edit_booking.php?id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="delete_booking.php?id=<?php echo $booking['id']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this booking?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
