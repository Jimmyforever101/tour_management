<?php
require_once 'config/database.php';

// Update query to include image field
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
    
    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Available Tour Packages</h2>
        
        <div class="row">
    <?php while($tour = $result->fetch_assoc()): ?>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="tour-image" style="height: 200px; overflow: hidden;">
                <img src="uploads/tours/<?php echo $tour['image']; ?>" 
                     class="card-img-top" 
                     alt="<?php echo $tour['name']; ?>"
                     style="width: 100%; height: 100%; object-fit: cover;"
                     onerror="this.src='uploads/tours/default.jpg'">
            </div>
            <div class="card-body">
                <h5 class="card-title"><?php echo $tour['name']; ?></h5>
                <p class="card-text"><?php echo substr($tour['description'], 0, 100); ?>...</p>
                <p class="text-primary fw-bold">$<?php echo number_format($tour['price'], 2); ?></p>
                <p class="text-muted">
                    <i class="bi bi-calendar"></i>
                    <?php echo date('M d, Y', strtotime($tour['start_date'])); ?> -
                    <?php echo date('M d, Y', strtotime($tour['end_date'])); ?>
                </p>
                <a href="book-tour.php?id=<?php echo $tour['id']; ?>" class="btn btn-primary w-100">Book Now</a>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
