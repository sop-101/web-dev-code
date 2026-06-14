<?php
session_start();
include 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($username) || empty($password)) {
        $error = "Pakilagay ang username at password bago mag-login.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin["password"])) {
                $_SESSION["adminLoggedIn"] = true;
                $_SESSION["adminUsername"] = $admin["username"];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Mali ang username o password!";
            }
        } else {
            $error = "Mali ang username o password!";
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
    <title>Login - Brgy 727</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>

    <!-- TOP HEADER BAR -->
    <div class="top-bar">
        <img src="images/HEALTH.PNG" class="logo-circle" alt="Health">
        <div class="brand">
            <span class="brand-name">BRGY 727</span>
            <span class="brand-sub">Health Campaign</span>
        </div>
    </div>

    <!-- PAGE CENTER WRAPPER -->
    <div class="page-wrapper">

        <!-- LOGIN CARD -->
        <div class="login-container">
            <h2>Welcome Back</h2>
            <p class="login-subtitle">Sign in to access your health portal</p>

            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">

                <div class="form-group">
                    <label for="username">Email Address</label>
                    <div class="input-wrapper">
                        <span class="input-icon">✉</span>
                        <input type="text" id="username" name="username" placeholder="your.email@mail.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🔒</span>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                </div>


                <button type="submit" class="btn-login">Sign In</button>
            </form>

            <div class="register-link">
                Don't have an account? <a href="#">Register here</a>
            </div>

            <!-- PRIVACY NOTICE -->
            <div class="privacy-notice">
                <span class="privacy-icon">🛡</span>
                <p>
                    In compliance with the <strong>Philippine Data Privacy Act
                        (RA 10173)</strong>, all personal health data is handled
                    securely and anonymously. Your information is
                    encrypted and protected.
                </p>
            </div>

        </div>
    </div>

</body>

</html>
