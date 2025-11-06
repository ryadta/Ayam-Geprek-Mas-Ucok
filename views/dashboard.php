<?php
require_once '../config/database.php';
require_once '../controllers/DashboardController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$controller = new DashboardController($conn);
$stats = $controller->getTodayStats();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ayam Geprek Mas Ucok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Responsive navbar with mobile-optimized spacing */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 10px 15px;
        }
        
        @media (min-width: 768px) {
            .navbar {
                padding: 15px;
            }
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: clamp(16px, 5vw, 20px);
        }
        
        .navbar-text {
            font-size: clamp(12px, 3vw, 14px);
        }
        
        .container-main {
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 0 15px;
        }
        
        @media (min-width: 768px) {
            .container-main {
                margin-top: 30px;
                margin-bottom: 30px;
                padding: 0;
            }
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            transition: transform 0.3s;
        }
        
        @media (min-width: 768px) {
            .card {
                margin-bottom: 20px;
            }
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        /* Responsive stat cards with mobile-first design */
        .stat-card {
            text-align: center;
            padding: 20px 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        @media (min-width: 768px) {
            .stat-card {
                padding: 30px;
            }
        }
        
        .stat-card h5 {
            font-size: clamp(12px, 3vw, 14px);
            opacity: 0.9;
            margin-bottom: 10px;
        }
        
        .stat-card h2 {
            font-size: clamp(20px, 5vw, 32px);
            font-weight: bold;
        }
        
        .menu-item {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        @media (min-width: 768px) {
            .menu-item {
                padding: 15px;
            }
        }
        
        .menu-item:last-child {
            border-bottom: none;
        }
        
        .menu-name {
            font-weight: 500;
            font-size: clamp(13px, 3vw, 15px);
            flex: 1;
            min-width: 150px;
        }
        
        .menu-count {
            background: #667eea;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: clamp(10px, 2.5vw, 12px);
            font-weight: bold;
            white-space: nowrap;
        }
        
        .btn-primary, .btn-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            font-size: clamp(13px, 3vw, 14px);
            padding: 10px 15px;
        }
        
        @media (min-width: 768px) {
            .btn-primary, .btn-info {
                padding: 12px 30px;
            }
        }
        
        .btn-primary:hover, .btn-info:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
        }
        
        h2 {
            font-size: clamp(20px, 5vw, 28px);
            margin-bottom: 15px;
        }
        
        @media (min-width: 768px) {
            h2 {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <span class="navbar-brand">Ayam Geprek Mas Ucok</span>
            <div class="ms-auto d-flex align-items-center gap-2">
                <span class="text-white navbar-text d-none d-sm-inline">Selamat datang, <strong><?php echo $_SESSION['username']; ?></strong></span>
                <form method="POST" action="../controllers/LoginController.php" style="display: inline;">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" class="btn btn-sm btn-light">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-main container-fluid">
        <div class="row">
            <div class="col-12">
                <h2>Dashboard</h2>
            </div>
        </div>

        <!-- Responsive stat cards - stack on mobile, 3 columns on desktop -->
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card stat-card">
                    <h5>Total Penjualan Hari Ini</h5>
                    <h2>Rp <?php echo number_format($stats['total'], 0, ',', '.'); ?></h2>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card stat-card">
                    <h5>Total Item Terjual</h5>
                    <h2><?php echo array_sum(array_column($stats['items'], 'total_jumlah')); ?></h2>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card stat-card">
                    <h5>Jenis Menu Terjual</h5>
                    <h2><?php echo $stats['count']; ?></h2>
                </div>
            </div>
        </div>

        <!-- Responsive layout - single column on mobile, split on desktop -->
        <div class="row mt-4">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0" style="font-size: clamp(16px, 4vw, 18px);">Penjualan Hari Ini</h5>
                    </div>
                    <div class="card-body p-0">
                        <?php if (count($stats['items']) > 0): ?>
                            <?php foreach ($stats['items'] as $item): ?>
                                <div class="menu-item">
                                    <div class="flex-grow-1">
                                        <div class="menu-name"><?php echo $item['menu']; ?></div>
                                        <small class="text-muted" style="font-size: clamp(11px, 2.5vw, 13px);">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></small>
                                    </div>
                                    <div class="menu-count"><?php echo $item['total_jumlah']; ?> pcs</div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center py-4">Belum ada data penjualan hari ini</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0" style="font-size: clamp(16px, 4vw, 18px);">Menu Aksi</h5>
                    </div>
                    <div class="card-body">
                        <a href="penjualan.php" class="btn btn-primary w-100 mb-2">Input Penjualan</a>
                        <a href="rekap.php" class="btn btn-info w-100">Lihat Rekap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
