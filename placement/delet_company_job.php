<?php
include "database.php";

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM jobs WHERE id='$id'");

header("Location: job_postings.php");
?>