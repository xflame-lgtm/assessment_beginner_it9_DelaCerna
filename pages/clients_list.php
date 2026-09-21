<?php
include "../db.php";

$result = mysqli_query($conn, "SELECT * FROM clients ORDER BY client_id DESC");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Clients</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Clients</h2>

<p>
    <a href="clients_add.php">Add Client</a>
</p>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['client_id']; ?></td>
        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['phone']); ?></td>
        <td><?php echo htmlspecialchars($row['address']); ?></td>
        <td>
            <a href="clients_edit.php?id=<?php echo $row['client_id']; ?>">Edit</a>
            |
            <a href="clients_delete.php?id=<?php echo $row['client_id']; ?>"
               onclick="return confirm('Delete this client?');">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</body>
</html>
