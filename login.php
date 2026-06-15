<?php
session_start();
include 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($username) || empty($password)) {
        $error = "Pakilagay ang username at password.";
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
                $error = "Mali ang password!";
            }
        } else {
            $error = "Mali ang username!";
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
    <title>Admin Login - Brgy 727</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <!-- HEADER BAR -->
    <header class="header">
        <div class="header-left">
            <div class="logo-section">
                <img src="images/HEALTH.PNG" class="logo-icon-img" alt="Health">
                <div class="logo-text">
                    <h1>BRGY 727</h1>
                    <p>HEALTH CAMPAIGN</p>
                </div>
            </div>
        </div>
    </header>

    <!-- LOGIN CARD CENTERED -->
    <div class="page-wrapper">
        <div class="login-container">
            <h2>Admin Login</h2>

            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <span class="input-icon">&#128100;</span>
                        <input type="text" name="username" placeholder="Enter username" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">&#128274;</span>
                        <input type="password" name="password" placeholder="Enter password" required>
                    </div>
                </div>

                <button type="submit" class="btn-login">Login</button>
            </form>

            <div class="back-link">
                <a href="homepage.php">← Back to Homepage</a>
            </div>
        </div>
    </div>
</body>

</html>