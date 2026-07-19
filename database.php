<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "placement";

$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>