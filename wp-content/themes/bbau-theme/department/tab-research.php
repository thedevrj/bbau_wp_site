<?php
// Inherited variables: $api_base, $slug
$projects_url = $api_base . '/api/v1/research-projects/?department__slug=' . urlencode($slug);
$projects_res = wp_remote_get($projects_url, array('timeout' => 10));
$projects_list = array();

if (!is_wp_error($projects_res) && wp_remote_retrieve_response_code($projects_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($projects_res), true);
    $projects_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

$scholars_url = $api_base . '/api/v1/research-scholars/?department__slug=' . urlencode($slug);
$scholars_res = wp_remote_get($scholars_url, array('timeout' => 10));
$scholars_list = array();

if (!is_wp_error($scholars_res) && wp_remote_retrieve_response_code($scholars_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($scholars_res), true);
    $scholars_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<div class="section">
    <h3>Funded Research Projects</h3>
    <?php if(!empty($projects_list)): ?>
    <div class="prog-table-wrap">
        <table class="prog-table">
            <thead>
                <tr>
                    <th style="width: 40%">Project Title</th>
                    <th style="width: 25%">Investigator(s)</th>
                    <th style="width: 20%">Agency & Funding</th>
                    <th style="width: 15%">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($projects_list as $project): ?>
                <tr>
                    <td style="font-weight:700; color:#5c1010;"><?php echo esc_html($project['title']); ?></td>
                    <td>
                        <strong>PI:</strong> <?php echo esc_html($project['pi_name'] ?? 'N/A'); ?><br>
                        <?php if(!empty($project['co_investigators_names'])): ?>
                        <small style="color:#666;">Co-PI: <?php echo esc_html(implode(', ', $project['co_investigators_names'])); ?></small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <strong><?php echo esc_html($project['funding_agency'] ?? '-'); ?></strong><br>
                        <?php if(!empty($project['amount_sanctioned'])): ?>
                        <span style="color:#8B1A1A; font-weight:600;">₹<?php echo number_format((float)$project['amount_sanctioned'], 2); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php 
                        $status = $project['status'] ?? 'Ongoing';
                        $status_style = ($status === 'Completed') ? 'background:#dcfce7; color:#166534;' : 'background:#dbeafe; color:#1e40af;';
                        ?>
                        <span style="display:inline-block; padding:4px 10px; border-radius:12px; font-size:0.75rem; font-weight:700; <?php echo $status_style; ?>">
                            <?php echo esc_html($status); ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <p style="margin-top:20px; color:#555;">No research projects are currently documented for this department.</p>
    <?php endif; ?>
</div>

<div class="section" style="margin-top:50px;">
    <h3>PhD Scholars</h3>
    <?php if(!empty($scholars_list)): ?>
    <div class="prog-table-wrap">
        <table class="prog-table">
            <thead>
                <tr>
                    <th style="width: 20%">Scholar Name</th>
                    <th style="width: 40%">Research Topic</th>
                    <th style="width: 30%">Supervisor(s)</th>
                    <th style="width: 10%">Reg. Year</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($scholars_list as $scholar): ?>
                <tr>
                    <td style="font-weight:700; color:#5c1010;"><?php echo esc_html($scholar['scholar_name']); ?></td>
                    <td style="font-style:italic; font-size:0.9rem;">"<?php echo esc_html($scholar['research_topic']); ?>"</td>
                    <td>
                        <strong>Sup:</strong> <?php echo esc_html($scholar['supervisor_name'] ?? 'N/A'); ?><br>
                        <?php if(!empty($scholar['co_supervisor_name'])): ?>
                        <small style="color:#666;">Co-Sup: <?php echo esc_html($scholar['co_supervisor_name']); ?></small>
                        <?php endif; ?>
                    </td>
                    <td><?php echo esc_html($scholar['registration_year'] ?? '-'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <p style="margin-top:20px; color:#555;">No PhD scholars are currently registered under this department.</p>
    <?php endif; ?>
</div>

<style>
/* Re-using styles from tab-programs.php for consistency, plus some minor tweaks */
.prog-table-wrap {
    overflow-x: auto;
    margin-top: 20px;
}

.prog-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    min-width: 600px;
}

.prog-table th {
    background: linear-gradient(160deg, #5c1010, #8B1A1A);
    color: white;
    padding: 15px;
    text-align: left;
    font-family: 'Inter', sans-serif;
}

.prog-table td {
    padding: 15px;
    border-bottom: 1px solid #e2d9cc;
    color: #444;
    vertical-align: top;
}

.prog-table tr:hover {
    background: #fdfaf6;
}
</style>
