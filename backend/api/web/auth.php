<?php
include_once(__DIR__ . '/../../controller/AuthController.php');
// include_once(__DIR__ . '/../../controller/OtpController.php');
// include_once(__DIR__ . '/../../controller/SendEmailController.php');

$requestType = $_POST['requestType'];

$controller = new AuthController();
// $otpController = new OtpController();
// $emailController = new SendEmailController();

if ($requestType == "Login") {
    $controller->Login($_POST);
} elseif ($requestType == "GetProfileDetails") {
    $id = $_POST['auth_user_id'];
    $controller->GetUser2($id);
} elseif ($requestType == "EditUser") {
    $id = $_POST['auth_user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $newPassword = $_POST['newPassword'];
    $controller->UpdateUser($id, $name, $email, $newPassword);
} elseif ($requestType == "SendOTP") {
    $email = $_POST['email'];
    $controller->SendForGotPasswordOtp($email);
} elseif ($requestType == "LoginUsingOtp") {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $controller->LoginUsingOtp($email, $otp);
} else {
    http_response_code(400);
    echo "Invalid or missing requestType.";
}
