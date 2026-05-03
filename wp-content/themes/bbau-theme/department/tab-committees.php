<?php
// Inherited variables: $api_base, $slug
$api_base = getenv('DJANGO_API_URL');
$committees_url = $api_base . '/api/v1/committees/?department__slug=' . urlencode($slug);
$committees_res = wp_remote_get($committees_url, array('timeout' => 10));
$committees_list = array();

if (!is_wp_error($committees_res) && wp_remote_retrieve_response_code($committees_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($committees_res), true);
    $committees_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<div class="section">
    <h3>Department Committees</h3>
    <?php if(!empty($committees_list)): ?>
    <div class="committees-wrap">
        <?php foreach($committees_list as $committee): ?>
        <div class="committee-card">
            <div class="committee-header">
                <h4><?php echo esc_html($committee['name']); ?></h4>
            </div>
            <div class="committee-body">
                <?php if(!empty($committee['description'])): ?>
                <div class="committee-desc"><?php echo wp_kses_post($committee['description']); ?>
                    <?php endif; ?>
                    <?php if(!empty($committee['notification_document'])): ?>
                    <p>Committee Notification:<a class="link-new"
                            href=<?php echo ($committee['notification_document']); ?>> &nbsp; View
                            Notification </a></p>
                        <?php endif; ?>
                </div>

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
    <p style="margin-top:20px; color:#555;">No committee information is available for this department.</p>
    <?php endif; ?>
</div>

<style>
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
    padding: 15px 40px;
    color: #fff;
}

.committee-header h4 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
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
    font-weight: 800;
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