<?php
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: tools_list_assign.php");
    exit;
}

$booking_id = $_POST["booking_id"];
$tool_id = $_POST["tool_id"];
$qty_used = $_POST["qty_used"];

if ($qty_used < 1) {
    die("Quantity must be at least 1.");
}

$tool_result = mysqli_query(
    $conn,
    "SELECT *
     FROM tools
     WHERE tool_id = $tool_id"
);

$tool = mysqli_fetch_assoc($tool_result);

if (!$tool) {
    die("Tool not found.");
}

if ($tool["quantity_available"] < $qty_used) {
    die("Not enough available tools.");
}

$insert = mysqli_query(
    $conn,
    "INSERT INTO booking_tools
     (booking_id, tool_id, qty_used)
     VALUES
     ($booking_id, $tool_id, $qty_used)"
);

if (!$insert) {
    die("Failed to assign tool.");
}

$new_quantity = $tool["quantity_available"] - $qty_used;

mysqli_query(
    $conn,
    "UPDATE tools
     SET quantity_available = $new_quantity
     WHERE tool_id = $tool_id"
);

header("Location: tools_list_assign.php");
exit;
?>
