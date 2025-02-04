<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

$pageTitle = "Tour Package Management";
$currentPage = "tours";

$query = "SELECT t.*, u.username 
          FROM tours t 
          LEFT JOIN users u ON t.created_by = u.id 
          ORDER BY t.id DESC";
$result = $conn->query($query);

include '../includes/header.php';
?>

<div class="dashboard-container">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Tour Package Management</h2>
            <a href="add_tour.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Tour
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Created By</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($tour = $result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?php
                                    $imagePath = "../../uploads/tours/" . $tour['image'];
                                    if (!empty($tour['image']) && file_exists($imagePath)) {
                                        echo "<img src='{$imagePath}' alt='{$tour['name']}' style='width: 50px; height: 50px; object-fit: cover;'>";
                                    } else {
                                        echo "<img src='../../assets/images/default-tour.jpg' alt='Default' style='width: 50px; height: 50px; object-fit: cover;'>";
                                    }
                                    ?>
                                </td>

                                <td><?php echo $tour['name']; ?></td>
                                <td>$<?php echo number_format($tour['price'], 2); ?></td>
                                <td>
                                    <?php
                                    $start = new DateTime($tour['start_date']);
                                    $end = new DateTime($tour['end_date']);
                                    echo $start->diff($end)->days . ' days';
                                    ?>
                                </td>
                                <td><?php echo $tour['username']; ?></td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <a href="view_tour.php?id=<?php echo $tour['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="edit_tour.php?id=<?php echo $tour['id']; ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="delete_tour.php?id=<?php echo $tour['id']; ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this tour?')">
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