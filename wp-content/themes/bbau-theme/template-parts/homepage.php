<?php 
/*
Template name: Homepage Template
*/  
get_header();
defined( 'ABSPATH' ) || exit;
?>

<!-- ================= HERO SECTION ================= -->
<section class="hero">
    <video class="hero-video" autoplay muted loop playsinline>
        <source src="http://172.35.2.130:9001/wp-content/uploads/2026/01/BBAU-home-video-HD-1080p.mp4" type="video/mp4">
    </video>

    <div class="hero-overlay"></div>

    <div class="hero-caption">
        <p>
            ““It is the education which is the right weapon to cut the social slavery and it is the
            education which will enlighten the downtrodden masses to come up and gain social status,
            economic betterment and political freedom.”
        </p>
        <p class="author">Dr. B. R. Ambedkar, Bharat Ratna</p>
    </div>
</section>


<!-- ================= ANNOUNCEMENT BAR ================= -->
<div class="announce-bar">
    <div class="announce-container">
        <div class="announce-track">
            <span>Admission in UG & Diploma Courses for the Academic Session 2025–26</span>
            <span>Admission in B.Tech Programme 2025–26 through JEE (Main) Score</span>
            <span>Admissions Open for PG Programmes for the Academic Session 2025–26</span>
        </div>
    </div>
</div>


<!-- ================= UNIVERSITY AT A GLANCE ================= -->
<section class="glance-section">
    <div class="glance-overlay container-fluid">
        <div class="glance-container">

            <h2 class="glance-title"><?php echo get_field('glance_heading');?></h2>
            <p class="glance-desc">
                <?php echo get_field('glance_description');?>
            </p>


            <div class="glance-stats">
                <?php
                    if( have_rows('glance_stats') ):
                        while ( have_rows('glance_stats') ) : the_row(); ?>
                            <div class="stat">
                                <div class="icon-box">
                                    <img src="<?php echo get_sub_field('stats_icon');?>"
                                        alt="<?php echo get_sub_field('stats_label');?>">
                                </div>
                                <div class="stat-text">
                                    <span class="num"><?php echo get_sub_field('stats_number');?></span>
                                    <span class="label"><?php echo get_sub_field('stats_label');?></span>
                                </div>
                            </div>
                            <?php endwhile;
                    endif;
                ?>
            </div>
        </div>
    </div>
</section>

<!-- ================= VICE CHANCELLOR DESK ================= -->
<section class="vc-section">
    <div class="vc-container">

        <style>
        .vc-slider {
            Babasaheb Bhimrao Ambedkar University,
            a premier Central University located in the historic capital city of Lucknow,
            Uttar Pradesh,
            stands as a beacon of academic excellence and social empowerment. The University equips students with knowledge,
            professional skills,
            and deep-rooted values to contribute responsibly to society. width: 100%;
            overflow: hidden
        }

        .vc-slider-track {
            display: flex;
            transition: transform .6s ease
        }

        .vc-slide {
            min-width: 100%;
            box-sizing: border-box
        }

        .vc-slide img {
            width: 100%;
            height: 360px;
            object-fit: cover;
            display: block
        }
        </style>

        <!-- LEFT IMAGE (Slider) -->
        <div class="vc-image">
            <div class="vc-slider" aria-roledescription="carousel">
                <div class="vc-slider-track">
                    <div class="vc-slide"><img
                            src="http://172.35.2.130:9001/wp-content/uploads/2026/01/bd84e33f73912eca5938f36a7148b43ace88498f.png"
                            alt="Vice Chancellor"></div>
                    <div class="vc-slide"><img src="http://172.35.2.130:9001/wp-content/uploads/2026/01/VC-SIR-4.png"
                            alt="Vice Chancellor"></div>
                    <div class="vc-slide"><img
                            src="http://172.35.2.130:9001/wp-content/uploads/2026/01/PXL_20250925_055605975.MP_-scaled.jpg"
                            alt="Vice Chancellor"></div>
                    <div class="vc-slide"><img
                            src="http://172.35.2.130:9001/wp-content/uploads/2026/01/WhatsApp-Image-2026-01-23-at-11.36.45-AM.jpeg"
                            alt="Vice Chancellor"></div>
                    <div class="vc-slide"><img
                            src="http://172.35.2.130:9001/wp-content/uploads/2026/01/PXL_20250925_101748138-scaled.jpg"
                            alt="Vice Chancellor"></div>
                </div>
            </div>
        </div>

        <!-- RIGHT CONTENT -->
        <div class="vc-content">
            <h3>Vice Chancellor Desk</h3>

            <p class="vc-text">
                <span class="vc-greeting">Greetings…</span>
                Welcome to Babasaheb Bhimrao Ambedkar University, a premier institution
                of higher learning dedicated to shaping the minds of future leaders.
                As we strive for excellence in education, research and innovations,
                we remain focused on fostering a culture of innovation, inclusivity,
                and social responsibility essential to navigate the complexities of
                the 21st century and provide the opportunity to everyone to realize
                one’s full potential.
            </p>

            <div class="vc-btn-wrap">
                <a href="#" class="vc-btn">Read More</a>
            </div>
        </div>

    </div>
