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
    <title>Transaction Engine | Stock Master</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --bg-gradient: linear-gradient(135deg, #f8fafe 0%, #e2e8f0 100%);
            --glass: rgba(255, 255, 255, 0.9);
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg-gradient); 
            margin: 0; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh;
        }

        .container { width: 100%; max-width: 550px; padding: 20px; }

        /* Premium Form Card */
        .card-transaction {
            background: var(--glass);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 45px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.6);
            position: relative;
        }

        .header { text-align: center; margin-bottom: 35px; }
        .header h2 { font-weight: 800; color: #1e293b; margin: 0; font-size: 26px; }
        .header p { color: #64748b; font-size: 14px; margin-top: 8px; }

        .input-group { margin-bottom: 24px; }
        .input-group label { 
            display: block; 
            font-weight: 600; 
            color: #475569; 
            margin-bottom: 10px; 
            font-size: 13px; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Form Controls */
        .form-control {
            width: 100%;
            padding: 14px 18px;
            border-radius: 14px;
            border: 2px solid #e2e8f0;
            background: white;
            font-size: 15px;
            color: #1e293b;
            transition: 0.3s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        select.form-control { cursor: pointer; }

        textarea.form-control { resize: none; height: 100px; }

        /* Premium Button */
        .btn-process {
            width: 100%;
            padding: 16px;
            border-radius: 16px;
            border: none;
            background: var(--primary);
            color: white;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: 0.3s;
            box-shadow: 0 10px 20px -5px rgba(67, 97, 238, 0.4);
        }

        .btn-process:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(67, 97, 238, 0.5);
        }

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 25px;
            text-decoration: none;
            color: #94a3b8;
            font-size: 14px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-back:hover { color: var(--primary); }

        /* Floating Icon Background */
        .bg-icon {
            position: absolute;
            top: -20px;
            right: -20px;
            font-size: 80px;
            color: var(--primary);
            opacity: 0.05;
            transform: rotate(15deg);
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card-transaction">
            <i class="fas fa-exchange-alt bg-icon"></i>
            
            <div class="header">
                <h2>Catat Transaksi</h2>
                <p>Kelola arus masuk dan keluar barang inventaris</p>
            </div>

            <form action="transaksi_aksi.php" method="post">
                <div class="input-group">
                    <label><i class="fas fa-search"></i> Pilih Barang</label>
                    <select name="id_barang" class="form-control" required>
                        <option value="">-- Cari Nama atau Kode Barang --</option>
                        <?php 
                        $data = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");
                        while($d = mysqli_fetch_array($data)){
                            echo "<option value='".$d['id_barang']."'>".$d['kode_barang']." - ".$d['nama_barang']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="input-group">
                    <label><i class="fas fa-sort-amount-up-alt"></i> Jenis Transaksi</label>
                    <select name="jenis" class="form-control" required>
                        <option value="masuk">Barang Masuk (+)</option>
                        <option value="keluar">Barang Keluar (-)</option>
                    </select>
                </div>

                <div class="input-group">
                    <label><i class="fas fa-calculator"></i> Jumlah Unit</label>
                    <input type="number" name="jumlah" class="form-control" placeholder="0" min="1" required>
                </div>

                <div class="input-group">
                    <label><i class="fas fa-sticky-note"></i> Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" placeholder="Contoh: Pengadaan stok baru atau pesanan pelanggan..."></textarea>
                </div>

                <button type="submit" class="btn-process">
                    PROSES TRANSAKSI <i class="fas fa-arrow-right"></i>
                </button>

                <a href="index.php" class="btn-back">
                    <i class="fas fa-chevron-left"></i> Kembali ke Dashboard
                </a>
            </form>
        </div>
    </div>

</body>
</html>