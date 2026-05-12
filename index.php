<?php 
session_start();

// Proteksi Halaman: Jika belum login, dilempar ke login.php
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    header("location:login.php?pesan=belum_login");
    exit();
}

include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Stok Barang</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background-color: #f9f9f9; }
        .header-box { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; }
        table { border-collapse: collapse; width: 100%; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #eee; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; color: #333; }
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; color: white; display: inline-block; font-size: 13px; }
        .btn-edit { background-color: #f0ad4e; }
        .btn-hapus { background-color: #d9534f; }
        .btn-logout { background-color: #333; float: right; }
        .menu { margin: 20px 0; }
        .badge-stok { background: #eee; padding: 3px 8px; border-radius: 10px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header-box">
        <a href="logout.php" class="btn btn-logout" onclick="return confirm('Yakin ingin keluar?')">Logout</a>
        <span>Selamat Datang, <b><?php echo $_SESSION['nama']; ?></b>!</span>
        <h2 style="margin-top: 10px; color: #2c3e50;">Dashboard Manajemen Stok</h2>
    </div>

    <div class="menu">
        <a href="tambah.php" class="btn" style="background: #5cb85c;">+ Tambah Barang Baru</a>
        <a href="transaksi.php" class="btn" style="background: #0275d8;">+ Transaksi (Masuk/Keluar)</a>
        <a href="riwayat.php" style="margin-left: 15px; text-decoration: none; color: #0275d8; font-weight: bold;">[ Lihat Riwayat ]</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Stok Saat Ini</th>
                <th>Aksi Control</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            // Menampilkan barang terbaru di posisi paling atas
            $data = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id_barang DESC");
            
            if (mysqli_num_rows($data) > 0) {
                while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><code style="color: #e83e8c;"><?php echo $d['kode_barang']; ?></code></td>
                        <td><b><?php echo $d['nama_barang']; ?></b></td>
                        <td><span class="badge-stok"><?php echo $d['stok']; ?></span></td>
                        <td>
                            <a href="edit.php?id=<?php echo $d['id_barang']; ?>" class="btn btn-edit">Edit</a>
                            <a href="hapus.php?id=<?php echo $d['id_barang']; ?>" class="btn btn-hapus" onclick="return confirm('Peringatan: Menghapus barang akan menghapus seluruh data transaksi terkait. Lanjutkan?')">Hapus</a>
                        </td>
                    </tr>
                    <?php 
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center; padding: 30px;'>Belum ada data barang. Silakan tambah barang baru.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>