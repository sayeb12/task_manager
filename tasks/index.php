<?php
require_once __DIR__ . '/../includes/header.php';

// Check authentication
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Include the Task class
require_once __DIR__ . '/../includes/Task.php';

$task = new Task();
$task->user_id = $_SESSION['user_id'];
$stmt = $task->readAll($_SESSION['user_id']);

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-tasks"></i> My Tasks</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <i class="fas fa-plus"></i> Add New Task
            </button>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row" id="tasksContainer">
            <?php 
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="col-md-6 mb-3">
                        <div class="card task-card <?php echo $row['status'] == 'completed' ? 'border-success' : ''; ?>">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="card-title">
                                        <?php if ($row['status'] == 'completed'): ?>
                                            <s><?php echo htmlspecialchars($row['title']); ?></s>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($row['title']); ?>
                                        <?php endif; ?>
                                    </h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                     <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="edit_form.php?id=<?php echo $row['id']; ?>">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </li>
    <li>
        <a class="dropdown-item" href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this task?')">
            <i class="fas fa-trash"></i> Delete
        </a>
    </li>
</ul>
                                    </div>
                                </div>
                                
                                <?php if (!empty($row['description'])): ?>
                                    <p class="card-text"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                                <?php endif; ?>
                                
                                <?php if ($row['due_date']): ?>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar"></i> Due: <?php echo date('M j, Y', strtotime($row['due_date'])); ?>
                                        </small>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-<?php echo $row['status'] == 'completed' ? 'success' : 'warning'; ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                    <a href="toggle_status.php?id=<?php echo $row['id']; ?>&status=<?php echo $row['status'] == 'completed' ? 'pending' : 'completed'; ?>" class="btn btn-sm btn-<?php echo $row['status'] == 'completed' ? 'warning' : 'success'; ?>">
                                        <?php echo $row['status'] == 'completed' ? 'Mark Pending' : 'Mark Complete'; ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; 
            } else { ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <h4>No tasks found</h4>
                        <p class="text-muted">Get started by creating your first task!</p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="add.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title *</label>
                        <input type="text" class="form-control" id="title" name="title" required 
                               placeholder="Enter task title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                                  placeholder="Enter task description (optional)"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="edit.php" method="POST">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Title *</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="edit_due_date" name="due_date">
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-select" id="edit_status" name="status">
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Simple edit task functionality
document.addEventListener('DOMContentLoaded', function() {
    // Edit task buttons
    const editButtons = document.querySelectorAll('.edit-task');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const taskId = this.getAttribute('data-id');
            
            // Load task data via query parameter
            window.location.href = `edit_form.php?id=${taskId}`;
        });
    });
});

// Alternative: Simple modal approach without AJAX
function loadEditForm(taskId) {
    // Redirect to edit form page
    window.location.href = 'edit_form.php?id=' + taskId;
}
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>