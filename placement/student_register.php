<?php
session_start();
include "database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['register'])){
    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $roll_no    = $_POST['roll_no'];
    $department = $_POST['department'];
    $cgpa       = $_POST['cgpa'];
    $skills     = $_POST['skills'];
    $password   = $_POST['password'];
    $status     = "Not Placed";

    // ✅ Fixed: $dept → $department, added phone/roll_no/skills
    $sql = "INSERT INTO students 
            (name, email, phone, roll_no, department, cgpa, skills, password, status, company, placed_date)
            VALUES 
            ('$name','$email','$phone','$roll_no','$department','$cgpa','$skills','$password','$status','',NULL)";

    // ✅ Fixed: $query → $sql
    if(mysqli_query($conn, $sql)){
        header("Location: student_login.php?msg=registered");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Student Registration</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: #f5f7fb;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.container {
    width: 100%;
    max-width: 450px;
    background: white;
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.logo-section {
    text-align: center;
    margin-bottom: 25px;
}

.logo-section img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin-bottom: 10px;
}

.logo-section h3 {
    font-size: 14px;
    color: #27ae60;
    font-weight: 600;
}

h2 {
    text-align: center;
    color: #2c3e50;
    font-size: 22px;
    margin-bottom: 25px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #666;
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

.form-group input {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    color: #333;
    outline: none;
    transition: border 0.3s;
}

.form-group input:focus {
    border-color: #27ae60;
    box-shadow: 0 0 0 3px rgba(39,174,96,0.15);
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

button {
    width: 100%;
    padding: 12px;
    background: #27ae60;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 10px;
    transition: background 0.3s;
}

button:hover { background: #219150; }

.login-link {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #27ae60;
    text-decoration: none;
    font-size: 14px;
}

.login-link:hover { text-decoration: underline; }
</style>
</head>
<body>

<div class="container">

    <div class="logo-section">
        <img src="logo.png" alt="Logo">
        <h3>ST.JOSEPH'S COLLEGE (ARTS AND SCIENCE)</h3>
    </div>

    <h2>Student Registration</h2>

    <form method="POST">

        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" placeholder="e.g. John Smith" required>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="e.g. john@email.com" required>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" placeholder="9876543210" required>
            </div>
            <div class="form-group">
                <label>Roll Number</label>
                <input type="text" name="roll_no" placeholder="CS2024001" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Department</label>
                <input type="text" name="department" placeholder="e.g. CS" required>
            </div>
            <div class="form-group">
                <label>CGPA</label>
                <input type="text" name="cgpa" placeholder="e.g. 8.5" required>
            </div>
        </div>

        <div class="form-group">
            <label>Skills</label>
            <input type="text" name="skills" placeholder="e.g. PHP, MySQL, HTML" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Create a password" required>
        </div>

        <button type="submit" name="register">Register</button>

    </form>

    <a href="student_login.php" class="login-link">Already have an account? Login</a>

</div>

</body>
</html>