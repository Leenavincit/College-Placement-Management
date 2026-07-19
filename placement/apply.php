<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "database.php";

// ✅ Check login
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

// ✅ Check job_id
if (!isset($_POST['job_id']) || empty($_POST['job_id'])) {
    die("Job ID not received");
}

$student_id = $_SESSION['student_id'];
$job_id = $_POST['job_id'];

// ✅ Prevent duplicate application
$check = mysqli_query($conn, "
    SELECT * FROM applications 
    WHERE student_id = '$student_id' 
    AND job_id = '$job_id'
");

if (mysqli_num_rows($check) > 0) {
    header("Location: student_dashboard.php?msg=already");
    exit();
}

// ✅ Insert application
$query = "
    INSERT INTO applications 
    (student_id, job_id, applied_date, status) 
    VALUES 
    ('$student_id', '$job_id', CURDATE(), 'Pending')
";

$result = mysqli_query($conn, $query);

// ✅ Success / Error handling
if ($result) {
    header("Location: student_dashboard.php?msg=success");
    exit();
} else {
    die("Error: " . mysqli_error($conn));
}
?>