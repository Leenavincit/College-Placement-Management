<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "database.php";

if(!isset($_SESSION['company_id'])){
    header("Location: company_login.php");
    exit();
}

// ✅ AJAX handler - returns JSON, no redirect
if(isset($_POST['ajax']) && isset($_POST['app_id']) && isset($_POST['action'])){
    $app_id = $_POST['app_id'];
    $action = $_POST['action'];
    $result = mysqli_query($conn, "UPDATE applications SET status='$action' WHERE id='$app_id'");
    echo json_encode(['success' => $result ? true : false, 'status' => $action]);
    exit();
}

$company_id = $_SESSION['company_id'];

$company = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM companies WHERE id='$company_id'"
));

$query = mysqli_query($conn,"
    SELECT applications.*,
           students.name, students.email, students.phone,
           students.roll_no, students.department, students.cgpa, students.skills,
           jobs.job_role
    FROM applications
    JOIN students ON applications.student_id = students.id
    JOIN jobs ON applications.job_id = jobs.id
    WHERE jobs.company_id = '$company_id'
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Applicants</title>
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
    max-width: 900px;
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

/* ── APPLICANT CARD ── */
.applicant-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
}

.applicant-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
}

.applicant-header h2 {
    font-size: 20px;
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 4px;
}

.email {
    color: #777;
    font-size: 14px;
    margin-bottom: 4px;
}

.applied-role {
    color: #7c3aed;
    font-size: 14px;
    font-weight: 600;
}

/* ── STATUS BADGE ── */
.status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
    transition: all 0.3s;
}

.accepted { background: #d4edda; color: #155724; }
.pending  { background: #fff3cd; color: #856404; }
.rejected { background: #f8d7da; color: #721c24; }

/* ── DETAILS GRID ── */
.applicant-details {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    background: #f8f9fc;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
}

.applicant-details span {
    font-size: 12px;
    color: #888;
    display: block;
    margin-bottom: 3px;
}

.applicant-details p {
    font-size: 15px;
    font-weight: 600;
    color: #2c3e50;
}

/* ── SKILLS ── */
.skills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 18px;
}

.skill-tag {
    background: #eef2ff;
    color: #3949ab;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
}

/* ── ACTIONS ── */
.actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
}

.btn-success {
    background: #27ae60;
    color: white;
    padding: 9px 18px;
    border: none;
    border-radius: 7px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-success:hover { background: #219150; }

.btn-danger {
    background: #e74c3c;
    color: white;
    padding: 9px 18px;
    border: none;
    border-radius: 7px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-danger:hover { background: #c0392b; }

.btn-call {
    background: #2d6cdf;
    color: white;
    padding: 9px 18px;
    border-radius: 7px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: background 0.2s;
}

.btn-call:hover { background: #1a4fb5; }

/* ── TOAST NOTIFICATION ── */
.toast {
    position: fixed;
    bottom: 30px;
    right: 30px;
    padding: 14px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    color: white;
    opacity: 0;
    transition: opacity 0.4s;
    z-index: 9999;
    pointer-events: none;
}

.toast.show { opacity: 1; }
.toast.success { background: #27ae60; }
.toast.error   { background: #e74c3c; }

.no-applicants {
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
    <a href="job_postings.php">Job Postings</a>
    <a href="applicants.php" class="active">Applicants</a>
</div>

<!-- CONTAINER -->
<div class="container">
    <h1 class="page-title">Job Applicants</h1>

    <?php if(mysqli_num_rows($query) > 0){ ?>
        <?php while($row = mysqli_fetch_assoc($query)){ ?>

        <div class="applicant-card" id="card-<?php echo $row['id']; ?>">

            <div class="applicant-header">
                <div>
                    <h2><?php echo $row['name']; ?></h2>
                    <p class="email">
                        <?php echo $row['email']; ?> • <?php echo $row['phone']; ?>
                    </p>
                    <p class="applied-role">
                        Applied for: <?php echo $row['job_role']; ?>
                    </p>
                </div>

                <!-- ✅ Badge updates dynamically via JS -->
                <span class="status-badge <?php echo strtolower($row['status']); ?>"
                      id="badge-<?php echo $row['id']; ?>">
                    <?php echo $row['status']; ?>
                </span>
            </div>

            <div class="applicant-details">
                <div>
                    <span>Roll Number</span>
                    <p><?php echo $row['roll_no']; ?></p>
                </div>
                <div>
                    <span>Branch</span>
                    <p><?php echo $row['department']; ?></p>
                </div>
                <div>
                    <span>CGPA</span>
                    <p><?php echo $row['cgpa']; ?></p>
                </div>
                <div>
                    <span>Applied Date</span>
                    <p><?php echo $row['applied_date']; ?></p>
                </div>
            </div>

            <div class="skills">
                <?php
                $skills = !empty($row['skills']) ? explode(",", $row['skills']) : [];
                foreach($skills as $skill){
                    echo "<span class='skill-tag'>".trim($skill)."</span>";
                }
                ?>
            </div>

            <div class="actions" id="actions-<?php echo $row['id']; ?>">

                <!-- ✅ AJAX buttons - NO page reload or scroll -->
                <button class="btn-success"
                        onclick="updateStatus(<?php echo $row['id']; ?>, 'Accepted')">
                    Shortlist
                </button>

                <button class="btn-danger"
                        onclick="updateStatus(<?php echo $row['id']; ?>, 'Rejected')">
                     Reject
                </button>

                <?php if($row['status'] == "Accepted"){ ?>
                <a href="call_letter_sent.php?id=<?php echo $row['id']; ?>"
                   class="btn-call" id="call-<?php echo $row['id']; ?>">
                     Send Call Letter
                </a>
                <?php } else { ?>
                <a href="#" class="btn-call" id="call-<?php echo $row['id']; ?>"
                   style="display:none;">
                     Send Call Letter
                </a>
                <?php } ?>

            </div>
        </div>

        <?php } ?>
    <?php } else { ?>
        <p class="no-applicants">No applicants found.</p>
    <?php } ?>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>



<script>
// ✅ AJAX update - NO page reload, NO scroll to top
function updateStatus(appId, action) {

    fetch('applicants.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'ajax=1&app_id=' + appId + '&action=' + action
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){

            // ✅ Update badge instantly
            let badge = document.getElementById('badge-' + appId);
            badge.className = 'status-badge ' + action.toLowerCase();
            badge.innerText = action;

            // ✅ Show/hide Call Letter button
            let callBtn = document.getElementById('call-' + appId);
            if(action === 'Accepted'){
                callBtn.style.display = 'inline-block';
            } else {
                callBtn.style.display = 'none';
            }

            // ✅ Show toast notification
            showToast(action === 'Accepted'
                ? '✅ Candidate Shortlisted!'
                : '❌ Candidate Rejected!',
                action === 'Accepted' ? 'success' : 'error'
            );
        }
    })
    .catch(err => {
        showToast('Something went wrong!', 'error');
    });
}

function showToast(msg, type){
    let toast = document.getElementById('toast');
    toast.innerText = msg;
    toast.className = 'toast ' + type + ' show';
    setTimeout(() => {
        toast.className = 'toast';
    }, 3000);
}
</script>

</body>
</html>