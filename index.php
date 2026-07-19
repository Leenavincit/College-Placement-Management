<!DOCTYPE html>
<html>
<head>

<title>Student Placement Tracking and Recruitment System</title>

<link rel="stylesheet" href="portal.css">

</head>

<body>


<div class="header">

<img src="logo.png" class="logo">

<h1>ST JOSEPH'S COLLEGE OF ARTS & SCIENCE</h1>

<h2>Student Placement Tracking and Recruitment System</h2>

</div>


<h1 class="title">Access Portal</h1>


<div class="card-container">


<div class="card">

<div class="icon">👨‍💼</div>

<h2>T&P Admin</h2>

<p>Manage placement activities and generate reports</p>

<a href="admin_login.php" class="btn admin">Admin Login</a>

</div>


<div class="card">

<div class="icon">🎓</div>

<h2>Student</h2>

<p>Apply for jobs and track your applications</p>

<a href="student_login.php" class="btn student">Student Login</a>

</div>


<div class="card">

<div class="icon">🏢</div>

<h2>Company</h2>

<p>Post jobs and recruit talented students</p>

<a href="company_login.php" class="btn company">Company Login</a>

</div>


</div>
<!-- ── ABOUT T&P SECTION ── -->
<section class="about-section">

    <div class="about-container">

        <!-- SECTION TITLE -->
        <div class="section-title">
            <h2>Training and Placement Cell</h2>
            <p>Bridging the gap between academia and industry</p>
        </div>

        <!-- ABOUT BOX -->
        <div class="about-box">
            <h3>About Training and Placement Cell</h3>
            <p>
                The Training and Placement Cell of St. Joseph's College of Arts & Science 
                is dedicated to empowering students with the skills, knowledge, and 
                opportunities needed to launch successful careers. We work closely with 
                leading industries and organizations to provide our students with the best 
                placement opportunities across diverse sectors.
            </p>
        </div>

        <!-- OBJECTIVES + ACTIVITIES GRID -->
        <div class="two-col-grid">

            <!-- OBJECTIVES -->
            <div class="info-card">
                <div class="card-header">
                    <span class="card-icon">🎯</span>
                    <h3>Objectives</h3>
                </div>
                <ul>
                    <li>Equip students with essential technical, analytical, and soft skills to meet industry demands and improve their employability.</li>
                    <li>Offer personalized career counselling to help students identify their strengths and align their career goals.</li>
                    <li>Establish strong industry-academic linkages and partnerships with companies for internships, training, and job placements.</li>
                    <li>Develop and enhance students' employability through skill development programs, workshops, and seminars.</li>
                    <li>Organize on-campus recruitment drives and collaborate with nearby institutions for off-campus placement opportunities.</li>
                    <li>Foster an entrepreneurial mind-set among students by collaborating with incubators and start-ups.</li>
                    <li>Secure placement opportunities for students across diverse sectors, ensuring a high placement rate.</li>
                    <li>Provide company-specific training (both aptitude and technical) for students preparing for interviews.</li>
                    <li>Provide guidance and resources for personal and professional growth, including resume building and interview preparation.</li>
                </ul>
            </div>

            <!-- ACTIVITIES -->
            <div class="info-card">
                <div class="card-header">
                    <span class="card-icon">⚡</span>
                    <h3>Activities</h3>
                </div>
                <ul>
                    <li>🛠️ Skill Development Programs</li>
                    <li>🌟 Personality Development Programs (PDP)</li>
                    <li>🏭 Industry Interaction Programs</li>
                    <li>🧭 Career Guidance and Counselling</li>
                    <li>💼 Internship Programs</li>
                    <li>🚀 Placement Drives</li>
                    <li>🤝 Collaborations with Industry and Corporates</li>
                    <li>💡 Entrepreneurship Development Activities</li>
                    <li>📝 Special Preparatory Sessions for Competitive Exams</li>
                </ul>
            </div>

        </div>

        <!-- STATS ROW -->
        <div class="stats-row">
            <div class="stat-box">
                <h2>500+</h2>
                <p>Students Placed</p>
            </div>
            <div class="stat-box">
                <h2>100+</h2>
                <p>Partner Companies</p>
            </div>
            <div class="stat-box">
                <h2>50+</h2>
                <p>Placement Drives</p>
            </div>
            <div class="stat-box">
                <h2>95%</h2>
                <p>Placement Rate</p>
            </div>
        </div>

    </div>

</section>

<style>
/* ── ABOUT SECTION ── */
.about-section {
    background: #f0f2f5;
    padding: 60px 20px;
}

.about-container {
    max-width: 1100px;
    margin: 0 auto;
}

/* ── SECTION TITLE ── */
.section-title {
    text-align: center;
    margin-bottom: 40px;
}

.section-title h2 {
    font-size: 32px;
    font-weight: 800;
    color: #1a73e8;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
}

.section-title p {
    font-size: 16px;
    color: #666;
}

/* ── ABOUT BOX ── */
.about-box {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
    margin-bottom: 30px;
    border-left: 5px solid #1a73e8;
}

.about-box h3 {
    font-size: 20px;
    color: #2c3e50;
    margin-bottom: 12px;
    font-weight: 700;
}

.about-box p {
    font-size: 15px;
    color: #555;
    line-height: 1.8;
}

/* ── TWO COLUMN GRID ── */
.two-col-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
    margin-bottom: 30px;
}

/* ── INFO CARD ── */
.info-card {
    background: white;
    padding: 28px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.card-icon {
    font-size: 28px;
}

.card-header h3 {
    font-size: 20px;
    font-weight: 700;
    color: #2c3e50;
}

.info-card ul {
    list-style: none;
    padding: 0;
}

.info-card ul li {
    font-size: 14px;
    color: #555;
    padding: 10px 0;
    border-bottom: 1px solid #f5f5f5;
    line-height: 1.6;
    padding-left: 10px;
    position: relative;
}

.info-card ul li::before {
    content: "→";
    color: #1a73e8;
    font-weight: 700;
    margin-right: 8px;
}

/* ── STATS ROW ── */
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.stat-box {
    background: #1a73e8;
    color: white;
    padding: 30px 20px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(26,115,232,0.3);
}

.stat-box h2 {
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 8px;
}

.stat-box p {
    font-size: 14px;
    opacity: 0.9;
    font-weight: 500;
}

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
    .two-col-grid {
        grid-template-columns: 1fr;
    }
    .stats-row {
        grid-template-columns: 1fr 1fr;
    }
    .section-title h2 {
        font-size: 22px;
    }
}
</style>
<!-- FOOTER -->
<footer>
    <p>© St.Joseph's College (Arts & Science), 2026. All Rights Reserved.</p>
</footer>

<style>
footer {
    background: #1a73e8;
    color: white;
    text-align: center;
    padding: 16px;
    font-size: 14px;
    margin-top: auto;
}
</style>
</body>
</html>