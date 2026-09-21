<?php
include "../db.php";

$id = $_GET["id"];

$result = mysqli_query(
    $conn,
    "SELECT * FROM tools WHERE tool_id = $id"
);

$tool = mysqli_fetch_assoc($result);

if (!$tool) {
    die("Tool not found.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $tool_name = $_POST["tool_name"];
    $quantity_total = $_POST["quantity_total"];

    $used = $tool["quantity_total"] - $tool["quantity_available"];

    if ($quantity_total < $used) {
        die("Total quantity cannot be lower than the quantity already in use.");
    }

    $quantity_available = $quantity_total - $used;

    $sql = "UPDATE tools
            SET tool_name=?,
                quantity_total=?,
                quantity_available=?
            WHERE tool_id=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "siii",
        $tool_name,
        $quantity_total,
        $quantity_available,
        $id
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
    <title>Edit Tool</title>
</head>
<body>

<?php include "../nav.php"; ?>

<h2>Edit Tool</h2>

<form method="POST">

    <p>
        <label>Tool Name:</label><br>

        <input
            type="text"
            name="tool_name"
            value="<?php echo htmlspecialchars($tool['tool_name']); ?>"
            required
        >
    </p>

    <p>
        <label>Total Quantity:</label><br>

        <input
            type="number"
            name="quantity_total"
            min="0"
            value="<?php echo $tool['quantity_total']; ?>"
            required
        >
    </p>

    <p>
        Currently Available:
        <b><?php echo $tool['quantity_available']; ?></b>
    </p>

    <button type="submit">
        Update Tool
    </button>

    <a href="tools_list_assign.php">
        Cancel
    </a>

</form>

</body>
</html>
