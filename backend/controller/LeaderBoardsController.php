<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__ . '/../db/db.php');
date_default_timezone_set('Asia/Manila');

class LeaderBoardsController extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function test()
    {
        echo "login";
    }

    // public function GetLeaderBoards($teacher_id, $section_id = null)
    // {
    //     if ($section_id) {
    //         $query = "
    //         SELECT u.*
    //         FROM `users` AS u
    //         JOIN `student_teacher_assignments` AS sta ON u.lrn = sta.student_lrn
    //         JOIN `sections` AS s ON sta.section_id = s.id 
    //         WHERE s.teacher_id = ? AND s.id = ?
    //         ORDER BY u.points DESC";

    //         $q = $this->conn->prepare($query);

    //         if (!$q) {
    //             echo json_encode([
    //                 'status' => 'error',
    //                 'message' => 'SQL prepare failed: ' . $this->conn->error
    //             ]);
    //             return;
    //         }

    //         $q->bind_param("ii", $teacher_id, $section_id);
    //     } else {
    //         $query = "
    //         SELECT u.*
    //         FROM `users` AS u
    //         JOIN `student_teacher_assignments` AS sta ON u.lrn = sta.student_lrn
    //         JOIN `sections` AS s ON sta.section_id = s.id 
    //         WHERE s.teacher_id = ?
    //         ORDER BY u.points DESC";

    //         $q = $this->conn->prepare($query);

    //         if (!$q) {
    //             echo json_encode([
    //                 'status' => 'error',
    //                 'message' => 'SQL prepare failed: ' . $this->conn->error
    //             ]);
    //             return;
    //         }

    //         $q->bind_param("i", $teacher_id);
    //     }

    //     if ($q->execute()) {
    //         $result = $q->get_result();
    //         $leaderBoards = [];

    //         while ($row = $result->fetch_assoc()) {
    //             $leaderBoards[] = $row;
    //         }

    //         echo json_encode([
    //             'status' => 'success',
    //             'message' => 'success',
    //             'data' => $leaderBoards
    //         ]);
    //     } else {
    //         echo json_encode([
    //             'status' => 'error',
    //             'message' => 'Execute failed: ' . $q->error
    //         ]);
    //     }

    //     $q->close();
    // }


    public function GetLeaderBoards($teacher_id, $section_id = null)
    {
        if ($section_id) {
            $query = "
            SELECT 
                u.*,
                SUM(at.points) AS total_points
            FROM users AS u
            JOIN student_teacher_assignments AS sta ON u.lrn = sta.student_lrn
            JOIN sections AS s ON sta.section_id = s.id
            JOIN levels AS l ON s.teacher_id = l.teacher_id
            JOIN assessments AS a ON l.id = a.level_id
            JOIN assessment_takes AS at ON a.id = at.assessment_id AND at.lrn = u.lrn
            WHERE s.teacher_id = ? AND s.id = ?
            GROUP BY u.id
            ORDER BY total_points DESC
            ";

            $q = $this->conn->prepare($query);

            if (!$q) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'SQL prepare failed: ' . $this->conn->error
                ]);
                return;
            }

            $q->bind_param("ii", $teacher_id, $section_id);
        } else {
            $query = "
            SELECT u.*
            FROM `users` AS u
            JOIN `student_teacher_assignments` AS sta ON u.lrn = sta.student_lrn
            JOIN `sections` AS s ON sta.section_id = s.id 
            WHERE s.teacher_id = ?
            ORDER BY u.points DESC";

            $q = $this->conn->prepare($query);

            if (!$q) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'SQL prepare failed: ' . $this->conn->error
                ]);
                return;
            }

            $q->bind_param("i", $teacher_id);
        }

        if ($q->execute()) {
            $result = $q->get_result();
            $leaderBoards = [];

            while ($row = $result->fetch_assoc()) {
                $leaderBoards[] = $row;
            }

            echo json_encode([
                'status' => 'success',
                'message' => 'success',
                'data' => $leaderBoards
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
