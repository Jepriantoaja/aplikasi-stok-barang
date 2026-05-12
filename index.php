<?php 
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    header("location:login.php?pesan=belum_login");
    exit();
}
include 'koneksi.php'; 

// Mengambil data untuk Ringkasan
$total_barang = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang"));
$stok_limit = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang WHERE stok < 5"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Manajemen Stok</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #f0f2f5; margin: 0; padding: 20px; }
        
        /* Navbar Area */
        .header { 
            display: flex; justify-content: space-between; align-items: center; 
            background: white; padding: 15px 30px; border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px;
        }
        .user-info b { color: #0275d8; }
        .btn-logout { background: #dc3545; color: white; padding: 8px 15px; border-radius: 6px; text-decoration: none; font-size: 14px; }

        /* Stats Cards */
        .stats-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 25px; }
        .card-stat { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #0275d8; }
        .card-stat h3 { margin: 0; font-size: 14px; color: #777; text-transform: uppercase; }
        .card-stat p { margin: 10px 0 0; font-size: 28px; font-weight: bold; color: #333; }
        .border-warning { border-left-color: #ffc107; }

        /* Table & Action Area */
        .main-content { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .action-bar { margin-bottom: 25px; display: flex; gap: 10px; align-items: center; }
        .btn { padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.3s; }
        .btn-add { background: #28a745; color: white; }
        .btn-trans { background: #007bff; color: white; }
        .btn-history { color: #007bff; }
        .btn:hover { opacity: 0.8; transform: translateY(-2px); }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f8f9fa; padding: 15px; text-align: left; color: #555; border-bottom: 2px solid #eee; }
        td { padding: 15px; border-bottom: 1px solid #eee; vertical-align: middle; }
        .badge-stok { background: #e9ecef; padding: 5px 12px; border-radius: 20px; font-weight: bold; }
        .low-stock { color: #dc3545; background: #f8d7da; }
        
        .btn-edit { color: #ffc107; text-decoration: none; margin-right: 10px; font-weight: bold; }
        .btn-delete { color: #dc3545; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <div class="user-info">Selamat Datang, <b><?php echo $_SESSION['nama']; ?></b>!</div>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="stats-container">
        <div class="card-stat">
            <h3>Total Jenis Barang</h3>
            <p><?php echo $total_barang; ?></p>
        </div>
        <div class="card-stat border-warning">
            <h3>Stok Menipis (< 5)</h3>
            <p><?php echo $stok_limit; ?></p>
        </div>
    </div>

    <div class="main-content">
        <h2 style="margin-top:0; color:#2c3e50;">Dashboard Manajemen Stok</h2>
        
        <div class="action-bar">
            <a href="tambah.php" class="btn btn-add">+ Tambah Barang Baru</a>
            <a href="transaksi.php" class="btn btn-trans">+ Transaksi (Masuk/Keluar)</a>
            <a href="riwayat.php" class="btn btn-history">[ Lihat Riwayat ]</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Stok Saat Ini</th>
                    <th style="text-align: center;">Aksi Control</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");
                while($d = mysqli_fetch_array($data)){
                    $status_stok = ($d['stok'] < 5) ? 'low-stock' : '';
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td style="color: #999; font-family: monospace;"><?php echo $d['kode_barang']; ?></td>
                        <td><b><?php echo $d['nama_barang']; ?></b></td>
                        <td><span class="badge-stok <?php echo $status_stok; ?>"><?php echo $d['stok']; ?></span></td>
                        <td align="center">
                            <a href="edit.php?id=<?php echo $d['id_barang']; ?>" class="btn-edit">Edit</a>
                            <a href="hapus.php?id=<?php echo $d['id_barang']; ?>" class="btn-delete" onclick="return confirm('Hapus barang ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>