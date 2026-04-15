<?php
/*
Template Name: Event Gallery
*/
defined('ABSPATH') || exit;
get_header();
?>

<!-- ✅ FONT AWESOME (REQUIRED) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid page-bg py-lg-5 overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>

    <div class="container">
        <h2>Event Gallery</h2>

        <!-- EVENT CARDS -->
        <div id="egCards" class="eg-grid">
            <?php
            $i=0;
            if( have_rows('event_gallery') ):
            while( have_rows('event_gallery') ): the_row();
            ?>
            <div class="eg-card" onclick="openEvent(<?php echo $i;?>)">
                <img src="<?php echo get_sub_field('event_cover')['url']; ?>" class="eg-cover">
                <div class="eg-card-name"><?php echo esc_html(get_sub_field('event_name')); ?></div>
            </div>
            <?php $i++; endwhile; endif; ?>
        </div>

        <!-- DETAILS -->
        <div id="egDetails">
            <?php
            $i=0;
            if( have_rows('event_gallery') ):
            while( have_rows('event_gallery') ): the_row();
            ?>
            <div class="eg-event-detail" id="event-<?php echo $i;?>">

                <h3><?php echo esc_html(get_sub_field('event_name')); ?></h3>

                <button class="eg-back-btn" onclick="goBack()">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Gallery
                </button>

                <?php if( have_rows('event_year') ): ?>
                <?php while( have_rows('event_year') ): the_row(); ?>
                <div class="eg-year-block">
                    <h3 class="eg-year-title"><?php echo esc_html(get_sub_field('year_title')); ?></h3>

                    <div class="eg-photo-grid">
                        <?php foreach(get_sub_field('year_photos') as $photo): ?>
                        <img src="<?php echo $photo['url']; ?>" class="eg-photo" onclick="openImage(this)">
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

        <!-- CLOSE -->
        <div class="eg-close-btn" onclick="closeImage()">
            <i class="fa-solid fa-xmark"></i>
            <span>Close</span>
        </div>

        <!-- PREV -->
        <div class="eg-prev" onclick="prevImage()">
            <i class="fa-solid fa-chevron-left"></i>
        </div>

        <!-- IMAGE -->
        <img id="egLightboxImg">

        <!-- NEXT -->
        <div class="eg-next" onclick="nextImage()">
            <i class="fa-solid fa-chevron-right"></i>
        </div>

    </div>
</div>

<!-- ================= CSS ================= -->
<style>
.eg-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:25px; }

.eg-card {
    background:#fff; border-radius:12px; overflow:hidden; cursor:pointer;
    box-shadow:0 8px 25px rgba(0,0,0,0.08); transition:.3s;
}
.eg-card:hover { transform:translateY(-6px); }

.eg-cover { width:100%; height:220px; object-fit:cover; }

.eg-card-name { padding:16px; font-size:18px; font-weight:600; text-align:center; }

.eg-photo-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:15px; }

.eg-photo {
    width:100%; height:200px; object-fit:cover;
    border-radius:8px; cursor:pointer; transition:.3s;
}
.eg-photo:hover { transform:scale(1.05); }

#egDetails { display:none; }
.eg-event-detail { display:none; }

/* LIGHTBOX */
.eg-lightbox {
    display:none; position:fixed; inset:0;
    background:rgba(0,0,0,0.95);
    align-items:center; justify-content:center;
    z-index:99999;
}

/* IMAGE */
.eg-lightbox img {
    max-width:90%; max-height:85vh;
    border-radius:10px; transition:.3s;
}

/* NAV BUTTONS */
.eg-prev, .eg-next {
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    font-size:22px;
    color:#fff;
    background:rgba(0,0,0,0.4);
    padding:12px;
    border-radius:50%;
    cursor:pointer;
}
.eg-prev { left:15px; }
.eg-next { right:15px; }

/* CLOSE BUTTON */
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
}
.eg-close-btn:hover {
    background:#fff;
    color:#000;
}

/* YEAR COLORS */
.eg-year-title {
  display:inline-block;
  padding:8px 14px;
  border-radius:10px;
  font-weight:600;
}

.eg-year-block:nth-child(1) .eg-year-title { background:#f5f0e8; color:#8B0000; }
.eg-year-block:nth-child(2) .eg-year-title { background:#e8f5f2; color:#00695c; }
.eg-year-block:nth-child(3) .eg-year-title { background:#f3e8f5; color:#6a1b9a; }

/* BACK BUTTON */
.eg-back-btn {
  display:inline-flex; align-items:center; gap:8px;
  padding:8px 16px; margin-bottom:15px;
  background:#f5f0e8; color:#8B0000;
  border:none; border-radius:20px;
  cursor:pointer;
}
.eg-back-btn:hover { background:#8B0000; color:#fff; }

/* RESPONSIVE */
@media(max-width:992px){
    .eg-grid,.eg-photo-grid { grid-template-columns:repeat(2,1fr); }
}
@media(max-width:600px){
    .eg-grid,.eg-photo-grid { grid-template-columns:1fr; }
}

/* FIX HEADER */
body.lightbox-open { overflow:hidden; }
body.lightbox-open header { position:static !important; }
</style>

<!-- ================= JS ================= -->
<script>
function openEvent(id){
    document.getElementById("egCards").style.display="none";
    document.getElementById("egDetails").style.display="block";
    document.querySelectorAll(".eg-event-detail").forEach(e=>e.style.display="none");
    document.getElementById("event-"+id).style.display="block";
}

function goBack(){
    document.getElementById("egCards").style.display="grid";
    document.getElementById("egDetails").style.display="none";
}

let currentImages=[],currentIndex=0,zoomed=false;

function openImage(el){
    currentImages=Array.from(el.parentNode.querySelectorAll('img'));
    currentIndex=currentImages.indexOf(el);
    document.body.classList.add("lightbox-open");
    showImage();
}

function showImage(){
    const box=document.getElementById("egLightbox");
    const img=document.getElementById("egLightboxImg");
    box.style.display="flex";
    img.src=currentImages[currentIndex].src;
    img.style.transform="scale(1)";
    zoomed=false;
}

function nextImage(){ currentIndex=(currentIndex+1)%currentImages.length; showImage(); }
function prevImage(){ currentIndex=(currentIndex-1+currentImages.length)%currentImages.length; showImage(); }

function closeImage(){
    document.getElementById("egLightbox").style.display="none";
    document.body.classList.remove("lightbox-open");
}

/* CLICK OUTSIDE */
document.getElementById("egLightbox").addEventListener("click",function(e){
    if(e.target===this) closeImage();
});

/* KEYBOARD */
document.addEventListener("keydown",function(e){
    if(document.getElementById("egLightbox").style.display==="flex"){
        if(e.key==="ArrowRight") nextImage();
        if(e.key==="ArrowLeft") prevImage();
        if(e.key==="Escape") closeImage();
    }
});

/* SWIPE */
let startX=0;
document.getElementById("egLightbox").addEventListener("touchstart",e=>{
    startX=e.touches[0].clientX;
});
document.getElementById("egLightbox").addEventListener("touchend",e=>{
    let diff=startX-e.changedTouches[0].clientX;
    if(Math.abs(diff)>60) diff>0?nextImage():prevImage();
});

/* DOUBLE TAP */
let lastTap=0;
document.getElementById("egLightboxImg").addEventListener("touchend",function(){
    let t=new Date().getTime(),tap=t-lastTap;
    if(tap<300 && tap>0){
        zoomed=!zoomed;
        this.style.transform=zoomed?"scale(2)":"scale(1)";
    }
    lastTap=t;
});
</script>

<?php get_footer(); ?>