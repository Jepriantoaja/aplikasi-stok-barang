<?php 
session_start();
// Proteksi Halaman
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    header("location:login.php?pesan=belum_login");
    exit();
}
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Barang - Inventory System</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body {
            margin: 0; padding: 0;
            display: flex; justify-content: center; align-items: center;
            min-height: 100vh; background-color: #f4f7f6;
        }
        .card {
            background: white; padding: 40px;
            border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%; max-width: 500px;
        }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 25px; font-weight: 700; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; font-size: 14px; }
        select, input, textarea {
            width: 100%; padding: 12px 15px;
            border: 1px solid #ddd; border-radius: 8px;
            outline: none; transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        select:focus, input:focus, textarea:focus {
            border-color: #0275d8; background-color: #fff;
            box-shadow: 0 0 8px rgba(2, 117, 216, 0.15);
        }
        textarea { height: 80px; resize: none; }
        .btn-proses {
            width: 100%; padding: 14px;
            background: #0275d8; color: white;
            border: none; border-radius: 8px;
            font-size: 16px; font-weight: 700;
            cursor: pointer; transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(2, 117, 216, 0.2);
        }
        .btn-proses:hover { background: #025aa5; transform: translateY(-2px); }
        .btn-back {
            display: block; text-align: center; margin-top: 20px;
            color: #3498db; text-decoration: none;
            font-size: 14px; font-weight: 600;
        }
        .btn-back:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Catat Transaksi</h2>
        
        <form method="POST">
            <div class="form-group">
                <label>Pilih Barang</label>
                <select name="id_barang" required>
                    <option value="" disabled selected>-- Pilih Barang --</option>
                    <?php 
                    $barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");
                    while($b = mysqli_fetch_array($barang)){
                        echo "<option value='".$b['id_barang']."'>".$b['nama_barang']." (Stok: ".$b['stok'].")</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Jenis Transaksi</label>
                <select name="jenis" required>
                    <option value="masuk">Barang Masuk (+)</option>
                    <option value="keluar">Barang Keluar (-)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Jumlah Unit</label>
                <input type="number" name="jumlah" min="1" placeholder="Masukkan jumlah unit" required>
            </div>

            <div class="form-group">
                <label>Keterangan Tambahan</label>
                <textarea name="keterangan" placeholder="Contoh: Pengadaan stok baru atau pesanan pelanggan"></textarea>
            </div>

            <button type="submit" name="proses" class="btn-proses">PROSES TRANSAKSI</button>
            <a href="index.php" class="btn-back"> Kembali ke Dashboard</a>
        </form>
    </div>

    <?php 
    if(isset($_POST['proses'])){
        $id_barang = mysqli_real_escape_string($koneksi, $_POST['id_barang']);
        $jenis     = mysqli_real_escape_string($koneksi, $_POST['jenis']);
        $jumlah    = mysqli_real_escape_string($koneksi, $_POST['jumlah']);
        $ket       = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

        // 1. Simpan ke tabel riwayat
        $ins = mysqli_query($koneksi, "INSERT INTO riwayat (id_barang, jenis_transaksi, jumlah, keterangan) VALUES ('$id_barang', '$jenis', '$jumlah', '$ket')");

        if($ins){
            // 2. Update stok di tabel barang (Otomatis)
            if($jenis == 'masuk'){
                mysqli_query($koneksi, "UPDATE barang SET stok = stok + $jumlah WHERE id_barang = '$id_barang'");
            } else {
                mysqli_query($koneksi, "UPDATE barang SET stok = stok - $jumlah WHERE id_barang = '$id_barang'");
            }
            echo "<script>alert('Transaksi Berhasil!'); window.location='index.php';</script>";
        }
    }
    ?>
</body>
</html>