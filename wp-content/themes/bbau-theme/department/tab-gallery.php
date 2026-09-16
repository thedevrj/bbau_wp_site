<?php
$events = $dept_data['gallery_events'] ?? [];
$media_base = getenv('DJANGO_MEDIA_URL');

// PAGINATION
$per_page = 5; 
$total_events = count($events);
$total_pages = ceil($total_events / $per_page);

$current_page = isset($_GET['pg']) ? max(1, intval($_GET['pg'])) : 1;
$offset = ($current_page - 1) * $per_page;

$events_page = array_slice($events, $offset, $per_page);
?>

<div class="section">
    <h3>Department Gallery</h3>

    <?php if (!empty($events_page)): ?>
    <?php foreach ($events_page as $event_index => $event): ?>
    <div class="gallery-event-block" style="margin-bottom: 40px;">
        <h4 style="margin-bottom: 5px; color: #8b1a1a;"><?php echo esc_html($event['title']); ?></h4>
        <?php if (!empty($event['date_of_event'])): ?>
        <p style="font-size: 14px; color: #666; margin-bottom: 15px;">
            <i class="fa-regular fa-calendar"></i> <?php echo date('d M Y', strtotime($event['date_of_event'])); ?>
        </p>
        <?php endif; ?>

        <?php if (!empty($event['images'])): ?>
        <div class="gallery-grid">
            <?php foreach ($event['images'] as $img_index => $item): ?>
            <div class="gallery-item" data-index="<?php echo $event_index . '-' . $img_index; ?>"
                data-image="<?php echo esc_url($media_base . $item['image']); ?>"
                data-caption="<?php echo esc_attr($item['caption'] ?? ''); ?>">

                <img src="<?php echo esc_url($media_base . $item['image']); ?>"
                    alt="<?php echo esc_attr($item['caption'] ?? 'Gallery Image'); ?>" loading="lazy">

                <?php if (!empty($item['caption'])): ?>
                <div class="gallery-caption">
                    <?php echo esc_html($item['caption']); ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p style="color: #888; font-size: 14px;">No images uploaded for this event.</p>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>

    <!-- PAGINATION -->
    <div class="pagination">
        <?php if ($current_page > 1): ?>
        <a href="<?php echo add_query_arg('pg', $current_page - 1); ?>"><i class="fa-solid fa-chevron-left"></i>
            Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="<?php echo add_query_arg('pg', $i); ?>" class="<?php echo ($i == $current_page) ? 'active' : ''; ?>">
            <?php echo $i; ?>
        </a>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
        <a href="<?php echo add_query_arg('pg', $current_page + 1); ?>">Next <i
                class="fa-solid fa-chevron-right"></i></a>
        <?php endif; ?>
    </div>

    <?php else: ?>
    <p style="margin-top:20px; color:#555;">
        No gallery events available.
    </p>
    <?php endif; ?>
</div>

<!-- LIGHTBOX -->
<div id="lightbox" class="lightbox">
    <span class="lightbox-close">&times;</span>

    <button class="lightbox-prev">&#10094;</button>

    <div class="lightbox-content">
        <img id="lightbox-img" src="">
        <p id="lightbox-caption"></p>
    </div>

    <button class="lightbox-next">&#10095;</button>
</div>

<style>
/* ===== GALLERY GRID ===== */
.gallery-grid {
    display: grid;
    gap: 18px;
    margin-top: 25px;
}

/* Desktop: 4 per row */
@media (min-width: 1200px) {
    .gallery-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

/* Tablet: 2 per row */
@media (max-width: 1199px) {
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Mobile: 1 per row */
@media (max-width: 600px) {
    .gallery-grid {
        grid-template-columns: 1fr;
    }
}

.gallery-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    aspect-ratio: 4 / 3;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: inherit;
    transition: 0.4s;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

.gallery-caption {
    position: absolute;
    bottom: 0;
    width: 100%;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
    color: #fff;
    padding: 10px;
    font-size: 13px;
}

/* ===== PAGINATION ===== */
.pagination {
    margin-top: 30px;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 8px;
}

.pagination a {
    padding: 8px 16px;
    background: #eee;
    border-radius: 6px;
    text-decoration: none;
    color: #333;
    font-weight: 500;
    transition: 0.2s;
}

.pagination a.active {
    background: #8b1a1a;
    color: #fff;
}

.pagination a:hover {
    background: #8b1a1a;
    color: #fff;
}

/* ===== LIGHTBOX ===== */
.lightbox {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.95);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.lightbox.active {
    display: flex;
}

.lightbox img {
    max-width: 90%;
    max-height: 80vh;
    border-radius: 10px;
}

.lightbox-close {
    position: absolute;
    top: 20px;
    right: 30px;
    font-size: 32px;
    color: white;
    cursor: pointer;
}

.lightbox-prev,
.lightbox-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 30px;
    background: none;
    border: none;
    color: white;
    cursor: pointer;
}

.lightbox-prev {
    left: 20px;
}

.lightbox-next {
    right: 20px;
}

#lightbox-caption {
    color: white;
    text-align: center;
    margin-top: 10px;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const items = document.querySelectorAll(".gallery-item");
    const lightbox = document.getElementById("lightbox");
    const img = document.getElementById("lightbox-img");
    const caption = document.getElementById("lightbox-caption");

    let currentIndex = 0;
    let gallery = [];

    items.forEach((item, index) => {
        gallery.push({
            image: item.dataset.image,
            caption: item.dataset.caption
        });

        item.addEventListener("click", () => {
            openLightbox(index);
        });
    });

    function openLightbox(index) {
        currentIndex = index;
        updateLightbox();
        lightbox.classList.add("active");
    }

    function closeLightbox() {
        lightbox.classList.remove("active");
    }

    function updateLightbox() {
        img.src = gallery[currentIndex].image;
        caption.innerText = gallery[currentIndex].caption || "";
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % gallery.length;
        updateLightbox();
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + gallery.length) % gallery.length;
        updateLightbox();
    }

    document.querySelector(".lightbox-close").onclick = closeLightbox;
    document.querySelector(".lightbox-next").onclick = nextImage;
    document.querySelector(".lightbox-prev").onclick = prevImage;

    lightbox.addEventListener("click", (e) => {
        if (e.target === lightbox) closeLightbox();
    });

    document.addEventListener("keydown", (e) => {
        if (!lightbox.classList.contains("active")) return;

        if (e.key === "Escape") closeLightbox();
        if (e.key === "ArrowRight") nextImage();
        if (e.key === "ArrowLeft") prevImage();
    });

});
</script>