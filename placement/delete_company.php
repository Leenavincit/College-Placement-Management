<?php
include("database.php");

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM companies WHERE id=$id");

header("Location: view_company.php");
?>