<?php
include "db.php";

$clients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM clients"))['c'];
$services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM services"))['c'];
$bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM bookings"))['c'];

$revRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS s FROM payments"));
$revenue = $revRow['s'];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
</head>
<body>

<?php include "nav.php"; ?>

<h2>Dashboard</h2>

<div class="welcome">
    <h3>Welcome, Admin!</h3>
    <p>Logged in as <b><?php echo htmlspecialchars($_SESSION['username']); ?></b></p>
</div>

<div class="stats">
    <div class="stat">
        <div class="label">Total Clients</div>
        <div class="value"><?php echo $clients; ?></div>
    </div>
    <div class="stat">
        <div class="label">Total Services</div>
        <div class="value"><?php echo $services; ?></div>
    </div>
    <div class="stat">
        <div class="label">Total Bookings</div>
        <div class="value"><?php echo $bookings; ?></div>
    </div>
    <div class="stat">
        <div class="label">Total Revenue</div>
        <div class="value">₱<?php echo number_format($revenue, 2); ?></div>
    </div>
</div>

<div class="actions">
    <a href="/assessment_beginner/pages/clients_add.php">+ Add Client</a>
    <a href="/assessment_beginner/pages/bookings_create.php">+ Create Booking</a>
</div>

</body>
</html>
