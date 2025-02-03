<?php
$cssPath = "css/style.css";
$version = filemtime($cssPath); // Gets file modification time for cache busting
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


<style>

    </style>

<body>
    <!-- Header Section -->
    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">TourismPro</a>
            <nav class="navbar-nav me-auto">
                <a class="nav-link" href="index.php">Home</a>
                <a class="nav-link" href="tour-packages.php">Tour Packages</a>
                <a class="nav-link" href="bookings.php">Bookings</a>
                <a class="nav-link" href="feedback.php">Feedback</a>
            </nav>
            <div class="auth-buttons">
                <a href="login.php" class="btn btn-outline-light me-2">Sign In</a>
                <a href="admin/signin.php" class="btn btn-primary">Admin Login</a>
            </div>
        </div>
    </header>

    <!-- Hero Section with Background Image -->
    <section class="hero-section" style="background-image: url('back.jpeg');">
        <div class="container">
            <h1>Welcome to TourismPro</h1>
            <p>Discover amazing destinations and create unforgettable memories</p>
            <a href="tour-packages.php" class="btn btn-primary btn-lg">Explore Tours</a>
        </div>
    </section>

    <!-- Our Services Section -->
    <section class="services-section">
        <div class="container">
            <h2>Our Services</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="service-card">
                        <h3>Tour Packages</h3>
                        <p>Customized tour packages for all your travel needs</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <h3>Travel Planning</h3>
                        <p>Expert guidance for your perfect vacation</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <h3>24/7 Support</h3>
                        <p>Round-the-clock assistance for our customers</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about-section">
        <div class="container">
            <h2>About Us</h2>
            <div class="row">
                <div class="col-md-6">
                    <p>We are dedicated to providing exceptional travel experiences to our customers. With years of expertise in the tourism industry, we ensure quality service and memorable adventures.</p>
                </div>
                <div class="col-md-6">
                    <img src="images/about-us.jpg" alt="About Us" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="contact-section">
        <div class="container">
            <h2>Contact Us</h2>
            <div class="row">
                <div class="col-md-4">
                    <h3>Address</h3>
                    <p>123 Tourism Street<br>Travel City, TC 12345</p>
                </div>
                <div class="col-md-4">
                    <h3>Phone</h3>
                    <p>+1 234 567 8900<br>+1 234 567 8901</p>
                </div>
                <div class="col-md-4">
                    <h3>Email</h3>
                    <p>info@tourismPro.com<br>support@tourismPro.com</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light">
        <div class="container">
            <div class="row py-4">
                <div class="col-md-6">
                    <h4>TourismPro</h4>
                    <p>Your trusted travel partner</p>
                </div>
                <div class="col-md-6 text-end">
                    <div class="social-links">
                        <a href="#" class="text-light me-3">Facebook</a>
                        <a href="#" class="text-light me-3">Twitter</a>
                        <a href="#" class="text-light">Instagram</a>
                    </div>
                </div>
            </div>
            <div class="row border-top py-2">
                <div class="col text-center">
                    <small>&copy; 2025 TourismPro. All rights reserved.</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
