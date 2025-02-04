<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'];

// Fetch existing tour data
$query = "SELECT * FROM tours WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$tour = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    
    // Handle image upload
    $image = $tour['image']; // Keep existing image by default
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        // Delete old image
        if (!empty($tour['image'])) {
            $old_image_path = "../../uploads/tours/" . $tour['image'];
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }
        
        // Upload new image
        $upload_dir = '../../uploads/tours/';
        $image = uniqid() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image);
    }

    $stmt = $conn->prepare("UPDATE tours SET name=?, description=?, price=?, start_date=?, end_date=?, image=? WHERE id=?");
    $stmt->bind_param("ssdsssi", $name, $description, $price, $start_date, $end_date, $image, $id);
    

    if ($stmt->execute()) {
        header('Location: tour-packages.php');
        exit();
    }
}

$pageTitle = "Edit Tour Package";
$currentPage = "tours";
include '../includes/header.php';
?>

<div class="dashboard-container">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content p-4">
        <div class="card">
            <div class="card-header">
                <h3>Edit Tour Package</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div>
                            <?php if (!empty($tour['image'])): ?>
                                <img src="../../uploads/tours/<?php echo $tour['image']; ?>" 
                                     alt="Current Image" 
                                     style="max-width: 200px; height: auto;">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Image (leave empty to keep current)</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tour Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $tour['name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" step="0.01" value="<?php echo $tour['price']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" value="<?php echo $tour['start_date']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" value="<?php echo $tour['end_date']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="4" required><?php echo $tour['description']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Tour</button>
                        <a href="tour-packages.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
