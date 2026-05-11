<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Barang</title>
</head>
<body>
    <h2>Catat Barang Masuk / Keluar</h2>
    <a href="index.php">Kembali ke Dashboard</a><br><br>
    
    <form method="POST">
        <table>
            <tr>
                <td>Pilih Barang</td>
                <td>
                    <select name="id_barang" required>
                        <?php 
                        $barang = mysqli_query($koneksi, "SELECT * FROM barang");
                        while($b = mysqli_fetch_array($barang)){
                            echo "<option value='".$b['id_barang']."'>".$b['nama_barang']." (Stok: ".$b['stok'].")</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Jenis Transaksi</td>
                <td>
                    <select name="jenis" required>
                        <option value="masuk">Barang Masuk (+)</option>
                        <option value="keluar">Barang Keluar (-)</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td><input type="number" name="jumlah" min="1" required></td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td><textarea name="keterangan"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" name="proses">Proses Transaksi</button></td>
            </tr>
        </table>
    </form>

    <?php 
    if(isset($_POST['proses'])){
        $id_barang = $_POST['id_barang'];
        $jenis     = $_POST['jenis'];
        $jumlah    = $_POST['jumlah'];
        $ket       = $_POST['keterangan'];

        // 1. Simpan ke tabel riwayat
        $ins = mysqli_query($koneksi, "INSERT INTO riwayat (id_barang, jenis_transaksi, jumlah, keterangan) VALUES ('$id_barang', '$jenis', '$jumlah', '$ket')");

        if($ins){
            // 2. Update stok di tabel barang (Otomatis)
            if($jenis == 'masuk'){
                mysqli_query($koneksi, "UPDATE barang SET stok = stok + $jumlah WHERE id_barang = '$id_barang'");
            } else {
                mysqli_query($koneksi, "UPDATE barang SET stok = stok - $jumlah WHERE id_barang = '$id_barang'");
            }
            echo "<script>alert('Transaksi Berhasil!'); window.location='index.php';</script>";
        }
    }
    ?>
</body>
</html>