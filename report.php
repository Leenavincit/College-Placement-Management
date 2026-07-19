<?php
session_start();
include "database.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$total_students     = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM students"));
$total_companies    = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM companies"));
$total_jobs         = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM jobs"));
$total_applications = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM applications"));
$placed_students    = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM students WHERE status='Placed'"));

$report = mysqli_query($conn, "
    SELECT students.name, jobs.job_role,
           companies.name AS company, applications.status
    FROM applications
    JOIN students  ON applications.student_id = students.id
    JOIN jobs      ON applications.job_id     = jobs.id
    JOIN companies ON jobs.company_id         = companies.id
    ORDER BY applications.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Reports</title>
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
    display: flex;
    flex-direction: column;
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

/* ── CONTAINER ── */
.container {
    max-width: 1100px;
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

/* ── STAT CARDS ── */
.cards {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
    margin-bottom: 30px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
}

.card p {
    font-size: 12px;
    color: #888;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
}

.card h2 {
    font-size: 32px;
    font-weight: 700;
    color: #1a73e8;
}

/* ── TABLE SECTION ── */
.table-section {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
    overflow: hidden;
    margin-bottom: 30px;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 25px;
    border-bottom: 1px solid #f0f0f0;
    flex-wrap: wrap;
    gap: 15px;
}

.table-header h3 {
    font-size: 18px;
    font-weight: 700;
    color: #2c3e50;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

/* ── SEARCH BOX ── */
.search-wrap {
    position: relative;
}

.search-wrap input {
    padding: 9px 16px 9px 38px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    width: 260px;
    transition: border 0.3s;
}

.search-wrap input:focus {
    border-color: #1a73e8;
    box-shadow: 0 0 0 3px rgba(26,115,232,0.15);
}

.search-wrap .search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #aaa;
    font-size: 15px;
}

.total-badge {
    background: #e8f0fe;
    color: #1a73e8;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
}

/* ── TABLE ── */
table {
    width: 100%;
    border-collapse: collapse;
}

thead th {
    background: #f8f9fc;
    padding: 14px 20px;
    text-align: left;
    font-size: 12px;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    border-bottom: 1px solid #eee;
}

tbody td {
    padding: 14px 20px;
    font-size: 14px;
    color: #333;
    border-bottom: 1px solid #f5f5f5;
}

tbody tr:last-child td {
    border-bottom: none;
}

tbody tr:hover td {
    background: #fafbff;
}

/* ── STATUS BADGES ── */
.badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.accepted { background: #d4edda; color: #155724; }
.pending  { background: #fff3cd; color: #856404; }
.rejected { background: #f8d7da; color: #721c24; }

/* ── NO DATA ── */
.no-data {
    text-align: center;
    padding: 40px;
    color: #888;
    font-size: 15px;
}

/* ── FOOTER ── */
footer {
    background: #1a73e8;
    color: white;
    text-align: center;
    padding: 16px;
    font-size: 14px;
    margin-top: auto;
}
</style>

<script>
function searchReport(){
    let input = document.getElementById('searchInput').value.toLowerCase();
    let rows  = document.querySelectorAll('#reportTable tbody tr');
    let count = 0;
    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        if(text.includes(input)){
            row.style.display = '';
            count++;
        } else {
            row.style.display = 'none';
        }
    });
    document.getElementById('resultCount').innerText = 'Total: ' + count + ' Applications';
}
</script>
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
    <a href="view_company.php">Companies</a>
    <a href="admin_job_postings.php">Job Postings</a>
    <a href="active_drives.php">Active Drives</a>
    <a href="placed_students.php">Placed Students</a>
    <a href="report.php" class="active">Reports</a>
</div>

<!-- CONTAINER -->
<div class="container">

    <h1 class="page-title">📊 Reports</h1>

    <!-- STAT CARDS -->
    <div class="cards">
        <div class="card">
            <p>Students</p>
            <h2><?php echo $total_students; ?></h2>
        </div>
        <div class="card">
            <p>Companies</p>
            <h2><?php echo $total_companies; ?></h2>
        </div>
        <div class="card">
            <p>Jobs</p>
            <h2><?php echo $total_jobs; ?></h2>
        </div>
        <div class="card">
            <p>Applications</p>
            <h2><?php echo $total_applications; ?></h2>
        </div>
        <div class="card">
            <p>Placed</p>
            <h2><?php echo $placed_students; ?></h2>
        </div>
    </div>

    <!-- TABLE SECTION -->
    <div class="table-section">

        <div class="table-header">
            <h3>Placement Report</h3>
            <div class="header-right">

                <!-- ✅ SEARCH BAR -->
                <div class="search-wrap">
                    <span class="search-icon">🔍</span>
                    <input type="text"
                           id="searchInput"
                           placeholder="Search student, job, company..."
                           onkeyup="searchReport()">
                </div>

                <span class="total-badge" id="resultCount">
                    Total: <?php echo mysqli_num_rows($report); ?> Applications
                </span>

            </div>
        </div>

        <table id="reportTable">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Job Role</th>
                    <th>Company</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($report) > 0){ ?>
                    <?php while($row = mysqli_fetch_assoc($report)) { ?>
                    <tr>
                        <td><strong><?php echo $row['name']; ?></strong></td>
                        <td><?php echo $row['job_role']; ?></td>
                        <td><?php echo $row['company']; ?></td>
                        <td>
                            <span class="badge <?php echo strtolower($row['status']); ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4" class="no-data">
                            No report data found.
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>

</div>


</body>
</html>