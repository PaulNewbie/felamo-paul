$(document).ready(function () {
  const level_id = $("#hidden_level_id").val();
  const firstFilterValue = "ALL";

  const showAlert = (type, message) => {
    $("#alert").removeClass().addClass(`alert ${type}`).text(message).show();

    setTimeout(() => {
      $("#alert").fadeOut("slow", function () {
        $(this).removeClass().text("").hide();
      });
    }, 2000);
  };

  const loadTakenAssessment = (filter) => {
    $.ajax({
      type: "POST",
      url: "../backend/api/web/taken_assessment.php",
      data: { requestType: "GetTakenAssessments", filter, level_id },
      success: function (response) {
        let res = JSON.parse(response);

        if (res.status === "success") {
          const assessments = res.data;
          let rowsHtml = "";

          assessments.forEach((assessment) => {
            rowsHtml += `
                <tr>
                  <td>${assessment.lrn}</td>
                  <td>${assessment.first_name + " " + assessment.last_name}</td>
                  <td>${assessment.points}</td>
                  <td>${assessment.total}</td>
                  <td>${assessment.created_at}</td>
                  <td>${assessment.total_attempts}</td>
                  <td></td>
                </tr>
              `;
          });

          $("#taken-assessment-table-tbody").html(rowsHtml);
        } else {
          $("#taken-assessment-table-tbody").html(
            `<tr><td colspan="5">Failed to load assessment: ${res.message}</td></tr>`
          );
        }
      },
      error: function () {
        $("#taken-assessment-table-tbody").html(
          `<tr><td colspan="5">Server error while loading assessment.</td></tr>`
        );
      },
    });
  };

  $("#filter").change(function (e) {
    e.preventDefault();
    loadTakenAssessment($(this).val());
  });

  $("#download-csv").click(function () {
    let csv = [];
    let rows = $("#taken-assessment-table tr");

    rows.each(function () {
      let cols = $(this).find("th, td");
      let row = [];

      cols.each(function () {
        let text = $(this).text().trim().replace(/"/g, '""'); // escape quotes
        row.push('"' + text + '"');
      });

      csv.push(row.join(","));
    });

    let csvString = csv.join("\n");
    let blob = new Blob([csvString], { type: "text/csv;charset=utf-8;" });
    let link = document.createElement("a");

    link.href = URL.createObjectURL(blob);
    link.download = "taken_assessments.csv";
    link.click();
  });

  loadTakenAssessment(firstFilterValue);
});
