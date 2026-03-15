<?php  
/*
Template Name: Press Media Gallery
*/
defined('ABSPATH') || exit;
get_header();
?>
<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid page-bg py-lg-5 overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>
        <div class="container">
            <h2>Press & <span>Media Gallery</span></h2>
            <?php
$media_index = isset($_GET['media']) ? intval($_GET['media']) : -1;
$repeater = 'press_media_gallery';
?>
            <?php if($media_index === -1): ?>
            <!-- ================= MEDIA CARDS ================= -->
            <div class="pm-cards-grid">
                <?php
$ci=0;
if( have_rows($repeater) ):
while( have_rows($repeater) ): the_row();
$title = get_sub_field('news_title');
$type  = get_sub_field('news_type');
$bg    = get_sub_field('card_background');
$bg_url = '';
if($bg){
$bg_url = $bg['url'];
}
?>
                <a href="?media=<?php echo $ci;?>" class="pm-card">
                    <div class="pm-card-cover" style="background-image:url('<?php echo esc_url($bg_url); ?>')">
                        <div class="pm-cover-overlay"></div>
                        <div class="pm-cover-icon">📰</div>
                    </div>
                    <div class="pm-card-body">
                        <h3 class="pm-card-title"><?php echo esc_html($title); ?></h3>
                    </div>
                </a>
                <?php
$ci++;
endwhile;
endif;
?>

            </div>
            <?php else: ?>
            <!-- ================= MEDIA DETAIL ================= -->
            <?php
$ci=0;
if( have_rows($repeater) ):
while( have_rows($repeater) ): the_row();
if($ci==$media_index):
$title = get_sub_field('news_title');
?><br>
            <a href="?" class="link-new">← Back to Media</a><br>
            <h3><?php echo esc_html($title); ?></h3>
            <?php if( have_rows('media_years') ): ?>
            <?php while( have_rows('media_years') ): the_row();
$year = get_sub_field('year_title');
$photos = get_sub_field('media_photos');
?>
            <div class="pm-year-block">
                <h3 class="pm-year-title"><?php echo esc_html($year); ?></h3>
                <div class="pm-photo-grid">
                    <?php foreach($photos as $photo): ?>
                    <img src="<?php echo esc_url($photo['url']); ?>" class="pm-photo"
                        onclick="pmOpenImage('<?php echo $photo['url']; ?>')">
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endwhile; ?>
            <?php endif; ?>
            <?php
endif;
$ci++;
endwhile;
endif;
?>
            <?php endif; ?>
        </div>
    <!-- LIGHTBOX -->
    <div id="pmLightbox" class="pm-lightbox" onclick="pmCloseImage()">
        <img id="pmLightboxImg">
    </div>
</div>
<style>


.pm-cards-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}
.pm-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    text-decoration: none;
    color: black;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
}
.pm-card:hover {
    transform: translateY(-6px);
}
.pm-card-cover {
    height: 180px;
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pm-cover-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.45);
}

.pm-cover-icon {
    position: relative;
    font-size: 40px;
    color: white;
    z-index: 2;
}
.pm-card-body {
    padding: 18px;
    text-align: center;
}
.pm-card-title {
    margin: 0;
    font-size: 18px;
}
.pm-year-block {
    margin-top: 40px;
}
.pm-year-title {
    font-size: 22px;
    margin-bottom: 15px;
}
.pm-photo-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}
.pm-photo {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}
.pm-photo:hover {
    transform: scale(1.05);
}
.pm-lightbox {
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
.pm-lightbox img {
    max-width: 90%;
    max-height: 90%;
    border-radius: 10px;
}
@media(max-width:900px) {
    .pm-cards-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .pm-photo-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media(max-width:600px) {
    .pm-cards-grid {
        grid-template-columns: 1fr;
    }
    .pm-photo-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<script>
function pmOpenImage(src) {
    document.getElementById("pmLightboxImg").src = src;
    document.getElementById("pmLightbox").style.display = "flex";
}
function pmCloseImage() {
    document.getElementById("pmLightbox").style.display = "none";
}
</script>
<?php get_footer(); ?>