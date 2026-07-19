<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("database.php");

if(!isset($_SESSION['student_email'])){
    header("Location: student_login.php");
    exit();
}

$email      = $_SESSION['student_email'];
$student_id = $_SESSION['student_id'];

$student = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM students WHERE email='$email'"
));

$jobs = mysqli_query($conn, "
    SELECT jobs.id, jobs.job_role, jobs.salary, jobs.description, jobs.skills, jobs.cgpa,
           companies.name AS company_name, companies.location
    FROM jobs
    JOIN companies ON jobs.company_id = companies.id
");

$applications = mysqli_query($conn, "
    SELECT applications.applied_date, applications.status,
           applications.interview_date, applications.interview_time,
           applications.interview_location, applications.call_letter_sent,
           jobs.job_role, jobs.salary,
           companies.name AS company_name, companies.location
    FROM applications
    JOIN jobs ON applications.job_id = jobs.id
    JOIN companies ON jobs.company_id = companies.id
    WHERE applications.student_id = '$student_id'
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: #f5f7fb;
}

/* ── HEADER ── */
.header {
    background: linear-gradient(to right, #2ecc71, #27ae60);
    color: white;
    padding: 18px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.header-left img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 2px solid white;
    object-fit: cover;
}

.header-left h2 {
    font-size: 20px;
    font-weight: 700;
}

.header-left small {
    font-size: 13px;
    color: #d5f5e3;
}

.logout {
    background: white;
    color: #27ae60;
    padding: 8px 18px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 700;
}

.logout:hover {
    background: #f0f0f0;
}

/* ── NAV ── */
.nav {
    display: flex;
    gap: 10px;
    padding: 0 30px;
    background: white;
    border-bottom: 1px solid #e0e0e0;
}

.nav a {
    cursor: pointer;
    text-decoration: none;
    color: #555;
    font-size: 14px;
    font-weight: 500;
    padding: 14px 12px;
    border-bottom: 3px solid transparent;
    transition: all 0.2s;
}

.nav a:hover {
    color: #27ae60;
}

.nav a.active {
    color: #27ae60;
    border-bottom: 3px solid #27ae60;
    font-weight: 600;
}

/* ── CONTAINER ── */
.container {
    max-width: 950px;
    margin: 30px auto;
    padding: 0 20px;
}

/* ── ALERT ── */
.alert {
    padding: 12px 18px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
    font-weight: 500;
}

.alert-success {
    background: #d4edda;
    color: #155724;
}

.alert-warning {
    background: #fff3cd;
    color: #856404;
}

/* ── SECTIONS ── */
.section { display: none; }
.section.active { display: block; }

/* ── PROFILE CARD ── */
.card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
    margin-bottom: 20px;
}

.card h2 {
    font-size: 20px;
    color: #2c3e50;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f0f0f0;
}

.profile-box {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.box {
    background: #f9fbfd;
    padding: 20px;
    border-radius: 10px;
}

.box p {
    margin-bottom: 15px;
    font-size: 14px;
    color: #2c3e50;
}

.box b {
    display: block;
    font-size: 12px;
    color: #888;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-bottom: 3px;
}

/* SKILLS */
.skill {
    display: inline-block;
    background: #eaf3ff;
    color: #1a73e8;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    margin: 3px 3px 3px 0;
}

/* PLACEMENT STATUS BADGE */
.badge {
    display: inline-block;
    background: #fff3cd;
    color: #856404;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

/* EDIT PROFILE BUTTON */
.btn {
    background: #27ae60;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    margin-top: 5px;
}

.btn:hover {
    background: #219150;
}

/* ── JOB CARDS ── */
.job-card {
    background: white;
    padding: 22px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.07);
    position: relative;
}

.job-card h3 {
    font-size: 18px;
    color: #2c3e50;
    margin-bottom: 4px;
}

.company {
    color: #777;
    font-size: 14px;
    margin-bottom: 10px;
}

.desc {
    color: #666;
    font-size: 14px;
    margin-bottom: 14px;
    line-height: 1.6;
}

.job-details {
    display: flex;
    gap: 25px;
    margin-bottom: 14px;
}

.job-details div small {
    color: #888;
    font-size: 12px;
}

.job-details div p {
    font-size: 15px;
    font-weight: 600;
    color: #2c3e50;
    margin-top: 2px;
}

.job-skills span {
    display: inline-block;
    background: #eef2f7;
    color: #444;
    padding: 5px 12px;
    margin: 3px 3px 10px 0;
    border-radius: 20px;
    font-size: 12px;
}

.status-active {
    position: absolute;
    right: 20px;
    top: 20px;
    background: #d4edda;
    color: #155724;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.apply-btn {
    background: #27ae60;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
}

.apply-btn:hover {
    background: #219150;
}

/* ── APPLICATION CARDS ── */
.app-card {
    background: white;
    padding: 22px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.07);
}

.app-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
}

