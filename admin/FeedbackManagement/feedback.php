
<?php
session_start();
require_once '../config/database.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = "Feedback Management";
$currentPage = "feedback";

// Fetch all feedback with user and tour details
$query = "SELECT f.*, u.username, t.name as tour_name 
          FROM feedback f 
          JOIN users u ON f.user_id = u.id 
          JOIN tours t ON f.tour_id = t.id 
          ORDER BY f.feedback_date DESC";
$result = $conn->query($query);

include '../includes/header.php';
?>

<div class="dashboard-container">
    <?php include '../includes/sidebar.php'; ?>

    <div class="main-content p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Feedback Management</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Tour Package</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($feedback = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $feedback['id']; ?></td>
                            <td><?php echo $feedback['username']; ?></td>
                            <td><?php echo $feedback['tour_name']; ?></td>
                            <td>
                                <div class="text-warning">
                                    <?php 
                                    for($i = 1; $i <= 5; $i++) {
                                        echo $i <= $feedback['rating'] ? 
                                            '<i class="bi bi-star-fill"></i>' : 
                                            '<i class="bi bi-star"></i>';
                                    }
                                    ?>
                                </div>
                            </td>
                            <td>
                                <?php 
                                $comment = $feedback['comment'];
                                echo strlen($comment) > 50 ? substr($comment, 0, 50) . '...' : $comment;
                                ?>
                            </td>
                            <td><?php echo date('d M Y', strtotime($feedback['feedback_date'])); ?></td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="viewFeedback(<?php echo $feedback['id']; ?>)">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteFeedback(<?php echo $feedback['id']; ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- View Feedback Modal -->
<div class="modal fade" id="viewFeedbackModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Feedback Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="feedbackDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function viewFeedback(id) {
        // Implement view feedback details functionality
    }

    function deleteFeedback(id) {
        if(confirm('Are you sure you want to delete this feedback?')) {
            // Implement delete feedback functionality
        }
    }
</script>
</body>
</html>
