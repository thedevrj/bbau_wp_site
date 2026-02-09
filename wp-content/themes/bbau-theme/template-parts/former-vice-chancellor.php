<?php
/* 
Template Name: Former Vice Chancellor Template
*/
get_header();
defined( 'ABSPATH' ) || exit;

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$args = array(
    'post_type'      => 'old_vice_chancellor',
    'posts_per_page' => 9,
    'paged'          => $paged,
    'meta_key'       => 'start_date',
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
);

$query = new WP_Query($args);
?>
<!-- Banner -->
<?php get_template_part( 'banners/about-banner' ); ?>
<!-- End Banner -->
<?php if ($query->have_posts()) : ?>
<div class="container-fluid page-bg page-template-about-bg overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>
    <div class="container py-5">
        <h2 class="text-center mb-4">Former Vice Chancellors</h2>

        <div class="vc-grid">

            <?php while ($query->have_posts()) : $query->the_post(); 
            $start = get_field('start_date');
            $end   = get_field('end_date');
        ?>

            <div class="vc-card">
                <div class="vc-inner">

                    <div class="vc-image">
                        <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium'); ?>
                        <?php endif; ?>
                    </div>

                    <div class="vc-content">
                        <h3 class="vc-title"><?php the_title(); ?></h3>

                        <p class="vc-duration">
                            <strong>Tenure:</strong>
                            <?php echo esc_html($start); ?> - <?php echo esc_html($end); ?>
                        </p>
                    </div>

                </div>
            </div>

            <?php endwhile; ?>

        </div>
    </div>
</div>

<!-- Pagination -->
<div class="vc-pagination">
    <?php
        echo paginate_links(array(
            'total' => $query->max_num_pages,
        ));
        ?>
</div>

<?php endif; wp_reset_postdata(); ?>
<?php
get_footer();
?>
<style>
.vc-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 24px;
}

.vc-card {
    background: #fff;
    border: 1px solid #e5e5e5;
    padding: 16px;
}

.vc-inner {
    display: flex;
    gap: 16px;
    min-width: 0;
}

.vc-image {
    flex: 0 0 55%;
}


.vc-content {
    flex: 1;
    min-width: 0;
}

.vc-title {
    margin: 0 0 8px;
    font-size: 18px;
}

.vc-duration {
    font-size: 14px;
    color: #555;
}

/* Pagination */
.vc-pagination {
    margin-top: 40px;
    text-align: center;
}

/* Responsive */
@media (max-width: 992px) {
    .vc-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 576px) {
    .vc-grid {
        grid-template-columns: 1fr;
    }
}

body {
    overflow-x: hidden;
}
</style>