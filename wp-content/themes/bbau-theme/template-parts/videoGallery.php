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

<!-- ✅ CENTER MAIN HEADING -->
<h2 class="vg-title">Video <span>Gallery</span></h2>

<!-- ================= CARDS ================= -->
<div id="vgCards" class="vg-grid">
<?php
$i=0;
if( have_rows('video_gallery') ):
while( have_rows('video_gallery') ): the_row();
?>
<div class="vg-card" onclick="openVideoSection(<?php echo $i;?>)">

    <div class="vg-card-cover" style="background-image:url('<?php echo get_sub_field('video_background')['url']; ?>')">
        <div class="vg-overlay"></div>
        <div class="vg-play"><i class="fas fa-play"></i></div>
    </div>

    <div class="vg-card-body">
        <!-- ✅ CENTER CARD TITLE -->
        <h3><?php echo esc_html(get_sub_field('video_title')); ?></h3>
    </div>

</div>
<?php $i++; endwhile; endif; ?>
</div>

<!-- ================= DETAILS ================= -->
<div id="vgDetails">
<?php
$i=0;
if( have_rows('video_gallery') ):
while( have_rows('video_gallery') ): the_row();
?>

<div class="vg-detail" id="video-<?php echo $i;?>">

<h3 class="vg-subtitle"><?php echo esc_html(get_sub_field('video_title')); ?></h3>

<button class="eg-back-btn" onclick="goBackVideo()">
    <i class="fa-solid fa-arrow-left"></i>
    Back to Gallery
</button>

<?php if( have_rows('video_year') ): ?>
<?php while( have_rows('video_year') ): the_row(); ?>

<div class="vg-year">
<h3 class="vg-year-title"><?php echo esc_html(get_sub_field('year_title')); ?></h3>

<div class="vg-video-grid">

<?php if( have_rows('videos') ): ?>
<?php while( have_rows('videos') ): the_row();

$vtitle = get_sub_field('video_name');
$vurl   = get_sub_field('video_url');

if(empty($vurl)) continue;

$videoId = "";
if(strpos($vurl,"watch?v=")!==false){ $videoId = explode("watch?v=",$vurl)[1]; }
elseif(strpos($vurl,"youtu.be/")!==false){ $videoId = explode("youtu.be/",$vurl)[1]; }

if(strpos($videoId,"&")!==false){ $videoId = explode("&",$videoId)[0]; }

$thumb = "https://img.youtube.com/vi/".$videoId."/hqdefault.jpg";
?>

<div class="vg-video-card" onclick='openVideo("<?php echo esc_url($vurl); ?>")'>

    <div class="vg-thumb-img">
        <img src="<?php echo $thumb; ?>">
        <div class="vg-play-btn">
            <i class="fas fa-play"></i>
        </div>
    </div>

    <div class="vg-video-title"><?php echo esc_html($vtitle); ?></div>

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

<!-- ================= LIGHTBOX ================= -->
<div id="vgLightbox" class="vg-lightbox">

    <div class="vg-close-btn" onclick="closeVideo()">
        <i class="fa-solid fa-xmark"></i>
        <span>Close</span>
    </div>

    <div class="vg-video-wrap" onclick="event.stopPropagation()">
        <iframe id="vgVideoFrame" frameborder="0" allow="autoplay" allowfullscreen></iframe>
    </div>

</div>

</div>

<!-- ================= CSS ================= -->
<style>

#vgDetails { display:none; }
.vg-detail { display:none; }

/* ===== MAIN HEADING ===== */
.vg-title {
    text-align: center;
}
#vgDetails .vg-video-title {
    text-align: center;
}

/* ===== CARD GRID ===== */
.vg-grid {
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:30px;
}

.vg-card {
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
    cursor:pointer;
    transition:0.3s;
}
.vg-card:hover { transform:translateY(-6px); }

.vg-card-cover {
    height:260px;
    background-size:cover;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
}

.vg-overlay { position:absolute; inset:0; background:rgba(0,0,0,0.4); }

