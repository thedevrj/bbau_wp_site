<?php 
/* 
Template Name: Accreditation Template
*/
defined('ABSPATH') || exit;
get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid page-bg page-template-about-bg py-lg-5 overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>

    <div class="container">
        <h2 class="mb-4 text-center">Accreditation & Rankings</h2>
        <h4 class="accreditation-subtitle text-center mb-4">
            National Rankings & Quality Assurance
        </h4>

        <div class="accreditation-grid mb-4">

            <!-- ================= NIRF ================= -->
            <div class="accreditation-card">
                <div class="accreditation-logo">
                    <img src="/wp-content/themes/bbau-theme/assets/img/IQAC/nirf_logo.png">
                    <h3 class="accreditation-name">NIRF</h3>
                </div>

                <p class="accreditation-desc text-center text-uppercase">
                    National Institutional Ranking Framework
                </p>

                <ul class="accreditation-details text-start">
                    <li><strong>Year:</strong> 2025</li>
                    <li><strong>Rank:</strong> 69 (University Category)</li>
                </ul>

                <div class="accreditation-links">
                    <a href="/about-us/accreditation/report/" target="_blank">
                        View Report (PDF)
                    </a>

                    <a href="/nirf-reports">
                        View NIRF Reports
                    </a>

                    <a href="https://www.nirfindia.org" target="_blank">
                        Official Website
                    </a>
                </div>
            </div>

            <!-- ================= NAAC ================= -->
            <div class="accreditation-card">
                <div class="accreditation-logo">
                    <img src="/wp-content/themes/bbau-theme/assets/img/IQAC/naac_logo.png">
                    <h3 class="accreditation-name">NAAC</h3>
                </div>

                <p class="accreditation-desc text-center text-uppercase">
                    National Assessment and Accreditation Council
                </p>

                <ul class="accreditation-details text-start">
                    <li><strong>Grade:</strong> A++</li>
                    <li><strong>CGPA:</strong> 3.72</li>
                </ul>

                <div class="accreditation-links">
                    <a href="/wp-content/uploads/2026/02/naaccertificate23.pdf" target="_blank">
                        View Report (PDF)
                    </a>
                    <a href="https://www.naac.gov.in" target="_blank">
                        Official Website
                    </a>
                </div>
            </div>

            <!-- ================= ARIIA ================= -->
            <div class="accreditation-card">
                <div class="accreditation-logo">
                    <img src="/wp-content/themes/bbau-theme/assets/img/IQAC/ARIIA.png">
                    <h3 class="accreditation-name">ARIIA</h3>
                </div>

                <p class="accreditation-desc text-uppercase text-center">
                    ATAL Ranking of Institutions on Innovation Achievements
                </p>

                <ul class="accreditation-details">
                    <li><strong>Year:</strong> 2021</li>
                </ul>

                <div class="accreditation-links">
                    <a href="/wp-content/uploads/2026/02/ARIIA2021Report.pdf" target="_blank">
                        View Report (PDF)
                    </a>
                </div>
            </div>

            <!-- ================= QS RANKING ================= -->
            <div class="accreditation-card">
                <div class="accreditation-logo">
                    <img src="/wp-content/uploads/2026/04/images.png">
                    <h3 class="accreditation-name">QS Ranking</h3>
                </div>

                <p class="accreditation-desc text-center text-uppercase">
                    QS World University Rankings
                </p>

                <ul class="accreditation-details text-start">
                    <li><strong>Year:</strong> 2025</li>
                    <li><strong>Rank:</strong> 1201–1400</li>
                </ul>

                <div class="accreditation-links">
                    <a href="/wp-content/uploads/qs/qs-2025-report.pdf" target="_blank">
                        View Report (PDF)
                    </a>

                    <a href="https://www.topuniversities.com" target="_blank">
                        Official Website
                    </a>
                </div>
            </div>

            <!-- ================= CLARIVATE ================= -->
            <div class="accreditation-card">
                <div class="accreditation-logo">
                    <img src="/wp-content/uploads/2026/04/clarivate.png">
                    <h3 class="accreditation-name">Clarivate</h3>
                </div>

                <p class="accreditation-desc text-center text-uppercase">
                    India Research Excellence Citation Awards
                </p>

                <ul class="accreditation-details text-start">
                    <li><strong>Year:</strong> 2025</li>
                    <li><strong>Award:</strong> Research Excellence</li>
                </ul>

                <div class="accreditation-links">
                    <a href="/wp-content/uploads/clarivate/clarivate-2025-certificate.jpg" target="_blank">
                        View Certificate
                    </a>

                    <a href="https://clarivate.com" target="_blank">
                        Official Website
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= BASIC STYLING ================= -->
<style>
/* GRID */
.accreditation-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 16px;
}

/* CARD */
.accreditation-card {
  background: #fff;
  padding: 15px;              /* 🔻 reduced from 20px */
  border-radius: 10px;
  text-align: center;
  box-shadow: 0 3px 10px rgba(0,0,0,0.08);
}

/* LOGO */
.accreditation-logo img {
  max-width: 90px;           /* 🔻 smaller logo */
  margin-bottom: 6px;
}

/* TITLE */
.accreditation-name {
  font-size: 18px;           /* 🔻 reduced */
  font-weight: 600;
  margin-bottom: 5px;
}

/* DESCRIPTION */
.accreditation-desc {
  font-size: 13px;           /* 🔻 smaller */
  margin: 6px 0;
  line-height: 1.3;
}

/* DETAILS */
.accreditation-details {
  margin: 8px 0;
  padding-left: 15px;
  font-size: 13px;
}

/* LINKS */
.accreditation-links a {
  display: inline-block;
  margin: 4px 4px;
  padding: 5px 8px;          /* 🔻 smaller buttons */
  font-size: 12px;
  background: #f1f1f1;
  border-radius: 4px;
  text-decoration: none;
}

.accreditation-links a:hover {
  background: #ddd;
}
</style>
<?php get_footer(); ?>