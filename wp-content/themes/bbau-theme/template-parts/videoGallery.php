<?php
/*
Template Name: Video Gallery
*/
defined('ABSPATH') || exit;
get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="container-fluid page-bg py-lg-5 overflow-hidden">
<?php get_template_part('template-parts/breadcrumb'); ?>

<section class="vg-section">
<div class="container">

<h2 class="vg-title">Video <span>Gallery</span></h2>

<!-- ================= OUTER CARDS ================= -->
<div id="vgCards" class="vg-grid">

<?php
$i=0;
if( have_rows('video_gallery') ):
while( have_rows('video_gallery') ): the_row();

$title = get_sub_field('video_title');
$bg    = get_sub_field('video_background');
$bg_url = $bg ? $bg['url'] : '';
?>

<div class="vg-card" onclick="openVideoSection(<?php echo $i;?>)">

    <div class="vg-card-cover" style="background-image:url('<?php echo esc_url($bg_url); ?>');">

        <div class="vg-overlay"></div>

        <div class="vg-play">
            <i class="fas fa-play"></i>
        </div>

    </div>

    <div class="vg-card-body">
        <h3><?php echo esc_html($title); ?></h3>
    </div>

</div>

<?php $i++; endwhile; endif; ?>

</div>


<!-- ================= VIDEO DETAILS ================= -->
<div id="vgDetails">

<?php
$i=0;
if( have_rows('video_gallery') ):
while( have_rows('video_gallery') ): the_row();

$title = get_sub_field('video_title');
?>

<div class="vg-detail" id="video-<?php echo $i;?>">

<!-- SAME STRUCTURE LIKE EVENT PAGE -->

<h3 class="vg-subtitle"><?php echo esc_html($title); ?></h3>

<a class="vg-back" onclick="goBackVideo()">← Back to Videos</a>

<?php if( have_rows('video_year') ): ?>
<?php while( have_rows('video_year') ): the_row();

$year = get_sub_field('year_title');
?>

<div class="vg-year">

<h3 class="vg-year-title"><?php echo esc_html($year); ?></h3>

<div class="vg-video-grid">

<?php if( have_rows('videos') ): ?>
<?php while( have_rows('videos') ): the_row();

$vtitle = get_sub_field('video_name');
$vurl   = get_sub_field('video_url');

if(empty($vurl)) continue;

/* YOUTUBE ID */
$videoId = "";

if(strpos($vurl, "watch?v=") !== false){
    $videoId = explode("watch?v=", $vurl)[1];
} elseif(strpos($vurl, "youtu.be/") !== false){
    $videoId = explode("youtu.be/", $vurl)[1];
}

if(strpos($videoId, "&") !== false){
    $videoId = explode("&", $videoId)[0];
}

$thumb = "https://img.youtube.com/vi/".$videoId."/hqdefault.jpg";
?>

<div class="vg-video-card" onclick='openVideo("<?php echo esc_url($vurl); ?>")'>

    <div class="vg-thumb-img">
        <img src="<?php echo $thumb; ?>">
        <div class="vg-play-btn">
            <i class="fas fa-play"></i>
        </div>
    </div>

    <div class="vg-video-title">
        <?php echo esc_html($vtitle); ?>
    </div>

</div>

<?php endwhile; endif; ?>

</div>
</div>

<?php endwhile; endif; ?>

</div>

<?php $i++; endwhile; endif; ?>

</div>

</div>
</section>

<!-- LIGHTBOX -->
<div id="vgLightbox" class="vg-lightbox" onclick="closeVideo()">
    <div class="vg-video-wrap" onclick="event.stopPropagation()">
        <iframe id="vgVideoFrame" src="" frameborder="0" allow="autoplay" allowfullscreen></iframe>
    </div>
</div>

</div>

<style>

/* ===== KEEP YOUR DESIGN SAME ===== */

#vgDetails { display:none; }
.vg-detail { display:none; }

.vg-subtitle {
    font-size: 28px;
    margin: 10px 0;
}

.vg-back {
    display: inline-block;
    margin-bottom: 20px;
    cursor: pointer;
}

/* (YOUR OLD CSS REMAINS SAME BELOW) */

.vg-section {
    padding: 70px 0;
    background: #faf7f2;
}

.vg-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.vg-card {
    display: block;
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    text-decoration: none !important;
    color: inherit !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
}

.vg-card:hover {
    transform: translateY(-6px);
}

.vg-card-cover {
    width: 100%;
    height: 260px;
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.vg-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.4);
}

.vg-play {
    position: relative;
    z-index: 2;
    font-size: 50px;
    color: #fff;
}

.vg-card-body {
    padding: 20px;
    text-align: center;
}

.vg-card-body h3 {
    font-size: 24px;
    color: #7a008c;
}

.vg-video-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.vg-video-card {
    border-radius: 18px;
    overflow: hidden;
    background: #fff;
    cursor: pointer;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
}

.vg-video-card:hover {
    transform: translateY(-6px);
}

.vg-thumb-img {
    position: relative;
}

.vg-thumb-img img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.vg-thumb-img::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.25);
}

.vg-play-btn {
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
}

.vg-play-btn i {
    color: #fff;
}

.vg-video-title {
    padding: 15px;
    text-align: center;
}

.vg-lightbox {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.9);
    justify-content: center;
    align-items: center;
}

.vg-video-wrap iframe {
    width: 800px;
    height: 450px;
    max-width: 90vw;
}

@media(max-width:1000px) {
    .vg-grid { grid-template-columns: repeat(2, 1fr); }
    .vg-video-grid { grid-template-columns: repeat(2, 1fr); }
}

@media(max-width:600px) {
    .vg-grid, .vg-video-grid { grid-template-columns: 1fr; }
}

</style>

<script>

function openVideoSection(id){
    document.getElementById("vgCards").style.display="none";
    document.getElementById("vgDetails").style.display="block";

    document.querySelectorAll(".vg-detail").forEach(el => el.style.display="none");
    document.getElementById("video-"+id).style.display="block";
}

function goBackVideo(){
    document.getElementById("vgCards").style.display="grid";
    document.getElementById("vgDetails").style.display="none";
}

function openVideo(url){

    let id="";

    if (url.includes("watch?v=")) {
        id = url.split("watch?v=")[1];
    } else if (url.includes("youtu.be/")) {
        id = url.split("youtu.be/")[1];
    }

    if (id.includes("&")) {
        id = id.split("&")[0];
    }

    document.getElementById("vgVideoFrame").src =
        "https://www.youtube.com/embed/" + id + "?autoplay=1";

    document.getElementById("vgLightbox").style.display = "flex";
}

function closeVideo(){
    document.getElementById("vgLightbox").style.display="none";
    document.getElementById("vgVideoFrame").src="";
}

</script>

<?php get_footer(); ?>