<table>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Stok</th>
            <th>Aksi</th> </tr>
        <?php
        $no = 1;
        $data = mysqli_query($koneksi, "SELECT * FROM barang");
        while($d = mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['kode_barang']; ?></td>
                <td><?php echo $d['nama_barang']; ?></td>
                <td><?php echo $d['stok']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $d['id_barang']; ?>">Edit</a> | 
                    <a href="hapus.php?id=<?php echo $d['id_barang']; ?>" onclick="return confirm('Yakin hapus data?')">Hapus</a>
                </td>
            </tr>
            <?php 
        }
        ?>
    </table>