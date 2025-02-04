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
    /* Add Font Awesome CSS */
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
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
                    <p>Welcome to Jimmy Forever Tour Company, your ultimate partner in crafting unforgettable adventures and lifelong memories! 
                        We are a passionate team of travel enthusiasts, storytellers, and explorers who believe that travel is not just about visiting new places—
                        it’s about creating meaningful connections, discovering the world’s wonders, and experiencing life in its fullest, most vibrant form. 
                        Whether you’re dreaming of wandering through serene landscapes, diving into the heart of bustling cities, or uncovering hidden gems that only locals know about,
                         we’re here to make your travel dreams come true. At Jimmy Forever Tour Company, we pride ourselves on offering personalized, tailor-made experiences that are as unique as you are. 
                         From the moment you reach out to us, our dedicated team of travel experts will work closely with you to design a journey that reflects your passions, interests, and aspirations. 
                         We handle every detail with care, from seamless transportation and handpicked accommodations to immersive activities that bring your destination to life. Our commitment to excellence ensures that your trip is not just a vacation, 
                         but a transformative experience. At the core of everything we do is a deep love for storytelling through travel. We believe that every journey has a story to tell, and we’re here to help you write yours. 
                         Whether it’s a romantic getaway, a family vacation, a solo adventure, or a group expedition, we’re dedicated to making every moment unforgettable. Welcome to the Jimmy Forever family—where your journey begins, and memories last forever. 
                         Let’s explore the world together!</p>
                </div>
                <div class="col-md-6">
                    <img src="images/6.jpeg" alt="About Us" class="img-fluid">
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
                    <p>+255 767 711 890<br>+255 629 411 890 </p>
                </div>
                <div class="col-md-4">
                    <h3>Email</h3>
                    <p>jimmyforever@gmail.com<br>jimmytourscompany@gmail.com</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light">
        <div class="container">
            <div class="row py-4">
                <div class="col-md-6">
                    <h4>JimmyTours Company</h4>
                    <p>Your trusted travel partner</p>
                </div>
                <div class="col-md-6 text-end">
                    <div class="social-links">
                        <button>
                        <div class="social-icons">
  <a href="https://facebook.com/yourpage" target="_blank" class="social-icon">
    <i class="fab fa-facebook-f"></i>
  </a>
  <a href="https://twitter.com/yourhandle" target="_blank" class="social-icon">
    <i class="fab fa-twitter"></i>
  </a>
  <a href="https://instagram.com/yourprofile" target="_blank" class="social-icon">
    <i class="fab fa-instagram"></i>
  </a>
  <a href="https://youtube.com/yourchannel" target="_blank" class="social-icon">
    <i class="fab fa-youtube"></i>
  </a>
  <a href="https://linkedin.com/yourcompany" target="_blank" class="social-icon">
    <i class="fab fa-linkedin-in"></i>
  </a>
                    </div>
                </div>
            </div>
            <div class="row border-top py-2">
                <div class="col text-center">
                    <small>&copy; 2025 jimmyforever. All rights reserved.</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
