<?php
include("components/header.php");
?>

<!-- hidden inputs -->
<input type="hidden" id="hidden_user_id" value="<?= $auth_user_id ?>">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-main">
            <i class="bi bi-diagram-3 me-2"></i>My Sections
        </h4>
    </div>

    <table class="table table-striped table-sm" style="font-size: 12px;">
        <thead>
            <tr>
                <th><i class="bi bi-people me-1"></i>Section</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="section-table-tbody"></tbody>
    </table>
</div>

<?php
include("components/footer-scripts.php");
?>

<script>
    $(document).ready(function() {
        const teacher_id = $("#hidden_user_id").val();

        const showAlert = (type, message) => {
            $("#alert").removeClass().addClass(`alert ${type}`).text(message).show();

            setTimeout(() => {
                $("#alert").fadeOut("slow", function() {
                    $(this).removeClass().text("").hide();
                });
            }, 2000);
        };

        const loadAssignedSections = () => {
            $.ajax({
                type: "POST",
                url: "../backend/api/web/section_assignment.php",
                data: {
                    requestType: "GetAssignedSections",
                    teacher_id
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    console.log(res);

                    if (res.status === "success") {
                        let rows = "";

                        res.data.forEach((section) => {
                            rows += `
                <tr>
                  <td>${section.section_name}</td>
                  <td>
                    <a href="section_students.php?sectionId=${section.id}" class="btn btn-sm btn-primary" style="font-size: 12px">
                      <i class="bi bi-person-lines-fill me-1"></i>View Students
                    </a>
                  </td>
                </tr>
              `;
                        });

                        $("#section-table-tbody").html(rows);
                    } else {
                        $("#section-table-tbody").html(`
              <tr><td colspan="2" class="text-center text-danger">Failed to load sections</td></tr>
            `);
                    }
                },
                error: function() {
                    $("#section-table-tbody").html(`
            <tr><td colspan="2" class="text-center text-danger">Error connecting to server</td></tr>
          `);
                },
            });
        };

        loadAssignedSections();
    });
</script>

<?php
include("components/footer.php");
?>