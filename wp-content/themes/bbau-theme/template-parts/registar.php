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
                            <img src="/wp-content/uploads/2026/02/registar.jpg" alt="Registrar">
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
                    <h3>General Administration</h3>
                    <p><strong>Mr. Atul Bajpai </strong>, (GAD) <br>
                    <a class="link-new" href="mailto:gad@bbau.ac.in"><strong>Email:</strong> gad@bbau.ac.in</a> </p>
                </div>

                <div class="vc-resource-card">
                    <h3>Establishment</h3>
                    <p><strong>Smt. Sudha Srivastava </strong>, Section Officer <br>
                    <strong>Shri. Somesh Chandra </strong>, Section Officer <br>
                    <strong> Shri. Pradeep Kumar </strong>, Stenographer </p>
                </div>

                <div class="vc-resource-card">
                    <h3>Academic Section</h3>
                    <p><strong>Dr. Ranjeev Kumar Sahu </strong>, Deputy Registrar <br>
                    <strong>Shri. Govind Bhushan Madhukar </strong>, (LDC) </p>
                </div>

                <div class="vc-resource-card">
                    <h3>Store & Purchase Section</h3>
                    <p><strong>Dr. Subhash Kumar Yadav </strong>, Deputy In-charge <br>
                    <strong>Dr. Vinit Kumar </strong>, Deputy In-charge <br> </p>
                
                    <a href= "#" class="vc-btn" target="_blank">Visit page</a>
                </div>
                

                <div class="vc-resource-card">
                    <h3>Vehicle Section</h3>
                    <p><strong>Dr. Jay Shankar Singh </strong>, In-charge <br>
                    <strong>Mr. S. K. Tripathi </strong>, Hindi Officer <br>
                    <strong>Shri B.S. Saini </strong>, Section Officer </p>
                </div>

                <div class="vc-resource-card">
                    <h3>ST / SC Cell</h3>
                    <p><strong>Mr. Arvind Shukla </strong>, RSO (I/c) </p>
                    <a href= "#" class="vc-btn" target="_blank">Visit page</a>
                </div>

                <div class="vc-resource-card">
                    <h3>Legal / RTI Cell</h3>
                    <p><strong>Shri B. K. Kashyap </strong>, Assistant Registrar <br>
                    <strong>Shri Amit Upadhyay </strong>, LDC </p>
                </div>

                <div class="vc-resource-card">
                    <h3>Research-cum-Statistical Officer(RSO)</h3>
                    <p><strong>Shri Arvind Shukla </strong> </p>
                </div>

                <div class="vc-resource-card">
                    <h3>University Works Department</h3>
                    <p><strong>Er. Pratik Kumar </strong>, Executive Engineer </p>
                    <a href= "#" class="vc-btn" target="_blank">Visit page</a>
                </div>

                <div class="vc-resource-card">
                    <h3>Hindi Cell</h3>
                    <p><strong>Mr. S. K. Tripathi </strong>, Hindi Officer </p>
                    <a href= "#" class="vc-btn" target="_blank">Visit page</a>
                </div>

                <div class="vc-resource-card">
                    <h3>UWD</h3>
                    <p><strong>Dr. R. S. Verma </strong>, In-Charge </p>
                    <a href= "#" class="vc-btn" target="_blank">Visit page</a>
                </div>

            </div>

        </div>
    </section>
</div>

<?php get_footer(); ?>


