<?php
// Inherited variables: $api_base, $slug, $media_base
$api_base = getenv('DJANGO_API_URL');
$committees_url = $api_base . '/api/v1/dept-committees/?centre_slug=' . urlencode($slug);
$minutes_url = $api_base . '/api/v1/dept-minutes/?centre_slug=' . urlencode($slug);
$committees_res = wp_remote_get($committees_url, array('timeout' => 10));
$minutes_res = wp_remote_get($minutes_url, array('timeout' => 10));
$committees_list = array();
$minutes_list = array();

if (!is_wp_error($committees_res) && wp_remote_retrieve_response_code($committees_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($committees_res), true);
    $committees_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
if (!is_wp_error($minutes_res) && wp_remote_retrieve_response_code($minutes_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($minutes_res), true);
    $minutes_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<div class="section">
    <div class="row">
        <div class="col-lg-6 mb-3">
            <h3>Centre Committees</h3>
            <?php if(!empty($committees_list)): ?>
            <div class="committees-wrap">
                <?php foreach($committees_list as $committee): ?>
                <div class="committee-card">
                    <div class="committee-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <h4 class="mb-0"><?php echo esc_html($committee['name']); ?></h4>

                        <?php if(!empty($committee['notification_document'])): ?>
                        <a class="btn-committee-doc" target="_blank"
                                href="<?php echo esc_url($media_base . $committee['notification_document']); ?>">
                                <i class="fa-solid fa-file-pdf"></i> View Notification
                        </a>
                        <?php endif; ?>

                    </div>
                    <div class="committee-body">
                        <?php if(!empty($committee['description'])): ?>
                        <div class="committee-desc"><?php echo wp_kses_post($committee['description']); ?>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($committee['members'])): ?>
                        <table class="members-table">
                            <thead>
                                <tr>
                                    <th>Member Name</th>
                                    <th>Role in Committee</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($committee['members'] as $member): ?>
                                <tr>
                                    <td><strong><?php echo esc_html($member['name_of_member']); ?></strong></td>
                                    <td>
                                        <span class="role-badge">
                                            <?php echo esc_html($member['designation_in_committee'] === 'Others' ? $member['other_designation'] : $member['designation_in_committee']); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p style="margin-top:20px; color:#555;">No committee information is available for this centre.</p>
            <?php endif; ?>
        </div>
        <div class="col-lg-6 mb-3">
            <h3>Minutes of Meetings</h3>
            <?php if(!empty($minutes_list)): ?>
            <div class="section-card">
                <div class="minutes-list-modern">
                    <?php foreach ($minutes_list as $min) : ?>
                    <a href="<?php echo esc_url( $min['date_of_meeting']); ?>" class="minute-row" target="_blank">
                        <div class="min-date">
                            <span class="d"><?php echo date('d', strtotime($min['date_of_meeting'])); ?></span>
                            <span class="m"><?php echo date('M', strtotime($min['date_of_meeting'])); ?></span>
                        </div>
                        <div class="min-info">
                            <strong><?php echo esc_html(!empty($min['meeting_title']) ? $min['meeting_title'] : 'Board Meeting'); ?></strong>
                            <span>Download PDF <i class="fa-solid fa-file-pdf"></i></span>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>
<style>
.section-card {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    margin-top: 20px;
}


.minute-row {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 15px;
    background: #fdfbf7;
    border-radius: 12px;
    margin-bottom: 12px;
    text-decoration: none !important;
    transition: 0.2s;
}

.minute-row:hover {
    background: #fff;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transform: scale(1.01);
}

.min-date {
    background: #8B1A1A;
    color: #fff;
    width: 60px;
    height: 60px;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.min-date .d {
    font-weight: 800;
    font-size: 20px;
    line-height: 1;
}

.min-date .m {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

.min-info strong {
    display: block;
    color: #5c1010;
    font-size: 16px;
}

.min-info span {
    font-size: 13px;
    color: #8B1A1A;
    font-weight: 600;
}

.committees-wrap {
    display: flex;
    flex-direction: column;
    gap: 30px;
    margin-top: 20px;
}

.committee-card {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
}

.committee-header {
    background: linear-gradient(135deg, #5c1010, #8B1A1A);
    padding: 20px 25px;
    color: #fff;
}

.committee-header h4 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
}

.btn-committee-doc {
    background: rgba(255, 255, 255, 0.15);
    color: #fff !important;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-committee-doc:hover {
    background: #fff;
    color: #8B1A1A !important;
}

.committee-body {
    padding: 25px;
}

.committee-desc {
    color: #555;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 20px;
    border-bottom: 2px solid #f3f4f6;
}

.members-table {
    width: 100%;
    border-collapse: collapse;
}

.members-table th {
    text-align: left;
    padding: 12px;
    background: #fdfaf6;
    font-size: 0.85rem;
    text-transform: uppercase;
    color: #8B1A1A;
    font-weight: 700;
}

.members-table td {
    padding: 12px;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.95rem;
    color: #333;
}

.role-badge {
    display: inline-block;
    padding: 4px 12px;
    background: #f1f5f9;
    color: #475569;
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 20px;
    text-transform: uppercase;
}
</style>