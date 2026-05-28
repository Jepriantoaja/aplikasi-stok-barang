# Aplikasi Manajemen Stok Barang Berbasis Web

Aplikasi berbasis web yang dirancang untuk mengelola sistem inventaris, transaksi masuk-keluar barang, serta pelaporan stok secara efisien dan terstruktur.

Fitur Utama
* **Autentikasi & Hak Akses:** Sistem login dan pengelolaan sesi (*session*) pengguna yang aman (`login.php`, `cek_login.php`, `logout.php`).
* **Manajemen Stok Kontrol:** Fitur tambah, edit, pencarian cepat, serta hapus data barang (`tambah.php`, `edit.php`, `hapus.php`).
* **Validasi Cerdas:** Sistem validasi otomatis untuk mencegah input stok kosong atau tidak valid saat transaksi berjalan.
* **Pencatatan Transaksi:** Log pencatatan transaksi barang masuk dan keluar secara *real-time* (`transaksi.php`, `riwayat.php`).
* **Ekspor Laporan (Fitur Unggulan):** Fitur untuk mengunduh dan mencetak laporan inventaris ke dalam format **Excel** (`cetak_excel.php`) dan **PDF** (`cetak_pdf.php`).

Teknologi yang Digunakan
* **Bahasa Pemrograman:** PHP
* **Database:** MySQL
* **Antarmuka (Frontend):** HTML, CSS, JavaScript (UI dioptimalkan untuk kemudahan input data)

Cara Menjalankan Proyek di Lokal
1. Download atau *clone* repositori ini.
2. Pindahkan folder proyek ke dalam direktori server lokal Anda (misalnya: `xampp/htdocs/`).
3. Import database MySQL (silakan periksa dan sesuaikan konfigurasi database di file `koneksi.php`).
4. Buka browser Anda dan akses aplikasi melalui URL: `http://localhost/aplikasi-stok-barang/login.php`.
