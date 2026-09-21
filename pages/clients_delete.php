<?php
include "../db.php";

$id = $_GET["id"];

mysqli_query($conn, "DELETE FROM clients WHERE client_id = $id");

header("Location: clients_list.php");
exit;
?>
