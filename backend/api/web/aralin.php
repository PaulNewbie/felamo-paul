<?php
include_once(__DIR__ . '/../../controller/AralinController.php');

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

$controller = new AralinController();

if ($requestType == "GetAralin") {
    $level_id = $_POST['level_id'];
    $controller->GetAralins($level_id);
} elseif ($requestType == "InsertAralin") {
    $post = $_POST;
    $files = $_FILES;

    $controller->InsertAralin($post, $files);
} elseif ($requestType == "EditAralin") {
    $post = $_POST;
    $files = $_FILES;

    $controller->EditAralin($post, $files);
} elseif ($requestType == "GetDoneAralin") {
    $id = $_POST['userId'];

    $controller->GetDoneAralin($id);
} elseif ($requestType == "GetWatchHistory") {
    $id = $_POST['aralin_id'];

    $controller->GetWatchHistory($id);
} else {
    http_response_code(400);
    echo "Invalid or missing requestType.";
}
