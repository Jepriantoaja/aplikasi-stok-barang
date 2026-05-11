<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Stok Barang</title>
    <style>
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Daftar Stok Barang</h2>
    <a href="tambah.php">+ Tambah Barang Baru</a><br><br>
    <table>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Stok</th>
        </tr>
        <?php
        $no = 1;
        $data = mysqli_query($koneksi, "SELECT * FROM barang");
        while($d = mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['kode_barang']; ?></td>
                <td><?php echo $d['nama_barang']; ?></td>
                <td><?php echo $d['stok']; ?></td>
            </tr>
            <?php 
        }
        ?>
    </table>
</body>
</html>~