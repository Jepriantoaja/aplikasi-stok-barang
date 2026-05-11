<?php 
include 'koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang='$id'");

if($query){
    header("location:index.php?pesan=hapus");
} else {
    echo "Gagal menghapus: " . mysqli_error($koneksi);
}
?>