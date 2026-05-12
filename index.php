<?php 
session_start();

// Cek apakah user sudah login, jika belum maka dialihkan ke halaman login
if($_SESSION['status'] != "login"){
    header("location:login.php?pesan=belum_login");
}

include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Stok Barang</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; color: white; display: inline-block; }
        .btn-edit { background-color: #f0ad4e; }
        .btn-hapus { background-color: #d9534f; }
        .btn-logout { background-color: #333; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; float: right; }
        .menu { margin-bottom: 20px; padding: 10px 0; border-bottom: 1px solid #ddd; }
        .user-info { margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>

    <div class="user-info">
        <a href="logout.php" class="btn-logout">Logout</a>
        Selamat Datang, <b><?php echo $_SESSION['nama']; ?></b>!
    </div>

    <h2>Dashboard Manajemen Stok</h2>

    <div class="menu">
        <a href="tambah.php" style="background: #5cb85c; color: white; padding: 8px; text-decoration: none; border-radius: 3px;">+ Tambah Barang</a> | 
        <a href="transaksi.php" style="background: #0275d8; color: white; padding: 8px; text-decoration: none; border-radius: 3px;">+ Transaksi (Masuk/Keluar)</a> | 
        <a href="riwayat.php" style="text-decoration: none; color: #0275d8; font-weight: bold;">Lihat Riwayat Transaksi</a>
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