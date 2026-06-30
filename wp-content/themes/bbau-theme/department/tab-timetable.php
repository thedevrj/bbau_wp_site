<?php
// Inherited variables: $api_base, $slug,$media_base
$timetables_url = $api_base . '/api/v1/timetables/?department__slug=' . urlencode($slug);
$timetables_res = wp_remote_get($timetables_url, array('timeout' => 10));
$timetables_list = array();

if (!is_wp_error($timetables_res) && wp_remote_retrieve_response_code($timetables_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($timetables_res), true);
    $timetables_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

$materials_url = $api_base . '/api/v1/study-materials/?department__slug=' . urlencode($slug);
$materials_res = wp_remote_get($materials_url, array('timeout' => 10));
$materials_list = array();

if (!is_wp_error($materials_res) && wp_remote_retrieve_response_code($materials_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($materials_res), true);
    $materials_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<div class="section">
    <h3>Time Tables</h3>
    <?php if(!empty($timetables_list)): ?>
    <div class="timetable-grid">
        <?php foreach($timetables_list as $tt): ?>
        <div class="tt-card">
            <div class="tt-icon"><i class="fa-solid fa-calendar-days"></i></div>
            <div class="tt-info">
                <h4><?php echo esc_html($tt['title']); ?></h4>
                <!-- <p>Uploaded on: <?php echo date('d M Y', strtotime($tt['uploaded_at'])); ?></p> -->
            </div>
            <a href="<?php echo $media_base . esc_url($tt['attachment']); ?>" target="_blank" class="tt-download">View</a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p style="margin-top:20px; color:#555;">No time tables are currently available for download.</p>
    <?php endif; ?>
</div>

<div class="section" style="margin-top:50px;">
    <h3>Study Materials</h3>
    <?php if(!empty($materials_list)): ?>
    <div class="timetable-grid">
        <?php foreach($materials_list as $sm): ?>
        <div class="tt-card material-card">
            <div class="tt-icon"><i class="fa-solid fa-book-open"></i></div>
            <div class="tt-info">
                <h4><?php echo esc_html($sm['title']); ?></h4>
                <!-- <p>Uploaded on: <?php echo date('d M Y', strtotime($sm['uploaded_at'])); ?></p> -->
            </div>
            <a href="<?php echo $media_base . esc_url($sm['attachment']); ?>" target="_blank" class="tt-download">Download</a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p style="margin-top:20px; color:#555;">No study materials have been uploaded for academic reference yet.</p>
    <?php endif; ?>
</div>

<style>
.timetable-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 25px;
}

.tt-card {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #fff;
    padding: 15px 20px;
    border-radius: 12px;
    border: 1px solid #e2d9cc;
    transition: 0.3s;
}

.tt-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
}

.tt-icon {
    font-size: 1.5rem;
    color: #8B1A1A;
}

.tt-info {
    flex-grow: 1;
}

.tt-info h4 {
    margin: 0;
    font-size: 1rem;
    color: #5c1010;
    font-weight: 700;
}

.tt-info p {
    margin: 3px 0 0;
    font-size: 0.75rem;
    color: #888;
}

.tt-download {
    background: #fdfaf6;
    border: 1px solid #c9a84c;
    color: #5c1010  !important;
    padding: 6px 15px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none;
    transition: 0.2s;
}

.tt-download:hover {
    background: #c9a84c;
    color: #fff;
}

.material-card .tt-icon {
    color: #1e40af;
}

.material-card .tt-download {
    border-color: #1e40af;
    color: #1e40af !important;
}

.material-card .tt-download:hover {
    background: #1e40af;
    color: #fff !important;
}
</style>
