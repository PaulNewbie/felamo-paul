let questionsList = []; // Array to store questions temporarily

$(document).ready(function () {

    // --- MAIN FORM SUBMIT ---
    $("#create-assessment-form").on("submit", function (e) {
        e.preventDefault();

        const title = $("#assessment_title").val();
        if (!title) { alert("Please enter an Assessment Title."); return; }

        // Use FormData to handle files + form fields
        let formData = new FormData(this);

        // Append Fixed Data
        formData.append('requestType', 'CreateAssessment');
        formData.append('teacher_id', $("#hidden_user_id").val());
        formData.append('level_id', $("#hidden_level_id").val());
        
        // Append Defaults for removed fields
        formData.append('due_date', ''); 
        formData.append('time_limit', 0);
        formData.append('is_active', 0);

        // Append the QUESTIONS LIST as a JSON string
        formData.append('questions_data', JSON.stringify(questionsList));

        // Send AJAX
        $.ajax({
            type: "POST",
            url: "../backend/api/web/asssessments.php", // Ensure filename matches backend
            data: formData,
            dataType: "json",
            contentType: false, 
            processData: false, 
            beforeSend: function() {
                $(".btn-submit").prop("disabled", true).html('Saving...');
            },
            success: function (response) {
                $(".btn-submit").prop("disabled", false).html('<i class="bi bi-check-circle me-2"></i> Save Assessment');
                if (response.status === "success") {
                    alert("Assessment created successfully!");
                    window.location.href = "levels.php"; 
                } else {
                    alert("Error: " + (response.message || "Unknown error"));
                }
            },
            error: function (xhr) {
                $(".btn-submit").prop("disabled", false).html('<i class="bi bi-check-circle me-2"></i> Save Assessment');
                console.error("Error:", xhr.responseText);
                alert("Server Error.");
            },
        });
    });
});

// --- HELPER FOR MODAL SELECTION UI ---
// Highlights the selected choice row (MCQ A-D or TF True/False)
function selectRadio(val) {
    // 1. Check the specific radio button
    let radioBtn = $("#radio" + val);
    radioBtn.prop("checked", true);
    
    // 2. Find parent form
    let form = radioBtn.closest("form");
    
    // 3. Update styling classes
    form.find(".choice-item").removeClass("active-choice");
    radioBtn.closest(".choice-item").addClass("active-choice");
}

// Global listener for radio buttons to update UI if clicked directly
$(document).on('change', 'input[type="radio"]', function() {
    let val = $(this).val();
    if ($(this).attr("id") && $(this).attr("id").startsWith("radio")) {
        selectRadio(val);
    }
});

// --- FUNCTION TO SAVE QUESTION FROM MODAL ---
function saveQuestion(type) {
    let qData = { type: type };
    let isValid = true;

    if (type === 'MCQ') {
        qData.question = $("#mcq_question").val();
        qData.a = $("#mcq_a").val();
        qData.b = $("#mcq_b").val();
        qData.c = $("#mcq_c").val();
        qData.d = $("#mcq_d").val();
        qData.correct = $("input[name='mcq_correct']:checked").val();

        if (!qData.question || !qData.a || !qData.b || !qData.correct) isValid = false;
    } 
    else if (type === 'TF') {
        qData.question = $("#tf_question").val();
        qData.correct = $("input[name='tf_correct']:checked").val();
        if (!qData.question || !qData.correct) isValid = false;
    }
    else if (type === 'IDENT') {
        qData.question = $("#ident_question").val();
        qData.correct = $("#ident_answer").val();
        if (!qData.question || !qData.correct) isValid = false;
    }
    else if (type === 'JUMBLED') {
        qData.question = $("#jumbled_question").val();
        qData.correct = $("#jumbled_answer").val();
        if (!qData.question || !qData.correct) isValid = false;
    }

    if (!isValid) {
        alert("Please fill in all required fields.");
        return;
    }

    // Add to Array
    questionsList.push(qData);
    renderQuestions();

    // Reset Forms & UI
    $("#formMCQ")[0].reset();
    $("#formTF")[0].reset();
    $("#formIdent")[0].reset();
    $("#formJumbled")[0].reset();
    $(".choice-item").removeClass("active-choice");
    
    $(".modal").modal("hide");
}

// --- RENDER PREVIEW LIST ---
function renderQuestions() {
    let container = $("#questions-list");
    let wrapper = $("#questions-preview-container");
    container.empty();

    if (questionsList.length > 0) {
        wrapper.removeClass("d-none");
        $("#q-count").text(questionsList.length);

        questionsList.forEach((q, index) => {
            let badgeClass = "bg-secondary";
            if(q.type === 'MCQ') badgeClass = "bg-primary";
            if(q.type === 'TF') badgeClass = "bg-success";
            if(q.type === 'IDENT') badgeClass = "bg-info text-dark";
            if(q.type === 'JUMBLED') badgeClass = "bg-warning text-dark";
            
            let html = `
                <div class="added-question-item">
                    <span class="badge ${badgeClass} mb-2">${q.type}</span>
                    <p class="mb-1 fw-bold">${q.question}</p>
                    <small class="text-muted">Answer: ${q.correct}</small>
                    <button type="button" class="btn-remove-q" onclick="removeQuestion(${index})">&times;</button>
                </div>
            `;
            container.append(html);
        });
    } else {
        wrapper.addClass("d-none");
    }
}

function removeQuestion(index) {
    questionsList.splice(index, 1);
    renderQuestions();
}