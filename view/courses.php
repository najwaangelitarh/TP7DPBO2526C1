<?php
require_once '../class/Course.php';
$courseObj = new Course();

$editMode = false;
$editData = ['id' => '', 'title' => '', 'description' => ''];

if (isset($_POST['add'])) {
    $courseObj->addCourse($_POST['title'], $_POST['description']);
    header("Location: courses.php");
}

if (isset($_POST['update'])) {
    $courseObj->updateCourse($_POST['id'], $_POST['title'], $_POST['description']);
    header("Location: courses.php");
}

if (isset($_GET['delete'])) {
    $courseObj->deleteCourse($_GET['delete']);
    header("Location: courses.php");
}

if (isset($_GET['edit'])) {
    $editMode = true;
    $editData = $courseObj->getCourseById($_GET['edit']);
}

$courses = $courseObj->getCourses();
include 'header.php';
?>

<div class="card">
    <h2 class="card-header"><?= $editMode ? 'Edit Data Kursus' : 'Tambah Kursus Baru' ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $editMode ? $editData['id'] : '' ?>">
        
        <div class="form-group">
            <input type="text" name="title" placeholder="Nama Kursus" value="<?= $editMode ? $editData['title'] : '' ?>" required>
            <input type="text" name="description" placeholder="Deskripsi Kursus" value="<?= $editMode ? $editData['description'] : '' ?>" required>
            
            <?php if($editMode): ?>
                <button type="submit" name="update" class="btn" style="background-color: #f39c12;">Update Data</button>
                <a href="courses.php" class="btn btn-danger" style="display:flex; align-items:center;">Batal</a>
            <?php else: ?>
                <button type="submit" name="add" class="btn">Simpan Data</button>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <h2 class="card-header">Daftar Kursus</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Kursus</th>
            <th>Deskripsi</th>
            <th style="width: 150px;">Aksi</th>
        </tr>
        <?php foreach ($courses as $row): ?>
        <tr>
            <td>#<?= $row['id'] ?></td>
            <td><strong><?= $row['title'] ?></strong></td>
            <td><?= $row['description'] ?></td>
            <td>
                <a href="?edit=<?= $row['id'] ?>" class="btn" style="background-color: #f39c12; padding: 5px 10px; font-size: 14px; text-decoration: none;">Edit</a>
                <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include 'footer.php'; ?>