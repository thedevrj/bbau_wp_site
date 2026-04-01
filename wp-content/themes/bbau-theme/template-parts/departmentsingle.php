<?php
/*
Template Name: Department Single Page Template
*/
defined('ABSPATH') || exit;
get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<!-- ✅ PAGE WRAPPER (Scoped Styling) -->
<div class="dept-page-wrapper container-fluid py-lg-5">

    <!-- ✅ MENU AFTER BREADCRUMB -->
    <div class="container">
        <div class="dept-nav">
            <a href="#" class="active">About</a>
            <a href="#">Thrust Areas</a>
            <a href="#">Programmes</a>
            <a href="#">Achievements</a>
            <a href="#">People</a>
            <a href="#">Notices</a>
            <a href="#">Research Activities</a>
            <a href="#">Time Table</a>
            <a href="#">Committees</a>
            <a href="#">Gallery</a>
        </div>
    </div>

    <div class="container py-4">

        <div class="page-title">
            <h2 class="dept-title-gradient">
                Department of Biotechnology
            </h2>
        </div>

        <!-- ✅ HOD CARD -->
        <div class="hod-card">

            <!-- LEFT -->
            <div class="hod-left">
                <div class="avatar">
                    <img src="/wp-content/uploads/2026/03/Dr.-Modi.png" alt="HOD">
                </div>

            </div>

            <!-- RIGHT -->
            <div class="hod-right">
                <div class="name">Prof. D. R. Modi</div>
                <div class="role">Head of the Department</div>

                <div class="contacts">

                    <div class="contact-row">
                        
                        <span class="label">Phone:</span>
                        <span class="icon">📞</span>
                        <span class="value">9935720995</span>
                    </div>

                    <div class="contact-row">
                        
                        <span class="label">Email:</span>
                        <span class="icon">✉️</span>
                        <span class="value">
                            <a href="#">drmodilko@gmail.com</a>
                        </span>
                    </div>

                    <div class="contact-row">
                        
                        <span class="label">Email:</span>
                        <span class="icon">✉️</span>
                        <span class="value">
                            <a href="#">drmodi@bbau.ac.in</a>
                        </span>
                    </div>

                </div>
            </div>

        </div>

        <!-- ✅ INTRODUCTION -->
        <div class="section">
            <h3>Introduction of the Department</h3>
            <p>
                The Department of Biotechnology started in September, 2005 under the School for Biosciences and
                Biotechnology. Presently, under School of Life Sciences (SLSc). The present intake capacity is 46
                students. Apart from M. Sc in Biotechnology, the department has also startedM. Sc in Bioinformatics, M.
                Sc Industrial Biotechnology from this session 2022-2023 and Ph. D in Biotechnology with diverse field of
                specialization including Enzyme Technology and Protein Chemistry, Microbial Technology, Plant Molecular
                Biology, Immunotechnology and Neurobiology
            </p>

        </div>

        <!-- ✅ ACADEMIC PROFILE -->
        <div class="section">
            <h3>Academic Profile of Department</h3>
            <p>
                Biotechnology, being a multidisciplinary subject, requires knowledge from various areas of biological as
                well as technological sciences. It encompasses understanding of fundamental concepts and their
                applications in the area of Molecular biology, Cell Biology, Immunology, Microbiology, Biochemistry,
                Bioinformatics and Bio-processing.
            </p>
            <p>Keeping in view the developing of modern applied aspect of the subject, Biotechnology has now become a
                multi-billion-dollar industry. The teaching programme caters the requirement of Biotechnology Industry
                and Institutes in India and aboard
            </p>
            <p>Presently, Choice Based Credit System has been introduced and many courses which may supplement and
                compliment core Biotechnology subject from various discipline i.eLaw, Department of Zoology, Department
                of Horticulture, Management, Statistics etc. have been introduced. The course curriculum of M. Sc.
                Biotechnology has been prepared taking the guidelines from UGC and DBT, Govt. of India modified time to
                time in respective BoS (Board of Studies) meetingsheld on 16-11-2022 (as per NEP2020), 20-08-2019,
                20-04-2018, 22-05-2015, 21-03-2014, 11-11-2009 and October 2005.
            </p>
            <p>Modifications in syllabus in consultation with the industry professionals, practitioners, students and
                their parents basically who are the stake holders is a continuous process
            </p>
            <p>
                In addition to the normal teaching classes and the practical training, the curriculum has integral
                components of Seminars and Research based project works targeted to shape the student’s career in
                accordance with the requirement of the present national and international needs. The department is in
                the process of developing facilities conducive for training in the field of Biotechnology at par with
                that of international level. Faculty of the department is running various externally funded research
                projects from agencies like UGC, DST and DBT. Many distinguished scientists and eminent scholars from
                premier research institutes such as CSIR, ICAR, Indian and foreign Universities are invited to deliver
                lectures in their area of research interest from time to time. The students are exposed to both
                academics as well as extracurricular activities during their tenure.
            </p>
        </div>

        <!-- ✅ COMMITTEE -->
        <div class="section">
            <h3>Committees</h3>
            <div class="committee-row">
                <span class="committee-text">
                    📥 Different Committees under Department of Biotechnology
                </span>

                <a href="#" class="committee-link">View</a>
            </div>
        </div>

    </div>
