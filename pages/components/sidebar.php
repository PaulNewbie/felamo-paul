<?php
// Ensure we don't crash if $user isn't set yet
$currentUserRole = $user['role'] ?? 'guest';
$currentUserName = $user['name'] ?? 'User';
$isSuperAdmin = $currentUserRole === 'super_admin';
$current_page = basename($_SERVER['PHP_SELF']); 
?>

<aside class="sidebar">
    <div class="sidebar-profile">
        <img src="../backend/storage/assets/logo.png" alt="Profile"> 
        <div>
            <h5><?= htmlspecialchars($currentUserName) ?></h5>
            <small style="opacity: 0.8; font-size: 0.7rem;">
                <?= $isSuperAdmin ? 'SUPER ADMIN' : strtoupper($currentUserRole) ?>
            </small>
        </div>
    </div>

    <nav class="nav flex-column">
        <a href="home.php" class="nav-link-custom <?= $current_page == 'home.php' ? 'active' : '' ?>">
            <i class="bi bi-house-door-fill"></i> HOME
        </a>
        
        <?php if ($currentUserRole == "teacher") { ?>
            <a href="levels.php" class="nav-link-custom <?= $current_page == 'levels.php' ? 'active' : '' ?>">
                <i class="bi bi-journal-bookmark-fill"></i> MARKAHAN
            </a>
            <a href="my_sections.php" class="nav-link-custom <?= $current_page == 'my_sections.php' ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i> SECTIONS
            </a>
            <a href="students.php" class="nav-link-custom <?= $current_page == 'students.php' ? 'active' : '' ?>">
                <i class="bi bi-person-badge-fill"></i> STUDENTS
            </a>
            <a href="notifications.php" class="nav-link-custom <?= $current_page == 'notifications.php' ? 'active' : '' ?>">
                <i class="bi bi-bell-fill"></i> NOTIFICATIONS
            </a>
        <?php } ?>

        <?php if ($currentUserRole == "super_admin") { ?>
            <a href="teachers.php" class="nav-link-custom <?= ($current_page == 'teachers.php' || $current_page == 'assign_sections.php' || $current_page == 'assign_students-v2.php') ? 'active' : '' ?>">
                <i class="bi bi-person-video3"></i> TEACHER
            </a>
            
            <a href="students.php" class="nav-link-custom <?= ($current_page == 'students.php' || $current_page == 'section_students.php') ? 'active' : '' ?>">
                <i class="bi bi-person-fill"></i> STUDENT
            </a>
        <?php } ?>
    </nav>

    <button class="logout-btn" type="button" data-bs-toggle="modal" data-bs-target="#logoutModal">
        LOG OUT
    </button>
    
    <div class="sidebar-toggle" id="sidebarToggleBtn">
        <i class="bi bi-chevron-left"></i>
    </div>
</aside>

<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="logoutModalLabel">
                    <i class="bi bi-box-arrow-right me-2"></i>Confirm Logout
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="mb-0 fs-5">Are you sure you want to log out?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="../logout.php" class="btn btn-danger">Yes, Log Out</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var toggleBtn = document.getElementById("sidebarToggleBtn");
        var wrapper = document.querySelector(".dashboard-wrapper");

        if (toggleBtn && wrapper) {
            toggleBtn.addEventListener("click", function() {
                wrapper.classList.toggle("toggled");
            });
        }
    });
</script>