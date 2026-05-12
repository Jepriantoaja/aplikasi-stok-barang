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
    <title>Riwayat Transaksi - Inventory</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 20px; background-color: #f9f9f9; }
        .container { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        h2 { color: #2c3e50; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #eee; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; color: #333; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .masuk { background-color: #d4edda; color: #155724; }
        .keluar { background-color: #f8d7da; color: #721c24; }
        .btn-back { text-decoration: none; color: #0275d8; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Laporan Riwayat Transaksi</h2>
        <a href="index.php" class="btn-back"><< Kembali ke Dashboard</a>
        
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>Barang</th>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $sql = "SELECT riwayat.*, barang.nama_barang FROM riwayat 
                        JOIN barang ON riwayat.id_barang = barang.id_barang 
                        ORDER BY tanggal DESC";
                $query = mysqli_query($koneksi, $sql);
                while($r = mysqli_fetch_array($query)){
                    $kelas = ($r['jenis_transaksi'] == 'masuk') ? 'masuk' : 'keluar';
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($r['tanggal'])); ?></td>
                        <td><b><?php echo $r['nama_barang']; ?></b></td>
                        <td><span class="badge <?php echo $kelas; ?>"><?php echo $r['jenis_transaksi']; ?></span></td>
                        <td><?php echo $r['jumlah']; ?></td>
                        <td><?php echo $r['keterangan']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>