$(document).ready(function () {
  const level_id = $("#hidden_level_id").val();

  const showAlert = (type, message) => {
    $("#alert").removeClass().addClass(`alert ${type}`).text(message).show();

    setTimeout(() => {
      $("#alert").fadeOut("slow", function () {
        $(this).removeClass().text("").hide();
      });
    }, 2000);
  };

  const loadAralins = () => {
    $.ajax({
      type: "POST",
      url: "../backend/api/web/aralin.php",
      data: { requestType: "GetAralin", level_id },
      success: function (response) {
        let res = JSON.parse(response);

        if (res.status === "success") {
          const aralins = res.data;
          let rowsHtml = "";

          aralins.forEach((aralin) => {
            rowsHtml += `
              <tr>
                <td>${aralin.aralin_no}</td>
                <td>${aralin.title}</td>
                <td class="text-truncate" style="max-width: 200px;" title="${
                  aralin.summary
                }">
                  ${aralin.summary}
                </td>
                <td class="text-truncate" style="max-width: 200px;" title="${
                  aralin.details
                }">
                  ${aralin.details}
                </td>
                <td>
                  <div class='d-flex align-items-center'>
                    <a href="/backend/storage/videos/${
                      aralin.attachment_filename
                    }" target="_blank">View Videoo</a>
                    <button class="btnEditAralin btn btn-main btn-sm text-light"
                      data-id="${aralin.id}"
                      data-title="${aralin.title || ""}"
                      data-summary="${aralin.summary || ""}"
                      data-details="${aralin.details || ""}"
                      data-filename="${aralin.attachment_filename || ""}"
                    >
                      Edit
                    </button>
                    <a class="btn btn-secondary" href="watch_history.php?aralinId=${
                      aralin.id
                    }">Mga Nakapanood</a>
                  </div>
                </td>
                <td>
                </td>
              </tr>
            `;
          });

          $("#antas-details-table-tbody").html(rowsHtml);
        } else {
          $("#antas-details-table-tbody").html(
            `<tr><td colspan="5">Failed to load aralin: ${res.message}</td></tr>`
          );
        }
      },
      error: function () {
        $("#antas-details-table-tbody").html(
          `<tr><td colspan="5">Server error while loading aralin.</td></tr>`
        );
      },
    });
  };

  $("#insert-aralin-form").on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    $.ajax({
      type: "POST",
      url: "../backend/api/web/aralin.php",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        try {
          let res =
            typeof response === "string" ? JSON.parse(response) : response;

          if (res.status === "success") {
            showAlert("alert-success", res.message);

            loadAralins();

            $("#insertAralinModal").modal("hide");
            $("#insert-aralin-form")[0].reset();
          } else {
            showAlert("alert-danger", "Upload failed: " + res.message);
          }
        } catch (err) {
          console.error("Invalid response:", response);
          showAlert("alert-danger", "Unexpected error occurred.");
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
        showAlert("alert-danger", "Request failed.");
      },
    });
  });

  $(document).on("click", ".btnEditAralin", function () {
    const id = $(this).data("id");
    const title = $(this).data("title");
    const summary = $(this).data("summary");
    const details = $(this).data("details");
    const filename = $(this).data("filename");

    $("#edit-aralin-id").val(id);
    $("#edit-aralin-title").val(title);
    $("#edit-aralin-summary").val(summary);
    $("#edit-aralin-details").val(details);

    $("#current-video-link").attr(
      "href",
      "/backend/storage/videos/" + filename
    );

    $("#editAralinModal").modal("show");
  });

  $("#edit-aralin-form").on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    $.ajax({
      type: "POST",
      url: "../backend/api/web/aralin.php",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        try {
          let res =
            typeof response === "string" ? JSON.parse(response) : response;

          if (res.status === "success") {
            showAlert("alert-success", res.message);

            loadAralins();

            $("#editAralinModal").modal("hide");
            $("#edit-aralin-form")[0].reset();
          } else {
            showAlert("alert-danger", "Upload failed: " + res.message);
          }
        } catch (err) {
          console.error("Invalid response:", response);
          showAlert("alert-danger", "Unexpected error occurred.");
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
        showAlert("alert-danger", "Request failed.");
      },
    });
  });

  loadAralins();
});
