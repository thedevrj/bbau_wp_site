<?php
/**
 * Template Name: Research Publications
 */

get_header();

$api_base = getenv('DJANGO_API_URL');
$pubs_url = $api_base . '/api/v1/publications/';
$pubs_res = wp_remote_get($pubs_url, array('timeout' => 10));
$publications = array();

if (!is_wp_error($pubs_res) && wp_remote_retrieve_response_code($pubs_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($pubs_res), true);
    $publications = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

// Fetch Depts for filter
$depts_url = $api_base . '/api/v1/departments/';
$depts_res = wp_remote_get($depts_url, array('timeout' => 10));
$departments = array();
if (!is_wp_error($depts_res) && wp_remote_retrieve_response_code($depts_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($depts_res), true);
    $departments = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<main id="primary" class="site-main research-portal">
    <div class="research-hero" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
        <div class="container">
            <h1>Research Publications</h1>
            <p>A comprehensive repository of journals, books, and conference proceedings published by our faculty and research scholars.</p>
            <a href="/research-hub" class="back-link"><i class="fas fa-arrow-left"></i> Back to Research Hub</a>
        </div>
    </div>

    <div class="research-container container">
        <div class="portal-header">
            <h2 class="section-title">Academic Publications</h2>
            <div class="filter-controls">
                <select id="pub-dept-filter" class="custom-select">
                    <option value="">All Departments</option>
                    <?php foreach($departments as $dept): ?>
                        <option value="<?php echo esc_attr($dept['slug']); ?>"><?php echo esc_html($dept['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="publications-list">
            <?php if(!empty($publications)): ?>
                <?php foreach($publications as $pub): ?>
                <div class="pub-card" data-dept="<?php echo esc_attr($pub['department_slug'] ?? ''); ?>">
                    <div class="pub-type"><?php echo esc_html($pub['publication_type']); ?></div>
                    <h3 class="pub-title"><?php echo esc_html($pub['title']); ?></h3>
                    <div class="pub-authors">
                        <i class="fas fa-user-edit"></i> <?php echo esc_html($pub['faculty_name']); ?>
                    </div>
                    <div class="pub-venue">
                        <strong><?php echo esc_html($pub['journal_name'] ?? 'Publisher/Venue'); ?></strong> | <?php echo esc_html($pub['publication_year']); ?>
                    </div>
                    <?php if(!empty($pub['doi_url'])): ?>
                        <a href="<?php echo esc_url($pub['doi_url']); ?>" target="_blank" class="doi-link">View DOI <i class="fas fa-external-link-alt"></i></a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-data">No publications are currently listed.</div>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
document.getElementById('pub-dept-filter').addEventListener('change', function() {
    const slug = this.value;
    document.querySelectorAll('.pub-card').forEach(card => {
        card.style.display = (!slug || card.dataset.dept === slug) ? '' : 'none';
    });
});
</script>

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>
<style>
.pub-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border-left: 4px solid #1e3a8a;
    position: relative;
    transition: transform 0.2s;
}

.pub-card:hover {
    transform: translateX(5px);
}

.pub-type {
    position: absolute;
    top: 20px;
    right: 25px;
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    background: #f1f5f9;
    padding: 4px 10px;
    border-radius: 20px;
    color: #64748b;
}

.pub-title {
    font-size: 1.25rem;
    color: #1e293b;
    line-height: 1.4;
    margin-bottom: 12px;
    padding-right: 100px;
}

.pub-authors {
    color: #475569;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.pub-venue {
    color: #64748b;
    font-size: 0.9rem;
}

.doi-link {
    display: inline-block;
    margin-top: 15px;
    font-weight: 700;
    color: #3b82f6;
    text-decoration: none;
    font-size: 0.85rem;
}
</style>

<?php get_footer(); ?>
