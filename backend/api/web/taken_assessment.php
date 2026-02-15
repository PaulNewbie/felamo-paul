<?php
include_once(__DIR__ . '/../../controller/AssessmentTakesController.php');

$requestType = $_POST['requestType'];

$controller = new LevelsController();

if ($requestType == "GetTakenAssessments") {
    $id = $_POST['level_id'];
    $filter = $_POST['filter'];
    $controller->GetTakenAssessments($id, $filter);
} else {
    http_response_code(400);
    echo "Invalid or missing requestType.";
}
