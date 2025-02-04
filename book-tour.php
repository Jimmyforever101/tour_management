<?php
session_start();
require_once 'config/database.php';

$tour_id = $_GET['id'];

// Fetch tour details
$stmt = $conn->prepare("SELECT * FROM tours WHERE id = ?");
$stmt->bind_param("i", $tour_id);
$stmt->execute();
$tour = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    $number_of_travelers = $_POST['number_of_travelers'];
    $total_amount = $tour['price'] * $number_of_travelers;
    $booking_date = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, tour_id, number_of_travelers, total_amount, booking_date, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("iiids", $user_id, $tour_id, $number_of_travelers, $total_amount, $booking_date);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Booking successful! We will contact you shortly.";
        header('Location: bookings.php');
        exit();
    }
}

$pageTitle = "Book Tour";
include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="uploads/tours/<?php echo $tour['image']; ?>" 
                 class="img-fluid rounded" 
                 alt="<?php echo $tour['name']; ?>"
                 onerror="this.src='uploads/tours/default.jpg'">
        </div>
        <div class="col-md-6">
            <h2><?php echo $tour['name']; ?></h2>
            <p class="text-muted">
                <?php echo date('M d', strtotime($tour['start_date'])); ?> - 
                <?php echo date('M d, Y', strtotime($tour['end_date'])); ?>
            </p>
            <p><?php echo $tour['description']; ?></p>
            <h4 class="text-primary mb-4">$<?php echo number_format($tour['price'], 2); ?> per person</h4>

            <?php if(isset($_SESSION['user_id'])): ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Number of Travelers</label>
                        <input type="number" class="form-control" name="number_of_travelers" 
                               min="1" required onchange="updateTotal(this.value)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Amount</label>
                        <h3 id="totalAmount" class="text-success">$0.00</h3>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Book Now</button>
                </form>
            <?php else: ?>
                <div class="alert alert-info">
                    Please <a href="login.php">login</a> to book this tour.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function updateTotal(travelers) {
    const pricePerPerson = <?php echo $tour['price']; ?>;
    const total = travelers * pricePerPerson;
    document.getElementById('totalAmount').textContent = '$' + total.toFixed(2);
}
</script>

<?php include 'includes/footer.php'; ?>
