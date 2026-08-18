<?php
/**
 * Template Name: COE Viva Voce & RDCU Notices Page
 */
defined('ABSPATH') || exit;

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');

function bbau_coe_count($url) {
    $count = null;
    $error = '';

    $response = wp_remote_get($url, array('timeout' => 15));

    if (is_wp_error($response)) {
        $error = $response->get_error_message();
    } elseif (wp_remote_retrieve_response_code($response) !== 200) {
        $error = 'API Error : HTTP ' . wp_remote_retrieve_response_code($response);
    } else {
        $decoded = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($decoded['count'])) {
            $count = (int) $decoded['count'];
        } elseif (isset($decoded['results']) && is_array($decoded['results'])) {
            $count = count($decoded['results']);
        } elseif (is_array($decoded)) {
            $count = count($decoded);
        }
    }

    return array($count, $error);
}

$cache_key = 'bbau_coe_hub_counts';
$cached    = get_transient($cache_key);

if ($cached !== false) {

    $card_data = $cached;

} else {

    list($mphil_count, $mphil_error)   = bbau_coe_count($media_base . '/api/v1/coe/mphil-viva-voce-dates/');
    list($phd_count, $phd_error)       = bbau_coe_count($media_base . '/api/v1/coe/phd-viva-voce-dates/');
    list($presub_count, $presub_error) = bbau_coe_count($media_base . '/api/v1/coe/phd-pre-submission-seminars/');
    list($rdcu_count, $rdcu_error)     = bbau_coe_count($media_base . '/api/v1/coe/rdcu-notices/');

    $card_data = array(
        array('count' => $mphil_count,  'error' => $mphil_error),
        array('count' => $phd_count,    'error' => $phd_error),
        array('count' => $presub_count, 'error' => $presub_error),
        array('count' => $rdcu_count,   'error' => $rdcu_error),
    );

    set_transient($cache_key, $card_data, 10 * MINUTE_IN_SECONDS);
}


$coe_cards = array(
    array(
        'icon'  => 'fa-user-graduate',
        'title' => 'M.Phil Viva Voce Dates',
        'desc'  => 'Scheduled viva voce dates for M.Phil candidates.',
        'url'   => home_url('/mphil-viva-voce-dates/'),
        'count' => $card_data[0]['count'],
        'error' => $card_data[0]['error'],
    ),
    array(
        'icon'  => 'fa-graduation-cap',
        'title' => 'Ph.D Viva Voce Dates',
        'desc'  => 'Scheduled viva voce dates for Ph.D candidates.',
        'url'   => home_url('/phd-viva-voce-dates/'),
        'count' => $card_data[1]['count'],
        'error' => $card_data[1]['error'],
    ),
    array(
        'icon'  => 'fa-chalkboard-user',
        'title' => 'Ph.D Pre-Submission Seminars',
        'desc'  => 'Upcoming pre-submission seminar schedules.',
        'url'   => home_url('/phd-pre-submission-seminars/'),
        'count' => $card_data[2]['count'],
        'error' => $card_data[2]['error'],
    ),
    array(
        'icon'  => 'fa-bullhorn',
        'title' => 'RDCU Notices',
        'desc'  => 'Notices issued by the Research Degree Committee Unit.',
        'url'   => home_url('/rdcu-notices/'),
        'count' => $card_data[3]['count'],
        'error' => $card_data[3]['error'],
    ),
);

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid page-bg py-5">

    <div class="container">

        <?php get_template_part('template-parts/breadcrumb'); ?>

        <?php get_template_part('menu/menu'); ?>

        <h2 class="pb-page-title">
            COE Notices &amp; Schedules
        </h2>

        <div class="row coe-hub-row">

            <?php foreach ($coe_cards as $card): ?>

                <div class="col-lg-3 col-md-6 mb-4">

                    <a href="<?php echo esc_url($card['url']); ?>" class="coe-hub-card">

                        <span class="coe-hub-icon">
                            <i class="fa-solid <?php echo esc_attr($card['icon']); ?>"></i>
                        </span>

                        <h4 class="coe-hub-title"><?php echo esc_html($card['title']); ?></h4>

                        <p class="coe-hub-desc"><?php echo esc_html($card['desc']); ?></p>

                        <div class="coe-hub-footer">

                            <?php if ($card['error']): ?>
                                <span class="coe-hub-count coe-hub-count-error">Unavailable</span>
                            <?php elseif ($card['count'] !== null): ?>
                                <span class="coe-hub-count"><?php echo (int) $card['count']; ?> entries</span>
                            <?php else: ?>
                                <span class="coe-hub-count">&nbsp;</span>
                            <?php endif; ?>

                            <span class="coe-hub-view">
                                View <i class="fa-solid fa-arrow-right"></i>
                            </span>

                        </div>

                    </a>

                </div>

            <?php endforeach; ?>

        </div>

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

.coe-hub-row{
    margin-top:10px;
}

.coe-hub-card{
    display:flex;
    flex-direction:column;
    height:100%;
    background:#fff;
    border:1px solid #5c1010;
    border-radius:18px;
    padding:28px 24px;
    text-decoration:none !important;
    transition:.25s;
    box-shadow:0 4px 15px rgba(0,0,0,.03);
}

.coe-hub-card:hover{
    transform:translateY(-5px);
    box-shadow:0 12px 28px rgba(0,0,0,.1);
    border-color:#8B1A1A;
}

.coe-hub-icon{
    width:56px;
    height:56px;
    border-radius:14px;
    background:linear-gradient(135deg, #5c1010, #8B1A1A);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    margin-bottom:18px;
    flex-shrink:0;
}

.coe-hub-title{
    color:#5c1010;
    font-weight:700;
    font-size:17px;
    margin-bottom:10px;
    line-height:1.35;
}

.coe-hub-desc{
    color:#666;
    font-size:13.5px;
    line-height:1.6;
    margin-bottom:20px;
    flex-grow:1;
}

.coe-hub-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    padding-top:16px;
    border-top:1px solid #f1ece2;
}

.coe-hub-count{
    font-size:12px;
    font-weight:700;
    color:#c9a84c;
    text-transform:uppercase;
    letter-spacing:.3px;
}

.coe-hub-count-error{
    color:#b91c1c;
}

.coe-hub-view{
    display:flex;
    align-items:center;
    gap:6px;
    font-size:13px;
    font-weight:700;
    color:#5c1010;
    transition:.2s transform;
}

.coe-hub-view i{
    font-size:11px;
    transition:.2s transform;
}

.coe-hub-card:hover .coe-hub-view i{
    transform:translateX(4px);
}

@media (max-width: 991px){
    .coe-hub-card{
        padding:24px 20px;
    }
}

@media (max-width: 577px){
    .coe-hub-icon{
        width:48px;
        height:48px;
        font-size:19px;
        margin-bottom:14px;
    }
    .coe-hub-title{
        font-size:16px;
    }
    .coe-hub-desc{
        font-size:13px;
    }
}

</style>

<?php get_footer(); ?>