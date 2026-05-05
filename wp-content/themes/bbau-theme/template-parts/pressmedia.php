<?php  
/*
Template Name: Press Media Gallery
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
        <h2>Press & <span>Media Gallery</span></h2>

        <!-- MEDIA CARDS -->
        <div id="egCards" class="eg-grid">
            <?php
            $i = 0;
            if( have_rows('press_media_gallery') ):
            while( have_rows('press_media_gallery') ): the_row();
            ?>
            <div class="eg-card" onclick="openEvent(<?php echo $i; ?>)">
                <img src="<?php echo esc_url(get_sub_field('card_background')['url']); ?>" class="eg-cover">
                <div class="eg-card-name"><?php echo esc_html(get_sub_field('news_title')); ?></div>
            </div>
            <?php $i++; endwhile; endif; ?>
        </div>

        <!-- DETAILS -->
        <div id="egDetails">
            <?php
            $i = 0;
            if( have_rows('press_media_gallery') ):
            while( have_rows('press_media_gallery') ): the_row();
            ?>
            <div class="eg-event-detail" id="event-<?php echo $i; ?>">

                <h3><?php echo esc_html(get_sub_field('news_title')); ?></h3>

                <button class="eg-back-btn" onclick="goBack()">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Gallery
                </button>

                <?php if( have_rows('media_years') ): ?>
                <?php while( have_rows('media_years') ): the_row(); ?>
                <div class="eg-year-block">
                    <h3 class="eg-year-title"><?php echo esc_html(get_sub_field('year_title')); ?></h3>

                    <div class="eg-photo-grid">
                        <?php foreach( get_sub_field('media_photos') as $photo ): ?>
                        <img src="<?php echo esc_url($photo['url']); ?>" class="eg-photo" onclick="openImage(this)">
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endwhile; endif; ?>

            </div>
            <?php $i++; endwhile; endif; ?>
        </div>
    </div>

    <!-- LIGHTBOX -->
    <div id="egLightbox" class="eg-lightbox">

        <div class="eg-close-btn" onclick="closeImage()">
            <i class="fa-solid fa-xmark"></i>
            <span>Close</span>
        </div>

        <div class="eg-prev" onclick="prevImage()">
            <i class="fa-solid fa-chevron-left"></i>
        </div>

        <img id="egLightboxImg">

        <div class="eg-next" onclick="nextImage()">
            <i class="fa-solid fa-chevron-right"></i>
        </div>

    </div>
</div>
<!-- ================= CSS ================= -->
<style>
/* ===== EXISTING PM STYLES (unchanged) ===== */

.pm-cards-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:25px; }

.pm-card { background:#fff; border-radius:12px; overflow:hidden; text-decoration:none; color:#000;
box-shadow:0 8px 25px rgba(0,0,0,0.1); transition:.3s; }
.pm-card:hover { transform:translateY(-6px); }

.pm-card-cover { height:180px; background-size:cover; display:flex; align-items:center; justify-content:center; position:relative; }
.pm-cover-overlay { position:absolute; inset:0; background:rgba(0,0,0,0.45); }
.pm-cover-icon { position:relative; font-size:40px; color:#fff; }
.pm-card-body { padding:18px; text-align:center; }

.pm-photo-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:15px; }
.pm-photo { width:100%; height:200px; object-fit:cover; border-radius:8px; cursor:pointer; }
.pm-photo:hover { transform:scale(1.05); }

.pm-lightbox {
    display:none; position:fixed; inset:0;
    background:rgba(0,0,0,0.95);
    align-items:center; justify-content:center;
    z-index:99999; touch-action:pan-y;
}
.pm-lightbox img { max-width:90%; max-height:85vh; border-radius:10px; transition:transform .3s ease; }

.pm-prev,.pm-next {
    position:absolute; top:50%; font-size:28px; color:#fff;
    padding:10px; transform:translateY(-50%);
    background:rgba(0,0,0,0.4); border-radius:50%; cursor:pointer;
}
.pm-prev { left:15px; }
.pm-next { right:15px; }

