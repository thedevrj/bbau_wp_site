<?php
/*
Template Name: Eminent Lectures Template
*/  
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
get_header();
$page_Id = get_the_ID();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args = array(
    'post_type'      => 'eminent_lecture',
    'posts_per_page' => 8,
    'paged'          => $paged,
    'meta_key'       => 'lecture_date',
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
    );
    $query = new WP_Query($args);?>

<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid page-bg page-template-about-bg pt-lg-4 overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>
    <div class="container py-5">
        <div class="row">
            <?php            
            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    ?>
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="card-img-top">
                        <?php the_post_thumbnail( 'medium', array( 'class' => 'img-fluid' ) ); ?>
                    </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php the_title(); ?></h5>
                        <p class="card-text">Speaker: <?php echo get_field('speaker_name'); ?></p>
                        <p class="card-text">Designation: <?php echo get_field('speaker_designation'); ?></p>
                        <p class="card-text">Date: <?php echo get_field('lecture_date'); ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="former-vc-pagination">
            <?php
                    echo paginate_links(array(
                        'total' => $query->max_num_pages,
                    ));
                ?>
        </div>
        <?php
                wp_reset_postdata();
            }
            ?>
    </div>
</div>
<?php get_footer();?>