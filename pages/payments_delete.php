<?php
include "../db.php";

$id = $_GET["id"];

mysqli_query(
    $conn,
    "DELETE FROM payments WHERE payment_id = $id"
);

header("Location: payments_list.php");
exit;
?>
