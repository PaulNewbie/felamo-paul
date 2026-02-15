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
?>

<!-- hidden inputs -->
<input type="hidden" id="hidden_section_id" value="<?= $sectionId ?>">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-main">
            <i class="bi bi-people-fill me-2"></i>Students of Section <?= $section['section_name'] ?>
        </h4>
    </div>

    <!-- <div class="d-flex justify-content-end align-items-center">
        <div class="me-2">
            <button class="btn btn-sm btn-main text-light" data-bs-toggle="modal" data-bs-target="#insertStudentModal">Insert Students</button>
        </div>
    </div> -->

    <div id="alert" style="position: absolute; top:10px; right:10px; font-size: 12px;"></div>

    <table class="table table-sm table-striped" style="font-size: 13px;">
        <thead>
            <tr>
                <th><i class="bi bi-person-vcard me-1"></i>LRN</th>
                <th><i class="bi bi-person me-1"></i>First Name</th>
                <th><i class="bi bi-person me-1"></i>Middle Name</th>
                <th><i class="bi bi-person me-1"></i>Last Name</th>
                <th><i class="bi bi-person me-1"></i>Birth Date</th>
                <th><i class="bi bi-person me-1"></i>Gender</th>
                <th>Email</th>
                <th>Contact no</th>
            </tr>
        </thead>
        <tbody id="student-table-tbody"></tbody>
    </table>
</div>

<?php
include("components/footer-scripts.php");
?>

<script>
    const section_id = $("#hidden_section_id").val();
    const loadAssignedStudents = () => {
        $.ajax({
            type: "POST",
            url: "../backend/api/web/student_teacher_assignment.php",
            data: {
                requestType: "GetAssignedStudents",
                section_id
            },
            success: function(response) {
                let res = JSON.parse(response);
                console.log(res);

                if (res.status === "success") {
                    let rows = "";

                    res.data.forEach((student) => {
                        const fullName = `${student.first_name ?? ""} ${
                            student.middle_name ?? ""
                        } ${student.last_name ?? ""}`.trim();

                        rows += `
                <tr>
                  <td>${student.student_lrn}</td>
                  <td>${student.first_name ?? ""}</td>
                  <td>${student.middle_name ?? ""}</td>
                  <td>${student.last_name ?? ""}</td>
                  <td>${student.birth_date ?? ""}</td>
                  <td>${student.gender ?? ""}</td>
                  <td>${student.student_email ?? ""}</td>
                  <td>${student.contact_no ?? ""}</td>
                </tr>
              `;
                    });

                    $("#student-table-tbody").html(rows);
                } else {
                    $("#student-table-tbody").html(`
              <tr><td colspan="5" class="text-center text-danger">Failed to load students</td></tr>
            `);
                }
            },
            error: function() {
                $("#student-table-tbody").html(`
            <tr><td colspan="5" class="text-center text-danger">Error connecting to server</td></tr>
          `);
            },
        });
    };

    loadAssignedStudents();
</script>

<?php
include("components/footer.php");
?>