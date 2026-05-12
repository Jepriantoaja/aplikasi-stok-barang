<?php 
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    header("location:login.php?pesan=belum_login");
    exit();
}
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang - Inventory</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; padding: 40px; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
        h2 { color: #2c3e50; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .btn-simpan { background: #5cb85c; color: white; border: none; padding: 12px 20px; border-radius: 6px; cursor: pointer; width: 100%; font-weight: bold; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #777; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Tambah Barang Baru</h2>
        <form action="tambah_aksi.php" method="POST">
            <div class="form-group">
                <label>Kode Barang</label>
                <input type="text" name="kode_barang" placeholder="Contoh: BRG-001" required>
            </div>
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" placeholder="Masukkan nama barang" required>
            </div>
            <div class="form-group">
                <label>Stok Awal</label>
                <input type="number" name="stok" value="0" required>
            </div>
            <button type="submit" class="btn-simpan">Simpan Data Barang</button>
            <a href="index.php" class="btn-back"><< Kembali ke Dashboard</a>
        </form>
    </div>
</body>
</html>