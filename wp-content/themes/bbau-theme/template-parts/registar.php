<?php 
/*
Template Name: Registrar Template
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid page-bg page-template-about-bg py-lg-5">

    <?php get_template_part('template-parts/breadcrumb'); ?>

    <!-- =====================================
     REGISTRAR SECTION
===================================== -->

    <section class="registrar-modern-style">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-11">

                    <div class="registrar-card">

                        <!-- LEFT IMAGE -->
                        <div class="registrar-right">
                            <img src="http://localhost:9001/wp-content/uploads/2026/02/registar.jpg" alt="Registrar">
                        </div>

                        <!-- RIGHT CONTENT -->
                        <div class="registrar-left">
                            <h3>Dr. Ashwini Kumar Singh</h3>
                            <p class="vc-designation">Registrar</p>

                            <!-- Contact -->
                            <div class="vc-contact">
                                <p>
                                    ✉
                                    <a class="link-new" href="mailto:registrar@bbau.ac.in">
                                        registrar@bbau.ac.in
                                    </a>
                                </p>

                                <p>
                                    📞
                                    <a class="link-new" href="tel:+915222440821">
                                        +91-522-2440821
                                    </a>
                                </p>
                            </div>

                            <!-- Buttons -->
                            <div class="registrar-buttons">
                                <a href="/wp-content/uploads/2026/02/BriefResume_page-0001.pdf" class="reg-btn"
                                    target="_blank">
                                    Profile
                                </a>

                                <a href="/wp-content/uploads/2026/02/Tenure_of_Registrar.pdf" class="reg-btn"
                                    target="_blank">
                                    Tenure of Registrar
                                </a>
                            </div>

                            <!-- Office -->
                            <div class="registrar-office">
                                <strong>Registrar Office:</strong><br>
                                Dr. Balan G. (PS)<br>
                                Shri Diwan Singh Bisth (MTS)
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>


    <!-- =====================================
     ADMINISTRATIVE SECTIONS
===================================== -->

    <section class="registrar-department-section">
        <div class="container">
            <h2 class="vc-section-title">
                Sections Under Registrar
            </h2>

            <div class="vc-resource-grid">

                <div class="vc-resource-card">
                    <h4>General Administration</h4>
                    Mr. Atul Bajpai, Assistant Registrar</p>
                </div>

                <div class="vc-resource-card">
                    <h4>ES Details</h4>
                    <p><strong>Establishment Section</strong></p>
                    <p>Mr. Atul Bajpai</p>
                    <p>Mr. Sudha Srivastava</p>
                </div>

                <div class="vc-resource-card">
                    <h4>Academic Section</h4>
                    <p>Dr. Ranjeev Kumar Sahu</p>
                    <p>Shri. Govind Bhushan Madhukar</p>
                </div>

                <div class="vc-resource-card">
                    <h4>Store & Purchase</h4>
                    <p>Dr. Subhash Kumar Yadav</p>
                </div>

                <div class="vc-resource-card">
                    <h4>Vehicle Section</h4>
                    <p>Dr. Jay Shankar Singh</p>
                </div>

                <div class="vc-resource-card">
                    <h4>ST / SC Cell</h4>
                    <p>Mr. Arvind Shukla</p>
                </div>

                <div class="vc-resource-card">
                    <h4>Legal / RTI Cell</h4>
                    <p>Shri B. K. Kashyap</p>
                </div>

                <div class="vc-resource-card">
                    <h4>RSO</h4>
                    <p>Research-cum-Statistical Officer</p>
                </div>

                <div class="vc-resource-card">
                    <h4>Sanitation Section</h4>
                    <p>Dr. R. S. Verma</p>
                </div>

                <div class="vc-resource-card">
                    <h4>Hindi Cell</h4>
                    <p>Mr. S. K. Tripathi</p>
                </div>

                <div class="vc-resource-card">
                    <h4>UWD</h4>
                    <p>University Works Department</p>
                    <p>Er. Pratik Kumar</p>
                </div>

            </div>

        </div>
    </section>
</div>

<?php get_footer(); ?>

<style>
/* =====================================
   REGISTRAR MODERN SECTION
===================================== */

