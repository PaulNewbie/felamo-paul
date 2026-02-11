<?php
include("components/header.php");

// include('../backend/controller/GenericController.php');

// $auth_user_id

// $GenericController = new GenericController();

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

<!-- hidden inputs -->
<input type="hidden" id="hidden_user_id" value="<?= $auth_user_id ?>">
<input type="hidden" id="hidden_level_id" value="<?= $level_id ?>">

<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between">

        <h4 class="my-3 text-main">
            <i class="bi bi-file-earmark-check me-2"></i>
            Taken Assessment sa
            <?=
            $level['level'] == 1 ? "Unang markahan" : ($level['level'] == 2 ? "Pangalawang markahan" : ($level['level'] == 3 ? "Pangatlong markahan" : ($level['level'] == 4 ? "Ika-apat na markahan" : "Hindi kilalang markahan")))
            ?>
        </h4>

        <div class="d-flex align-items-center">

            <div class="input-group input-group-sm w-auto">
                <label for="filter" class="input-group-text">Filter By</label>
                <select id="filter" class="form-control">
                    <option value="ALL">All Students</option>
                    <option value="FAILED">Failed Students</option>
                    <option value="PASSED">Passed Students</option>
                </select>
            </div>

            <button id="download-csv" class="btn btn-sm btn-main text-light ms-2">
                <i class="bi bi-download"></i> Download CSV
            </button>
        </div>

    </div>

    <div id="alert" style="position: absolute; top:10px; right:10px; font-size: 12px;"></div>

    <table class="table table-striped" id="taken-assessment-table">
        <thead>
            <tr>
                <th><i class="bi bi-person-vcard me-1"></i>LRN</th>
                <th><i class="bi bi-person me-1"></i>Student Name</th>
                <th><i class="bi bi-star me-1"></i>Points</th>
                <th><i class="bi bi-star me-1"></i>Total</th>
                <th><i class="bi bi-calendar me-1"></i>Date</th>
                <th><i class="bi bi-calendar me-1"></i>Attempts</th>
                <th><i class="bi bi-three-dots"></i></th>
            </tr>
        </thead>
        <tbody id="taken-assessment-table-tbody"></tbody>
    </table>
</div>

<?php
include("components/footer-scripts.php");
?>

<script src="scripts/takenAssessment.js"></script>

<?php
include("components/footer.php");
?>