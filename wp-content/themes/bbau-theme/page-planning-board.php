<?php
/*
Template Name: Planning Board
*/
defined('ABSPATH') || exit;
get_header();

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
$api_url    = $api_base . '/api/v1/authorities/PLANNING_BOARD/';

$response = wp_remote_get($api_url, array('timeout' => 15));
$members = array();
$minutes = array();
$authority_title = "Planning Board";

if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
    $data = json_decode(wp_remote_retrieve_body($response), true);
    $members = isset($data['members']) ? $data['members'] : array();
    $minutes = isset($data['minutes']) ? $data['minutes'] : array();
}

function parse_phones($phone_fax) {
    if (empty($phone_fax)) {
        return array();
    }
    $parsed = array();
    $parts = explode(',', $phone_fax);
    foreach ($parts as $part) {
        $part = trim($part);
        if (empty($part)) {
            continue;
        }
        if (strpos($part, '(') !== false && strpos($part, ')') !== false) {
            $num_parts = explode('(', $part, 2);
            $number = trim($num_parts[0]);
            $label_parts = explode(')', $num_parts[1], 2);
            $label = '(' . trim($label_parts[0]) . ')';
            $parsed[] = array('number' => $number, 'label' => $label);
        } else {
            $parsed[] = array('number' => $part, 'label' => '');
        }
    }
    return $parsed;
}

function format_designation($designation) {
    if (empty($designation)) {
        return '';
    }
    $designation = str_replace('  ', '<br>', esc_html($designation));
    $designation = nl2br($designation);
    return $designation;
}
?>

<?php get_template_part('banners/about-banner');?>

<main id="primary" class="site-main authority-page" style="background:#fdfaf6; padding-bottom:60px;">
    <div class="container pt-4">
        <?php get_template_part('template-parts/breadcrumb');?>

        <!-- Custom Card Container -->
        <div class="authority-card">
            <!-- Tabs Menu -->
            <div class="authority-tabs">
                <button class="auth-tab-btn active" onclick="switchAuthorityTab(event, 'auth-members')">
                    <i class="fa-solid fa-users" style="margin-right: 8px;"></i>Members
                </button>
                <button class="auth-tab-btn" onclick="switchAuthorityTab(event, 'auth-minutes')">
                    <i class="fa-solid fa-file-pdf" style="margin-right: 8px;"></i>Minutes of Meetings
                </button>
            </div>

            <!-- Card Body Content -->
            <div class="authority-card-body">
                
                <!-- Members List Tab Panel -->
                <div id="auth-members" class="auth-tab-panel active">
                    <?php if (!empty($members)): ?>
                    <div class="table-responsive">
                        <table class="authority-table">
                            <thead>
                                <tr>
                                    <th class="col-sno">S.No.</th>
                                    <th class="col-provision">Provision</th>
                                    <th class="col-name">Name of Member</th>
                                    <th class="col-email">Email-Id</th>
                                    <th class="col-phone">Phone/Fax</th>
                                    <th class="col-date">Date of Nomination</th>
                                    <th class="col-date">Date of Expiry</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sno = 1;
                                foreach ($members as $member): 
                                ?>
                                <tr>
                                    <td class="col-sno"><strong><?php echo $sno++; ?></strong></td>
                                    <td class="col-provision"><?php echo esc_html(!empty($member['provision']) ? $member['provision'] : '—'); ?></td>
                                    <td class="col-name">
                                        <div class="member-title"><?php echo esc_html($member['name']); ?></div>
                                        <?php if (!empty($member['designation'])): ?>
                                            <div class="member-desc"><?php echo format_designation($member['designation']); ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="col-email">
                                        <?php if (!empty($member['email'])): ?>
                                            <a href="mailto:<?php echo esc_attr($member['email']); ?>" class="member-link"><?php echo esc_html($member['email']); ?></a>
                                        <?php else: ?>
                                            —
                                        <?php endif; ?>
                                    </td>
                                    <td class="col-phone">
                                        <?php 
                                        $phones = parse_phones($member['phone_fax']);
                                        if (!empty($phones)):
                                            foreach ($phones as $phone):
                                        ?>
                                            <span class="phone-number"><?php echo esc_html($phone['number']); ?></span><br>
                                            <?php if (!empty($phone['label'])): ?>
                                                <span class="phone-lbl"><?php echo esc_html($phone['label']); ?></span><br>
                                            <?php endif; ?>
                                        <?php 
                                            endforeach;
                                        else:
                                            echo '—';
                                        endif; 
                                        ?>
                                    </td>
                                    <td class="col-date">
                                        <?php echo esc_html(!empty($member['date_of_nomination']) ? date('d.m.Y', strtotime($member['date_of_nomination'])) : '—'); ?>
                                    </td>
                                    <td class="col-date">
                                        <?php echo esc_html(!empty($member['date_of_expiry']) ? date('d.m.Y', strtotime($member['date_of_expiry'])) : '—'); ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                        <div class="auth-empty-state">
                            <i class="fa-solid fa-users-slash"></i>
                            <p>No members listed for this authority yet.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Minutes List Tab Panel -->
                <div id="auth-minutes" class="auth-tab-panel">
                    <?php if (!empty($minutes)): ?>
                    <div class="minutes-list-modern">
                        <?php foreach ($minutes as $min) : 
                            $file_url = !empty($min['file']) ? $media_base . $min['file'] : '#';
                            if (strpos($min['file'], 'http') === 0) {
                                $file_url = $min['file'];
                            }
                        ?>
                        <a href="<?php echo esc_url($file_url); ?>" class="minute-row" target="_blank">
                            <div class="min-date">
                                <span class="d"><?php echo date('d', strtotime($min['date_of_meeting'])); ?></span>
                                <span class="m"><?php echo date('M', strtotime($min['date_of_meeting'])); ?></span>
                            </div>
                            <div class="min-info">
                                <strong><?php echo esc_html(!empty($min['meeting_title']) ? $min['meeting_title'] : 'Authority Meeting'); ?></strong>
                                <span>Download PDF <i class="fa-solid fa-file-pdf"></i></span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                        <div class="auth-empty-state">
                            <i class="fa-solid fa-folder-open"></i>
                            <p>No meeting minutes uploaded for this authority yet.</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</main>

