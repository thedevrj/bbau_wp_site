<?php
/*
Template name: Notices Template
*/

get_header();

$category_param = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
$search_param    = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
$year_param      = isset($_GET['year']) ? sanitize_text_field($_GET['year']) : '';
$month_param     = isset($_GET['month']) ? sanitize_text_field($_GET['month']) : '';
$current_page    = isset($_GET['notice_page']) ? max(1, intval($_GET['notice_page'])) : 1;
$per_page        = 20; 


$api_base = getenv('DJANGO_API_URL');
$api_url  = $api_base . '/api/v1/global-notices/?page_size=100';

if (!empty($category_param)) {
    $api_url .= '&category=' . urlencode($category_param);
}

$response = wp_remote_get($api_url, array('timeout' => 10));
$notices_data = array();

if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
    $body = wp_remote_retrieve_body($response);
    $decoded = json_decode($body, true);
    $notices_data = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

function get_notice_href_page($n) {
    if (!empty($n['attachment'])) return $n['attachment'];
    if (!empty($n['link'])) return $n['link'];
    return '#';
}

$page_name = !empty($category_param) ? ucfirst($category_param) : 'Notice';

function pluralize($word) {
    if (strtolower($word) === 'news') return 'News';
    return strtolower($word) . 's';
}

$available_years = array();
foreach ($notices_data as $n) {
    if (!empty($n['date_posted'])) {
        $y = date('Y', strtotime($n['date_posted']));
        if ($y && !in_array($y, $available_years)) {
            $available_years[] = $y;
        }
    }
}
rsort($available_years);

$months_list = array(
    '01' => 'January', '02' => 'February', '03' => 'March',
    '04' => 'April',   '05' => 'May',      '06' => 'June',
    '07' => 'July',    '08' => 'August',   '09' => 'September',
    '10' => 'October',  '11' => 'November', '12' => 'December'
);

if ($search_param !== '' || $year_param !== '' || $month_param !== '') {
    $notices_data = array_values(array_filter($notices_data, function ($n) use ($search_param, $year_param, $month_param) {
        if ($search_param !== '') {
            $title = isset($n['title']) ? $n['title'] : '';
            if (mb_stripos($title, $search_param) === false) {
                return false;
            }
        }
        if (!empty($n['date_posted'])) {
            $ts = strtotime($n['date_posted']);
            if ($year_param !== '' && date('Y', $ts) !== $year_param) {
                return false;
            }
            if ($month_param !== '' && date('m', $ts) !== $month_param) {
                return false;
            }
        } elseif ($year_param !== '' || $month_param !== '') {
            return false;
        }
        return true;
    }));
}

$total_notices = count($notices_data);
$total_pages   = ceil($total_notices / $per_page);

if ($current_page > $total_pages && $total_pages > 0) {
    $current_page = $total_pages;
}

$offset = ($current_page - 1) * $per_page;
$notices_to_display = array_slice($notices_data, $offset, $per_page);

$has_active_filters = ($search_param !== '' || $year_param !== '' || $month_param !== '');

$base_args = array();
if (!empty($category_param)) {
    $base_args['category'] = $category_param;
}
$clear_url = add_query_arg($base_args, strtok($_SERVER['REQUEST_URI'], '?'));
?>

