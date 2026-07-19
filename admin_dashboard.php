<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
include("database.php");

// COUNTS
$students = mysqli_query($conn, "SELECT COUNT(*) AS total FROM students");
$students_count = mysqli_fetch_assoc($students)['total'];

$companies = mysqli_query($conn, "SELECT COUNT(*) AS total FROM companies");
$companies_count = mysqli_fetch_assoc($companies)['total'];

$jobs = mysqli_query($conn, "SELECT COUNT(*) AS total FROM jobs");
$jobs_count = mysqli_fetch_assoc($jobs)['total'];

$applications = mysqli_query($conn, "SELECT COUNT(*) AS total FROM applications");
$applications_count = mysqli_fetch_assoc($applications)['total'];

$placed_result = mysqli_query($conn, "SELECT * FROM students WHERE status='Placed'");
$placed_count = mysqli_num_rows($placed_result);

// RECENT APPLICATIONS
$recent = mysqli_query($conn, "
    SELECT students.name, jobs.job_role, applications.status 
    FROM applications
    JOIN students ON applications.student_id = students.id
    JOIN jobs ON applications.job_id = jobs.id
    ORDER BY applications.id DESC LIMIT 5
");

// TOP RECRUITERS
$top = mysqli_query($conn, "
    SELECT companies.name, COUNT(jobs.id) AS total_jobs 
    FROM companies
    LEFT JOIN jobs ON jobs.company_id = companies.id
    GROUP BY companies.id
    ORDER BY total_jobs DESC LIMIT 5
");
?>
<!DOCTYPE html>
<html>
<head>
<title>T&P Admin Dashboard</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: #f0f2f5;
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

.logout:hover {
    background: #f0f0f0;
}

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

.menu a:hover {
    color: #1a73e8;
}

.menu a.active {
    color: #1a73e8;
    border-bottom: 3px solid #1a73e8;
    font-weight: 600;
}

/* ── CONTAINER ── */
.container {
    max-width: 1100px;
    margin: 30px auto;
    padding: 0 20px;
}

.container h1 {
    font-size: 26px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 25px;
}

/* ── STAT CARDS ── */
.cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
    text-align: center;
}

.card h4 {
    font-size: 13px;
    color: #888;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
}

.card h2 {
    font-size: 38px;
    font-weight: 700;
    color: #1a73e8;
}

/* ── BOTTOM ROW ── */
.bottom {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.box {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
}

.box h3 {
    font-size: 17px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f0f0f0;
}

/* ── ITEM ROW ── */
.item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    background: #f8f9fc;
    border-radius: 8px;
    margin-bottom: 10px;
}

.item strong {
    font-size: 14px;
    color: #2c3e50;
}

.item span.role {
    font-size: 13px;
    color: #777;
}

/* ── STATUS BADGES ── */
.status {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.accepted { background: #d4edda; color: #155724; }
.pending  { background: #fff3cd; color: #856404; }
.rejected { background: #f8d7da; color: #721c24; }

/* ── TOP RECRUITER ITEM ── */
.recruiter-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    background: #f8f9fc;
    border-radius: 8px;
    margin-bottom: 10px;
}

.recruiter-item strong {
    font-size: 14px;
    color: #2c3e50;
}

.recruiter-item span {
    font-size: 13px;
    color: #1a73e8;
    font-weight: 600;
}
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
    <a class="active">Overview</a>
    <a href="view_student.php">Students</a>
    <a href="view_company.php">Companies</a>
    <a href="jobs.php">Post Job</a>
    <a href="active_drives.php">Active Drives</a>
    <a href="placed_students.php">Placed Students</a>
    <a href="report.php">Reports</a>
</div>

<!-- MAIN -->
<div class="container">

    <h1>Dashboard Overview</h1>

    <!-- STAT CARDS -->
    <div class="cards">
        <div class="card">
            <h4>Total Students</h4>
            <h2><?php echo $students_count; ?></h2>
        </div>
        <div class="card">
            <h4>Students Placed</h4>
            <h2><?php echo $placed_count; ?></h2>
        </div>
        <div class="card">
            <h4>Partner Companies</h4>
            <h2><?php echo $companies_count; ?></h2>
        </div>
        <div class="card">
            <h4>Active Jobs</h4>
            <h2><?php echo $jobs_count; ?></h2>
        </div>
    </div>

    <!-- BOTTOM -->
    <div class="bottom">

        <!-- RECENT APPLICATIONS -->
        <div class="box">
            <h3>Recent Applications</h3>
            <?php while($row = mysqli_fetch_assoc($recent)) { ?>
            <div class="item">
                <div>
                    <strong><?php echo $row['name']; ?></strong>
                    <br>
                    <span class="role"><?php echo $row['job_role']; ?></span>
                </div>
                <span class="status
                    <?php
                    if($row['status'] == 'Accepted') echo 'accepted';
                    elseif($row['status'] == 'Rejected') echo 'rejected';
                    else echo 'pending';
                    ?>">
                    <?php echo $row['status']; ?>
                </span>
            </div>
            <?php } ?>
        </div>

        <!-- TOP RECRUITERS -->
        <div class="box">
            <h3>Top Recruiters</h3>
            <?php while($row = mysqli_fetch_assoc($top)) { ?>
            <div class="recruiter-item">
                <strong><?php echo $row['name']; ?></strong>
                <span><?php echo $row['total_jobs']; ?> jobs</span>
            </div>
            <?php } ?>
        </div>

    </div>

</div>

</body>
</html>