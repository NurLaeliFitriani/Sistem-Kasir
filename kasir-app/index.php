<?php
require_once 'config.php';

if (isset($_POST['simpan'])) {
    $stmt = mysqli_prepare($conn, "INSERT INTO barang VALUES (NULL, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sii", $_POST['nama'], $_POST['harga'], $_POST['stok']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if (isset($_GET['hapus'])) {
    $stmt = mysqli_prepare($conn, "DELETE FROM barang WHERE id_barang=?");
    mysqli_stmt_bind_param($stmt, "i", $_GET['hapus']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

$data = mysqli_query($conn, "SELECT * FROM barang");
?>

<h2>📦 Data Barang</h2>

<form method="POST">
<input type="text" name="nama" placeholder="Nama Barang" required>
<br><br>
<input type="number" name="harga" placeholder="Harga" required>
<br><br>
<input type="number" name="stok" placeholder="Stok" required>
<br><br>
<button name="simpan">Tambah</button>
</form>

<table>
<tr>
<th style="text-align:left;">Nama</th>
<th style="text-align:right;">Harga</th>
<th style="text-align:center;">Stok</th>
<th style="text-align:center;">Aksi</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($data)) { ?>
<tr>

<td><?= $row['nama_barang'] ?></td>

<td style="font-family:monospace;">
    <div style="display:flex; justify-content:flex-end; gap:5px;">
        <span>Rp</span>
        <span style="display:inline-block; width:90px; text-align:right;">
            <?= number_format($row['harga'], 0, ',', '.') ?>
        </span>
    </div>
</td>

<td style="text-align:center;">
<?= $row['stok'] ?>
</td>

<td style="text-align:center;">
<a href="?page=barang&hapus=<?= $row['id_barang'] ?>"
style="color:red;"
onclick="return confirm('Yakin hapus?')">
Hapus
</a>
</td>

</tr>
<?php } ?>

</table>
