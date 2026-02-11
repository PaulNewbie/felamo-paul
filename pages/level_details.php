<?php
include("components/header.php");

// Authorization and Validation
if (isset($_GET['level'])) {
    $level_id = $_GET['level'];
    $levelResult = $AuthController->GetUsingId("levels", $level_id);

    if ($levelResult->num_rows > 0) {
        $level = $levelResult->fetch_assoc();
        if ($level['teacher_id'] != $auth_user_id) {
            header("Location: ../index.php");
        }
    } else {
        header("Location: ../index.php");
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>

<!-- Hidden Inputs -->
<input type="hidden" id="hidden_user_id" value="<?= $auth_user_id ?>">
<input type="hidden" id="hidden_level_id" value="<?= $level_id ?>">

<!-- Page Content -->
<div class="container py-4">
    <h4 class="my-3 text-main">
        <i class="bi bi-journals me-2"></i>Detalye ng
        <?php
        $markahan = '';
        switch ($level['level']) {
            case 1:
                $markahan = ' Unang markahan';
                break;
            case 2:
                $markahan = ' Pangalawang markahan';
                break;
            case 3:
                $markahan = ' Pangatlong markahan';
                break;
            case 4:
                $markahan = ' Ika-apat na markahan';
                break;
            default:
                $markahan = '';
        }
        echo $markahan;
        ?>
    </h4>


    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-sm btn-main text-light" data-bs-toggle="modal" data-bs-target="#insertAralinModal">
            <i class="bi bi-plus-circle me-1"></i>Insert Aralin
        </button>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th><i class="bi bi-list-ol me-1"></i>Aralin</th>
                <th><i class="bi bi-card-text me-1"></i>Title</th>
                <th><i class="bi bi-card-text me-1"></i>Summary</th>
                <th><i class="bi bi-info-circle me-1"></i>Details</th>
                <th><i class="bi bi-gear me-1"></i>Action</th>
            </tr>
        </thead>
        <tbody id="antas-details-table-tbody"></tbody>
    </table>
</div>

<!-- Insert Aralin Modal -->
<div class="modal fade" id="insertAralinModal" tabindex="-1" aria-labelledby="insertAralinModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="insert-aralin-form" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="requestType" value="InsertAralin">
            <input type="hidden" name="level_id" value="<?= $level_id ?>">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertAralinModalLabel">
                        <i class="bi bi-plus-circle me-1"></i>Add New Aralin
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="aralin-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="aralin-title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="aralin-summary" class="form-label">Summary</label>
                        <textarea class="form-control" id="aralin-summary" name="summary" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="aralin-details" class="form-label">Details</label>
                        <textarea class="form-control" id="aralin-details" name="details" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="aralin-attachment" class="form-label">Upload Attachment / Video</label>
                        <input type="file" class="form-control" id="aralin-attachment" name="attachment" accept="video/*" required>
                        <small class="text-muted">Accepted: mp4, webm, mov</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-main text-light">
                        <i class="bi bi-save me-1"></i>Save Aralin
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Aralin Modal -->
<div class="modal fade" id="editAralinModal" tabindex="-1" aria-labelledby="editAralinModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="edit-aralin-form" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="requestType" value="EditAralin">
            <input type="hidden" name="aralin_id" id="edit-aralin-id">
            <input type="hidden" name="level_id" value="<?= $level_id ?>">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAralinModalLabel">
                        <i class="bi bi-pencil-square me-1"></i>Edit Aralin
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-aralin-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit-aralin-title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-aralin-summary" class="form-label">Summary</label>
                        <textarea class="form-control" id="edit-aralin-summary" name="summary" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit-aralin-details" class="form-label">Details</label>
                        <textarea class="form-control" id="edit-aralin-details" name="details" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit-aralin-attachment" class="form-label">Replace Video (optional)</label>
                        <input type="file" class="form-control" id="edit-aralin-attachment" name="attachment" accept="video/*">
                        <small class="text-muted">Leave empty if not changing the video</small>
                    </div>

                    <div class="mb-3">
                        <label>Current Video:</label><br>
                        <a href="#" target="_blank" id="current-video-link">
                            <i class="bi bi-film"></i> View Current Video
                        </a>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-main text-light">
                        <i class="bi bi-arrow-repeat me-1"></i>Update
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include("components/footer-scripts.php"); ?>
<script src="scripts/levelsDetails.js?v=1"></script>
<?php include("components/footer.php"); ?>