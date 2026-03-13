<?php 
/* 
Template Name: Schools Single Page
*/
defined('ABSPATH') || exit;
get_header();
$slug = get_query_var('school_slug');
$api = "http://172.35.0.45:8001/api/v1/schools/?slug=".$slug;
$response = wp_remote_get($api);
$data = json_decode(wp_remote_retrieve_body($response), true);
$school = $data[0];
?>

<?php   get_template_part('banners/about-banner');?>

<section class=" container-fluid page-bg page-template-about-bg py-lg-5 overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>
    <div class="container">
        <h1><?php echo esc_html($school['name']); ?></h1>

        <p>Dean: <?php echo esc_html($school['dean_name']); ?></p>
    </div>
</section>


<?php get_footer(); ?>