<?php
// Inherited variables: $api_base, $slug
$notices_url = $api_base . '/api/v1/notices/?department__slug=' . urlencode($slug) . '&page_size=100';
$notices_res = wp_remote_get($notices_url, array('timeout' => 10));
$notices_list = array();

if (!is_wp_error($notices_res) && wp_remote_retrieve_response_code($notices_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($notices_res), true);
    $notices_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<div class="section">
    <h3>Department Notices</h3>
    <?php if(!empty($notices_list)): ?>
    <div class="notice-list-wrap">
        <?php foreach($notices_list as $notice): ?>
        <div class="notice-item">
            <div class="notice-date">
                <span class="day"><?php echo date('d', strtotime($notice['date_posted'])); ?></span>
                <span class="month"><?php echo date('M', strtotime($notice['date_posted'])); ?></span>
            </div>
            <div class="notice-content">
                <h4><?php echo esc_html($notice['title']); ?></h4>
                <div class="notice-description">
                    <?php echo wp_kses_post($notice['content']); ?>
                </div>
                <?php if(!empty($notice['attachment'])): ?>
                <a href="<?php echo esc_url($notice['attachment']); ?>" target="_blank" class="notice-download">
                    <i class="fa-solid fa-file-pdf"></i> Download Attachment
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p style="margin-top:20px; color:#555;">No active notices for this department at the moment.</p>
    <?php endif; ?>
</div>

<style>
.notice-list-wrap {
    margin-top: 25px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.notice-item {
    display: flex;
    gap: 20px;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    border-left: 5px solid #8B1A1A;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: 0.3s;
}

.notice-item:hover {
    transform: translateX(5px);
    box-shadow: 0 8px 25px rgba(139, 26, 26, 0.1);
}

.notice-date {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-width: 70px;
    height: 70px;
    background: #fdfaf6;
    border: 1px solid #e2d9cc;
    border-radius: 8px;
    color: #5c1010;
}

.notice-date .day {
    font-size: 1.4rem;
    font-weight: 800;
    line-height: 1;
}

.notice-date .month {
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
}

.notice-content h4 {
    margin: 0 0 10px 0;
    color: #5c1010;
    font-family: 'Merriweather', serif;
    font-size: 1.1rem;
    font-weight: 700;
}

.notice-description {
    font-size: 0.9rem;
    color: #444;
    line-height: 1.6;
    margin-bottom: 12px;
}

.notice-download {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f3f4f6;
    color: #8B1A1A;
    padding: 6px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none;
    transition: 0.2s;
}

.notice-download:hover {
    background: #8B1A1A;
    color: #fff;
}
</style>
