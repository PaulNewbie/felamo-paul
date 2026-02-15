<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__ . '/../db/db.php');
date_default_timezone_set('Asia/Manila');

class LevelsController extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function test()
    {
        echo "login";
    }

    public function GetTakenAssessments($level_id, $filter)
    {
        $sql = "
        SELECT 
            at.lrn, 
            at.points, 
            at.assessment_id, 
            at.created_at, 
            u.first_name, 
            u.last_name, 
            at.total,
            COUNT(atl.id) AS total_attempts
        FROM assessment_takes AS at 
        JOIN assessments AS a ON at.assessment_id = a.id
        JOIN users AS u ON at.lrn = u.lrn

        JOIN assessment_takes_log AS atl ON at.assessment_id = atl.assessment_id AND at.lrn = atl.lrn

        WHERE a.level_id = ?
        GROUP BY at.lrn
    ";

        if ($filter === "PASSED") {
            $sql .= " AND at.points >= (at.total * 0.5)";
        } elseif ($filter === "FAILED") {
            $sql .= " AND at.points < (at.total * 0.5)";
        }

        $q = $this->conn->prepare($sql);

        if (!$q) {
            echo json_encode([
                'status' => 'error',
                'message' => 'SQL prepare failed: ' . $this->conn->error
            ]);
            return;
        }

        $q->bind_param("i", $level_id);

        if ($q->execute()) {
            $result = $q->get_result();
            $taken_assessments = [];

            while ($row = $result->fetch_assoc()) {
                $taken_assessments[] = $row;
            }

            echo json_encode([
                'status' => 'success',
                'message' => 'success',
                'data' => $taken_assessments
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
