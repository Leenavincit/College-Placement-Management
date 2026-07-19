<?php
include "database.php";

if(isset($_POST['submit']))
{
$name=$_POST['name'];
$email=$_POST['email'];
$dept=$_POST['department'];
$cgpa=$_POST['cgpa'];
$password=$_POST['password'];

mysqli_query($conn,"INSERT INTO students(name,email,department,cgpa,password)
VALUES('$name','$email','$dept','$cgpa','$password')");
}
?>

<h2>Student Registration</h2>

<form method="POST">

Name  
<input type="text" name="name" required>

Email  
<input type="email" name="email" required>

Department  
<input type="text" name="department" required>

CGPA  
<input type="text" name="cgpa" required>

Password  
<input type="password" name="password" required>

<br><br>

<button name="submit">Register</button>

</form>