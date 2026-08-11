<?php
/**
 * Template Name: COE Viva Voce & RDCU Notices Page
 */
defined('ABSPATH') || exit;

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');

function bbau_coe_fetch($url) {
    $data  = array();
    $error = '';

    $response = wp_remote_get($url, array('timeout' => 15));

    if (is_wp_error($response)) {
        $error = $response->get_error_message();
    } elseif (wp_remote_retrieve_response_code($response) !== 200) {
        $error = 'API Error : HTTP ' . wp_remote_retrieve_response_code($response);
    } else {
        $decoded = json_decode(wp_remote_retrieve_body($response), true);
        $data    = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
    }

    return array($data, $error);
}

list($mphil_dates, $mphil_error)      = bbau_coe_fetch($media_base . '/api/v1/coe/mphil-viva-voce-dates/');
list($phd_dates, $phd_error)          = bbau_coe_fetch($media_base . '/api/v1/coe/phd-viva-voce-dates/');
list($presub_seminars, $presub_error) = bbau_coe_fetch($media_base . '/api/v1/coe/phd-pre-submission-seminars/');
list($rdcu_notices, $rdcu_error)      = bbau_coe_fetch($media_base . '/api/v1/coe/rdcu-notices/');

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid page-bg py-5">

    <div class="container">

        <?php get_template_part('template-parts/breadcrumb'); ?>

        <h2 class="pb-page-title">
            COE Notices &amp; Schedules
        </h2>

        <div class="row">

            <div class="col-lg-6 mb-4">

                <h3 class="pb-col-title">Examination Notices</h3>

                <div class="committees-wrap" id="coeAccordion">

                    <?php
                    $panels = array(
                        array('id' => 'coeMphil',  'label' => 'M.Phil Viva Voce Dates',        'items' => $mphil_dates,     'error' => $mphil_error),
                        array('id' => 'coePhd',    'label' => 'Ph.D Viva Voce Dates',           'items' => $phd_dates,       'error' => $phd_error),
                        array('id' => 'coePresub', 'label' => 'Ph.D Pre-Submission Seminars',   'items' => $presub_seminars, 'error' => $presub_error),
                    );
                    ?>

                    <?php foreach ($panels as $i => $panel): ?>

                        <div class="committee-card">

                            <div class="committee-header" data-bs-toggle="collapse"
                                 data-bs-target="#<?php echo esc_attr($panel['id']); ?>"
                                 data-bs-parent="#coeAccordion"
                                 aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>" role="button">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4><?php echo esc_html($panel['label']); ?></h4>
                                    <span class="toggle-icon">&#9660;</span>
                                </div>
                            </div>

                            <div id="<?php echo esc_attr($panel['id']); ?>" class="accordion-collapse collapse<?php echo $i === 0 ? ' show' : ''; ?>" data-bs-parent="#coeAccordion">

                                <div class="committee-body">

                                    <?php if ($panel['error']): ?>

                                        <div class="alert alert-danger"><?php echo esc_html($panel['error']); ?></div>

                                    <?php elseif (empty($panel['items'])): ?>

                                        <div class="alert alert-warning">No entries available.</div>

                                    <?php else: ?>

                                        <div class="coe-schedule-list<?php echo count($panel['items']) > 40 ? ' coe-scrollable' : ''; ?>">

                                            <?php foreach ($panel['items'] as $item): ?>

                                                <?php
                                                $item_title = esc_html($item['title'] ?? $item['name'] ?? '');
                                                $item_date  = esc_html($item['date'] ?? '');
                                                $item_file  = '';

                                                if (!empty($item['file'])) {
                                                    if (filter_var($item['file'], FILTER_VALIDATE_URL)) {
                                                        $item_file = $item['file'];
                                                    } else {
                                                        $item_file = $media_base . $item['file'];
                                                    }
                                                }
                                                ?>

                                                <div class="coe-schedule-row">
                                                    <div class="coe-schedule-info">
                                                        <strong><?php echo $item_title; ?></strong>
                                                        <?php if ($item_date): ?>
                                                            <span><?php echo $item_date; ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if ($item_file): ?>
                                                        <a href="<?php echo esc_url($item_file); ?>" target="_blank" rel="noopener" class="coe-file-link">
                                                            <i class="fa-solid fa-file-pdf"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>

                                            <?php endforeach; ?>

                                        </div>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

            <div class="col-lg-6 mb-4">

                <h3 class="pb-col-title">RDCU Notices</h3>

                <?php if ($rdcu_error): ?>

                    <div class="alert alert-danger"><?php echo esc_html($rdcu_error); ?></div>

                <?php elseif (empty($rdcu_notices)): ?>

                    <div class="alert alert-warning">No notices available.</div>

                <?php else: ?>

                    <div class="row">

                        <?php foreach ($rdcu_notices as $notice): ?>

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

                            <div class="col-lg-12 mb-3">
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

