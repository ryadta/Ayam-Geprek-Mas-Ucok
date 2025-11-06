<?php
session_start();

require_once '../config/database.php';
require_once '../models/Penjualan.php';

class DashboardController {
    private $penjualan;
    
    public function __construct($db) {
        $this->penjualan = new Penjualan($db);
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public function getTodayStats() {
        $total = $this->penjualan->getTotalHarian();
        $report = $this->penjualan->getHarianReport();
        return [
            'total' => $total,
            'items' => $report,
            'count' => count($report)
        ];
    }
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}
?>
