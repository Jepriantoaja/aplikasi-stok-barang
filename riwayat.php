<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Transaksi</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .masuk { color: #5cb85c; font-weight: bold; }
        .keluar { color: #d9534f; font-weight: bold; }
        .btn-back { text-decoration: none; color: #0275d8; }
    </style>
</head>
<body>
    <h2>Laporan Riwayat Barang Masuk & Keluar</h2>
    <a href="index.php" class="btn-back"><< Kembali ke Dashboard</a>
    
    <table>
        <tr>
            <th>No</th>
            <th>Tanggal & Waktu</th>
            <th>Nama Barang</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </tr>
        <?php 
        $no = 1;
        // Query untuk menggabungkan tabel riwayat dan barang
        $sql = "SELECT riwayat.*, barang.nama_barang 
                FROM riwayat 
                JOIN barang ON riwayat.id_barang = barang.id_barang 
                ORDER BY tanggal DESC";
        $query = mysqli_query($koneksi, $sql);
        
        while($r = mysqli_fetch_array($query)){
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($r['tanggal'])); ?></td>
                <td><?php echo $r['nama_barang']; ?></td>
                <td class="<?php echo $r['jenis_transaksi']; ?>">
                    <?php echo strtoupper($r['jenis_transaksi']); ?>
                </td>
                <td><?php echo $r['jumlah']; ?></td>
                <td><?php echo $r['keterangan']; ?></td>
            </tr>
            <?php 
        }
        ?>
    </table>
</body>
</html>