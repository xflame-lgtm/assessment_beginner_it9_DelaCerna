<?php
include "../db.php";

$tools = mysqli_query(
    $conn,
    "SELECT * FROM tools ORDER BY tool_id DESC"
);

$bookings = mysqli_query(
    $conn,
    "SELECT
        b.booking_id,
        b.booking_date,
        c.full_name,
        s.service_name
     FROM bookings b
     JOIN clients c ON b.client_id = c.client_id
     JOIN services s ON b.service_id = s.service_id
     ORDER BY b.booking_id DESC"
);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tools</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Tools</h2>

<p>
    <a href="tools_add.php">Add Tool</a>
</p>

<table border="1" cellpadding="8" cellspacing="0">

    <tr>
        <th>ID</th>
        <th>Tool Name</th>
        <th>Total Quantity</th>
        <th>Available Quantity</th>
        <th>Actions</th>
    </tr>

    <?php while ($tool = mysqli_fetch_assoc($tools)): ?>

    <tr>

        <td>
            <?php echo $tool['tool_id']; ?>
        </td>

        <td>
            <?php echo htmlspecialchars($tool['tool_name']); ?>
        </td>

        <td>
            <?php echo $tool['quantity_total']; ?>
        </td>

        <td>
            <?php echo $tool['quantity_available']; ?>
        </td>

        <td>

            <a href="tools_edit.php?id=<?php echo $tool['tool_id']; ?>">
                Edit
            </a>

            |

            <a
                href="tools_delete.php?id=<?php echo $tool['tool_id']; ?>"
                onclick="return confirm('Delete this tool?');"
            >
                Delete
            </a>

        </td>

    </tr>

    <?php endwhile; ?>

</table>

<hr>

<h2>Assign Tool to Booking</h2>

<form method="POST" action="tools_assign.php">

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
                    <?php echo $booking['booking_date']; ?>

                </option>

            <?php endwhile; ?>

        </select>

    </p>

    <p>
        <label>Tool:</label><br>

        <select name="tool_id" required>

            <option value="">-- Select Tool --</option>

            <?php
            mysqli_data_seek(
                $tools,
                0
            );

            while ($tool = mysqli_fetch_assoc($tools)):
            ?>

                <option value="<?php echo $tool['tool_id']; ?>">

                    <?php echo htmlspecialchars($tool['tool_name']); ?>

                    -
                    Available:
                    <?php echo $tool['quantity_available']; ?>

                </option>

            <?php endwhile; ?>

        </select>

    </p>

    <p>
        <label>Quantity Used:</label><br>

        <input
            type="number"
            name="qty_used"
            min="1"
            value="1"
            required
        >

    </p>

    <button type="submit">
        Assign Tool
    </button>

</form>

<hr>

<h2>Assigned Tools</h2>

<?php
$assigned = mysqli_query(
    $conn,
    "SELECT
        bt.booking_tool_id,
        bt.booking_id,
        bt.qty_used,
        t.tool_name,
        c.full_name,
        s.service_name
     FROM booking_tools bt
     JOIN tools t ON bt.tool_id = t.tool_id
     JOIN bookings b ON bt.booking_id = b.booking_id
     JOIN clients c ON b.client_id = c.client_id
     JOIN services s ON b.service_id = s.service_id
     ORDER BY bt.booking_tool_id DESC"
);
?>

<table border="1" cellpadding="8" cellspacing="0">

    <tr>
        <th>ID</th>
        <th>Booking</th>
        <th>Client</th>
        <th>Service</th>
        <th>Tool</th>
        <th>Quantity Used</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($assigned)): ?>

    <tr>

        <td>
            <?php echo $row['booking_tool_id']; ?>
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
            <?php echo htmlspecialchars($row['tool_name']); ?>
        </td>

        <td>
            <?php echo $row['qty_used']; ?>
        </td>

    </tr>

    <?php endwhile; ?>

</table>

</body>
</html>
