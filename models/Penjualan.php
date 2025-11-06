<?php
class Penjualan {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function getMenu() {
        $query = "SELECT * FROM menu ORDER BY id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function savePenjualan($data) {
        foreach ($data as $item) {
            if ($item['jumlah'] > 0) {
                $query = "INSERT INTO penjualan (menu, harga, jumlah, total, tanggal) 
                         VALUES (?, ?, ?, ?, DATE(NOW()))";
                $stmt = $this->conn->prepare($query);
                $total = $item['harga'] * $item['jumlah'];
                $stmt->bind_param("siii", $item['menu'], $item['harga'], $item['jumlah'], $total);
                $stmt->execute();
            }
        }
        return true;
    }
    
    public function getHarianReport() {
        $query = "SELECT menu, harga, SUM(jumlah) as total_jumlah, SUM(total) as total_penjualan 
                 FROM penjualan WHERE DATE(tanggal) = DATE(NOW())
                 GROUP BY menu ORDER BY menu";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getTotalHarian() {
        $query = "SELECT SUM(total) as grand_total FROM penjualan WHERE DATE(tanggal) = DATE(NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['grand_total'] ?? 0;
    }
    
    public function getBulananReport($month, $year) {
        $query = "SELECT menu, harga, SUM(jumlah) as total_jumlah, SUM(total) as total_penjualan 
                 FROM penjualan WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?
                 GROUP BY menu ORDER BY menu";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $month, $year);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getTotalBulanan($month, $year) {
        $query = "SELECT SUM(total) as grand_total FROM penjualan 
                 WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $month, $year);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['grand_total'] ?? 0;
    }
    
    public function getTahunanReport($year) {
        $query = "SELECT menu, harga, SUM(jumlah) as total_jumlah, SUM(total) as total_penjualan 
                 FROM penjualan WHERE YEAR(tanggal) = ?
                 GROUP BY menu ORDER BY menu";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getTotalTahunan($year) {
        $query = "SELECT SUM(total) as grand_total FROM penjualan WHERE YEAR(tanggal) = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['grand_total'] ?? 0;
    }
}
?>
