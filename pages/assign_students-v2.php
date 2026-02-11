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
$isSuperAdmin = $user['role'] === 'super_admin';
?>

<input type="hidden" id="hidden_user_id" value="<?= $auth_user_id ?>">
<input type="hidden" id="hidden_is_super_admin" value="<?= $isSuperAdmin ? 'true' : 'false' ?>">
<input type="hidden" id="hidden_section_id" value="<?= $sectionId ?>">

<style>
    /* --- UNIFIED CSS (MATCHES HOME/TEACHERS/STUDENTS) --- */
    .navbar { display: none !important; }
    body { background-color: #f4f6f9; overflow-x: hidden; }
    .dashboard-wrapper { display: flex; min-height: 100vh; width: 100%; overflow-x: hidden; }

    /* SIDEBAR (Visible Arrow + 80px Logo) */
    .sidebar { width: 280px; background: linear-gradient(180deg, #a71b1b 0%, #880f0b 100%); color: white; display: flex; flex-direction: column; padding: 20px; position: fixed; height: 100vh; z-index: 1000; left: 0; transition: all 0.3s ease; overflow: visible !important; }
    .sidebar-profile { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.5); }
    .sidebar-profile img { width: 80px !important; height: 80px !important; border-radius: 50%; object-fit: cover; border: 2px solid white; max-width: 100%; display: block; }
    .sidebar-profile h5 { font-weight: bold; margin: 0; font-size: 1.2rem; text-transform: uppercase; }
    .nav-link-custom { display: flex; align-items: center; padding: 12px 15px; color: white; text-decoration: none; font-weight: 600; margin-bottom: 10px; transition: 0.3s; border-radius: 5px; }
    .nav-link-custom:hover { background-color: rgba(255, 255, 255, 0.2); color: white; }
    .nav-link-custom.active { background-color: #FFC107; color: #333; }
    .nav-link-custom i { margin-right: 15px; font-size: 1.2rem; }
    .logout-btn { margin-top: auto; background-color: #FFC107; color: black; font-weight: bold; border: none; width: 100%; padding: 12px; border-radius: 25px; text-align: center; text-decoration: none; cursor: pointer; }
    .logout-btn:hover { background-color: #e0a800; color: black; }
    
    /* ARROW FIX */
    .sidebar-toggle { position: absolute; right: -15px; top: 50%; width: 30px; height: 60px; background-color: #FFC107; border-radius: 0 4px 4px 0; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #333; transition: right 0.3s ease; z-index: 1001; }
    .sidebar-toggle i { transition: transform 0.3s ease; }
    
    .dashboard-wrapper.toggled .sidebar { left: -280px; }
    .dashboard-wrapper.toggled .main-content { margin-left: 0; }
    .dashboard-wrapper.toggled .sidebar-toggle { right: -30px; }
    .dashboard-wrapper.toggled .sidebar-toggle i { transform: rotate(180deg); }

    /* CONTENT */
    .main-content { flex: 1; margin-left: 280px; padding: 30px 40px; transition: all 0.3s ease; }
    .page-header { background: linear-gradient(180deg, #880f0b 0%, #ce3c3c 100%); color: white; padding: 15px 30px; border-radius: 8px; font-weight: bold; font-size: 1.2rem; margin-bottom: 20px; text-transform: uppercase; display: flex; align-items: center; justify-content: space-between; }
</style>

<div class="dashboard-wrapper">
    <?php include("components/sidebar.php"); ?>
    <main class="main-content">
        <div class="page-header shadow-sm">
            <div class="d-flex align-items-center">
                <a href="javascript:history.back()" class="btn btn-sm btn-light text-main me-3 rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-arrow-left"></i></a>
                <span><i class="bi bi-people-fill me-2"></i> Students: <?= htmlspecialchars($section['section_name']) ?></span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-light text-main fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#insertStudentModal"><i class="bi bi-person-plus-fill me-1"></i> Insert Student</button>
                <div class="input-group input-group-sm" style="width: 220px;">
                    <label for="CSV" class="input-group-text bg-light border-0 fw-bold text-secondary" style="cursor:pointer;"><i class="bi bi-upload me-2"></i> Import CSV</label>
                    <input type="file" id="CSV" class="form-control bg-white border-0" accept=".csv" style="display:none;">
                </div>
            </div>
        </div>

        <div class="card shadow-sm rounded-3">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-sm table-striped align-middle mb-0" style="font-size: 13px;">
                        <thead class="table-light">
                            <tr><th><i class="bi bi-card-list me-1"></i>LRN</th><th><i class="bi bi-person me-1"></i>Email</th><th><i class="bi bi-telephone me-1"></i>Contact</th><th><i class="bi bi-person me-1"></i>First Name</th><th><i class="bi bi-person me-1"></i>Middle Name</th><th><i class="bi bi-person me-1"></i>Last Name</th><th><i class="bi bi-calendar-event me-1"></i>Birth Date</th><th><i class="bi bi-gender-ambiguous me-1"></i>Gender</th></tr>
                        </thead>
                        <tbody id="student-table-tbody"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="insertStudentModal" tabindex="-1">
            <div class="modal-dialog">
                <form id="assign-student-form">
                    <div class="modal-content">
                        <div class="modal-header text-white" style="background: linear-gradient(180deg, #a71b1b 0%, #880f0b 100%);">
                            <h5 class="modal-title"><i class="bi bi-person-plus-fill me-2"></i>Assign Student</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3"><label for="assign_lrn" class="form-label">LRN</label><input type="number" class="form-control" id="assign_lrn" name="lrn" required></div>
                            <div class="row">
                                <div class="col-md-6 mb-3"><label for="assign_first_name" class="form-label">First Name</label><input type="text" class="form-control" id="assign_first_name" name="first_name" required></div>
                                <div class="col-md-6 mb-3"><label for="assign_middle_name" class="form-label">Middle Name</label><input type="text" class="form-control" id="assign_middle_name" name="middle_name"></div>
                            </div>
                            <div class="mb-3"><label for="assign_last_name" class="form-label">Last Name</label><input type="text" class="form-control" id="assign_last_name" name="last_name" required></div>
                            <div class="row">
                                <div class="col-md-6 mb-3"><label for="assign_birth_date" class="form-label">Birth Date</label><input type="date" class="form-control" id="assign_birth_date" name="birth_date" required></div>
                                <div class="col-md-6 mb-3"><label for="assign_gender" class="form-label">Gender</label><select class="form-control" id="assign_gender" name="gender" required><option value="">Select</option><option value="Lalaki">Lalaki</option><option value="Babae">Babae</option></select></div>
                            </div>
                            <div class="mb-3"><label for="assign_contactno" class="form-label">Contact no</label><input type="number" class="form-control" id="assign_contactno" name="contact_no"></div>
                            <div class="mb-3"><label for="assign_email" class="form-label">Email</label><input type="email" class="form-control" id="assign_email" name="email"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-main text-light" style="background-color: #880f0b; border:none;"><i class="bi bi-save me-1"></i>Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?php include("components/footer-scripts.php"); ?>
<script src="scripts/assignStudentsv2.js?v=4"></script>
<?php include("components/footer.php"); ?>