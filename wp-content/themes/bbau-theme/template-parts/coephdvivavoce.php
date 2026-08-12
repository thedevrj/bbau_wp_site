<?php
/**
 * Template Name: PhD Viva Voce Dates Page
 */
defined('ABSPATH') || exit;

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
$BBAU_PHD_VIVA_API = $media_base . '/api/v1/coe/phd-viva-voce-dates/';

$notices       = array();
$notices_error = '';

$cache_key = 'bbau_phd_viva_dates_all';
$cached    = get_transient($cache_key);

if ($cached !== false) {

    $notices = $cached;

} else {

    $next_url  = $BBAU_PHD_VIVA_API;
    $safety_i  = 0; 

    while ($next_url && $safety_i < 50) {

        $response = wp_remote_get($next_url, array('timeout' => 15));

        if (is_wp_error($response)) {
            $notices_error = $response->get_error_message();
            break;
        }

        if (wp_remote_retrieve_response_code($response) !== 200) {
            $notices_error = 'API Error : HTTP ' . wp_remote_retrieve_response_code($response);
            break;
        }

        $decoded = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($decoded['results']) && is_array($decoded['results'])) {
            $notices  = array_merge($notices, $decoded['results']);
            $next_url = !empty($decoded['next']) ? $decoded['next'] : null;
        } elseif (is_array($decoded)) {
            // API isn't paginated after all, just a flat array
            $notices  = array_merge($notices, $decoded);
            $next_url = null;
        } else {
            $next_url = null;
        }

        $safety_i++;
    }

    if (!$notices_error) {
        set_transient($cache_key, $notices, 10 * MINUTE_IN_SECONDS);
    }
}

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid page-bg py-5">

    <div class="container">

        <?php get_template_part('template-parts/breadcrumb'); ?>

        <h2 class="pb-page-title">
            Ph.D. Viva Voce Dates
        </h2>

        <?php if ($notices_error): ?>

            <div class="alert alert-danger"><?php echo esc_html($notices_error); ?></div>

        <?php elseif (empty($notices)): ?>

            <div class="alert alert-warning">No viva voce dates available.</div>

        <?php else: ?>

            <div class="row pb-notice-grid">

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

                    <div class="col-lg-6 mb-3 pb-notice-item">
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

            <nav class="pb-pagination" aria-label="Notices pagination">
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

/* Pagination */
.pb-pagination{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    margin-top:30px;
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

@media (max-width: 577px){

    .pb-pagination{
        gap:6px;
        margin-top:22px;
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
document.addEventListener('DOMContentLoaded', function () {

    var grid       = document.querySelector('.pb-notice-grid');
    if (!grid) return;

    var items       = Array.prototype.slice.call(grid.querySelectorAll('.pb-notice-item'));
    var perPage     = 20;
    var totalPages  = Math.max(1, Math.ceil(items.length / perPage));
    var currentPage = 1;

    var pagination  = document.querySelector('.pb-pagination');
    var numbersWrap = pagination ? pagination.querySelector('.pb-page-numbers') : null;
    var prevBtn     = pagination ? pagination.querySelector('.pb-prev') : null;
    var nextBtn     = pagination ? pagination.querySelector('.pb-next') : null;

    if (!pagination || totalPages <= 1) {
        if (pagination) pagination.style.display = 'none';
        return;
    }

    function renderItems() {
        var start = (currentPage - 1) * perPage;
        var end   = start + perPage;

        items.forEach(function (item, idx) {
            item.style.display = (idx >= start && idx < end) ? '' : 'none';
        });
    }

    function renderNumbers() {
        numbersWrap.innerHTML = '';

        var pagesToShow = [];
        var delta = 1;

        for (var p = 1; p <= totalPages; p++) {
            if (p === 1 || p === totalPages || (p >= currentPage - delta && p <= currentPage + delta)) {
                pagesToShow.push(p);
            }
        }

        var lastPushed = 0;
        pagesToShow.forEach(function (p) {
            if (lastPushed && p - lastPushed > 1) {
                var dots = document.createElement('span');
                dots.className = 'pb-page-num ellipsis';
                dots.textContent = '…';
                numbersWrap.appendChild(dots);
            }

            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'pb-page-num' + (p === currentPage ? ' active' : '');
            btn.textContent = p;
            btn.addEventListener('click', function () {
                currentPage = p;
                update();
            });
            numbersWrap.appendChild(btn);

            lastPushed = p;
        });

        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;
    }

    function update() {
        renderItems();
        renderNumbers();
        pagination.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    prevBtn.addEventListener('click', function () {
        if (currentPage > 1) {
            currentPage--;
            update();
        }
    });

    nextBtn.addEventListener('click', function () {
        if (currentPage < totalPages) {
            currentPage++;
            update();
        }
    });

    update();
});
</script>

<?php get_footer(); ?>