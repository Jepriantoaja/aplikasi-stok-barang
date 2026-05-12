<?php 
// menghubungkan koneksi database
include 'koneksi.php';

// menangkap data yang di kirim dari form
$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$stok = $_POST['stok'];

// menginput data ke database
mysqli_query($koneksi,"insert into barang values('','$kode_barang','$nama_barang','$stok')");

// mengalihkan halaman kembali ke index.php
header("location:index.php");

?>