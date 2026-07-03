<?php
require_once 'config.php';

$data = mysqli_query($conn, "
SELECT nama_barang, SUM(jumlah) as terjual
FROM detail_transaksi
GROUP BY nama_barang
ORDER BY terjual DESC
LIMIT 10
");
?>

<h2>🏆 Barang Terlaris</h2>

<div style="
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 2px 8px rgba(0,0,0,0.1);
">

<table style="width:100%; border-collapse:collapse;">

<tr style="background:#3498db;color:white;">
    <th style="padding:12px;">Ranking</th>
    <th style="padding:12px;">Nama Barang</th>
    <th style="padding:12px;">Total Terjual</th>
</tr>

<?php
$no = 1;

while ($d = mysqli_fetch_assoc($data)) {
?>

<tr>
    <td style="padding:12px;text-align:center;">
        <?= $no++ ?>
    </td>

    <td style="padding:12px;">
        <?= $d['nama_barang'] ?>
    </td>

    <td style="padding:12px;text-align:center;">
        <?= $d['terjual'] ?>
    </td>
</tr>

<?php } ?>

</table>

</div>
