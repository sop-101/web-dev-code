<!DOCTYPE html>
<html lang="tl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BRGY 727 Health Monitoring System</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(
        135deg,
        #16213e 0%,
        #1f4068 100%
    );
    padding:20px;
}

/* ======================
   LOGIN CARD
====================== */

.login-container{
    width:100%;
    max-width:450px;
    background:#ffffff;
    border-radius:25px;
    padding:40px;
    box-shadow:
        0 20px 60px rgba(0,0,0,.25);
}

/* ======================
   HEADER
====================== */

.logo-section{
    text-align:center;
    margin-bottom:30px;
}

.logo-icon{
    width:80px;
    height:80px;
    margin:auto;
    border-radius:50%;
    background:#eef4ff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:40px;
    color:#1e40af;
    margin-bottom:15px;
}

.logo-section h1{
    color:#16213e;
    font-size:38px;
    font-weight:800;
    margin-bottom:5px;
}

.logo-section p{
    color:#64748b;
    font-size:15px;
}

.system-badge{
    display:inline-block;
    margin-top:12px;
    background:#fee2e2;
    color:#dc2626;
    padding:7px 15px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
}

/* ======================
   TITLES
====================== */

.login-title{
    text-align:center;
    margin-bottom:5px;
    color:#16213e;
    font-size:28px;
}

.subtitle{
    text-align:center;
    color:#64748b;
    margin-bottom:30px;
    font-size:15px;
}

/* ======================
   ERROR MESSAGE
====================== */

.error-message{
    background:#fee2e2;
    color:#b91c1c;
    padding:14px;
    border-radius:12px;
    margin-bottom:20px;
    text-align:center;
}

/* ======================
   FORM
====================== */

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    color:#334155;
    font-weight:600;
}

.form-group input{
    width:100%;
    padding:14px 16px;
    border:2px solid #e2e8f0;
    border-radius:12px;
    font-size:15px;
    transition:.3s;
}

.form-group input:focus{
    outline:none;
    border-color:#e94560;
    box-shadow:0 0 0 4px rgba(233,69,96,.15);
}

/* ======================
   SHOW PASSWORD
====================== */

.show-password{
    margin-top:-10px;
    margin-bottom:20px;
    font-size:14px;
    color:#475569;
}

.show-password input{
    margin-right:5px;
}

/* ======================
   LOGIN BUTTON
====================== */

.btn-login{
    width:100%;
    border:none;
    background:#e94560;
    color:white;
    padding:15px;
    border-radius:12px;
    font-size:17px;
    font-weight:700;
    cursor:pointer;
    transition:.3s;
}

.btn-login:hover{
    background:#d63652;
    transform:translateY(-2px);
}

/* ======================
   LINKS
====================== */

.register-link{
    text-align:center;
    margin-top:22px;
    font-size:15px;
}

.register-link a{
    color:#e94560;
    font-weight:700;
    text-decoration:none;
}

.register-link a:hover{
    text-decoration:underline;
}

.admin-link{
    text-align:center;
    margin-top:15px;
}

.admin-link a{
    color:#64748b;
    text-decoration:none;
    font-size:13px;
}

.admin-link a:hover{
    color:#1e293b;
}

/* ======================
   FOOTER
====================== */

.login-footer{
    margin-top:25px;
    text-align:center;
    font-size:12px;
    color:#94a3b8;
}

</style>
</head>

<body>

<div class="login-container">

    <!-- HEADER -->
    <div class="logo-section">

        <div class="logo-icon">
            🏥
        </div>

        <h1>BRGY 727</h1>

        <p>Health Monitoring System</p>

        <div class="system-badge">
            Barangay Health Survey Portal
        </div>

    </div>

    <!-- TITLE -->

    <h2 class="login-title">
        User Login
    </h2>

    <p class="subtitle">
        Log in to access community health surveys and reports.
    </p>

    <!-- ERROR MESSAGE -->

    <?php if (!empty($error)): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <!-- FORM -->

    <form method="POST" action="login_user.php">

        <div class="form-group">

            <label>Email Address</label>

            <input
                type="email"
                name="email"
                placeholder="yourname@gmail.com"
                required
            >

        </div>

        <div class="form-group">

            <label>Password</label>

            <input
                type="password"
                name="password"
                id="password"
                placeholder="Enter your password"
                required
            >

        </div>

        <div class="show-password">

            <input type="checkbox" id="showPassword">

            <label for="showPassword">
                Show Password
            </label>

        </div>

        <button type="submit" class="btn-login">
            Log In
        </button>

    </form>

    <!-- LINKS -->

    <div class="register-link">
        No account yet?
        <a href="register_user.php">
            Create Account
        </a>
    </div>

    <div class="admin-link">
        <a href="login.php">
            ← Admin Login
        </a>
    </div>

    <!-- FOOTER -->

    <div class="login-footer">
        BRGY 727 Health Monitoring System
    </div>

</div>

<script>

document
.getElementById("showPassword")
.addEventListener("change", function(){

    const passwordField =
    document.getElementById("password");

    passwordField.type =
    this.checked ? "text" : "password";

});

</script>

</body>
</html>
