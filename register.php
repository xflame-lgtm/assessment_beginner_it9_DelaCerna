<?php
define("PUBLIC_PAGE", true);
include "db.php";

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];

    if (strlen($username) < 3) {
        $error = "Username must be at least 3 characters.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Check if username already exists
        $check = mysqli_prepare($conn, "SELECT user_id FROM users WHERE username = ?");
        mysqli_stmt_bind_param($check, "s", $username);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {
            $error = "Username is already taken.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO users (username, password) VALUES (?, ?)"
            );
            mysqli_stmt_bind_param($stmt, "ss", $username, $hash);
            mysqli_stmt_execute($stmt);

            header("Location: login.php?registered=1");
            exit;
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="/assessment_beginner/style.css">
</head>
<body class="auth">

<div class="auth-card">

<h2>Create Account</h2>
<p class="sub">Register to access the system</p>

<?php if ($error): ?>
    <div class="msg error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="POST">

    <p>
        <label>Username</label><br>
        <input
            type="text"
            name="username"
            value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>"
            required
            autofocus
        >
    </p>

    <p>
        <label>Password</label><br>
        <input type="password" name="password" required>
    </p>

    <p>
        <label>Confirm Password</label><br>
        <input type="password" name="confirm_password" required>
    </p>

    <button type="submit">Register</button>

</form>

<p class="switch">Already have an account? <a href="login.php">Login here</a></p>

</div>

</body>
</html>
