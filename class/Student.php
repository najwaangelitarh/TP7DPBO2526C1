<?php
require_once __DIR__ . '/../config/db.php';

class Student {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn;
    }

    public function addStudent($name, $email) {
        $stmt = $this->db->prepare("INSERT INTO students (name, email) VALUES (?, ?)");
        return $stmt->execute([$name, $email]);
    }

    public function getStudents() {
        $stmt = $this->db->prepare("SELECT * FROM students");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteStudent($id) {
        $stmt = $this->db->prepare("DELETE FROM students WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>