$(document).ready(function () {
  const auth_user_id = $("#hidden_user_id").val();

  const loadAntas = () => {
    $.ajax({
      type: "POST",
      url: "../backend/api/web/levels.php",
      data: { requestType: "GetLevels", auth_user_id },
      success: function (response) {
        let res = JSON.parse(response);
        console.log(res);

        if (res.status === "success") {
          let levels = res.data;
          let html = "";

          if (levels.length === 0) {
            html = `<tr><td colspan="2" class="text-center text-muted">Walang antas.</td></tr>`;
          } else {
            levels.forEach((level) => {
              switch (level.level) {
                case 1:
                  markahan = "Unang markahan";
                  break;
                case 2:
                  markahan = "Pangalawang markahan";
                  break;
                case 3:
                  markahan = "Pangatlong markahan";
                  break;
                case 4:
                  markahan = "Ika-apat na markahan";
                  break;
                default:
                  markahan = "";
              }

              html += `
                  <tr>
                    <td>${markahan}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-main text-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item text-main" href='level_details.php?level=${level.id}'>View Details</a></li>
                                <li><a class="dropdown-item" href='create_assessment.php?level=${level.id}'>Create Assessment</a></li>
                                <li><a class="dropdown-item" href='taken_assessments.php?level=${level.id}'>View Taken Assessments</a></li>
                            </ul>
                        </div>
                    </td>

                  </tr>
                `;
            });
          }

          $("#antas-table-tbody").html(html);
        } else {
          $("#antas-table-tbody").html(
            `<tr><td colspan="2">Failed to load levels.</td></tr>`
          );
        }
      },
      error: function () {
        $("#antas-table-tbody").html(
          `<tr><td colspan="2">Server error.</td></tr>`
        );
      },
    });
  };

  loadAntas();
});
