<?php
include("components/header.php");

$sections = $AuthController->GetSections($auth_user_id);
?>

<!-- hidden inputs -->
<input type="hidden" id="hidden_user_id" value="<?= $auth_user_id ?>">

<div class="container py-4">

    <h4 class="text-main mb-3">
        <i class="bi bi-trophy-fill me-2"></i>Leader Boards
    </h4>

    <div class="d-flex justify-content-end">
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

    <table class="table table-striped table-sm mt-3" style="font-size: 12px;">
        <thead>
            <tr>
                <th><i class="bi bi-sort-numeric-down me-1"></i>Rank</th>
                <th><i class="bi bi-person-vcard me-1"></i>LRN</th>
                <th><i class="bi bi-person me-1"></i>First Name</th>
                <th><i class="bi bi-person me-1"></i>Middle Name</th>
                <th><i class="bi bi-person me-1"></i>Last Name</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="leader-boards-table-tbody"></tbody>
    </table>
</div>

<?php include("components/footer-scripts.php"); ?>

<script>
    $(document).ready(function() {
        const teacher_id = $("#hidden_user_id").val();
        const section_id = null;

        const showAlert = (type, message) => {
            $("#alert").removeClass().addClass(`alert ${type}`).text(message).show();

            setTimeout(() => {
                $("#alert").fadeOut("slow", function() {
                    $(this).removeClass().text("").hide();
                });
            }, 2000);
        };

        const loadLeaderBoards = (section_id) => {
            $.ajax({
                type: "POST",
                url: "../backend/api/web/leader_boards.php",
                data: {
                    requestType: "GetLeaderBoards",
                    teacher_id,
                    section_id
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    console.log(res);

                    if (res.status === "success") {
                        let rows = "";

                        res.data.forEach((student, index) => {
                            rows += `
        <tr>
            <td>${index + 1}</td>
            <td>${student.lrn}</td>
            <td>${student.first_name ?? ""}</td>
            <td>${student.middle_name ?? ""}</td>
            <td>${student.last_name ?? ""}</td>
            <td></td>
        </tr>
    `;
                        });

                        $("#leader-boards-table-tbody").html(rows);
                    } else {
                        $("#leader-boards-table-tbody").html(`
              <tr><td colspan="6" class="text-center text-danger">Failed to load leader boards</td></tr>
            `);
                    }
                },
                error: function() {
                    $("#leader-boards-table-tbody").html(`
            <tr><td colspan="6" class="text-center text-danger">Error connecting to server</td></tr>
          `);
                },
            });
        };

        $("#sectionDropdown").change(function(e) {
            e.preventDefault();
            loadLeaderBoards($(this).val());
        });

        loadLeaderBoards(section_id);
    });
</script>

<?php include("components/footer.php"); ?>