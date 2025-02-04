<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'];
$query = "SELECT t.*, u.username 
          FROM tours t 
          LEFT JOIN users u ON t.created_by = u.id 
          WHERE t.id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$tour = $result->fetch_assoc();

$pageTitle = "View Tour Package";
$currentPage = "tours";
include '../includes/header.php';
?>

<div class="dashboard-container">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content p-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3><?php echo $tour['name']; ?></h3>
                <div>
                    <a href="edit_tour.php?id=<?php echo $tour['id']; ?>" class="btn btn-primary">Edit Tour</a>
                    <a href="tour-packages.php" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php if (!empty($tour['image'])): ?>
                            <img src="../../uploads/tours/<?php echo $tour['image']; ?>" 
                                 alt="<?php echo $tour['name']; ?>" 
                                 class="img-fluid rounded mb-3"
                                 style="max-height: 400px; width: 100%; object-fit: cover;">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <div class="tour-details">
                            <table class="table">
                                <tr>
                                    <th width="30%">Price:</th>
                                    <td>$<?php echo number_format($tour['price'], 2); ?></td>
                                </tr>
                                <tr>
                                    <th>Start Date:</th>
                                    <td><?php echo date('F d, Y', strtotime($tour['start_date'])); ?></td>
                                </tr>
                                <tr>
                                    <th>End Date:</th>
                                    <td><?php echo date('F d, Y', strtotime($tour['end_date'])); ?></td>
                                </tr>
                                <tr>
                                    <th>Duration:</th>
                                    <td>
                                        <?php
                                        $start = new DateTime($tour['start_date']);
                                        $end = new DateTime($tour['end_date']);
                                        echo $start->diff($end)->days . ' days';
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created By:</th>
                                    <td><?php echo $tour['username']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12">
                        <h4>Tour Description</h4>
                        <div class="p-3 bg-light rounded">
                            <?php echo nl2br(htmlspecialchars($tour['description'])); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
