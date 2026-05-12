<?php 
session_start();
include 'koneksi.php';

if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$user' AND password='$pass'");
    
    if(mysqli_num_rows($query) > 0){
        $data = mysqli_fetch_array($query);
        $_SESSION['status'] = "login";
        $_SESSION['nama']   = $data['nama_lengkap'];
        header("location:index.php");
    } else {
        $error = "Username atau Password Salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Aplikasi Stok</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); width: 300px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #0275d8; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="login-box">
        <h3>Login Sistem</h3>
        <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Masuk</button>
        </form>
    </div>
</body>
</html>