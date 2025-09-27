    </div> <!-- Close container -->

    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-tasks"></i> Task Manager</h5>
                    <p class="mb-0">Efficiently manage your tasks and boost productivity.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        <strong>Built by:</strong> Sayeb<br>
                        <strong>For:</strong> Dial Dynamic Ltd Hiring Process<br>
                        <strong>Position:</strong> In-house Web Developer
                    </p>
                </div>
            </div>
            <hr class="my-3">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> Task Manager. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Load tasks JavaScript only on tasks pages -->
    <?php if (basename(dirname($_SERVER['PHP_SELF'])) == 'tasks'): ?>
        <script src="../assets/js/tasks.js"></script>
    <?php endif; ?>
</body>
</html>