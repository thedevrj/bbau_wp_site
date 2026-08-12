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

$BBAU_COE_PANEL_LIMIT = 10;

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
                        array(
                            'id'           => 'coeMphil',
                            'label'        => 'M.Phil Viva Voce Dates',
                            'items'        => $mphil_dates,
                            'error'        => $mphil_error,
                            'view_all_url' => home_url('/mphil-viva-voce-dates/'),
                        ),
                        array(
                            'id'           => 'coePhd',
                            'label'        => 'Ph.D Viva Voce Dates',
                            'items'        => $phd_dates,
                            'error'        => $phd_error,
                            'view_all_url' => home_url('/phd-viva-voce-dates/'),
                        ),
                        array(
                            'id'           => 'coePresub',
                            'label'        => 'Ph.D Pre-Submission Seminars',
                            'items'        => $presub_seminars,
                            'error'        => $presub_error,
                            'view_all_url' => home_url('/phd-pre-submission-seminars/'),
                        ),
                    );
                    ?>

                    <?php foreach ($panels as $i => $panel): ?>

                        <?php
                        $total_items   = count($panel['items']);
                        $visible_items = array_slice($panel['items'], 0, $BBAU_COE_PANEL_LIMIT);
                        $has_more      = $total_items > $BBAU_COE_PANEL_LIMIT;
                        ?>

                        <div class="committee-card">

                            <div class="committee-header" data-bs-toggle="collapse"
                                 data-bs-target="#<?php echo esc_attr($panel['id']); ?>"
                                 data-bs-parent="#coeAccordion"
                                 aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>" role="button">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4><?php echo esc_html($panel['label']); ?></h4>
                                    <span class="toggle-icon"><i class="fa-solid fa-chevron-down"></i></span>
                                </div>
                            </div>

                            <div id="<?php echo esc_attr($panel['id']); ?>" class="accordion-collapse collapse<?php echo $i === 0 ? ' show' : ''; ?>" data-bs-parent="#coeAccordion">

                                <div class="committee-body">

                                    <?php if ($panel['error']): ?>

                                        <div class="alert alert-danger"><?php echo esc_html($panel['error']); ?></div>

                                    <?php elseif (empty($panel['items'])): ?>

                                        <div class="alert alert-warning">No entries available.</div>

                                    <?php else: ?>

                                        <div class="coe-schedule-list">

                                            <?php foreach ($visible_items as $item): ?>

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

                                        <?php if ($has_more): ?>

                                            <a href="<?php echo esc_url($panel['view_all_url']); ?>" class="coe-view-all-btn">
                                                View All <?php echo (int) $total_items; ?> <i class="fa-solid fa-arrow-right"></i>
                                            </a>

                                        <?php endif; ?>

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

                    <div class="row pb-rdcu-grid">

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

                            <div class="col-lg-12 mb-3 pb-rdcu-item">
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

                    <nav class="pb-pagination pb-rdcu-pagination" aria-label="RDCU notices pagination">
                        <button type="button" class="pb-page-btn pb-prev" disabled>
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <div class="pb-page-numbers"></div>
                        <button type="button" class="pb-page-btn pb-next">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </nav>

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

.coe-view-all-btn{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    margin-top:14px;
    padding:11px 16px;
    background:#fdfbf7;
    border:1.5px dashed #8B1A1A;
    border-radius:10px;
    color:#5c1010;
    font-weight:700;
    font-size:14px;
    text-decoration:none !important;
    transition:.2s;
}

.coe-view-all-btn:hover{
    background:#5c1010;
    border-style:solid;
    color:#fff;
}

.coe-view-all-btn i{
    font-size:12px;
    transition:.2s transform;
}

.coe-view-all-btn:hover i{
    transform:translateX(3px);
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
    .coe-view-all-btn{
        font-size:13px;
        padding:10px 14px;
    }
}


.pb-pagination{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    margin-top:20px;
    flex-wrap:wrap;
}

.pb-page-btn{
    width:38px;
    height:38px;
    border-radius:8px;
    border:1px solid #5c1010;
    background:#fff;
    color:#5c1010;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    transition:.2s;
    flex-shrink:0;
}

.pb-page-btn:hover:not(:disabled){
    background:#5c1010;
    color:#fff;
}

.pb-page-btn:disabled{
    opacity:.4;
    cursor:not-allowed;
}

.pb-page-numbers{
    display:flex;
    align-items:center;
    gap:6px;
    flex-wrap:wrap;
    justify-content:center;
}

