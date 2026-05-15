<?php
include 'koneksi.php';


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Riwayat_Stok_".date('d-m-Y').".xls");
?>

<table border="0">
    <tr>
        <th colspan="6" style="font-size: 18px; text-align: left;">Riwayat Transaksi</th>
    </tr>
    <tr>
        <th colspan="6" style="font-size: 12px; text-align: left; color: #666; font-weight: normal;">
            Laporan aktivitas keluar masuk barang secara real-time
        </th>
    </tr>
    <tr>
        <th colspan="6"></th>
    </tr>
</table>

<table border="1">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>No</th>
            <th>Waktu & Tanggal</th>
            <th>Nama Barang</th>
            <th>Tipe</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        
        $query = "SELECT riwayat.*, barang.nama_barang 
                  FROM riwayat 
                  LEFT JOIN barang ON riwayat.id_barang = barang.id_barang 
                  ORDER BY riwayat.id_riwayat DESC";
        
        $result = mysqli_query($koneksi, $query);
        
        while($d = mysqli_fetch_assoc($result)){
            $jenis = $d['jenis_transaksi'] ?? $d['jenis'];
            $waktu = date('d/m/Y H:i', strtotime($d['tanggal']));
        ?>
        <tr>
            <td align="center"><?php echo $no++; ?></td>
            <td><?php echo $waktu; ?></td>
            <td><?php echo strtoupper($d['nama_barang']); ?></td>
            <td align="center"><?php echo strtoupper($jenis); ?></td>
            <td align="center"><?php echo $d['jumlah']; ?></td>
            <td><?php echo $d['keterangan']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>