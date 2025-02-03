<?php
session_start();
require_once '../config/database.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = "Booking Management";
$currentPage = "bookings";

// Handle booking status updates
if (isset($_GET['update_status'])) {
    $booking_id = $_GET['booking_id'];
    $status = $_GET['status'];
    $conn->query("UPDATE bookings SET status = '$status' WHERE id = $booking_id");
    header('Location: bookings.php');
    exit();
}

// Fetch all bookings with user and tour details
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
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookingModal">
                <i class="bi bi-plus-circle"></i> Add New Booking
            </button>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
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
                            <td>$<?php echo $booking['total_amount']; ?></td>
                            <td><?php echo date('d M Y', strtotime($booking['booking_date'])); ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-<?php 
                                        echo $booking['status'] == 'confirmed' ? 'success' : 
                                            ($booking['status'] == 'pending' ? 'warning' : 'danger'); 
                                        ?> dropdown-toggle" data-bs-toggle="dropdown">
                                        <?php echo ucfirst($booking['status']); ?>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="?update_status=1&booking_id=<?php echo $booking['id']; ?>&status=pending">Pending</a></li>
                                        <li><a class="dropdown-item" href="?update_status=1&booking_id=<?php echo $booking['id']; ?>&status=confirmed">Confirmed</a></li>
                                        <li><a class="dropdown-item" href="?update_status=1&booking_id=<?php echo $booking['id']; ?>&status=cancelled">Cancelled</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <a href="view_booking.php?id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="bookings.php?delete=<?php echo $booking['id']; ?>" class="btn btn-sm btn-danger" 
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

<!-- Add Booking Modal -->
<div class="modal fade" id="addBookingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addBookingForm">
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
                        <input type="number" class="form-control" name="travelers" min="1" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveBooking()">Create Booking</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function saveBooking() {
        // Implement save booking functionality
    }
</script>
</body>
</html>
