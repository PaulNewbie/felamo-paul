<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__ . '/../db/db.php');
date_default_timezone_set('Asia/Manila');

class SectionController extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function GetSectionsByTeacher($teacher_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM sections WHERE teacher_id = ?");

        if (!$stmt) {
            echo json_encode([
                'status' => 'error',
                'message' => 'SQL prepare failed: ' . $this->conn->error
            ]);
            return;
        }

        $stmt->bind_param("i", $teacher_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $sections = [];

            while ($row = $result->fetch_assoc()) {
                $sections[] = $row;
            }

            echo json_encode([
                'status' => 'success',
                'message' => 'Sections retrieved successfully.',
                'data' => $sections
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Execute failed: ' . $stmt->error
            ]);
        }

        $stmt->close();
    }

    public function AssignSectionToTeacher($teacher_id, $section_name)
    {
        $stmt = $this->conn->prepare("INSERT INTO sections (teacher_id, section_name) VALUES (?, ?)");

        if (!$stmt) {
            echo json_encode([
                'status' => 'error',
                'message' => 'SQL prepare failed: ' . $this->conn->error
            ]);
            return;
        }

        $stmt->bind_param("is", $teacher_id, $section_name);

        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Section assigned successfully.',
                'section_id' => $stmt->insert_id
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Insert failed: ' . $stmt->error. ' '.$teacher_id
            ]);
        }

        $stmt->close();
    }
}
