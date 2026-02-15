<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include(__DIR__ . '/../../db/db.php');

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

$lrn = trim($input['lrn'] ?? '');
$email = trim($input['email'] ?? '');
$password = $input['password'] ?? '';
$confirm_password = $input['confirm_password'] ?? '';
$otp = trim($input['otp'] ?? '');

$errors = [];

if (!$lrn) $errors[] = "LRN is required.";
if (!preg_match('/^\d{12}$/', $lrn)) $errors[] = "LRN must be exactly 12 digits.";

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Valid email is required.";
}

if (!$password || strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters.";
}

if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match.";
}

if (!$otp || !preg_match('/^\d{6}$/', $otp)) {
    $errors[] = "Valid 6-digit OTP is required.";
}

if ($errors) {
    echo json_encode(['status' => 'error', 'errors' => $errors]);
    exit;
}

$conn = (new db_connect())->connect();

$stmt = $conn->prepare("SELECT 1 FROM student_teacher_assignments WHERE student_lrn = ? LIMIT 1");
$stmt->bind_param("s", $lrn);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'LRN is not assigned to any section.'
    ]);
    exit;
}
$stmt->close();

// $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR lrn = ?");
// $stmt->bind_param("ss", $email, $lrn);
// $stmt->execute();
// $stmt->store_result();

// if ($stmt->num_rows > 0) {
//     echo json_encode([
//         'status' => 'error',
//         'message' => 'Email or LRN already exists.'
//     ]);
//     exit;
// }
// $stmt->close();

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare("SELECT id FROM users WHERE lrn = ? AND email = ?");
$stmt->bind_param("ss", $lrn, $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'User not found with this LRN and email.'
    ]);
    exit;
}

$stmt->close();

$otp_stmt = $conn->prepare("
    SELECT id 
    FROM user_otps
    WHERE email = ? 
      AND otp = ? 
      AND otp_type = 'registration' 
      AND expiration_date > NOW()
    LIMIT 1
");
$otp_stmt->bind_param("ss", $email, $otp);
$otp_stmt->execute();
$otp_stmt->store_result();

if ($otp_stmt->num_rows === 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid or expired OTP.'
    ]);
    exit;
}

$otp_stmt->close();

$update_stmt = $conn->prepare("
    UPDATE users 
    SET password = ? 
    WHERE lrn = ? AND email = ?
");
$update_stmt->bind_param("sss", $hashed_password, $lrn, $email);

if (!$update_stmt->execute()) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to update password: ' . $update_stmt->error
    ]);
    exit;
}

if ($update_stmt->affected_rows === 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No user updated. LRN or email mismatch.'
    ]);
    exit;
}

$update_stmt->close();

echo json_encode([
    'status' => 'success',
    'message' => 'Registration successful. You can now log in.'
]);
exit;
