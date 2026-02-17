<?php 
/*
Template Name: VC Template
*/
   
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
get_header();
$page_Id = get_the_ID();
?>
<?php get_template_part('banners/about-banner'); ?>
<div class="container-fluid page-bg page-template-about-bg py-lg-5 overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>
    <section class="vc-hero-modern">
        <div class="vc-hero-container">

            <div class="vc-hero-card">

                <!-- Left Image -->
                <div class="vc-hero-image">
                    <div class="vc-image-wrapper">
                        <img src="/wp-content/uploads/2026/02/Image-Vice-Chancellor.png" alt="Vice Chancellor">
                    </div>
                </div>

                <!-- Right Content -->
                <div class="vc-hero-content">
                    <h1>Prof. Raj Kumar Mittal</h1>
                    <p class="vc-designation">Vice-Chancellor</p>

                    <p class="vc-description">
                        Distinguished academician and visionary leader with over 30 years of
                        experience in higher education, research, and institutional development.
                        Committed to excellence, innovation, and holistic growth of students and faculty.
                    </p>

                    <div class="vc-contact">
                        <p>📧 vc@bbau.ac.in</p>
                        <p>📞 +91-522-2440621</p>
                        <p>📍 Vidya Vihar, Rae Bareli Road, Lucknow - 226025</p>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <section class="vc-message">
        <div class="vc-container1">
            <h2><?php echo get_field('vc_message_heading'); ?></h2>
            <div class="vc-message-box">
                <?php echo get_field('vc_message');?>
            </div>
        </div>
    </section>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <section class="vc-gallery">
        <div class="vc-container1">

            <h2>Photo Gallery</h2>
            <div class="swiper vcSwiper">
                <div class="swiper-wrapper">
                    <?php if( have_rows('slider_image_section') ):
                     while ( have_rows('slider_image_section') ) : the_row(); ?>
                    <div class="swiper-slide">
                        <img src="<?php echo get_sub_field('slider_images');?>" alt="">
                    </div>
                    <?php endwhile; endif; ?>
                </div>
                <div class="swiper-pagination"></div>

            </div>
        </div>
    </section>
    <!-- <section class="vc-lecture">
        <div class="vc-container1">
            <h2>Eminent Lecture Series</h2>
            <div class="swiper vcSwiper">
                <div class="swiper-wrapper">
                    <?php 
                    $args = array(
                        'post_type' => 'eminent_lecture',
                        'posts_per_page' => -1
                    );
                    $lectures = new WP_Query( $args );
                    
                    if ( $lectures->have_posts() ) :
                        while ( $lectures->have_posts() ) : $lectures->the_post();
                        $video_url = trim(get_the_content());
                    ?>
                    <div class="swiper-slide">
                        <div class="lecture-card">
                            <h4><?php the_title(); ?></h4>
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                            <p>Speaker: <?php echo get_field('speaker_name'); ?></p>
                            <p>Designation: <?php echo get_field('speaker_designation'); ?></p>
                            <p>Date: <?php echo get_field('lecture_date'); ?></p>
                        </div>
                    </div>
                    <?php 
                        endwhile;
                        wp_reset_postdata();
                    endif; 
                    ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
    </section> -->

    <section class="">
        <div class="vc-container1">

            <h2 class="vc-section-title"><?php echo get_field('heading'); ?></h2>

            <div class="vc-resource-grid">
                <?php if(have_rows('resource_section')): 
                    while(have_rows('resource_section')): the_row();
                    $link = get_sub_field('button_link');?>
                    
                <div class="vc-resource-card">
                    <h3><?php echo get_sub_field('card_heading'); ?></h3>
                    <p><?php echo get_sub_field('card_description'); ?></p>
                    <a href="<?php  echo esc_url($link['url']); ?>"
                        class="vc-btn"><?php echo esc_html($link['title']); ?></a>
                </div>
                <?php endwhile; endif; ?>
            </div>

        </div>
    </section>

</div>
<?php get_footer(); ?>

<style>
.vc-section-title {
    text-align: center;
    font-size: 28px;
    margin-bottom: 50px;
    color: #002855;
}

.vc-resource-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.vc-resource-card {
    background: #ffffff;
    padding: 40px 30px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
    transition: all 0.3s ease;
}

.vc-resource-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 35px rgba(0, 0, 0, 0.1);
}

.vc-resource-card h3 {
    font-size: 20px;
    margin-bottom: 12px;
    color: #002855;
}

.vc-resource-card p {
    font-size: 15px;
    color: #555;
    margin-bottom: 20px;
    line-height: 1.6;
}

.vc-btn {
    text-decoration: none;
    font-weight: 600;
    color: #00509e;
}

.vc-btn:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 992px) {
    .vc-resource-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<script>
var swiper = new Swiper(".vcSwiper", {
    spaceBetween: 20,
    loop: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        1020: {
            slidesPerView: 3
        },
        768: {
            slidesPerView: 2
        },
        480: {
            slidesPerView: 1
        }
    }
});
</script>
<style>
/* ===== VC MODERN HERO ===== */
.vc-container1 {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
}

.vc-hero-modern {
    padding: 60px 20px;
}

.vc-hero-container {
    max-width: 1200px;
    margin: 0 auto;
}

.vc-hero-card {
    position: relative;
    display: flex;
    align-items: center;
    gap: 60px;
    padding: 60px;
    border-radius: 30px;
    background: linear-gradient(135deg, #2ca7c9, #1f7fa5);
    color: #ffffff;
    overflow: hidden;
}

/* Diagonal Accent Overlay */
.vc-hero-card::before {
    content: "";
    position: absolute;
    left: -150px;
    top: 0;
    width: 400px;
    height: 100%;
    background: rgba(255, 255, 255, 0.08);
    transform: skewX(-20deg);
}

/* Image */
.vc-hero-image {
    flex: 0 0 280px;
    position: relative;
    z-index: 2;
}

.vc-image-wrapper {
    width: 260px;
    height: 260px;
    border-radius: 50%;
    padding: 10px;
    background: #ffffff;
}

.vc-image-wrapper img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

/* Content */
.vc-hero-content {
    position: relative;
    z-index: 2;
    max-width: 600px;
}

.vc-hero-content h1 {
    font-size: 32px;
    margin-bottom: 6px;
}

.vc-designation {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 18px;
}

.vc-description {
    font-size: 16px;
    line-height: 1.7;
    margin-bottom: 20px;
    opacity: 0.95;
}

.vc-contact p {
    margin: 6px 0;
    font-size: 15px;
}

/* Responsive */
@media (max-width: 992px) {
    .vc-hero-card {
        flex-direction: column;
        text-align: center;
        padding: 40px 20px;
    }

    .vc-hero-card::before {
        display: none;
    }

    .vc-hero-image {
        margin-bottom: 20px;
    }
}


.vc-message-box {
    background: #f4f6f9;
    padding: 30px;
    border-left: 4px solid #002855;
    border-radius: 8px;
    line-height: 1.8;
}

/* Video */
.video-wrapper iframe {
    width: 100%;
    aspect-ratio: 16/9;
    border-radius: 12px;
}

/* Swiper */
.swiper-slide img {
    width: 100%;
    border-radius: 10px;
}

/* Lecture Cards */
.lecture-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.lecture-card {
    background: #fff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
}

/* Responsive */
@media (max-width: 768px) {
    .vc-profile {
        flex-direction: column;
        text-align: center;
    }

    .lecture-grid {
        grid-template-columns: 1fr;
    }
}
</style>