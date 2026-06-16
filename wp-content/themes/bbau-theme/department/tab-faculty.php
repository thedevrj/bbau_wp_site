<?php
// Inherited variables: $api_base, $slug
$api_base = getenv('DJANGO_API_URL');
$fac_campus = isset($dept_data['campus']) ? $dept_data['campus'] : 'BBAU';
$fac_url = $api_base . '/api/v1/faculty/?department__slug=' . urlencode($slug) . '&campus=' . urlencode($fac_campus) . '&page_size=500';
$fac_res = wp_remote_get($fac_url, array('timeout' => 10));
$faculty_list = array();

$media_base = getenv('DJANGO_MEDIA_URL');

if (!is_wp_error($fac_res) && wp_remote_retrieve_response_code($fac_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($fac_res), true);
    $faculty_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
    usort($faculty_list, function($a, $b) {
        return strcasecmp($a['name'] ?? '', $b['name'] ?? '');
    });
}
?>



<div class="section">
    <h3>Department Faculty</h3>
    <?php if(!empty($faculty_list)): ?>
    <div class="faculty-grid">
        <?php foreach($faculty_list as $fac): ?>
        <a href="<?php echo esc_url(home_url('/faculty/' . ($fac['slug'] ?? ''))); ?>"  class="fac-card-premium1">
            <div class="faculty-card">
                <img src="<?php echo $media_base . esc_url($fac['photo'] ); ?>" alt="photo" class="faculty-photo">
                <div class="faculty-info">
                    <h4>
                        <?php echo esc_html($fac['name']); ?>
                        <?php if(($fac['campus'] ?? '') === 'Satellite Campus Amethi'): ?>
                        <small style="color: #9d174d; font-size: 0.8rem; font-weight: 700;">(Amethi)</small>
                        <?php endif; ?>
                    </h4>
                    <p><?php echo esc_html($fac['designation']); ?></p>
                    <?php if(!empty($fac['insti_email'])): ?>
                    <div class="faculty-sub">✉️ <?php echo esc_html($fac['insti_email']); ?></div>
                    <?php endif; ?>
                    <?php if(!empty($fac['other_email'])): ?>
                    <div class="faculty-sub">✉️ <?php echo esc_html($fac['other_email']); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p style="margin-top:20px; color:#555;">No faculty members have been explicitly assigned to this department yet.</p>
    <?php endif; ?>
</div>

<style>
.faculty-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 25px;
    margin-top: 20px;
}

.fac-card-premium1 {
    display: block;
    height: 100%;
    text-decoration: none;
}

.faculty-card {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    transition: 0.3s;
    position: relative;
    text-align: center;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.faculty-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100px;
    background: linear-gradient(135deg, #8B1A1A, #5c1010);
    z-index: 0;
    border-radius: 12px 12px 0 0;
}

.faculty-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(139, 26, 26, 0.12);
}

.faculty-photo {
    width: 160px;
    height: 160px;
    object-fit: inherit;
    border-radius: 50%;
    border: 4px solid white;
    margin: 25px auto 10px;
    position: relative;
    z-index: 1;
    background: #f1f5f9;
}

.faculty-info {
    padding: 10px 15px 20px;
    position: relative;
    z-index: 1;
    flex-grow: 1;
}

.faculty-info h4 {
    margin: 0;
    font-family: 'Merriweather', serif;
    color: #5c1010;
    font-size: 1.15rem;
    font-weight: 700;
}

.faculty-info p {
    margin: 5px 5px 10px;
    font-size: 0.95rem;
    color: #8B1A1A;
    font-weight: 600;
}

.faculty-sub {
    font-size: 0.85rem;
    color: #555;
}
</style>