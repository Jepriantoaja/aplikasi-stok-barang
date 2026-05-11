<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
</head>
<body>
    <h2>Tambah Barang Baru</h2>
    <form method="POST">
        <table border="0">
            <tr><td>Kode Barang</td><td><input type="text" name="kode_barang" placeholder="Contoh: BRG-001" required></td></tr>
            <tr><td>Nama Barang</td><td><input type="text" name="nama_barang" required></td></tr>
            <tr><td>Stok Awal</td><td><input type="number" name="stok" value="0" required></td></tr>
            <tr><td></td><td><button type="submit" name="simpan">Simpan Barang</button></td></tr>
        </table>
    </form>

    <?php
    if(isset($_POST['simpan'])){
        $kode = $_POST['kode_barang'];
        $nama = $_POST['nama_barang'];
        $stok = $_POST['stok'];

        // Menginput data ke tabel barang
        $query = mysqli_query($koneksi, "INSERT INTO barang (nama_barang, kode_barang, stok) VALUES ('$nama', '$kode', '$stok')");

        if($query){
            echo "<script>alert('Berhasil!'); window.location='index.php';</script>";
        } else {
            echo "Gagal: " . mysqli_error($koneksi);
        }
    }
    ?>
</body>
</html>