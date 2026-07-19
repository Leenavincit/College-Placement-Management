<?php
session_start();
include("database.php");

if(!isset($_SESSION['student_id'])){
    header("Location: student_login.php");
    exit();
}

$id = $_SESSION['student_id'];
$result = mysqli_query($conn, "SELECT * FROM students WHERE id='$id'");
$student = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){
    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $department = $_POST['department'];
    $cgpa       = $_POST['cgpa'];
    $roll       = $_POST['roll'];
    $phone      = $_POST['phone'];
    $year       = $_POST['year'];
    $skills     = $_POST['skills'];

    mysqli_query($conn, "UPDATE students SET 
        name='$name', email='$email', department='$department',
        cgpa='$cgpa', roll_no='$roll', phone='$phone',
        year='$year', skills='$skills'
        WHERE id='$id'");

    echo "<script>alert('Profile Updated!'); window.location='student_dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Profile</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }

body {
    background: #f5f7fb;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.header {
    background: linear-gradient(to right, #2ecc71, #27ae60);
    padding: 18px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header .left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.header .left img {
    width: 55px; height: 55px;
    border-radius: 50%;
    border: 2px solid white;
    object-fit: cover;
}

.header .left h2 { color: white; font-size: 20px; font-weight: 700; }
.header .left p  { color: #d5f5e3; font-size: 13px; margin-top: 2px; }

.logout {
    background: white; color: #27ae60;
    padding: 8px 18px; border-radius: 6px;
    text-decoration: none; font-weight: 700; font-size: 14px;
}

.page-content {
    display: flex;
    justify-content: center;
    padding: 40px 20px;
    flex: 1;
}

.form-card {
    background: white;
    width: 100%;
    max-width: 650px;
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.form-card h2 {
    font-size: 22px; color: #2c3e50;
    margin-bottom: 25px; padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0; font-weight: 700;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

.full { grid-column: span 2; }

.form-group { display: flex; flex-direction: column; }

.form-group label {
    font-size: 12px; font-weight: 600; color: #666;
    margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.4px;
}

.form-group input,
.form-group select {
    padding: 10px 14px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px; color: #333; outline: none;
    transition: border 0.3s;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #27ae60;
    box-shadow: 0 0 0 3px rgba(39,174,96,0.15);
}

.divider {
    border: none; border-top: 2px dashed #eee;
    margin: 25px 0;
}

.section-label {
    font-size: 14px; font-weight: 700;
    color: #27ae60; margin-bottom: 15px;
    display: flex; align-items: center; gap: 8px;
}

.btn-row { display: flex; gap: 12px; margin-top: 25px; }

.btn-submit {
    flex: 1; padding: 12px;
    background: #27ae60; color: white;
    border: none; border-radius: 8px;
    font-size: 15px; font-weight: 600; cursor: pointer;
    transition: background 0.3s;
}

.btn-submit:hover { background: #219150; }

.btn-back {
    flex: 1; padding: 12px;
    background: #f0f2f5; color: #444;
    border-radius: 8px; font-size: 15px; font-weight: 600;
    text-decoration: none; text-align: center;
    display: flex; align-items: center; justify-content: center;
}

.btn-back:hover { background: #e0e2e5; }

footer {
    background: linear-gradient(to right, #2ecc71, #27ae60);
    color: white; text-align: center;
    padding: 16px; font-size: 14px; margin-top: auto;
}
</style>
</head>
<body>

<div class="header">
    <div class="left">
        <img src="logo.png">
        <div>
            <h2>Student Portal</h2>
            <p>Welcome, <?php echo $student['name']; ?></p>
        </div>
    </div>
    <a href="logout.php" class="logout">Logout</a>
</div>

<div class="page-content">
    <div class="form-card">
        <h2>✏️ Edit Profile</h2>

        <form method="POST">
            <div class="form-grid">
                <div class="form-group full">
                    <label>Full Name</label>
                    <input type="text" name="name" value="<?php echo $student['name']; ?>" required>
                </div>
                <div class="form-group full">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $student['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Roll Number</label>
                    <input type="text" name="roll" value="<?php echo $student['roll_no']; ?>">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo $student['phone']; ?>">
                </div>
                <div class="form-group">
                    <label>Department</label>
                    <input type="text" name="department" value="<?php echo $student['department']; ?>">
                </div>
                <div class="form-group">
                    <label>Year</label>
                    <select name="year">
                        <option value="1st Year"   <?php echo $student['year']=='1st Year'  ?'selected':''; ?>>1st Year</option>
                        <option value="2nd Year"   <?php echo $student['year']=='2nd Year'  ?'selected':''; ?>>2nd Year</option>
                        <option value="3rd Year"   <?php echo $student['year']=='3rd Year'  ?'selected':''; ?>>3rd Year</option>
                        <option value="Final Year" <?php echo $student['year']=='Final Year'?'selected':''; ?>>Final Year</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>CGPA</label>
                    <input type="text" name="cgpa" value="<?php echo $student['cgpa']; ?>">
                </div>
                <div class="form-group">
                    <label>Skills</label>
                    <input type="text" name="skills" value="<?php echo $student['skills']; ?>" placeholder="e.g. PHP, MySQL">
                </div>
                         
            </div>

            <div class="btn-row">
                <a href="student_dashboard.php" class="btn-back">← Cancel</a>
                <button type="submit" name="update" class="btn-submit">💾 Save Changes</button>
            </div>
        </form>
    </div>
</div>


</body>
</html>