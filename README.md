# 🛒 Kasir App - Sistem Point of Sale (POS)

Aplikasi Kasir (POS) yang simpel dan mudah digunakan untuk mengelola penjualan, inventaris barang, dan transaksi di toko Anda.

## ✨ Fitur

- 🔐 **Autentikasi & Otorisasi**
  - Login dengan username dan password
  - Role-based access (Admin dan Kasir)
  - Keamanan password dengan bcrypt

- 📦 **Manajemen Barang**
  - Tambah, edit, dan hapus data barang
  - Kelola harga dan stok barang
  - Tracking stok real-time

- 🧾 **Transaksi Penjualan**
  - Buat transaksi penjualan dengan multiple items
  - Hitung otomatis subtotal, total, dan kembalian
  - Pencatatan kasir penanganan transaksi

- 📋 **Laporan**
  - Laporan penjualan harian/periode
  - Barang terlaris
  - Riwayat transaksi lengkap

- 🖨️ **Struk Digital**
  - Cetak struk penjualan
  - Format receipt siap untuk printer thermal

- 📊 **Dashboard**
  - Ringkasan penjualan
  - Statistik barang terlaris
  - Monitoring transaksi real-time

## 🛠️ Tech Stack

- **Backend**: PHP
- **Database**: MySQL/MariaDB
- **Frontend**: HTML, CSS, JavaScript
- **Server**: Apache (XAMPP)

## 📋 Persyaratan

- XAMPP atau Web Server dengan PHP 7.4+
- MySQL 5.7+
- Browser modern (Chrome, Firefox, Edge, Safari)

## 🚀 Instalasi

### 1. Clone atau download repository
```bash
git clone https://github.com/yourusername/kasir-app.git
cd kasir-app
```

### 2. Setup Database
1. Buka phpMyAdmin (http://localhost/phpmyadmin)
2. Import file `database.sql` ke database baru atau existing
3. Database akan dibuat otomatis dengan tabel:
   - `barang` - Data barang
   - `user` - User/kasir
   - `transaksi` - Record penjualan
   - `detail_transaksi` - Detail item per transaksi

### 3. Konfigurasi Database
1. Copy file `config.example.php` menjadi `config.php`
2. Sesuaikan konfigurasi:
```php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "kasir_toko";
```

### 4. Jalankan Aplikasi
Akses di browser: `http://localhost/kasir-app`

## 👤 Default Login

**Username**: `admin`  
**Password**: `admin`  
**Role**: Admin

> ⚠️ **Penting**: Ubah password admin setelah login pertama kali!

## 📁 Struktur File

```
kasir-app/
├── config.php              # Konfigurasi database
├── config.example.php      # Template konfigurasi
├── database.sql            # Database schema
├── index.php               # Halaman manajemen barang
├── Login.php               # Halaman login
├── Logout.php              # Logout user
├── Dashboard.php           # Dashboard utama
├── transaksi.php           # Halaman transaksi penjualan
├── struk.php               # Cetak struk
├── struk_multi.php         # Cetak struk multiple
├── laporan.php             # Laporan penjualan
├── barang_terlaris.php     # Laporan barang terlaris
├── riwayat.php             # Riwayat transaksi
├── hapus.php               # Fungsi hapus data
├── User.php                # Manajemen user
├── AGENT.py                # Script automasi
├── logo.png                # Logo aplikasi
└── .github/workflows/      # GitHub Actions
```

## 🔑 Fitur Utama

### 1. Dashboard
Tampilan ringkasan dengan:
- Total penjualan hari ini
- Barang terlaris
- Transaksi terbaru

### 2. Manajemen Barang (index.php)
- Tambah barang baru
- Edit harga dan stok
- Hapus barang
- View semua barang

### 3. Transaksi (transaksi.php)
- Pilih barang untuk dijual
- Tentukan jumlah
- Hitung otomatis total dan kembalian
- Simpan transaksi

### 4. Laporan
- **Laporan Penjualan**: Detail semua transaksi
- **Barang Terlaris**: Ranking barang berdasarkan penjualan
- **Riwayat**: History lengkap transaksi

### 5. User Management
- Tambah user baru (admin/kasir)
- Edit profil
- Kelola role pengguna

## 💡 Cara Penggunaan

### Workflow Penjualan
1. Login dengan akun kasir
2. Buka menu "Transaksi"
3. Pilih barang dari daftar
4. Masukkan jumlah yang ingin dijual
5. Sistem menghitung subtotal otomatis
6. Lanjutkan tambah item jika perlu
7. Masukkan jumlah pembayaran
8. Sistem menghitung kembalian
9. Simpan transaksi
10. Cetak struk

### Manajemen Stok
1. Login sebagai admin
2. Buka menu "Data Barang"
3. Tambah barang baru atau edit stok existing
4. Sistem otomatis update stok saat ada transaksi

## 🔒 Keamanan

- ✅ Password di-hash dengan bcrypt
- ✅ Prepared statements (SQL Injection protection)
- ✅ Session-based authentication
- ✅ Role-based access control
- ✅ Input validation

## 📝 License

Distributed under the MIT License. See LICENSE file for more information.

## 🤝 Kontribusi

Kami menerima kontribusi! Silakan:
1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

## 📞 Kontak & Support

Jika ada pertanyaan atau menghadapi masalah, silakan:
- Buka Issue di GitHub
- Hubungi melalui email
- Baca dokumentasi yang tersedia

## 🐛 Bug Report

Temukan bug? Silakan buat Issue dengan:
- Deskripsi bug yang jelas
- Steps to reproduce
- Expected vs actual behavior
- Screenshots jika diperlukan

## 📈 Roadmap

- [ ] Integrasi payment gateway
- [ ] Export laporan ke PDF/Excel
- [ ] Mobile app
- [ ] Real-time analytics dashboard
- [ ] Inventory forecasting
- [ ] Multi-branch support
- [ ] API REST

---

## 👨‍💻 Author

| Attribute | Informasi |
|-----------|-----------|
| **Nama** | Nur Laeli Fitriani |
| **NIM** | 101230051 |
| **Mata Kuliah** | Kewirausahaan Teknologi |
| **Kelas** | TF23C |

---

**Made with ❤️ for small business owners**
