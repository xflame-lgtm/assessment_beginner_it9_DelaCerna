<?php
include "../db.php";

$id = $_GET["id"];

$result = mysqli_query($conn, "SELECT * FROM clients WHERE client_id = $id");
$client = mysqli_fetch_assoc($result);

if (!$client) {
    die("Client not found.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    $sql = "UPDATE clients
            SET full_name=?, email=?, phone=?, address=?
            WHERE client_id=?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "ssssi",
        $full_name,
        $email,
        $phone,
        $address,
        $id
    );

    mysqli_stmt_execute($stmt);

    header("Location: clients_list.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Client</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Edit Client</h2>

<form method="POST">

    <p>
        <label>Full Name:</label><br>
        <input
            type="text"
            name="full_name"
            value="<?php echo htmlspecialchars($client['full_name']); ?>"
            required
        >
    </p>

    <p>
        <label>Email:</label><br>
        <input
            type="email"
            name="email"
            value="<?php echo htmlspecialchars($client['email']); ?>"
            required
        >
    </p>

    <p>
        <label>Phone:</label><br>
        <input
            type="text"
            name="phone"
            value="<?php echo htmlspecialchars($client['phone']); ?>"
        >
    </p>

    <p>
        <label>Address:</label><br>
        <input
            type="text"
            name="address"
            value="<?php echo htmlspecialchars($client['address']); ?>"
        >
    </p>

    <button type="submit">Update Client</button>
    <a href="clients_list.php">Cancel</a>

</form>

</body>
</html>
