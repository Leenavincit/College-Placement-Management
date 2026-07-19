<?php
session_start();
include "database.php";

$email = $_POST['email'];
$password = $_POST['password'];

$result = mysqli_query($conn, "
    SELECT * FROM companies 
    WHERE email='$email' AND password='$password'
");

if(mysqli_num_rows($result) > 0){

    $company = mysqli_fetch_assoc($result);

    // Store session
    $_SESSION['company_id'] = $company['id'];
    $_SESSION['company_name'] = $company['name'];

    // 🔥 STEP 3 (REDIRECT)
    header("Location: company_dashboard.php");
    exit();

} else {
    echo "Invalid login";
}
?>