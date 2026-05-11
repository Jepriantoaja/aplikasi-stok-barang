<?php 
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id'");
$d = mysqli_fetch_array($data);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
</head>
<body>
    <h2>Edit Data Barang</h2>
    <form method="POST">
        <table>
            <tr>
                <td>Nama Barang</td>
                <td><input type="text" name="nama_barang" value="<?php echo $d['nama_barang']; ?>" required></td>
            </tr>
            <tr>
                <td>Kode Barang</td>
                <td><input type="text" name="kode_barang" value="<?php echo $d['kode_barang']; ?>" required></td>
            </tr>
            <tr>
                <td>Stok</td>
                <td><input type="number" name="stok" value="<?php echo $d['stok']; ?>" required></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" name="update">Simpan Perubahan</button></td>
            </tr>
        </table>
    </form>

    <?php 
    if(isset($_POST['update'])){
        $nama = $_POST['nama_barang'];
        $kode = $_POST['kode_barang'];
        $stok = $_POST['stok'];

        $update = mysqli_query($koneksi, "UPDATE barang SET nama_barang='$nama', kode_barang='$kode', stok='$stok' WHERE id_barang='$id'");

        if($update){
            echo "<script>alert('Data Berhasil Diupdate'); window.location='index.php';</script>";
        } else {
            echo "Gagal update: " . mysqli_error($koneksi);
        }
    }
    ?>
</body>
</html>