<?php include("components/header.php"); ?>

<!-- Hidden Input -->
<input type="hidden" id="hidden_user_id" value="<?= $auth_user_id ?>">

<div class="container py-4">

    <div class="card shadow-sm rounded-3 p-4 mx-auto" style="max-width: 700px;">
        <h4 class="mb-3 text-main">
            <i class="bi bi-person-circle me-2"></i>Edit Profile
        </h4>

        <form id="editUserForm">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="input-group input-group-sm">
                        <label for="name" class="input-group-text">
                            <i class="bi bi-person-fill"></i>
                        </label>
                        <input type="text" id="name" name="name" class="form-control" required placeholder="Full Name">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="input-group input-group-sm">
                        <label for="email" class="input-group-text">
                            <i class="bi bi-envelope-fill"></i>
                        </label>
                        <input type="email" id="email" name="email" class="form-control" required placeholder="Email Address">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="input-group input-group-sm">
                        <label for="newPassword" class="input-group-text">
                            <i class="bi bi-lock-fill"></i>
                        </label>
                        <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="New Password">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="input-group input-group-sm">
                        <label for="newPassword2" class="input-group-text">
                            <i class="bi bi-lock-fill"></i>
                        </label>
                        <input type="password" id="newPassword2" name="newPassword2" class="form-control" placeholder="Repeat New Password">
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-main btn-sm text-white w-100">
                    <i class="bi bi-save me-1"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>

<?php include("components/footer-scripts.php"); ?>
<script src="scripts/profile.js"></script>
<?php include("components/footer.php"); ?>