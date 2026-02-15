<?php
include("components/header.php");

$isSuperAdmin = $user['role'] === 'super_admin';

$sections = $AuthController->GetAllSections();
?>

<!-- Hidden Inputs -->
<input type="hidden" id="hidden_user_id" value="<?= $auth_user_id ?>">
<input type="hidden" id="hidden_is_super_admin" value="<?= $isSuperAdmin ? 'true' : 'false' ?>">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-main mb-0">
            <i class="bi bi-person-lines-fill me-2"></i>
            <?= $isSuperAdmin ? "Students" : "My Students" ?>
        </h4>

        <div class="input-group input-group-sm w-auto">
            <label for="sectionDropDown" class="input-group-text">
                <i class="bi bi-diagram-3 me-1"></i>Section
            </label>
            <select name="section_id" id="sectionDropdown" class="form-select">
                <option value=""></option>
                <?php while ($section = $sections->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($section['id']) ?>">
                        <?= htmlspecialchars($section['section_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
    </div>

    <div class="card shadow-sm rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped table-sm align-middle mb-0" style="font-size: 12px;">
                    <thead class="table-light">
                        <tr>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Section</th>
                            <th>LRN</th>
                            <th>Birth Date</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Contact no</th>
                            <th>Points</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="students-table-tbody">
                        <!-- Dynamically loaded -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Aralin Progress -->
<div class="modal fade" id="progressModal" tabindex="-1" aria-labelledby="progressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-main text-white">
                <h5 class="modal-title" id="progressModalLabel">
                    <i class="bi bi-graph-up-arrow me-2"></i>Student Aralin Progress
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm" style="font-size: 13px;">
                    <thead class="table-light">
                        <tr>
                            <th>Markahan</th>
                            <th>Aralin No.</th>
                            <th>Title</th>
                            <th>Completed At</th>
                        </tr>
                    </thead>
                    <tbody id="progressModalBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("components/footer-scripts.php"); ?>

<script>
    $(document).ready(function() {
        const auth_user_id = $("#hidden_user_id").val();
        const is_super_admin = $("#hidden_is_super_admin").val();
        const section_id = null;

        const showAlert = (type, message) => {
            $("#alert").removeClass().addClass(`alert ${type}`).text(message).show();

            setTimeout(() => {
                $("#alert").fadeOut("slow", function() {
                    $(this).removeClass().text("").hide();
                });
            }, 2000);
        };

        const loadStudent = (section_id) => {
            $.ajax({
                type: "POST",
                url: "../backend/api/web/students.php",
                data: {
                    requestType: "GetStudents",
                    auth_user_id,
                    is_super_admin,
                    section_id
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    if (res.status === "success") {
                        const students = res.data;
                        let rowsHtml = "";

                        students.forEach((student) => {
                            rowsHtml += `
                                <tr>
                                    <td>${student.first_name ?? ""}</td>
                                    <td>${student.middle_name ?? ""}</td>
                                    <td>${student.last_name ?? ""}</td>
                                    <td>${student.section_name ?? ""}</td>
                                    <td>${student.student_lrn ?? ""}</td>
                                    <td>${student.birth_date ?? ""}</td>
                                    <td>${student.gender ?? ""}</td>
                                    <td>${student.email ?? ""}</td>
                                    <td>${student.contact_no ?? ""}</td>
                                    <td>${student.points ?? ""}</td>
                                    <td>
                                        ${student.id
                                            ? `<button class="btn-view-progress btn btn-sm btn-main text-white" data-id="${student.id}">
                                                <i class="bi bi-eye-fill me-1"></i>Progress
                                               </button>`
                                            : ""}
                                    </td>
                                </tr>
                            `;
                        });

                        $("#students-table-tbody").html(rowsHtml);
                    } else {
                        $("#students-table-tbody").html(
                            `<tr><td colspan="10">Failed to load students: ${res.message}</td></tr>`
                        );
                    }
                },
                error: function() {
                    showAlert("alert-danger", "Something went wrong!");
                },
            });
        };

        $(document).on("click", ".btn-view-progress", function(e) {
            e.preventDefault();

            let userId = $(this).data("id");

            $.ajax({
                type: "POST",
                url: "../backend/api/web/aralin.php",
                data: {
                    requestType: "GetDoneAralin",
                    userId
                },
                success: function(response) {
                    let res = JSON.parse(response);

                    if (res.status === "success") {
                        let rows = "";
                        res.data.forEach(item => {
                            rows += `
                                <tr>
                                    <td>
                                    ${item.level == 1 ? "Unang markahan" :
                                        item.level == 2 ? "Pangalawang markahan" :
                                        item.level == 3 ? "Pangatlong markahan" :
                                        item.level == 4 ? "Ika-apat na markahan" :
                                        "Hindi kilalang markahan"}
                                    </td>

                                    <td>Aralin ${item.aralin_no}</td>
                                    <td>${item.title}</td>
                                    <td>${new Date(item.completed_at).toLocaleString('en-US', {
                                        month: 'long',
                                        day: 'numeric',
                                        year: 'numeric',
                                        hour: 'numeric',
                                        minute: '2-digit',
                                        hour12: true
                                    })}</td>
                                </tr>
                            `;
                        });

                        $("#progressModalBody").html(rows);
                        const progressModal = new bootstrap.Modal(document.getElementById('progressModal'));
                        progressModal.show();
                    } else {
                        showAlert("alert-danger", res.message || "No progress data.");
                    }
                },
                error: function() {
                    showAlert("alert-danger", "Something went wrong!");
                }
            });
        });

        $("#sectionDropdown").change(function(e) {
            e.preventDefault();
            loadStudent($(this).val());
        });

        loadStudent(section_id);
    });
</script>

<?php include("components/footer.php"); ?>