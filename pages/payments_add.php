<?php
include "../db.php";

$bookings = mysqli_query(
    $conn,
    "SELECT
        b.booking_id,
        b.booking_date,
        b.total_cost,
        c.full_name,
        s.service_name
     FROM bookings b
     JOIN clients c ON b.client_id = c.client_id
     JOIN services s ON b.service_id = s.service_id
     ORDER BY b.booking_id DESC"
);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $booking_id = $_POST["booking_id"];
    $amount_paid = $_POST["amount_paid"];
    $method = $_POST["method"];

    $booking_result = mysqli_query(
        $conn,
        "SELECT
            total_cost,
            IFNULL(
                (
                    SELECT SUM(amount_paid)
                    FROM payments
                    WHERE booking_id = $booking_id
                ),
                0
            ) AS already_paid
         FROM bookings
         WHERE booking_id = $booking_id"
    );

    $booking = mysqli_fetch_assoc($booking_result);

    if (!$booking) {
        die("Booking not found.");
    }

    $remaining =
        $booking["total_cost"] - $booking["already_paid"];

    if ($amount_paid <= 0) {
        die("Payment amount must be greater than zero.");
    }

    if ($amount_paid > $remaining) {
        die("Payment is greater than the remaining balance.");
    }

    $sql = "INSERT INTO payments
            (booking_id, amount_paid, method)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ids",
        $booking_id,
        $amount_paid,
        $method
    );

    mysqli_stmt_execute($stmt);

    header("Location: payments_list.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Payment</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Add Payment</h2>

<form method="POST">

    <p>
        <label>Booking:</label><br>

        <select name="booking_id" required>

            <option value="">-- Select Booking --</option>

            <?php while ($booking = mysqli_fetch_assoc($bookings)): ?>

                <option value="<?php echo $booking['booking_id']; ?>">

                    #<?php echo $booking['booking_id']; ?>

                    -
                    <?php echo htmlspecialchars($booking['full_name']); ?>

                    -
                    <?php echo htmlspecialchars($booking['service_name']); ?>

                    -
                    ₱<?php echo number_format($booking['total_cost'], 2); ?>

                </option>

            <?php endwhile; ?>

        </select>
    </p>

    <p>
        <label>Amount Paid:</label><br>

        <input
            type="number"
            name="amount_paid"
            step="0.01"
            min="0.01"
            required
        >
    </p>

    <p>
        <label>Payment Method:</label><br>

        <select name="method">

            <option value="CASH">CASH</option>
            <option value="GCASH">GCASH</option>
            <option value="BANK TRANSFER">BANK TRANSFER</option>
            <option value="CARD">CARD</option>

        </select>
    </p>

    <button type="submit">
        Save Payment
    </button>

    <a href="payments_list.php">
        Cancel
    </a>

</form>

</body>
</html>
