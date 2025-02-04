<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $tour_id = $_POST['tour_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $feedback_date = date('Y-m-d');
    
    $stmt = $conn->prepare("INSERT INTO feedback (tour_id, rating, comment, feedback_date, guest_name, guest_email) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $tour_id, $rating, $comment, $feedback_date, $name, $email);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Thank you for your feedback!";
    }
}

// Fetch all feedbacks
$query = "SELECT f.*, t.name as tour_name, 
          COALESCE(u.username, f.guest_name) as reviewer_name 
          FROM feedback f 
          LEFT JOIN users u ON f.user_id = u.id 
          JOIN tours t ON f.tour_id = t.id 
          ORDER BY f.feedback_date DESC";
$result = $conn->query($query);

$pageTitle = "Customer Feedback";
include 'includes/header.php';
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Customer Feedback</h2>
    
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php 
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Share Your Experience</h5>
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Your Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Your Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Select Tour Package</label>
                    <select class="form-select" name="tour_id" required>
                        <option value="">Choose a tour package...</option>
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
                    <div class="rating-stars">
                        <?php for($i = 5; $i >= 1; $i--): ?>
                        <input type="radio" name="rating" value="<?php echo $i; ?>" id="star<?php echo $i; ?>" required>
                        <label for="star<?php echo $i; ?>">★</label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Your Comment</label>
                    <textarea class="form-control" name="comment" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit Feedback</button>
            </form>
        </div>
    </div>

    <h3 class="mb-4">Recent Feedback</h3>
    <div class="row">
        <?php while($feedback = $result->fetch_assoc()): ?>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($feedback['tour_name']); ?></h5>
                    <div class="stars mb-2">
                        <?php 
                        for($i = 1; $i <= 5; $i++) {
                            echo '<span class="' . ($i <= $feedback['rating'] ? 'text-warning' : 'text-muted') . '">★</span>';
                        }
                        ?>
                    </div>
                    <p class="card-text"><?php echo htmlspecialchars($feedback['comment']); ?></p>
                    <p class="card-text">
                        <small class="text-muted">
                            By <?php echo htmlspecialchars($feedback['reviewer_name']); ?> on
                            <?php echo date('M d, Y', strtotime($feedback['feedback_date'])); ?>
                        </small>
                    </p>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<style>
.rating-stars {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.rating-stars input {
    display: none;
}

.rating-stars label {
    cursor: pointer;
    font-size: 25px;
    color: #ddd;
    padding: 5px;
}

.rating-stars input:checked ~ label {
    color: #ffd700;
}

.rating-stars label:hover,
.rating-stars label:hover ~ label {
    color: #ffd700;
}
</style>

<?php include 'includes/footer.php'; ?>
