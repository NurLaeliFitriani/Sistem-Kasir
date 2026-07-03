<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$exit_code = 0;

echo "=== Smoke Test Kasir App ===\n\n";

require_once 'config.php';

echo "[OK] Koneksi database berhasil\n";

// Test 1: Cek tabel barang
$result = mysqli_query($conn, "SHOW TABLES LIKE 'barang'");
if (mysqli_num_rows($result) > 0) {
    echo "[OK] Tabel 'barang' ditemukan\n";
} else {
    echo "[FAIL] Tabel 'barang' tidak ditemukan\n";
    $exit_code = 1;
}

// Test 2: Cek tabel user
$result = mysqli_query($conn, "SHOW TABLES LIKE 'user'");
if (mysqli_num_rows($result) > 0) {
    echo "[OK] Tabel 'user' ditemukan\n";
} else {
    echo "[FAIL] Tabel 'user' tidak ditemukan\n";
    $exit_code = 1;
}

// Test 3: Cek tabel transaksi
$result = mysqli_query($conn, "SHOW TABLES LIKE 'transaksi'");
if (mysqli_num_rows($result) > 0) {
    echo "[OK] Tabel 'transaksi' ditemukan\n";
} else {
    echo "[FAIL] Tabel 'transaksi' tidak ditemukan\n";
    $exit_code = 1;
}

// Test 4: Cek tabel detail_transaksi
$result = mysqli_query($conn, "SHOW TABLES LIKE 'detail_transaksi'");
if (mysqli_num_rows($result) > 0) {
    echo "[OK] Tabel 'detail_transaksi' ditemukan\n";
} else {
    echo "[FAIL] Tabel 'detail_transaksi' tidak ditemukan\n";
    $exit_code = 1;
}

// Test 5: Cek user admin
$result = mysqli_query($conn, "SELECT * FROM user WHERE username='admin'");
if (mysqli_num_rows($result) > 0) {
    $admin = mysqli_fetch_assoc($result);
    if (password_verify('admin', $admin['password'])) {
        echo "[OK] User admin dengan password 'admin' valid\n";
    } else {
        echo "[FAIL] Password admin tidak valid\n";
        $exit_code = 1;
    }
} else {
    echo "[FAIL] User admin tidak ditemukan\n";
    $exit_code = 1;
}

// Test 6: Prepared statement test (barang)
$stmt = mysqli_prepare($conn, "INSERT INTO barang (nama_barang, harga, stok) VALUES (?, ?, ?)");
if ($stmt) {
    $nama_test = "Test Barang CI";
    $harga_test = 10000;
    $stok_test = 5;
    mysqli_stmt_bind_param($stmt, "sii", $nama_test, $harga_test, $stok_test);
    if (mysqli_stmt_execute($stmt)) {
        echo "[OK] Prepared statement INSERT barang berhasil\n";
        $id_barang = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);

        // Test 7: Read dengan prepared statement
        $stmt2 = mysqli_prepare($conn, "SELECT * FROM barang WHERE id_barang=?");
        mysqli_stmt_bind_param($stmt2, "i", $id_barang);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $barang = mysqli_fetch_assoc($result2);
        if ($barang['nama_barang'] === $nama_test) {
            echo "[OK] Prepared statement SELECT barang berhasil\n";
        } else {
            echo "[FAIL] Prepared statement SELECT barang gagal\n";
            $exit_code = 1;
        }
        mysqli_stmt_close($stmt2);

        // Bersihkan data test
        mysqli_query($conn, "DELETE FROM barang WHERE id_barang=$id_barang");
    } else {
        echo "[FAIL] Prepared statement INSERT barang gagal: " . mysqli_error($conn) . "\n";
        $exit_code = 1;
    }
} else {
    echo "[FAIL] Gagal membuat prepared statement: " . mysqli_error($conn) . "\n";
    $exit_code = 1;
}

echo "\n=== Selesai ===\n";

if ($exit_code === 0) {
    echo "Semua test PASSED\n";
} else {
    echo "Beberapa test FAILED\n";
}

exit($exit_code);
