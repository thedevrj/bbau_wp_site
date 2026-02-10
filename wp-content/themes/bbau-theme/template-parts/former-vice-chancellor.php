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

        <div class="former-vc-grid">

            <?php while ($query->have_posts()) : $query->the_post(); 
            $start = get_field('start_date');
            $end   = get_field('end_date');
        ?>

            <div class="former-vc-card">
                <div class="former-vc-inner">


                    <div class="former-vc-image">
                        <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium'); ?>
                        <?php endif; ?>
                    </div>

                    <div class="former-vc-content">
                        <h3 class="former-vc-title"><?php the_title(); ?></h3>

                        <p class="former-vc-duration">
                            <strong>Tenure:</strong>
                            <?php echo esc_html($start); ?> - <?php echo esc_html($end); ?>
                        </p>
                    </div>

                </div>
            </div>

            <?php endwhile; ?>

        </div>
    </div>
    <!-- Pagination -->
<div class="former-vc-pagination">
    <?php
        echo paginate_links(array(
            'total' => $query->max_num_pages,
        ));
        ?>
</div>
</div>



<?php endif; wp_reset_postdata(); ?>
<?php
get_footer();
?>
