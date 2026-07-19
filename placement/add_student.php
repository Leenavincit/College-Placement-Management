<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("database.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

if(isset($_POST['submit'])){
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $dept     = $_POST['department'];
    $cgpa     = $_POST['cgpa'];
    $phone    = $_POST['phone'];
    $roll_no  = $_POST['roll_no'];
    $year     = $_POST['year'];
    $skills   = $_POST['skills'];
    $password = "123";
    $status   = "Not Placed";

    $sql = "INSERT INTO students 
            (name, email, department, cgpa, phone, roll_no, year, skills, status, password)
            VALUES 
            ('$name','$email','$dept','$cgpa','$phone','$roll_no','$year','$skills','$status','$password')";

    $result = mysqli_query($conn, $sql);

    if($result){
        echo "<script>alert('Student Added Successfully!'); window.location='view_student.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: #f0f2f5;
    min-height: 100vh;
}

/* ── TOPBAR ── */
.topbar {
    background: #1a73e8;
    padding: 14px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.topbar .left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.topbar .logo {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    border: 2px solid white;
    object-fit: cover;
}

.topbar .left h2 {
    color: white;
    font-size: 18px;
    font-weight: 700;
}

.topbar .left p {
    color: #d0e8ff;
    font-size: 13px;
    margin-top: 2px;
}

.logout {
    background: white;
    color: #1a73e8;
    padding: 8px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
}

.logout:hover { background: #f0f0f0; }

/* ── MENU ── */
.menu {
    background: white;
    border-bottom: 1px solid #e0e0e0;
    padding: 0 30px;
    display: flex;
    gap: 5px;
}

.menu a {
    text-decoration: none;
    color: #555;
    font-size: 14px;
    font-weight: 500;
    padding: 14px 14px;
    border-bottom: 3px solid transparent;
    transition: all 0.2s;
    display: inline-block;
}

.menu a:hover { color: #1a73e8; }

.menu a.active {
    color: #1a73e8;
    border-bottom: 3px solid #1a73e8;
    font-weight: 600;
}

/* ── PAGE CONTENT ── */
.page-content {
    display: flex;
    justify-content: center;
    padding: 40px 20px;
}

/* ── FORM CARD ── */
.form-card {
    background: white;
    width: 100%;
    max-width: 600px;
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.form-card h2 {
    font-size: 22px;
    color: #2c3e50;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-card h2 i {
    color: #1a73e8;
}

/* ── FORM GRID ── */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

.full {
    grid-column: span 2;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 12px;
    font-weight: 600;
    color: #666;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

.form-group input,
.form-group select {
    padding: 10px 14px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    color: #333;
    outline: none;
    transition: border 0.3s;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #1a73e8;
    box-shadow: 0 0 0 3px rgba(26,115,232,0.15);
}

/* ── NOTE ── */
.note {
    margin-top: 18px;
    padding: 12px 15px;
    background: #fff3cd;
    border-radius: 8px;
    font-size: 13px;
    color: #856404;
    border-left: 4px solid #ffc107;
}

/* ── BUTTONS ── */
.btn-row {
    display: flex;
    gap: 12px;
    margin-top: 20px;
}

.btn-submit {
    flex: 1;
    padding: 12px;
    background: #1a73e8;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-submit:hover { background: #1558b0; }

.btn-back {
    flex: 1;
    padding: 12px;
    background: #f0f2f5;
    color: #444;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s;
}

.btn-back:hover { background: #e0e2e5; }
</style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
    <div class="left">
        <img src="logo.png" class="logo">
        <div>
            <h2>ST.JOSEPH'S COLLEGE (ARTS AND SCIENCE)</h2>
            <p>Welcome, <?php echo $_SESSION['admin']; ?></p>
        </div>
    </div>
    <a href="logout.php" class="logout">Logout</a>
</div>

<!-- MENU -->
<div class="menu">
    <a href="admin_dashboard.php">Overview</a>
    <a href="view_student.php" class="active">Students</a>
    <a href="view_company.php">Companies</a>
    <a href="jobs.php">Job Postings</a>
    <a href="active_drives.php">Active Drives</a>
    <a href="placed_students.php">Placed Students</a>
    <a href="report.php">Reports</a>
</div>

<!-- FORM -->
<div class="page-content">
    <div class="form-card">

        <h2><i class="fa fa-user-plus"></i> Add New Student</h2>

        <form method="POST">
            <div class="form-grid">

                <div class="form-group full">
                    <label>Full Name</label>
                    <input type="text" name="name" 
                           placeholder="e.g. John Smith" required>
                </div>

                <div class="form-group full">
                    <label>Email Address</label>
                    <input type="email" name="email" 
                           placeholder="e.g. john@email.com" required>
                </div>

                <div class="form-group">
                    <label>Roll Number</label>
                    <input type="text" name="roll_no" 
                           placeholder="e.g. CS2024001" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" 
                           placeholder="e.g. 9876543210" required>
                </div>

                <div class="form-group">
                    <label>Department</label>
                    <input type="text" name="department" 
                           placeholder="e.g. Computer Science" required>
                </div>

                <div class="form-group">
                    <label>Year</label>
                    <select name="year">
                        <option value="1st Year">1st Year</option>
                        <option value="2nd Year">2nd Year</option>
                        <option value="3rd Year">3rd Year</option>
                        <option value="Final Year" selected>Final Year</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>CGPA</label>
                    <input type="number" step="0.01" 
                           min="0" max="10" name="cgpa" 
                           placeholder="e.g. 8.5" required>
                </div>

                <div class="form-group">
                    <label>Skills</label>
                    <input type="text" name="skills" 
                           placeholder="e.g. PHP, MySQL, HTML">
                </div>

            </div>

            <div class="note">
                ℹ️ Default password will be set to <strong>123</strong>. 
                Student can change it after login.
            </div>

            <div class="btn-row">
                <a href="view_student.php" class="btn-back">← Back</a>
                <button type="submit" name="submit" class="btn-submit">
                    <i class="fa fa-plus"></i> Add Student
                </button>
            </div>

        </form>
    </div>
</div>

</body>
</html>