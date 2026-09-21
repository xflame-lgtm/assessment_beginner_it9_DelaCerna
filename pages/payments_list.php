<?php
include "../db.php";

$sql = "SELECT
            p.*,
            b.booking_date,
            b.total_cost,
            c.full_name,
            s.service_name
        FROM payments p
        JOIN bookings b ON p.booking_id = b.booking_id
        JOIN clients c ON b.client_id = c.client_id
        JOIN services s ON b.service_id = s.service_id
        ORDER BY p.payment_id DESC";

$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payments</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Payments</h2>

<p>
    <a href="payments_add.php">Add Payment</a>
</p>

<table border="1" cellpadding="8" cellspacing="0">

    <tr>
        <th>ID</th>
        <th>Booking</th>
        <th>Client</th>
        <th>Service</th>
        <th>Booking Date</th>
        <th>Total Cost</th>
        <th>Amount Paid</th>
        <th>Method</th>
        <th>Payment Date</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>

    <tr>

        <td>
            <?php echo $row['payment_id']; ?>
        </td>

        <td>
            #<?php echo $row['booking_id']; ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['full_name']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['service_name']); ?>
        </td>

        <td>
            <?php echo $row['booking_date']; ?>
        </td>

        <td>
            ₱<?php echo number_format($row['total_cost'], 2); ?>
        </td>

        <td>
            ₱<?php echo number_format($row['amount_paid'], 2); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['method']); ?>
        </td>

        <td>
            <?php echo $row['payment_date']; ?>
        </td>

        <td>
            <a
                href="payments_delete.php?id=<?php echo $row['payment_id']; ?>"
                onclick="return confirm('Delete this payment?');"
            >
                Delete
            </a>
        </td>

    </tr>

    <?php endwhile; ?>

</table>

</body>
</html>
