<?php
require_once '../class/Student.php';
$studentObj = new Student();

if (isset($_POST['add'])) {
    $studentObj->addStudent($_POST['name'], $_POST['email']);
    header("Location: students.php");
}

if (isset($_GET['delete'])) {
    $studentObj->deleteStudent($_GET['delete']);
    header("Location: students.php");
}

$students = $studentObj->getStudents();
include 'header.php';
?>

<div class="card">
    <h2 class="card-header">Tambah Siswa Baru</h2>
    <form method="POST">
        <div class="form-group">
            <input type="text" name="name" placeholder="Masukkan Nama Lengkap" required>
            <input type="email" name="email" placeholder="Masukkan Alamat Email" required>
            <button type="submit" name="add" class="btn">Simpan Data</button>
        </div>
    </form>
</div>

<div class="card">
    <h2 class="card-header">Daftar Siswa</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Siswa</th>
            <th>Email</th>
            <th style="width: 100px;">Aksi</th>
        </tr>
        <?php foreach ($students as $row): ?>
        <tr>
            <td>#<?= $row['id'] ?></td>
            <td><strong><?= $row['name'] ?></strong></td>
            <td><?= $row['email'] ?></td>
            <td>
                <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include 'footer.php'; ?>