$(document).ready(function () {
  const showAlert = (type, message) => {
    $("#alert").removeClass().addClass(`alert ${type}`).text(message).show();

    setTimeout(() => {
      $("#alert").fadeOut("slow", function () {
        $(this).removeClass().text("").hide();
      });
    }, 2000);
  };

  const loadTeacher = () => {
    $.ajax({
      type: "POST",
      url: "../backend/api/web/admin.php",
      data: { requestType: "GetTeachers" },
      success: function (response) {
        try {
          let res = JSON.parse(response);
          if (res.status === "success") {
            let tbody = $("#teacher-table-tbody");
            tbody.empty();

            res.data.forEach((teacher) => {
              const status = teacher.is_active == 1 ? "Active" : "Inactive";

              tbody.append(`
                  <tr>
                    <td>${teacher.name}</td>
                    <td>${teacher.email}</td>
                    <td>${teacher.grade_level ?? "N/A"}</td>
                    <td>${status}</td>
                    <td>
                        <a href="assign_sections.php?tId=${
                          teacher.id
                        }" class="btn btn-sm btn-primary" style="font-size: 12px">Assign Section</a>
                    </td>
                  </tr>
                `);
            });
          } else {
            showAlert("alert-danger", "Failed to load teachers.");
          }
        } catch (err) {
          console.error("JSON parse error:", err);
          showAlert("alert-danger", "Invalid server response.");
        }
      },
      error: function () {
        showAlert("alert-danger", "Error fetching teacher data.");
      },
    });
  };

  $("#insert-teacher-form").submit(function (e) {
    e.preventDefault();

    const name = $("#teacher-name").val().trim();
    // const grade = $("#teacher-grade-level").val().trim();
    // const section = $("#teacher-section").val().trim();
    const email = $("#teacher-email").val().trim();
    const password = $("#teacher-password").val();

    if (!name || !email || !password) {
      showAlert("alert-warning", "All fields are required.");
      return;
    }

    $.ajax({
      type: "POST",
      url: "../backend/api/web/admin.php",
      data: {
        requestType: "InsertTeacher",
        name,
        // grade,
        // section,
        email,
        password,
      },
      success: function (response) {
        try {
          let res = JSON.parse(response);
          if (res.status === "success") {
            showAlert("alert-success", res.message);
            loadTeacher();
            $("#insert-teacher-form")[0].reset();

            const modal = bootstrap.Modal.getInstance(
              document.getElementById("insertTeacherModal")
            );
            if (modal) modal.hide();
          } else {
            showAlert("alert-danger", res.message || "Insert failed.");
          }
        } catch (err) {
          console.error("JSON parse error:", err);
          showAlert("alert-danger", "Unexpected response from server.");
        }
      },
      error: function () {
        showAlert("alert-danger", "Failed to submit data.");
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
      let teacherAccs = [];

      rows.slice(1).forEach((row, index) => {
        const columns = row.split(",");
        const accName = columns[0]?.trim();
        const accEmail = columns[1]?.trim();
        const accPassword = columns[2]?.trim();

        const obj = {
          name: accName,
          email: accEmail,
          password: accPassword,
        };

        teacherAccs.push(obj);
      });

      console.log(teacherAccs);

      $.ajax({
        type: "POST",
        url: "../backend/api/web/admin.php",
        data: {
          requestType: "ImportTeachers",
          teacherAccs: JSON.stringify(teacherAccs),
        },
        success: function (response) {
          let res = JSON.parse(response);

          if (res.status === "success") {
            showAlert("alert-success", res.message);
            loadTeacher();
          } else {
            showAlert("alert-danger", res.message);
          }
        },
      });
    };

    reader.readAsText(file);
  });

  loadTeacher();
});
