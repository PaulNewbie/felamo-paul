<?php
include("components/header.php");

// $auth_user_id

$hasExistingAssessment = false;

if (isset($_GET['level'])) {
    $level_id = $_GET['level'];

    $levelResult = $AuthController->GetUsingId("levels", $level_id);

    if ($levelResult->num_rows > 0) {
        $level = $levelResult->fetch_assoc();

        if ($level['teacher_id'] != $auth_user_id) {
            header("Location: ../index.php");
        }

        // $assessmentResult = $AuthController->GetUsingCustomField("assessments", "level_id", $level_id);

        // if ($assessmentResult->num_rows > 0) {
        //     $hasExistingAssessment = true;
        //     $assessment = $assessmentResult->fetch_assoc();
        // }
    } else {
        header("Location: ../index.php");
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>

<!-- hidden inputs -->

<input type="hidden" id="auth_user_id" value="<?= $auth_user_id ?>">
<input type="hidden" id="hidden_level_id" value="<?= $level_id ?>">


<div class="container py-4">
    <h4 class="my-3 text-main">
        <span id="page-title-action-type"></span>
        Assessment sa
        <?=
        $level['level'] == 1 ? "Unang markahan" : ($level['level'] == 2 ? "Pangalawang markahan" : ($level['level'] == 3 ? "Pangatlong markahan" : ($level['level'] == 4 ? "Ika-apat na markahan" : "Hindi kilalang markahan")))
        ?>
    </h4>


    <div id="alert" style="position: fixed; top:10px; right:10px; font-size: 12px;"></div>

    <form id="create-assessment-form">
        <input type="hidden" name="requestType" value="CreateAssessment">
        <input type="hidden" name="level_id" value="<?= $level_id ?>">

        <input type="hidden" name="assessment_id" id="hiddenAssessmentId" value="">

        <div class="mb-3">
            <label for="title" class="form-label">Assessment Title</label>
            <input type="text" class="form-control" id="title" name="title"
                value=""
                required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Assessment Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-main text-light">
            <span id="button-create-assesment-action"></span>
        </button>
        <a href="levels.php" class="btn btn-secondary">Cancel</a>
    </form>

    <div class="DONTSHOWHENCREATEONLY">

        <hr>

        <div>
            <h5 class="text-center my-3 text-main">Multple Choice</h5>
            <div class="d-flex align-items-center">

                <button class="btn btn-sm btn-main text-light my-2" data-bs-toggle="modal" data-bs-target="#multipleChoiceModal">Create Question</button>
                <div class="input-group input-group-sm w-auto ms-2">
                    <label for="multiple-choice-CSV" class="input-group-text">Import Questions</label>
                    <input type="file" id="multiple-choice-CSV" class="form-control" accept=".csv">
                </div>

            </div>

            <div id="multi-questions-container"></div>
        </div>


        <div>
            <h5 class="text-center my-3 text-main">True or False</h5>
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-main text-light my-2" data-bs-toggle="modal" data-bs-target="#trueFalseModal">Create Question</button>
                <div class="input-group input-group-sm w-auto ms-2">
                    <label for="true-or-false-CSV" class="input-group-text">Import Questions</label>
                    <input type="file" id="true-or-false-CSV" class="form-control" accept=".csv">
                </div>
            </div>

            <div id="t-or-f-questions-container"></div>
        </div>


        <div>
            <h5 class="text-center my-3 text-main">Identification</h5>
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-main text-light my-2" data-bs-toggle="modal" data-bs-target="#identificationModal">Create Question</button>
                <div class="input-group input-group-sm w-auto ms-2">
                    <label for="identification-CSV" class="input-group-text">Import Questions</label>
                    <input type="file" id="identification-CSV" class="form-control" accept=".csv">
                </div>
            </div>

            <div id="identification-questions-container"></div>
        </div>


        <div>
            <h5 class="text-center my-3 text-main">Jumbled Words</h5>
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-main text-light my-2" data-bs-toggle="modal" data-bs-target="#jumbledWordsModal">Create Question</button>
                <div class="input-group input-group-sm w-auto ms-2">
                    <label for="jumbled-words-CSV" class="input-group-text">Import Questions</label>
                    <input type="file" id="jumbled-words-CSV" class="form-control" accept=".csv">
                </div>
            </div>

            <div id="jumbled-words-questions-container"></div>
        </div>
    </div>


</div>


<div class="modal fade DONTSHOWHENCREATEONLY" id="multipleChoiceModal" tabindex="-1" aria-labelledby="multipleChoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="multiple-choice-form" method="POST">
            <input type="hidden" name="requestType" value="InsertMultipleChoice">
            <input type="hidden" name="assessment_id" class="form-assesment-id" id="form-assesment-id" value="">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="multipleChoiceModalLabel">Add Multiple Choice Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <textarea class="form-control" id="question" name="question" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Answer Choices</label>
                        <input type="text" class="form-control mb-2" name="choice_a" placeholder="Choice A" required>
                        <input type="text" class="form-control mb-2" name="choice_b" placeholder="Choice B" required>
                        <input type="text" class="form-control mb-2" name="choice_c" placeholder="Choice C" required>
                        <input type="text" class="form-control mb-2" name="choice_d" placeholder="Choice D" required>
                    </div>

                    <div class="mb-3">
                        <label for="correct_answer" class="form-label">Correct Answer</label>
                        <select class="form-select" id="correct_answer" name="answer" required>
                            <option value="">Select correct answer</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-main text-light">Save Question</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade DONTSHOWHENCREATEONLY" id="trueFalseModal" tabindex="-1" aria-labelledby="trueFalseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="true-false-form" method="POST">
            <input type="hidden" name="requestType" value="InsertTrueOrFalse">
            <input type="hidden" name="assessment_id" class="form-assesment-id" id="tf-assessment-id" value="">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trueFalseModalLabel">Add True or False Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tf-question" class="form-label">Question</label>
                        <textarea class="form-control" id="tf-question" name="question" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="tf-answer" class="form-label">Correct Answer</label>
                        <select class="form-select" id="tf-answer" name="answer" required>
                            <option value="">Select correct answer</option>
                            <option value="true">True</option>
                            <option value="false">False</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-main text-light">Save Question</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade DONTSHOWHENCREATEONLY" id="identificationModal" tabindex="-1" aria-labelledby="identificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="identification-form" method="POST">
            <input type="hidden" name="requestType" value="InsertIdentification">
            <input type="hidden" name="assessment_id" class="form-assesment-id" id="form-assesment-id" value="">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="identificationModalLabel">Add Identification Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <textarea class="form-control" id="identification-question" name="question" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <input type="text" class="form-control" id="identification_correct_answer" name="answer">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-main text-light">Save Question</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade DONTSHOWHENCREATEONLY" id="jumbledWordsModal" tabindex="-1" aria-labelledby="jumbledWordsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="jumbled-words-form" method="POST">
            <input type="hidden" name="requestType" value="InsertJumbledWords">
            <input type="hidden" name="assessment_id" class="form-assesment-id" id="form-assesment-id" value="">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jumbledWordsModalLabel">Add Jumbled Word Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="question" class="form-label">Word</label>
                        <textarea class="form-control" id="jumbled-word-question" name="question" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <input type="text" class="form-control" id="jumbled_word_correct_answer" name="answer">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-main text-light">Save Question</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php
include("components/footer-scripts.php");
?>

<script src="scripts/create_assessment.js"></script>

<?php
include("components/footer.php");
