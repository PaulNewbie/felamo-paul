<?php
include_once(__DIR__ . '/../../controller/StudentsController.php');

if (!isset($_POST['requestType'])) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'requestType is missing',
        'raw_post' => $_POST,
        'raw_files' => $_FILES
    ]);
    exit;
}

$requestType = $_POST['requestType'];

$controller = new StudentsController();

if ($requestType == "GetStudents") {
    $auth_user_id = $_POST['auth_user_id'];
    $is_super_admin = $_POST['is_super_admin'];
    $section_id = $_POST['section_id'];
    $controller->GetStudents($auth_user_id, $is_super_admin, $section_id);
} else {
    http_response_code(400);
    echo "Invalid or missing requestType.";
}
