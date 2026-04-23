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

// Fetch Department Publications
$pubs_url = $api_base . '/api/v1/publications/?department__slug=' . urlencode($slug);
$pubs_res = wp_remote_get($pubs_url, array('timeout' => 10));
$pubs_list = array();
if (!is_wp_error($pubs_res) && wp_remote_retrieve_response_code($pubs_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($pubs_res), true);
    $pubs_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

// Fetch Department Patents
$patents_url = $api_base . '/api/v1/patents/?department__slug=' . urlencode($slug);
$patents_res = wp_remote_get($patents_url, array('timeout' => 10));
$patents_list = array();
if (!is_wp_error($patents_res) && wp_remote_retrieve_response_code($patents_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($patents_res), true);
    $patents_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<div class="research-tab-content">

    <!-- PROJECTS SECTION -->
    <div class="section">
        <h3 class="tab-sec-title">Funded Research Projects</h3>
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
                        <td class="proj-title-cell"><?php echo esc_html($project['title']); ?></td>
                        <td>
                            <strong>PI:</strong> <?php echo esc_html($project['pi_name'] ?? 'N/A'); ?><br>
                            <?php if(!empty($project['co_investigators_names'])): ?>
                            <small class="co-pi-text">Co-PI:
                                <?php echo esc_html(implode(', ', $project['co_investigators_names'])); ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="agency-text"><?php echo esc_html($project['funding_agency'] ?? '-'); ?></div>
                            <?php if(!empty($project['amount_sanctioned'])): ?>
                            <div class="amount-text">₹<?php echo number_format((float)$project['amount_sanctioned']); ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="status-badge <?php echo strtolower($project['status'] ?? 'ongoing'); ?>">
                                <?php echo esc_html($project['status'] ?? 'Ongoing'); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="empty-msg">No research projects are currently documented for this department.</p>
        <?php endif; ?>
    </div>

    <!-- SCHOLARS SECTION -->
    <div class="section" style="margin-top:50px;">
        <h3 class="tab-sec-title">PhD Scholars</h3>
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
                        <td class="scholar-name-cell"><?php echo esc_html($scholar['scholar_name']); ?></td>
                        <td class="topic-cell">"<?php echo esc_html($scholar['research_topic']); ?>"</td>
                        <td>
                            <strong>Sup:</strong> <?php echo esc_html($scholar['supervisor_name'] ?? 'N/A'); ?><br>
                            <?php if(!empty($scholar['co_supervisor_name'])): ?>
                            <small class="co-sup-text">Co-Sup:
                                <?php echo esc_html($scholar['co_supervisor_name']); ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?php echo esc_html($scholar['registration_year'] ?? '-'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="empty-msg">No PhD scholars are currently registered under this department.</p>
        <?php endif; ?>
    </div>

    <!-- PUBLICATIONS & PATENTS ROW -->
    <div class="research-row" style="margin-top:50px; display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">

        <!-- PUBLICATIONS -->
        <div class="section">
            <h3 class="tab-sec-title">Recent Publications</h3>
            <?php if(!empty($pubs_list)): ?>
            <ul class="mini-pub-list">
                <?php foreach(array_slice($pubs_list, 0, 5) as $pub): ?>
                <li>
                    <div class="pub-type-mini"><?php echo esc_html($pub['publication_type']); ?></div>
                    <strong><?php echo esc_html($pub['title']); ?></strong>
                    <div class="pub-meta-mini"><?php echo esc_html($pub['faculty_name']); ?> |
                        <?php echo esc_html($pub['publication_date']); ?></div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php if(count($pubs_list) > 5): ?>
            <a href="/publications?department=<?php echo $slug; ?>" class="view-more">View All Publications</a>
            <?php endif; ?>
            <?php else: ?>
            <p class="empty-msg">No recent publications recorded.</p>
            <?php endif; ?>
        </div>

        <!-- PATENTS -->
        <div class="section">
            <h3 class="tab-sec-title">Patents</h3>
            <?php if(!empty($patents_list)): ?>
            <ul class="mini-patent-list">
                <?php foreach($patents_list as $pat): ?>
                <li>
                    <span class="status-dot <?php echo strtolower($pat['status']); ?>"></span>
                    <strong><?php echo esc_html($pat['title']); ?></strong>
                    <div class="pat-meta-mini"><?php echo esc_html($pat['faculty_name']); ?>
                        (<?php echo esc_html($pat['year']); ?>)</div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p class="empty-msg">No patents recorded for this department.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.tab-sec-title {
    font-size: 1.5rem;
    color: #1e3a8a;
    font-weight: 700;
    margin-bottom: 20px;
    border-bottom: 2px solid #f1f5f9;
    padding-bottom: 10px;
}

.empty-msg {
    color: #64748b;
    font-style: italic;
}

.proj-title-cell,
.scholar-name-cell {
    font-weight: 700;
    color: #1e3a8a;
}

.topic-cell {
    font-style: italic;
    font-size: 0.9rem;
    color: #475569;
}

.co-pi-text,
.co-sup-text {
    color: #64748b;
    font-size: 0.8rem;
}

.agency-text {
    font-weight: 600;
}

.amount-text {
    color: #b91c1c;
    font-weight: 700;
    font-size: 0.9rem;
}

.status-badge {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
}

.status-badge.ongoing {
    background: #dbeafe;
    color: #1e40af;
}

.status-badge.completed {
    background: #dcfce7;
    color: #15803d;
}

/* Mini Lists */
.mini-pub-list,
.mini-patent-list {
    list-style: none;
    padding: 0;
}

.mini-pub-list li,
.mini-patent-list li {
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
}

.pub-type-mini {
    font-size: 0.65rem;
    font-weight: 800;
    color: #94a3b8;
    text-transform: uppercase;
}

.pub-meta-mini,
.pat-meta-mini {
    font-size: 0.8rem;
    color: #64748b;
    margin-top: 4px;
}

.status-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 8px;
}

.status-dot.granted {
    background: #10b981;
}

.status-dot.published {
    background: #f59e0b;
}

.status-dot.filed {
    background: #ef4444;
}

.view-more {
    display: inline-block;
    margin-top: 15px;
    font-size: 0.85rem;
    font-weight: 700;
    color: #3b82f6;
    text-decoration: none;
}

@media (max-width: 768px) {
    .research-row {
        grid-template-columns: 1fr;
    }
}
</style>