<?php
session_start();
include "database.php";

if(!isset($_SESSION['company_id'])){
    header("Location: company_login.php");
    exit();
}

$company_id = $_SESSION['company_id'];
$jobs = mysqli_query($conn, "SELECT * FROM jobs WHERE company_id='$company_id'");

$company = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM companies WHERE id='$company_id'"
));
?>
<!DOCTYPE html>
<html>
<head>
<title>Job Postings</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: #f5f6fa;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* ── TOPBAR ── */
.topbar {
    background: linear-gradient(to right, #7c3aed, #a855f7);
    padding: 18px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.topbar .left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.topbar .logo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 2px solid white;
    object-fit: cover;
}

.topbar .left h2 {
    color: white;
    font-size: 20px;
    font-weight: 700;
}

.topbar .left p {
    color: #e9d5ff;
    font-size: 14px;
    margin-top: 3px;
}

.logout {
    background: white;
    color: #7c3aed;
    padding: 8px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
    border: 2px solid white;
}

.logout:hover { background: #f0f0f0; }

/* ── NAV ── */
.nav {
    background: white;
    border-bottom: 1px solid #e0e0e0;
    padding: 0 30px;
    display: flex;
    gap: 5px;
}

.nav a {
    text-decoration: none;
    color: #555;
    font-size: 14px;
    font-weight: 500;
    padding: 14px 14px;
    border-bottom: 3px solid transparent;
    transition: all 0.2s;
    display: inline-block;
}

.nav a:hover { color: #7c3aed; }

.nav a.active {
    color: #7c3aed;
    border-bottom: 3px solid #7c3aed;
    font-weight: 600;
}

/* ── CONTAINER ── */
.container {
    max-width: 900px;
    margin: 30px auto;
    padding: 0 20px;
    flex: 1;
    width: 100%;
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.page-title {
    font-size: 26px;
    font-weight: 700;
    color: #2c3e50;
}

.btn-primary {
    background: linear-gradient(to right, #7c3aed, #a855f7);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    display: inline-block;
}

.btn-primary:hover { opacity: 0.9; }

/* ── JOB CARD ── */
.job-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
}

.job-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.job-header h2 {
    font-size: 20px;
    color: #2c3e50;
    font-weight: 700;
}

.badge-active {
    background: #d4edda;
    color: #155724;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

.job-desc {
    color: #666;
    font-size: 14px;
    margin-bottom: 12px;
    line-height: 1.6;
}

.job-info {
    display: flex;
    gap: 20px;
    margin-bottom: 12px;
}

.job-info span {
    color: #555;
    font-size: 14px;
    font-weight: 500;
}

.skills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 15px;
}

.skill-tag {
    background: #eef2ff;
    color: #3949ab;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
}

.job-stats {
    display: flex;
    gap: 20px;
    margin-bottom: 18px;
    padding: 12px 15px;
    background: #f8f9fc;
    border-radius: 8px;
}

.job-stats span {
    font-size: 14px;
    color: #444;
    font-weight: 600;
}

.job-actions {
    display: flex;
    gap: 10px;
}

.btn-view {
    background: #2d6cdf;
    color: white;
    padding: 8px 18px;
    border-radius: 7px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
}

.btn-view:hover { background: #1a4fb5; }

.btn-edit {
    background: #fff3cd;
    color: #856404;
    padding: 8px 18px;
    border-radius: 7px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
}

.btn-edit:hover { background: #ffeeba; }

.btn-delete {
    background: #f8d7da;
    color: #721c24;
    padding: 8px 18px;
    border-radius: 7px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
}

.btn-delete:hover { background: #f5c6cb; }

.no-jobs {
    text-align: center;
    color: #888;
    font-size: 16px;
    padding: 40px;
    background: white;
    border-radius: 12px;
}

/* ── FOOTER ── */
footer {
    background: linear-gradient(to right, #7c3aed, #a855f7);
    color: white;
    text-align: center;
    padding: 16px;
    font-size: 14px;
    margin-top: auto;
}
</style>
</head>
<body>

<!-- TOPBAR -->
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

<!-- NAV -->
<div class="nav">
    <a href="company_dashboard.php">Overview</a>
    <a href="job_postings.php" class="active">Job Postings</a>
    <a href="applicants.php">Applicants</a>
</div>

<!-- CONTAINER -->
<div class="container">
    <div class="top-bar">
        <h1 class="page-title">Job Postings</h1>
        <a href="post_job.php" class="btn-primary">+ Post New Job</a>
    </div>

    <?php if(mysqli_num_rows($jobs) > 0){ ?>
        <?php while($row = mysqli_fetch_assoc($jobs)) {
            $app_count = mysqli_num_rows(mysqli_query($conn,
                "SELECT * FROM applications WHERE job_id='".$row['id']."'"));
            $short_count = mysqli_num_rows(mysqli_query($conn,
                "SELECT * FROM applications WHERE job_id='".$row['id']."' AND status='Accepted'"));
        ?>
        <div class="job-card">
            <div class="job-header">
                <h2><?php echo $row['job_role']; ?></h2>
                <span class="badge-active">Active</span>
            </div>
            <p class="job-desc"><?php echo $row['description']; ?></p>
            <div class="job-info">
                <span>📍 <?php echo $row['location']; ?></span>
                <span>💰 ₹<?php echo $row['salary']; ?></span>
                <span>🎓 CGPA: <?php echo $row['cgpa']; ?></span>
            </div>
            <div class="skills">
                <?php
                $skills = explode(",", $row['skills']);
                foreach($skills as $skill){ ?>
                    <span class="skill-tag"><?php echo trim($skill); ?></span>
                <?php } ?>
            </div>
            <div class="job-stats">
                <span>📋 Applications: <?php echo $app_count; ?></span>
                <span>✅ Shortlisted: <?php echo $short_count; ?></span>
            </div>
            <div class="job-actions">
                <a href="applicants.php?job_id=<?php echo $row['id']; ?>"
                   class="btn-view">👁️ View</a>
                <a href="edit_job_company.php?id=<?php echo $row['id']; ?>"
                   class="btn-edit">✏️ Edit</a>
                <a href="delete_job.php?id=<?php echo $row['id']; ?>"
                   class="btn-delete"
                   onclick="return confirm('Are you sure?')">🗑️ Delete</a>
            </div>
        </div>
        <?php } ?>
    <?php } else { ?>
        <p class="no-jobs">No job postings found.</p>
    <?php } ?>
</div>



</body>
</html>