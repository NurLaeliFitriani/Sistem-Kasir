<?php
date_default_timezone_set('Asia/Jakarta');

require_once 'config.php';

if (!isset($_GET['id'])) {
    echo "Transaksi tidak ditemukan!";
    exit;
}

$id = $_GET['id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM transaksi WHERE id_transaksi=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$trx = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$stmt2 = mysqli_prepare($conn, "SELECT * FROM detail_transaksi WHERE id_transaksi=?");
mysqli_stmt_bind_param($stmt2, "i", $id);
mysqli_stmt_execute($stmt2);
$data = mysqli_stmt_get_result($stmt2);
?>

<style>
@media print {
    body {
        margin: 0;
    }
}

body {
    font-family: monospace;
}

.struk {
    width: 260px;
    margin: auto;
    padding: 10px;
}

.center {
    text-align: center;
}

.small {
    font-size: 12px;
}

.logo {
    width: 60px;
    margin-bottom: 5px;
}

.line {
    border-top: 1px dashed black;
    margin: 6px 0;
}

.flex {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
}
</style>

<div class="struk">

<div class="center">

<img src="logo.png" class="logo"><br>

<b>TB. JAYA SANTOSA</b><br>
<span class="small">Toko Bangunan</span><br>

<span class="small">
No: TRX-<?= str_pad($id, 4, '0', STR_PAD_LEFT) ?>
</span><br>

<span class="small">
Kasir: <?= $trx['kasir'] ?>
</span><br>

<span class="small">
<?= date("d-m-Y H:i", strtotime($trx['tanggal'])) ?>
</span>

</div>

<div class="line"></div>

<?php
$total = 0;

while ($d = mysqli_fetch_assoc($data)) {
    $subtotal = $d['subtotal'];
    $total += $subtotal;
?>

<div class="flex">
    <span><?= $d['nama_barang'] ?></span>
    <span><?= $d['jumlah'] ?>x</span>
</div>

<div class="flex small">
    <span></span>
    <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
</div>

<?php } ?>

<div class="line"></div>

<div class="flex">
    <span>Bayar</span>
    <span>Rp <?= number_format($trx['bayar'], 0, ',', '.') ?></span>
</div>

<div class="flex">
    <span>Kembali</span>
    <span>Rp <?= number_format($trx['kembalian'], 0, ',', '.') ?></span>
</div>
    <b>Rp <?= number_format($total, 0, ',', '.') ?></b>
</div>

<div class="line"></div>

<div class="center small">
    Terima kasih 🙏<br>
    Barang yang sudah dibeli<br>
    tidak dapat dikembalikan
</div>

</div>

<script>
window.print();

setTimeout(function(){
    window.location.href = "dashboard.php";
}, 1000);
</script>
