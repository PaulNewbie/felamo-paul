$(document).ready(function () {
    const auth_user_id = $("#hidden_user_id").val();
    const level_id = $("#hidden_level_id").val();

    const loadTakenAssessments = () => {
        $.ajax({
            type: "POST",
            url: "../backend/api/web/taken_assessment.php",
            data: { 
                // MATCHING FIX: This must match the PHP if statement exactly
                requestType: "GetTakenAssessments", 
                level_id: level_id,
                teacher_id: auth_user_id,
                // MATCHING FIX: Added the filter parameter your PHP expects
                filter: "all" 
            },
            dataType: "json", // Ensure we expect JSON
            success: function (response) {
                // Adjust this check based on how your Controller returns data
                // Some controllers return arrays directly, others return {status: 'success', data: [...]}
                // I will assume your controller returns the array of data directly or inside a 'data' key.
                
                let data = response.data ? response.data : response; 
                
                // If response is just the array (common in some setups)
                if (Array.isArray(response)) {
                    data = response;
                }

                let html = "";

                if (!data || data.length === 0) {
                    html = `
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                No assessments taken yet for this level.
                            </td>
                        </tr>`;
                } else {
                    data.forEach((item) => {
                        // Handle Date Formatting safely
                        let dateTaken = item.created_at || "N/A";
                        
                        // Handle Student Name (adjust key based on your DB columns)
                        let studentName = item.student_name || item.fullname || "Student";
                        
                        // Handle Title
                        let title = item.assessment_title || item.title || "Assessment";

                        html += `
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">${title}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-secondary">
                                        <i class="bi bi-person-circle me-2"></i> ${studentName}
                                    </div>
                                </td>
                                <td>
                                    <span class="text-date">${dateTaken}</span>
                                </td>
                                <td>
                                    <span class="badge-score">${item.score} / ${item.total_items}</span>
                                </td>
                                <td style="text-align: right;">
                                    <div class="dropdown">
                                        <button class="btn-action-red dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li>
                                                <a class="dropdown-item" href="view_result.php?id=${item.id}">
                                                    <i class="bi bi-eye me-2"></i> View Results
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                }
                $("#taken-assessments-list").html(html);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                $("#taken-assessments-list").html(`
                    <tr>
                        <td colspan="5" class="text-center text-danger py-4">
                            Error loading data: ${xhr.statusText}
                        </td>
                    </tr>
                `);
            },
        });
    };

    loadTakenAssessments();
});