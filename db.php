<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "assessment_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Login guard: every page that includes db.php requires a logged-in user,
// except pages that define("PUBLIC_PAGE", true) before including this file
// (login.php and register.php).
if (!defined("PUBLIC_PAGE") && !isset($_SESSION["user_id"])) {
    header("Location: /assessment_beginner/login.php");
    exit;
}
?>
