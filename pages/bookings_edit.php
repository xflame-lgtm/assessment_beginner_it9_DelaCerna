<?php
include "../db.php";

$id = $_GET["id"];

$result = mysqli_query(
    $conn,
    "SELECT * FROM bookings WHERE booking_id = $id"
);

$booking = mysqli_fetch_assoc($result);

if (!$booking) {
    die("Booking not found.");
}

$clients = mysqli_query(
    $conn,
    "SELECT * FROM clients ORDER BY full_name"
);

$services = mysqli_query(
    $conn,
    "SELECT * FROM services ORDER BY service_name"
);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $client_id = $_POST["client_id"];
    $service_id = $_POST["service_id"];
    $booking_date = $_POST["booking_date"];
    $hours = $_POST["hours"];
    $status = $_POST["status"];

    $service_result = mysqli_query(
        $conn,
        "SELECT hourly_rate
         FROM services
         WHERE service_id = $service_id"
    );

    $service = mysqli_fetch_assoc($service_result);

    if (!$service) {
        die("Service not found.");
    }

    $hourly_rate = $service["hourly_rate"];
    $total_cost = $hours * $hourly_rate;

    $sql = "UPDATE bookings
            SET client_id=?,
                service_id=?,
                booking_date=?,
                hours=?,
                hourly_rate_snapshot=?,
                total_cost=?,
                status=?
            WHERE booking_id=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "iisiddsi",
        $client_id,
        $service_id,
        $booking_date,
        $hours,
        $hourly_rate,
        $total_cost,
        $status,
        $id
    );

    mysqli_stmt_execute($stmt);

    header("Location: bookings_list.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Booking</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Edit Booking</h2>

<form method="POST">

    <p>
        <label>Client:</label><br>

        <select name="client_id" required>

            <?php while ($client = mysqli_fetch_assoc($clients)): ?>

                <option
                    value="<?php echo $client['client_id']; ?>"
                    <?php
                    echo $client['client_id'] == $booking['client_id']
                        ? 'selected'
                        : '';
                    ?>
                >
                    <?php echo htmlspecialchars($client['full_name']); ?>
                </option>

            <?php endwhile; ?>

        </select>
    </p>

    <p>
        <label>Service:</label><br>

        <select name="service_id" required>

            <?php while ($service = mysqli_fetch_assoc($services)): ?>

                <option
                    value="<?php echo $service['service_id']; ?>"
                    <?php
                    echo $service['service_id'] == $booking['service_id']
                        ? 'selected'
                        : '';
                    ?>
                >
                    <?php echo htmlspecialchars($service['service_name']); ?>
                    - ₱<?php echo number_format($service['hourly_rate'], 2); ?>/hr
                </option>

            <?php endwhile; ?>

        </select>
    </p>

    <p>
        <label>Booking Date:</label><br>

        <input
            type="date"
            name="booking_date"
            value="<?php echo $booking['booking_date']; ?>"
            required
        >
    </p>

    <p>
        <label>Hours:</label><br>

        <input
            type="number"
            name="hours"
            min="1"
            value="<?php echo $booking['hours']; ?>"
            required
        >
    </p>

    <p>
        <label>Status:</label><br>

        <select name="status">

            <option
                value="PENDING"
                <?php echo $booking['status'] == 'PENDING' ? 'selected' : ''; ?>
            >
                PENDING
            </option>

            <option
                value="CONFIRMED"
                <?php echo $booking['status'] == 'CONFIRMED' ? 'selected' : ''; ?>
            >
                CONFIRMED
            </option>

            <option
                value="COMPLETED"
                <?php echo $booking['status'] == 'COMPLETED' ? 'selected' : ''; ?>
            >
                COMPLETED
            </option>

            <option
                value="CANCELLED"
                <?php echo $booking['status'] == 'CANCELLED' ? 'selected' : ''; ?>
            >
                CANCELLED
            </option>

        </select>
    </p>

    <button type="submit">Update Booking</button>

    <a href="bookings_list.php">Cancel</a>

</form>

</body>
</html>
