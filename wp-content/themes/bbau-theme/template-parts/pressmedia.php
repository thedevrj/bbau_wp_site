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

        <!-- MEDIA CARDS -->
        <div class="pm-cards-grid">
            <?php $ci=0; if( have_rows($repeater) ): while( have_rows($repeater) ): the_row(); ?>
            <a href="?media=<?php echo $ci;?>" class="pm-card">
                <div class="pm-card-cover" style="background-image:url('<?php echo esc_url(get_sub_field('card_background')['url']); ?>')">
                    <div class="pm-cover-overlay"></div>
                    <div class="pm-cover-icon">📰</div>
                </div>
                <div class="pm-card-body">
                    <h3><?php echo esc_html(get_sub_field('news_title')); ?></h3>
                </div>
            </a>
            <?php $ci++; endwhile; endif; ?>
        </div>

        <?php else: ?>

        <!-- DETAIL -->
        <?php $ci=0; if( have_rows($repeater) ): while( have_rows($repeater) ): the_row();
        if($ci==$media_index): ?>

        <!-- BACK BUTTON -->
        <button class="eg-back-btn" onclick="window.location.href='?'">
            <i class="fa-solid fa-arrow-left"></i> Back to Gallery
        </button>

        <h3><?php echo esc_html(get_sub_field('news_title')); ?></h3>

        <?php if( have_rows('media_years') ): while( have_rows('media_years') ): the_row(); ?>
        <div class="pm-year-block">
            <h3 class="pm-year-title"><?php echo esc_html(get_sub_field('year_title')); ?></h3>

            <div class="pm-photo-grid">
                <?php foreach(get_sub_field('media_photos') as $photo): ?>
                <img src="<?php echo esc_url($photo['url']); ?>" class="pm-photo" onclick="pmOpenImage(this)">
                <?php endforeach; ?>
            </div>
        </div>
        <?php endwhile; endif; ?>

        <?php endif; $ci++; endwhile; endif; ?>
        <?php endif; ?>
    </div>

    <!-- LIGHTBOX -->
    <div id="pmLightbox" class="pm-lightbox">

        <!-- CLOSE BUTTON -->
        <div class="pm-close-btn" onclick="pmCloseImage()">
            <i class="fa-solid fa-xmark"></i>
            <span>Close</span>
        </div>

        <span class="pm-prev" onclick="pmPrev()">❮</span>
        <img id="pmLightboxImg">
        <span class="pm-next" onclick="pmNext()">❯</span>

    </div>
</div>

<!-- ================= CSS ================= -->
<style>

/* GRID */
.pm-cards-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:25px; }

.pm-card { background:#fff; border-radius:12px; overflow:hidden; text-decoration:none; color:#000;
box-shadow:0 8px 25px rgba(0,0,0,0.1); transition:.3s; }
.pm-card:hover { transform:translateY(-6px); }

.pm-card-cover { height:180px; background-size:cover; display:flex; align-items:center; justify-content:center; position:relative; }
.pm-cover-overlay { position:absolute; inset:0; background:rgba(0,0,0,0.45); }
.pm-cover-icon { position:relative; font-size:40px; color:#fff; }

.pm-card-body { padding:18px; text-align:center; }

/* PHOTOS */
.pm-photo-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:15px; }

.pm-photo { width:100%; height:200px; object-fit:cover; border-radius:8px; cursor:pointer; }
.pm-photo:hover { transform:scale(1.05); }

/* LIGHTBOX */
.pm-lightbox {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.95);
    align-items:center;
    justify-content:center;
    z-index:99999;
    touch-action: pan-y;
}

.pm-lightbox img {
    max-width:90%;
    max-height:85vh;
    border-radius:10px;
    transition:transform .3s ease;
}

/* NAV */
.pm-prev,.pm-next {
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
.pm-prev{ left:15px; }
.pm-next{ right:15px; }

/* CLOSE BUTTON */
.pm-close-btn {
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
.pm-close-btn:hover {
    background:#fff;
    color:#000;
}

/* RESPONSIVE */
@media(max-width:992px){
    .pm-cards-grid, .pm-photo-grid { grid-template-columns:repeat(2,1fr); }
}
@media(max-width:600px){
    .pm-cards-grid, .pm-photo-grid { grid-template-columns:1fr; }
}

/* HEADER FIX */
body.pm-open { overflow:hidden; }
body.pm-open header { position:static !important; }

/* BACK BUTTON */
.eg-back-btn {
  display:inline-flex; align-items:center; gap:8px;
  padding:8px 16px; margin-bottom:15px;
  background:#f5f0e8; color:#8B0000;
  border:none; border-radius:20px;
  font-size:14px; font-weight:600;
  cursor:pointer;
}
.eg-back-btn:hover { background:#8B0000; color:#fff; }

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
});
</script>

<?php get_footer(); ?>