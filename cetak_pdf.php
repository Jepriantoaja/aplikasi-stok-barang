<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Print Laporan Riwayat</title>
    <style>
        body { font-family: 'Arial', sans-serif; padding: 30px; }
        .header { text-align: center; border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 10px; text-align: left; font-size: 12px; }
        th { background: #f0f0f0; }
        .footer { margin-top: 30px; text-align: right; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>STOCK MASTER REPORT</h1>
        <p>Laporan Riwayat Transaksi Barang - Tanggal: <?php echo date('d F Y'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT riwayat.*, barang.nama_barang FROM riwayat JOIN barang ON riwayat.id_barang = barang.id_barang ORDER BY tanggal DESC");
            while($d = mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($d['tanggal'])); ?></td>
                <td><?php echo strtoupper($d['nama_barang']); ?></td>
                <td><?php echo strtoupper($d['jenis_transaksi']); ?></td>
                <td><?php echo $d['jumlah']; ?></td>
                <td><?php echo $d['keterangan']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: <?php echo date('d/m/Y H:i:s'); ?></p>
        <br><br><br>
        <p>( _________________________ )</p>
        <p>Admin Gudang</p>
    </div>

    <script>window.print();</script>
</body>
</html>