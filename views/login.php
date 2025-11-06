<?php
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ayam Geprek Mas Ucok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 15px;
        }
        
        /* Improved responsive login container with better mobile padding and scaling */
        .login-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 30px 20px;
            width: 100%;
            max-width: 400px;
        }
        
        @media (min-width: 576px) {
            .login-container {
                padding: 40px;
            }
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h1 {
            color: #667eea;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: clamp(24px, 5vw, 28px);
        }
        
        .login-header p {
            color: #666;
            font-size: clamp(12px, 4vw, 14px);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-control {
            border: 2px solid #e0e0e0;
            padding: 12px;
            border-radius: 5px;
            transition: border-color 0.3s;
            font-size: 16px;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: none;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            width: 100%;
            transition: transform 0.2s;
            cursor: pointer;
            font-size: 16px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            color: white;
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert {
            display: none;
            margin-bottom: 20px;
            font-size: clamp(12px, 3vw, 14px);
        }
        
        .alert.show {
            display: block;
        }
        
        .demo-credentials {
            text-align: center;
            margin-top: 20px;
            color: #999;
            font-size: clamp(10px, 2.5vw, 12px);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Ayam Geprek Mas Ucok</h1>
            <p>Sistem Manajemen Penjualan</p>
        </div>
        
        <div id="alertMessage" class="alert"></div>
        
        <form id="loginForm">
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-login" id="loginBtn">Login</button>
        </form>
        
        <div class="demo-credentials">
            <p>Demo: username: <strong>admin</strong> | password: <strong>admin123</strong></p>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const btn = document.getElementById('loginBtn');
            
            btn.disabled = true;
            btn.textContent = 'Loading...';
            
            fetch('../controllers/LoginController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=login&username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password)
            })
            .then(response => response.json())
            .then(data => {
                const alert = document.getElementById('alertMessage');
                if (data.success) {
                    alert.className = 'alert alert-success show';
                    alert.textContent = data.message;
                    setTimeout(() => {
                        window.location.href = 'dashboard.php';
                    }, 1000);
                } else {
                    alert.className = 'alert alert-danger show';
                    alert.textContent = data.message;
                    btn.disabled = false;
                    btn.textContent = 'Login';
                }
            });
        });
    </script>
</body>
</html>
