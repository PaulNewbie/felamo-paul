<?php include("components/header.php"); ?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-main mb-0">
            <i class="bi bi-person-badge-fill me-2"></i>Teachers
        </h4>

        <div class="d-flex">
            <button class="btn btn-sm btn-main text-light me-2" data-bs-toggle="modal" data-bs-target="#insertTeacherModal">
                <i class="bi bi-person-plus-fill me-1"></i>Add Teacher
            </button>

            <div class="input-group input-group-sm" style="width: 220px;">
                <label for="CSV" class="input-group-text"><i class="bi bi-upload"></i> Import</label>
                <input type="file" id="CSV" class="form-control" accept=".csv">
            </div>
        </div>
    </div>

    <div class="card shadow-sm rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-striped align-middle mb-0" style="font-size: 13px;">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-person-fill me-1"></i>Name</th>
                            <th><i class="bi bi-envelope-fill me-1"></i>Email</th>
                            <th><i class="bi bi-grid-1x2-fill me-1"></i>Grade</th>
                            <th><i class="bi bi-check-circle-fill me-1"></i>Status</th>
                            <th><i class="bi bi-gear-fill me-1"></i>Action</th>
                        </tr>
                    </thead>
                    <tbody id="teacher-table-tbody">
                        <!-- Table rows go here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Insert Teacher -->
<div class="modal fade" id="insertTeacherModal" tabindex="-1" aria-labelledby="insertTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="insert-teacher-form">
            <div class="modal-content">
                <div class="modal-header bg-main text-white">
                    <h5 class="modal-title" id="insertTeacherModalLabel">
                        <i class="bi bi-person-plus-fill me-2"></i>Add New Teacher
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="teacher-name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="teacher-name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="teacher-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="teacher-email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="teacher-password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="teacher-password" name="password" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-main text-light">
                        <i class="bi bi-save me-1"></i>Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include("components/footer-scripts.php"); ?>
<script src="scripts/teachers.js?v=2"></script>
<?php include("components/footer.php"); ?>
