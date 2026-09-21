<?php
include "../db.php";

$id = $_GET["id"];

mysqli_query(
    $conn,
    "DELETE FROM services WHERE service_id = $id"
);

header("Location: services_list.php");
exit;
?>
