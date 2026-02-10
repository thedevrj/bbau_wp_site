<?php
/*
Template Name: University Kulgeet
*/
defined('ABSPATH') || exit;
get_header();
?>
<div class="uni-kulgeet page-bg page-template-about-bg overflow-hidden">

    <!-- Hero -->
    <section class="kulgeet-hero text-center">
        <h1 class="mb-4"><?php the_title(); ?></h1>
        <span class="kulgeet-subtitle">The Soul of Our University</span>
        <?php get_template_part('template-parts/breadcrumb'); ?>
    </section>

    <!-- Video -->
    <section class="kulgeet-video container">
        <div class="video-wrapper">
            <?php
            if(have_posts()) :
            while (have_posts()) : the_post();
                the_content(); 
            endwhile;
            endif;
            ?>
        </div>
    </section>

    <!-- About -->
    <section class="kulgeet-about container">
        <h2>About the Kulgeet</h2>
        <p>
            The University Kulgeet reflects the ethos, values, and
            academic heritage of the institution. It is sung on
            ceremonial occasions and important university events.
        </p>
    </section>

    <!-- Lyrics -->
    <section class="kulgeet-lyrics container">
        <h2>Kulgeet Lyrics</h2>
        <div class="lyrics-box">
            <?php echo get_field('kulgeet_lyrics'); ?>
        </div>
    </section>

</div>

<?php get_footer(); ?>
<style>
.kulgeet-hero {
    padding: 60px 20px;
    background: linear-gradient(135deg, #003366, #00509e);
    color: #fff;
}

.kulgeet-hero h1 {
    font-size: 36px;
    margin-bottom: 10px;
}

.kulgeet-subtitle {
    font-size: 18px;
    opacity: 0.9;
}

.kulgeet-video {
    margin-top: -40px;
}

.video-wrapper {
    background: #fff;
    padding: 16px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.video-wrapper iframe {
    width: 100%;
    aspect-ratio: 16 / 9;
    border-radius: 8px;
}

.kulgeet-about,
.kulgeet-lyrics {
    padding: 40px 20px;
}

.kulgeet-about h2,
.kulgeet-lyrics h2 {
    margin-bottom: 16px;
    color: #003366;
}

.lyrics-box {
    background: #fff;
    padding: 24px;
    border-left: 4px solid #00509e;
    font-size: 18px;
    line-height: 1.8;
}
</style>