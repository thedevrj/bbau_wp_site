<?php
/*
Template Name: Video Gallery
*/

defined('ABSPATH') || exit;
get_header();
?>
<?php get_template_part('banners/about-banner'); ?>
<div class="container-fluid page-bg py-lg-5 overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>
    <section class="vg-section">
        <div class="container">
            <h2 class="vg-title">Video <span>Gallery</span></h2>
            <?php
$video_index = isset($_GET['video']) ? intval($_GET['video']) : -1;
$repeater = 'video_gallery';
?>
            <?php if($video_index === -1): ?>
            <!-- VIDEO CARDS -->
            <div class="vg-grid">
                <?php
$vi = 0;
if( have_rows($repeater) ):
while( have_rows($repeater) ): the_row();
$title = get_sub_field('video_title');
$bg    = get_sub_field('video_background');
$bg_url = $bg ? $bg['url'] : '';
?>
                <a href="?video=<?php echo $vi; ?>" class="vg-card">
                    <div class="vg-card-cover" style="background-image:url('<?php echo esc_url($bg_url); ?>')">
                        <div class="vg-overlay"></div>
                        <div class="vg-play">▶</div>
                    </div>
                    <div class="vg-card-body">
                        <h3><?php echo esc_html($title); ?></h3>
                    </div>
                </a>
                <?php
$vi++;
endwhile;
endif;
?>
            </div>
            <?php else: ?>
            <!-- VIDEO DETAIL PAGE -->
            <?php
$vi=0;
if( have_rows($repeater) ):
while( have_rows($repeater) ): the_row();
if($vi==$video_index):
$title = get_sub_field('video_title');
?> <br>
            <a href="?" class="vg-back">← Back to Videos</a><br>
            <h2 class="vg-title"><?php echo esc_html($title); ?></h2>

            <?php if( have_rows('video_years') ): ?>
            <?php while( have_rows('video_years') ): the_row();
$year = get_sub_field('year_title');
?>
            <div class="vg-year">
                <h3><?php echo esc_html($year); ?></h3>
                <div class="vg-video-grid">
                    <?php if( have_rows('videos') ): ?>
                    <?php while( have_rows('videos') ): the_row();
$vtitle = get_sub_field('video_name');
$vurl   = get_sub_field('video_url');
?>
                    <div class="vg-video-card" onclick="openVideo('<?php echo esc_url($vurl); ?>')">
                        <div class="vg-thumb">▶</div>
                        <div class="vg-video-title">
                            <?php echo esc_html($vtitle); ?>
                        </div>
                    </div>
                    <?php endwhile; endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
            <?php endif; ?>
            <?php
endif;
$vi++;
endwhile;
endif;
?>
            <?php endif; ?>
        </div>
    </section>
    <!-- VIDEO LIGHTBOX -->
    <div id="vgLightbox" class="vg-lightbox" onclick="closeVideo()">
        <div class="vg-video-wrap">
            <iframe id="vgVideoFrame" src="" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>
<style>
.vg-section {
    padding: 70px 0;
    background: #faf7f2;
}

.vg-container {
    max-width: 1200px;
    margin: auto;
    padding: 0 30px;
}

.vg-title {
    font-size: 32px;
    margin-bottom: 30px;
}

.vg-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

.vg-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    text-decoration: none;
    color: black;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.vg-card-cover {
    height: 180px;
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.vg-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.45);
}

.vg-play {
    position: relative;
    font-size: 40px;
    color: white;
}

.vg-card-body {
    padding: 18px;
    text-align: center;
}

.vg-video-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.vg-video-card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    cursor: pointer;
    text-align: center;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.vg-thumb {
    font-size: 40px;
    margin-bottom: 10px;
}

.vg-lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.vg-video-wrap iframe {
    width: 800px;
    height: 450px;
    max-width: 90vw;
}

@media(max-width:900px) {
    .vg-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .vg-video-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media(max-width:600px) {
    .vg-grid {
        grid-template-columns: 1fr;
    }

    .vg-video-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<script>
function openVideo(url) {
    var embed = url.replace("watch?v=", "embed/");
    document.getElementById("vgVideoFrame").src = embed;
    document.getElementById("vgLightbox").style.display = "flex";
}

function closeVideo() {
    document.getElementById("vgLightbox").style.display = "none";
    document.getElementById("vgVideoFrame").src = "";
}
</script>
<?php get_footer(); ?>