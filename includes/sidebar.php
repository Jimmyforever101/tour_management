<div class="sidebar">
    <h4 class="text-center mb-4">Admin Panel</h4>
    <nav class="nav flex-column">
        <a class="nav-link <?php echo ($currentPage == 'dashboard') ? 'active' : ''; ?>" href="dashboard.php">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a class="nav-link <?php echo ($currentPage == 'users') ? 'active' : ''; ?>" href="users.php">
            <i class="bi bi-people"></i> Users
        </a>
        <a class="nav-link <?php echo ($currentPage == 'bookings') ? 'active' : ''; ?>" href="bookings.php">
            <i class="bi bi-calendar-check"></i> Bookings
        </a>
        <a class="nav-link <?php echo ($currentPage == 'tours') ? 'active' : ''; ?>" href="tour-packages.php">
            <i class="bi bi-map"></i> Tour Packages
        </a>
        <a class="nav-link <?php echo ($currentPage == 'feedback') ? 'active' : ''; ?>" href="feedback.php">
            <i class="bi bi-chat-dots"></i> Feedback
        </a>
        <a class="nav-link" href="logout.php">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </nav>
</div>
