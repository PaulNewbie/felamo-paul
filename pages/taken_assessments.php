<?php 
include("components/header.php"); 

// Authorization & Validation
if (isset($_GET['level'])) {
    $level_id = $_GET['level'];
    // Optional: Fetch level details for display
    $levelResult = $AuthController->GetUsingId("levels", $level_id);
    if ($levelResult && $levelResult->num_rows > 0) {
        $levelData = $levelResult->fetch_assoc();
    } else {
        header("Location: levels.php");
        exit();
    }
} else {
    header("Location: levels.php");
    exit();
}
?>

<input type="hidden" id="hidden_user_id" value="<?= $auth_user_id ?>">
<input type="hidden" id="hidden_level_id" value="<?= $level_id ?>">

<style>
    /* --- LAYOUT & RESET --- */
    nav.navbar { display: none !important; } 
    body { background-color: #f4f6f9; overflow-x: hidden; }
    .dashboard-wrapper { display: flex; width: 100%; min-height: 100vh; overflow-x: hidden; }
    .main-content { flex: 1; margin-left: 280px; padding: 30px 40px; background-color: #f8f9fa; transition: margin-left 0.3s ease-in-out; }
    .dashboard-wrapper.toggled .main-content { margin-left: 0 !important; }

    /* --- SIDEBAR STYLE --- */
    .sidebar-profile { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.5); }
    .sidebar-profile img { width: 80px !important; height: 80px !important; border-radius: 50%; object-fit: cover; border: 2px solid white; }
    .sidebar-profile h5 { font-weight: bold; margin: 0; font-size: 1.2rem; text-transform: uppercase; color: white; }
    .nav-link-custom { display: flex; align-items: center; padding: 12px 15px; color: white; text-decoration: none; font-weight: 600; margin-bottom: 10px; transition: 0.3s; border-radius: 5px; }
    .nav-link-custom:hover { background-color: rgba(255, 255, 255, 0.2); color: white; }
    .nav-link-custom.active { background-color: #FFC107 !important; color: #440101 !important; }
    .nav-link-custom i { margin-right: 15px; font-size: 1.2rem; }
    .logout-btn { margin-top: auto; background-color: #FFC107; color: black; font-weight: bold; border: none; width: 100%; padding: 12px; border-radius: 25px; text-align: center; cursor: pointer; }

    /* --- PAGE HEADER --- */
    .page-header-banner {
        background: linear-gradient(90deg, #a71b1b 0%, #880f0b 100%);
        color: white; padding: 15px 25px; border-radius: 8px; margin-bottom: 25px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: space-between;
        font-size: 1.5rem; font-weight: 700; text-transform: uppercase;
    }
    .header-text { display: flex; align-items: center; }
    .header-text i { margin-right: 15px; font-size: 1.8rem; }
    
    .btn-back {
        background-color: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.5);
        font-size: 0.9rem; font-weight: 600; padding: 8px 20px; border-radius: 50px; text-decoration: none;
        transition: all 0.2s; display: flex; align-items: center; gap: 8px;
    }
    .btn-back:hover { background-color: white; color: #a71b1b; }

    /* --- TABLE CONTAINER --- */
    .table-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        border: 1px solid #dee2e6;
    }
    .custom-table { width: 100%; margin-bottom: 0; border-collapse: collapse; }
    .custom-table thead {
        background-color: #e9ecef; color: #333; font-weight: 800;
        text-transform: uppercase; font-size: 0.85rem;
    }
    .custom-table th, .custom-table td {
        padding: 15px 25px; vertical-align: middle; border-bottom: 1px solid #f0f0f0;
    }
    .custom-table tbody tr:hover { background-color: #f8f9fa; }
    
    /* Status Badges */
    .badge-score { background-color: #a71b1b; color: white; padding: 5px 10px; border-radius: 4px; font-weight: 600; font-size: 0.85rem; }
    .text-date { font-size: 0.9rem; color: #6c757d; }

    /* Action Button */
    .btn-action-red {
        background-color: #c92a2a; color: white; border: none;
        padding: 6px 12px; border-radius: 4px; font-size: 0.85rem;
        font-weight: 600; display: inline-flex; align-items: center; gap: 5px;
        text-decoration: none;
    }
    .btn-action-red:hover { background-color: #a71b1b; color: white; }

    @media (max-width: 991.98px) { .main-content { margin-left: 0; padding: 1rem; } .page-header-banner { flex-direction: column; gap: 15px; text-align: center; } }
</style>

<div class="dashboard-wrapper">
    
    <?php include("components/sidebar.php"); ?>

    <div class="main-content">
        
        <div class="page-header-banner">
    
    <div class="header-left" style="display: flex; align-items: center; gap: 15px;">
        <a href="levels.php" class="btn-back-text">
            BACK
        </a>
        <h4 class="m-0 fw-bold text-uppercase">
            Detalye ng <?= htmlspecialchars($level['level'] ?? "Markahan") ?>
        </h4>
    </div>

    <div class="header-right">
        </div>

</div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Assessment Title</th>
                            <th style="width: 25%;">Student Name</th>
                            <th style="width: 15%;">Date Taken</th>
                            <th style="width: 15%;">Score</th>
                            <th style="width: 15%; text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="taken-assessments-list">
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="spinner-border text-main" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include("components/footer-scripts.php"); ?>
<script src="scripts/takenAssessment.js?v=<?= time() ?>"></script>

<script>
    $(document).ready(function () {
        // Toggle Sidebar Logic
        $(document).off('click', '.sidebar-toggle');
        $(document).on('click', '.sidebar-toggle', function(e) {
            e.preventDefault();
            e.stopPropagation(); 
            $(".dashboard-wrapper").toggleClass("toggled");
        });

        // Force Sidebar "Markahan" Active State
        $('a.nav-link-custom[href="levels.php"]').addClass('active');
    });
</script>

<?php include("components/footer.php"); ?>