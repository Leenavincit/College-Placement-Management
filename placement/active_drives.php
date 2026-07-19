<?php
session_start();
include("database.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$result = mysqli_query($conn, "
    SELECT jobs.id, jobs.job_role, jobs.salary, jobs.description,
           jobs.location, jobs.cgpa, jobs.skills,
           companies.name AS company_name
    FROM jobs
    JOIN companies ON jobs.company_id = companies.id
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Active Drives</title>
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
}

/* ── TOP BAR ── */
.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.top-bar h1 {
    font-size: 26px;
    font-weight: 700;
    color: #2c3e50;
}

.total-badge {
    background: #e8f0fe;
    color: #1a73e8;
    padding: 8px 18px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

/* ── GRID ── */
.drives-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
}

/* ── CARD ── */
.drive-card {
    background: white;
    padding: 22px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
}

.drive-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

/* ── CARD HEADER ── */
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
}

.card-header h3 {
    font-size: 17px;
    color: #2c3e50;
    font-weight: 700;
}

.badge-active {
    background: #d4edda;
    color: #155724;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

/* ── CARD INFO ── */
.card-info {
    margin-bottom: 14px;
}

.card-info p {
    font-size: 13px;
    color: #666;
    margin-bottom: 7px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.card-info p strong {
    color: #444;
}

/* ── DESCRIPTION ── */
.card-desc {
    font-size: 13px;
    color: #777;
    line-height: 1.6;
    margin-bottom: 14px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* ── SKILLS ── */
.card-skills {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 16px;
}

.skill-tag {
    background: #eef2ff;
    color: #3949ab;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 500;
}

/* ── ACTION BUTTONS ── */
.action-btns {
    display: flex;
    gap: 10px;
}

.edit-btn {
    flex: 1;
    text-align: center;
    padding: 8px;
    background: #fff3cd;
    color: #856404;
    border-radius: 7px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: background 0.2s;
}

.edit-btn:hover { background: #ffeeba; }

.delete-btn {
    flex: 1;
    text-align: center;
    padding: 8px;
    background: #f8d7da;
    color: #721c24;
    border-radius: 7px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: background 0.2s;
}

.delete-btn:hover { background: #f5c6cb; }

/* ── NO DATA ── */
.no-data {
    text-align: center;
    color: #888;
    padding: 60px;
    background: white;
    border-radius: 12px;
    font-size: 15px;
    grid-column: 1 / -1;
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
    <a href="admin_dashboard.php">Overview</a>
    <a href="view_student.php">Students</a>
    <a href="view_company.php">Companies</a>
    <a href="jobs.php">Post Job</a>
    <a href="active_drives.php" class="active">Active Drives</a>
    <a href="placed_students.php">Placed Students</a>
    <a href="report.php">Reports</a>
</div>

<!-- CONTAINER -->
<div class="container">

    <div class="top-bar">
        <h1>🚀 Active Drives</h1>
        <span class="total-badge">
            Total: <?php echo mysqli_num_rows($result); ?> Jobs
        </span>
    </div>

    <div class="drives-grid">

        <?php if(mysqli_num_rows($result) > 0){ ?>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="drive-card">

                <!-- HEADER -->
                <div class="card-header">
                    <h3><?php echo $row['job_role']; ?></h3>
                    <span class="badge-active">Active</span>
                </div>

                <!-- INFO -->
                <div class="card-info">
                    <p>🏢 <strong><?php echo $row['company_name']; ?></strong></p>
                    <p>💰 ₹<?php echo $row['salary']; ?></p>
                    <p>📍 <?php echo $row['location']; ?></p>
                    <p>🎓 Min CGPA: <?php echo $row['cgpa']; ?></p>
                </div>

                <!-- DESCRIPTION -->
                <p class="card-desc"><?php echo $row['description']; ?></p>

                <!-- SKILLS -->
                <?php if(!empty($row['skills'])){ ?>
                <div class="card-skills">
                    <?php
                    $skills = explode(",", $row['skills']);
                    foreach($skills as $skill){
                        echo "<span class='skill-tag'>" . trim($skill) . "</span>";
                    }
                    ?>
                </div>
                <?php } ?>

                <!-- ACTIONS -->
                <div class="action-btns">
                    <a href="edit_job.php?id=<?php echo $row['id']; ?>"
                       class="edit-btn">✏️ Edit</a>
                    <a href="delete_job.php?id=<?php echo $row['id']; ?>"
                       class="delete-btn"
                       onclick="return confirm('Are you sure to delete this job?')">
                       🗑️ Delete
                    </a>
                </div>

            </div>
            <?php } ?>

        <?php } else { ?>
            <div class="no-data">No active drives found.</div>
        <?php } ?>

    </div>
</div>

</body>
</html>