.registrar-modern-style {
    padding: 70px 15px;
}

.registrar-modern-style .container {
    max-width: 1400px;
}


/* =====================================
   CARD LAYOUT (50% / 50%)
===================================== */

.registrar-card {
    background: #0f5b66;
    border-radius: 22px;
    padding: 55px 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    transition: 0.3s ease;
}

.registrar-card:hover {
    transform: translateY(-4px);
}


/* =====================================
   LEFT SIDE (IMAGE 50%)
===================================== */

.registrar-right {
    width: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.registrar-right img {
    width: 80%;
    max-width: 320px;
    aspect-ratio: 1/1;
    object-fit: cover;
    border-radius: 50%;
    border: 5px solid #ffffff;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.4);
    transition: 0.4s ease;
}

.registrar-card:hover .registrar-right img {
    transform: scale(1.05);
}


/* =====================================
   RIGHT SIDE (CONTENT 50%)
===================================== */

.registrar-left {
    width: 50%;
    color: #ffffff;
}

.registrar-left h3 {
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 8px;
    color: #ffffff;
}

.vc-designation {
    font-size: 19px;
    font-weight: 600;
    margin-bottom: 22px;
    opacity: 0.9;
}


/* =====================================
   CONTACT SECTION
===================================== */

.vc-contact p {
    font-size: 18px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.vc-contact a {
    color: #ffffff;
    text-decoration: none;
    font-weight: 500;
}

.vc-contact a:hover {
    text-decoration: underline;
    opacity: 0.85;
}


/* ======================================
   REGISTRAR SECTION CUSTOM BTN DESIGN
   Only affects Registrar section
====================================== */

.registrar-modern-style .reg-btn {
    background: linear-gradient(135deg, #2d83aa7e, #699fd4b3) !important;
    color: #ffffff !important;
    border-radius: 30px !important;
    padding: 10px 26px !important;
    font-size: 15px !important;
    font-weight: bold !important;
    letter-spacing: 0.3px !important;
    text-decoration: none !important;
    display: inline-block;
    transition: all 0.3s ease !important;
}

/* hover */
.registrar-modern-style .reg-btn:hover {
    background: linear-gradient(135deg, #3c8bcbd9, #5e93c9) !important;
    color: #ffffff !important;
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(0, 80, 158, 0.35);
}

/* active */
.registrar-modern-style .reg-btn:active {
    transform: translateY(0px);
    box-shadow: 0 4px 12px rgba(0, 80, 158, 0.25);
}

/* remove focus outline */
.registrar-modern-style .reg-btn:focus {
    outline: none !important;
    box-shadow: 0 6px 18px rgba(0, 80, 158, 0.25) !important;
}

/* spacing between buttons */
.registrar-modern-style .registrar-buttons {
    margin-top: 20px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}


/* =====================================
   OFFICE SECTION
===================================== */

.registrar-office {
    margin-top: 18px;
    font-size: 18px;
    line-height: 1.5;
}

.registrar-office strong {
    display: block;
    margin-bottom: -12px;
}


/* =====================================
   RESPONSIVE DESIGN
===================================== */

@media(max-width:1200px) {
    .registrar-card {
        padding: 45px 60px;
    }
}

@media(max-width:992px) {

    .registrar-card {
        flex-direction: column;
        text-align: center;
        padding: 40px 30px;
    }

    .registrar-right,
    .registrar-left {
        width: 100%;
    }

    .vc-contact p {
        justify-content: center;
    }

    .registrar-right img {
        width: 180px;
    }
}

@media(max-width:576px) {

    .registrar-left h3 {
        font-size: 22px;
    }

    .vc-designation {
        font-size: 16px;
    }

    .registrar-card {
        padding: 30px 20px;
    }

    .registrar-right img {
        width: 150px;
    }
}
</style>