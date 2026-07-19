<?php
session_start();
include "database.php";

// CHECK COMPANY LOGIN
if(!isset($_SESSION['company_id'])){
    die("Not logged in");
}

$app_id = $_GET['id']; // ⚠️ This gets lost on form submit - fix below

if(isset($_POST['send'])){
    $date     = $_POST['date'];
    $time     = $_POST['time'];
    $location = $_POST['location'];
    $app_id   = $_POST['app_id']; // ✅ Get from hidden input instead

    $sql = "UPDATE applications 
            SET 
                status='Accepted',
                interview_date='$date',
                interview_time='$time',
                interview_location='$location',
                call_letter_sent='Yes'
            WHERE id='$app_id'";

    if(mysqli_query($conn, $sql)){
        header("Location: applicants.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Send Call Letter</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: #f0f2f5;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.box {
    width: 420px;
    background: white;
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.box h2 {
    margin-bottom: 25px;
    color: #2c3e50;
    text-align: center;
}

label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #555;
    margin-bottom: 6px;
    margin-top: 15px;
}

input {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
}

input:focus {
    border-color: #2d6cdf;
    box-shadow: 0 0 0 3px rgba(45,108,223,0.15);
}

button {
    width: 100%;
    padding: 12px;
    margin-top: 25px;
    background: #2d6cdf;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
}

button:hover {
    background: #1a4fb5;
}

.back {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #2d6cdf;
    text-decoration: none;
    font-size: 14px;
}
</style>
</head>
<body>

<div class="box">
    <h2>📨 Send Interview Call Letter</h2>

    <form method="POST" action="call_letter_sent.php">

        <!-- ✅ HIDDEN INPUT to carry the app_id through form submit -->
        <input type="hidden" name="app_id" value="<?php echo $app_id; ?>">

        <label>Interview Date</label>
        <input type="date" name="date" required>

        <label>Interview Time</label>
        <input type="time" name="time" required>

        <label>Interview Location / Link</label>
        <input type="text" name="location" placeholder="e.g. Room 101 / Google Meet link" required>

        <button name="send">Send Call Letter</button>

    </form>

    <a href="applicants.php" class="back">← Back to Applicants</a>
</div>

</body>
</html>