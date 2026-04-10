<?php
/*
Template name: Notices Template
*/

get_header();

$category_param = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
$current_page   = isset($_GET['notice_page']) ? max(1, intval($_GET['notice_page'])) : 1;
$per_page       = 9;

$api_base   = getenv('DJANGO_API_URL');
$api_url = $api_base . '/api/v1/global-notices/';
if ( !empty($category_param) ) {
    $api_url .= '?category=' . urlencode($category_param);
}

$response = wp_remote_get($api_url, array('timeout' => 10));
$notices_data = array();

if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
    $body = wp_remote_retrieve_body( $response );
    $decoded = json_decode( $body, true );
    $notices_data = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

function get_notice_href_page($n) {

    if (!empty($n['attachment'])) 
        return $n['attachment'];

    if (!empty($n['link']))
        return $n['link'];

    return '#';
}

$page_title = empty($category_param) ? 'All Notices' : esc_html(ucfirst($category_param)) . 's';

// --- ARRAY PAGINATION LOGIC ---
$total_notices = count($notices_data);
$total_pages   = ceil($total_notices / $per_page);

if ($current_page > $total_pages && $total_pages > 0) {
    $current_page = $total_pages;
}

$offset = ($current_page - 1) * $per_page;
$notices_to_display = array_slice($notices_data, $offset, $per_page);
// ------------------------------

?>

<div class="page-bg">

    <main id="primary" class="site-main" style="background:#f3f4f6; padding-bottom:60px;">
        <div class="notices-container">
            <h1 class="notices-title"><?php echo $page_title; ?></h1>
            <ul class="notices-list">
                <?php if ( !empty($notices_to_display) ) : ?>
                <?php foreach ( $notices_to_display as $notice ) : ?>
                <li>
                    <a href="<?php echo esc_url(get_notice_href_page($notice)); ?>" target="_blank">
                        <?php echo esc_html($notice['title']); ?>
                    </a>
                    <div class="notices-meta">
                        <span><i class="fa fa-folder-open"></i>
                            <?php $cats = isset($notice['categories']) && is_array($notice['categories']) ? implode(', ', $notice['categories']) : ''; echo esc_html($cats); ?></span>
                        <span><i class="fa fa-calendar"></i>
                            <?php echo esc_html(date('F j, Y', strtotime($notice['date_posted']))); ?></span>
                    </div>
                </li>
                <?php endforeach; ?>
                <?php else : ?>
                <li style="text-align:center; color:#6b7280; font-size:1.1rem; border-left:none;">No notices found for
                    this
                    category at the moment.</li>
                <?php endif; ?>
            </ul>

            <?php if ($total_pages > 1) : ?>
            <div class="pagination-controls">
                <?php
                $prev_url = add_query_arg('notice_page', max(1, $current_page - 1));
                $next_url = add_query_arg('notice_page', min($total_pages, $current_page + 1));
                ?>
                <a href="<?php echo esc_url($prev_url); ?>"
                    class="<?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">« </a>
                <span class="page-info">Page <?php echo intval($current_page); ?> of
                    <?php echo intval($total_pages); ?></span>
                <a href="<?php echo esc_url($next_url); ?>"
                    class="<?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>"> »</a>
            </div>
            <?php endif; ?>

            <div class="btn-back-wrap">
                <a href="/" class="btn-back">Back to Homepage</a>
            </div>
        </div>
    </main>
</div>
<?php
get_footer();
?>

<style>
.notices-container {
    max-width: 1200px;
    margin: auto;
    padding: 0 20px;
    font-family: 'Inter', sans-serif;
}

.notices-title {
    text-align: center;
    margin-bottom: 30px;
    font-size: 2.5rem;
    color: #1f2937;
}

.notices-list {
    list-style: none;
    padding: 0;
}

.notices-list li {
    background: #ffffff;
    margin-bottom: 15px;
    padding: 25px;
    border-radius: 12px;
    border-left: 6px solid #ea580c;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: transform 0.2s ease;
}

.notices-list li:hover {
    transform: translateY(-3px);
}

.notices-list li a {
    text-decoration: none;
    color: #111827;
    font-size: 1.25rem;
    font-weight: 600;
    display: block;
    margin-bottom: 8px;
}

.notices-list li a:hover {
    color: #ea580c;
    text-decoration: underline;
}

.notices-meta {
    display: flex;
    gap: 20px;
    font-size: 0.95rem;
    color: #6b7280;
    font-weight: 500;
}

.btn-back-wrap {
    text-align: center;
    margin-top: 40px;
}

.btn-back {
    padding: 12px 28px;
    background: #1f2937;
    color: white !important;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: background 0.3s;
    display: inline-block;
}

.btn-back:hover {
    background: #ea580c;
}

/* Pagination Styles */
.pagination-controls {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    margin-top: 30px;
}

.pagination-controls a {
    padding: 8px 16px;
    background: #ea580c;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
    transition: background 0.2s;
}

.pagination-controls a:hover {
    background: #c2410a;
}

.pagination-controls .page-info {
    font-weight: 600;
    color: #374151;
    font-size: 1.1rem;
}

.pagination-controls a.disabled {
    background: #d1d5db;
    color: #9ca3af;
    pointer-events: none;
}
</style>