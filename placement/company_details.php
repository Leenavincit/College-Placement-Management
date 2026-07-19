<?php
include("database.php");

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM companies WHERE id = '$id'");
$row = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Company Details</title>

<style>
body {
    font-family: Arial;
    background: #f4f6f9;
    margin: 0;
}

/* HEADER */
.header {
    background: #2563eb;
    color: white;
    padding: 15px;
    display: flex;
    align-items: center;
}
.header img {
    width: 50px;
    margin-right: 10px;
}

/* CARD */
.container {
    width: 50%;
    margin: 40px auto;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

h2 {
    margin-bottom: 15px;
}

p {
    margin: 10px 0;
    font-size: 16px;
}

/* BACK BUTTON */
.back-btn {
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 18px;
    background: #22c55e;
    color: white;
    border-radius: 25px;
    text-decoration: none;
}
</style>

</head>
<body>

<div class="header">
    <img src="logo.png">
    <h2>ST.JOSEPH'S COLLEGE (ARTS AND SCIENCE)</h2>
</div>

<div class="container">

<a href="view_company.php" class="back-btn">← Back</a>

<div class="card">
    <h2><?php echo $row['company_name']; ?></h2>

    <p><strong>Industry:</strong> <?php echo $row['industry']; ?></p>
    <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
    <p><strong>Email:</strong> <?php echo $row['email']; ?></p>

</div>

</div>

</body>
</html>