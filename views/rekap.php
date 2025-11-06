<?php
require_once '../config/database.php';
require_once '../controllers/RekkapController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$controller = new RekkapController($conn);

$type = isset($_GET['type']) ? $_GET['type'] : 'harian';
$month = isset($_GET['month']) ? $_GET['month'] : date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

if ($type === 'harian') {
    $report = $controller->getReport('harian');
    $title = 'Rekap Penjualan Harian - ' . date('d/m/Y');
} elseif ($type === 'bulanan') {
    $report = $controller->getReport('bulanan', $month, $year);
    $monthName = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $title = 'Rekap Penjualan Bulanan - ' . $monthName[intval($month)-1] . ' ' . $year;
} else {
    $report = $controller->getReport('tahunan', null, $year);
    $title = 'Rekap Penjualan Tahunan - ' . $year;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Penjualan - Ayam Geprek Mas Ucok</title>
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
        
        /* Responsive filter section with stacked inputs on mobile */
        .filter-section {
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        @media (min-width: 768px) {
            .filter-section {
                padding: 20px;
                margin-bottom: 20px;
            }
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
        
        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
        }
        
        /* Responsive summary box */
        .summary-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 15px;
            border-radius: 10px;
            margin-top: 15px;
            text-align: center;
        }
        
        @media (min-width: 768px) {
            .summary-box {
                padding: 20px;
                margin-top: 20px;
            }
        }
        
        .summary-box h5 {
            margin-bottom: 10px;
            opacity: 0.9;
            font-size: clamp(12px, 3vw, 14px);
        }
        
        .summary-box h2 {
            font-size: clamp(20px, 5vw, 32px);
            font-weight: bold;
        }
        
        .btn-filter, .btn-export, .btn-back {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-size: clamp(13px, 3vw, 14px);
            padding: 8px 12px;
        }
        
        @media (min-width: 768px) {
            .btn-filter, .btn-export, .btn-back {
                padding: 10px 20px;
            }
        }
        
        .btn-filter:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
        }
        
        .btn-export {
            background: #28a745;
        }
        
        .btn-export:hover {
            background: #218838;
            color: white;
        }
        
        .btn-back {
            background: #6c757d;
        }
        
        .btn-back:hover {
            background: #5a6268;
            color: white;
        }
        
        .form-select {
            border: 2px solid #e0e0e0;
            font-size: clamp(12px, 3vw, 14px);
        }
        
        .form-select:focus {
            border-color: #667eea;
            box-shadow: none;
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
                <h2><?php echo $title; ?></h2>
            </div>
        </div>

        <!-- Responsive filter with stacked inputs on mobile -->
        <div class="filter-section">
            <form method="GET" class="row g-2">
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label" style="font-size: clamp(12px, 3vw, 14px);">Tipe Laporan</label>
                    <select name="type" class="form-select" onchange="this.form.submit()">
                        <option value="harian" <?php echo $type === 'harian' ? 'selected' : ''; ?>>Harian</option>
                        <option value="bulanan" <?php echo $type === 'bulanan' ? 'selected' : ''; ?>>Bulanan</option>
                        <option value="tahunan" <?php echo $type === 'tahunan' ? 'selected' : ''; ?>>Tahunan</option>
                    </select>
                </div>

                <?php if ($type === 'bulanan'): ?>
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label" style="font-size: clamp(12px, 3vw, 14px);">Bulan</label>
                        <select name="month" class="form-select" onchange="this.form.submit()">
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>" <?php echo $month == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : ''; ?>>
                                    <?php echo array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')[$i-1]; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <?php if ($type === 'bulanan' || $type === 'tahunan'): ?>
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label" style="font-size: clamp(12px, 3vw, 14px);">Tahun</label>
                        <select name="year" class="form-select" onchange="this.form.submit()">
                            <?php for ($i = date('Y'); $i >= date('Y') - 5; $i--): ?>
                                <option value="<?php echo $i; ?>" <?php echo $year == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="col-12 col-sm-6 col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-export w-100" onclick="exportToExcel()" style="height: fit-content;">Export ke Excel</button>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($report['data']) > 0): ?>
                                <?php $no = 1; foreach ($report['data'] as $item): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $item['menu']; ?></td>
                                        <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                                        <td><?php echo $item['total_jumlah']; ?> pcs</td>
                                        <td>Rp <?php echo number_format($item['total_penjualan'], 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Tidak ada data penjualan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="summary-box">
            <h5>Total Penjualan</h5>
            <h2>Rp <?php echo number_format($report['total'], 0, ',', '.'); ?></h2>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <a href="dashboard.php" class="btn btn-back w-100">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function exportToExcel() {
            const table = document.querySelector('table');
            let html = '<table border="1">';
            
            // Add header
            html += '<tr style="background-color: #667eea; color: white;">';
            table.querySelectorAll('thead th').forEach(th => {
                html += '<td>' + th.textContent + '</td>';
            });
            html += '</tr>';
            
            // Add body
            table.querySelectorAll('tbody tr').forEach(tr => {
                html += '<tr>';
                tr.querySelectorAll('td').forEach(td => {
                    html += '<td>' + td.textContent + '</td>';
                });
                html += '</tr>';
            });
            
            html += '</table>';
            
            // Create Excel file
            const element = document.createElement('a');
            element.setAttribute('href', 'data:application/vnd.ms-excel,' + encodeURIComponent(html));
            element.setAttribute('download', 'rekap_penjualan_<?php echo date('Y-m-d'); ?>.xls');
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        }
    </script>
</body>
</html>