.pb-col-title{
    color:#5c1010;
    font-weight:700;
    font-size:20px;
    margin-bottom:18px;
}

.committees-wrap {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 20px;
}

.committee-card {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
}

.committee-header {
    background: linear-gradient(135deg, #5c1010, #8B1A1A);
    padding: 18px 22px;
    color: #fff;
    cursor: pointer;
}

.committee-header h4 {
    margin: 0;
    font-size: 1.05rem;
    font-weight: 700;
}

.committee-body {
    padding: 20px;
}

.toggle-icon {
    transition: transform 0.3s ease;
    font-size: 12px;
}

.committee-header[aria-expanded="true"] .toggle-icon {
    transform: rotate(180deg);
}

.accordion-collapse {
    display: none;
}

.accordion-collapse.show {
    display: block;
}

.coe-schedule-list{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.coe-schedule-list.coe-scrollable{
    max-height:600px;
    overflow-y:auto;
    padding-right:6px;
}

.coe-schedule-list.coe-scrollable::-webkit-scrollbar{
    width:6px;
}

.coe-schedule-list.coe-scrollable::-webkit-scrollbar-track{
    background:#f3f4f6;
    border-radius:10px;
}

.coe-schedule-list.coe-scrollable::-webkit-scrollbar-thumb{
    background:#8B1A1A;
    border-radius:10px;
}

.coe-schedule-list.coe-scrollable::-webkit-scrollbar-thumb:hover{
    background:#5c1010;
}

.coe-schedule-row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding:12px 14px;
    background:#fdfbf7;
    border-radius:10px;
}

.coe-schedule-info{
    display:flex;
    flex-direction:column;
    gap:2px;
    min-width:0;
}

.coe-schedule-info strong{
    color:#5c1010;
    font-size:14.5px;
    word-break:break-word;
}

.coe-schedule-info span{
    font-size:12.5px;
    color:#8B1A1A;
    font-weight:600;
}

.coe-file-link{
    flex-shrink:0;
    color:#8B1A1A;
    font-size:18px;
}

.coe-file-link:hover{
    color:#5c1010;
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

@media (max-width: 991px){
    .pb-notice-card{
        margin-bottom: 0;
    }
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
    .coe-schedule-row{
        flex-direction:column;
        align-items:flex-start;
    }
    .coe-schedule-list.coe-scrollable{
        max-height:400px;
    }
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleHeaders = document.querySelectorAll('.committee-header[data-bs-toggle="collapse"]');
    toggleHeaders.forEach(header => {
        header.addEventListener('click', function(e) {
            if (e.target.closest('a') || e.target.closest('button') || e.target.closest('[onclick]')) {
                return;
            }

            const targetId = this.getAttribute('data-bs-target');
            const target = document.querySelector(targetId);
            if (!target) return;

            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            const parentSelector = target.getAttribute('data-bs-parent');
            if (parentSelector) {
                const parent = document.querySelector(parentSelector);
                if (parent) {
                    const allTargets = parent.querySelectorAll('.accordion-collapse.show');
                    const allHeaders = parent.querySelectorAll('.committee-header[aria-expanded="true"]');

                    allTargets.forEach(t => {
                        if (t !== target) t.classList.remove('show');
                    });

                    allHeaders.forEach(h => {
                        if (h !== this) h.setAttribute('aria-expanded', 'false');
                    });
                }
            }

            if (isExpanded) {
                target.classList.remove('show');
                this.setAttribute('aria-expanded', 'false');
            } else {
                target.classList.add('show');
                this.setAttribute('aria-expanded', 'true');
            }
        });
    });
});
</script>

<?php get_footer(); ?>