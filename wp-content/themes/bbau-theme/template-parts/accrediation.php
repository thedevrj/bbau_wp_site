<?php 
/* 
Template Name: Accreditation Template
*/
defined('ABSPATH') || exit;
get_header();
?>
<?php   get_template_part('banners/about-banner');?>

<section class=" container-fluid page-bg page-template-about-bg py-lg-5 overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>
    <div class="container">
        <h2 class="mb-4 text-center ">Accreditation & Rankings</h2>
        <h4 class="accreditation-subtitle text-center mb-4">
            National Rankings & Quality Assurance
        </h4>
        <div class="accreditation-grid mb-4">
            <!-- NIRF -->
            <div class="accreditation-card">
                <div class="accreditation-logo">
                    <img src="/wp-content/themes/bbau-theme/assets/img/IQAC/nirf_logo.png" alt="NIRF Logo">
                    <h3 class="accreditation-name">NIRF</h3>
                </div>
                <p class="accreditation-desc text-center text-uppercase">
                    National Institutional Ranking Framework

                <ul class="accreditation-details text-start">
                    <li><strong>Year:</strong> 2025</li>
                    <li><strong>Rank:</strong> 69 (University Category)</li>
                </ul>
                </p>
                <div class="accreditation-links">
                    <a href="/nirf">View Reports (PDF)</a>
                    <a href="https://www.nirfindia.org" target="_blank">Official Website</a>
                </div>
            </div>

            <!-- NAAC -->
            <div class="accreditation-card">
                <div class="accreditation-logo">
                    <img src="/wp-content/themes/bbau-theme/assets/img/IQAC/naac_logo.png" alt="NAAC Logo">
                    <h3 class="accreditation-name">NAAC</h3>
                    <p class="accreditation-desc text-center text-uppercase">
                        National Assessment and Accreditation Council

                    <ul class="accreditation-details text-start">
                        <li><strong>Grade:</strong> A++</li>
                        <li><strong>CGPA:</strong> 3.72</li>
                    </ul>
                    </p>
                </div>
                <div class="accreditation-links">
                    <a href="/wp-content/uploads/2026/02/naaccertificate23.pdf"
                        target="_blank">View Report (PDF)</a>
                    <a href="https://www.naac.gov.in" target="_blank">Official Website</a>
                </div>
            </div>

            <!-- ARIIA -->
            <div class="accreditation-card">
                <div class="accreditation-logo">
                    <img src="/wp-content/themes/bbau-theme/assets/img/IQAC/ARIIA.png" alt="ARIIA Logo">
                    <h3 class="accreditation-name">ARIIA</h3>
                    <p class="accreditation-desc text-uppercase text-center">
                        ATAL RANKING OF INSTITUTIONS ON INNOVATION ACHIEVEMENTS
                    </p>
                </div>
                <ul class="accreditation-details">
                    <li><strong>Year:</strong> 2021</li>
                </ul>
                <div class="accreditation-links">
                    <a href="/wp-content/uploads/2026/02/ARIIA2021Report.pdf"
                        target="_blank">View Report (PDF)</a>
                    <a href="#" target="_blank">Official Website</a>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- </section> -->
<?php get_footer(); ?>
