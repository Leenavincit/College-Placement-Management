<?php
session_start();
include "database.php";

/* CHECK LOGIN */
if(!isset($_SESSION['company_id']) && !isset($_SESSION['admin_id'])){
    die("Not authorized");
}

$id = $_GET['id'];

/* IF COMPANY */
if(isset($_SESSION['company_id'])){
    $company_id = $_SESSION['company_id'];

    mysqli_query($conn, "
        DELETE FROM jobs 
        WHERE id='$id' AND company_id='$company_id'
    ");
}

/* IF ADMIN */
elseif(isset($_SESSION['admin_id'])){
    mysqli_query($conn, "
        DELETE FROM jobs 
        WHERE id='$id'
    ");
}

header("Location: job_postings.php");
exit();
?>