<div class="page-bg">
<main id="primary" class="site-main">
<div class="ntl-wrap">

    <div class="ntl-hdr">
        <div class="ntl-hdr-left">
            <div class="ntl-tag-line">
                <span class="ntl-tag-dot"></span>
                Updates
            </div>

            <h1 class="ntl-title">
                <?php echo esc_html($page_name); ?>
            </h1>
        </div>

        <div class="ntl-hdr-box">
            <div class="ntl-hdr-num">
                <?php echo str_pad($total_notices, 2, '0', STR_PAD_LEFT); ?>
            </div>
            <div class="ntl-hdr-lbl">
                <?php echo esc_html(($page_name)); ?>
            </div>
        </div>
    </div>
    <form class="ntl-filterbar" id="ntl-filter-form" method="get">
        <?php if (!empty($category_param)) : ?>
            <input type="hidden" name="category" value="<?php echo esc_attr($category_param); ?>">
        <?php endif; ?>

        <label class="ntl-search">
            <i class="fa fa-search"></i>
            <input
                type="text"
                name="s"
                id="ntl-search-input"
                placeholder="Search by name..."
                value="<?php echo esc_attr($search_param); ?>"
                autocomplete="off"
            >
        </label>

        <div class="ntl-select-wrap">
            <select name="year" id="ntl-year-select" class="ntl-select">
                <option value="">All Years</option>
                <?php foreach ($available_years as $y) : ?>
                    <option value="<?php echo esc_attr($y); ?>" <?php selected($year_param, $y); ?>>
                        <?php echo esc_html($y); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="ntl-select-wrap">
            <select name="month" id="ntl-month-select" class="ntl-select">
                <option value="">All Months</option>
                <?php foreach ($months_list as $mnum => $mname) : ?>
                    <option value="<?php echo esc_attr($mnum); ?>" <?php selected($month_param, $mnum); ?>>
                        <?php echo esc_html($mname); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php if ($has_active_filters) : ?>
            <a href="<?php echo esc_url($clear_url); ?>" class="ntl-clear-btn">
                <i class="fa fa-times"></i> Clear
            </a>
        <?php else : ?>
            <button type="button" class="ntl-clear-btn ntl-clear-btn--off" disabled>
                <i class="fa fa-times"></i> Clear
            </button>
        <?php endif; ?>
    </form>

    <div class="ntl-grid">

        <?php if (!empty($notices_to_display)) : ?>
        <?php foreach ($notices_to_display as $i => $notice) :
            $index = $offset + $i + 1;
            $href = esc_url(get_notice_href_page($notice));
            $is_new = ($index === 1 && !$has_active_filters);
            $label = !empty($category_param) ? strtolower($category_param) : 'notice';
        ?>

        <a class="ntl-item" href="<?php echo $href; ?>" target="_blank">

            <div class="ntl-card">
                <div class="ntl-card-icon">
                    <i class="fa fa-bullhorn"></i>
                </div>

                <div class="ntl-card-body">
                    <p class="ntl-card-title">
                        <?php echo esc_html($notice['title']); ?>
                    </p>

                    <div class="ntl-card-date">
                        <?php echo esc_html($label); ?> &bull; <?php echo esc_html(date('d F Y', strtotime($notice['date_posted']))); ?>
                    </div>
                </div>

                <?php if ($is_new) : ?>
                    <span class="ntl-new-pill">New</span>
                <?php endif; ?>
            </div>
        </a>

        <?php endforeach; ?>
        <?php else : ?>
            <p class="ntl-empty">No <?php echo strtolower($page_name); ?> found.</p>
        <?php endif; ?>

    </div>

    <div class="ntl-foot">

        <a href="/" class="ntl-back-btn"><i class="fa fa-arrow-left"></i> Back to home</a>

        <?php if ($total_pages > 1) : ?>
        <div class="ntl-pager">

            <?php
            $prev = max(1, $current_page - 1);
            $next = min($total_pages, $current_page + 1);
            ?>

            <a href="<?php echo esc_url(add_query_arg('notice_page', $prev)); ?>"
               class="ntl-pb <?php echo ($current_page <= 1) ? 'off' : ''; ?>">‹</a>

            <?php
            $start = max(1, $current_page - 1);
            $end   = min($total_pages, $start + 2);
            for ($p = $start; $p <= $end; $p++) :
            ?>
            <a href="<?php echo esc_url(add_query_arg('notice_page', $p)); ?>"
               class="ntl-pb <?php echo ($p === $current_page) ? 'on' : ''; ?>">
               <?php echo $p; ?>
            </a>
            <?php endfor; ?>

            <a href="<?php echo esc_url(add_query_arg('notice_page', $next)); ?>"
               class="ntl-pb <?php echo ($current_page >= $total_pages) ? 'off' : ''; ?>">›</a>

        </div>
        <?php endif; ?>

    </div>

</div>
</main>
</div>
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Noto+Serif:wght@600;700&family=Noto+Serif+Devanagari:wght@600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.site-main,
.page-bg {
    width: 100% !important;
    max-width: 100% !important;
}

.site-main {
    background: #fafaf9;
    padding-bottom: 60px;
    min-height: 80vh;
}

.ntl-wrap {
    font-family: 'Outfit', sans-serif;
    width: 100%;
    margin: 0;
    padding: 3rem clamp(16px, 5vw, 60px);
}

.ntl-hdr {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.75rem;
}

.ntl-hdr-left {
    max-width: 70%;
}

.ntl-tag-line {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fff7ed;
    border: 1px solid #fed7aa;
    border-radius: 20px;
    padding: 4px 12px;
    font-size: 11px;
    font-weight: 600;
    color: #c2410c;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.ntl-tag-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #f97316;
    animation: ntl-blink 1.5s infinite;
}

@keyframes ntl-blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

.ntl-title {
    font-size: 1.9rem;
    font-weight: 700;
    color: #1c1917;
    line-height: 1.1;
}

.ntl-hdr-box {
    width: auto;
    height: auto;
    border-radius: 18px;
    background: #fff7ed;
    border: 1.5px solid #fed7aa;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding : 8px;
}

.ntl-hdr-num {
    font-size: 1.4rem;
    font-weight: 700;
    color: #c2410c;
}

.ntl-hdr-lbl {
    font-size: 9px;
    color: #fb923c;
}

.ntl-filterbar {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 2rem;
}

.ntl-search {
    flex: 1 1 260px;
    min-width: 220px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff;
    border: 1.5px solid #e7e1d6;
    border-radius: 999px;
    padding: 11px 20px;
    transition: 0.2s;
}

.ntl-search:focus-within {
    border-color: #8a3a3a;
    box-shadow: 0 0 0 3px rgba(138, 58, 58, 0.08);
}

.ntl-search i {
    color: #a39c8e;
    font-size: 14px;
}

.ntl-search input {
    border: none;
    outline: none;
    background: transparent;
    font-family: 'Outfit', sans-serif;
    font-size: 14px;
    color: #1c1917;
    width: 100%;
}

