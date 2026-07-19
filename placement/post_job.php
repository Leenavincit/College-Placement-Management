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

if(isset($_POST['job_role'])){
    $job_role    = $_POST['job_role'];
    $salary      = $_POST['salary'];
    $description = $_POST['description'];
    $location    = $_POST['location'];
    $cgpa        = $_POST['cgpa'];
    $skills      = $_POST['skills'];

    $stmt = mysqli_prepare($conn,
        "INSERT INTO jobs 
         (company_id, job_role, salary, description, location, cgpa, skills)
         VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "issssss",
        $company_id, $job_role, $salary,
        $description, $location, $cgpa, $skills);

    if(mysqli_stmt_execute($stmt)){
        echo "<script>alert('Job Posted Successfully!'); 
              window.location='job_postings.php';</script>";
        exit();
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Post New Job</title>
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

/* ── PAGE CONTENT ── */
.page-content {
    display: flex;
    justify-content: center;
    padding: 40px 20px;
    flex: 1;
}

/* ── FORM CARD — same max-width as admin ── */
.form-card {
    background: white;
    width: 100%;
    max-width: 900px;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.form-card h2 {
    font-size: 24px;
    color: #2c3e50;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ── FORM GRID ── */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px;
}

.full { grid-column: span 2; }

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 13px;
    font-weight: 600;
    color: #555;
    margin-bottom: 7px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 12px 16px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    color: #333;
    outline: none;
    transition: border 0.3s;
    background: white;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124,58,237,0.15);
}

.form-group textarea {
    resize: vertical;
    height: 120px;
}

/* ── BUTTONS ── */
.btn-row {
    display: flex;
    gap: 15px;
    margin-top: 30px;
}

.btn-submit {
    flex: 1;
    padding: 13px;
    background: linear-gradient(to right, #7c3aed, #a855f7);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.3s;
}

.btn-submit:hover { opacity: 0.9; }

.btn-back {
    flex: 1;
    padding: 13px;
    background: #f0f2f5;
    color: #444;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s;
}

.btn-back:hover { background: #e0e2e5; }

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

<!-- FORM -->
<div class="page-content">
    <div class="form-card">

        <h2>📋 Post New Job</h2>

        <form method="POST">
            <div class="form-grid">

                <div class="form-group">
                    <label>Job Title</label>
                    <input type="text" name="job_role"
                           placeholder="e.g. Software Engineer" required>
                </div>

                <div class="form-group">
                    <label>Package / Salary</label>
                    <input type="text" name="salary"
                           placeholder="e.g. 6-8 LPA" required>
                </div>

                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location"
                           placeholder="e.g. Chennai" required>
                </div>

                <div class="form-group">
                    <label>Minimum CGPA</label>
                    <input type="text" name="cgpa"
                           placeholder="e.g. 7.5" required>
                </div>

                <div class="form-group full">
                    <label>Required Skills</label>
                    <input type="text" name="skills"
                           placeholder="e.g. Java, Python, SQL">
                </div>

                <div class="form-group full">
                    <label>Job Description</label>
                    <textarea name="description"
                        placeholder="Describe the job role and responsibilities..."
                        required></textarea>
                </div>

            </div>

            <div class="btn-row">
                <a href="job_postings.php" class="btn-back">← Back</a>
                <button type="submit" class="btn-submit">
                    Post Job
                </button>
            </div>
        </form>

    </div>
</div>



</body>
</html>