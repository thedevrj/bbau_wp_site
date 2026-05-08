<?php
/*
Template Name: Video Gallery
*/
defined('ABSPATH') || exit;
get_header();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid page-bg py-lg-5 overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>

    <div class="container">
        <div class="menu-wrapper">
            <?php get_template_part('menu/menu'); ?>
        </div>
        <h2>Video Gallery</h2>

        <!-- VIDEO CARDS -->
        <div id="egCards" class="eg-grid">
            <?php
            $i = 0;
            if( have_rows('video_gallery') ):
            while( have_rows('video_gallery') ): the_row();
            ?>
            <div class="eg-card" onclick="openEvent(<?php echo $i; ?>)">
                <img src="<?php echo get_sub_field('video_background')['url']; ?>" class="eg-cover">
                <div class="eg-card-name"><?php echo esc_html(get_sub_field('video_title')); ?></div>
            </div>
            <?php $i++; endwhile; endif; ?>
        </div>

        <!-- DETAILS -->
        <div id="egDetails">
            <?php
            $i = 0;
            if( have_rows('video_gallery') ):
            while( have_rows('video_gallery') ): the_row();
            ?>
            <div class="eg-event-detail" id="event-<?php echo $i; ?>">

                <h3><?php echo esc_html(get_sub_field('video_title')); ?></h3>

                <button class="eg-back-btn" onclick="goBack()">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Gallery
                </button>

                <?php if( have_rows('video_year') ): ?>
                <?php while( have_rows('video_year') ): the_row(); ?>
                <div class="eg-year-block">
                    <h3 class="eg-year-title"><?php echo esc_html(get_sub_field('year_title')); ?></h3>

                    <div class="eg-photo-grid">
                        <?php
                        if( have_rows('videos') ):
                        while( have_rows('videos') ): the_row();
                            $vtitle = get_sub_field('video_name');
                            $vurl   = get_sub_field('video_url');
                            if( empty($vurl) ) continue;

                            $videoId = "";
                            if( strpos($vurl, "watch?v=") !== false ){
                                $videoId = explode("watch?v=", $vurl)[1];
                            } elseif( strpos($vurl, "youtu.be/") !== false ){
                                $videoId = explode("youtu.be/", $vurl)[1];
                            }
                            if( strpos($videoId, "&") !== false ){
                                $videoId = explode("&", $videoId)[0];
                            }
                            $thumb = "https://img.youtube.com/vi/" . $videoId . "/hqdefault.jpg";
                        ?>
                        <div class="eg-photo-wrap" onclick='openVideo("<?php echo esc_url($vurl); ?>")'>
                            <img src="<?php echo $thumb; ?>" class="eg-photo">
                            <div class="eg-play-overlay">
                                <i class="fas fa-play"></i>
                            </div>
                            <?php if( $vtitle ): ?>
                            <div class="eg-video-label"><?php echo esc_html($vtitle); ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endwhile; endif; ?>
                    </div>
                </div>
                <?php endwhile; endif; ?>

            </div>
            <?php $i++; endwhile; endif; ?>
        </div>
    </div>

    <!-- VIDEO LIGHTBOX -->
    <div id="egLightbox" class="eg-lightbox">

        <div class="eg-close-btn" onclick="closeVideo()">
            <i class="fa-solid fa-xmark"></i>
            <span>Close</span>
        </div>

        <div class="eg-video-wrap" onclick="event.stopPropagation()">
            <iframe id="egVideoFrame" frameborder="0" allow="autoplay" allowfullscreen></iframe>
        </div>

    </div>
</div>
<!-- ================= CSS ================= -->
 <style>
/* ===== HIDE ON LOAD ===== */
#egDetails { display: none; }
.eg-event-detail { display: none; }

/* ===== CARD GRID ===== */
.eg-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.eg-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: 0.3s;
}
.eg-card:hover { transform: translateY(-6px); }

.eg-cover {
    width: 100%;
    height: 260px;
    object-fit: cover;
}

.eg-card-name {
    text-align: center;
    padding: 12px;
    font-weight: 600;
}

/* ===== PHOTO / VIDEO GRID ===== */
.eg-photo-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

/* ===== VIDEO THUMBNAIL WRAP ===== */
.eg-photo-wrap {
    border-radius: 18px;
    overflow: hidden;
    background: #fff;
    cursor: pointer;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    position: relative;
}

.eg-photo-wrap .eg-photo {
    width: 100%;
    height: 180px;
    object-fit: cover;
    display: block;
}

.eg-play-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(255, 0, 0, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
}

.eg-play-overlay i {
    color: #fff;
    font-size: 20px;
}

.eg-video-label {
    text-align: center;
    padding: 8px;
    font-size: 13px;
    font-weight: 500;
    background: #fff;
    color: #333;
}

/* ===== YEAR TITLE ===== */
#egDetails .eg-year-title {
    display: inline-block;
    padding: 8px 14px;
    border-radius: 10px;
    font-weight: 600;
    margin-top: 12px;
    margin-bottom: 12px;
}

