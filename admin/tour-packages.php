
<?php
session_start();
require_once '../config/database.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = "Tour Package Management";
$currentPage = "tours";

// Fetch all tours with creator info
$query = "SELECT t.*, u.username as created_by_name 
          FROM tours t 
          LEFT JOIN users u ON t.created_by = u.id 
          ORDER BY t.tour_id DESC";
$result = $conn->query($query);


include '../includes/header.php';
?>

<div class="dashboard-container">
    <?php include '../includes/sidebar.php'; ?>

    <div class="main-content p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Tour Package Management</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTourModal">
                <i class="bi bi-plus-circle"></i> Add New Tour
            </button>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Created By</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($tour = $result->fetch_assoc()): ?>
                        <tr>
                        <td><?php echo $tour['tour_id']; ?></td>
<td><?php echo $tour['name']; ?></td>
<td>$<?php echo number_format($tour['price'], 2); ?></td>
<td>
    <?php 
    $start = new DateTime($tour['start_date']);
    $end = new DateTime($tour['end_date']);
    $duration = $start->diff($end)->days;
    echo $duration . ' days';
    ?>
</td>
<td><?php echo $tour['created_by_name']; ?></td>
<td>
    <span class="badge bg-success">Active</span>
</td>
<td>
    <button class="btn btn-sm btn-info" onclick="viewTour(<?php echo $tour['tour_id']; ?>)">
        <i class="bi bi-eye"></i>
    </button>
    <button class="btn btn-sm btn-primary" onclick="editTour(<?php echo $tour['tour_id']; ?>)">
        <i class="bi bi-pencil"></i>
    </button>
    <button class="btn btn-sm btn-danger" onclick="deleteTour(<?php echo $tour['tour_id']; ?>)">
        <i class="bi bi-trash"></i>
    </button>
</td>

                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Tour Modal -->
<div class="modal fade" id="addTourModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Tour Package</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addTourForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tour Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" step="0.01" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="4" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveTour()">Save Tour</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
   function viewTour(id) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `get_tour.php?tour_id=${id}`, true);
    xhr.onload = function() {
        const tour = JSON.parse(this.responseText);
        const viewModal = `
            <div class="modal fade" id="viewTourModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tour Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <h4>${tour.name}</h4>
                            <p><strong>Price:</strong> $${tour.price}</p>
                            <p><strong>Duration:</strong> ${tour.start_date} to ${tour.end_date}</p>
                            <p><strong>Description:</strong> ${tour.description}</p>
                        </div>
                    </div>
                </div>
            </div>`;
        document.body.insertAdjacentHTML('beforeend', viewModal);
        const modal = new bootstrap.Modal(document.getElementById('viewTourModal'));
        modal.show();
    };
    xhr.send();
}

function editTour(id) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `get_tour.php?tour_id=${id}`, true);
    xhr.onload = function() {
        const tour = JSON.parse(this.responseText);
        document.querySelector('[name="name"]').value = tour.name;
        document.querySelector('[name="price"]').value = tour.price;
        document.querySelector('[name="start_date"]').value = tour.start_date;
        document.querySelector('[name="end_date"]').value = tour.end_date;
        document.querySelector('[name="description"]').value = tour.description;
        
        const form = document.getElementById('addTourForm');
        const tourIdInput = document.createElement('input');
        tourIdInput.type = 'hidden';
        tourIdInput.name = 'tour_id';
        tourIdInput.value = id;
        form.appendChild(tourIdInput);
        
        const modal = new bootstrap.Modal(document.getElementById('addTourModal'));
        modal.show();
    };
    xhr.send();
}

function deleteTour(id) {
    if(confirm('Are you sure you want to delete this tour package?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_tour.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if(this.status === 200) {
                location.reload();
            }
        };
        xhr.send(`tour_id=${id}`);
    }
}

function saveTour() {
    const formData = new FormData(document.getElementById('addTourForm'));
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_tour.php', true);
    xhr.onload = function() {
        if(this.status === 200) {
            location.reload();
        }
    };
    xhr.send(formData);
}

</script>
</body>
</html>
