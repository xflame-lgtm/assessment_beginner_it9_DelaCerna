<?php
include "../db.php";

$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Services</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Services</h2>

<p>
    <a href="services_add.php">Add Service</a>
</p>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Service Name</th>
        <th>Description</th>
        <th>Hourly Rate</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['service_id']; ?></td>

        <td>
            <?php echo htmlspecialchars($row['service_name']); ?>
        </td>

        <td>
            <?php echo htmlspecialchars($row['description']); ?>
        </td>

        <td>
            ₱<?php echo number_format($row['hourly_rate'], 2); ?>
        </td>

        <td>
            <?php echo $row['is_active'] ? 'ACTIVE' : 'INACTIVE'; ?>
        </td>

        <td>
            <a href="services_edit.php?id=<?php echo $row['service_id']; ?>">
                Edit
            </a>
            |
            <a
                href="services_delete.php?id=<?php echo $row['service_id']; ?>"
                onclick="return confirm('Delete this service?');"
            >
                Delete
            </a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</body>
</html>
