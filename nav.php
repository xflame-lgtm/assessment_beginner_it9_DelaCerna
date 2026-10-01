<?php
// nav.php
$current = $_SERVER["PHP_SELF"];

function nav_active($needle, $current) {
    return strpos($current, $needle) !== false ? "active" : "";
}
?>
<link rel="stylesheet" href="/assessment_beginner/style.css">

<nav class="topnav">
    <span class="brand">Assessment System</span>

    <a class="<?php echo basename($current) === 'index.php' && strpos($current, '/pages/') === false ? 'active' : ''; ?>"
       href="/assessment_beginner/index.php">Dashboard</a>
    <a class="<?php echo nav_active('clients_', $current); ?>"
       href="/assessment_beginner/pages/clients_list.php">Clients</a>
    <a class="<?php echo nav_active('services_', $current); ?>"
       href="/assessment_beginner/pages/services_list.php">Services</a>
    <a class="<?php echo nav_active('bookings_', $current); ?>"
       href="/assessment_beginner/pages/bookings_list.php">Bookings</a>
    <a class="<?php echo nav_active('tools_', $current); ?>"
       href="/assessment_beginner/pages/tools_list_assign.php">Tools</a>
    <a class="<?php echo nav_active('payments_', $current); ?>"
       href="/assessment_beginner/pages/payments_list.php">Payments</a>

    <a class="logout" href="/assessment_beginner/logout.php">Logout</a>
</nav>
