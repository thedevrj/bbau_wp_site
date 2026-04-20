<?php
/**
 * Template Name: Research Facilities
 */

get_header();

$api_base = getenv('DJANGO_API_URL');
$facilities_url = $api_base . '/api/v1/research-facilities/';
$facilities_res = wp_remote_get($facilities_url, array('timeout' => 10));
$facilities = array();

if (!is_wp_error($facilities_res) && wp_remote_retrieve_response_code($facilities_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($facilities_res), true);
    $facilities = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<main id="primary" class="site-main research-portal">
    <div class="research-hero" style="background: linear-gradient(135deg, #065f46 0%, #10b981 100%);">
        <div class="container">
            <h1>Research Facilities</h1>
            <p>Advanced laboratories and instrumentation centers supporting multi-disciplinary research.</p>
            <a href="/research-hub" class="back-link"><i class="fas fa-arrow-left"></i> Back to Research Hub</a>
        </div>
    </div>

    <div class="research-container container">
        <div class="facility-grid">
            <?php if(!empty($facilities)): ?>
                <?php foreach($facilities as $facility): ?>
                <div class="facility-card">
                    <?php if(!empty($facility['image'])): ?>
                        <div class="facility-image">
                            <img src="<?php echo esc_url($facility['image']); ?>" alt="<?php echo esc_attr($facility['name']); ?>">
                        </div>
                    <?php endif; ?>
                    <div class="facility-content">
                        <h3><?php echo esc_html($facility['name']); ?></h3>
                        <div class="facility-meta">
                            <span><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($facility['location']); ?></span>
                            <?php if(!empty($facility['incharge_name'])): ?>
                                <span><i class="fas fa-user-tie"></i> In-charge: <?php echo esc_html($facility['incharge_name']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="facility-description">
                            <?php echo wp_kses_post($facility['description']); ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-data">No research facilities are currently listed.</div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>
<style>
.back-link {
    color: white;
    text-decoration: none;
    font-weight: 600;
    margin-top: 20px;
    display: inline-block;
    padding: 8px 20px;
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 30px;
    transition: all 0.3s;
}
.back-link:hover {
    background: white;
    color: #065f46;
}

.facility-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 40px;
}

.facility-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: row;
}

.facility-image {
    width: 400px;
    flex-shrink: 0;
}

.facility-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.facility-content {
    padding: 40px;
}

.facility-content h3 {
    font-size: 1.8rem;
    color: #111827;
    margin-bottom: 15px;
}

.facility-meta {
    display: flex;
    gap: 25px;
    margin-bottom: 25px;
    color: #6b7280;
    font-weight: 600;
    font-size: 0.9rem;
}

.facility-description {
    line-height: 1.7;
    color: #4b5563;
}

@media (max-width: 992px) {
    .facility-card { flex-direction: column; }
    .facility-image { width: 100%; height: 250px; }
}
</style>

<?php get_footer(); ?>