.pb-page-num{
    min-width:38px;
    height:38px;
    padding:0 10px;
    border-radius:8px;
    border:1px solid #ddd;
    background:#fff;
    color:#1a1a1a;
    font-weight:600;
    cursor:pointer;
    transition:.2s;
    flex-shrink:0;
}

.pb-page-num:hover{
    border-color:#5c1010;
}

.pb-page-num.active{
    background:#c9a84c;
    border-color:#c9a84c;
    color:#5c1010;
}

.pb-page-num.ellipsis{
    cursor:default;
    border:none;
    background:transparent;
    min-width:20px;
}

/* Pagination - responsive */
@media (max-width: 577px){

    .pb-pagination{
        gap:6px;
        margin-top:16px;
    }

    .pb-page-btn{
        width:32px;
        height:32px;
        font-size:13px;
    }

    .pb-page-numbers{
        gap:4px;
    }

    .pb-page-num{
        min-width:32px;
        height:32px;
        padding:0 8px;
        font-size:13px;
    }

    .pb-page-num.ellipsis{
        min-width:14px;
        padding:0 2px;
    }
}

@media (max-width: 360px){

    .pb-page-btn{
        width:30px;
        height:30px;
        font-size:12px;
    }

    .pb-page-num{
        min-width:30px;
        height:30px;
        padding:0 6px;
        font-size:12px;
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
    const rdcuGrid = document.querySelector('.pb-rdcu-grid');
    if (!rdcuGrid) return;

    const rdcuItems      = Array.prototype.slice.call(rdcuGrid.querySelectorAll('.pb-rdcu-item'));
    const rdcuPerPage     = 20;
    const rdcuTotalPages  = Math.max(1, Math.ceil(rdcuItems.length / rdcuPerPage));
    let rdcuCurrentPage   = 1;

    const rdcuPagination  = document.querySelector('.pb-rdcu-pagination');
    const rdcuNumbersWrap = rdcuPagination ? rdcuPagination.querySelector('.pb-page-numbers') : null;
    const rdcuPrevBtn     = rdcuPagination ? rdcuPagination.querySelector('.pb-prev') : null;
    const rdcuNextBtn     = rdcuPagination ? rdcuPagination.querySelector('.pb-next') : null;

    if (!rdcuPagination || rdcuTotalPages <= 1) {
        if (rdcuPagination) rdcuPagination.style.display = 'none';
        return;
    }

    function rdcuRenderItems() {
        const start = (rdcuCurrentPage - 1) * rdcuPerPage;
        const end   = start + rdcuPerPage;

        rdcuItems.forEach(function (item, idx) {
            item.style.display = (idx >= start && idx < end) ? '' : 'none';
        });
    }

    function rdcuRenderNumbers() {
        rdcuNumbersWrap.innerHTML = '';

        const pagesToShow = [];
        const delta = 1;

        for (let p = 1; p <= rdcuTotalPages; p++) {
            if (p === 1 || p === rdcuTotalPages || (p >= rdcuCurrentPage - delta && p <= rdcuCurrentPage + delta)) {
                pagesToShow.push(p);
            }
        }

        let lastPushed = 0;
        pagesToShow.forEach(function (p) {
            if (lastPushed && p - lastPushed > 1) {
                const dots = document.createElement('span');
                dots.className = 'pb-page-num ellipsis';
                dots.textContent = '…';
                rdcuNumbersWrap.appendChild(dots);
            }

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'pb-page-num' + (p === rdcuCurrentPage ? ' active' : '');
            btn.textContent = p;
            btn.addEventListener('click', function () {
                rdcuCurrentPage = p;
                rdcuUpdate();
            });
            rdcuNumbersWrap.appendChild(btn);

            lastPushed = p;
        });

        rdcuPrevBtn.disabled = rdcuCurrentPage === 1;
        rdcuNextBtn.disabled = rdcuCurrentPage === rdcuTotalPages;
    }

    function rdcuUpdate() {
        rdcuRenderItems();
        rdcuRenderNumbers();
        rdcuPagination.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    rdcuPrevBtn.addEventListener('click', function () {
        if (rdcuCurrentPage > 1) {
            rdcuCurrentPage--;
            rdcuUpdate();
        }
    });

    rdcuNextBtn.addEventListener('click', function () {
        if (rdcuCurrentPage < rdcuTotalPages) {
            rdcuCurrentPage++;
            rdcuUpdate();
        }
    });

    rdcuUpdate();
});
</script>

<?php get_footer(); ?>