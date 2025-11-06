<?php
session_start();

require_once '../config/database.php';
require_once '../models/Penjualan.php';

class PenjualanController {
    private $penjualan;
    
    public function __construct($db) {
        $this->penjualan = new Penjualan($db);
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public function getMenu() {
        return $this->penjualan->getMenu();
    }
    
    public function savePenjualan($data) {
        $this->penjualan->savePenjualan($data);
        return ['success' => true, 'message' => 'Penjualan berhasil disimpan'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new PenjualanController($conn);
    
    if (!$controller->isLoggedIn()) {
        header('Location: ../index.php');
        exit;
    }
    
    if ($_POST['action'] === 'save_penjualan') {
        $data = [];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'jumlah_') === 0) {
                $menu_id = str_replace('jumlah_', '', $key);
                $menu_name = $_POST['menu_' . $menu_id];
                $harga = $_POST['harga_' . $menu_id];
                $jumlah = intval($value);
                
                if ($jumlah > 0) {
                    $data[] = [
                        'menu' => $menu_name,
                        'harga' => intval($harga),
                        'jumlah' => $jumlah
                    ];
                }
            }
        }
        
        $response = $controller->savePenjualan($data);
        $_SESSION['message'] = $response['message'];
        header('Location: ../index.php?page=penjualan');
        exit;
    }
}
?>
