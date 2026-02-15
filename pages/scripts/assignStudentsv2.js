$(document).ready(function () {
  const section_id = $("#hidden_section_id").val();

  const showAlert = (type, message) => {
    $("#alert").removeClass().addClass(`alert ${type}`).text(message).show();

    setTimeout(() => {
      $("#alert").fadeOut("slow", function () {
        $(this).removeClass().text("").hide();
      });
    }, 2000);
  };

  const loadAssignedStudents = () => {
    $.ajax({
      type: "POST",
      url: "../backend/api/web/student_teacher_assignment.php",
      data: { requestType: "GetAssignedStudents", section_id },
      success: function (response) {
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
                  <td>${student.student_email ?? ""}</td>
                  <td>${student.contact_no ?? ""}</td>
                  <td>${student.first_name ?? ""}</td>
                  <td>${student.middle_name ?? ""}</td>
                  <td>${student.last_name ?? ""}</td>
                  <td>${student.birth_date ?? ""}</td>
                  <td>${student.gender ?? ""}</td>
                  <td></td>
                </tr>
              `;
          });

          $("#student-table-tbody").html(rows);
        } else {
          $("#student-table-tbody").html(`
              <tr><td colspan="10" class="text-center text-danger">Failed to load students</td></tr>
            `);
        }
      },
      error: function () {
        $("#student-table-tbody").html(`
            <tr><td colspan="10" class="text-center text-danger">Error connecting to server</td></tr>
          `);
      },
    });
  };

  $("#assign-student-form").submit(function (e) {
    e.preventDefault();

    let data = {
      requestType: "AssignStudent",
      lrn: $("#assign_lrn").val(),
      first_name: $("#assign_first_name").val(),
      middle_name: $("#assign_middle_name").val(),
      last_name: $("#assign_last_name").val(),
      birth_date: $("#assign_birth_date").val(),
      gender: $("#assign_gender").val(),
      email: $("#assign_email").val(),
      contact_no: $("#assign_contactno").val(),
      // password: $("#assign_password").val(),
      section_id: section_id,
    };

    $.ajax({
      type: "POST",
      url: "../backend/api/web/student_teacher_assignment.php",
      data: data,
      success: function (response) {
        let res = JSON.parse(response);

        if (res.status === "success") {
          showAlert("alert-success", res.message);
          loadAssignedStudents();

          const modal = bootstrap.Modal.getInstance(
            document.getElementById("insertStudentModal")
          );
          if (modal) modal.hide();

          $("#assign-student-form")[0].reset();
        } else {
          if (res.errors) {
            showAlert("alert-danger", res.errors);
          } else {
            showAlert("alert-danger", res.message);
          }
        }
      },
      error: function (xhr, status, error) {
        showAlert("alert-danger", "Request failed: " + error);
      },
    });
  });

  $("#CSV").on("change", function (e) {
    const file = e.target.files[0];

    if (!file) {
      alert("No file selected.");
      return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
      const text = e.target.result;

      const rows = text.trim().split("\n");
      const students = [];

      rows.slice(1).forEach((row, index) => {
        const columns = row.split(",");

        const student = {
          lrn: columns[0]?.trim(),
          first_name: columns[1]?.trim(),
          middle_name: columns[2]?.trim(),
          last_name: columns[3]?.trim(),
          birth_date: columns[4]?.trim(),
          gender: columns[5]?.trim(),
          email: columns[6]?.trim(),
          password: columns[7]?.trim(),
        };

        students.push(student);
      });

      $.ajax({
        type: "POST",
        url: "../backend/api/web/student_teacher_assignment.php",
        data: { requestType: "ImportStudent", students, section_id },
        success: function (response) {
          let res = JSON.parse(response);

          if (res.status === "success") {
            showAlert("alert-success", res.message);
          } else {
            showAlert("alert-danger", res.message);
          }
          loadAssignedStudents();
        },
      });
    };

    reader.readAsText(file);
  });

  loadAssignedStudents();
});
