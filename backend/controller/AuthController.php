<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__ . '/../db/db.php');
date_default_timezone_set('Asia/Manila');


require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class AuthController extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function test()
    {
        echo "login";
    }

    public function GetUsingId($tbl, $id)
    {
        $q = $this->conn->prepare("SELECT * FROM `$tbl` WHERE `id` = ?");
        $q->bind_param("i", $id);

        if ($q->execute()) {
            $result = $q->get_result();

            return $result;
        } else {
            echo "error";
        }
    }

    public function GetUsingCustomField($tbl, $field, $id)
    {
        $q = $this->conn->prepare("SELECT * FROM `$tbl` WHERE `$field` = ?");
        $q->bind_param("i", $id);

        if ($q->execute()) {
            $result = $q->get_result();

            return $result;
        } else {
            echo "error";
        }
    }

    public function GetUser($id)
    {
        $q = $this->conn->prepare("SELECT * FROM `admin` WHERE `id` = ? AND `is_active` = 1");
        $q->bind_param("i", $id);

        if ($q->execute()) {
            $result = $q->get_result();

            return $result;
        } else {
            echo "error";
        }
    }

    public function GetUser2($id)
    {
        $q = $this->conn->prepare("SELECT * FROM `admin` WHERE `id` = ? AND `is_active` = 1");
        $q->bind_param("i", $id);

        if ($q->execute()) {
            $result = $q->get_result();
            $user = $result->fetch_assoc();

            echo json_encode([
                'status' => 'success',
                'message' => 'User details',
                'data' => [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ]
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Something went wrong.'
            ]);
        }
    }

    public function Login($data)
    {
        $email = $data['email'];
        $password = $data['password'];

        $q = $this->conn->prepare("SELECT * FROM `admin` WHERE `email` = ? AND `is_active` = 1");
        $q->bind_param("s", $email);

        if ($q->execute()) {
            $result = $q->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password'])) {

                session_start();
                $_SESSION['id'] = $user['id'];

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Logged in',
                    'user' => [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role']
                    ]
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid email or password.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Something went wrong.'
            ]);
        }
    }

    public function UpdateUser($id, $name, $email, $newPassword)
    {
        $hashedPassword = null;

        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        if ($hashedPassword) {
            $stmt = $this->conn->prepare("UPDATE admin SET name = ?, email = ?, password = ? WHERE id = ?");
            $stmt->bind_param("sssi", $name, $email, $hashedPassword, $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE admin SET name = ?, email = ? WHERE id = ?");
            $stmt->bind_param("ssi", $name, $email, $id);
        }

        if (!$stmt) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Prepare failed: ' . $this->conn->error
            ]);
            return;
        }

        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'User updated successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Execute failed: ' . $stmt->error
            ]);
        }

        $stmt->close();
    }


    public function GetSections($id)
    {
        $q = $this->conn->prepare("SELECT * FROM `sections` WHERE `teacher_id` = ?");
        $q->bind_param("i", $id);

        if ($q->execute()) {
            return $q->get_result();

            // $section = $result->fetch_assoc();

            // echo json_encode([
            //     'status' => 'success',
            //     'message' => 'section details',
            //     'data' => $section
            // ]);
        } else {
            // echo json_encode([
            //     'status' => 'error',
            //     'message' => 'Something went wrong.'
            // ]);

            return null;
        }
    }

    public function GetAllSections()
    {
        $q = $this->conn->prepare("SELECT * FROM `sections`");

        if ($q->execute()) {
            return $q->get_result();
        } else {
            return null;
        }
    }

    public function SendForGotPasswordOtp($email)
    {
        $uQ = $this->conn->prepare("SELECT * FROM `admin` WHERE `email` = ?");
        $uQ->bind_param("s", $email);

        if (!$uQ->execute()) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email']);
            return;
        }

        $user = $uQ->get_result();

        if ($user->num_rows === 0) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email']);
            return;
        }

        $data = $user->fetch_assoc();
        $name = $data['name'];

        $otp = rand(100000, 999999);
        $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        $userType = "admin";
        $otpType  = "forgot_password";
        $otpStr   = (string) $otp;

        $sql = "INSERT INTO user_otps (email, user_type, otp_type, otp, expiration_date)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $email, $userType, $otpType, $otpStr, $expires);

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ugabane0516@gmail.com';
        $mail->Password = 'owwj dmzb hypq lsfu';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';

        $mail->setFrom('ugabane0516@gmail.com', 'Felamo');
        $mail->addAddress($email);
        $mail->isHTML(true);

        $mail->Subject = 'Felamo Login Using OTP';
        $mail->Body = "Your OTP is: <b>{$otp}</b>";

        if ($mail->send() && $stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'OTP sent successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }

    public function CheckAvailableOTP($email)
    {
        $currentDateTime = date('Y-m-d H:i:s');

        $sql = "SELECT * FROM user_otps 
                WHERE email = ? 
                AND user_type = 'admin' 
                AND otp_type = 'forgot_password' 
                AND expiration_date >= ? 
                ORDER BY expiration_date DESC 
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $email, $currentDateTime);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function LoginUsingOtp($email, $otp)
    {
        $now = date('Y-m-d H:i:s');

        $stmt = $this->conn->prepare(
            "SELECT id, name, email, role 
         FROM admin 
         WHERE email = ? AND is_active = 1"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if (!$user) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid email or inactive account.'
            ]);
            return;
        }

        $otpStmt = $this->conn->prepare(
            "SELECT otp 
         FROM user_otps 
         WHERE email = ?
         AND user_type = 'admin'
         AND otp_type = 'forgot_password'
         AND expiration_date >= ?
         ORDER BY expiration_date DESC
         LIMIT 1"
        );
        $otpStmt->bind_param("ss", $email, $now);
        $otpStmt->execute();

        $otpData = $otpStmt->get_result()->fetch_assoc();
        if (!$otpData) {
            echo json_encode([
                'status' => 'error',
                'message' => 'OTP expired or not found.'
            ]);
            return;
        }

        if ($otpData['otp'] != $otp) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Incorrect OTP.'
            ]);
            return;
        }

        session_start();
        $_SESSION['id'] = $user['id'];

        echo json_encode([
            'status' => 'success',
            'message' => 'Logged in successfully.',
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role']
            ]
        ]);
        
        return;
    }
}
