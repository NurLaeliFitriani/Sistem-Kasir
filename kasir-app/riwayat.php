<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once 'config.php';

$data = mysqli_query($conn, "
SELECT t.*,
GROUP_CONCAT(CONCAT(d.nama_barang,' (',d.jumlah,'x)') SEPARATOR ', ') as barang
FROM transaksi t
INNER JOIN detail_transaksi d ON t.id_transaksi = d.id_transaksi
GROUP BY t.id_transaksi
ORDER BY t.id_transaksi DESC
");
?>

<h2 style="margin-bottom:20px;">📊 Riwayat Transaksi</h2>

<p>Login sebagai: <b><?= $_SESSION['nama'] ?></b></p>

<div style="
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 2px 8px rgba(0,0,0,0.1);
">

<table style="width:100%; border-collapse:collapse;">

<tr style="background:#3498db; color:white;">
<th style="padding:12px;">ID</th>
<th style="padding:12px;">Tanggal</th>
<th style="padding:12px;">Kasir</th>
<th style="padding:12px;">Barang</th>
<th style="padding:12px; text-align:right;">Total</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($data)) { ?>
<tr style="border-bottom:1px solid #eee;">

<td style="padding:12px; text-align:center;">
<?= $row['id_transaksi'] ?>
</td>

<td style="padding:12px; text-align:center; white-space:nowrap;">
<?= date("d-m-Y", strtotime($row['tanggal'])) ?>
</td>

<td style="padding:12px; text-align:center;">
<?= $row['kasir'] ?>
</td>

<td style="padding:12px; max-width:450px;">
<?= $row['barang'] ?>
</td>

<td style="padding:12px; font-family:monospace;">
    <div style="display:flex; justify-content:flex-end; gap:5px;">
        <span>Rp</span>
        <span style="width:110px; text-align:right;">
            <?= number_format($row['total'], 0, ',', '.') ?>
        </span>
    </div>
</td>

</tr>
<?php } ?>

</table>

</div>

<div style="
margin-top:15px;
background:#eaf3ff;
padding:10px;
border-radius:8px;
color:#2c3e50;
font-size:14px;
">
ℹ️ Menampilkan transaksi lengkap beserta nama kasir dan detail barang.
</div>
