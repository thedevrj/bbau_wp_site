<?php
// Inherited variables: $dept, $media_base
$gallery = $dept['gallery_images'] ?? array();
$media_base = getenv('DJANGO_MEDIA_URL');

?>
<div class="section">
    <h3>Department Gallery</h3>
    <?php if(!empty($gallery)): ?>
    <div class="gallery-grid">
        <?php foreach($gallery as $item): ?>
        <div class="gallery-item" onclick="openLightbox('<?php echo esc_url($media_base . $item['image']); ?>', '<?php echo esc_attr($item['caption'] ?? ''); ?>')">
            <img src="<?php echo esc_url($media_base . $item['image']); ?>" alt="<?php echo esc_attr($item['caption'] ?? 'Gallery Image'); ?>" loading="lazy">
            <?php if(!empty($item['caption'])): ?>
            <div class="gallery-caption"><?php echo esc_html($item['caption']); ?></div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p style="margin-top:20px; color:#555;">No gallery images have been uploaded for this department yet.</p>
    <?php endif; ?>
</div>

<!-- Simple Lightbox logic could be added here or in departmentsingle.php -->

<style>
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 25px;
}

.gallery-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    height: 220px;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: 0.3s;
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.5s;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

.gallery-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: #fff;
    padding: 15px 10px 10px;
    font-size: 0.85rem;
    font-weight: 600;
}

.gallery-item:hover {
    box-shadow: 0 10px 20px rgba(139, 26, 26, 0.2);
}
</style>
