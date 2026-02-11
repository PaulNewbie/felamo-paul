<?php
include("components/header.php");
// $auth_user_id
$sections = $AuthController->GetSections($auth_user_id);
?>

<!-- hidden inputs -->
<input type="hidden" id="hidden_user_id" value="<?= $auth_user_id ?>">

<div class="container py-4">

    <h4 class="text-main mb-3">
        <i class="bi bi-bell-fill me-2"></i>Notifications
    </h4>

    <div class="d-flex justify-content-end mb-2">
        <button class="btn btn-sm btn-main text-light" data-bs-toggle="modal" data-bs-target="#notificationModal">
            <i class="bi bi-plus-circle me-1"></i>Send Notification
        </button>
    </div>

    <div id="alert" style="position: absolute; top:10px; right:10px; font-size: 12px;"></div>

    <table class="table table-striped table-sm" style="font-size: 12px;">
        <thead>
            <tr>
                <th><i class="bi bi-diagram-3 me-1"></i>Section</th>
                <th><i class="bi bi-chat-left-text me-1"></i>Title</th>
                <th><i class="bi bi-file-text me-1"></i>Description</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody id="notif-table-tbody"></tbody>
    </table>
</div>

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="notificationForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">
                        <i class="bi bi-pencil-square me-2"></i>Send Notification
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="notifSection" class="form-label">
                            <i class="bi bi-diagram-3 me-1"></i>Section
                        </label>
                        <select name="section" id="notifSection" class="form-control" required>
                            <option></option>
                            <?php while ($section = $sections->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($section['id']) ?>">
                                    <?= htmlspecialchars($section['section_name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notifTitle" class="form-label">
                            <i class="bi bi-chat-left-text me-1"></i>Title
                        </label>
                        <input type="text" class="form-control" id="notifTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="notifDescription" class="form-label">
                            <i class="bi bi-file-text me-1"></i>Description
                        </label>
                        <textarea class="form-control" id="notifDescription" name="description" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i>Send Notification
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include("components/footer-scripts.php"); ?>
<script src="scripts/notifications.js"></script>
<?php include("components/footer.php"); ?>