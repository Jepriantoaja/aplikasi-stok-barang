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
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
        h2 { color: #2c3e50; margin-bottom: 25px; text-align: center; font-weight: 700; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; font-size: 14px; }
        input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; outline: none; transition: 0.3s; }
        input:focus { border-color: #5cb85c; box-shadow: 0 0 8px rgba(92, 184, 92, 0.2); }
        .btn-simpan { background: #5cb85c; color: white; border: none; padding: 14px; border-radius: 8px; cursor: pointer; width: 100%; font-weight: bold; font-size: 16px; transition: 0.3s; }
        .btn-simpan:hover { background: #4cae4c; transform: translateY(-2px); }
        .btn-back { display: block; text-align: center; margin-top: 20px; color: #3498db; text-decoration: none; font-size: 14px; font-weight: 600; }
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
            <a href="index.php" class="btn-back"> Kembali ke Dashboard</a>
        </form>
    </div>
</body>
</html>