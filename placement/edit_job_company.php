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
$id         = $_GET['id'];

$job = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM jobs WHERE id='$id' AND company_id='$company_id'"
));

if(isset($_POST['job_role'])){
    $job_role    = $_POST['job_role'];
    $salary      = $_POST['salary'];
    $description = $_POST['description'];
    $location    = $_POST['location'];
    $cgpa        = $_POST['cgpa'];
    $skills      = $_POST['skills'];

    $result = mysqli_query($conn, "
        UPDATE jobs SET
            job_role='$job_role',
            salary='$salary',
            description='$description',
            location='$location',
            cgpa='$cgpa',
            skills='$skills'
        WHERE id='$id' AND company_id='$company_id'
    ");

    if($result){
        echo "<script>alert('Job Updated Successfully!'); window.location='job_postings.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch company info for header
$company = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM companies WHERE id='$company_id'"
));
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Job</title>
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
}

/* ── TOPBAR ── */
.topbar {
    background: linear-gradient(to right, #7c3aed, #a855f7);
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
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid white;
    object-fit: cover;
}

.topbar .left h2 {
    color: white;
    font-size: 17px;
    font-weight: 700;
}

.topbar .left p {
    color: #e9d5ff;
    font-size: 13px;
    margin-top: 2px;
}

.logout {
    background: white;
    color: #7c3aed;
    padding: 8px 18px;
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
    max-width: 700px;
    padding: 35px;
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

.form-card h2 {
    font-size: 22px;
    color: #2c3e50;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0;
}

/* ── FORM GRID ── */
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

.form-group input,
.form-group textarea {
    padding: 10px 14px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    color: #333;
    outline: none;
    transition: border 0.3s;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124,58,237,0.15);
}

.form-group textarea {
    resize: vertical;
    height: 110px;
}

/* ── BUTTONS ── */
.btn-row {
    display: flex;
    gap: 12px;
    margin-top: 25px;
}

.btn-submit {
    flex: 1;
    padding: 12px;
    background: linear-gradient(to right, #7c3aed, #a855f7);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.3s;
}

.btn-submit:hover { opacity: 0.9; }

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

<!-- FORM -->
<div class="page-content">
    <div class="form-card">

        <h2>✏️ Edit Job</h2>

        <form method="POST">
            <div class="form-grid">

                <div class="form-group full">
                    <label>Job Title</label>
                    <input type="text" name="job_role"
                           value="<?php echo $job['job_role']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Package / Salary</label>
                    <input type="text" name="salary"
                           value="<?php echo $job['salary']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location"
                           value="<?php echo $job['location']; ?>">
                </div>

                <div class="form-group">
                    <label>Minimum CGPA</label>
                    <input type="text" name="cgpa"
                           value="<?php echo $job['cgpa']; ?>">
                </div>

                <div class="form-group">
                    <label>Required Skills</label>
                    <input type="text" name="skills"
                           value="<?php echo $job['skills']; ?>">
                </div>

                <div class="form-group full">
                    <label>Job Description</label>
                    <textarea name="description"><?php echo $job['description']; ?></textarea>
                </div>

            </div>

            <div class="btn-row">
                <a href="job_postings.php" class="btn-back">← Back</a>
                <button type="submit" name="update" class="btn-submit">
                    ✔ Update Job
                </button>
            </div>

        </form>
    </div>
</div>

</body>
</html>