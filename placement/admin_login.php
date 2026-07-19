
<?php
session_start();
include "database.php";

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
 if(mysqli_num_rows($query) > 0){
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1f79ee, #2784f5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-card {
            background: #fff;
            padding: 40px;
            width: 350px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .logo {
            width: 70px;
            margin-bottom: 15px;
        }

        h2 {
            margin: 10px 0;
            color: #333;
        }

        p {
            color: #666;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        input:focus {
            border-color: #3b82f6;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #1e40af;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #3b82f6;
            font-size: 14px;
        }

        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="login-card">

    <!-- Logo -->
    <img src="logo.png" class="logo" alt="Logo">

    <h2>ST JOSEPH'S COLLEGE</h2>
    <p>Student Placement Tracking and Recruitment System</p>

    <!-- Error Message -->
    <?php if($error != ""){ ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <!-- Login Form -->
    <form method="POST">
        <input type="text" name="username" placeholder="Enter username" required>
        <input type="password" name="password" placeholder="Enter password" required>
        <button type="submit">Login</button>
    </form>

    <!-- Back Button -->
    <a href="index.php" class="back-btn">← Back to Portal</a>

</div>

</body>
</html>