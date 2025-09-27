$(document).ready(function() {
    // Add Task Form Submission
    $('#addTaskForm').submit(function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        
        // Show loading state
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Adding...');
        submitBtn.prop('disabled', true);
        
        $.ajax({
            url: 'tasks/add.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                // Reload page to show new task
                location.reload();
            },
            error: function() {
                alert('Error adding task. Please try again.');
                submitBtn.html('<i class="fas fa-plus"></i> Add Task');
                submitBtn.prop('disabled', false);
            }
        });
    });

    // Status Toggle
    $('.status-toggle').change(function() {
        const taskId = $(this).data('id');
        const status = $(this).is(':checked') ? 'completed' : 'pending';
        
        $.ajax({
            url: 'tasks/update.php',
            type: 'POST',
            data: {
                id: taskId,
                status: status
            },
            success: function(response) {
                // Reload to reflect changes
                location.reload();
            },
            error: function() {
                alert('Error updating task status.');
                location.reload(); // Reload to reset toggle state
            }
        });
    });

    // Edit Task Modal
    $('.edit-task').click(function(e) {
        e.preventDefault();
        const taskId = $(this).data('id');
        
        $.ajax({
            url: 'tasks/get_task.php',
            type: 'POST',
            data: { id: taskId },
            success: function(response) {
                const task = JSON.parse(response);
                if (task.success) {
                    $('#edit_id').val(task.data.id);
                    $('#edit_title').val(task.data.title);
                    $('#edit_description').val(task.data.description);
                    $('#edit_due_date').val(task.data.due_date);
                    $('#edit_status').val(task.data.status);
                    $('#editTaskModal').modal('show');
                } else {
                    alert('Error loading task data');
                }
            },
            error: function() {
                alert('Error loading task data');
            }
        });
    });

    // Edit Task Form Submission
    $('#editTaskForm').submit(function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        
        // Show loading state
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Updating...');
        submitBtn.prop('disabled', true);
        
        $.ajax({
            url: 'tasks/edit.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                location.reload();
            },
            error: function() {
                alert('Error updating task. Please try again.');
                submitBtn.html('Update Task');
                submitBtn.prop('disabled', false);
            }
        });
    });

    // Delete Task
    $('.delete-task').click(function(e) {
        e.preventDefault();
        const taskId = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this task?')) {
            $.ajax({
                url: 'tasks/delete.php',
                type: 'POST',
                data: { id: taskId },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Error deleting task.');
                }
            });
        }
    });

    // Reset modal when closed
    $('#addTaskModal').on('hidden.bs.modal', function() {
        $('#addTaskForm')[0].reset();
        $('#addTaskForm button[type="submit"]').html('Add Task').prop('disabled', false);
    });
    
    $('#editTaskModal').on('hidden.bs.modal', function() {
        $('#editTaskForm button[type="submit"]').html('Update Task').prop('disabled', false);
    });
});