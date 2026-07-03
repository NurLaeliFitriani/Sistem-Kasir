<?php
require_once 'config.php';

if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = mysqli_prepare($conn, "INSERT INTO user (nama, username, password, role) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $nama, $username, $password, $role);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $stmt = mysqli_prepare($conn, "DELETE FROM user WHERE id_user=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

$data = mysqli_query($conn, "SELECT * FROM user");
?>

<h2>👤 Data User</h2>

<form method="POST">
<input type="text" name="nama" placeholder="Nama" required><br><br>
<input type="text" name="username" placeholder="Username" required><br><br>
<input type="password" name="password" placeholder="Password" required><br><br>

<select name="role">
<option value="admin">Admin</option>
<option value="kasir">Kasir</option>
</select>

<br><br>

<button name="tambah">Tambah User</button>
</form>

<hr>

<table border="1" width="100%">
<tr>
<th>Nama</th>
<th>Username</th>
<th>Role</th>
<th>Aksi</th>
</tr>

<?php while ($u = mysqli_fetch_assoc($data)) { ?>
<tr>

<td><?= $u['nama'] ?></td>
<td><?= $u['username'] ?></td>
<td><?= $u['role'] ?></td>

<td>
<a href="?page=user&hapus=<?= $u['id_user'] ?>" onclick="return confirm('Hapus user?')">Hapus</a>
</td>

</tr>
<?php } ?>

</table>
