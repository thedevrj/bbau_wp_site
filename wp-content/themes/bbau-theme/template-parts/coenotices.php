<?php
/**
 * Template Name: COE Notices Page
 */
defined('ABSPATH') || exit;

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
$BBAU_COE_NOTICES_API = $media_base . '/api/v1/coe/coe-notices/';

$response_notices = wp_remote_get($BBAU_COE_NOTICES_API, array('timeout' => 15));

$notices       = array();
$notices_error = '';

if (is_wp_error($response_notices)) {

    $notices_error = $response_notices->get_error_message();

} elseif (wp_remote_retrieve_response_code($response_notices) !== 200) {

    $notices_error = 'API Error : HTTP ' . wp_remote_retrieve_response_code($response_notices);

} else {

    $decoded = json_decode(wp_remote_retrieve_body($response_notices), true);
    $notices = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid page-bg py-5">

    <div class="container">

        <?php get_template_part('template-parts/breadcrumb'); ?>

        <h2 class="pb-page-title">
            COE Notices
        </h2>

        <?php if ($notices_error): ?>

            <div class="alert alert-danger"><?php echo esc_html($notices_error); ?></div>

        <?php elseif (empty($notices)): ?>

            <div class="alert alert-warning">No notices available.</div>

        <?php else: ?>

            <div class="row">

                <?php foreach ($notices as $notice): ?>

                    <?php
                    $title = esc_html($notice['title'] ?? '');
                    $date  = esc_html($notice['date'] ?? '');
                    $file  = '';

                    if (!empty($notice['file'])) {
                        if (filter_var($notice['file'], FILTER_VALIDATE_URL)) {
                            $file = $notice['file'];
                        } else {
                            $file = $media_base . $notice['file'];
                        }
                    }
                    ?>

                    <div class="col-lg-6 mb-3">
                        <a class="pb-notice-card" <?php if ($file): ?>href="<?php echo esc_url($file); ?>" target="_blank" rel="noopener"<?php endif; ?>>
                            <span class="pb-notice-icon">
                                <i class="fa-solid fa-bullhorn"></i>
                            </span>
                            <span class="pb-notice-body">
                                <span class="pb-notice-title"><?php echo $title; ?></span>
                                <span class="pb-notice-meta">notice &bull; <?php echo $date; ?></span>
                            </span>
                        </a>
                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>

<style>

.pb-page-title{
    color:#5c1010;
    font-weight:700;
    margin-bottom:25px;
    border-left:5px solid #c9a84c;
    padding-left:15px;
}

.pb-notice-card{
    display:flex;
    align-items:center;
    gap:16px;
    background:#fff;
    border:1px solid #5c1010;
    border-radius:14px;
    padding:8px 22px;
    text-decoration:none;
    transition:.25s;
    height:100%;
}

.pb-notice-card:hover{
    box-shadow:0 6px 18px rgba(0,0,0,.08);
    transform:translateY(-3px);
}

.pb-notice-icon{
    flex-shrink:0;
    width:46px;
    height:46px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#f4f1ea;
    border-radius:10px;
    color:#1a1a1a;
    font-size:18px;
}

.pb-notice-body{
    display:flex;
    flex-direction:column;
    gap:4px;
    min-width:0;
}

.pb-notice-title{
    font-family:Georgia, 'Times New Roman', serif;
    font-weight:700;
    font-size:18px;
    color:#1a1a1a;
    line-height:1.4;
    word-break:break-word;
}

.pb-notice-meta{
    font-size:13px;
    font-weight:600;
    color:#c9a84c;
}

@media (max-width: 577px){
    .pb-notice-card{
        padding:14px 16px;
        gap:12px;
    }
    .pb-notice-icon{
        width:38px;
        height:38px;
        font-size:15px;
    }
    .pb-notice-title{
        font-size:16px;
    }
}

</style>

<?php get_footer(); ?>