<div class="sidebar">
    <h4 class="text-center mb-4">Admin Panel</h4>
    <nav class="nav flex-column">
        <a class="nav-link <?php echo ($currentPage == 'dashboard') ? 'active' : ''; ?>" href=".admin/sidebar.php">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a class="nav-link <?php echo ($currentPage == 'users') ? 'active' : ''; ?>" href="/admin/UserManagement/users.php">
            <i class="bi bi-people"></i> Users
        </a>
        <a class="nav-link <?php echo ($currentPage == 'bookings') ? 'active' : ''; ?>" href="/admin/BookingManagement/bookings.php">
            <i class="bi bi-calendar-check"></i> Bookings
        </a>
        <a class="nav-link <?php echo ($currentPage == 'tours') ? 'active' : ''; ?>" href="/admin/TourPackage/tour-packages.php">
            <i class="bi bi-map"></i> Tour Packages
        </a>
        <a class="nav-link <?php echo ($currentPage == 'feedback') ? 'active' : ''; ?>" href="/admin/FeedbackManagement/feedback.php">
            <i class="bi bi-chat-dots"></i> Feedback
        </a>
        <a class="nav-link" href="logout.php">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </nav>
</div>
