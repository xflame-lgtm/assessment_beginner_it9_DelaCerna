<?php
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    $sql = "INSERT INTO clients (full_name, email, phone, address)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $full_name, $email, $phone, $address);
    mysqli_stmt_execute($stmt);

    header("Location: clients_list.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Client</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Add Client</h2>

<form method="POST">

    <p>
        <label>Full Name:</label><br>
        <input type="text" name="full_name" required>
    </p>

    <p>
        <label>Email:</label><br>
        <input type="email" name="email" required>
    </p>

    <p>
        <label>Phone:</label><br>
        <input type="text" name="phone">
    </p>

    <p>
        <label>Address:</label><br>
        <input type="text" name="address">
    </p>

    <button type="submit">Save Client</button>
    <a href="clients_list.php">Cancel</a>

</form>

</body>
</html>
