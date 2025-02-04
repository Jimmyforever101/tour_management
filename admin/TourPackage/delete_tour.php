<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $tour_id = $_GET['id'];
    
    // Get image filename before deleting tour
    $stmt = $conn->prepare("SELECT image FROM tours WHERE id = ?");
    $stmt->bind_param("i", $tour_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tour = $result->fetch_assoc();
    
    // Delete the tour
    $stmt = $conn->prepare("DELETE FROM tours WHERE id = ?");
    $stmt->bind_param("i", $tour_id);
    
    if ($stmt->execute()) {
        // Delete associated image file if it exists
        if (!empty($tour['image'])) {
            $image_path = "../../uploads/tours/" . $tour['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        header('Location: tour-packages.php');
    } else {
        echo "Error deleting tour: " . $conn->error;
    }
}

header('Location: tour-packages.php');
exit();
