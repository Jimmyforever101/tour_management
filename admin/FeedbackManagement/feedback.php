<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

$pageTitle = "Feedback Management";
$currentPage = "feedback";

$query = "SELECT f.*, t.name as tour_name, 
          COALESCE(u.username, f.guest_name) as reviewer_name,
          COALESCE(u.email, f.guest_email) as reviewer_email
          FROM feedback f 
          LEFT JOIN users u ON f.user_id = u.id 
          JOIN tours t ON f.tour_id = t.id 
          ORDER BY f.feedback_date DESC";
$result = $conn->query($query);

include '../includes/header.php';
?>

<div class="dashboard-container">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content p-4">
        <div class="card">
            <div class="card-header">
                <h3>Feedback Management</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Reviewer</th>
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
                            <td>
                                <?php echo $feedback['reviewer_name']; ?><br>
                                <small class="text-muted"><?php echo $feedback['reviewer_email']; ?></small>
                            </td>
                            <td><?php echo $feedback['tour_name']; ?></td>
                            <td>
                                <?php 
                                for($i = 0; $i < $feedback['rating']; $i++) {
                                    echo "⭐";
                                }
                                ?>
                            </td>
                            <td><?php echo $feedback['comment']; ?></td>
                            <td><?php echo date('d M Y', strtotime($feedback['feedback_date'])); ?></td>
                            <td>
                                <a href="delete_feedback.php?id=<?php echo $feedback['id']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this feedback?')">
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
