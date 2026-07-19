<?php
session_start();
include "database.php";

if(!isset($_SESSION['company_id'])){
    die("Not logged in");
}

$company_id = $_SESSION['company_id'];

/* SAVE DATA */
if(isset($_POST['name'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $industry = $_POST['industry'];
    $phone = $_POST['phone'];

    $update = mysqli_query($conn, "
        UPDATE companies SET
        name='$name',
        email='$email',
        location='$location',
        industry='$industry',
        phone='$phone'
        WHERE id='$company_id'
    ");

    if($update){
        header("Location: edit_company_profile.php?success=1");
        exit();
    } else {
        echo "Error updating: " . mysqli_error($conn);
    }
}

/* FETCH DATA */
$company = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM companies WHERE id='$company_id'"
));
?>
<style>
body {
    background:#f5f6fa;
    font-family: 'Segoe UI', sans-serif;
}

/* CARD */
.form-card {
    background: white;
    padding: 35px;
    border-radius: 16px;
    max-width: 750px;
    margin: 40px auto;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

/* TITLE */
.form-card h2 {
    margin-bottom: 25px;
}

/* GRID */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

/* INPUT GROUP */
.input-group {
    position: relative;
}

.input-group input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ccc;
    outline: none;
    transition: 0.3s;
    font-size: 14px;
}

/* FLOAT LABEL */
.input-group label {
    position: absolute;
    top: 12px;
    left: 12px;
    background: white;
    padding: 0 5px;
    color: #777;
    font-size: 13px;
    transition: 0.3s;
}

/* ANIMATION */
.input-group input:focus {
    border-color: #7b2ff7;
    box-shadow: 0 0 0 2px rgba(123,47,247,0.1);
}

.input-group input:focus + label,
.input-group input:not(:placeholder-shown) + label {
    top: -8px;
    font-size: 11px;
    color: #7b2ff7;
}

/* BUTTONS */
.form-actions {
    margin-top: 25px;
}

.btn-primary {
    background: linear-gradient(90deg,#7b2ff7,#a4508b);
    color: white;
    padding: 12px 20px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}

.btn-primary:hover {
    transform: scale(1.05);
}

.btn-cancel {
    margin-left: 10px;
    text-decoration: none;
    color: #555;
}

/* SUCCESS POPUP */
.success-msg {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
}
.top-bar {
    max-width: 750px;
    margin: 30px auto 0;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: white;
    border: 1px solid #ddd;
    padding: 10px 16px;
    border-radius: 10px;
    text-decoration: none;
    color: #333;
    font-weight: 500;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    transition: 0.3s;
}

/* Hover effect */
.back-btn:hover {
    background: #f5f5f5;
    transform: translateY(-2px);
}
</style>

<div class="form-card">

<h2>Edit Company Profile</h2>

<?php if(isset($_GET['success'])) { ?>
    <div class="success-msg">Profile Updated Successfully!</div>
<?php } ?>

<form method="POST">

<div class="form-grid">

    <div class="input-group">
        <input type="text" name="name" value="<?php echo $company['name']; ?>" required placeholder=" ">
        <label>Company Name</label>
    </div>

    <div class="input-group">
        <input type="email" name="email" value="<?php echo $company['email']; ?>" required placeholder=" ">
        <label>Email</label>
    </div>

    <div class="input-group">
        <input type="text" name="location" value="<?php echo $company['location']; ?>" placeholder=" ">
        <label>Location</label>
    </div>

    <div class="input-group">
        <input type="text" name="industry" value="<?php echo $company['industry']; ?>" placeholder=" ">
        <label>Industry</label>
    </div>

    <div class="input-group">
        <input type="text" name="phone" value="<?php echo $company['phone']; ?>" placeholder=" ">
        <label>Phone</label>
    </div>

</div>
<div class="top-bar">
    <a href="company_dashboard.php" class="back-btn">
        ← Back to Dashboard
    </a>
</div>
<div class="form-actions">
    
    <button type="submit" class="btn-primary">Save Changes</button>
    <a href="company_dashboard.php" class="btn-cancel">Cancel</a>
    
</div>

</form>

</div>