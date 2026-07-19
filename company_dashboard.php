<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "database.php";

if(!isset($_SESSION['company_id'])){
    header("Location: company_login.php");
    exit();
}

$company_id = $_SESSION['company_id'];

$company = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM companies WHERE id='$company_id'"
));

$total_jobs = mysqli_num_rows(mysqli_query($conn,
    "SELECT * FROM jobs WHERE company_id='$company_id'"
));

$total_applications = mysqli_num_rows(mysqli_query($conn,
    "SELECT applications.* FROM applications 
     JOIN jobs ON applications.job_id = jobs.id 
     WHERE jobs.company_id='$company_id'"
));

$shortlisted = mysqli_num_rows(mysqli_query($conn,
    "SELECT applications.* FROM applications 
     JOIN jobs ON applications.job_id = jobs.id 
     WHERE jobs.company_id='$company_id' AND applications.status='Accepted'"
));
?>
<!DOCTYPE html>
<html>
<head>
<title>Company Dashboard</title>
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
    max-width: 950px;
    margin: 30px auto;
    padding: 0 20px;
    flex: 1;
    width: 100%;
}

.page-title {
    font-size: 26px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 25px;
}

/* ── STATS ROW ── */
.stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
}

.card h3 {
    font-size: 13px;
    color: #888;
    font-weight: 600;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.card p {
    font-size: 38px;
    font-weight: 700;
    color: #7c3aed;
}

/* ── PROFILE CARD ── */
.profile-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
    margin-bottom: 30px;
}

.profile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0;
}

.profile-header h2 {
    font-size: 20px;
    font-weight: 700;
    color: #2c3e50;
}

.btn-edit {
    background: linear-gradient(to right, #7c3aed, #a855f7);
    color: white;
    padding: 8px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
}

.btn-edit:hover { opacity: 0.9; }

/* ── PROFILE GRID ── */
.profile-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
}

.profile-grid label {
    display: block;
    font-size: 12px;
    color: #888;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
}

.profile-grid p {
    font-size: 16px;
    font-weight: 500;
    color: #2c3e50;
}

.badge-active {
    display: inline-block;
    background: #d4edda;
    color: #155724;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
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
    <a href="company_dashboard.php" class="active">Overview</a>
    <a href="job_postings.php">Job Postings</a>
    <a href="applicants.php">Applicants</a>
</div>

<!-- CONTAINER -->
<div class="container">

    <h1 class="page-title">Company Dashboard</h1>

    <!-- STATS -->
    <div class="stats">
        <div class="card">
            <h3>Active Jobs</h3>
            <p><?php echo $total_jobs; ?></p>
        </div>
        <div class="card">
            <h3>Total Applications</h3>
            <p><?php echo $total_applications; ?></p>
        </div>
        <div class="card">
            <h3>Shortlisted</h3>
            <p><?php echo $shortlisted; ?></p>
        </div>
    </div>

    <!-- COMPANY PROFILE -->
    <div class="profile-card">
        <div class="profile-header">
            <h2>Company Profile</h2>
            <a href="edit_company_profile.php" class="btn-edit">✏️ Edit Profile</a>
        </div>

        <div class="profile-grid">
            <div>
                <label>Company Name</label>
                <p><?php echo $company['name']; ?></p>
            </div>
            <div>
                <label>Email</label>
                <p><?php echo $company['email']; ?></p>
            </div>
            <div>
                <label>Location</label>
                <p><?php echo $company['location']; ?></p>
            </div>
            <div>
                <label>Industry</label>
                <p><?php echo $company['industry']; ?></p>
            </div>
            <div>
                <label>Phone</label>
                <p><?php echo $company['phone'] ?? 'Not available'; ?></p>
            </div>
            <div>
                <label>Status</label>
                <span class="badge-active">✅ Active</span>
            </div>
        </div>
    </div>

</div>



</body>
</html>