</section>

<!-- ================= INFO SECTION ================= -->
<section class="info-section">
    <div class="info-container">

        <!-- ================= CARD 1 ================= -->
        <div class="info-card">
            <h3 class="info-title">Announcement</h3>

            <div class="info-scroll">
                <a href="#" class="info-item">Walk in interview For Staff</a>
                <a href="#" class="info-item">CUET – PG 2026 Info Bulletin</a>
                <a href="#" class="info-item">CUET-PG 2026 Mapping-Eligibility</a>
                <a href="#" class="info-item">Advertisement For Vacant Non Teaching Post</a>
                <a href="#" class="info-item">Syllabus for CUET – 2026</a>
                <a href="#" class="info-item">Examination Notice Update</a>
                <a href="#" class="info-item">Hostel Admission Notice</a>
            </div>

            <a href="#" class="info-btn orange">View All Announcement</a>
        </div>

        <!-- ================= CARD 2 ================= -->
        <div class="info-card">
            <h3 class="info-title">Events</h3>

            <div class="info-scroll">
                <a href="#" class="info-item">National Seminar on AI</a>
                <a href="#" class="info-item">International Conference 2025</a>
                <a href="#" class="info-item">Sports Meet Registration</a>
                <a href="#" class="info-item">Cultural Fest “Abhivyakti”</a>
                <a href="#" class="info-item">Workshop on Cyber Security</a>
                <a href="#" class="info-item">Startup Awareness Program</a>
            </div>

            <a href="#" class="info-btn dark">View All Events</a>
        </div>

        <!-- ================= CARD 3 ================= -->
        <div class="info-card">
            <h3 class="info-title">Appointments</h3>

            <div class="info-scroll">
                <a href="#" class="info-item">Appointment of Registrar</a>
                <a href="#" class="info-item">New Dean – Academics</a>
                <a href="#" class="info-item">Controller of Examination</a>
                <a href="#" class="info-item">Head of Department – CS</a>
                <a href="#" class="info-item">Finance Officer Appointment</a>
                <a href="#" class="info-item">Proctor Committee Update</a>
            </div>

            <a href="#" class="info-btn orange">View All Appointments</a>
        </div>

        <!-- ================= CARD 4 ================= -->
        <div class="info-card">
            <h3 class="info-title">Tender</h3>

            <div class="info-scroll">
                <a href="#" class="info-item">Tender for Hostel Maintenance</a>
                <a href="#" class="info-item">Library Automation Tender</a>
                <a href="#" class="info-item">Security Services Tender</a>
                <a href="#" class="info-item">Campus Landscaping Tender</a>
                <a href="#" class="info-item">Electrical Works Tender</a>
                <a href="#" class="info-item">IT Infrastructure Tender</a>
            </div>

            <a href="#" class="info-btn dark">View All Tenders</a>
        </div>

    </div>
</section>


<section class="auto-slider">
    <div class="auto-slider-container">

        <!-- start gap -->
        <div class="slider-gap"></div>

        <div class="slider-track">

            <div class="slider-card">
                <img src="http://172.35.2.130:9001/wp-content/uploads/2026/01/bv3-scaled.jpg">
            </div>

            <div class="slider-card">
                <img src="http://172.35.2.130:9001/wp-content/uploads/2026/01/IMG_8672-scaled.jpeg">
            </div>

            <div class="slider-card">
                <img src="http://172.35.2.130:9001/wp-content/uploads/2026/01/vc2-scaled.jpg">
            </div>

            <div class="slider-card">
                <img src="http://172.35.2.130:9001/wp-content/uploads/2026/01/vc1-scaled-1.jpg">
            </div>

            <div class="slider-card">
                <img src="http://172.35.2.130:9001/wp-content/uploads/2026/01/vc5.jpg">
            </div>

            <div class="slider-card">
                <img src="http://172.35.2.130:9001/wp-content/uploads/2026/01/vc4.jpg">
            </div>

        </div>

        <!-- end gap -->
        <div class="slider-gap"></div>

    </div>
</section>
<?php 
get_footer();
?>