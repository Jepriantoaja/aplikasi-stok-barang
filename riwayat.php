<?php 
session_start();
// Cek status login
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
    <title>Transaction History | Stock Master</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4361ee;
            --success: #2ec4b6;
            --danger: #e71d36;
            --bg: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            margin: 0;
            padding: 40px 20px;
        }

        .container { max-width: 1000px; margin: 0 auto; }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-weight: 800;
            font-size: 28px;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .btn-back {
            text-decoration: none;
            background: white;
            color: var(--text-main);
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            transition: 0.3s;
            border: 1px solid #e2e8f0;
        }

        .btn-back:hover { background: #f1f5f9; transform: translateX(-5px); }

        /* Style untuk Tombol Export */
        .export-actions {
            display: flex;
            gap: 12px;
            margin-bottom: 25px;
        }

        .btn-export {
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        .btn-pdf { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
        .btn-pdf:hover { background: #fecaca; transform: translateY(-2px); }

        .btn-excel { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .btn-excel:hover { background: #bbf7d0; transform: translateY(-2px); }

        .table-card {
            background: white;
            border-radius: 24px;
            padding: 10px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05), 0 10px 10px -5px rgba(0,0,0,0.02);
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }

        th {
            text-align: left;
            padding: 20px;
            background: #f8fafc;
            color: var(--text-muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            border-bottom: 1px solid #f1f5f9;
        }

        td {
            padding: 20px;
            border-bottom: 1px solid #f8fafc;
            font-size: 14px;
            color: #334155;
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }
        .timestamp { font-size: 12px; color: var(--text-muted); display: block; margin-top: 4px; }
        .item-name { font-weight: 700; color: var(--text-main); }
        .amount { font-family: 'Courier New', monospace; font-weight: 700; font-size: 16px; }

        .badge {
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
        }

        .badge-in { background: #dcfce7; color: #15803d; }
        .badge-out { background: #fee2e2; color: #b91c1c; }

        .note-box {
            font-style: italic;
            color: var(--text-muted);
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .empty-state { padding: 60px; text-align: center; color: var(--text-muted); }
    </style>
</head>
<body>

    <div class="container">
        <div class="page-header">
            <div>
                <h1>Riwayat Transaksi</h1>
                <p style="color: var(--text-muted); margin-top: 5px;">Laporan aktivitas keluar masuk barang secara real-time</p>
            </div>
            <a href="index.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="export-actions">
            <a href="cetak_pdf.php" target="_blank" class="btn-export btn-pdf">
                <i class="fas fa-file-pdf"></i> Cetak PDF / Print
            </a>
            <a href="cetak_excel.php" class="btn-export btn-excel">
                <i class="fas fa-file-excel"></i> Export ke Excel
            </a>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Waktu & Tanggal</th>
                        <th width="25%">Nama Barang</th>
                        <th width="15%">Tipe</th>
                        <th width="10%">Jumlah</th>
                        <th width="25%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if (!$koneksi) {
                        echo "<tr><td colspan='6' class='empty-state'>Koneksi database gagal.</td></tr>";
                    } else {
                        // Query JOIN untuk mendapatkan nama_barang dari tabel barang
                        $query = "SELECT riwayat.*, barang.nama_barang 
                                  FROM riwayat 
                                  LEFT JOIN barang ON riwayat.id_barang = barang.id_barang 
                                  ORDER BY riwayat.id_riwayat DESC";
                        
                        $result = mysqli_query($koneksi, $query);
                        
                        if($result && mysqli_num_rows($result) > 0) {
                            while($d = mysqli_fetch_assoc($result)){
                                // PERBAIKAN: Membaca kolom jenis_transaksi sesuai database kamu
                                $jenis_raw = $d['jenis_transaksi'] ?? $d['jenis'] ?? 'keluar'; 
                                $waktu_raw = $d['tanggal'] ?? date('Y-m-d H:i:s');
                                
                                $is_masuk = (strtolower($jenis_raw) == 'masuk');
                                $nama_barang = $d['nama_barang'] ?? 'Barang Telah Dihapus';
                    ?>
                        <tr>
                            <td><span style="color: #cbd5e1; font-weight: 600;"><?php echo str_pad($no++, 2, "0", STR_PAD_LEFT); ?></span></td>
                            <td>
                                <span style="font-weight: 600;"><?php echo date('d M Y', strtotime($waktu_raw)); ?></span>
                                <span class="timestamp"><?php echo date('H:i', strtotime($waktu_raw)); ?> WIB</span>
                            </td>
                            <td><span class="item-name"><?php echo strtoupper($nama_barang); ?></span></td>
                            <td>
                                <?php if($is_masuk): ?>
                                    <span class="badge badge-in"><i class="fas fa-arrow-down"></i> Masuk</span>
                                <?php else: ?>
                                    <span class="badge badge-out"><i class="fas fa-arrow-up"></i> Keluar</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="amount" style="color: <?php echo $is_masuk ? '#15803d' : '#b91c1c'; ?>">
                                    <?php echo $is_masuk ? '+' : '-'; ?> <?php echo abs($d['jumlah'] ?? 0); ?>
                                </span>
                            </td>
                            <td><div class="note-box"><?php echo $d['keterangan'] ?? '-'; ?></div></td>
                        </tr>
                    <?php 
                            } 
                        } else {
                            echo "<tr><td colspan='6' class='empty-state'>Belum ada riwayat transaksi tercatat.</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>