<?php
/*
Template name: Notices Template
*/

get_header();

$category_param = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
$current_page   = isset($_GET['notice_page']) ? max(1, intval($_GET['notice_page'])) : 1;
$per_page       = 20; 


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

$total_notices = count($notices_data);
$total_pages   = ceil($total_notices / $per_page);

if ($current_page > $total_pages && $total_pages > 0) {
    $current_page = $total_pages;
}

$offset = ($current_page - 1) * $per_page;
$notices_to_display = array_slice($notices_data, $offset, $per_page);
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

    <div class="ntl-grid">

        <?php if (!empty($notices_to_display)) : ?>
        <?php foreach ($notices_to_display as $i => $notice) : 
            $index = $offset + $i + 1;
            $href = esc_url(get_notice_href_page($notice));
            $is_new = ($index === 1);
        ?>

        <a class="ntl-item" href="<?php echo $href; ?>" target="_blank">

            <div class="ntl-card">
                <div class="ntl-card-num">
                    <?php echo str_pad($index, 2, '0', STR_PAD_LEFT); ?>
                </div>

                <div class="ntl-card-body">
                    <p class="ntl-card-title">
                        <?php echo esc_html($notice['title']); ?>
                    </p>

                    <div class="ntl-card-date">
                        <?php echo esc_html(date('F j, Y', strtotime($notice['date_posted']))); ?>
                    </div>
                </div>

                <div class="ntl-card-right">
                    <?php if ($is_new) : ?>
                        <span class="ntl-new-pill">New</span>
                    <?php endif; ?>
                    <span class="ntl-arr">→</span>
                </div>
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
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');

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
    margin-bottom: 2.5rem;
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

.ntl-title em {
    color: #f97316;
    font-style: normal;
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
.ntl-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px 20px;
}

.ntl-item {
    position: relative;
    text-decoration: none;
    display: block;
}

.ntl-card {
    background: #fff;
    border: 1px solid #e7e5e4;
    border-radius: 14px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    height: 100%;
    transition: 0.25s;
}

.ntl-item:hover .ntl-card {
    background: #fff7ed;
    border-color: #fed7aa;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(249, 115, 22, 0.12);
}

.ntl-card-num {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: #fff7ed;
    border: 1px solid #fed7aa;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: #fb923c;
    flex-shrink: 0;
    transition: 0.25s;
}

.ntl-item:hover .ntl-card-num {
    background: #f97316;
    color: #fff;
}
.ntl-card-body {
    flex: 1;
    min-width: 0;
}

.ntl-card-title {
    font-size: 15px;
    font-weight: 600;
    color: #1c1917;
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.ntl-item:hover .ntl-card-title {
    color: #9a3412;
}

.ntl-card-date {
    font-size: 11px;
    color: #78716c;
    display: flex;
    align-items: center;
    gap: 4px;
}

.ntl-card-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 5px;
    flex-shrink: 0;
}

.ntl-new-pill {
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    background: #fff7ed;
    color: #c2410c;
    border: 1px solid #fed7aa;
    padding: 2px 7px;
    border-radius: 20px;
}

/* ARROW */
.ntl-arr {
    font-size: 14px;
    color: #fb923c;
    opacity: 0;
    transform: translateX(-5px);
    transition: 0.2s;
}

.ntl-item:hover .ntl-arr {
    opacity: 1;
    transform: translateX(0);
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

/* BACK BUTTON */
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

/* PAGINATION */
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
        font-size: 13px;
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
}
</style>
<?php get_footer(); ?>