<?php 
/* 
Template Name: Schools Page
*/
defined('ABSPATH') || exit;
get_header();

/* Get API base URL from environment */
$api_base = getenv('DJANGO_API_URL');
/* Build endpoint */
$api_url = $api_base . '/api/v1/schools/';
/* Call API */
$response = wp_remote_get($api_url);
$schools = json_decode(wp_remote_retrieve_body($response), true);
?>
<?php   get_template_part('banners/about-banner');?>

<section class=" container-fluid page-bg page-template-about-bg py-lg-5 overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>
    <div class="container">
        <div class="schools-list">

            <?php foreach ($schools as $school): ?>

            <div class="school-card">
                <a href="/schools/<?php echo $school['slug']; ?>">
                    <?php echo esc_html($school['name']); ?>
                </a>
            </div>

            <?php endforeach; ?>

        </div>
    </div>
</section>
<?php get_footer(); ?>