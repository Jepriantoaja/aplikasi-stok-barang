<?php 
// 1. Hubungkan ke database
include 'koneksi.php';

// 2. Tangkap data dari form
$kode_barang = mysqli_real_escape_string($koneksi, $_POST['kode_barang']);
$nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
$stok        = mysqli_real_escape_string($koneksi, $_POST['stok']);

// 3. Input data ke tabel 'barang'
$query = "INSERT INTO barang (kode_barang, nama_barang, stok) VALUES ('$kode_barang', '$nama_barang', '$stok')";

if (mysqli_query($koneksi, $query)) {
    // Jika berhasil, balik ke index.php
    header("location:index.php?pesan=berhasil");
} else {
    // Jika gagal, tampilkan pesan error yang spesifik
    echo "Gagal input data. Pesan Error: " . mysqli_error($koneksi);
}
?>