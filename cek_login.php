<?php 
session_start();
include 'koneksi.php';


if (isset($_POST['username']) && isset($_POST['password'])) {
    
    
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Query ke tabel user
    $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $login = mysqli_query($koneksi, $query);
    
    if ($login) {
        $cek = mysqli_num_rows($login);

        if($cek > 0){
            $data = mysqli_fetch_assoc($login);
            $_SESSION['username'] = $username;
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['status'] = "login";
            
            // Redirect ke dashboard
            header("location:index.php");
            exit(); 
        } else {
            // Login gagal
            header("location:login.php?pesan=gagal");
            exit();
        }
    } else {
        
        die("Error pada query: " . mysqli_error($koneksi));
    }
} else {
    
    header("location:login.php");
    exit();
}
?>