<?php 
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    header("location:login.php?pesan=belum_login");
    exit();
}
include 'koneksi.php'; 

// Statistik Data
$total_barang = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang"));
$stok_limit = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang WHERE stok < 5"));

// Data Grafik
$label_grafik = [];
$data_grafik  = [];
$query_chart  = mysqli_query($koneksi, "SELECT nama_barang, stok FROM barang ORDER BY nama_barang ASC LIMIT 10");
while($row = mysqli_fetch_array($query_chart)){
    $label_grafik[] = $row['nama_barang'];
    $data_grafik[]  = $row['stok'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Stock System | Dashboard</title>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --bg: #f8fafe;
            --sidebar: #ffffff;
        }

        * { box-sizing: border-box; font-family: 'Inter', 'Segoe UI', system-ui; }
        body { background-color: var(--bg); margin: 0; display: flex; min-height: 100vh; }

        /* Sidebar Glassmorphism */
        .sidebar {
            width: 260px; background: var(--sidebar); border-right: 1px solid rgba(0,0,0,0.05);
            padding: 30px 20px; display: flex; flex-direction: column; position: fixed; height: 100vh;
        }
        .brand { font-size: 20px; font-weight: 800; color: var(--primary); margin-bottom: 40px; display: flex; align-items: center; gap: 10px; }
        .nav-link { 
            padding: 12px 15px; text-decoration: none; color: #64748b; border-radius: 10px;
            margin-bottom: 5px; display: flex; align-items: center; gap: 12px; transition: 0.3s;
        }
        .nav-link.active { background: var(--primary); color: white; box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3); }
        .nav-link:hover:not(.active) { background: #f1f5f9; color: var(--primary); }

        /* Main Content Area */
        .main { margin-left: 260px; width: calc(100% - 260px); padding: 30px 40px; }
        
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
        
        /* Tombol Profil yang bisa diklik */
        .profile-link { text-decoration: none; transition: transform 0.2s; }
        .profile-link:hover { transform: scale(1.05); }
        .user-pill { background: white; padding: 8px 20px; border-radius: 50px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 10px; cursor: pointer; }

        /* Premium Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 25px; margin-bottom: 35px; }
        .card-glass { 
            background: white; padding: 25px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.8);
            box-shadow: 0 10px 30px rgba(0,0,0,0.02); position: relative; overflow: hidden;
        }
        .card-glass h3 { font-size: 13px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin: 0; }
        .card-glass p { font-size: 32px; font-weight: 700; margin: 10px 0 0; color: #1e293b; }
        .card-icon { position: absolute; right: -10px; bottom: -10px; font-size: 80px; opacity: 0.05; transform: rotate(-15deg); }

        /* Action Buttons */
        .action-flex { display: flex; gap: 15px; margin-bottom: 30px; }
        .btn-premium { 
            padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600;
            display: flex; align-items: center; gap: 8px; transition: 0.3s; font-size: 14px;
        }
        .btn-primary-p { background: var(--primary); color: white; box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2); }
        .btn-primary-p:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4); }

        /* Table & Chart Container */
        .content-card { background: white; padding: 30px; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); margin-bottom: 30px; }
        
        table { width: 100%; border-spacing: 0 10px; border-collapse: separate; }
        th { color: #64748b; font-weight: 600; font-size: 13px; padding: 15px; border-bottom: 1px solid #f1f5f9; }
        td { background: white; padding: 18px 15px; border-top: 1px solid #f8f9fa; border-bottom: 1px solid #f8f9fa; }
        td:first-child { border-left: 1px solid #f8f9fa; border-radius: 15px 0 0 15px; }
        td:last-child { border-right: 1px solid #f8f9fa; border-radius: 0 15px 15px 0; }

        .badge-premium { padding: 6px 14px; border-radius: 8px; font-weight: 700; font-size: 12px; }
        .bg-low { background: #fee2e2; color: #ef4444; }
        .bg-safe { background: #f0fdf4; color: #22c55e; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="brand">
            <i class="fas fa-box-open"></i>
            <span>STOCK MASTER</span>
        </div>
        <nav>
            <a href="index.php" class="nav-link active"><i class="fas fa-home"></i> Dashboard</a>
            <a href="tambah.php" class="nav-link"><i class="fas fa-plus-circle"></i> Tambah Barang</a>
            <a href="transaksi.php" class="nav-link"><i class="fas fa-exchange-alt"></i> Transaksi</a>
            <a href="riwayat.php" class="nav-link"><i class="fas fa-history"></i> Riwayat</a>
        </nav>
        <div style="margin-top: auto;">
            <a href="logout.php" class="nav-link" style="color: #ef4444;"><i class="fas fa-sign-out-alt"></i> Keluar</a>
        </div>
    </aside>

    <main class="main">
        <div class="top-bar">
            <h1 style="font-size: 24px; font-weight: 800; color: #1e293b;">Overview System</h1>
            
            <a href="logout.php" class="profile-link" title="Klik untuk Logout">
                <div class="user-pill">
                    <i class="fas fa-user-circle" style="color: var(--primary);"></i>
                    <span style="font-weight: 600; color: #1e293b;"><?php echo $_SESSION['nama']; ?></span>
                </div>
            </a>
        </div>

        <div class="stats-grid">
            <div class="card-glass">
                <h3>Total Jenis Barang</h3>
                <p><?php echo $total_barang; ?></p>
                <i class="fas fa-cubes card-icon"></i>
            </div>
            <div class="card-glass" style="border-bottom: 4px solid var(--danger);">
                <h3>Kritis (Stok < 5)</h3>
                <p style="color: var(--danger);"><?php echo $stok_limit; ?></p>
                <i class="fas fa-exclamation-triangle card-icon"></i>
            </div>
        </div>

        <div class="content-card">
            <h3 style="margin: 0 0 25px 0; font-size: 18px; color: #1e293b;">Analisis Visual Stok</h3>
            <div style="height: 300px;">
                <canvas id="stokChart"></canvas>
            </div>
        </div>

        <div class="content-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h3 style="margin: 0; font-size: 18px; color: #1e293b;">Inventaris Barang</h3>
                <div class="action-flex" style="margin:0;">
                    <a href="tambah.php" class="btn-premium btn-primary-p">+ Baru</a>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>KODE</th>
                        <th>NAMA BARANG</th>
                        <th>STATUS STOK</th>
                        <th style="text-align: center;">KONTROL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $data = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");
                    while($d = mysqli_fetch_array($data)){
                        $is_low = ($d['stok'] < 5);
                        ?>
                        <tr>
                            <td width="50"><?php echo $no++; ?></td>
                            <td style="font-weight: 600; color: var(--primary);"><?php echo $d['kode_barang']; ?></td>
                            <td style="font-weight: 700; color: #1e293b;"><?php echo $d['nama_barang']; ?></td>
                            <td>
                                <span class="badge-premium <?php echo $is_low ? 'bg-low' : 'bg-safe'; ?>">
                                    <i class="fas <?php echo $is_low ? 'fa-arrow-down' : 'fa-check-circle'; ?>"></i> 
                                    <?php echo $d['stok']; ?> Unit
                                </span>
                            </td>
                            <td align="center">
                                <a href="edit.php?id=<?php echo $d['id_barang']; ?>" style="color: #f59e0b; margin-right: 15px;"><i class="fas fa-edit"></i></a>
                                <a href="hapus.php?id=<?php echo $d['id_barang']; ?>" style="color: #ef4444;" onclick="return confirm('Hapus data?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        const ctx = document.getElementById('stokChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(67, 97, 238, 0.8)');
        gradient.addColorStop(1, 'rgba(67, 97, 238, 0.1)');

        new Chart(ctx, {
            type: 'line', 
            data: {
                labels: <?php echo json_encode($label_grafik); ?>,
                datasets: [{
                    label: 'Stok',
                    data: <?php echo json_encode($data_grafik); ?>,
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: '#4361ee',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4361ee',
                    pointRadius: 6,
                    tension: 0.4
                }]
                
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>