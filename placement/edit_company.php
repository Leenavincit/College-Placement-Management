<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("database.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// ✅ Get company id from URL
$company_id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM companies WHERE id='$company_id'");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])) {
    $name     = $_POST['name'];
    $industry = $_POST['industry'];
    $location = $_POST['location'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];

    $query = "UPDATE companies 
              SET name='$name', industry='$industry', 
                  location='$location', email='$email', phone='$phone'
              WHERE id='$company_id'";

    $result = mysqli_query($conn, $query);

    if($result){
        echo "<script>alert('Company Updated Successfully!'); window.location='view_company.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Company</title>
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
    max-width: 550px;
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
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

.full { grid-column: span 2; }

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

.form-group input {
    padding: 10px 14px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    color: #333;
    outline: none;
    transition: border 0.3s;
}

.form-group input:focus {
    border-color: #1a73e8;
    box-shadow: 0 0 0 3px rgba(26,115,232,0.15);
}

.btn-row {
    display: flex;
    gap: 12px;
    margin-top: 25px;
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
    <a href="view_student.php">Students</a>
    <a href="view_company.php" class="active">Companies</a>
    <a href="jobs.php">Job Postings</a>
    <a href="active_drives.php">Active Drives</a>
    <a href="placed_students.php">Placed Students</a>
    <a href="report.php">Reports</a>
</div>

<!-- FORM -->
<div class="page-content">
    <div class="form-card">
        <h2>✏️ Edit Company</h2>

        <form method="POST">
            <div class="form-grid">

                <div class="form-group full">
                    <label>Company Name</label>
                    <input type="text" name="name"
                           value="<?php echo $row['name']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Industry</label>
                    <input type="text" name="industry"
                           value="<?php echo $row['industry']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location"
                           value="<?php echo $row['location']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email"
                           value="<?php echo $row['email']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone"
                           value="<?php echo $row['phone'] ?? ''; ?>">
                </div>

            </div>

            <div class="btn-row">
                <a href="view_company.php" class="btn-back">← Back</a>
                <button type="submit" name="update" class="btn-submit">
                    ✔ Update Company
                </button>
            </div>

        </form>
    </div>
</div>

</body>
</html>