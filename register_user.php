<?php
session_start();
include 'db_connect.php';

$error = "";
$success = "";

// ===== RAPID EMAIL VERIFIER API =====
function verifyEmail($email) {
    $api_url = "https://rapid-email-verifier.fly.dev/api/validate?email=" . urlencode($email);
    $response = @file_get_contents($api_url);

    if ($response === false) return true;

    $data = json_decode($response, true);
    return ($data['valid'] ?? false) || ($data['deliverable'] ?? false);
}

// Password validation: min 8 chars, must have uppercase, lowercase, number, special char
function isPasswordValid($password) {
    if (strlen($password) < 8) return false;
    if (!preg_match('/[A-Z]/', $password)) return false;
    if (!preg_match('/[a-z]/', $password)) return false;
    if (!preg_match('/[0-9]/', $password)) return false;
    if (!preg_match('/[^A-Za-z0-9]/', $password)) return false;
    return true;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = trim($_POST["fullname"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    if (empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Pakilagay ang lahat ng fields.";
    }
    elseif (!verifyEmail($email)) {
        $error = "Invalid email. Please use a real email address.";
    }
    elseif (!isPasswordValid($password)) {
        $error = "Password must be at least 8 characters with uppercase, lowercase, number, and special character.";
    }
    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    }
    else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already registered. Please log in instead.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $fullname, $email, $hashed_password);

            if ($stmt->execute()) {
                // ===== AUTO LOGIN AFTER REGISTRATION =====
                $new_user_id = $stmt->insert_id;

                // Set session variables (log them in automatically)
                $_SESSION["userLoggedIn"] = true;
                $_SESSION["userId"] = $new_user_id;
                $_SESSION["userName"] = $fullname;
                $_SESSION["userEmail"] = $email;

                // Redirect to survey immediately
                header("Location: survey.php");
                exit();
            } else {
                $error = "Error creating account. Please try again.";
            }
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
    <title>Create Account - Brgy 727</title>
    <link rel="stylesheet" href="login.css">
    <style>
        .register-container {
            max-width: 450px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        .register-container h2 {
            text-align: center;
            color: #1a1a2e;
            margin-bottom: 10px;
        }

        .register-container .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .password-requirements {
            background: #f8f9fa;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 12px;
            color: #666;
        }

        .password-requirements strong {
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .password-requirements ul {
            margin-left: 18px;
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            background: #e94560;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-register:hover {
            background: #c73e54;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .login-link a {
            color: #e94560;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-icon {
            font-size: 50px;
        }

        /* ===== SHOW/HIDE PASSWORD STYLES ===== */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            width: 100%;
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #666;
            padding: 5px;
            outline: none;
        }

        .toggle-password:hover {
            color: #e94560;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo-section">
            <div class="logo-icon">⚕</div>
            <h1>BRGY 727</h1>
            <p>Monitoring System</p>
        </div>

        <h2>Create Account</h2>
        <p class="subtitle">Register to access the survey</p>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="register_user.php">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" placeholder="Juan Dela Cruz" required
                       value="<?php echo htmlspecialchars($_POST['fullname'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="yourname@gmail.com" required
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>

            <div class="password-requirements">
                <strong>Password Requirements:</strong>
                <ul>
                    <li>At least 8 characters</li>
                    <li>One uppercase letter (A-Z)</li>
                    <li>One lowercase letter (a-z)</li>
                    <li>One number (0-9)</li>
                    <li>One special character (!@#$%^&*)</li>
                </ul>
            </div>

            <!-- Password with Show/Hide Toggle -->
            <div class="form-group">
                <label>Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Create password" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('password', this)" title="Show/Hide Password">
                        👁️
                    </button>
                </div>
            </div>

            <!-- Confirm Password with Show/Hide Toggle -->
            <div class="form-group">
                <label>Confirm Password</label>
                <div class="password-wrapper">
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('confirm_password', this)" title="Show/Hide Password">
                        👁️
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-register">Create Account</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="login_user.php">Log in here</a>
        </div>
    </div>

    <!-- JavaScript for Show/Hide Password -->
    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);

            if (input.type === "password") {
                input.type = "text";
                btn.textContent = "🙈";
                btn.title = "Hide Password";
            } else {
                input.type = "password";
                btn.textContent = "👁️";
                btn.title = "Show Password";
            }
        }
    </script>
</body>
</html>
