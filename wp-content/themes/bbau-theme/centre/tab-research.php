<?php
// Inherited variables: $api_base, $slug
// Fetch Department Projects
$centre_campus = isset($centre_data['campus']) ? $centre_data['campus'] : 'BBAU';

$projects_url = $api_base . '/api/v1/research-projects/?centre_slug=' . urlencode($slug) . '&campus=' . urlencode($centre_campus) . '&page_size=25';
$projects_res = wp_remote_get($projects_url, array('timeout' => 10));
$projects_list = array();

if (!is_wp_error($projects_res) && wp_remote_retrieve_response_code($projects_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($projects_res), true);
    $projects_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

// Fetch Research Scholars
$scholars_url = $api_base . '/api/v1/research-scholars/?centre_slug=' . urlencode($slug) . '&campus=' . urlencode($centre_campus) . '&page_size=25';
$scholars_res = wp_remote_get($scholars_url, array('timeout' => 10));
$scholars_list = array();

if (!is_wp_error($scholars_res) && wp_remote_retrieve_response_code($scholars_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($scholars_res), true);
    $scholars_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

// Fetch Department Publications
$pubs_url = $api_base . '/api/v1/publications/?centre_slug=' . urlencode($slug) . '&campus=' . urlencode($centre_campus) . '&page_size=25';
$pubs_res = wp_remote_get($pubs_url, array('timeout' => 10));
$pubs_list = array();
if (!is_wp_error($pubs_res) && wp_remote_retrieve_response_code($pubs_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($pubs_res), true);
    $pubs_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

// Fetch Department Patents
$patents_url = $api_base . '/api/v1/patents/?centre_slug=' . urlencode($slug) . '&campus=' . urlencode($centre_campus) . '&page_size=25';
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
        <div class="<?php echo (count($projects_list) > 5) ? 'scrollable-list table-scroll' : ''; ?>">
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
                            <td class="proj-title-cell" data-label="Project Title"><?php echo esc_html($project['title']); ?></td>
                            <td data-label="Investigator(s)">
                                <strong>PI:</strong> <?php echo esc_html($project['pi_name'] ?? 'N/A'); ?><br>
                                <?php if(!empty($project['co_investigators_names'])): ?>
                                <small class="co-pi-text">Co-PI:
                                    <?php echo esc_html(implode(', ', $project['co_investigators_names'])); ?></small>
                                <?php endif; ?>
                            </td>
                            <td data-label="Agency & Funding">
                                <div class="agency-text"><?php echo esc_html($project['funding_agency'] ?? '-'); ?></div>
                                <?php if(!empty($project['amount_sanctioned'])): ?>
                                <div class="amount-text">₹<?php echo number_format((float)$project['amount_sanctioned']); ?>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td data-label="Status">
                                <span class="status-badge <?php echo strtolower($project['status'] ?? 'ongoing'); ?>">
                                    <?php echo esc_html($project['status'] ?? 'Ongoing'); ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if(count($projects_list) > 5): ?>
        <a href="/research-projects/?department=<?php echo $slug; ?>" class="view-more">View All Projects</a>
        <?php endif; ?>
        <?php else: ?>
        <p class="empty-msg">No research projects are currently documented for this centre.</p>
        <?php endif; ?>
    </div>

    <!-- SCHOLARS SECTION -->
    <div class="section" style="margin-top:50px;">
        <h3 class="tab-sec-title">PhD Scholars</h3>
        <?php if(!empty($scholars_list)): ?>
        <div class="<?php echo (count($scholars_list) > 5) ? 'scrollable-list table-scroll' : ''; ?>">
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
                            <td class="scholar-name-cell" data-label="Scholar Name"><?php echo esc_html($scholar['scholar_name']); ?></td>
                            <td class="topic-cell" data-label="Research Topic">"<?php echo esc_html($scholar['research_topic']); ?>"</td>
                            <td data-label="Supervisor(s)">
                                <strong>Sup:</strong> <?php echo esc_html($scholar['supervisor']['name'] ?? 'N/A'); ?><br>
                                <?php if(!empty($scholar['co_supervisor'])): ?>
                                <?php foreach($scholar['co_supervisor'] as $co_sup) {
                                        echo '<small class="co-sup-text">Co-Sup: ' . esc_html($co_sup['name']) . '</small><br>';
                                    }?>
                                <?php endif; ?>
                            </td>
                            <td data-label="Reg. Year"><?php echo esc_html($scholar['registration_year'] ?? '-'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if(count($scholars_list) > 5): ?>
        <a href="/doctoral-research/?department=<?php echo $slug; ?>" class="view-more">View All PhD Scholars</a>
        <?php endif; ?>
        <?php else: ?>
        <p class="empty-msg">No PhD scholars are currently registered under this centre.</p>
        <?php endif; ?>
    </div>

    <!-- PUBLICATIONS & PATENTS ROW -->
    <div class="research-row">

        <!-- PUBLICATIONS -->
        <div class="section">
            <h3 class="tab-sec-title">Recent Publications</h3>
            <?php if(!empty($pubs_list)): ?>
            <div class="<?php echo (count($pubs_list) > 5) ? 'scrollable-list' : ''; ?>">
                <ul class="mini-pub-list">
                    <?php foreach($pubs_list as $pub): ?>
                    <li>
                        <div class="pub-type-mini"><?php echo esc_html($pub['publication_type']); ?></div>
                        <strong><?php echo esc_html($pub['title']); ?></strong>
                        <div class="pub-meta-mini"><?php echo esc_html($pub['faculty_name']); ?> |
                            <?php echo esc_html($pub['publication_date']); ?></div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
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
            <div class="<?php echo (count($patents_list) > 5) ? 'scrollable-list' : ''; ?>">
                <ul class="mini-patent-list">
                    <?php foreach($patents_list as $pat): ?>
                    <li>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px; gap: 10px;">
                            <strong style="color: #1e3a8a; line-height: 1.4; font-size: 0.95rem;"><?php echo esc_html($pat['title']); ?></strong>
                            <span class="status-badge <?php echo strtolower($pat['status']); ?>" style="white-space: nowrap;">
                                <?php echo esc_html($pat['status']); ?>
                            </span>
                        </div>
                        <div class="pat-meta-mini">
                            <?php if(!empty($pat['patent_number'])): ?>
                                <strong style="color: #475569;">No:</strong> <?php echo esc_html($pat['patent_number']); ?> |
                            <?php endif; ?>
                            <?php echo esc_html($pat['faculty_name']); ?>
                            (<?php echo esc_html($pat['date_of_filing']); ?>)
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php if(count($patents_list) > 5): ?>
            <a href="/patents?department=<?php echo $slug; ?>" class="view-more">View All Patents</a>
            <?php endif; ?>
            <?php else: ?>
            <p class="empty-msg">No patents recorded for this centre.</p>
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

.research-row {
    margin-top: 50px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.prog-table-wrap {
    overflow-x: auto;
    max-width: 100%;
    -webkit-overflow-scrolling: touch;
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
    font-weight: 700;
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

/* Scrollable List container for > 5 items */
.scrollable-list {
    max-height: 380px;
    overflow-y: auto;
    padding-right: 10px;
}

.scrollable-list.table-scroll {
    max-height: 280px;
}

.scrollable-list::-webkit-scrollbar {
    width: 6px;
}

.scrollable-list::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.scrollable-list::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.scrollable-list::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
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
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
}

.pub-meta-mini,
.pat-meta-mini {
    font-size: 0.8rem;
    color: #64748b;
    margin-top: 4px;
}

.status-badge.granted {
    background: #dcfce7;
    color: #15803d;
}

.status-badge.published {
    background: #fef3c7;
    color: #b45309;
}

.status-badge.filed {
    background: #fee2e2;
    color: #b91c1c;
}

.view-more {
    display: inline-block;
    margin-top: 15px;
    font-size: 0.85rem;
    font-weight: 700;
    color: #5c1010 !important;
    text-decoration: none;
}

/* Adding spacing between table rows in desktop view */
/* Adding spacing between table rows */
.prog-table {
    border-collapse: separate !important;
    border-spacing: 0 12px !important;
    background: transparent !important;
    box-shadow: none !important;
}

.prog-table thead tr {
    background: transparent !important;
}

.prog-table th {
    background: linear-gradient(160deg, #5c1010, #8B1A1A) !important;
    color: white !important;
    border: none !important;
    padding: 15px !important;
    position: sticky;
    top: 0;
    z-index: 10;
}

.prog-table th:first-child {
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
}

.prog-table th:last-child {
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
}

.prog-table tbody tr {
    background: #ffffff !important;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03) !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.prog-table tbody tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.06) !important;
}

.prog-table td {
    border: none !important;
    padding: 15px 20px !important;
    vertical-align: middle !important;
}

.prog-table tbody tr td:first-child {
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
}

.prog-table tbody tr td:last-child {
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
}

@media (max-width: 1024px) {
    .research-row {
        grid-template-columns: 1fr;
    }
}
</style>