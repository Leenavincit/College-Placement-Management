<?php
session_start();
include("database.php");

if(!isset($_SESSION['company_id'])){
    header("Location: company_login.php");
    exit();
}

$company_id = $_SESSION['company_id'];
$company    = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM companies WHERE id='$company_id'"
));

$error = ""; $success = "";

if(isset($_POST['change'])){
    $current = $_POST['current_password'];
    $new     = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if($current != $company['password']){
        $error = "Current password is incorrect!";
    } elseif($new != $confirm){
        $error = "New passwords do not match!";
    } elseif(strlen($new) < 4){
        $error = "Password must be at least 4 characters!";
    } else {
        mysqli_query($conn, "UPDATE companies SET password='$new' WHERE id='$company_id'");
        $success = "Password changed successfully!";
        // Refresh company data
        $company = mysqli_fetch_assoc(mysqli_query($conn,
            "SELECT * FROM companies WHERE id='$company_id'"
        ));
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Change Password</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }
body { background:#f5f6fa; min-height:100vh; display:flex; flex-direction:column; }

.topbar {
    background:linear-gradient(to right,#7c3aed,#a855f7);
    padding:18px 30px; display:flex; justify-content:space-between; align-items:center;
}
.topbar .left { display:flex; align-items:center; gap:16px; }
.topbar .logo { width:60px; height:60px; border-radius:50%; border:2px solid white; object-fit:cover; }
.topbar .left h2 { color:white; font-size:20px; font-weight:700; }
.topbar .left p  { color:#e9d5ff; font-size:14px; margin-top:3px; }
.logout { background:white; color:#7c3aed; padding:8px 20px; border-radius:6px; text-decoration:none; font-weight:700; font-size:14px; }

.nav {
    background:white; border-bottom:1px solid #e0e0e0;
    padding:0 30px; display:flex; gap:5px;
}
.nav a {
    text-decoration:none; color:#555; font-size:14px; font-weight:500;
    padding:14px 14px; border-bottom:3px solid transparent; transition:all 0.2s; display:inline-block;
}
.nav a:hover { color:#7c3aed; }
.nav a.active { color:#7c3aed; border-bottom:3px solid #7c3aed; font-weight:600; }

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
    border:1px solid #ddd; border-radius:8px; font-size:14px; outline:none;
}
.form-group input:focus { border-color:#7c3aed; box-shadow:0 0 0 3px rgba(124,58,237,0.15); }

.alert { padding:12px 15px; border-radius:8px; margin-bottom:18px; font-size:14px; font-weight:500; }
.alert-error   { background:#f8d7da; color:#721c24; }
.alert-success { background:#d4edda; color:#155724; }

.btn-submit {
    width:100%; padding:12px;
    background:linear-gradient(to right,#7c3aed,#a855f7);
    color:white; border:none; border-radius:8px;
    font-size:15px; font-weight:600; cursor:pointer;
}
.btn-submit:hover { opacity:0.9; }

footer { background:linear-gradient(to right,#7c3aed,#a855f7); color:white; text-align:center; padding:16px; font-size:14px; margin-top:auto; }
</style>
</head>
<body>

<div class="topbar">
    <div class="left">
        <img src="logo.png" class="logo">
        <div>
            <h2>Company Portal</h2>
            <p>Welcome, <?php echo $company['name']; ?></p>
        </div>
    </div>
    <a href="logout.php" class="logout">Logout</a>
</div>

<div class="nav">
    <a href="company_dashboard.php" class="active">Overview</a>
    <a href="job_postings.php">Job Postings</a>
    <a href="applicants.php">Applicants</a>
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

        <div style="text-align:center; margin-top:15px;">
            <a href="company_dashboard.php" style="color:#7c3aed; font-size:14px;">← Back to Dashboard</a>
        </div>
    </div>
</div>

<footer>© St.Joseph's College (Arts & Science), 2026. All Rights Reserved.</footer>
</body>
</html>