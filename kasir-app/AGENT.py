"""
AGENT.py — Aturan untuk AI dalam pengembangan & pemeliharaan aplikasi Kasir

IKUTI ATURAN INI SETIAP BEKERJA PADA PROYEK INI.
"""

PROJECT_RULES = {
    "nama": "TB. Jaya Santosa - Sistem Kasir",
    "stack": "PHP 7.4+ / MySQL / XAMPP",
    "db_host": "localhost",
    "db_user": "root",
    "db_pass": "",
    "db_name": "kasir_toko",
}

WORKFLOW = """
## WORKFLOW PENGEMBANGAN

1. EDIT CODE
   - Lakukan perubahan kode di localhost (C:\\xampp\\htdocs\\kasir-app)
   - Gunakan prepared statements (mysqli) untuk semua query SQL
   - Hash password dengan password_hash()/verify dengan password_verify()
   - Gunakan require_once 'config.php' untuk koneksi DB (jangan hardcode)
   - JANGAN commit config.php (ada di .gitignore)

2. TEST LOKAL
   - Jalankan: php -l setiap file yang diubah
   - Buka di browser: http://localhost/kasir-app/login.php
   - Test login admin/admin, buat transaksi, cek riwayat & laporan
   - Pastikan tidak ada error/warning PHP

3. COMMIT & PUSH
   - git add <file>
   - git commit -m "pesan singkat dalam Bahasa Indonesia"
   - git push origin master

4. CI/CD (GitHub Actions)
   - Setelah push, GitHub Actions otomatis menjalankan:
     a. PHP syntax check (php -l) semua file .php
     b. Test koneksi database & query dasar
   - Jika CI gagal → baca log error → perbaiki → ulangi dari step 1
"""

COMMIT_RULES = """
## ATURAN COMMIT
- Bahasa Indonesia
- Format: "jenis: deskripsi singkat"
- Jenis: feat, fix, refactor, style, docs, chore
- Contoh: "fix: sql injection di login.php"
- JANGAN commit file config.php, .env, *.log
"""

CI_RULES = """
## CONTINUOUS INTEGRATION
- Workflow ada di .github/workflows/test.yml
- Trigger: push ke semua branch
- Wajib lolos semua CI check sebelum merge
- Jika CI gagal, analisa error dan buat fix commit
"""

TESTS = """
## CARA TEST
- LOKAL: php -l <file.php> untuk syntax check
- LOKAL: php test.php untuk smoke test database
- CI OTOMATIS: push ke GitHub → GitHub Actions jalankan test.yml
- Jika test gagal: baca output error, fix code, commit ulang
"""