.vg-play { font-size:50px; color:#fff; }

.vg-card-body h3 {
    text-align:center;
}

/* ===== VIDEO GRID ===== */
.vg-video-grid {
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
}

.vg-video-card {
    border-radius:18px;
    overflow:hidden;
    background:#fff;
    cursor:pointer;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

/* FIX PLAY BUTTON */
.vg-thumb-img { position:relative; }

.vg-thumb-img img {
    width:100%;
    height:180px;
    object-fit:cover;
}

.vg-play-btn {
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    width:60px;
    height:60px;
    border-radius:50%;
    background:rgba(255,0,0,0.9);
    display:flex;
    align-items:center;
    justify-content:center;
}

/* ===== YEAR COLORS (ONLY INNER PAGE) ===== */
#vgDetails .vg-year-title {
  display:inline-block;
  padding:8px 14px;
  border-radius:10px;
  font-weight:600;
}

#vgDetails .vg-year:nth-child(1) .vg-year-title {
  background:#f5f0e8;
  color:#8B0000;
}

#vgDetails .vg-year:nth-child(2) .vg-year-title {
  background:#e8f5f2;
  color:#00695c;
}

#vgDetails .vg-year:nth-child(3) .vg-year-title {
  background:#f3e8f5;
  color:#6a1b9a;
}

#vgDetails .vg-year:nth-child(4) .vg-year-title {
  background:#e8eef5;
  color:#1a237e;
}

/* ===== LIGHTBOX ===== */
.vg-lightbox {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.95);
    justify-content:center;
    align-items:center;
    z-index:99999;
}

.vg-video-wrap iframe {
    width:800px;
    height:450px;
    max-width:90vw;
}

/* CLOSE BUTTON */
.vg-close-btn {
    position:absolute;
    top:20px;
    right:25px;
    display:flex;
    gap:6px;
    background:rgba(0,0,0,0.6);
    color:#fff;
    padding:6px 12px;
    border-radius:20px;
    cursor:pointer;
}
.vg-close-btn:hover { background:#fff; color:#000; }

/* BACK BUTTON */
.eg-back-btn {
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:8px 16px;
  margin-bottom:15px;
  background:#f5f0e8;
  color:#8B0000;
  border:none;
  border-radius:20px;
  cursor:pointer;
}
.eg-back-btn:hover { background:#8B0000; color:#fff; }

/* RESPONSIVE */
@media(max-width:992px){
    .vg-grid,.vg-video-grid { grid-template-columns:repeat(2,1fr); }
}
@media(max-width:600px){
    .vg-grid,.vg-video-grid { grid-template-columns:1fr; }
}

/* HEADER FIX */
body.vg-open { overflow:hidden; }
body.vg-open header { position:static !important; }

</style>

<!-- ================= JS ================= -->
<script>
function openVideoSection(id){
    document.getElementById("vgCards").style.display="none";
    document.getElementById("vgDetails").style.display="block";
    document.querySelectorAll(".vg-detail").forEach(el=>el.style.display="none");
    document.getElementById("video-"+id).style.display="block";
}

function goBackVideo(){
    document.getElementById("vgCards").style.display="grid";
    document.getElementById("vgDetails").style.display="none";
}

function openVideo(url){
    let id="";
    if(url.includes("watch?v=")){ id=url.split("watch?v=")[1]; }
    else if(url.includes("youtu.be/")){ id=url.split("youtu.be/")[1]; }

    if(id.includes("&")){ id=id.split("&")[0]; }

    document.getElementById("vgVideoFrame").src =
        "https://www.youtube.com/embed/"+id+"?autoplay=1";

    document.getElementById("vgLightbox").style.display="flex";
    document.body.classList.add("vg-open");
}

function closeVideo(){
    document.getElementById("vgLightbox").style.display="none";
    document.getElementById("vgVideoFrame").src="";
    document.body.classList.remove("vg-open");
}

document.getElementById("vgLightbox").addEventListener("click",function(e){
    if(e.target===this) closeVideo();
});
</script>

<?php get_footer(); ?>