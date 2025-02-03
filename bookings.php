<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT b.*, t.name as tour_name, t.start_date, t.end_date 
          FROM bookings b 
          JOIN tours t ON b.tour_id = t.id 
          WHERE b.user_id = ? 
          ORDER BY b.booking_date DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - TourismPro</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">My Bookings</h2>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Tour Name</th>
                        <th>Travel Dates</th>
                        <th>Travelers</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($booking = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $booking['id']; ?></td>
                        <td><?php echo $booking['tour_name']; ?></td>
                        <td>
                            <?php echo date('M d, Y', strtotime($booking['start_date'])); ?> - 
                            <?php echo date('M d, Y', strtotime($booking['end_date'])); ?>
                        </td>
                        <td><?php echo $booking['number_of_travelers']; ?></td>
                        <td>$<?php echo $booking['total_amount']; ?></td>
                        <td><span class="badge bg-<?php echo $booking['status'] == 'confirmed' ? 'success' : ($booking['status'] == 'pending' ? 'warning' : 'danger'); ?>">
                            <?php echo ucfirst($booking['status']); ?>
                        </span></td>
                        <td>
                            <?php if($booking['status'] != 'cancelled'): ?>
                            <a href="cancel-booking.php?id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
