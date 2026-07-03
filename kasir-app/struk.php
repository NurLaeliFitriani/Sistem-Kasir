<?php
require_once 'config.php';

if (!isset($_GET['id_barang']) || !isset($_GET['jumlah'])) {
    echo "Silakan lakukan transaksi dulu!";
    exit;
}

$id_barang = $_GET['id_barang'];
$jumlah = $_GET['jumlah'];

$stmt = mysqli_prepare($conn, "SELECT * FROM barang WHERE id_barang=?");
mysqli_stmt_bind_param($stmt, "i", $id_barang);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$barang = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$total = $barang['harga'] * $jumlah;
?>

<style>
body {
    font-family: monospace;
    background: #f5f6fa;
}

.struk {
    background: white;
    width: 300px;
    margin: auto;
    padding: 20px;
    border: 1px dashed black;
    text-align: center;
}

hr {
    border: 1px dashed black;
}

button {
    margin-top: 10px;
    padding: 8px 15px;
    background: black;
    color: white;
    border: none;
    cursor: pointer;
}

@media print {
    button {
        display: none;
    }
}
</style>

<div class="struk">

    <?php date_default_timezone_set('Asia/Jakarta'); ?>
<p><?= date('d-m-Y H:i:s') ?></p>

    <h3>TB. Jaya Santosa</h3>
<p>STRUK PEMBELIAN</p>
    <hr>

    <p>Barang: <?= $barang['nama_barang'] ?></p>

    <p>Harga: Rp <?= number_format($barang['harga'], 0, ',', '.') ?></p>

    <p>Jumlah: <?= $jumlah ?></p>

    <hr>

    <p><b>Total: Rp <?= number_format($total, 0, ',', '.') ?></b></p>

    <hr>

    <p>Terima kasih</p>
</div>

<div style="text-align:center;">
    <button onclick="window.print()">Print</button>
</div>
