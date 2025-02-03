<?php
require_once 'config/database.php';

$query = "SELECT * FROM tours WHERE start_date >= CURDATE() ORDER BY start_date";
$result = $conn->query($query);
?>

<?php
$cssPath = "css/style.css";
$version = filemtime($cssPath); // Gets file modification time for cache busting
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourism Management System</title>
    <link rel="stylesheet" href="<?php echo $cssPath . '?v=' . $version; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">TourismPro</a>
            <nav class="navbar-nav me-auto">
                <a class="nav-link" href="index.php">Home</a>
                <a class="nav-link" href="tour-packages.php">Tour Packages</a>
                <a class="nav-link" href="bookings.php">Bookings</a>
                <a class="nav-link" href="feedback.php">Feedback</a>
            </nav>
            <div class="auth-buttons">
                <a href="login.php" class="btn btn-outline-light me-2">Sign In</a>
                <a href="admin/login.php" class="btn btn-primary">Admin Login</a>
            </div>
        </div>
    </header>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Available Tour Packages</h2>
        
        <div class="row">
            <?php while($tour = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/tours/<?php echo $tour['id']; ?>.jpg" class="card-img-top" alt="<?php echo $tour['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $tour['name']; ?></h5>
                        <p class="card-text"><?php echo substr($tour['description'], 0, 100); ?>...</p>
                        <p class="text-primary">$<?php echo $tour['price']; ?></p>
                        <p class="text-muted">
                            <?php echo date('M d, Y', strtotime($tour['start_date'])); ?> - 
                            <?php echo date('M d, Y', strtotime($tour['end_date'])); ?>
                        </p>
                        <a href="book-tour.php?id=<?php echo $tour['id']; ?>" class="btn btn-primary">Book Now</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
