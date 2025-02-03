<?php
require_once '../config/database.php';

$username = 'admin';
$password = password_hash('zxczxc', PASSWORD_DEFAULT);
$email = 'admin@gmail.com';
$role = 'admin';

$stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $password, $email, $role);

if ($stmt->execute()) {
    echo "Admin user created successfully!";
} else {
    echo "Error creating admin user: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
