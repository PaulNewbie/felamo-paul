<?php 
include("components/header.php"); 
$isSuperAdmin = $user['role'] === 'super_admin'; 
?>

<input type="hidden" id="hidden_user_id" value="<?= $auth_user_id ?>">

<style>
    /* --- CRITICAL FIX: HIDE THE TOP NAVBAR --- */
    .navbar, header, .main-header { display: none !important; }

    /* --- PAGE LAYOUT --- */
    body { background-color: #f4f6f9; overflow-x: hidden; }
    .dashboard-wrapper { display: flex; min-height: 100vh; width: 100%; }
    
    /* MAIN CONTENT AREA */
    .main-content { 
        flex: 1; 
        margin-left: 280px; /* Width of sidebar */
        padding: 30px 40px; 
        transition: all 0.3s ease; 
    }

    /* 1. PROFILE BANNER (Red Gradient) */
    .profile-header-banner {
        background: linear-gradient(90deg, #a71b1b 0%, #d32f2f 100%);
        color: white;
        padding: 15px 25px;
        border-radius: 10px;
        margin-bottom: 25px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        font-weight: 800;
        font-size: 1.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* 2. CARD STYLING */
    .profile-card {
        background: white;
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,0.1);
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 30px;
    }

    /* 3. SECTION TITLE */
    .section-title {
        color: #d32f2f;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    /* 4. CUSTOM INPUT FIELDS */
    .input-group-text {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-right: none;
        color: #333;
        font-size: 1.2rem;
    }
    .form-control-custom {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-left: none;
        padding: 10px;
        font-weight: 500;
        color: #495057;
    }
    .form-control-custom:focus {
        background-color: #e9ecef;
        box-shadow: none;
        border-color: #a71b1b;
    }
    .input-group { margin-bottom: 20px; }

    /* 5. UPDATE BUTTON */
    .btn-update {
        background: linear-gradient(90deg, #a71b1b 0%, #880f0b 100%);
        color: white;
        width: 100%;
        padding: 12px;
        border-radius: 5px;
        border: none;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: transform 0.2s;
        margin-top: 10px;
    }
    .btn-update:hover {
        background: linear-gradient(90deg, #880f0b 0%, #680a0a 100%);
        color: white;
        transform: translateY(-2px);
    }
</style>

<div class="dashboard-wrapper">
    <?php include("components/sidebar.php"); ?>

    <main class="main-content">
        
        <div class="profile-header-banner">
            PROFILE
        </div>

        <div class="profile-card">
            <div class="section-title">
                <i class="bi bi-person-circle"></i> Edit Profile
            </div>

            <form id="editUserForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" id="name" name="name" class="form-control form-control-custom" required placeholder="Full Name" value="<?= isset($user['name']) ? $user['name'] : '' ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" id="email" name="email" class="form-control form-control-custom" required placeholder="Email" value="<?= isset($user['email']) ? $user['email'] : '' ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" id="newPassword" name="newPassword" class="form-control form-control-custom" placeholder="New Password">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" id="newPassword2" name="newPassword2" class="form-control form-control-custom" placeholder="Repeat New Password">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-update">
                    <i class="bi bi-box-arrow-in-down me-2"></i> Update
                </button>
            </form>
        </div>
    </main>
</div>

<?php include("components/footer-scripts.php"); ?>

<script>
    $(document).ready(function() {
        // Toggle Sidebar
        $(document).off('click', '.sidebar-toggle').on('click', '.sidebar-toggle', function() {
            $(".dashboard-wrapper").toggleClass("toggled");
        });

        // Update Profile Logic
        $("#editUserForm").on('submit', function(e) {
            e.preventDefault();
            
            let p1 = $("#newPassword").val();
            let p2 = $("#newPassword2").val();

            if(p1 !== "" && p1 !== p2) {
                alert("Passwords do not match!");
                return;
            }

            alert("Ready to update profile!");
            // Add AJAX call here
        });
    });
</script>

<?php include("components/footer.php"); ?>