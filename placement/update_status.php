<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "database.php";

/* CHECK LOGIN */
if(!isset($_SESSION['company_id'])){
    die("Not logged in");
}

/* CHECK IF FORM DATA RECEIVED */
if(isset($_POST['app_id']) && isset($_POST['action'])){

    $app_id = $_POST['app_id'];
    $status = $_POST['action'];

    // ALLOW ONLY VALID VALUES
    if($status == "Accepted" || $status == "Rejected"){

        mysqli_query($conn, "
            UPDATE applications 
            SET status='$status' 
            WHERE id='$app_id'
        ");

    } else {
        die("Invalid status");
    }
}

/* GO BACK TO APPLICANTS PAGE */
header("Location: applicants.php");
exit();
?>