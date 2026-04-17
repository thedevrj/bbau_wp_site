<?php
/**
 * Template Name: Research Patents
 */

get_header();

$api_base = getenv('DJANGO_API_URL');
$patents_url = $api_base . '/api/v1/patents/';
$patents_res = wp_remote_get($patents_url, array('timeout' => 10));
$patents = array();

if (!is_wp_error($patents_res) && wp_remote_retrieve_response_code($patents_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($patents_res), true);
    $patents = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<main id="primary" class="site-main research-portal">
    <div class="research-hero" style="background: linear-gradient(135deg, #7c2d12 0%, #b45309 100%);">
        <div class="container">
            <h1>Research Patents</h1>
            <p>Showcasing the intellectual property and innovative breakthroughs registered by our University fraternity.</p>
            <a href="/research-hub" class="back-link"><i class="fas fa-arrow-left"></i> Back to Research Hub</a>
        </div>
    </div>

    <div class="research-container container">
        <div class="patents-grid">
            <?php if(!empty($patents)): ?>
                <?php foreach($patents as $patent): ?>
                <div class="patent-card">
                    <div class="patent-header">
                        <span class="patent-year"><?php echo esc_html($patent['year']); ?></span>
                        <span class="status-badge <?php echo strtolower($patent['status']); ?>">
                            <?php echo esc_html($patent['status']); ?>
                        </span>
                    </div>
                    <h3 class="patent-title"><?php echo esc_html($patent['title']); ?></h3>
                    <div class="patent-info">
                        <div class="info-item">
                            <strong>Inventor:</strong> <?php echo esc_html($patent['faculty_name']); ?>
                        </div>
                        <?php if(!empty($patent['patent_number'])): ?>
                        <div class="info-item">
                            <strong>No:</strong> <?php echo esc_html($patent['patent_number']); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-data">No patents are currently registered in the hub.</div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>
<style>
.patents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
}

.patent-card {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    border-top: 5px solid #b45309;
    display: flex;
    flex-direction: column;
}

.patent-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    align-items: center;
}

.patent-year {
    font-weight: 800;
    color: #92400e;
    font-size: 1.1rem;
}

.patent-title {
    font-size: 1.3rem;
    color: #111827;
    line-height: 1.4;
    margin-bottom: 20px;
    flex-grow: 1;
}

.patent-info {
    border-top: 1px solid #f1f5f9;
    padding-top: 15px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.info-item {
    font-size: 0.95rem;
    color: #4b5563;
}

.info-item strong {
    color: #1f2937;
}

.status-badge.filed { background: #fee2e2; color: #991b1b; }
.status-badge.published { background: #ffedd5; color: #9a3412; }
.status-badge.granted { background: #dcfce7; color: #166534; }
</style>

<?php get_footer(); ?>