.pm-close-btn {
    position:absolute; top:20px; right:25px;
    display:flex; align-items:center; gap:6px;
    background:rgba(0,0,0,0.6); color:#fff;
    padding:6px 12px; border-radius:20px; cursor:pointer;
}
.pm-close-btn:hover { background:#fff; color:#000; }

.pm-year-title {
    display:inline-block; padding:8px 14px;
    border-radius:10px; font-weight:600;
}
.pm-year-block:nth-of-type(1) .pm-year-title { background:#f5f0e8; color:#8B0000; }
.pm-year-block:nth-of-type(2) .pm-year-title { background:#e8f5f2; color:#00695c; }
.pm-year-block:nth-of-type(3) .pm-year-title { background:#f3e8f5; color:#6a1b9a; }
.pm-year-block:nth-of-type(4) .pm-year-title { background:#e8eef5; color:#1a237e; }
.pm-year-block:nth-of-type(5) .pm-year-title { background:#fff3e0; color:#e65100; }

body.pm-open { overflow:hidden; }
body.pm-open header { position:static !important; }

@media(max-width:992px){ .pm-cards-grid,.pm-photo-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:600px){ .pm-cards-grid,.pm-photo-grid { grid-template-columns:1fr; } }

/* ===== NEW EG- CLASSES FOR EVENT GALLERY STYLE ===== */

#egDetails { display:none; }
.eg-event-detail { display:none; }

.eg-grid {
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:25px;
}

.eg-card {
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 8px 25px rgba(0,0,0,0.1);
    cursor:pointer;
    transition:.3s;
}
.eg-card:hover { transform:translateY(-6px); }

.eg-cover {
    width:100%;
    height:180px;
    object-fit:cover;
    display:block;
}

.eg-card-name {
    padding:18px;
    text-align:center;
    font-weight:600;
}

.eg-photo-grid {
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:15px;
}

.eg-photo {
    width:100%;
    height:200px;
    object-fit:cover;
    border-radius:8px;
    cursor:pointer;
    transition:transform .3s;
}
.eg-photo:hover { transform:scale(1.05); }

/* YEAR TITLE */
#egDetails .eg-year-title {
    display:inline-block;
    padding:8px 14px;
    border-radius:10px;
    font-weight:600;
    margin-top:12px;
    margin-bottom:12px;
}
.eg-event-detail .eg-year-block:nth-of-type(1) .eg-year-title { background:#f5f0e8; color:#8B0000; }
.eg-event-detail .eg-year-block:nth-of-type(2) .eg-year-title { background:#e8f5f2; color:#00695c; }
.eg-event-detail .eg-year-block:nth-of-type(3) .eg-year-title { background:#f3e8f5; color:#6a1b9a; }
.eg-event-detail .eg-year-block:nth-of-type(4) .eg-year-title { background:#e8eef5; color:#1a237e; }
.eg-event-detail .eg-year-block:nth-of-type(5) .eg-year-title { background:#fff3e0; color:#e65100; }

/* LIGHTBOX */
.eg-lightbox {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.95);
    align-items:center;
    justify-content:center;
    z-index:99999;
    touch-action:pan-y;
}

.eg-lightbox img#egLightboxImg {
    max-width:90%;
    max-height:85vh;
    border-radius:10px;
    transition:transform .3s ease;
}

.eg-prev, .eg-next {
    position:absolute;
    top:50%;
    font-size:28px;
    color:#fff;
    padding:10px;
    transform:translateY(-50%);
    background:rgba(0,0,0,0.4);
    border-radius:50%;
    cursor:pointer;
}
.eg-prev { left:15px; }
.eg-next { right:15px; }

.eg-close-btn {
    position:absolute;
    top:20px;
    right:25px;
    display:flex;
    align-items:center;
    gap:6px;
    background:rgba(0,0,0,0.6);
    color:#fff;
    padding:6px 12px;
    border-radius:20px;
    cursor:pointer;
    border:none;
}
.eg-close-btn:hover { background:#fff; color:#000; }

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
    font-size:14px;
    font-weight:600;
    cursor:pointer;
}
.eg-back-btn:hover { background:#8B0000; color:#fff; }

/* RESPONSIVE */
@media(max-width:992px){ .eg-grid,.eg-photo-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:600px){ .eg-grid,.eg-photo-grid { grid-template-columns:1fr; } }

/* HEADER FIX */
body.eg-open { overflow:hidden; }
body.eg-open header { position:static !important; }
</style>

<!-- ================= JS ================= -->
<script>
let pmImages=[], pmIndex=0, pmZoom=false;

/* OPEN */
function pmOpenImage(el){
    pmImages = Array.from(el.parentNode.querySelectorAll('img'));
    pmIndex = pmImages.indexOf(el);
    document.body.classList.add("pm-open");
    pmShow();
}

function pmShow(){
    const box=document.getElementById("pmLightbox");
    const img=document.getElementById("pmLightboxImg");
    box.style.display="flex";
    img.src=pmImages[pmIndex].src;
    img.style.transform="scale(1)";
    pmZoom=false;
}

function pmNext(){ pmIndex=(pmIndex+1)%pmImages.length; pmShow(); }
function pmPrev(){ pmIndex=(pmIndex-1+pmImages.length)%pmImages.length; pmShow(); }

function pmCloseImage(){
    document.getElementById("pmLightbox").style.display="none";
    document.body.classList.remove("pm-open");
}

/* CLICK OUTSIDE */
document.getElementById("pmLightbox").addEventListener("click",function(e){
    if(e.target===this) pmCloseImage();
});

/* KEYBOARD */
document.addEventListener("keydown",function(e){
    if(document.getElementById("pmLightbox").style.display==="flex"){
        if(e.key==="ArrowRight") pmNext();
        if(e.key==="ArrowLeft") pmPrev();
        if(e.key==="Escape") pmCloseImage();
    }
});

/* SWIPE */
let startX=0;
document.getElementById("pmLightbox").addEventListener("touchstart",e=>{
    startX=e.touches[0].clientX;
});
document.getElementById("pmLightbox").addEventListener("touchend",e=>{
    let diff=startX-e.changedTouches[0].clientX;
    if(Math.abs(diff)>60){ diff>0?pmNext():pmPrev(); }
});

/* DOUBLE TAP */
let lastTap=0;
document.getElementById("pmLightboxImg").addEventListener("touchend",function(){
    let t=new Date().getTime(),tap=t-lastTap;
    if(tap<300 && tap>0){
        pmZoom=!pmZoom;
        this.style.transform=pmZoom?"scale(2)":"scale(1)";
    }
    lastTap=t;
});/* ===== EXISTING PM JS (unchanged) ===== */
let pmImages = [], pmIndex = 0, pmZoom = false;

function pmOpenImage(el) {
    pmImages = Array.from(el.parentNode.querySelectorAll('img'));
    pmIndex = pmImages.indexOf(el);
    document.body.classList.add("pm-open");
    pmShow();
}
function pmShow() {
    const box = document.getElementById("pmLightbox");
    const img = document.getElementById("pmLightboxImg");
    box.style.display = "flex";
    img.src = pmImages[pmIndex].src;
    img.style.transform = "scale(1)";
    pmZoom = false;
}
function pmNext() { pmIndex = (pmIndex + 1) % pmImages.length; pmShow(); }
function pmPrev() { pmIndex = (pmIndex - 1 + pmImages.length) % pmImages.length; pmShow(); }
function pmCloseImage() {
    document.getElementById("pmLightbox").style.display = "none";
    document.body.classList.remove("pm-open");
}

document.getElementById("pmLightbox").addEventListener("click", function(e) {
    if (e.target === this) pmCloseImage();
});
document.addEventListener("keydown", function(e) {
    if (document.getElementById("pmLightbox").style.display === "flex") {
        if (e.key === "ArrowRight") pmNext();
        if (e.key === "ArrowLeft") pmPrev();
        if (e.key === "Escape") pmCloseImage();
    }
});
let startX = 0;
document.getElementById("pmLightbox").addEventListener("touchstart", e => { startX = e.touches[0].clientX; });
document.getElementById("pmLightbox").addEventListener("touchend", e => {
    let diff = startX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 60) { diff > 0 ? pmNext() : pmPrev(); }
});
let lastTap = 0;
document.getElementById("pmLightboxImg").addEventListener("touchend", function() {
    let t = new Date().getTime(), tap = t - lastTap;
    if (tap < 300 && tap > 0) {
        pmZoom = !pmZoom;
        this.style.transform = pmZoom ? "scale(2)" : "scale(1)";
    }
    lastTap = t;
});

/* ===== NEW EG JS FOR PRESS MEDIA GALLERY ===== */
let egImages = [], egIndex = 0, egZoom = false;

function openEvent(id) {
    document.getElementById("egCards").style.display = "none";
    document.getElementById("egDetails").style.display = "block";
    document.querySelectorAll(".eg-event-detail").forEach(el => el.style.display = "none");
    document.getElementById("event-" + id).style.display = "block";
}

function goBack() {
    document.getElementById("egCards").style.display = "grid";
    document.getElementById("egDetails").style.display = "none";
}

function openImage(el) {
    egImages = Array.from(el.parentNode.querySelectorAll('img'));
    egIndex = egImages.indexOf(el);
    document.body.classList.add("eg-open");
    egShow();
}

function egShow() {
    const box = document.getElementById("egLightbox");
    const img = document.getElementById("egLightboxImg");
    box.style.display = "flex";
    img.src = egImages[egIndex].src;
    img.style.transform = "scale(1)";
    egZoom = false;
}

function prevImage() { egIndex = (egIndex - 1 + egImages.length) % egImages.length; egShow(); }
function nextImage() { egIndex = (egIndex + 1) % egImages.length; egShow(); }

function closeImage() {
    document.getElementById("egLightbox").style.display = "none";
    document.getElementById("egLightboxImg").src = "";
    document.body.classList.remove("eg-open");
}

document.getElementById("egLightbox").addEventListener("click", function(e) {
    if (e.target === this) closeImage();
});
document.addEventListener("keydown", function(e) {
    if (document.getElementById("egLightbox").style.display === "flex") {
        if (e.key === "ArrowRight") nextImage();
        if (e.key === "ArrowLeft") prevImage();
        if (e.key === "Escape") closeImage();
    }
});

/* SWIPE */
let egStartX = 0;
document.getElementById("egLightbox").addEventListener("touchstart", e => { egStartX = e.touches[0].clientX; });
document.getElementById("egLightbox").addEventListener("touchend", e => {
    let diff = egStartX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 60) { diff > 0 ? nextImage() : prevImage(); }
});

/* DOUBLE TAP ZOOM */
let egLastTap = 0;
document.getElementById("egLightboxImg").addEventListener("touchend", function() {
    let t = new Date().getTime(), tap = t - egLastTap;
    if (tap < 300 && tap > 0) {
        egZoom = !egZoom;
        this.style.transform = egZoom ? "scale(2)" : "scale(1)";
    }
    egLastTap = t;
});
</script>

<?php get_footer(); ?>