<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Check if user exists
    $check_stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $user = $check_stmt->get_result()->fetch_assoc();
    
    // Don't allow deleting the last admin
    if ($user['role'] == 'admin') {
        $admin_count = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'")->fetch_assoc()['count'];
        if ($admin_count <= 1) {
            $_SESSION['error'] = "Cannot delete the last admin user";
            header('Location: users.php');
            exit();
        }
    }
    
    // Delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "User deleted successfully";
    } else {
        $_SESSION['error'] = "Error deleting user";
    }
}

header('Location: users.php');
exit();
