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
        body { font-family: 'Segoe UI', sans-serif; padding: 30px; background-color: #f4f7f6; color: #333; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        h2 { margin-top: 0; color: #2c3e50; display: inline-block; }
        .btn-back { float: right; background: #3498db; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; }
        table { border-collapse: collapse; width: 100%; margin-top: 25px; overflow: hidden; border-radius: 8px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #2c3e50; color: white; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; }
        tr:hover { background-color: #f9f9f9; }
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; }
        .masuk { background-color: #d4edda; color: #155724; }
        .keluar { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Riwayat Transaksi</h2>
        <a href="index.php" class="btn-back"> Kembali</a>
        
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
                $query = mysqli_query($koneksi, "SELECT riwayat.*, barang.nama_barang FROM riwayat 
                        JOIN barang ON riwayat.id_barang = barang.id_barang ORDER BY tanggal DESC");
                while($r = mysqli_fetch_array($query)){
                    $type_class = ($r['jenis_transaksi'] == 'masuk') ? 'masuk' : 'keluar';
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><small><?php echo date('d M Y, H:i', strtotime($r['tanggal'])); ?></small></td>
                        <td><b><?php echo $r['nama_barang']; ?></b></td>
                        <td><span class="badge <?php echo $type_class; ?>"><?php echo strtoupper($r['jenis_transaksi']); ?></span></td>
                        <td><?php echo $r['jumlah']; ?></td>
                        <td><i style="color: #777;"><?php echo $r['keterangan']; ?></i></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>