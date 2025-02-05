<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                header('Location: home.php');
                exit();
            }
        }
    }
    
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Registration successful! Please login.";
            header('Location: login.php');
            exit();
        }
    }
}
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

    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#register">Register</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Login Form -->
                            <div class="tab-pane fade show active" id="login">
                                <form action="login.php" method="POST">
                                    <div class="mb-3">
                                        <label for="login-email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="login-email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="login-password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="login-password" name="password" required>
                                    </div>
                                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                                </form>
                            </div>

                            <!-- Registration Form -->
                            <div class="tab-pane fade" id="register">
                                <form action="login.php" method="POST">
                                    <div class="mb-3">
                                        <label for="register-username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="register-username" name="username" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="register-email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="register-email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="register-password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="register-password" name="password" required>
                                    </div>
                                    <button type="submit" name="register" class="btn btn-success w-100">Register</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
