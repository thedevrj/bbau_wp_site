<?php
/*
Template Name: Gallery Page
*/
defined('ABSPATH') || exit;

get_header();
?>

<!-- YOUR EXISTING BANNER -->
<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid py-5 page-bg">

    <div class="container">
        <h2 class="text-center mb-4">Gallery</h2>

        <!-- GALLERY -->
        <div class="gallery-container">
            <?php get_template_part('menu/menu'); ?>

            <?php if( have_rows('gallery_rows') ): ?>

            <?php while( have_rows('gallery_rows') ): the_row(); ?>

            <div class="gallery-row">

                <?php 
                        $images = get_sub_field('row_images');

                        if($images):
                            foreach($images as $img): ?>

                <div class="gallery-slot">
                    <img src="<?php echo esc_url($img['sizes']['medium']); ?>"
                        data-full="<?php echo esc_url($img['url']); ?>" alt="">
                </div>

                <?php endforeach;
                        endif;
                        ?>

            </div>

            <?php endwhile; ?>

            <?php else: ?>
            <p class="text-center">No images found.</p>
            <?php endif; ?>
        </div>

    </div>

</div>
<div id="lightbox" class="lightbox">

    <span class="close">&times;</span>

    <button id="prev" class="nav-btn prev">&#10094;</button>
    <img id="lightbox-img" class="lightbox-img">
    <button id="next" class="nav-btn next">&#10095;</button>

</div>
<script>
document.addEventListener("DOMContentLoaded", function() {

    const lightbox = document.getElementById("lightbox");
    const lightboxImg = document.getElementById("lightbox-img");
    const closeBtn = document.querySelector(".lightbox .close");

    let images = [];
    let currentIndex = 0;

    /* Collect all images */
    document.querySelectorAll(".gallery-slot img").forEach((img, index) => {
        images.push(img.dataset.full);

        img.addEventListener("click", function() {
            currentIndex = index;
            openLightbox();
        });
    });

    function openLightbox() {
        lightbox.style.display = "flex";
        lightboxImg.src = images[currentIndex];
    }

    function showNext() {
        if (currentIndex < images.length - 1) {
            currentIndex++;
            lightboxImg.src = images[currentIndex];
        }
    }

    function showPrev() {
        if (currentIndex > 0) {
            currentIndex--;
            lightboxImg.src = images[currentIndex];
        }
    }

    /* Buttons */
    document.getElementById("next").onclick = showNext;
    document.getElementById("prev").onclick = showPrev;

    /* Keyboard */
    document.addEventListener("keydown", function(e) {
        if (lightbox.style.display === "flex") {
            if (e.key === "ArrowRight") showNext();
            if (e.key === "ArrowLeft") showPrev();
            if (e.key === "Escape") lightbox.style.display = "none";
        }
    });

    closeBtn.onclick = () => lightbox.style.display = "none";

    lightbox.onclick = (e) => {
        if (e.target === lightbox) lightbox.style.display = "none";
    };

});
</script>
<style>
/* ===== GALLERY ===== */
.gallery-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* 🔥 CHANGE: FLEX → GRID (IMPORTANT) */
.gallery-row {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
}

/* ===== GALLERY ITEM ===== */
.gallery-slot {
    width: 100%;
    aspect-ratio: 1/1;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #eee;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f8f8f8;
}

.gallery-slot:hover {
    transform: scale(1.04);
}

.gallery-slot img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* ===== RESPONSIVE BREAKPOINTS ===== */

/* Laptop */
@media (max-width: 1200px) {
    .gallery-row {
        grid-template-columns: repeat(4, 1fr);
    }
}

/* Tablet */
@media (max-width: 992px) {
    .gallery-row {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Mobile */
@media (max-width: 768px) {
    .gallery-row {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Small Mobile */
@media (max-width: 480px) {
    .gallery-row {
        grid-template-columns: 1fr;
    }
}

/* ===== LIGHTBOX ===== */
.lightbox {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background: rgba(0, 0, 0, 0.95);
    justify-content: center;
    align-items: center;
    padding: 20px;
}

/* Image */
.lightbox-img {
    max-width: 95%;
    max-height: 85vh;
    border-radius: 8px;
    transition: 0.3s ease;
}

/* Close button */
.lightbox .close {
    position: absolute;
    top: 20px;
    right: 25px;
    color: #fff;
    font-size: 32px;
    cursor: pointer;
    z-index: 10;
}

/* ===== NAV BUTTONS ===== */
.nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 38px;
    color: #fff;
    background: rgba(0, 0, 0, 0.4);
    border: none;
    padding: 12px;
    cursor: pointer;
    border-radius: 50%;
    transition: 0.3s;
}

.nav-btn:hover {
    background: rgba(0, 0, 0, 0.7);
}

/* Position */
.prev {
    left: 15px;
}

.next {
    right: 15px;
}

/* Disabled state */
.nav-btn:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

/* ===== MOBILE LIGHTBOX FIX ===== */
@media (max-width: 768px) {

    .lightbox-img {
        max-width: 100%;
        max-height: 70vh;
    }

    .nav-btn {
        font-size: 24px;
        padding: 8px;
    }

    .prev {
        left: 5px;
    }

    .next {
        right: 5px;
    }

    .lightbox .close {
        font-size: 26px;
        top: 15px;
        right: 15px;
    }
}

/* ===== EXTRA SMOOTHNESS ===== */
.gallery-slot img {
    transition: transform 0.3s ease;
}

.gallery-slot:hover img {
    transform: scale(1.08);
}
</style>
<?php get_footer(); ?>