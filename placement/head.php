<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// Fetch company name from DB using company_id
include_once "database.php";
$company_data = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM companies WHERE id='".$_SESSION['company_id']."'"
));
?>
<!DOCTYPE html>
<html>
<head>
<title>Company Portal</title>
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

.top-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.logo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 2px solid white;
    object-fit: cover;
}

.topbar h2 {
    color: white;
    font-size: 20px;
    font-weight: 700;
}

.topbar p {
    color: #e9d5ff;
    font-size: 14px;
    margin-top: 3px;
}

.logout-btn {
    background: white;
    color: #7c3aed;
    padding: 8px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
}

.logout-btn:hover { background: #f0f0f0; }

/* ── NAV ── */
.nav-links {
    background: white;
    border-bottom: 1px solid #e0e0e0;
    padding: 0 30px;
    display: flex;
    gap: 5px;
}

.nav-links a {
    text-decoration: none;
    color: #555;
    font-size: 14px;
    font-weight: 500;
    padding: 14px 14px;
    border-bottom: 3px solid transparent;
    transition: all 0.2s;
    display: inline-block;
}

.nav-links a:hover { color: #7c3aed; }

.nav-links a.active {
    color: #7c3aed;
    border-bottom: 3px solid #7c3aed;
    font-weight: 600;
}
</style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
    <div class="top-left">
        <img src="logo.png" class="logo">
        <div>
            <h2>Company Portal</h2>
            <p>Welcome, <?php echo $company_data['name']; ?></p>
        </div>
    </div>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<!-- NAV -->
<div class="nav-links">
    <a href="company_dashboard.php"
       class="<?php if($page=='dashboard') echo 'active'; ?>">
       Overview
    </a>
    <a href="job_postings.php"
       class="<?php if($page=='jobs') echo 'active'; ?>">
       Job Postings
    </a>
    <a href="applicants.php"
       class="<?php if($page=='applicants') echo 'active'; ?>">
       Applicants
    </a>
</div>