</div>

<?php get_footer(); ?>


<!-- ✅ SCOPED CSS (ONLY THIS PAGE) -->
<style>
/* ================= PAGE BACKGROUND ================= */
.dept-page-wrapper {
    background: #f7f4ef;
}

/* ================= MENU ================= */
.dept-nav {
    background: linear-gradient(90deg, #8B1A1A, #5c1010);
    display: flex;
    overflow-x: auto;
    padding: 0 20px;
    border-radius: 10px;
    margin: 15px 0 25px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    scrollbar-width: none;
}

.dept-nav::-webkit-scrollbar {
    display: none;
}

.dept-nav a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-size: 13.5px;
    font-weight: 500;
    padding: 14px 18px;
    white-space: nowrap;
    border-bottom: 3px solid transparent;
    transition: 0.3s;
}

.dept-nav a:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.08);
    border-bottom: 5px solid #c9a84c;
}

.dept-nav a.active {
    color: #fff;
    border-bottom: 3px solid #c9a84c;
}

/* ================= TITLE ================= */
.page-title {
    font-family: 'Merriweather', serif;
    font-size: 26px;
    font-weight: 700;
    color: #5c1010;
    margin-bottom: 28px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e2d9cc;
    text-align: left;
}

/* ================= HOD CARD ================= */
.hod-card {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 14px;
    display: flex;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(139, 26, 26, .09);
    margin: 0 auto 32px;
    max-width: 700px;
    transition: 0.3s;
}
.dept-page-wrapper .dept-title-gradient {
  font-family: 'Merriweather', serif;
  font-size: 32px;
  font-weight: 700;
  color: #5c1010;

  position: relative;
  display: inline-block;
  margin-bottom: 20px;
}

/* 🔥 UNDERLINE (MATCHING YOUR THEME) */
.dept-page-wrapper .dept-title-gradient::after {
  content: "";
  display: block;
  width: 180px;
  height: 4px;
  background: linear-gradient(90deg, #8B1A1A, #c9a84c); /* 🔥 red → gold */
  margin-top: 8px;
  border-radius: 2px;
}
.avatar {
    overflow: hidden;
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hod-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(139, 26, 26, .18);
}

/* LEFT */
/* ================= LEFT ================= */
.hod-left {
    background: linear-gradient(160deg, #5c1010, #8B1A1A);
    width: 300px;
    /* 🔥 increased */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 16px;
    padding: 40px 24px;
}

/* ================= AVATAR ================= */
.avatar {
    width: 150px;
    /* 🔥 increased */
    height: 150px;
    /* 🔥 increased */
    border-radius: 50%;
    border: 5px solid #c9a84c;
    overflow: hidden;
    /* 🔥 important for image */
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ================= BADGE ================= */
.hod-badge {
    background: #c9a84c;
    color: #5c1010;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    padding: 6px 16px;
    border-radius: 20px;
}

/* ================= RIGHT ================= */
.hod-right {
    padding: 30px 35px;
    /* 🔥 better spacing */
}

.hod-right .name {
    font-family: 'Merriweather', serif;
    font-size: 24px;
    /* 🔥 slightly bigger */
    font-weight: 700;
    color: #5c1010;
    margin-bottom: 6px;
}

.hod-right .role {
    font-size: 14px;
    color: #8B1A1A;
    margin-bottom: 18px;
}

/* ================= CONTACT ================= */
/* CONTACT WRAPPER */
.contacts {
    display: flex;
    flex-direction: column;

    margin-top: 10px;
}

/* EACH ROW */
.contact-row {
    display: flex;
    align-items: center;
    font-size: 15px;
    color: #555;
}

/* ICON FIX WIDTH */
.icon {
    width: 24px;
    text-align: center;
}

/* LABEL FIX WIDTH */
.label {
    min-width: 70px;
    /* 🔥 alignment magic */
    font-weight: 600;
    color: #5c1010;
}

/* VALUE */
.value {
    color: #555;
}

/* LINKS */
.value a {
    color: #8B1A1A;
    text-decoration: none;
}

.value a:hover {
    text-decoration: underline;
}

/* ================= SECTIONS ================= */
.section h3 {
    font-family: 'Merriweather', serif;
    color: #5c1010;
    border-bottom: 1px solid #e2d9cc;
}

.section p {
    color: #555;
    line-height: 1.8;
}

.committee-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.committee-text {
    font-size: 15px;
    color: #444;
}

.committee-link {
    font-size: 14px;
    font-weight: 600;
    color: #8B1A1A;
    text-decoration: none;
    white-space: nowrap;
}

.committee-link:hover {
    color: #5c1010;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 580px) {
    .hod-card {
        flex-direction: column;
    }

    .hod-left {
        width: 100%;
        flex-direction: row;
        padding: 20px;
    }
}
</style>