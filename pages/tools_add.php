<?php
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $tool_name = $_POST["tool_name"];
    $quantity_total = $_POST["quantity_total"];

    $sql = "INSERT INTO tools
            (tool_name, quantity_total, quantity_available)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sii",
        $tool_name,
        $quantity_total,
        $quantity_total
    );

    mysqli_stmt_execute($stmt);

    header("Location: tools_list_assign.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Tool</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Add Tool</h2>

<form method="POST">

    <p>
        <label>Tool Name:</label><br>

        <input
            type="text"
            name="tool_name"
            required
        >
    </p>

    <p>
        <label>Total Quantity:</label><br>

        <input
            type="number"
            name="quantity_total"
            min="0"
            required
        >
    </p>

    <button type="submit">
        Save Tool
    </button>

    <a href="tools_list_assign.php">
        Cancel
    </a>

</form>

</body>
</html>
