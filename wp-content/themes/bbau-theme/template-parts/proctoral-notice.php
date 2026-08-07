<?php
/**
 * Template Name: Proctorial Board Notices Page
 */
defined('ABSPATH') || exit;

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');

define('BBAU_PBN_API',   $api_base . '/api/v1/proctorial-board-notices/');
define('BBAU_PBN_MEDIA', $media_base);

$response = wp_remote_get(BBAU_PBN_API, [
    'timeout' => 15,
    'headers' => [
        'Accept' => 'application/json'
    ]
]);

$items = [];
$error = '';
$debug_raw_body = '';
$debug_code = '';

if (is_wp_error($response)) {

    $error = $response->get_error_message();

} else {

    $code = wp_remote_retrieve_response_code($response);
    $debug_code = $code;

    $body = wp_remote_retrieve_body($response);
    $debug_raw_body = $body;

    if ($code == 200) {

        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = 'JSON decode failed: ' . json_last_error_msg();
        } else {
            $items = $data['results'] ?? [];
        }

    } else {

        $error = "API Error : HTTP " . $code;

    }

}

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid page-bg py-5">

    <div class="container">

        <?php get_template_part('template-parts/breadcrumb'); ?>

        <h2 class="pb-page-title">
            Proctorial Board Notices
        </h2>

        <?php if (defined('WP_DEBUG') && WP_DEBUG): ?>
            <div class="alert alert-info" style="font-family:monospace; font-size:12px; white-space:pre-wrap;">
DEBUG INFO
API URL called: <?php echo esc_html(BBAU_PBN_API); ?>
HTTP Code: <?php echo esc_html($debug_code); ?>
Raw response body:
<?php echo esc_html($debug_raw_body ?: '[EMPTY BODY]'); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>

            <div class="alert alert-danger">
                <?php echo esc_html($error); ?>
            </div>

        <?php endif; ?>

        <?php if (empty($items)): ?>

            <?php if (!$error): ?>
                <div class="alert alert-warning">
                    No notices available.
                </div>
            <?php endif; ?>

        <?php else: ?>

            <div class="row">

                <?php foreach ($items as $item): ?>

                    <?php
                    $title = esc_html($item['title'] ?? '');
                    $date  = esc_html($item['date'] ?? '');
                    $file  = '';

                    if (!empty($item['file'])) {
                        if (filter_var($item['file'], FILTER_VALIDATE_URL)) {
                            $file = $item['file'];
                        } else {
                            $file = BBAU_PBN_MEDIA . $item['file'];
                        }
                    }
                    ?>

                    <div class="col-lg-12 mb-4">
                        <div class="pb-card">
                            <div class="pb-card-left">
                                <span class="pb-date"><?php echo $date; ?></span>
                                <h4><?php echo $title; ?></h4>
                            </div>

                            <?php if ($file): ?>
                                <a href="<?php echo esc_url($file); ?>" target="_blank" rel="noopener" class="pb-pdf-link">View PDF</a>
                            <?php endif; ?>
                        </div>
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

.pb-card{
    background:#fff;
    border:1px solid #eee;
    border-left:5px solid #8B1A1A;
    border-radius:10px;
    padding: 6px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
    transition:.3s;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.pb-card:hover{
    transform:translateY(-5px);
    box-shadow:0 6px 18px rgba(0,0,0,.12);
}

.pb-card-left {
    flex: 1;
    min-width: 0;
}

.pb-date{
    display:inline-block;
    background:#c9a84c;
    color:#fff;
    padding:2px 5px;
    border-radius:30px;
    margin-bottom:10px;
    font-size:13px;
}

.pb-card h4{
    color:#5c1010;
    font-size:18px;
    margin-bottom:0;
    line-height:1.5;
    word-break: break-word;
}

.pb-pdf-link{
    display:inline-block;
    flex-shrink: 0;
    text-decoration:none;
    color:#8B1A1A;
    border:1px solid #8B1A1A;
    padding:8px 20px;
    border-radius:6px;
    font-weight:600;
    white-space: nowrap;
}

.pb-pdf-link:hover{
    background:#8B1A1A;
    color:#fff;
}

@media (max-width: 577px) {
    .pb-card {
        flex-direction: column;
        align-items: flex-start;
    }
    .pb-pdf-link {
        align-self: flex-end;
    }
}

</style>

<?php get_footer(); ?>