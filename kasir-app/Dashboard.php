<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once 'config.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: #f1f3f6;
    padding-top: 80px;
}

.header {
    height: 70px;
    background: linear-gradient(135deg, #8e44ad, #3498db);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
}

.sidebar {
    position: fixed;
    top: 70px;
    left: 0;
    width: 220px;
    height: calc(100% - 70px);
    background: #6c7a89;
    padding: 15px;
}

.sidebar a {
    display: block;
    padding: 12px;
    margin-bottom: 10px;
    background: #8fa3b0;
    color: black;
    text-decoration: none;
    border-radius: 10px;
}

.active {
    background: white !important;
    font-weight: bold;
}

.content {
    margin-left: 240px;
    padding: 30px;
}

.card-box {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.card {
    padding: 30px;
    border-radius: 15px;
    color: white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.green { background: #2ecc71; }
.orange { background: #e67e22; }
.blue { background: #3498db; }

.card h2 {
    margin: 0;
    font-size: 40px;
}

.card p {
    margin-top: 25px;
    font-size: 18px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th {
    background: #3498db;
    color: white;
    padding: 10px;
}

td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}
</style>

<div class="header">

    <div>
        🏪 TB. Jaya Santosa
    </div>

    <div>
        👤 <?= $_SESSION['nama'] ?>
        (<?= $_SESSION['role'] ?>)
        |
        <a href="logout.php" style="color:white;">
            Logout
        </a>
    </div>

</div>

<div class="sidebar">

    <a href="dashboard.php?page=dashboard"
    class="<?= $page == 'dashboard' ? 'active' : '' ?>">
    🏠 Dashboard
    </a>

    <?php if ($_SESSION['role'] == 'admin') { ?>

    <a href="dashboard.php?page=barang"
    class="<?= $page == 'barang' ? 'active' : '' ?>">
    📦 Data Barang
    </a>

    <a href="dashboard.php?page=user"
    class="<?= $page == 'user' ? 'active' : '' ?>">
    👤 Data User
    </a>

    <?php } ?>

    <a href="dashboard.php?page=transaksi"
    class="<?= $page == 'transaksi' ? 'active' : '' ?>">
    💰 Transaksi
    </a>

    <a href="dashboard.php?page=riwayat"
    class="<?= $page == 'riwayat' ? 'active' : '' ?>">
    📊 Riwayat
    </a>

    <a href="dashboard.php?page=laporan"
    class="<?= $page == 'laporan' ? 'active' : '' ?>">
    📈 Laporan
    </a>

    <a href="dashboard.php?page=barang_terlaris"
    class="<?= $page == 'barang_terlaris' ? 'active' : '' ?>">
    🏆 Barang Terlaris
    </a>

</div>

<div class="content">

<?php

if ($page == 'dashboard') {

    $b = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total FROM barang
    "));

    $t = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total FROM transaksi
    WHERE kasir IS NOT NULL AND kasir != ''
    "));

    $u = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(total) as total FROM transaksi
    WHERE kasir IS NOT NULL AND kasir != ''
    "));

    $chart = mysqli_query($conn, "
    SELECT DATE(tanggal) as tgl, SUM(total) as total
    FROM transaksi
    WHERE kasir IS NOT NULL AND kasir != ''
    GROUP BY DATE(tanggal)
    ORDER BY tgl ASC
    ");

    $tanggal = [];
    $total = [];

    while ($c = mysqli_fetch_assoc($chart)) {
        $tanggal[] = $c['tgl'];
        $total[] = $c['total'];
    }

?>

<h1>Dashboard</h1>

<p style="font-size:18px;">
Selamat datang,
<b><?= $_SESSION['nama'] ?></b>
</p>

<div class="card-box">

    <div class="card green">
        <h2><?= $b['total'] ?></h2>
        <p>Total Barang</p>
    </div>

    <div class="card orange">
        <h2><?= $t['total'] ?></h2>
        <p>Total Transaksi</p>
    </div>

    <div class="card blue">
        <h2>Rp <?= number_format($u['total'] ?? 0, 0, ',', '.') ?></h2>
        <p>Total Pendapatan</p>
    </div>

</div>

<br><br>

<h3>📈 Grafik Penjualan</h3>

<canvas id="chartPenjualan" height="100"></canvas>

<?php
} elseif ($page == 'barang') {
    include "index.php";
} elseif ($page == 'transaksi') {
    include "transaksi.php";
} elseif ($page == 'riwayat') {
    include "riwayat.php";
} elseif ($page == 'user') {
    include "user.php";
} elseif ($page == 'laporan') {
    include "laporan.php";
} elseif ($page == 'barang_terlaris') {
    include "barang_terlaris.php";
}
?>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('chartPenjualan');

if (ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($tanggal ?? []) ?>,
            datasets: [{
                label: 'Penjualan',
                data: <?= json_encode($total ?? []) ?>,
                borderWidth: 3,
                fill: true
            }]
        }
    });
}
</script>
