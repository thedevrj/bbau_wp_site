<?php
/*
Template Name: Gallery Page
*/
defined('ABSPATH') || exit;

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid page-bg page-template-about-bg py-5 overflow-hidden">
    <div class="container">

        <?php get_template_part('template-parts/breadcrumb'); ?>

       

        <!-- GALLERY -->
        <div class="gallery-container">
            <?php get_template_part('menu/menu'); ?>

            <?php if( have_rows('gallery_rows') ): ?>

                <?php while( have_rows('gallery_rows') ): the_row(); ?>

                    <div class="gallery-row">

                        <?php
                        $images = get_sub_field('row_images');

                        if( $images ):
                            foreach( $images as $img ): ?>

                                <div class="gallery-slot">
                                    <img
                                        src="<?php echo esc_url( $img['sizes']['large'] ); ?>"
                                        data-full="<?php echo esc_url( $img['url'] ); ?>"
                                        alt="<?php echo esc_attr( $img['alt'] ); ?>"
                                        loading="lazy"
                                    >
                                </div>

                            <?php endforeach;
                        endif; ?>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>
                <p class="text-center">No images found.</p>
            <?php endif; ?>

        </div><!-- /.gallery-container -->

    </div><!-- /.container -->
</section><!-- FIXED: was </div> before -->

<!-- LIGHTBOX (outside section, at body level) -->
<div id="lightbox" class="lightbox" role="dialog" aria-modal="true" aria-label="Image lightbox">

    <span class="close" role="button" aria-label="Close lightbox" tabindex="0">&times;</span>

    <button id="prev" class="nav-btn prev" aria-label="Previous image">&#10094;</button>
    <img id="lightbox-img" class="lightbox-img" src="" alt="Lightbox image">
    <button id="next" class="nav-btn next" aria-label="Next image">&#10095;</button>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const lightbox    = document.getElementById("lightbox");
    const lightboxImg = document.getElementById("lightbox-img");
    const closeBtn    = document.querySelector(".lightbox .close");
    const prevBtn     = document.getElementById("prev");
    const nextBtn     = document.getElementById("next");

    let images       = [];
    let currentIndex = 0;

    /* ── Collect all gallery images ── */
    document.querySelectorAll(".gallery-slot img").forEach(function (img, index) {
        images.push({
            full : img.dataset.full,
            alt  : img.alt || ""
        });

        img.addEventListener("click", function () {
            currentIndex = index;
            openLightbox();
        });
    });

    /* ── Open lightbox ── */
    function openLightbox() {
        lightbox.style.display = "flex";
        updateImage();
        document.body.style.overflow = "hidden"; // prevent background scroll
    }

    /* ── Close lightbox ── */
    function closeLightbox() {
        lightbox.style.display = "none";
        lightboxImg.src        = "";
        document.body.style.overflow = "";
    }

    /* ── Update displayed image & button states ── */
    function updateImage() {
        lightboxImg.src = images[currentIndex].full;
        lightboxImg.alt = images[currentIndex].alt;
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex === images.length - 1;
    }

    /* ── Navigation ── */
    function showNext() {
        if (currentIndex < images.length - 1) {
            currentIndex++;
            updateImage();
        }
    }

    function showPrev() {
        if (currentIndex > 0) {
            currentIndex--;
            updateImage();
        }
    }

    nextBtn.addEventListener("click", showNext);
    prevBtn.addEventListener("click", showPrev);

    /* ── Keyboard navigation ── */
    document.addEventListener("keydown", function (e) {
        if (lightbox.style.display !== "flex") return;
        if (e.key === "ArrowRight") showNext();
        if (e.key === "ArrowLeft")  showPrev();
        if (e.key === "Escape")     closeLightbox();
    });

    /* ── Close via button or backdrop click ── */
    closeBtn.addEventListener("click", closeLightbox);

    closeBtn.addEventListener("keydown", function (e) {
        if (e.key === "Enter" || e.key === " ") closeLightbox();
    });

    lightbox.addEventListener("click", function (e) {
        if (e.target === lightbox) closeLightbox();
    });

    /* ── Swipe support (mobile) ── */
    let touchStartX = 0;

    lightbox.addEventListener("touchstart", function (e) {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    lightbox.addEventListener("touchend", function (e) {
        const diff = touchStartX - e.changedTouches[0].screenX;
        if (Math.abs(diff) > 50) {
            diff > 0 ? showNext() : showPrev();
        }
    }, { passive: true });

});
</script>

<style>
/* ===================================================
   GALLERY GRID
=================================================== */

.gallery-row {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
    margin-bottom: 15px;
}

/* ===== GALLERY ITEM ===== */
.gallery-slot {
    width: 100%;
    aspect-ratio: 1 / 1;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #eee;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background: #f8f8f8;
}

.gallery-slot:hover {
    transform: scale(1.04);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.gallery-slot img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

.gallery-slot:hover img {
    transform: scale(1.08);
}

/* ===================================================
   RESPONSIVE BREAKPOINTS
=================================================== */

/* Laptop */
@media (max-width: 1200px) {
    .gallery-row { grid-template-columns: repeat(4, 1fr); }
}

/* Tablet */
@media (max-width: 992px) {
    .gallery-row { grid-template-columns: repeat(3, 1fr); }
}

/* Mobile */
@media (max-width: 768px) {
    .gallery-row { grid-template-columns: repeat(2, 1fr); }
}

/* Small Mobile */
@media (max-width: 480px) {
    .gallery-row { grid-template-columns: 1fr; }
}

/* ===================================================
   LIGHTBOX
=================================================== */

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

.lightbox-img {
    max-width: 90%;
    max-height: 85vh;
    border-radius: 8px;
    transition: opacity 0.25s ease;
    display: block;
    user-select: none;
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
    line-height: 1;
    transition: color 0.2s;
}

.lightbox .close:hover {
    color: #ccc;
}

/* ===================================================
   NAV BUTTONS
=================================================== */

.nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 38px;
    color: #fff;
    background: rgba(0, 0, 0, 0.4);
    border: none;
    padding: 12px 16px;
    cursor: pointer;
    border-radius: 50%;
    transition: background 0.3s ease, opacity 0.2s ease;
    line-height: 1;
}

.nav-btn:hover {
    background: rgba(0, 0, 0, 0.7);
}

.nav-btn:disabled {
    opacity: 0.25;
    cursor: not-allowed;
    pointer-events: none;
}

.prev { left: 15px; }
.next { right: 15px; }

/* ===================================================
   MOBILE LIGHTBOX
=================================================== */

@media (max-width: 768px) {
    .lightbox-img {
        max-width: 100%;
        max-height: 70vh;
    }

    .nav-btn {
        font-size: 24px;
        padding: 8px 10px;
    }

    .prev { left: 5px; }
    .next { right: 5px; }

    .lightbox .close {
        font-size: 26px;
        top: 15px;
        right: 15px;
    }
}
</style>

<?php get_footer(); ?>