.ntl-search input::placeholder {
    color: #a39c8e;
}

.ntl-select-wrap {
    position: relative;
    flex: 0 0 auto;
}

.ntl-select {
    appearance: none;
    -webkit-appearance: none;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8' fill='none'%3E%3Cpath d='M1 1L6 6L11 1' stroke='%23716a5c' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 16px center;
    border: 1.5px solid #e7e1d6;
    border-radius: 999px;
    padding: 11px 38px 11px 20px;
    font-family: 'Outfit', sans-serif;
    font-size: 14px;
    font-weight: 500;
    color: #1c1917;
    cursor: pointer;
    transition: 0.2s;
}

.ntl-select:hover,
.ntl-select:focus {
    border-color: #8a3a3a;
    outline: none;
}

.ntl-clear-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    border: 1.5px solid #e7e1d6;
    border-radius: 999px;
    padding: 11px 20px;
    font-family: 'Outfit', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #1c1917;
    text-decoration: none;
    cursor: pointer;
    transition: 0.2s;
    white-space: nowrap;
}

.ntl-clear-btn i {
    color: #b02a2a;
    font-size: 12px;
}

.ntl-clear-btn:hover {
    border-color: #b02a2a;
    background: #fdf2f2;
}

.ntl-clear-btn--off {
    opacity: 0.45;
    pointer-events: none;
}

.ntl-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px 22px;
}

.ntl-item {
    position: relative;
    text-decoration: none;
    display: block;
}

.ntl-card {
    background: #fff;
    border: 1.5px solid #6d2e34;
    border-radius: 14px;
    padding: 18px 20px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    height: 100%;
    position: relative;
    transition: 0.2s;
}

.ntl-item:hover .ntl-card {
    background: #fdf8f2;
    box-shadow: 0 6px 18px rgba(109, 46, 52, 0.12);
    transform: translateY(-2px);
}

.ntl-card-icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: #f6ecd9;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #2b2723;
    font-size: 17px;
}

.ntl-card-body {
    flex: 1;
    min-width: 0;
}

.ntl-card-title {
    font-family: 'Noto Serif Devanagari', 'Noto Serif', 'Georgia', serif;
    font-size: 16px;
    font-weight: 700;
    color: #1b1712;
    line-height: 1.35;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.ntl-card-date {
    font-family: 'Outfit', sans-serif;
    font-size: 12px;
    font-weight: 500;
    color: #8a7a3d;
    text-transform: capitalize;
}

.ntl-new-pill {
    position: absolute;
    top: 14px;
    right: 16px;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    background: #fff7ed;
    color: #c2410c;
    border: 1px solid #fed7aa;
    padding: 2px 8px;
    border-radius: 20px;
}
.ntl-empty {
    text-align: center;
    padding: 2rem;
    color: #78716c;
    grid-column: 1 / -1;
}

.ntl-foot {
    margin-top: 2rem;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding-top: 1rem;
    border-top: 1px dashed #fed7aa;
}

.ntl-back-btn {
    padding: 7px 16px;
    border-radius: 8px;
    background: #fff7ed;
    border: 1px solid #fed7aa;
    color: #c2410c !important;
    font-weight: 600;
    text-decoration: none;
    transition: 0.2s;
}

.ntl-back-btn:hover {
    background: #ffedd5;
}

.ntl-pager {
    display: flex;
    gap: 5px;
}

.ntl-pb {
    min-width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid #e7e5e4;
    background: #fff;
    color: #78716c;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    text-decoration: none;
    transition: 0.2s;
}

.ntl-pb:hover {
    background: #fff7ed;
    color: #c2410c;
}

.ntl-pb.on {
    background: #f97316;
    color: #fff;
    border-color: #f97316;
}

.ntl-pb.off {
    opacity: 0.3;
    pointer-events: none;
}

@media (max-width: 768px) {
    .ntl-wrap {
        padding: 2rem 1rem;
    }

    .ntl-title {
        font-size: 1.5rem;
    }

    .ntl-card-title {
        font-size: 14px;
    }

    .ntl-hdr-box {
        width: auto;
        height: auto;
        margin: 8px;
    }

    .ntl-hdr-lbl {
        font-size: 7px;
    }

    .ntl-hdr-num {
        font-size: 1.3rem;
    }

    .ntl-grid {
        grid-template-columns: 1fr;
    }

    .ntl-filterbar {
        flex-direction: column;
        align-items: stretch;
    }

    .ntl-search,
    .ntl-select-wrap,
    .ntl-select,
    .ntl-clear-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
(function () {
    var form = document.getElementById('ntl-filter-form');
    if (!form) return;

    var searchInput = document.getElementById('ntl-search-input');
    var yearSelect  = document.getElementById('ntl-year-select');
    var monthSelect = document.getElementById('ntl-month-select');
    var debounceTimer;

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                form.submit();
            }, 500);
        });
    }

    if (yearSelect) {
        yearSelect.addEventListener('change', function () {
            form.submit();
        });
    }

    if (monthSelect) {
        monthSelect.addEventListener('change', function () {
            form.submit();
        });
    }
})();
</script>
<?php get_footer(); ?>