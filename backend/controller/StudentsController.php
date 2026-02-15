<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__ . '/../db/db.php');
date_default_timezone_set('Asia/Manila');

class StudentsController extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function test()
    {
        echo "login";
    }

    public function GetStudents($user_id, $isSuperAdmin, $sectionId)
    {
        $hasSectionFilter = !empty($sectionId);

        if ($isSuperAdmin === "true") {
            if ($hasSectionFilter) {
                $q = $this->conn->prepare("
                SELECT u.*, sta.teacher_id, sta.student_lrn, s.section_name
                FROM student_teacher_assignments AS sta
                LEFT JOIN users AS u ON sta.student_lrn = u.lrn
                LEFT JOIN sections AS s ON sta.section_id = s.id
                WHERE s.id = ?
            ");
            } else {
                $q = $this->conn->prepare("
                SELECT u.*, sta.teacher_id, sta.student_lrn, s.section_name
                FROM student_teacher_assignments AS sta
                LEFT JOIN users AS u ON sta.student_lrn = u.lrn
                LEFT JOIN sections AS s ON sta.section_id = s.id
            ");
            }
        } else {
            if ($hasSectionFilter) {
                $q = $this->conn->prepare("
                SELECT u.*, sta.teacher_id, sta.student_lrn, s.section_name
                FROM student_teacher_assignments AS sta
                LEFT JOIN users AS u ON sta.student_lrn = u.lrn
                LEFT JOIN sections AS s ON sta.section_id = s.id
                WHERE s.teacher_id = ? AND s.id = ?
            ");
            } else {
                $q = $this->conn->prepare("
                SELECT u.*, sta.teacher_id, sta.student_lrn, s.section_name
                FROM student_teacher_assignments AS sta
                LEFT JOIN users AS u ON sta.student_lrn = u.lrn
                LEFT JOIN sections AS s ON sta.section_id = s.id
                WHERE s.teacher_id = ?
            ");
            }
        }

        if (!$q) {
            echo json_encode([
                'status' => 'error',
                'message' => 'SQL prepare failed: ' . $this->conn->error
            ]);
            return;
        }

        // Bind parameters
        if ($isSuperAdmin !== "true") {
            if ($hasSectionFilter) {
                $q->bind_param("ii", $user_id, $sectionId);
            } else {
                $q->bind_param("i", $user_id);
            }
        } else {
            if ($hasSectionFilter) {
                $q->bind_param("i", $sectionId);
            }
        }

        if ($q->execute()) {
            $result = $q->get_result();
            $students = [];

            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }

            echo json_encode([
                'status' => 'success',
                'message' => 'Students loaded successfully.',
                'data' => $students
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Execute failed: ' . $q->error
            ]);
        }

        $q->close();
    }
}
