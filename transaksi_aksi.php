<?php 
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta'); // Mengatur waktu agar sesuai WIB

// 1. Tangkap data dari form transaksi.php
$id_barang  = $_POST['id_barang'];
$jenis      = $_POST['jenis'];
$jumlah     = $_POST['jumlah'];
$keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
$tanggal    = date('Y-m-d H:i:s');

// 2. Ambil stok saat ini dari database
$query_stok = mysqli_query($koneksi, "SELECT stok FROM barang WHERE id_barang='$id_barang'");
$data_stok  = mysqli_fetch_array($query_stok);
$stok_sekarang = $data_stok['stok'];

// 3. Hitung stok baru berdasarkan jenis transaksi
if($jenis == "masuk"){
    $stok_baru = $stok_sekarang + $jumlah;
} else {
    // Jika barang keluar, pastikan stok mencukupi
    if($stok_sekarang < $jumlah){
        header("location:transaksi.php?pesan=stok_kurang");
        exit();
    }
    $stok_baru = $stok_sekarang - $jumlah;
}

// 4. Update stok di tabel 'barang'
$update_stok = mysqli_query($koneksi, "UPDATE barang SET stok='$stok_baru' WHERE id_barang='$id_barang'");

// 5. Simpan riwayat transaksi ke tabel 'riwayat'
$query_riwayat = "INSERT INTO riwayat (id_barang, jenis_transaksi, jumlah, keterangan, tanggal) 
                  VALUES ('$id_barang', '$jenis', '$jumlah', '$keterangan', '$tanggal')";

$insert_riwayat = mysqli_query($koneksi, $query_riwayat);

if($update_stok && $insert_riwayat){
    header("location:index.php?pesan=transaksi_berhasil");
} else {
    echo "Gagal memproses transaksi: " . mysqli_error($koneksi);
}
?>