<style>
/* --- Premium Custom Styling for Authorities --- */
.authority-card {
    background: #ffffff;
    border: 1px solid #e2d9cc;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    margin-top: 25px;
    overflow: hidden;
}

.authority-tabs {
    display: flex;
    background: #fdfbf7;
    border-bottom: 1px solid #e2d9cc;
}

.auth-tab-btn {
    background: transparent;
    border: none;
    outline: none;
    font-size: 15px;
    font-weight: 700;
    color: #64748b;
    padding: 16px 28px;
    cursor: pointer;
    transition: all 0.2s ease;
    border-right: 1px solid #e2d9cc;
    display: flex;
    align-items: center;
}

.auth-tab-btn:hover {
    color: #8B1A1A;
    background: #fff8f0;
}

.auth-tab-btn.active {
    color: #fff;
    background: #8B1A1A;
    border-bottom: 1px solid #8B1A1A;
}

.authority-card-body {
    padding: 30px;
}

.auth-tab-panel {
    display: none;
}

.auth-tab-panel.active {
    display: block;
    animation: authFadeIn 0.3s ease-in-out;
}

@keyframes authFadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}

/* --- Table Styling --- */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    border-radius: 12px;
    border: 1px solid #e2d9cc;
}

.authority-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
    text-align: left;
}

.authority-table th {
    background: #fdfaf6;
    color: #8B1A1A;
    font-weight: 700;
    padding: 16px 20px;
    border-bottom: 2px solid #e2d9cc;
    white-space: nowrap;
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 0.5px;
}

.authority-table td {
    padding: 16px 20px;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: top;
    color: #374151;
    line-height: 1.5;
}

.authority-table tbody tr:nth-child(even) {
    background-color: #fcfbf9;
}

.authority-table tbody tr:hover {
    background-color: #f7f3ed;
    transition: background-color 0.2s ease;
}

.col-sno {
    width: 60px;
    font-weight: 700;
    color: #1e293b;
}

.col-provision {
    width: 100px;
    font-weight: 500;
    color: #475569;
}

.col-name {
    min-width: 250px;
}

.member-title {
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
}

.member-desc {
    font-size: 13px;
    color: #64748b;
    margin-top: 4px;
    font-weight: 500;
}

.member-link {
    color: #8B1A1A;
    text-decoration: none;
    font-weight: 600;
}

.member-link:hover {
    text-decoration: underline;
}

.phone-number {
    font-weight: 600;
    color: #1e293b;
    white-space: nowrap;
}

.phone-lbl {
    font-size: 11px;
    color: #64748b;
    font-weight: 700;
}

.col-date {
    width: 130px;
    white-space: nowrap;
    font-weight: 500;
}

/* --- Empty State --- */
.auth-empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #64748b;
}

.auth-empty-state i {
    font-size: 50px;
    color: #cbd5e1;
    margin-bottom: 15px;
    display: block;
}

.auth-empty-state p {
    font-size: 16px;
    font-weight: 600;
}

/* --- Minutes Styling --- */
.minutes-list-modern {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.minute-row {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 16px 20px;
    background: #fdfbf7;
    border: 1px solid #e2d9cc;
    border-radius: 12px;
    text-decoration: none !important;
    transition: all 0.2s ease;
}

.minute-row:hover {
    background: #ffffff;
    box-shadow: 0 8px 25px rgba(139, 26, 26, 0.06);
    border-color: #8B1A1A;
    transform: translateY(-2px);
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
    flex-shrink: 0;
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

.min-info {
    flex-grow: 1;
}

.min-info strong {
    display: block;
    color: #5c1010;
    font-size: 16px;
    margin-bottom: 2px;
}

.min-info span {
    font-size: 13px;
    color: #8B1A1A;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
</style>

<script>
function switchAuthorityTab(evt, panelId) {
    // Hide all tab panels
    var panels = document.getElementsByClassName("auth-tab-panel");
    for (var i = 0; i < panels.length; i++) {
        panels[i].classList.remove("active");
    }

    // Deactivate all tab buttons
    var tablinks = document.getElementsByClassName("auth-tab-btn");
    for (var i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }

    // Show active panel and set button active
    document.getElementById(panelId).classList.add("active");
    evt.currentTarget.classList.add("active");
}
</script>

<?php get_footer(); ?>
