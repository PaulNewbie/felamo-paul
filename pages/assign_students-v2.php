<?php
include("components/header.php");

if (isset($_GET['sectionId'])) {
    $sectionId = $_GET['sectionId'];
    $sectionResult = $AuthController->GetUsingId('sections', $sectionId);

    if ($sectionResult->num_rows > 0) {
        $section = $sectionResult->fetch_assoc();
    } else {
        header("Location: ../index.php");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>

<!-- Hidden Input -->
<input type="hidden" id="hidden_section_id" value="<?= $sectionId ?>">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-main mb-0">
            <i class="bi bi-people-fill me-2"></i>Students of Section <?= htmlspecialchars($section['section_name']) ?>
        </h4>

        <div class="d-flex">
            <button class="btn btn-sm btn-main text-light me-2" data-bs-toggle="modal" data-bs-target="#insertStudentModal">
                <i class="bi bi-person-plus-fill me-1"></i>Insert Student
            </button>

            <div class="input-group input-group-sm" style="width: 230px;">
                <label for="CSV" class="input-group-text"><i class="bi bi-upload"></i> Import Student</label>
                <input type="file" id="CSV" class="form-control" accept=".csv">
            </div>
        </div>
    </div>

    <div class="card shadow-sm rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle mb-0" style="font-size: 13px;">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-card-list me-1"></i>LRN</th>
                            <th><i class="bi bi-person me-1"></i>Email</th>
                            <th><i class="bi bi-person me-1"></i>Contact no</th>
                            <th><i class="bi bi-person me-1"></i>First Name</th>
                            <th><i class="bi bi-person me-1"></i>Middle Name</th>
                            <th><i class="bi bi-person me-1"></i>Last Name</th>
                            <th><i class="bi bi-person me-1"></i>Birth date</th>
                            <th><i class="bi bi-person me-1"></i>Gender</th>
                        </tr>
                    </thead>
                    <tbody id="student-table-tbody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Insert Student -->
<div class="modal fade" id="insertStudentModal" tabindex="-1" aria-labelledby="insertStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="assign-student-form">
            <div class="modal-content">
                <div class="modal-header bg-main text-white">
                    <h5 class="modal-title" id="insertStudentModalLabel">
                        <i class="bi bi-person-plus-fill me-2"></i>Assign Student
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="assign_lrn" class="form-label">LRN</label>
                        <input type="number" class="form-control" id="assign_lrn" name="lrn" required>
                    </div>

                    <div class="mb-3">
                        <label for="assign_first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="assign_first_name" name="first_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="assign_middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="assign_middle_name" name="middle_name">
                    </div>

                    <div class="mb-3">
                        <label for="assign_last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="assign_last_name" name="last_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="assign_birth_date" class="form-label">Birth Date</label>
                        <input type="date" class="form-control" id="assign_birth_date" name="birth_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="assign_gender" class="form-label">Gender</label>
                        <select class="form-control" id="assign_gender" name="gender" required>
                            <option value="">Select</option>
                            <option value="Lalaki">Lalaki</option>
                            <option value="Babae">Babae</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="assign_contactno" class="form-label">Contact no</label>
                        <input type="number" class="form-control" id="assign_contactno" name="contact_no">
                    </div>

                    <div class="mb-3">
                        <label for="assign_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="assign_email" name="email">
                    </div>

                    <!-- <div class="mb-3">
                        <label for="assign_password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="assign_password" name="password">
                    </div> -->
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
<script src="scripts/assignStudentsv2.js?v=4"></script>
<?php include("components/footer.php"); ?>