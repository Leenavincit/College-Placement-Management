<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("database.php");

$username = $_POST['username'];
$password = $_POST['password'];

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $row = $result->fetch_assoc();

    // Compare password (use password_verify if you store hashed passwords)
    if($password == $row['password']){ // or: password_verify($password, $row['password'])
        
        // SET SESSION
        $_SESSION['admin_id']   = $row['id'];
        $_SESSION['admin_name'] = $row['username'];

        session_write_close(); // Ensure session is saved before redirect

        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Invalid username or password";
    }

} else {
    echo "Invalid username or password";
}
?>