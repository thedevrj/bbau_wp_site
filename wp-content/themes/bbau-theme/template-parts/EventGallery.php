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

            <?php
$i++;
endwhile;
endif;
?>

        </div>


        <!-- EVENT DETAILS -->
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
                            onclick="openImage('<?php echo $photo['url']; ?>')">

                        <?php endforeach; ?>

                    </div>

                </div>

                <?php endwhile; ?>

                <?php endif; ?>

            </div>

            <?php
$i++;
endwhile;
endif;
?>

        </div>

    </div>
    <div id="egLightbox" class="eg-lightbox" onclick="closeImage()">

        <img id="egLightboxImg" src="">

    </div>


</div>


<style>
/* .eg-section {
    padding: 70px 0;
    background: #f6f8fc;
} */

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

.eg-card:hover {
    transform: translateY(-6px);
}

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


.eg-year-block {
    margin-top: 40px;
}

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

.eg-photo:hover {
    transform: scale(1.05);
}

#egDetails {
    display: none;
}

.eg-event-detail {
    display: none;
}

.eg-lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.eg-lightbox img {
    max-width: 90%;
    max-height: 90%;
    border-radius: 8px;
}

@media(max-width:1200px) {

    .eg-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .eg-photo-grid {
        grid-template-columns: repeat(3, 1fr);
    }

}

@media(max-width:900px) {

    .eg-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .eg-photo-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media(max-width:600px) {

    .eg-grid {
        grid-template-columns: 1fr;
    }

    .eg-photo-grid {
        grid-template-columns: 1fr;
    }

}
</style>


<script>
function openEvent(id) {

    document.getElementById("egCards").style.display = "none";
    document.getElementById("egDetails").style.display = "block";

    var events = document.querySelectorAll(".eg-event-detail");

    events.forEach(e => e.style.display = "none");

    document.getElementById("event-" + id).style.display = "block";

}

function goBack() {

    document.getElementById("egCards").style.display = "grid";
    document.getElementById("egDetails").style.display = "none";

}

function openImage(src) {

    document.getElementById("egLightboxImg").src = src;

    document.getElementById("egLightbox").style.display = "flex";

}

function closeImage() {

    document.getElementById("egLightbox").style.display = "none";
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImage();
    }
});
</script>

<?php get_footer(); ?>