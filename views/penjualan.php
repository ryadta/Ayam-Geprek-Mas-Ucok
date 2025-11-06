<?php
require_once '../config/database.php';
require_once '../controllers/PenjualanController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$controller = new PenjualanController($conn);
$menu = $controller->getMenu();
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Penjualan - Ayam Geprek Mas Ucok</title>
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
        }
        
        @media (min-width: 768px) {
            .card {
                margin-bottom: 20px;
            }
        }
        
        /* Responsive table with horizontal scroll on mobile, full width on desktop */
        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
        }
        
        .table {
            margin-bottom: 0;
            font-size: clamp(12px, 3vw, 14px);
        }
        
        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .table tbody tr:hover {
            background-color: #f9f9f9;
        }
        
        .input-quantity {
            text-align: center;
            padding: 8px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            width: 100%;
            font-size: clamp(12px, 3vw, 14px);
        }
        
        .input-quantity:focus {
            border-color: #667eea;
            box-shadow: none;
        }
        
        .btn-submit, .btn-back {
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 15px;
            width: 100%;
            font-size: clamp(13px, 3vw, 14px);
        }
        
        @media (min-width: 768px) {
            .btn-submit, .btn-back {
                padding: 12px 30px;
                margin-top: 20px;
            }
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }
        
        .btn-submit:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
        }
        
        .btn-back {
            background: #6c757d;
            border: none;
            color: white;
        }
        
        .btn-back:hover {
            background: #5a6268;
            color: white;
        }
        
        .alert {
            border-radius: 10px;
            font-size: clamp(12px, 3vw, 14px);
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
                <h2>Input Penjualan</h2>
                
                <?php if (!empty($message)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <form method="POST" action="../controllers/PenjualanController.php" id="penjualanForm">
                                <input type="hidden" name="action" value="save_penjualan">
                                
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Menu</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($menu as $item): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $item['nama']; ?></td>
                                                <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                                                <td>
                                                    <input type="hidden" name="menu_<?php echo $item['id']; ?>" value="<?php echo $item['nama']; ?>">
                                                    <input type="hidden" name="harga_<?php echo $item['id']; ?>" value="<?php echo $item['harga']; ?>">
                                                    <input type="number" name="jumlah_<?php echo $item['id']; ?>" class="input-quantity jumlah-input" value="0" min="0" data-harga="<?php echo $item['harga']; ?>">
                                                </td>
                                                <td class="total-cell" data-id="<?php echo $item['id']; ?>">Rp 0</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Responsive button layout - stack on mobile, side-by-side on desktop -->
                <div class="row mt-3">
                    <div class="col-12 col-md-6 order-2 order-md-1">
                        <a href="dashboard.php" class="btn-back">Kembali ke Dashboard</a>
                    </div>
                    <div class="col-12 col-md-6 order-1 order-md-2 mb-2 mb-md-0">
                        <button type="submit" form="penjualanForm" class="btn-submit">Simpan Penjualan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.jumlah-input').forEach(input => {
            input.addEventListener('change', function() {
                updateTotal(this);
            });
            input.addEventListener('keyup', function() {
                updateTotal(this);
            });
        });

        function updateTotal(input) {
            const row = input.closest('tr');
            const harga = parseInt(input.dataset.harga);
            const jumlah = parseInt(input.value) || 0;
            const total = harga * jumlah;
            const totalCell = row.querySelector('.total-cell');
            totalCell.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        document.getElementById('penjualanForm').addEventListener('submit', function(e) {
            const hasData = Array.from(document.querySelectorAll('.jumlah-input')).some(input => parseInt(input.value) > 0);
            if (!hasData) {
                e.preventDefault();
                alert('Silakan isi minimal satu item penjualan');
            }
        });
    </script>
</body>
</html>
