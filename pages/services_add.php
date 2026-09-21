<?php
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $service_name = $_POST["service_name"];
    $description = $_POST["description"];
    $hourly_rate = $_POST["hourly_rate"];
    $is_active = $_POST["is_active"];

    $sql = "INSERT INTO services
            (service_name, description, hourly_rate, is_active)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssdi",
        $service_name,
        $description,
        $hourly_rate,
        $is_active
    );

    mysqli_stmt_execute($stmt);

    header("Location: services_list.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Service</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Add Service</h2>

<form method="POST">

    <p>
        <label>Service Name:</label><br>
        <input type="text" name="service_name" required>
    </p>

    <p>
        <label>Description:</label><br>
        <textarea name="description" rows="4" cols="40"></textarea>
    </p>

    <p>
        <label>Hourly Rate:</label><br>
        <input type="number" name="hourly_rate" step="0.01" min="0" required>
    </p>

    <p>
        <label>Status:</label><br>

        <select name="is_active">
            <option value="1">ACTIVE</option>
            <option value="0">INACTIVE</option>
        </select>
    </p>

    <button type="submit">Save Service</button>

    <a href="services_list.php">Cancel</a>

</form>

</body>
</html>