.eg-event-detail .eg-year-block:nth-of-type(1) .eg-year-title { background: #f5f0e8; color: #8B0000; }
.eg-event-detail .eg-year-block:nth-of-type(2) .eg-year-title { background: #e8f5f2; color: #00695c; }
.eg-event-detail .eg-year-block:nth-of-type(3) .eg-year-title { background: #f3e8f5; color: #6a1b9a; }
.eg-event-detail .eg-year-block:nth-of-type(4) .eg-year-title { background: #e8eef5; color: #1a237e; }
.eg-event-detail .eg-year-block:nth-of-type(5) .eg-year-title { background: #fff3e0; color: #e65100; }

/* ===== LIGHTBOX ===== */
.eg-lightbox {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.95);
    justify-content: center;
    align-items: center;
    z-index: 99999;
}

/* Image lightbox */
.eg-lightbox img#egLightboxImg {
    max-width: 90vw;
    max-height: 85vh;
    border-radius: 10px;
    object-fit: contain;
}

/* Video lightbox */
.eg-video-wrap {
    width: 800px;
    max-width: 90vw;
}

.eg-video-wrap iframe {
    width: 100%;
    height: 450px;
}

/* ===== CLOSE BUTTON ===== */
.eg-close-btn {
    position: absolute;
    top: 20px;
    right: 25px;
    display: flex;
    gap: 6px;
    background: rgba(0,0,0,0.6);
    color: #fff;
    padding: 6px 12px;
    border-radius: 20px;
    cursor: pointer;
    border: none;
}
.eg-close-btn:hover { background: #fff; color: #000; }

/* ===== BACK BUTTON ===== */
.eg-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    margin-bottom: 15px;
    background: #f5f0e8;
    color: #8B0000;
    border: none;
    border-radius: 20px;
    cursor: pointer;
}
.eg-back-btn:hover { background: #8B0000; color: #fff; }

/* ===== RESPONSIVE ===== */
@media(max-width: 992px) {
    .eg-grid, .eg-photo-grid { grid-template-columns: repeat(2, 1fr); }
}
@media(max-width: 600px) {
    .eg-grid, .eg-photo-grid { grid-template-columns: 1fr; }
}

/* ===== HEADER FIX ===== */
body.eg-open { overflow: hidden; }
body.eg-open header { position: static !important; }
</style>
<script>
    /* ===== CARD → DETAIL ===== */
function openEvent(id) {
    document.getElementById("egCards").style.display = "none";
    document.getElementById("egDetails").style.display = "block";
    document.querySelectorAll(".eg-event-detail").forEach(el => el.style.display = "none");
    document.getElementById("event-" + id).style.display = "block";
}

/* ===== BACK TO CARDS ===== */
function goBack() {
    document.getElementById("egCards").style.display = "grid";
    document.getElementById("egDetails").style.display = "none";
}

/* ===== IMAGE LIGHTBOX (Event Gallery) ===== */
let currentImages = [], currentIndex = 0;

function openImage(el) {
    const allImgs = [...document.querySelectorAll(".eg-event-detail[style*='block'] .eg-photo")];
    currentImages = allImgs;
    currentIndex = allImgs.indexOf(el);
    document.getElementById("egLightboxImg").src = el.src;
    document.getElementById("egLightbox").style.display = "flex";
    document.body.classList.add("eg-open");
}

function prevImage() {
    currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
    document.getElementById("egLightboxImg").src = currentImages[currentIndex].src;
}

function nextImage() {
    currentIndex = (currentIndex + 1) % currentImages.length;
    document.getElementById("egLightboxImg").src = currentImages[currentIndex].src;
}

function closeImage() {
    document.getElementById("egLightbox").style.display = "none";
    document.getElementById("egLightboxImg").src = "";
    document.body.classList.remove("eg-open");
}

/* ===== VIDEO LIGHTBOX (Video Gallery) ===== */
function openVideo(url) {
    let id = "";
    if (url.includes("watch?v=")) { id = url.split("watch?v=")[1]; }
    else if (url.includes("youtu.be/")) { id = url.split("youtu.be/")[1]; }
    if (id.includes("&")) { id = id.split("&")[0]; }

    document.getElementById("egVideoFrame").src =
        "https://www.youtube.com/embed/" + id + "?autoplay=1";

    document.getElementById("egLightbox").style.display = "flex";
    document.body.classList.add("eg-open");
}

function closeVideo() {
    document.getElementById("egLightbox").style.display = "none";
    document.getElementById("egVideoFrame").src = "";
    document.body.classList.remove("eg-open");
}

/* ===== LIGHTBOX CLOSE ON BACKDROP CLICK ===== */
document.getElementById("egLightbox").addEventListener("click", function(e) {
    if (e.target === this) {
        closeImage();
        closeVideo();
    }
});
</script>
<?php get_footer(); ?>