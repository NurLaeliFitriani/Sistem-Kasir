<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once 'config.php';

$data_barang = mysqli_query($conn, "SELECT * FROM barang");

if (isset($_POST['tambah'])) {
    $id = intval($_POST['id_barang']);
    $jumlah = max(1, intval($_POST['jumlah']));

    $stmt = mysqli_prepare($conn, "SELECT * FROM barang WHERE id_barang=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $b = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $_SESSION['keranjang'][] = [
        'nama' => $b['nama_barang'],
        'harga' => $b['harga'],
        'jumlah' => $jumlah
    ];
}

if (isset($_GET['plus'])) {
    $key = $_GET['plus'];

    if (isset($_SESSION['keranjang'][$key])) {
        $_SESSION['keranjang'][$key]['jumlah']++;
    }
}

if (isset($_GET['minus'])) {
    $key = $_GET['minus'];

    if (isset($_SESSION['keranjang'][$key])) {
        if ($_SESSION['keranjang'][$key]['jumlah'] > 1) {
            $_SESSION['keranjang'][$key]['jumlah']--;
        } else {
            unset($_SESSION['keranjang'][$key]);
            $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
        }
    }
}

if (isset($_POST['selesai']) && !empty($_SESSION['keranjang'])) {
    $total = 0;

    foreach ($_SESSION['keranjang'] as $k) {
        $total += $k['harga'] * $k['jumlah'];
    }

    $kasir = $_SESSION['nama'];
    $bayar = intval($_POST['bayar']);
    $kembalian = $bayar - $total;

    if ($bayar < $total) {
        echo "<script>alert('Uang bayar kurang!');</script>";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO transaksi (tanggal, total, kasir, bayar, kembalian) VALUES (NOW(), ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "isii", $total, $kasir, $bayar, $kembalian);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_error($stmt)) {
            die("ERROR: " . mysqli_stmt_error($stmt));
        }

        $id_transaksi = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);

        foreach ($_SESSION['keranjang'] as $k) {
            $subtotal = $k['harga'] * $k['jumlah'];
            $stmt2 = mysqli_prepare($conn, "INSERT INTO detail_transaksi (id_transaksi, nama_barang, harga, jumlah, subtotal) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt2, "isiii", $id_transaksi, $k['nama'], $k['harga'], $k['jumlah'], $subtotal);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);
        }

        unset($_SESSION['keranjang']);

        echo "<script>
        window.location='struk_multi.php?id=" . $id_transaksi . "';
        </script>";
        exit;
    }
}
?>

<h2>💰 Transaksi Kasir</h2>

<p>
Kasir: <b><?= $_SESSION['nama'] ?></b>
</p>

<input
type="text"
id="searchBarang"
placeholder="🔍 Cari barang..."
style="padding:8px; width:300px;"
>

<br><br>

<form method="POST">

<select name="id_barang" id="barangList" required>

<option value="">-- Pilih Barang --</option>

<?php while ($b = mysqli_fetch_assoc($data_barang)) { ?>

<option value="<?= $b['id_barang'] ?>">
<?= $b['nama_barang'] ?> - Rp <?= number_format($b['harga'], 0, ',', '.') ?>
</option>

<?php } ?>

</select>

<br><br>

<input
type="number"
name="jumlah"
min="1"
required
placeholder="Jumlah"
>

<br><br>

<button name="tambah">
Tambah
</button>

</form>

<h3>Keranjang</h3>

<table border="1" cellpadding="8">

<tr>
<th>Barang</th>
<th>Harga</th>
<th>Jumlah</th>
<th>Total</th>
</tr>

<?php
$total_semua = 0;

if (!empty($_SESSION['keranjang'])) {

foreach ($_SESSION['keranjang'] as $key => $k) {

    $total = $k['harga'] * $k['jumlah'];
    $total_semua += $total;
?>

<tr>

<td>
<?= $k['nama'] ?>
</td>

<td style="font-family:monospace;">

<div style="
display:flex;
justify-content:flex-end;
gap:5px;
">

<span>Rp</span>

<span style="
width:90px;
text-align:right;
">
<?= number_format($k['harga'], 0, ',', '.') ?>
</span>

</div>

</td>

<td align="center">

<a href="?page=transaksi&minus=<?= $key ?>">
➖
</a>

<b>
<?= $k['jumlah'] ?>
</b>

<a href="?page=transaksi&plus=<?= $key ?>">
➕
</a>

</td>

<td style="font-family:monospace;">

<div style="
display:flex;
justify-content:flex-end;
gap:5px;
">

<span>Rp</span>

<span style="
width:90px;
text-align:right;
">
<?= number_format($total, 0, ',', '.') ?>
</span>

</div>

</td>

</tr>

<?php }} ?>

<tr>

<td colspan="3">
<b>Total</b>
</td>

<td style="font-family:monospace;">

<div style="
display:flex;
justify-content:flex-end;
gap:5px;
">

<b>Rp</b>

<b style="
width:90px;
text-align:right;
">
<?= number_format($total_semua, 0, ',', '.') ?>
</b>

</div>

</td>

</tr>

</table>

<br>

<form method="POST">

<label>
💵 Uang Bayar
</label>

<br><br>

<input
type="number"
name="bayar"
required
placeholder="Masukkan uang bayar"
style="padding:10px; width:250px;"
>

<br><br>

<button
name="selesai"
style="
padding:10px 15px;
background:#2ecc71;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
">

💾 Simpan & Cetak

</button>

</form>

<script>

const search = document.getElementById('searchBarang');
const list = document.getElementById('barangList');

let allOptions = Array.from(list.options);
const firstOption = allOptions[0];

search.addEventListener('keyup', function() {

    let filter = search.value.toLowerCase();

    list.innerHTML = "";

    list.appendChild(firstOption);

    allOptions.forEach((opt, index) => {

        if (index === 0) return;

        if (opt.text.toLowerCase().includes(filter)) {
            list.appendChild(opt);
        }

    });

});

</script>
