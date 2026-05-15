<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockMaster | Premium Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #4361ee;
            --accent: #4cc9f0;
            --text-dark: #1e293b;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(at 0% 0%, rgba(67, 97, 238, 0.15) 0px, transparent 50%),
                        radial-gradient(at 100% 100%, rgba(76, 201, 240, 0.15) 0px, transparent 50%),
                        #f8fafe;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            filter: blur(80px);
            z-index: -1;
            border-radius: 50%;
        }
        .shape-1 { width: 300px; height: 300px; background: var(--primary); top: -100px; left: -100px; opacity: 0.2; }
        .shape-2 { width: 400px; height: 400px; background: var(--accent); bottom: -150px; right: -100px; opacity: 0.2; }

        .login-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 50px 40px;
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 0.8s ease-out;
            /* Tambahan agar card tetap rapi */
            box-sizing: border-box;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-logo {
            width: 65px;
            height: 65px;
            background: var(--primary);
            color: white;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 25px;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }

        h2 { color: var(--text-dark); font-weight: 800; margin-bottom: 10px; font-size: 26px; }
        p.subtitle { color: #64748b; font-size: 14px; margin-bottom: 35px; }

        .input-group {
            text-align: left;
            margin-bottom: 20px;
            position: relative;
        }

        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
            margin-left: 5px;
        }

        .input-group i {
            position: absolute;
            left: 18px;
            top: 40px;
            color: #94a3b8;
            font-size: 16px;
            z-index: 1;
        }

        .input-group input {
            width: 100%;
            padding: 14px 20px 14px 50px;
            border-radius: 15px;
            border: 1.5px solid #e2e8f0;
            background: white;
            font-size: 15px;
            transition: all 0.3s;
            color: var(--text-dark);
            /* PERBAIKAN UTAMA: Agar padding tidak menambah lebar elemen */
            box-sizing: border-box;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2);
            box-sizing: border-box;
        }

        .btn-login:hover {
            background: #3651d1;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
        }

        .alert {
            background: #fee2e2;
            color: #ef4444;
            padding: 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="login-card">
        <div class="brand-logo">
            <i class="fas fa-shield-halved"></i>
        </div>
        
        <h2>Selamat Datang</h2>
        <p class="subtitle">Silakan masuk ke sistem inventaris</p>

        <?php 
        if(isset($_GET['pesan'])){
            if($_GET['pesan'] == "gagal"){
                echo "<div class='alert'><i class='fas fa-circle-exclamation'></i> Login Gagal! Cek kembali data Anda.</div>";
            }else if($_GET['pesan'] == "logout"){
                echo "<div class='alert' style='background:#dcfce7; color:#22c55e;'><i class='fas fa-circle-check'></i> Berhasil logout.</div>";
            }else if($_GET['pesan'] == "belum_login"){
                echo "<div class='alert' style='background:#fef9c3; color:#a16207;'><i class='fas fa-triangle-exclamation'></i> Silakan login terlebih dahulu.</div>";
            }
        }
        ?>

        <form action="cek_login.php" method="post">
            <div class="input-group">
                <label>Username</label>
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-login">
                Masuk Sekarang <i class="fas fa-arrow-right" style="margin-left:8px;"></i>
            </button>
        </form>

        <p style="margin-top: 30px; font-size: 12px; color: #94a3b8;">
            &copy; 2026 <b>StockMaster v2.0</b> - Enterprise Edition
        </p>
    </div>

</body>
</html>