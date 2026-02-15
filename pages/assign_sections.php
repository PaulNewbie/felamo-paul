<?php
include("components/header.php");

if (isset($_GET['tId'])) {
    $teacherId = $_GET['tId'];
    $teacherResult = $AuthController->GetUser($teacherId);

    if ($teacherResult->num_rows > 0) {
        $teacher = $teacherResult->fetch_assoc();
    } else {
        header("Location: ../index.php");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>

<input type="hidden" id="hidden_teacher_id" value="<?= $teacherId ?>">

<!-- <div id="alert" style="position: absolute; top:10px; right:10px; font-size: 12px;"></div> -->

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-main mb-0">
            <i class="bi bi-person-lines-fill me-2"></i>Assign Section to <?= htmlspecialchars($teacher['name']) ?>
        </h4>

        <button class="btn btn-sm btn-main text-light" data-bs-toggle="modal" data-bs-target="#assignSectionModal">
            <i class="bi bi-plus-circle-fill me-1"></i>Assign Section
        </button>
    </div>

    <div class="card shadow-sm rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle mb-0" style="font-size: 13px;">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-diagram-3-fill me-1"></i>Section Name</th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody id="section-table-tbody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assignSectionModal" tabindex="-1" aria-labelledby="assignSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="assign-section-form">
            <div class="modal-content">
                <div class="modal-header bg-main text-white">
                    <h5 class="modal-title" id="assignSectionModalLabel">
                        <i class="bi bi-diagram-3-fill me-2"></i>Assign Section
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="section_name" class="form-label">Section Name</label>
                        <input type="text" class="form-control" id="section_name" name="section_name" required>
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
<script src="scripts/assignSections.js"></script>
<?php include("components/footer.php"); ?>