
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "database.php";

if(!isset($_SESSION['company_id'])){
    die("Company not logged in");
}

$page = 'applicants';
include "head.php";

$company_id = $_SESSION['company_id'];

/* FETCH APPLICANTS */
$applicants = mysqli_query($conn, "
SELECT 
applications.id AS app_id,
applications.status,
applications.applied_date,
students.name,
students.email,
students.phone,
students.roll_no,
students.department,
students.cgpa,
students.skills,
jobs.job_role
FROM applications
JOIN students ON applications.student_id = students.id
JOIN jobs ON applications.job_id = jobs.id
WHERE jobs.company_id='$company_id'
");

/* CHECK QUERY ERROR */
if(!$applicants){
    die(mysqli_error($conn));
}

$page = 'applicants';
include "header.php";
?>

<div class="container">

<h2>Job Applicants</h2>

<?php while($row = mysqli_fetch_assoc($applicants)) { ?>

<div class="card">

    <!-- TOP -->
    <div style="display:flex; justify-content:space-between;">

        <div>
            <h3 style="margin:0;"><?php echo $row['name']; ?></h3>
            <small>
                <?php echo $row['email']; ?> • <?php echo $row['phone']; ?>
            </small><br>
            <small>Applied for: <?php echo $row['job_role']; ?></small>
        </div>

        <!-- STATUS -->
        <div>
            <span class="badge <?php echo strtolower($row['status']); ?>">
                <?php echo $row['status']; ?>
            </span>
        </div>

    </div>

    <!-- DETAILS GRID -->
    <div style="display:flex; justify-content:space-between; margin-top:15px;">

        <div>
            <b>Roll Number:</b><br>
            <?php echo $row['roll_no']; ?>
        </div>

        <div>
            <b>Department:</b><br>
            <?php echo $row['department']; ?>
        </div>

        <div>
            <b>CGPA:</b><br>
            <?php echo $row['cgpa']; ?>
        </div>

        <div>
            <b>Applied Date:</b><br>
            <?php echo $row['applied_date']; ?>
        </div>

    </div>

    <!-- SKILLS -->
    <div style="margin-top:10px;">
        <?php 
        if(!empty($row['skills'])){
            $skills = explode(",", $row['skills']);
            foreach($skills as $skill){
                echo "<span class='skill'>$skill</span>";
            }
        }
        ?>
    </div>

    <!-- ACTION BUTTONS -->
    <form action="update_status.php" method="POST" style="margin-top:15px;">
        <input type="hidden" name="app_id" value="<?php echo $row['app_id']; ?>">

        <button name="action" value="Accepted" class="btn green">
            Shortlist Candidate
        </button>

        <button name="action" value="Rejected" class="btn red">
            Reject
        </button>
    </form>

</div>

<?php } ?>

</div>