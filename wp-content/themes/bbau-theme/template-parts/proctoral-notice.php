<?php
/**
 * Template Name: Proctorial Board Notices Page
 */
defined('ABSPATH') || exit;

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
$BBAU_PBN_API = $media_base . '/api/v1/proctor/proctorial-board-notices/';

$notices       = array();
$notices_error = '';

$cache_key = 'bbau_pbn_notices_all';
$cached    = get_transient($cache_key);

if ($cached !== false) {

    $notices = $cached;

} else {

    $next_url  = $BBAU_PBN_API;
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

$bbau_pbn_years = array();

if (!empty($notices)) {
    foreach ($notices as $n) {
        if (!empty($n['date'])) {
            $ts = strtotime($n['date']);
            if ($ts) {
                $bbau_pbn_years[(int) date('Y', $ts)] = true;
            }
        }
    }
    krsort($bbau_pbn_years);
    $bbau_pbn_years = array_keys($bbau_pbn_years);
}

$bbau_months = array(
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
);

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid page-bg py-5">

    <div class="container">

        <?php get_template_part('template-parts/breadcrumb'); ?>
        <?php get_template_part('menu/menu'); ?>

        <h2 class="pb-page-title">
            Proctorial Board Notices
        </h2>

        <?php if ($notices_error): ?>

            <div class="alert alert-danger"><?php echo esc_html($notices_error); ?></div>

        <?php elseif (empty($notices)): ?>

            <div class="alert alert-warning">No notices available.</div>

        <?php else: ?>

            <div class="pb-filter-bar">

                <div class="pb-filter-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="pbSearchInput" placeholder="Search by name...">
                </div>

                <select id="pbYearFilter" class="pb-filter-select">
                    <option value="">All Years</option>
                    <?php foreach ($bbau_pbn_years as $y): ?>
                        <option value="<?php echo esc_attr($y); ?>"><?php echo esc_html($y); ?></option>
                    <?php endforeach; ?>
                </select>

                <select id="pbMonthFilter" class="pb-filter-select">
                    <option value="">All Months</option>
                    <?php foreach ($bbau_months as $num => $label): ?>
                        <option value="<?php echo esc_attr($num); ?>"><?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="button" id="pbFilterClear" class="pb-filter-clear">
                    <i class="fa-solid fa-xmark"></i> Clear
                </button>

            </div>

            <div class="pb-filter-empty" id="pbFilterEmpty" style="display:none;">
                No notices match your filters.
            </div>

            <div class="row pb-notice-grid">

                <?php foreach ($notices as $notice): ?>

                    <?php
                    $title    = esc_html($notice['title'] ?? '');
                    $date_raw = $notice['date'] ?? '';
                    $file     = '';

                    $display_date = '';
                    $data_year    = '';
                    $data_month   = '';

                    if ($date_raw) {
                        $ts = strtotime($date_raw);
                        if ($ts) {
                            $display_date = date('d F Y', $ts); // e.g. 14 August 2026
                            $data_year    = date('Y', $ts);
                            $data_month   = date('n', $ts);
                        }
                    }

                    if (!empty($notice['file'])) {
                        if (filter_var($notice['file'], FILTER_VALIDATE_URL)) {
                            $file = $notice['file'];
                        } else {
                            $file = $media_base . $notice['file'];
                        }
                    }
                    ?>

                    <div class="col-lg-6 mb-3 pb-notice-item"
                         data-title="<?php echo esc_attr(mb_strtolower($notice['title'] ?? '')); ?>"
                         data-year="<?php echo esc_attr($data_year); ?>"
                         data-month="<?php echo esc_attr($data_month); ?>">
                        <a class="pb-notice-card" <?php if ($file): ?>href="<?php echo esc_url($file); ?>" target="_blank" rel="noopener"<?php endif; ?>>
                            <span class="pb-notice-icon">
                                <i class="fa-solid fa-bullhorn"></i>
                            </span>
                            <span class="pb-notice-body">
                                <span class="pb-notice-title"><?php echo $title; ?></span>
                                <span class="pb-notice-meta">notice &bull; <?php echo esc_html($display_date); ?></span>
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

/* Filter bar */
.pb-filter-bar{
    display:flex;
    flex-wrap:wrap;
    align-items:center;
    gap:14px;
    margin-bottom:22px;
}

.pb-filter-search{
    display:flex;
    align-items:center;
    gap:10px;
    flex:0 0 240px;
    background:#fff;
    border:1.5px solid #cfd0e0;
    border-radius:999px;
    padding:0 18px;
}

.pb-filter-search i{
    color:#9a9ab0;
    font-size:14px;
}

.pb-filter-search input{
    border:none;
    outline:none;
    padding:12px 0;
    width:100%;
    font-size:14px;
    background:transparent;
    color:#1a1a1a;
}

.pb-filter-search input::placeholder{
    color:#a3a3b3;
}

.pb-filter-select{
    padding:12px 18px;
    border-radius:999px;
    border:1.5px solid #cfd0e0;
    background:#fff;
    font-size:14px;
    color:#1a1a1a;
    cursor:pointer;
    flex:0 0 auto;
}

.pb-filter-select:focus{
    outline:none;
    border-color:#5c1010;
}

.pb-filter-clear{
    display:flex;
    align-items:center;
    gap:6px;
    padding:12px 18px;
    border-radius:999px;
    border:1.5px solid #cfd0e0;
    background:#fff;
    color:#5c1010;
    font-weight:600;
    font-size:13px;
    cursor:pointer;
    transition:.2s;
    flex:0 0 auto;
}

.pb-filter-clear:hover{
    background:#5c1010;
    border-color:#5c1010;
    color:#fff;
}

.pb-filter-empty{
    text-align:center;
    padding:30px 15px;
    color:#8B1A1A;
    font-weight:600;
    background:#fdfbf7;
    border-radius:14px;
    margin-bottom:20px;
}

@media (max-width: 577px){
    .pb-filter-bar{
        gap:10px;
    }
    .pb-filter-search{
        flex:1 1 100%;
    }
    .pb-filter-select,
    .pb-filter-clear{
        flex:1 1 auto;
        padding:11px 14px;
        font-size:13px;
    }
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

    var grid = document.querySelector('.pb-notice-grid');
    if (!grid) return;

    var allItems     = Array.prototype.slice.call(grid.querySelectorAll('.pb-notice-item'));
    var perPage       = 20;
    var currentPage   = 1;
    var filteredItems = allItems.slice();

    var searchInput  = document.getElementById('pbSearchInput');
    var yearFilter   = document.getElementById('pbYearFilter');
    var monthFilter  = document.getElementById('pbMonthFilter');
    var clearBtn     = document.getElementById('pbFilterClear');
    var emptyMsg     = document.getElementById('pbFilterEmpty');

    var pagination   = document.querySelector('.pb-pagination');
    var numbersWrap  = pagination ? pagination.querySelector('.pb-page-numbers') : null;
    var prevBtn      = pagination ? pagination.querySelector('.pb-prev') : null;
    var nextBtn      = pagination ? pagination.querySelector('.pb-next') : null;

    function applyFilters() {
        var searchVal = (searchInput.value || '').trim().toLowerCase();
        var yearVal   = yearFilter.value;
        var monthVal  = monthFilter.value;

        filteredItems = allItems.filter(function (item) {
            var titleMatch = !searchVal || item.getAttribute('data-title').indexOf(searchVal) !== -1;
            var yearMatch  = !yearVal || item.getAttribute('data-year') === yearVal;
            var monthMatch = !monthVal || item.getAttribute('data-month') === monthVal;
            return titleMatch && yearMatch && monthMatch;
        });

        allItems.forEach(function (item) {
            item.style.display = 'none';
        });

        currentPage = 1;

        if (filteredItems.length === 0) {
            emptyMsg.style.display = 'block';
            grid.style.display = 'none';
            if (pagination) pagination.style.display = 'none';
            return;
        }

        emptyMsg.style.display = 'none';
        grid.style.display = '';

        renderPagination();
    }

    function renderPage() {
        var start = (currentPage - 1) * perPage;
        var end   = start + perPage;

        allItems.forEach(function (item) {
            item.style.display = 'none';
        });

        filteredItems.slice(start, end).forEach(function (item) {
            item.style.display = '';
        });
    }

    function renderNumbers() {
        var totalPages = Math.max(1, Math.ceil(filteredItems.length / perPage));

        if (totalPages <= 1) {
            if (pagination) pagination.style.display = 'none';
            return;
        }

        if (pagination) pagination.style.display = '';

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
                renderPagination();
                pagination.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            });
            numbersWrap.appendChild(btn);

            lastPushed = p;
        });

        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;
    }

    function renderPagination() {
        renderPage();
        renderNumbers();
    }

    prevBtn.addEventListener('click', function () {
        if (currentPage > 1) {
            currentPage--;
            renderPagination();
            pagination.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    });

    nextBtn.addEventListener('click', function () {
        var totalPages = Math.max(1, Math.ceil(filteredItems.length / perPage));
        if (currentPage < totalPages) {
            currentPage++;
            renderPagination();
            pagination.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    });

    var searchDebounce;
    searchInput.addEventListener('input', function () {
        clearTimeout(searchDebounce);
        searchDebounce = setTimeout(applyFilters, 250);
    });

    yearFilter.addEventListener('change', applyFilters);
    monthFilter.addEventListener('change', applyFilters);

    clearBtn.addEventListener('click', function () {
        searchInput.value = '';
        yearFilter.value = '';
        monthFilter.value = '';
        applyFilters();
    });

    applyFilters();
});
</script>

<?php get_footer(); ?>