.app-title {
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 4px;
}

.app-company {
    color: #666;
    font-size: 14px;
    margin-bottom: 3px;
}

.app-date {
    font-size: 13px;
    color: #888;
}

/* STATUS BADGES */
.badge-status {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.pending  { background: #fff3cd; color: #856404; }
.accepted { background: #d4edda; color: #155724; }
.rejected { background: #f8d7da; color: #721c24; }

.app-row {
    display: flex;
    gap: 30px;
    align-items: flex-start;
    flex-wrap: wrap;
}

.app-box small {
    color: #888;
    font-size: 12px;
    text-transform: uppercase;
}

.app-box p {
    font-size: 15px;
    font-weight: 600;
    color: #2c3e50;
    margin-top: 3px;
}

/* INTERVIEW BOX */
.interview-box {
    width: 100%;
    margin-bottom: 15px;
    padding: 15px;
    border-radius: 10px;
    background: #f1f5ff;
    border-left: 4px solid #2d6cdf;
}

.interview-box p {
    margin: 5px 0;
    font-size: 14px;
    color: #333;
}

.interview-box .label {
    font-weight: 700;
    color: #2d6cdf;
}

.no-data {
    text-align: center;
    color: #888;
    padding: 30px;
    background: white;
    border-radius: 12px;
}

.section-title {
    font-size: 22px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
}
</style>

<script>
function showTab(tab, element){
    document.getElementById("profile").classList.remove("active");
    document.getElementById("jobs").classList.remove("active");
    document.getElementById("applications").classList.remove("active");
    document.getElementById(tab).classList.add("active");
    let links = document.querySelectorAll(".nav a");
    links.forEach(link => link.classList.remove("active"));
    element.classList.add("active");
}
</script>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <div class="header-left">
        <img src="logo.png" alt="Logo">
        <div>
            <h2>Student Portal</h2>
            <small>Welcome, <?php echo $student['name']; ?></small>
        </div>
    </div>
    <a href="logout.php" class="logout">Logout</a>
</div>

<!-- NAV -->
<div class="nav">
    <a onclick="showTab('profile', this)" class="active">My Profile</a>
    <a onclick="showTab('jobs', this)">Available Jobs</a>
    <a onclick="showTab('applications', this)">My Applications</a>
</div>

<div class="container">

    <?php if(isset($_GET['msg'])){ ?>
        <?php if($_GET['msg'] == "success"){ ?>
            <div class="alert alert-success">✅ Application submitted successfully!</div>
        <?php } elseif($_GET['msg'] == "already"){ ?>
            <div class="alert alert-warning">⚠️ You have already applied for this job.</div>
        <?php } ?>
    <?php } ?>

    <!-- ================= PROFILE ================= -->
    <div id="profile" class="section active">
        <div class="card">
            <h2>Student Profile</h2>
            <div class="profile-box">

                <!-- LEFT -->
                <div class="box">
                    <p><b>Full Name</b><?php echo $student['name']; ?></p>
                    <p><b>Email</b><?php echo $student['email']; ?></p>
                    <p><b>Branch</b><?php echo $student['department']; ?></p>
                    <p><b>CGPA</b><?php echo $student['cgpa']; ?></p>
                    <p><b>Skills</b>
                        <?php
                        $skills = explode(",", $student['skills'] ?? "");
                        foreach($skills as $skill){
                            echo "<span class='skill'>" . trim($skill) . "</span>";
                        }
                        ?>
                    </p>
                    <br>
                    <a href="edit_profile.php">
                        <button class="btn">✏️ Edit Profile</button>
                    </a>
                </div>

                <!-- RIGHT -->
                <div class="box">
                    <p><b>Roll Number</b><?php echo $student['roll_no'] ?? 'Not set'; ?></p>
                    <p><b>Phone</b><?php echo $student['phone'] ?? 'Not set'; ?></p>
                    <p><b>Year</b><?php echo $student['year'] ?? 'Final Year'; ?></p>
                    <p><b>Placement Status</b>
                        <span class="badge"><?php echo $student['status']; ?></span>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- ================= JOBS ================= -->
    <div id="jobs" class="section">
        <h2 class="section-title">Available Jobs</h2>

        <?php while($job = mysqli_fetch_assoc($jobs)) { ?>
        <div class="job-card">

            <span class="status-active">Active</span>

            <h3><?php echo $job['job_role']; ?></h3>
            <p class="company">🏢 <?php echo $job['company_name']; ?></p>
            <p class="desc"><?php echo $job['description']; ?></p>

            <div class="job-details">
                <div>
                    <small>Package</small>
                    <p>₹<?php echo $job['salary']; ?></p>
                </div>
                <div>
                    <small>Location</small>
                    <p><?php echo $job['location']; ?></p>
                </div>
                <div>
                    <small>Min CGPA</small>
                    <p><?php echo $job['cgpa']; ?></p>
                </div>
            </div>

            <div class="job-skills">
                <?php
                $jskills = explode(",", $job['skills'] ?? "");
                foreach($jskills as $js){
                    echo "<span>" . trim($js) . "</span>";
                }
                ?>
            </div>

            <form action="apply.php" method="POST">
                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                <button class="apply-btn">Apply Now</button>
            </form>

        </div>
        <?php } ?>
    </div>

    <!-- ================= APPLICATIONS ================= -->
    <div id="applications" class="section">
        <h2 class="section-title">My Applications</h2>

        <?php if(mysqli_num_rows($applications) > 0){ ?>

            <?php while($app = mysqli_fetch_assoc($applications)) { ?>
            <div class="app-card">

                <div class="app-header">
                    <div>
                        <p class="app-title"><?php echo $app['job_role']; ?></p>
                        <p class="app-company">🏢 <?php echo $app['company_name']; ?></p>
                        <p class="app-date">📅 Applied on: <?php echo $app['applied_date']; ?></p>
                    </div>
                    <span class="badge-status <?php echo strtolower($app['status']); ?>">
                        <?php echo $app['status']; ?>
                    </span>
                </div>

                <!-- INTERVIEW BOX -->
                <?php if(!empty($app['call_letter_sent']) && $app['call_letter_sent'] == "Yes"){ ?>
                <div class="interview-box">
                    <p><span class="label">📅 Interview Date:</span> <?php echo $app['interview_date']; ?></p>
                    <p><span class="label">⏰ Interview Time:</span> <?php echo $app['interview_time']; ?></p>
                    <p><span class="label">📍 Location:</span> <?php echo $app['interview_location']; ?></p>
                </div>
                <?php } ?>

                <div class="app-row">
                    <div class="app-box">
                        <small>Package</small>
                        <p>₹<?php echo $app['salary']; ?></p>
                    </div>
                    <div class="app-box">
                        <small>Location</small>
                        <p><?php echo $app['location']; ?></p>
                    </div>
                </div>

            </div>
            <?php } ?>

        <?php } else { ?>
            <p class="no-data">No applications found.</p>
        <?php } ?>
    </div>

</div>
</body>
</html>