<?php
session_start();
include 'db_connect.php';

// ===== EMAILDETECTIVE API CONFIGURATION =====
define('EMAIL_API_KEY', 'MmE0YTNiMWE5NzZkZjNiNTc5MGU6NWQ1MjgwMWI2ODI2OTY2YTI5Nzc');
define('EMAIL_API_URL', 'https://api.emaildetective.io/v1/verify');

function verifyEmail($email) {
    $api_url = EMAIL_API_URL . "?email=" . urlencode($email) . "&api_key=" . EMAIL_API_KEY;
    
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'header' => "Accept: application/json\r\n"
        ]
    ]);
    
    $response = @file_get_contents($api_url, false, $context);
    
    if ($response === false) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    $data = json_decode($response, true);
    
    if (isset($data['valid']) && $data['valid'] === true) return true;
    if (isset($data['deliverable']) && $data['deliverable'] === true) return true;
    if (isset($data['status']) && $data['status'] === 'valid') return true;
    if (isset($data['result']) && $data['result'] === 'deliverable') return true;
    
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($email) || empty($password)) {
        $error = "Pakilagay ang email at password.";
    }
    elseif (!verifyEmail($email)) {
        $error = "Invalid email address.";
    }
    else {
        $stmt = $conn->prepare("SELECT id, fullname, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user["password"])) {
                $_SESSION["userLoggedIn"] = true;
                $_SESSION["userId"] = $user["id"];
                $_SESSION["userName"] = $user["fullname"];
                $_SESSION["userEmail"] = $user["email"];
                header("Location: survey.php");
                exit();
            } else {
                $error = "Mali ang password!";
            }
        } else {
            $error = "Email not found. Please register first.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="tl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - Brgy 727</title>
    <link rel="stylesheet" href="login.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .login-container h2 {
            text-align: center;
            color: #1a1a2e;
            margin-bottom: 10px;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
            font-size: 14px;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: #e94560;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-login:hover {
            background: #c73e54;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .register-link a {
            color: #e94560;
            font-weight: 600;
            text-decoration: none;
        }
        .logo-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo-icon {
            font-size: 50px;
        }
        .admin-link {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
        }
        .admin-link a {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-section">
            <div class="logo-icon">⚕</div>
            <h1>BRGY 727</h1>
            <p>Monitoring System</p>
        </div>
        
        <h2>User Login</h2>
        <p class="subtitle">Log in to access the survey</p>
        
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="login_user.php">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="yourname@gmail.com" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" required>
            </div>
            
            <button type="submit" class="btn-login">Log In</button>
        </form>
        
        <div class="register-link">
            No account yet? <a href="register_user.php">Create Account</a>
        </div>
        
        <div class="admin-link">
            <a href="login.php">← Admin Login</a>
        </div>
    </div>
</body>
</html>
