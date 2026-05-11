<?php 
include 'koneksi.php'; // Pastikan koneksi dipanggil di paling atas
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Stok Barang</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; color: white; }
        .btn-edit { background-color: #f0ad4e; }
        .btn-hapus { background-color: #d9534f; }
        .menu { margin-bottom: 20px; }
    </style>
</head>
<body>

    <h2>Dashboard Manajemen Stok</h2>

    <div class="menu">
        <a href="tambah.php" style="background: #5cb85c; color: white; padding: 8px; text-decoration: none;">+ Tambah Barang</a> | 
        <a href="transaksi.php" style="background: #0275d8; color: white; padding: 8px; text-decoration: none;">+ Transaksi (Masuk/Keluar)</a> | 
        <a href="riwayat.php">Lihat Riwayat Transaksi</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Stok Saat Ini</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            // Query mengambil data dari tabel barang
            $data = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id_barang DESC");
            
            if (mysqli_num_rows($data) > 0) {
                while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><strong><?php echo $d['kode_barang']; ?></strong></td>
                        <td><?php echo $d['nama_barang']; ?></td>
                        <td><?php echo $d['stok']; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $d['id_barang']; ?>" class="btn btn-edit">Edit</a>
                            <a href="hapus.php?id=<?php echo $d['id_barang']; ?>" class="btn btn-hapus" onclick="return confirm('Yakin ingin menghapus barang ini? Semua riwayat terkait juga akan hilang.')">Hapus</a>
                        </td>
                    </tr>
                    <?php 
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center;'>Belum ada data barang.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>