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
        <source src="/wp-content/uploads/2026/01/BBAU-home-video-HD-1080p.mp4" type="video/mp4">
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
            <?php   if(have_rows('notice_file')):
                    while(have_rows('notice_file')): the_row(); ?>
                <span><a target="_blank"
                    href="<?php echo get_sub_field('files_upload'); ?>"><?php echo get_sub_field('file_text'); ?></a></span>
            <?php 
                    endwhile; 
                endif; ?> 
        </div>
    </div>
</div>


<!-- ================= UNIVERSITY AT A GLANCE ================= -->
<section class="glance-section">
    <div class="glance-overlay container-fluid">
        <div class="glance-container">
            <?php if( get_field('glance_heading') ): ?>
            <h2 class="glance-title"><?php echo get_field('glance_heading');?></h2>
            <?php endif; ?>

            <?php if(get_field('glance_description')): ?>
            <p class="glance-desc">
                <?php echo get_field('glance_description');?>
            </p>
            <?php endif; ?>
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
                        <span class="num count"
                         data-target="<?php echo preg_replace('/[^0-9]/', '', get_sub_field('stats_number')); ?>"
                         data-suffix="<?php echo strpos(get_sub_field('stats_number'), '+') !== false ? '+' : ''; ?>">
                         0
                        </span>

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
        <!-- LEFT IMAGE (Slider) -->
        <div class="vc-image">
            <div class="vc-slider" aria-roledescription="carousel">
                <div class="vc-slider-track">
                    <?php if(have_rows('vc_slider_image')): 
                        while(have_rows('vc_slider_image')): the_row();?>
                    <div class="vc-slide">
                        <img src="<?php echo get_sub_field('vc_images'); ?>" alt="Vice Chancellor">
                    </div>
                    <?php endwhile; endif; ?>
                </div>
            </div>
        </div>

        <!-- RIGHT CONTENT -->
        <div class="vc-content">
            <h3><?php echo get_field('vc_desk_heading'); ?></h3>

            <?php if(get_field('vc_desk_content')): ?>
            <p class="vc-text">
                <?php echo get_field('vc_desk_content');?>
            </p>
            <?php endif; ?>

            <div class="vc-btn-wrap">
                <?php $link = get_field('vc_button_text'); 
                if( $link ): ?>
                <a href="<?php echo esc_url($link['url']); ?>"
                    target="<?php echo esc_attr($link['target'] ?: '_self'); ?>" class="vc-btn">
                    <?php echo esc_html($link['title']); ?>
                </a>
                <?php endif; ?>
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
            <?php if( have_rows('slider_image_section') ):
                while ( have_rows('slider_image_section') ) : the_row(); ?>

            <div class="slider-card">
                <img src="<?php echo get_sub_field('slider_images'); ?>">
            </div>
            <?php endwhile;
            endif; ?>
        </div>

        <!-- end gap -->
        <div class="slider-gap"></div>

    </div>
</section>
<?php 
get_footer();
?>