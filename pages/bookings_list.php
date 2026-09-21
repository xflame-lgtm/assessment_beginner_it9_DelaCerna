<?php
include "../db.php";

$sql = "SELECT
            b.*,
            c.full_name,
            s.service_name
        FROM bookings b
        JOIN clients c ON b.client_id = c.client_id
        JOIN services s ON b.service_id = s.service_id
        ORDER BY b.booking_id DESC";

$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bookings</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Bookings</h2>

<p>
    <a href="bookings_create.php">Create Booking</a>
</p>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Service</th>
        <th>Date</th>
        <th>Hours</th>
        <th>Rate</th>
        <th>Total Cost</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['booking_id']; ?></td>

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
            <?php echo $row['hours']; ?>
        </td>

        <td>
            ₱<?php echo number_format($row['hourly_rate_snapshot'], 2); ?>
        </td>

        <td>
            ₱<?php echo number_format($row['total_cost'], 2); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['status']); ?>
        </td>

        <td>
            <a href="bookings_edit.php?id=<?php echo $row['booking_id']; ?>">
                Edit
            </a>
            |
            <a
                href="bookings_delete.php?id=<?php echo $row['booking_id']; ?>"
                onclick="return confirm('Delete this booking?');"
            >
                Delete
            </a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</body>
</html>
