$(document).ready(function() {
    // Status toggle
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
                const result = JSON.parse(response);
                if (result.success) {
                    location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            }
        });
    });

    // Edit task modal
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
            }
        });
    });

    // Delete task
    $('.delete-task').click(function(e) {
        e.preventDefault();
        const taskId = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this task?')) {
            $.ajax({
                url: 'tasks/delete.php',
                type: 'POST',
                data: { id: taskId },
                success: function() {
                    location.reload();
                }
            });
        }
    });

    // Form submissions
    $('#addTaskForm').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        $.ajax({
            url: 'tasks/add.php',
            type: 'POST',
            data: formData,
            success: function() {
                location.reload();
            }
        });
    });

    $('#editTaskForm').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        $.ajax({
            url: 'tasks/edit.php',
            type: 'POST',
            data: formData,
            success: function() {
                location.reload();
            }
        });
    });
});