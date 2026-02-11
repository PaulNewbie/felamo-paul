<?php 
// 1. Include the global header
include("components/header.php"); 

// 2. Define role and user variables
$isSuperAdmin = isset($user['role']) && $user['role'] === 'super_admin'; 
$currentUserId = isset($user['id']) ? $user['id'] : (isset($auth_user_id) ? $auth_user_id : 0);
?>

<input type="hidden" id="hidden_user_id" value="<?= $currentUserId ?>">

<style>
    /* --- CRITICAL FIX: HIDE THE TOP NAVBAR --- */
    .navbar, header, .main-header { display: none !important; }

    /* --- PAGE LAYOUT --- */
    body { background-color: #f4f6f9; overflow-x: hidden; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .dashboard-wrapper { display: flex; min-height: 100vh; width: 100%; }
    
    /* MAIN CONTENT AREA */
    .main-content { 
        flex: 1; 
        margin-left: 260px; /* Aligns with sidebar width */
        padding: 30px 40px; 
        transition: margin-left 0.3s ease; 
    }
    
    /* Mobile Responsive adjustment */
    .dashboard-wrapper.toggled .main-content { margin-left: 0; }
    @media (max-width: 768px) { .main-content { margin-left: 0; padding: 20px; } }

    /* 1. PROFILE BANNER */
    .profile-header-banner {
        background: linear-gradient(90deg, #a71b1b 0%, #d32f2f 100%);
        color: white;
        padding: 20px 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(167, 27, 27, 0.3);
        font-weight: 800;
        font-size: 1.8rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        display: flex;
        align-items: center;
    }
    .profile-header-banner i { margin-right: 15px; font-size: 2rem; }

    /* 2. CARD STYLING */
    .profile-card {
        background: white;
        border-radius: 12px;
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        padding: 35px;
        margin-bottom: 30px;
    }

    /* 3. SECTION TITLE */
    .section-title {
        color: #a71b1b;
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
    }

    /* 4. CUSTOM INPUT FIELDS */
    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #e0e0e0;
        border-right: none;
        color: #a71b1b;
        font-size: 1.1rem;
        border-radius: 8px 0 0 8px;
    }
    .form-control-custom {
        background-color: #f8f9fa;
        border: 1px solid #e0e0e0;
        border-left: none;
        padding: 12px 15px;
        font-weight: 500;
        color: #495057;
        border-radius: 0 8px 8px 0;
        transition: all 0.3s;
    }
    .form-control-custom:focus {
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(167, 27, 27, 0.1);
        border-color: #a71b1b;
    }
    .input-group { margin-bottom: 25px; }
    .form-label { font-size: 0.85rem; font-weight: 600; color: #6c757d; margin-bottom: 8px; text-transform: uppercase; }

    /* 5. UPDATE BUTTON */
    .btn-update {
        background: linear-gradient(90deg, #a71b1b 0%, #c62828 100%);
        color: white;
        width: 100%;
        padding: 14px;
        border-radius: 8px;
        border: none;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        margin-top: 15px;
        box-shadow: 0 4px 6px rgba(167, 27, 27, 0.2);
    }
    .btn-update:hover {
        background: linear-gradient(90deg, #8e1616 0%, #b71c1c 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(167, 27, 27, 0.3);
    }
</style>

<div class="dashboard-wrapper">
    <?php include("components/sidebar.php"); ?>

    <main class="main-content">
        <div class="profile-header-banner">
            <i class="bi bi-person-badge"></i> User Profile
        </div>

        <div class="profile-card">
            <div class="section-title">
                <i class="bi bi-pencil-square"></i> Edit Account Details
            </div>

            <form id="editUserForm">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" id="name" name="name" class="form-control form-control-custom" required placeholder="Enter your full name" value="<?= isset($user['name']) ? htmlspecialchars($user['name']) : '' ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" id="email" name="email" class="form-control form-control-custom" required placeholder="Enter your email" value="<?= isset($user['email']) ? htmlspecialchars($user['email']) : '' ?>">
                        </div>
                    </div>

                    <div class="col-12"><hr class="my-4" style="opacity: 0.1;"></div>

                    <div class="col-md-6">
                        <label class="form-label">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" id="newPassword" name="newPassword" class="form-control form-control-custom" placeholder="Leave blank to keep current">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-check-circle-fill"></i></span>
                            <input type="password" id="newPassword2" name="newPassword2" class="form-control form-control-custom" placeholder="Repeat new password">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-update" id="btnUpdate">
                    <i class="bi bi-save me-2"></i> Save Changes
                </button>
            </form>
        </div>
    </main>
</div>

<?php include("components/footer-scripts.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        
        // --- NOTE: Sidebar logic removed from here because it is already in sidebar.php ---

        // Handle Profile Update
        $("#editUserForm").on('submit', function(e) {
            e.preventDefault();
            
            const btn = $("#btnUpdate");
            const originalText = btn.html();
            
            // Get form values
            const userId = $("#hidden_user_id").val();
            const name = $("#name").val().trim();
            const email = $("#email").val().trim();
            const p1 = $("#newPassword").val();
            const p2 = $("#newPassword2").val();

            // Validation
            if(name === "" || email === "") {
                Swal.fire('Error', 'Name and Email are required.', 'error');
                return;
            }

            if(p1 !== "" && p1 !== p2) {
                Swal.fire('Error', 'Passwords do not match!', 'error');
                return;
            }

            // Prepare Data for AJAX
            let formData = new FormData();
            formData.append('user_id', userId);
            formData.append('name', name);
            formData.append('email', email);
            if(p1 !== "") {
                formData.append('password', p1);
            }

            // UI Loading State
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');

            // AJAX Request
            $.ajax({
                url: '../backend/api/app/edit-profile.php', 
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    btn.prop('disabled', false).html(originalText);
                    
                    if (response.status === 'success' || response.success === true) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Profile updated successfully.',
                            icon: 'success',
                            confirmButtonColor: '#a71b1b'
                        }).then(() => {
                            location.reload(); 
                        });
                    } else {
                        Swal.fire('Error', response.message || 'Failed to update profile.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    btn.prop('disabled', false).html(originalText);
                    console.error("Error:", error);
                    Swal.fire('Error', 'An unexpected error occurred. Please try again.', 'error');
                }
            });
        });
    });
</script>

<?php include("components/footer.php"); ?>