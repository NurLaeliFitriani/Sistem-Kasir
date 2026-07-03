CREATE DATABASE IF NOT EXISTS kasir_toko;
USE kasir_toko;

CREATE TABLE IF NOT EXISTS barang (
    id_barang INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(255) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'kasir') NOT NULL DEFAULT 'kasir'
);

CREATE TABLE IF NOT EXISTS transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total INT NOT NULL,
    kasir VARCHAR(255) NOT NULL,
    bayar INT NOT NULL DEFAULT 0,
    kembalian INT NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS detail_transaksi (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT NOT NULL,
    nama_barang VARCHAR(255) NOT NULL,
    harga INT NOT NULL,
    jumlah INT NOT NULL,
    subtotal INT NOT NULL,
    FOREIGN KEY (id_transaksi) REFERENCES transaksi(id_transaksi) ON DELETE CASCADE
);

-- Default admin (password: admin)
INSERT INTO user (nama, username, password, role) VALUES
('Admin', 'admin', '$2y$10$.dTSzEiGtIv8JXV2F4Nq5uc6Wq5Y.0ZWZdHl.2hxRpIqcL/qP8dly', 'admin');
