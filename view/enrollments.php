<?php
require_once '../class/Enrollment.php';
require_once '../class/Student.php';
require_once '../class/Course.php';

$enrollObj = new Enrollment();
$studentObj = new Student();
$courseObj = new Course();

$editMode = false;
$editData = ['id' => '', 'student_id' => '', 'course_id' => ''];

// Proses Create
if (isset($_POST['add'])) {
    $enrollObj->addEnrollment($_POST['student_id'], $_POST['course_id']);
    header("Location: enrollments.php");
}

// Proses Update
if (isset($_POST['update'])) {
    $enrollObj->updateEnrollment($_POST['id'], $_POST['student_id'], $_POST['course_id']);
    header("Location: enrollments.php");
}

// Proses Delete
if (isset($_GET['delete'])) {
    $enrollObj->deleteEnrollment($_GET['delete']);
    header("Location: enrollments.php");
}

// Tangkap request Edit
if (isset($_GET['edit'])) {
    $editMode = true;
    $editData = $enrollObj->getEnrollmentById($_GET['edit']);
}

$enrollments = $enrollObj->getEnrollments();
$students = $studentObj->getStudents();
$courses = $courseObj->getCourses();

include 'header.php';
?>

<div class="card">
    <h2 class="card-header"><?= $editMode ? 'Edit Data Pendaftaran' : 'Pendaftaran Kursus Baru' ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $editMode ? $editData['id'] : '' ?>">
        
        <div class="form-group">
            <select name="student_id" required style="flex: 1; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px;">
                <option value="">-- Pilih Siswa --</option>
                <?php foreach ($students as $s): ?>
                    <option value="<?= $s['id'] ?>" <?= ($editMode && $editData['student_id'] == $s['id']) ? 'selected' : '' ?>>
                        <?= $s['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="course_id" required style="flex: 1; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px;">
                <option value="">-- Pilih Kursus --</option>
                <?php foreach ($courses as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= ($editMode && $editData['course_id'] == $c['id']) ? 'selected' : '' ?>>
                        <?= $c['title'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <?php if($editMode): ?>
                <button type="submit" name="update" class="btn" style="background-color: #f39c12;">Update Data</button>
                <a href="enrollments.php" class="btn btn-danger" style="display:flex; align-items:center;">Batal</a>
            <?php else: ?>
                <button type="submit" name="add" class="btn">Daftarkan</button>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <h2 class="card-header">Daftar Pendaftaran (Relasi Tabel)</h2>
    <table>
        <tr>
            <th>ID Daftar</th>
            <th>Nama Siswa</th>
            <th>Nama Kursus</th>
            <th>Tanggal Daftar</th>
            <th style="width: 150px;">Aksi</th>
        </tr>
        <?php foreach ($enrollments as $row): ?>
        <tr>
            <td>#<?= $row['id'] ?></td>
            <td><strong><?= $row['student_name'] ?></strong></td>
            <td><?= $row['course_title'] ?></td>
            <td><?= $row['enroll_date'] ?></td>
            <td>
                <a href="?edit=<?= $row['id'] ?>" class="btn" style="background-color: #f39c12; padding: 5px 10px; font-size: 14px; text-decoration: none;">Edit</a>
                <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Batalkan pendaftaran ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include 'footer.php'; ?>