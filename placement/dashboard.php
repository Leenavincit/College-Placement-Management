<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
        .dashboard-container {
            text-align: center;
            margin-top: 100px;
        }

        .dashboard-btn {
            display: block;
            width: 250px;
            margin: 15px auto;
            padding: 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .dashboard-btn:hover {
            background-color: #0056b3;
        }

        .logout-btn {
            background-color: red;
        }

        .logout-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

<div class="dashboard-container">

    <h1>Dashboard Overview</h1>

    <div class="cards">

        <div class="card">
            <h4>Total Students</h4>
            <h2><?php echo $students_count; ?></h2>
        </div>

        <div class="card">
            <h4>Students Placed</h4>
            <h2><?php echo $applications_count; ?></h2>
        </div>

        <div class="card">
            <h4>Companies</h4>
            <h2><?php echo $companies_count; ?></h2>
        </div>

        <div class="card">
            <h4>Jobs</h4>
            <h2><?php echo $jobs_count; ?></h2>
        </div>

    </div>

</div>
