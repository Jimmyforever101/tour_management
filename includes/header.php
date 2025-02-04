<?php
$cssPath = "css/style.css";
$version = filemtime($cssPath);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>TourismPro</title>
    <link rel="stylesheet" href="<?php echo $cssPath . '?v=' . $version; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">TourismPro</a>
            <nav class="navbar-nav me-auto">
                <a class="nav-link <?php echo ($currentPage == 'home') ? 'active' : ''; ?>" href="index.php">Home</a>
                <a class="nav-link <?php echo ($currentPage == 'tours') ? 'active' : ''; ?>" href="tour-packages.php">Tour Packages</a>
                <a class="nav-link <?php echo ($currentPage == 'bookings') ? 'active' : ''; ?>" href="bookings.php">Bookings</a>
                <a class="nav-link <?php echo ($currentPage == 'feedback') ? 'active' : ''; ?>" href="feedback.php">Feedback</a>
            </nav>
            <div class="auth-buttons">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> My Account
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="my-bookings.php">My Bookings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-light me-2">Sign In</a>
                    <a href="admin/login.php" class="btn btn-primary">Admin Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
