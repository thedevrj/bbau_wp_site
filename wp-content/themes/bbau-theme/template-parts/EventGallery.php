<?php
/*
Template Name: Event Gallery
*/
defined('ABSPATH') || exit;
get_header();
?>
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
            $name  = get_sub_field('event_name');
            $cover = get_sub_field('event_cover');
            ?>
            <div class="eg-card" onclick="openEvent(<?php echo $i;?>)">
                <img src="<?php echo $cover['url']; ?>" class="eg-cover">
                <div class="eg-card-name">
                    <?php echo esc_html($name); ?>
                </div>
            </div>
            <?php $i++; endwhile; endif; ?>
        </div>
        <div id="egDetails">
            <?php
            $i=0;
            if( have_rows('event_gallery') ):
            while( have_rows('event_gallery') ): the_row();
            $name  = get_sub_field('event_name');
            ?>
            <div class="eg-event-detail" id="event-<?php echo $i;?>">
                <h3><?php echo esc_html($name); ?></h3>
                <a class="link-new" onclick="goBack()">← Back to Events</a>
                <?php if( have_rows('event_year') ): ?>
                <?php while( have_rows('event_year') ): the_row();
                $year = get_sub_field('year_title');
                $photos = get_sub_field('year_photos');
                ?>
                <div class="eg-year-block">
                    <h3 class="eg-year-title"><?php echo esc_html($year); ?></h3>
                    <div class="eg-photo-grid">
                        <?php foreach($photos as $photo): ?>
                        <img src="<?php echo $photo['url']; ?>" class="eg-photo"
                             onclick="openImage(this)">
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endwhile; endif; ?>
            </div>
            <?php $i++; endwhile; endif; ?>
        </div>
    </div>
    <div id="egLightbox" class="eg-lightbox">
        <span class="eg-close" onclick="closeImage()">×</span>
        <span class="eg-prev" onclick="prevImage()">❮</span>
        <img id="egLightboxImg" src="">
        <span class="eg-next" onclick="nextImage()">❯</span>
    </div>
</div>
<style>
.eg-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
}
.eg-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    transition: .3s;
}
.eg-card:hover { transform: translateY(-6px); }
.eg-cover {
    width: 100%;
    height: 220px;
    object-fit: cover;
}
.eg-card-name {
    padding: 16px;
    font-size: 18px;
    font-weight: 600;
    text-align: center;
}
.eg-year-block { margin-top: 40px; }
.eg-year-title {
    font-size: 22px;
    margin-bottom: 15px;
}
.eg-photo-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}
.eg-photo {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    transition: .3s;
}
.eg-photo:hover { transform: scale(1.05); }
#egDetails { display: none; }
.eg-event-detail { display: none; }
/* LIGHTBOX */
.eg-lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.9);
    align-items: center;
    justify-content: center;
    z-index: 9999;
}
.eg-lightbox img {
    max-width: 85%;
    max-height: 85%;
}
/* NAV BUTTONS */
.eg-prev, .eg-next {
    position: absolute;
    top: 50%;
    font-size: 30px;
    color: white;
    cursor: pointer;
    padding: 10px;
    transform: translateY(-50%);
}
.eg-prev { left: 20px; }
.eg-next { right: 20px; }
.eg-close {
    position: absolute;
    top: 20px;
    right: 30px;
    font-size: 30px;
    color: white;
    cursor: pointer;
}
/* RESPONSIVE */
@media(max-width:1200px){
    .eg-grid, .eg-photo-grid { grid-template-columns: repeat(3,1fr); }
}
@media(max-width:900px){
    .eg-grid, .eg-photo-grid { grid-template-columns: repeat(2,1fr); }
}
@media(max-width:600px){
    .eg-grid, .eg-photo-grid { grid-template-columns: 1fr; }
}
</style>
<script>
function openEvent(id) {
    document.getElementById("egCards").style.display = "none";
    document.getElementById("egDetails").style.display = "block";
    document.querySelectorAll(".eg-event-detail").forEach(e => e.style.display = "none");
    document.getElementById("event-" + id).style.display = "block";
}
function goBack() {
    document.getElementById("egCards").style.display = "grid";
    document.getElementById("egDetails").style.display = "none";
}
/* ===== IMAGE SLIDER ===== */
let currentImages = [];
let currentIndex = 0;
function openImage(el) {
    currentImages = Array.from(el.parentNode.querySelectorAll('img'));
    currentIndex = currentImages.indexOf(el);
    showImage();
}
function showImage() {
    document.getElementById("egLightbox").style.display = "flex";
    document.getElementById("egLightboxImg").src = currentImages[currentIndex].src;
}
function nextImage() {
    currentIndex = (currentIndex + 1) % currentImages.length;
    showImage();
}
function prevImage() {
    currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
    showImage();
}
function closeImage() {
    document.getElementById("egLightbox").style.display = "none";
}
/* KEYBOARD SUPPORT */
document.addEventListener('keydown', function(e){
    if(e.key === "ArrowRight") nextImage();
    if(e.key === "ArrowLeft") prevImage();
    if(e.key === "Escape") closeImage();
});
</script>

<?php get_footer(); ?>