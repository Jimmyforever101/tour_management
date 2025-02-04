<div class="sidebar">
    <h4 class="text-center mb-4">Admin Panel</h4>
    <nav class="nav flex-column">
        <a class="nav-link <?php echo ($currentPage == 'dashboard') ? 'active' : ''; ?>" href="/tour_management/admin/dashboard.php">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a class="nav-link <?php echo ($currentPage == 'users') ? 'active' : ''; ?>" href="/tour_management/admin/UserManagement/users.php">
            <i class="bi bi-people"></i> Users
        </a>
        <a class="nav-link <?php echo ($currentPage == 'bookings') ? 'active' : ''; ?>" href="/tour_management/admin/BookingManagement/bookings.php">
            <i class="bi bi-calendar-check"></i> Bookings
        </a>
        <a class="nav-link <?php echo ($currentPage == 'tours') ? 'active' : ''; ?>" href="/tour_management/admin/TourPackage/tour-packages.php">
            <i class="bi bi-map"></i> Tour Packages
        </a>
        <a class="nav-link <?php echo ($currentPage == 'feedback') ? 'active' : ''; ?>" href="/tour_management/admin/FeedbackManagement/feedback.php">
            <i class="bi bi-chat-dots"></i> Feedback
        </a>
        <a class="nav-link" href="/tour_management/admin/logout.php">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </nav>
</div>

<style>
    .dashboard-container {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 250px;
    background: #343a40;
    color: white;
    padding-top: 20px;
}

.main-content {
    flex: 1;
    background: #f8f9fa;
}

.nav-link {
    color: rgba(255, 255, 255, .8);
    padding: 15px 20px;
}

.nav-link:hover {
    color: white;
    background: rgba(255, 255, 255, .1);
}

.stat-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1);
}

.card {
    box-shadow: 0 0 15px rgba(0, 0, 0, .05);
    border: none;
}

.card-header {
    background: white;
    border-bottom: 1px solid rgba(0, 0, 0, .125);
}

.nav-link.active {
    background: rgba(255, 255, 255, .2);
    color: white;
}

</style>
