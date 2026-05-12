<?php 
session_start();
include 'koneksi.php';

if(isset($_POST['login'])){
    $user = mysqli_real_escape_string($koneksi, $_POST['username']);
    $pass = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$user' AND password='$pass'");
    
    if(mysqli_num_rows($query) > 0){
        $data = mysqli_fetch_array($query);
        $_SESSION['status'] = "login";
        $_SESSION['nama']   = $data['nama_lengkap'];
        header("location:index.php");
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory System</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #0275d8 0%, #025aa5 100%);
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }
        h2 { 
            text-align: center; 
            color: #2c3e50; 
            margin-bottom: 5px; 
            font-weight: 800; 
            font-size: 28px;
            letter-spacing: -0.5px;
        }
        p.subtitle { 
            text-align: center; 
            color: #7f8c8d; 
            margin-bottom: 35px; 
            font-size: 14px; 
        }
        
        .input-group { margin-bottom: 25px; }
        .input-group label { display: block; margin-bottom: 8px; color: #34495e; font-weight: 600; font-size: 14px; }
        .input-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #dcdde1;
            border-radius: 8px;
            outline: none;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }
        .input-group input:focus { 
            border-color: #0275d8; 
            background-color: #fff;
            box-shadow: 0 0 10px rgba(2, 117, 216, 0.15); 
        }
        
        button {
            width: 100%;
            padding: 14px;
            background: #0275d8;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(2, 117, 216, 0.2);
        }
        button:hover { 
            background: #025aa5; 
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(2, 117, 216, 0.3);
        }
        button:active { transform: translateY(0); }
        
        .error-msg {
            background: #fdf2f2;
            color: #c81e1e;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
            font-size: 14px;
            border-left: 4px solid #c81e1e;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Selamat Datang</h2>
        <p class="subtitle">Silakan masuk untuk mengelola stok barang</p>
        
        <?php if(isset($error)) : ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username admin" required autocomplete="off">
            </div>
            
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            
            <button type="submit" name="login">MASUK SEKARANG</button>
        </form>
    </div>

</body>
</html>