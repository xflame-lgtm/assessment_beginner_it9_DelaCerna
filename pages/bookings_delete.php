<?php
include "../db.php";

$id = $_GET["id"];

mysqli_query(
    $conn,
    "DELETE FROM bookings WHERE booking_id = $id"
);

header("Location: bookings_list.php");
exit;
?>
