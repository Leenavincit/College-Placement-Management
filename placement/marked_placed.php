<?php
session_start();
include("database.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$id      = $_POST['id'];
$company = $_POST['company'];

$query = "UPDATE students 
          SET status='Placed', 
              company='$company', 
              placed_date=CURDATE() 
          WHERE id='$id'";

if(mysqli_query($conn, $query)){
    header("Location: view_student.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Mark as Placed</title>
<link rel="stylesheet" href="admin.css">
</head>

<body>

<div class="container">

<h2>Enter Company Name</h2>

<form method="POST">
    <input type="text" name="company" placeholder="Company Name" required>
    <br><br>
    <button type="submit" name="submit">Confirm Placement</button>
</form>

</div>

</body>
</html>