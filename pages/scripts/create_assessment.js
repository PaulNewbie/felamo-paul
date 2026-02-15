$(document).ready(function () {
  const auth_user_id = $("#auth_user_id").val();
  const level_id = $("#hidden_level_id").val();

  const showAlert = (type, message) => {
    $("#alert").removeClass().addClass(`alert ${type}`).text(message).show();

    setTimeout(() => {
      $("#alert").fadeOut("slow", function () {
        $(this).removeClass().text("").hide();
      });
    }, 2000);
  };

  const loadAssessment = () => {
    $.ajax({
      type: "POST",
      url: "../backend/api/web/asssessments.php",
      data: { requestType: "GetAssessment", level_id },
      success: function (response) {
        let res = JSON.parse(response);
        console.log(res);

        if (res.status === "success") {
          if (Array.isArray(res.data) && res.data.length > 0) {
            // has assesment

            $("#page-title-action-type").text("Edit");

            let assessment_id = res.data[0].id;

            $("#hiddenAssessmentId").val(assessment_id);
            $("#title").val(res.data[0].title);
            $("#description").val(res.data[0].description);

            $(".form-assesment-id").val(assessment_id);

            $("#button-create-assesment-action").text("Update Assessment");

            $(".DONTSHOWHENCREATEONLY").removeClass("d-none");

            loadMultipleChoiceQuestions(assessment_id);
            loadTrueOrFalseQuestions(assessment_id);
            loadIdentificationQuestions(assessment_id);
            loadJumbledWordsQuestions(assessment_id);
          } else {
            $("#page-title-action-type").text("Create");
            $("#button-create-assesment-action").text("Create Assessment");

            $(".DONTSHOWHENCREATEONLY").addClass("d-none");
          }
        }
      },
      error: function () {
        console.log("Server error.");
      },
    });
  };

  const loadMultipleChoiceQuestions = (assessment_id) => {
    $.ajax({
      type: "POST",
      url: "../backend/api/web/asssessments.php",
      data: { requestType: "GetMultiQuestions", assessment_id },
      success: function (response) {
        let res = JSON.parse(response);
        console.log(res);

        if (res.status === "success" && Array.isArray(res.data)) {
          const container = $("#multi-questions-container");
          container.empty();

          res.data.forEach((q, index) => {
            const card = `
              <div class="card p-3 mb-3">
                <div style="font-size: 14px; font-weight: bold;">${
                  index + 1
                }. ${q.question}</div>
                <div style="font-size: 12px;">a. ${q.choice_a}</div>
                <div style="font-size: 12px;">b. ${q.choice_b}</div>
                <div style="font-size: 12px;">c. ${q.choice_c}</div>
                <div style="font-size: 12px;">d. ${q.choice_d}</div>
                <div style="font-size: 12px; font-weight: bold;">answer: ${
                  q.correct_answer
                }</div>
              </div>
            `;
            container.append(card);
          });

          if (res.data.length === 0) {
            container.append(
              `<div class="text-muted">No multiple choice questions available.</div>`
            );
          }
        } else {
          console.warn("No data received.");
        }
      },
      error: function () {
        console.log("Server error.");
      },
    });
  };

  // GetTrueOrFalseQuestions

  const loadTrueOrFalseQuestions = (assessment_id) => {
    $.ajax({
      type: "POST",
      url: "../backend/api/web/asssessments.php",
      data: { requestType: "GetTrueOrFalseQuestions", assessment_id },
      success: function (response) {
        let res = JSON.parse(response);
        console.log(res);

        if (res.status === "success" && Array.isArray(res.data)) {
          const container = $("#t-or-f-questions-container");
          container.empty();

          res.data.forEach((q, index) => {
            const card = `
              <div class="card p-3 mb-3">
                <div style="font-size: 14px; font-weight: bold;">${
                  index + 1
                }. ${q.question}</div>
                <div style="font-size: 12px; font-weight: bold;">answer: ${
                  q.answer ? "True" : "False"
                }</div>
              </div>
            `;
            container.append(card);
          });

          if (res.data.length === 0) {
            container.append(
              `<div class="text-muted">No true or false questions available.</div>`
            );
          }
        } else {
          console.warn("No data received.");
        }
      },
      error: function () {
        console.log("Server error.");
      },
    });
  };

  const loadIdentificationQuestions = (assessment_id) => {
    $.ajax({
      type: "POST",
      url: "../backend/api/web/asssessments.php",
      data: { requestType: "GetIdentificationQuestions", assessment_id },
      success: function (response) {
        let res = JSON.parse(response);
        console.log(res);

        if (res.status === "success" && Array.isArray(res.data)) {
          const container = $("#identification-questions-container");
          container.empty();

          res.data.forEach((q, index) => {
            const card = `
              <div class="card p-3 mb-3">
                <div style="font-size: 14px; font-weight: bold;">${
                  index + 1
                }. ${q.question}</div>
                <div style="font-size: 12px; font-weight: bold;">answer: ${
                  q.answer
                }</div>
              </div>
            `;
            container.append(card);
          });

          if (res.data.length === 0) {
            container.append(
              `<div class="text-muted">No identification questions available.</div>`
            );
          }
        } else {
          console.warn("No data received.");
        }
      },
      error: function () {
        console.log("Server error.");
      },
    });
  };

  const loadJumbledWordsQuestions = (assessment_id) => {
    $.ajax({
      type: "POST",
      url: "../backend/api/web/asssessments.php",
      data: { requestType: "GetJumbledWordsQuestions", assessment_id },
      success: function (response) {
        let res = JSON.parse(response);
        console.log(res);

        if (res.status === "success" && Array.isArray(res.data)) {
          const container = $("#jumbled-words-questions-container");
          container.empty();

          res.data.forEach((q, index) => {
            const card = `
              <div class="card p-3 mb-3">
                <div style="font-size: 14px; font-weight: bold;">${
                  index + 1
                }. ${q.question}</div>
                <div style="font-size: 12px; font-weight: bold;">answer: ${
                  q.answer
                }</div>
              </div>
            `;
            container.append(card);
          });

          if (res.data.length === 0) {
            container.append(
              `<div class="text-muted">No jumbled words questions available.</div>`
            );
          }
        } else {
          console.warn("No data received.");
        }
      },
      error: function () {
        console.log("Server error.");
      },
    });
  };

  $("#create-assessment-form").submit(function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    $.ajax({
      type: "POST",
      url: "../backend/api/web/asssessments.php",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        let res = JSON.parse(response);
        console.log(res);

        if (res.status == "success") {
          showAlert("alert-success", res.message);
          loadAssessment();
        }
      },
    });
  });

  $("#multiple-choice-form").submit(function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    let assesment_id = $(".form-assesment-id").val();

    $.ajax({
      type: "POST",
      url: "../backend/api/web/asssessments.php",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        let res = JSON.parse(response);
        console.log(res);

        if (res.status == "success") {
          $("#multipleChoiceModal").modal("hide");
          $("#multiple-choice-form")[0].reset();
          showAlert("alert-success", res.message);

          loadMultipleChoiceQuestions(assesment_id);
        }
      },
    });
  });

  $("#true-false-form").submit(function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    let assesment_id = $(".form-assesment-id").val();

    $.ajax({
      type: "POST",
      url: "../backend/api/web/asssessments.php",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        let res = JSON.parse(response);
        console.log(res);

        if (res.status == "success") {
          $("#trueFalseModal").modal("hide");
          $("#true-false-form")[0].reset();
          showAlert("alert-success", res.message);

          loadTrueOrFalseQuestions(assesment_id);
        }
      },
    });
  });

  $("#identification-form").submit(function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    let assesment_id = $(".form-assesment-id").val();

    $.ajax({
      type: "POST",
      url: "../backend/api/web/asssessments.php",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        let res = JSON.parse(response);
        console.log(res);

        if (res.status == "success") {
          $("#identificationModal").modal("hide");
          $("#identification-form")[0].reset();
          showAlert("alert-success", res.message);

          loadIdentificationQuestions(assesment_id);
        }
      },
    });
  });

  $("#jumbled-words-form").submit(function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    let assesment_id = $(".form-assesment-id").val();

    $.ajax({
      type: "POST",
      url: "../backend/api/web/asssessments.php",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        let res = JSON.parse(response);
        console.log(res);

        if (res.status == "success") {
          $("#jumbledWordsModal").modal("hide");
          $("#jumbled-words-form")[0].reset();
          showAlert("alert-success", res.message);

          loadJumbledWordsQuestions(assesment_id);
        }
      },
    });
  });

  $("#multiple-choice-CSV").on("change", function (e) {
    const file = e.target.files[0];

    if (!file) {
      alert("No file selected.");
      return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
      const text = e.target.result;

      const rows = text.trim().split("\n");
      let questions = [];

      rows.slice(1).forEach((row, index) => {
        const columns = row.split(",");
        const question = columns[0]?.trim();
        const choice_a = columns[1]?.trim();
        const choice_b = columns[2]?.trim();
        const choice_c = columns[3]?.trim();
        const choice_d = columns[4]?.trim();
        const answer = columns[5]?.trim();

        const obj = {
          question,
          choice_a,
          choice_b,
          choice_c,
          choice_d,
          answer,
        };

        questions.push(obj);
      });

      console.log(questions);

      const assessment_id = $("#hiddenAssessmentId").val();

      $.ajax({
        type: "POST",
        url: "../backend/api/web/asssessments.php",
        data: {
          requestType: "ImportMultipleChoices",
          assessment_id,
          questions: JSON.stringify(questions),
        },
        success: function (response) {
          let res = JSON.parse(response);

          if (res.status === "success") {
            showAlert("alert-success", res.message);
            loadAssessment();
          } else {
            showAlert("alert-danger", res.message);
          }
        },
      });
    };

    reader.readAsText(file);
  });

  $("#true-or-false-CSV").on("change", function (e) {
    const file = e.target.files[0];

    if (!file) {
      alert("No file selected.");
      return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
      const text = e.target.result;

      const rows = text.trim().split("\n");
      let questions = [];

      rows.slice(1).forEach((row, index) => {
        const columns = row.split(",");
        const question = columns[0]?.trim();
        const answer = columns[1]?.trim();

        const obj = {
          question,
          answer,
        };

        questions.push(obj);
      });

      console.log(questions);

      const assessment_id = $("#hiddenAssessmentId").val();

      $.ajax({
        type: "POST",
        url: "../backend/api/web/asssessments.php",
        data: {
          requestType: "ImportTrueOrFalse",
          assessment_id,
          questions: JSON.stringify(questions),
        },
        success: function (response) {
          let res = JSON.parse(response);

          if (res.status === "success") {
            showAlert("alert-success", res.message);
            loadAssessment();
          } else {
            showAlert("alert-danger", res.message);
          }
        },
      });
    };

    reader.readAsText(file);
  });

  $("#identification-CSV").on("change", function (e) {
    const file = e.target.files[0];

    if (!file) {
      alert("No file selected.");
      return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
      const text = e.target.result;

      const rows = text.trim().split("\n");
      let questions = [];

      rows.slice(1).forEach((row, index) => {
        const columns = row.split(",");
        const question = columns[0]?.trim();
        const answer = columns[1]?.trim();

        const obj = {
          question,
          answer,
        };

        questions.push(obj);
      });

      console.log(questions);

      const assessment_id = $("#hiddenAssessmentId").val();

      $.ajax({
        type: "POST",
        url: "../backend/api/web/asssessments.php",
        data: {
          requestType: "ImportIdentification",
          assessment_id,
          questions: JSON.stringify(questions),
        },
        success: function (response) {
          let res = JSON.parse(response);

          if (res.status === "success") {
            showAlert("alert-success", res.message);
            loadAssessment();
          } else {
            showAlert("alert-danger", res.message);
          }
        },
      });
    };

    reader.readAsText(file);
  });

  $("#jumbled-words-CSV").on("change", function (e) {
    const file = e.target.files[0];

    if (!file) {
      alert("No file selected.");
      return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
      const text = e.target.result;

      const rows = text.trim().split("\n");
      let questions = [];

      rows.slice(1).forEach((row, index) => {
        const columns = row.split(",");
        const question = columns[0]?.trim();
        const answer = columns[1]?.trim();

        const obj = {
          question,
          answer,
        };

        questions.push(obj);
      });

      console.log(questions);

      const assessment_id = $("#hiddenAssessmentId").val();

      $.ajax({
        type: "POST",
        url: "../backend/api/web/asssessments.php",
        data: {
          requestType: "ImportJumbledWords",
          assessment_id,
          questions: JSON.stringify(questions),
        },
        success: function (response) {
          let res = JSON.parse(response);

          if (res.status === "success") {
            showAlert("alert-success", res.message);
            loadAssessment();
          } else {
            showAlert("alert-danger", res.message);
          }
        },
      });
    };

    reader.readAsText(file);
  });

  loadAssessment();
});
