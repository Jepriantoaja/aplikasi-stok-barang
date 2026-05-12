<?php 
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    header("location:login.php?pesan=belum_login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Inventaris Baru | StockMaster</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #4361ee;
            --success: #22c55e;
            --bg: #f8fafe;
            --text-dark: #1e293b;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Decorative Background Shapes */
        .bg-shape {
            position: absolute;
            z-index: -1;
            filter: blur(100px);
            opacity: 0.15;
            border-radius: 50%;
        }
        .shape-1 { width: 300px; height: 300px; background: var(--primary); top: 10%; left: 15%; }
        .shape-2 { width: 250px; height: 250px; background: var(--success); bottom: 10%; right: 15%; }

        .form-card {
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.04);
            width: 100%;
            max-width: 500px;
            border: 1px solid rgba(0,0,0,0.02);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-header { text-align: center; margin-bottom: 35px; }
        .icon-circle {
            width: 60px; height: 60px; background: #f0f4ff; color: var(--primary);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 24px; margin: 0 auto 15px;
        }
        .form-header h2 { margin: 0; color: var(--text-dark); font-weight: 800; font-size: 22px; }
        .form-header p { color: #64748b; font-size: 14px; margin-top: 5px; }

        .input-box { margin-bottom: 22px; }
        .input-box label {
            display: block; font-size: 13px; font-weight: 700; color: #475569;
            margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .input-field {
            position: relative;
        }
        .input-field i {
            position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; transition: 0.3s;
        }
        .input-field input {
            width: 100%; padding: 14px 15px 14px 45px; border-radius: 12px;
            border: 2px solid #e2e8f0; font-size: 15px; font-family: inherit;
            transition: all 0.3s; box-sizing: border-box;
        }
        .input-field input:focus {
            outline: none; border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }
        .input-field input:focus + i { color: var(--primary); }

        .btn-group { display: flex; flex-direction: column; gap: 12px; margin-top: 30px; }
        .btn-submit {
            padding: 16px; border: none; border-radius: 12px; background: var(--primary);
            color: white; font-weight: 700; font-size: 15px; cursor: pointer;
            transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(67, 97, 238, 0.25); }
        
        .btn-back {
            text-align: center; text-decoration: none; color: #64748b;
            font-size: 14px; font-weight: 600; transition: 0.3s;
        }
        .btn-back:hover { color: var(--text-dark); }
    </style>
</head>
<body>

    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <div class="form-card">
        <div class="form-header">
            <div class="icon-circle">
                <i class="fas fa-box-open"></i>
            </div>
            <h2>Tambah Barang</h2>
            <p>Masukkan detail inventaris baru ke sistem</p>
        </div>

        <form action="tambah_aksi.php" method="post">
            <div class="input-box">
                <label>Kode Barang</label>
                <div class="input-field">
                    <i class="fas fa-tag"></i>
                    <input type="text" name="kode_barang" placeholder="Contoh: BRG-001" required>
                </div>
            </div>

            <div class="input-box">
                <label>Nama Barang</label>
                <div class="input-field">
                    <i class="fas fa-archive"></i>
                    <input type="text" name="nama_barang" placeholder="Masukkan nama barang" required>
                </div>
            </div>

            <div class="input-box">
                <label>Stok Awal</label>
                <div class="input-field">
                    <i class="fas fa-layer-group"></i>
                    <input type="number" name="stok" placeholder="0" min="0" required>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-submit">
                    Simpan Data Barang <i class="fas fa-save"></i>
                </button>
                <a href="index.php" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </form>
    </div>

</body>
</html>