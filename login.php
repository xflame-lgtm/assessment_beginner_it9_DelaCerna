<?php
define("PUBLIC_PAGE", true);
include "db.php";

// Already logged in? Go to dashboard.
if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT user_id, username, password, role FROM users WHERE username = ?"
    );
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if ($user && password_verify($password, $user["password"])) {
        session_regenerate_id(true);
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];

        header("Location: index.php");
        exit;
    }

    $error = "Invalid username or password.";
}

$registered = isset($_GET["registered"]);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="/assessment_beginner/style.css">
</head>
<body class="auth">

<div class="auth-card">

<h2>Welcome Back</h2>
<p class="sub">Log in to your account</p>

<?php if ($registered): ?>
    <div class="msg success">Registration successful! Please log in.</div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="msg error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="POST">

    <p>
        <label>Username</label><br>
        <input type="text" name="username" required autofocus>
    </p>

    <p>
        <label>Password</label><br>
        <input type="password" name="password" required>
    </p>

    <button type="submit">Login</button>

</form>

<p class="switch">No account yet? <a href="register.php">Register here</a></p>

</div>

</body>
</html>
