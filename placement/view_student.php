<?php
session_start();
include("database.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM students");
?>
<!DOCTYPE html>
<html>
<head>
<title>Student Management</title>
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

.top-bar h2 {
    font-size: 24px;
    font-weight: 700;
    color: #2c3e50;
}

.add-btn {
    background: #1a73e8;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
}

.add-btn:hover { background: #1558b0; }

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

th {
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

td {
    padding: 14px 16px;
    font-size: 14px;
    color: #333;
    border-bottom: 1px solid #f5f5f5;
    vertical-align: middle;
}

tr:last-child td {
    border-bottom: none;
}

tr:hover td {
    background: #fafbff;
}

/* ── STATUS BADGES ── */
.badge-placed {
    background: #d4edda;
    color: #155724;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-not {
    background: #f0f0f0;
    color: #555;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

/* ── COMPANY SELECT + MARK ── */
.place-form {
    display: flex;
    align-items: center;
    gap: 8px;
}

.company-select {
    padding: 6px 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 13px;
    outline: none;
    color: #333;
}

.company-select:focus {
    border-color: #1a73e8;
}

.mark-btn {
    background: #27ae60;
    color: white;
    border: none;
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
}

.mark-btn:hover { background: #219150; }

/* ── ACTION LINKS ── */
.action-links a {
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    padding: 5px 12px;
    border-radius: 6px;
}

.edit-link {
    background: #fff3cd;
    color: #856404;
}

.edit-link:hover { background: #ffeeba; }

.delete-link {
    background: #f8d7da;
    color: #721c24;
}

.delete-link:hover { background: #f5c6cb; }

/* ── NO DATA ── */
.no-data {
    text-align: center;
    padding: 40px;
    color: #888;
    font-size: 15px;
}
</style>

<script>
// Live search
function searchStudents(){
    let input = document.getElementById('searchInput').value.toLowerCase();
    let rows = document.querySelectorAll('#studentTable tbody tr');
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
    <a href="view_student.php" class="active">Students</a>
    <a href="view_company.php">Companies</a>
    <a href="jobs.php">Post Job</a>
    <a href="active_drives.php">Active Drives</a>
    <a href="placed_students.php">Placed Students</a>
    <a href="report.php">Reports</a>
</div>

<!-- CONTAINER -->
<div class="container">

    <!-- TOP BAR -->
    <div class="top-bar">
        <h2>Student Management</h2>
        <a href="add_student.php" class="add-btn">+ Add Student</a>
    </div>

    <!-- SEARCH -->
    <input type="text" id="searchInput" class="search-box"
           placeholder="🔍 Search students by name, email, department..."
           onkeyup="searchStudents()">

    <!-- TABLE -->
    <div class="table-wrap">
        <table id="studentTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>CGPA</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if(mysqli_num_rows($result) > 0){ ?>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><strong><?php echo $row['name']; ?></strong></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['department']; ?></td>
                    <td><?php echo $row['cgpa']; ?></td>

                    <td>
                        <?php if($row['status'] != 'Placed'){ ?>
                        <form method="POST" action="marked_placed.php" class="place-form">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <select name="company" class="company-select" required>
                                <option value="">Select Company</option>
                                <?php
                                $company_result = mysqli_query($conn, "SELECT * FROM companies");
                                while($company = mysqli_fetch_assoc($company_result)){
                                ?>
                                <option value="<?php echo $company['name']; ?>">
                                    <?php echo $company['name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                            <button type="submit" class="mark-btn">✔ Mark</button>
                        </form>
                        <?php } else { ?>
                            <span class="badge-placed">✅ Placed</span>
                        <?php } ?>
                    </td>

                    <td class="action-links">
                        <a href="edit_student.php?id=<?php echo $row['id']; ?>" 
                           class="edit-link">✏️ Edit</a>
                        &nbsp;
                        <a href="delete_student.php?id=<?php echo $row['id']; ?>"
                           class="delete-link"
                           onclick="return confirm('Are you sure to delete this student?')">
                           🗑️ Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6" class="no-data">No students found.</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>
<!-- BREADCRUMB BACK BUTTON -->
<div style="max-width:1100px; margin:20px auto; padding:0 20px;">
    <a href="admin_dashboard.php" 
       style="background:#f0f2f5; color:#444; padding:8px 18px; 
              border-radius:8px; text-decoration:none; font-size:14px; 
              font-weight:600;">
        ← Back to Dashboard
    </a>
</div>
</body>
</html>