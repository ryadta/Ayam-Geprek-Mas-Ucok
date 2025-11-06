<?php
session_start();

require_once '../config/database.php';
require_once '../models/Penjualan.php';

class RekkapController {
    private $penjualan;
    
    public function __construct($db) {
        $this->penjualan = new Penjualan($db);
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public function getReport($type, $month = null, $year = null) {
        if ($type === 'harian') {
            return [
                'data' => $this->penjualan->getHarianReport(),
                'total' => $this->penjualan->getTotalHarian()
            ];
        } elseif ($type === 'bulanan') {
            return [
                'data' => $this->penjualan->getBulananReport($month, $year),
                'total' => $this->penjualan->getTotalBulanan($month, $year)
            ];
        } elseif ($type === 'tahunan') {
            return [
                'data' => $this->penjualan->getTahunanReport($year),
                'total' => $this->penjualan->getTotalTahunan($year)
            ];
        }
    }
}
?>
