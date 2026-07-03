<?php
require_once 'config.php';

$tgl_awal = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '';
$tgl_akhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '';

$where = "WHERE kasir IS NOT NULL AND kasir != ''";

if ($tgl_awal != '' && $tgl_akhir != '') {
    $where .= " AND DATE(tanggal) BETWEEN ? AND ?";
    $stmt = mysqli_prepare($conn, "
    SELECT kasir, COUNT(id_transaksi) as jumlah, SUM(total) as pendapatan
    FROM transaksi
    $where
    GROUP BY kasir
    ORDER BY pendapatan DESC
    ");
    mysqli_stmt_bind_param($stmt, "ss", $tgl_awal, $tgl_akhir);
} else {
    $stmt = mysqli_prepare($conn, "
    SELECT kasir, COUNT(id_transaksi) as jumlah, SUM(total) as pendapatan
    FROM transaksi
    $where
    GROUP BY kasir
    ORDER BY pendapatan DESC
    ");
}

mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
?>

<h2>📊 Laporan Kasir</h2>

<form method="GET">

<input type="hidden" name="page" value="laporan">

<label>Dari Tanggal</label><br>
<input type="date" name="tgl_awal" value="<?= $tgl_awal ?>">

<br><br>

<label>Sampai Tanggal</label><br>
<input type="date" name="tgl_akhir" value="<?= $tgl_akhir ?>">

<br><br>

<button type="submit">
Tampilkan
</button>

</form>

<table>

<tr>
<th>Kasir</th>
<th>Total Transaksi</th>
<th>Total Pendapatan</th>
</tr>

<?php while ($d = mysqli_fetch_assoc($data)) { ?>

<tr>

<td><?= $d['kasir'] ?></td>

<td align="center">
<?= $d['jumlah'] ?>
</td>

<td style="text-align:right;">
Rp <?= number_format($d['pendapatan'], 0, ',', '.') ?>
</td>

</tr>

<?php } ?>

</table>
