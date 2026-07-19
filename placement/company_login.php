<!DOCTYPE html>
<html>
<head>
<title>Company Login</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #8e2de2, #4a00e0);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CARD */
.login-card {
    background: #fff;
    padding: 40px;
    border-radius: 16px;
    width: 380px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

/* HEADER */
.login-header {
    text-align: center;
    margin-bottom: 25px;
}

.login-header h2 {
    margin: 0;
    font-size: 24px;
}

.login-header p {
    color: #777;
    font-size: 14px;
}

/* INPUT */
.input-group {
    margin-bottom: 18px;
}

.input-group label {
    font-size: 13px;
    color: #555;
    display: block;
    margin-bottom: 5px;
}

.input-group input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ddd;
    outline: none;
    transition: 0.3s;
}

.input-group input:focus {
    border-color: #8e2de2;
    box-shadow: 0 0 5px rgba(142,45,226,0.3);
}

/* BUTTON */
.login-btn {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(to right, #8e2de2, #4a00e0);
    color: white;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
}

.login-btn:hover {
    transform: scale(1.02);
    opacity: 0.95;
}

/* FOOTER */
.footer {
    text-align: center;
    font-size: 12px;
    color: #aaa;
    margin-top: 15px;
}
/* LOGO SECTION */
.logo-container{
    text-align:center;
    margin-bottom:20px;
}

.logo{
    width:80px;
    height:80px;
    border-radius:50%;
    object-fit:cover;
    margin-bottom:10px;
}

/* OPTIONAL IMPROVEMENT */
.login-box h2{
    margin:5px 0;
    font-weight:600;
}
</style>

</head>

<body>

<div class="login-card">
<div class="logo-container">
    <img src="logo.png" alt="College Logo" class="logo">
</div>
    <div class="login-header">
        <h2>Company Portal</h2>
        <p>St.Joseph's college (Arts and Science)</p>
    </div>

    <form action="company_login_process.php" method="POST">

        <div class="input-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>

        <button class="login-btn">Login</button>

    </form>


</div>

</body>
</html>