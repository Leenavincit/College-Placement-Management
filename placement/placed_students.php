<?php
session_start();
include("database.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM students WHERE status='Placed'");
?>
<!DOCTYPE html>
<html>
<head>
<title>Placed Students</title>
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
    margin-bottom: 20px;
}

.top-bar h1 {
    font-size: 26px;
    font-weight: 700;
    color: #2c3e50;
}

.total-badge {
    background: #d4edda;
    color: #155724;
    padding: 8px 18px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

/* ── SEARCH ── */
.search-box {
    width: 100%;
    padding: 12px 16px;
    margin-bottom: 20px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 14px;
    outline: none;
    transition: border 0.3s;
}

.search-box:focus {
    border-color: #1a73e8;
    box-shadow: 0 0 0 3px rgba(26,115,232,0.15);
}

/* ── TABLE ── */
.table-wrap {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
    overflow: hidden;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead th {
    background: #f8f9fc;
    padding: 14px 16px;
    text-align: left;
    font-size: 13px;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    border-bottom: 1px solid #eee;
}

tbody td {
    padding: 14px 16px;
    font-size: 14px;
    color: #333;
    border-bottom: 1px solid #f5f5f5;
    vertical-align: middle;
}

tbody tr:last-child td {
    border-bottom: none;
}

tbody tr:hover td {
    background: #fafbff;
}

/* ── STATUS BADGE ── */
.badge-placed {
    background: #d4edda;
    color: #155724;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

/* ── NO DATA ── */
.no-data {
    text-align: center;
    color: #888;
    padding: 40px;
    font-size: 15px;
}
</style>

<script>
function searchStudents(){
    let input = document.getElementById('searchInput').value.toLowerCase();
    let rows = document.querySelectorAll('#placedTable tbody tr');
    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
    });
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
    <a href="jobs.php">Post Job</a>
    <a href="active_drives.php">Active Drives</a>
    <a href="placed_students.php" class="active">Placed Students</a>
    <a href="report.php">Reports</a>
</div>

<!-- CONTAINER -->
<div class="container">

    <!-- TOP BAR -->
    <div class="top-bar">
        <h1>🎓 Placed Students</h1>
        <span class="total-badge">
            ✅ Total Placed: <?php echo mysqli_num_rows($result); ?>
        </span>
    </div>

    <!-- SEARCH -->
    <input type="text" id="searchInput" class="search-box"
           placeholder="🔍 Search by name, email, company..."
           onkeyup="searchStudents()">

    <!-- TABLE -->
    <div class="table-wrap">
        <table id="placedTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>CGPA</th>
                    <th>Company</th>
                    <th>Placed Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0){ ?>
                    <?php while($row = mysqli_fetch_assoc($result)){ ?>
                    <tr>
                        <td><strong><?php echo $row['name']; ?></strong></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['department']; ?></td>
                        <td><?php echo $row['cgpa']; ?></td>
                        <td><?php echo $row['company']; ?></td>
                        <td><?php echo $row['placed_date']; ?></td>
                        <td><span class="badge-placed">✅ Placed</span></td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="7" class="no-data">
                            No placed students found.
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>