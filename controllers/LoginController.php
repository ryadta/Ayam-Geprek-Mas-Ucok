<?php
session_start();

require_once '../config/database.php';
require_once '../models/User.php';

class LoginController {
    private $user;
    
    public function __construct($db) {
        $this->user = new User($db);
    }
    
    public function login($username, $password) {
        if (empty($username) || empty($password)) {
            return ['success' => false, 'message' => 'Username dan password harus diisi'];
        }
        
        $result = $this->user->login($username, $password);
        
        if ($result) {
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['username'] = $result['username'];
            return ['success' => true, 'message' => 'Login berhasil'];
        } else {
            return ['success' => false, 'message' => 'Username atau password salah'];
        }
    }
    
    public function logout() {
        session_destroy();
        return true;
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new LoginController($conn);
    
    if ($_POST['action'] === 'login') {
        $response = $controller->login($_POST['username'] ?? '', $_POST['password'] ?? '');
        echo json_encode($response);
    } elseif ($_POST['action'] === 'logout') {
        $controller->logout();
        header('Location: ../index.php?page=login');
    }
}
?>
