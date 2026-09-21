<?php
include "../db.php";

$id = $_GET["id"];

$result = mysqli_query(
    $conn,
    "SELECT * FROM services WHERE service_id = $id"
);

$service = mysqli_fetch_assoc($result);

if (!$service) {
    die("Service not found.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $service_name = $_POST["service_name"];
    $description = $_POST["description"];
    $hourly_rate = $_POST["hourly_rate"];
    $is_active = $_POST["is_active"];

    $sql = "UPDATE services
            SET service_name=?,
                description=?,
                hourly_rate=?,
                is_active=?
            WHERE service_id=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssdii",
        $service_name,
        $description,
        $hourly_rate,
        $is_active,
        $id
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
    <title>Edit Service</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Edit Service</h2>

<form method="POST">

    <p>
        <label>Service Name:</label><br>
        <input
            type="text"
            name="service_name"
            value="<?php echo htmlspecialchars($service['service_name']); ?>"
            required
        >
    </p>

    <p>
        <label>Description:</label><br>
        <textarea
            name="description"
            rows="4"
            cols="40"
        ><?php echo htmlspecialchars($service['description']); ?></textarea>
    </p>

    <p>
        <label>Hourly Rate:</label><br>
        <input
            type="number"
            name="hourly_rate"
            step="0.01"
            min="0"
            value="<?php echo $service['hourly_rate']; ?>"
            required
        >
    </p>

    <p>
        <label>Status:</label><br>

        <select name="is_active">

            <option
                value="1"
                <?php echo $service['is_active'] == 1 ? 'selected' : ''; ?>
            >
                ACTIVE
            </option>

            <option
                value="0"
                <?php echo $service['is_active'] == 0 ? 'selected' : ''; ?>
            >
                INACTIVE
            </option>

        </select>
    </p>

    <button type="submit">Update Service</button>

    <a href="services_list.php">Cancel</a>

</form>

</body>
</html>
