<?php $page_id = get_the_Id(); ?>

<div class="sc-hero" style="background-image: url('<?php echo get_field('banner_image', $page_id); ?>');">
        <div class="sc-hero-overlay">
            <div class="sc-hero-card">
                <span class="sc-badge"><?php echo get_field('banner_text',$page_id); ?></span>
                <h1><?php echo get_field('banner_title',$page_id); ?></h1>
                <div class="sc-hero-line"></div>
            </div>
        </div>
    </div>