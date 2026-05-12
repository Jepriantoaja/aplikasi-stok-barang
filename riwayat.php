<?php 
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    header("location:login.php?pesan=belum_login");
    exit();
}
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Inventory System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { 
            background-color: #f8fafc; 
            margin: 0; 
            padding: 30px; 
            color: #1e293b;
        }
        .container { 
            max-width: 1100px; 
            margin: auto; 
            background: white; 
            padding: 35px; 
            border-radius: 16px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); 
        }
        
        /* Header Style */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 20px;
        }
        h2 { margin: 0; color: #0f172a; font-size: 24px; font-weight: 700; }
        
        .btn-back { 
            background: #f1f5f9; 
            color: #475569; 
            padding: 10px 20px; 
            border-radius: 8px; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 600;
            transition: 0.2s;
        }
        .btn-back:hover { background: #e2e8f0; color: #1e293b; }

        /* Table Styling */
        .table-wrapper { overflow-x: auto; }
        table { 
            border-collapse: collapse; 
            width: 100%; 
            min-width: 800px;
        }
        th { 
            background-color: #f8fafc; 
            padding: 16px; 
            text-align: left; 
            font-size: 12px; 
            text-transform: uppercase; 
            letter-spacing: 0.05em; 
            color: #64748b;
            border-bottom: 2px solid #f1f5f9;
        }
        td { 
            padding: 16px; 
            border-bottom: 1px solid #f1f5f9; 
            font-size: 14px; 
        }
        tr:hover { background-color: #fdfdfd; }

        /* Status Badge */
        .badge { 
            padding: 6px 12px; 
            border-radius: 9999px; 
            font-size: 11px; 
            font-weight: 700; 
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .badge-masuk { background-color: #dcfce7; color: #166534; }
        .badge-keluar { background-color: #fee2e2; color: #991b1b; }
        
        /* Typography */
        .text-muted { color: #94a3b8; font-size: 12px; }
        .item-name { font-weight: 600; color: #334155; }
        .jumlah-val { font-weight: 700; font-family: monospace; font-size: 16px; }
    </style>
</head>
<body>

    <div class="container">
        <div class="page-header">
            <h2>Riwayat Transaksi Barang</h2>
            <a href="index.php" class="btn-back">← Kembali ke Dashboard</a>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th width="50">No</th>
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
                    // Query JOIN untuk mengambil nama barang
                    $query = mysqli_query($koneksi, "SELECT riwayat.*, barang.nama_barang 
                                                     FROM riwayat 
                                                     JOIN barang ON riwayat.id_barang = barang.id_barang 
                                                     ORDER BY riwayat.tanggal DESC");
                    
                    while($r = mysqli_fetch_array($query)){
                        $is_masuk = ($r['jenis_transaksi'] == 'masuk');
                        $badge_class = $is_masuk ? 'badge-masuk' : 'badge-keluar';
                        $simbol = $is_masuk ? '↓' : '↑';
                        ?>
                        <tr>
                            <td><span class="text-muted"><?php echo $no++; ?></span></td>
                            <td>
                                <div><?php echo date('d M Y', strtotime($r['tanggal'])); ?></div>
                                <div class="text-muted"><?php echo date('H:i', strtotime($r['tanggal'])); ?> WIB</div>
                            </td>
                            <td><span class="item-name"><?php echo $r['nama_barang']; ?></span></td>
                            <td>
                                <span class="badge <?php echo $badge_class; ?>">
                                    <?php echo $simbol . ' ' . strtoupper($r['jenis_transaksi']); ?>
                                </span>
                            </td>
                            <td><span class="jumlah-val"><?php echo $r['jumlah']; ?></span></td>
                            <td><i style="color: #64748b;"><?php echo !empty($r['keterangan']) ? $r['keterangan'] : '-'; ?></i></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>