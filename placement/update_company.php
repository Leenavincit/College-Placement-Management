<?php
session_start();
include "database.php";

if (!isset($_SESSION['company_id'])) {
    die("Unauthorized");
}

$id = $_POST['id'];

// SECURITY CHECK
if ($_SESSION['company_id'] != $id) {
    die("Unauthorized access");
}

$name = $_POST['name'];
$email = $_POST['email'];
$location = $_POST['location'];
$industry = $_POST['industry'];
$phone = $_POST['phone'];

// check if phone column exists (safe update)
$query = "
UPDATE companies SET 
name='$name',
email='$email',
location='$location',
industry='$industry'
";

// add phone only if exists
if (isset($phone)) {
    $query .= ", phone='$phone'";
}

$query .= " WHERE id='$id'";

$result = mysqli_query($conn, $query);

if ($result) {
    header("Location: company_dashboard.php?msg=updated");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>