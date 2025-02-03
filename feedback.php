<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $tour_id = $_POST['tour_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    
    $query = "INSERT INTO feedback (user_id, tour_id, rating, comment, feedback_date) 
              VALUES (?, ?, ?, ?, CURDATE())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiis", $user_id, $tour_id, $rating, $comment);
    $stmt->execute();
}

$query = "SELECT f.*, u.username, t.name as tour_name 
          FROM feedback f 
          JOIN users u ON f.user_id = u.id 
          JOIN tours t ON f.tour_id = t.id 
          ORDER BY f.feedback_date DESC";
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
        <h2 class="text-center mb-4">Customer Feedback</h2>
        
        <?php if(isset($_SESSION['user_id'])): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Submit Your Feedback</h5>
                <form action="feedback.php" method="POST">
                    <div class="mb-3">
                        <label for="tour_id" class="form-label">Select Tour</label>
                        <select class="form-select" name="tour_id" required>
                            <?php
                            $tours = $conn->query("SELECT id, name FROM tours");
                            while($tour = $tours->fetch_assoc()) {
                                echo "<option value='{$tour['id']}'>{$tour['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="rating">
                            <?php for($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" name="rating" value="<?php echo $i; ?>" id="star<?php echo $i; ?>" required>
                            <label for="star<?php echo $i; ?>"><i class="fas fa-star"></i></label>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Your Comment</label>
                        <textarea class="form-control" name="comment" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <?php while($feedback = $result->fetch_assoc()): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $feedback['tour_name']; ?></h5>
                        <div class="stars mb-2">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?php echo $i <= $feedback['rating'] ? 'text-warning' : 'text-muted'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="card-text"><?php echo $feedback['comment']; ?></p>
                        <p class="card-text">
                            <small class="text-muted">
                                By <?php echo $feedback['username']; ?> on 
                                <?php echo date('M d, Y', strtotime($feedback['feedback_date'])); ?>
                            </small>
                        </p>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
