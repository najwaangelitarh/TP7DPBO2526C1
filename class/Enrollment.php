<?php
require_once __DIR__ . '/../config/db.php';

class Enrollment {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn;
    }

    public function addEnrollment($student_id, $course_id) {
        $stmt = $this->db->prepare("INSERT INTO enrollments (student_id, course_id, enroll_date) VALUES (?, ?, CURDATE())");
        return $stmt->execute([$student_id, $course_id]);
    }

    public function getEnrollments() {
        $stmt = $this->db->prepare("
            SELECT e.id, s.name as student_name, c.title as course_title, e.enroll_date 
            FROM enrollments e 
            JOIN students s ON e.student_id = s.id 
            JOIN courses c ON e.course_id = c.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteEnrollment($id) {
        $stmt = $this->db->prepare("DELETE FROM enrollments WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getEnrollmentById($id) {
        $stmt = $this->db->prepare("SELECT * FROM enrollments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateEnrollment($id, $student_id, $course_id) {
        $stmt = $this->db->prepare("UPDATE enrollments SET student_id = ?, course_id = ? WHERE id = ?");
        return $stmt->execute([$student_id, $course_id, $id]);
    }
}
?>