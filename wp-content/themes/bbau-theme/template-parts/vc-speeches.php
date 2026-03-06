<?php
/*
Template Name: VC Speeches
*/

get_header();
?>
<?php get_template_part('banners/about-banner'); ?>
<div class="container-fluid page-bg page-template-about-bg pt-lg-4 overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>

    <div class="container">
        <div class="speech-filters">

            <input type="text" id="speechSearch" placeholder="Search speeches...">

            <select id="yearFilter">
                <option value="">All Years</option>
                <?php
                    global $wpdb;

                    $years = $wpdb->get_col("
                    SELECT DISTINCT YEAR(meta_value)
                    FROM {$wpdb->postmeta}
                    WHERE meta_key = 'speech_date'
                    ORDER BY meta_value DESC
                    ");

                    if($years){
                        foreach($years as $year){
                            echo '<option value="'.esc_attr($year).'">'.esc_html($year).'</option>';
                        }
                    }
                ?>
            </select>

        </div>

        <div class="speech-grid">

            <?php
            $args = array(
            'post_type' => 'vc_speech',
            'posts_per_page' => 10,
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1
            );

            $query = new WP_Query($args);

            if($query->have_posts()):
                while($query->have_posts()): $query->the_post();
                $pdf = get_field('speech_pdf');
                $date = get_field('speech_date');
                $event = get_field('event_name');
            ?>

            <div class="speech-card" data-year="<?php echo date('Y', strtotime($date)); ?>">
                <div class="speech-icon"><i class="icon-file-pdf1"></i></div>
                <div class="speech-content">
                    <h3><?php the_title(); ?></h3>
                    <?php if($event): ?>
                    <h4 class="event"><?php echo $event; ?></h4>
                    <?php endif; ?>

                    <p class="date"><?php echo $date; ?></p>

                    <div class="speech-buttons">

                        <a href="<?php echo $pdf['url']; ?>" target="_blank" class="vc-btn">
                            View
                        </a>

                        <a href="<?php echo $pdf['url']; ?>" download class="download-btn">
                            Download
                        </a>

                    </div>

                </div>

            </div>

            <?php endwhile; endif; ?>

        </div>

        <div class="former-vc-pagination">
            <?php
        echo paginate_links(array(
            'total' => $query->max_num_pages,
        ));
        ?>
        </div>

    </div>

</div>

<?php get_footer(); ?>
<style>
/* ================================
VC SPEECH PAGE
================================ */

/* ================================
FILTER SECTION
================================ */

.speech-filters {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 40px;
}

.speech-filters input,
.speech-filters select {
    padding: 10px 14px;
    border: 1px solid #dcdcdc;
    border-radius: 6px;
    font-size: 15px;
    min-width: 280px;
}

.speech-filters input:focus,
.speech-filters select:focus {
    outline: none;
    border-color: #b60000;
}

/* ================================
GRID
================================ */

.speech-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
    row-gap: 30px;
}

/* ================================
CARD
================================ */

.speech-card {
    position: relative;
    display: flex;
    gap: 20px;
    padding: 20px;
    padding-left: 22px;
    background: #ffffff;
    border-radius: 8px;
    border: 1px solid #e6e6e6;
    border-left: 4px solid #b60000;
    transition: all 0.3s ease;
}

.speech-card:hover {
    border-left-color: #900000;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    transform: translateY(-3px);
}

/* ================================
PDF ICON
================================ */

.speech-icon {
    width: 50px;
    height: 50px;
    background: #fff3f3;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    font-size: 24px;
    color: #b60000;
    flex-shrink: 0;
}

/* ================================
CONTENT
================================ */

.speech-content {
    flex: 1;
}

.speech-content h3 {
    font-size: 19px;
    font-weight: 600;
    line-height: 1.4;
    margin: 8px 0;
}

.speech-content .event {
    font-size: 14px;
    color: #555;
    margin-bottom: 5px;
}

.speech-content .date {
    font-size: 13px;
    color: #777;
    margin-bottom: 12px;
}

/* ================================
BUTTONS
================================ */

.speech-buttons {
    display: flex;
    gap: 10px;
}

.speech-buttons a {
    font-size: 13px;
    padding: 7px 14px;
    border-radius: 4px;
    text-decoration: none;
    transition: 0.2s;
    font-weight: 500;
    letter-spacing: 0.3px;
}

.view-btn {
    background: #b60000;
    color: #fff;
}

.view-btn:hover {
    background: #920000;
}

.download-btn {
    background: #ececec;
    color: #333;
    border: 1px solid #ddd;
}

.download-btn:hover {
    background: #dcdcdc;
}

/* ================================
MOBILE RESPONSIVE
================================ */

@media (max-width:768px) {

    .speech-filters {
        flex-direction: column;
        align-items: stretch;
    }

    .speech-filters input,
    .speech-filters select {
        width: 100%;
    }

    .speech-grid {
        grid-template-columns: 1fr;
    }

    .speech-card {
        flex-direction: column;
    }

    .speech-icon {
        font-size: 22px;
        width: 40px;
        height: 40px;
    }

}
</style>