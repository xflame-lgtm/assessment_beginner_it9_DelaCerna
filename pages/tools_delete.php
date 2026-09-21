<?php
include "../db.php";

$id = $_GET["id"];

$check = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM booking_tools
     WHERE tool_id = $id"
);

$row = mysqli_fetch_assoc($check);

if ($row["total"] > 0) {
    die("This tool has been assigned to a booking and cannot be deleted.");
}

mysqli_query(
    $conn,
    "DELETE FROM tools WHERE tool_id = $id"
);

header("Location: tools_list_assign.php");
exit;
?>
