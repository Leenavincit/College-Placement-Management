<?php
session_start();
include("database.php");

if(!isset($_SESSION['student_id'])){
    header("Location: student_login.php");
    exit();
}

$id = $_SESSION['student_id'];
$error = ""; $success = "";

if(isset($_POST['change'])){
    $current  = $_POST['current_password'];
    $new      = $_POST['new_password'];
    $confirm  = $_POST['confirm_password'];

    $result = mysqli_query($conn, "SELECT * FROM students WHERE id='$id'");
    $row    = mysqli_fetch_assoc($result);

    if($current != $row['password']){
        $error = "Current password is incorrect!";
    } elseif($new != $confirm){
        $error = "New passwords do not match!";
    } elseif(strlen($new) < 4){
        $error = "Password must be at least 4 characters!";
    } else {
        mysqli_query($conn, "UPDATE students SET password='$new' WHERE id='$id'");
        $success = "Password changed successfully!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Change Password</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }
body { background:#f5f7fb; min-height:100vh; display:flex; flex-direction:column; }

.header {
    background: linear-gradient(to right, #2ecc71, #27ae60);
    padding: 18px 30px;
    display: flex; justify-content: space-between; align-items: center;
}
.header .left { display:flex; align-items:center; gap:14px; }
.header .left img { width:55px; height:55px; border-radius:50%; border:2px solid white; }
.header .left h2 { color:white; font-size:20px; font-weight:700; }
.header .left p  { color:#d5f5e3; font-size:13px; }
.back-btn { background:white; color:#27ae60; padding:8px 18px; border-radius:6px; text-decoration:none; font-weight:700; }

.page-content { display:flex; justify-content:center; padding:40px 20px; flex:1; }

.form-card {
    background:white; width:100%; max-width:480px;
    padding:35px; border-radius:12px;
    box-shadow:0 4px 20px rgba(0,0,0,0.1);
}

.form-card h2 { font-size:22px; color:#2c3e50; margin-bottom:25px; padding-bottom:15px; border-bottom:1px solid #f0f0f0; }

.form-group { margin-bottom:18px; }
.form-group label { display:block; font-size:12px; font-weight:600; color:#666; margin-bottom:6px; text-transform:uppercase; }
.form-group input {
    width:100%; padding:10px 14px;
    border:1px solid #ddd; border-radius:8px;
    font-size:14px; outline:none;
}
.form-group input:focus { border-color:#27ae60; box-shadow:0 0 0 3px rgba(39,174,96,0.15); }

.alert { padding:12px 15px; border-radius:8px; margin-bottom:18px; font-size:14px; font-weight:500; }
.alert-error   { background:#f8d7da; color:#721c24; }
.alert-success { background:#d4edda; color:#155724; }

.btn-submit {
    width:100%; padding:12px;
    background:#27ae60; color:white;
    border:none; border-radius:8px;
    font-size:15px; font-weight:600; cursor:pointer;
}
.btn-submit:hover { background:#219150; }

footer { background:linear-gradient(to right,#2ecc71,#27ae60); color:white; text-align:center; padding:16px; font-size:14px; margin-top:auto; }
</style>
</head>
<body>

<div class="header">
    <div class="left">
        <img src="logo.png">
        <div>
            <h2>Student Portal</h2>
            <p>Change Password</p>
        </div>
    </div>
    <a href="student_dashboard.php" class="back-btn">← Back</a>
</div>

<div class="page-content">
    <div class="form-card">
        <h2>🔒 Change Password</h2>

        <?php if($error)   echo "<div class='alert alert-error'>❌ $error</div>"; ?>
        <?php if($success) echo "<div class='alert alert-success'>✅ $success</div>"; ?>

        <form method="POST">
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" placeholder="Enter current password" required>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" placeholder="Enter new password" required>
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm new password" required>
            </div>
            <button type="submit" name="change" class="btn-submit">🔒 Change Password</button>
        </form>
    </div>
</div>

<footer>© St.Joseph's College (Arts & Science), 2026. All Rights Reserved.</footer>
</body>
</html>