<?php
require_once __DIR__ . '/../config/db.php';

class Course {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn;
    }

    public function addCourse($title, $description) {
        $stmt = $this->db->prepare("INSERT INTO courses (title, description) VALUES (?, ?)");
        return $stmt->execute([$title, $description]);
    }

    public function getCourses() {
        $stmt = $this->db->prepare("SELECT * FROM courses");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseById($id) {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCourse($id, $title, $description) {
        $stmt = $this->db->prepare("UPDATE courses SET title = ?, description = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $id]);
    }

    public function deleteCourse($id) {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>