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
        <div class="vc-container1">

            <div class="vc-hero-card">

                <!-- Left Image -->
                <div class="vc-hero-image">
                    <div class="vc-image-wrapper">
                        <img src="<?php echo get_field('vc_image'); ?>" alt="Vice Chancellor">
                    </div>
                </div>

                <!-- Right Content -->
                <div class="vc-hero-content">
                    <h3><?php echo get_field('vc_name'); ?></h3>
                    <p class="vc-designation"><?php echo get_field('vc_designation'); ?></p>

                    <p class="vc-description">
                        <?php echo get_field('about_vc'); ?>
                    </p>

                    <div class="vc-contact">
                        <?php echo get_field('vc_contact'); ?>
                    </div>
                    <div class="row pt-2">
                        <?php echo get_field('vc_extra_link'); ?>
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
                        <img src="<?php echo get_sub_field('slider_images');?>" alt="Photo Gallery">
                    </div>
                    <?php endwhile; endif; ?>
                </div>
                <div class="swiper-pagination"></div>

            </div>
        </div>
    </section>

    <section class="vc-gallery">
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
<script>
var swiper = new Swiper(".vcSwiper", {

    loop: true,
    speed: 1200,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    spaceBetween: 30,
    breakpoints: {
        1400: {
            slidesPerView: 4
        },
        1024: {
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