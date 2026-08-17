<?php
/*
Template Name: Academic Council
*/
defined('ABSPATH') || exit;
get_header();

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');

$members_url = $api_base . '/api/v1/authorities/academic-council-members/';
$minutes_url = $media_base . '/api/v1/authorities/academic-council-minutes/';

$response_members = wp_remote_get($members_url, array('timeout' => 15));

$members = array();
$minutes = array();

if (!is_wp_error($response_members) && wp_remote_retrieve_response_code($response_members) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($response_members), true);
    $members = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
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
            
            <!-- Authority Header Row -->
            <div class="authority-header-row" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2d9cc; margin-bottom: 30px; flex-wrap:wrap; gap:15px;">
                <div class="authority-tabs" style="border-bottom: none; margin-bottom: 0;">
                <button class="auth-tab-btn active" onclick="switchAuthorityTab(event, 'auth-members')">
                    <i class="fa-solid fa-users" style="margin-right: 8px;"></i>Members
                </button>
                <button class="auth-tab-btn" onclick="switchAuthorityTab(event, 'auth-minutes')">
                    <i class="fa-solid fa-file-pdf" style="margin-right: 8px;"></i>Minutes of Meetings
                </button>
            </div>
                <div class="auth-login-controls">
                    <button class="btn-auth-trigger" id="auth-btn-login" style="display:none;"><i class="fa-solid fa-lock"></i> Login</button>
                    <button class="btn-auth-logout" id="auth-btn-logout" style="display:none;"><i class="fa-solid fa-sign-out-alt"></i> Logout <span id="auth-username" style="font-size: 0.8em; margin-left:5px;"></span></button>
                </div>
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
                                    <th class="col-name">Name of Member</th>
                                    <th class="col-phone">Contact</th>
                                    <th class="col-email">Email-Id</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sno = 1;
                                foreach ($members as $member): 
                                ?>
                                <tr>
                                    <td class="col-sno"><strong><?php echo $sno++; ?></strong></td>
                                    <td class="col-name">
                                        <div class="member-title"><?php echo esc_html($member['name']); ?></div>
                                        <?php if (!empty($member['designation'])): ?>
                                            <div class="member-desc"><?php echo format_designation($member['designation']); ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($member['institution'])): ?>
                                            <div class="member-desc" style="font-style: italic;"><?php echo esc_html($member['institution']); ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="col-phone">
                                        <?php echo esc_html(!empty($member['contact']) ? $member['contact'] : '—'); ?>
                                    </td>
                                    <td class="col-email">
                                        <?php if (!empty($member['email'])): ?>
                                            <a href="mailto:<?php echo esc_attr($member['email']); ?>" class="member-link"><?php echo esc_html($member['email']); ?></a>
                                        <?php else: ?>
                                            —
                                        <?php endif; ?>
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
                    <div id="minutes-container">
                        <div style="padding:40px; text-align:center;"><i class="fa-solid fa-spinner fa-spin fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


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


<?php get_template_part('template-parts/portal-auth-modal'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const minutesApiUrl = "<?php echo esc_js($minutes_url); ?>";
    const mediaBase = "<?php echo rtrim(getenv('DJANGO_MEDIA_URL'), '/'); ?>";
    
    const btnLogin = document.getElementById('auth-btn-login');
    const btnLogout = document.getElementById('auth-btn-logout');
    const labelUsername = document.getElementById('auth-username');
    const minutesContainer = document.getElementById('minutes-container');

    function updateAuthButtons() {
        const token = localStorage.getItem('portal_access_token');
        const user = localStorage.getItem('portal_user');
        if (token) {
            btnLogin.style.display = 'none';
            btnLogout.style.display = 'inline-flex';
            labelUsername.textContent = `(${user})`;
        } else {
            btnLogin.style.display = 'inline-flex';
            btnLogout.style.display = 'none';
            labelUsername.textContent = '';
        }
    }

    async function fetchMinutes() {
        const token = localStorage.getItem('portal_access_token');
        const headers = token ? { 'Authorization': `Bearer ${token}` } : {};
        
        minutesContainer.innerHTML = '<div style="padding:40px; text-align:center;"><i class="fa-solid fa-spinner fa-spin fa-2x"></i></div>';
        
        try {
            const res = await fetch(minutesApiUrl, { headers });
            if (!res.ok) throw new Error('Failed to fetch');
            const data_raw = await res.json();
            const data = data_raw.results !== undefined ? data_raw.results : data_raw;
            
            if (data.length === 0) {
                minutesContainer.innerHTML = `
                    <div class="auth-empty-state">
                        <i class="fa-solid fa-folder-open"></i>
                        <p>No meeting minutes available.</p>
                    </div>`;
                return;
            }

            let html = '<div class="minutes-list-modern minute-row">';
            data.forEach(min => {
                let fileUrl = '#';
                if (min.file) {
                    if (min.file.startsWith('http')) {
                        fileUrl = min.file;
                    } else {
                        let path = min.file;
                        if (mediaBase.includes('/media') && path.startsWith('/media/')) {
                            path = path.substring(6);
                        }
                        fileUrl = mediaBase + (path.startsWith('/') ? path : '/' + path);
                    }
                }
                
                const d = new Date(min.date_of_meeting);
                const day = String(d.getDate()).padStart(2, '0');
                const month = d.toLocaleString('en-US', { month: 'short' });
                const title = min.meeting_title || 'Authority Meeting';
                
                const privateBadge = min.is_private ? '<span class="badge" style="background:#8B1A1A; color:#fff; font-size:0.6rem; padding:3px 6px; margin-left:10px; border-radius:4px;"><i class="fa-solid fa-lock"></i> Private</span>' : '';
                const isLoggedIn = !!localStorage.getItem('portal_access_token');
                
                if (min.is_private && !isLoggedIn) {
                    html += `
                    <a href="javascript:void(0);" onclick="toggleModal('login-modal', true)" class="minute-row" style="border-left:4px solid #8B1A1A; background:#fffdf9;">
                        <div class="min-date">
                            <span class="d">${day}</span>
                            <span class="m">${month}</span>
                        </div>
                        <div class="min-info">
                            <strong>${title} ${privateBadge}</strong>
                            <span>Login to view PDF <i class="fa-solid fa-lock"></i></span>
                        </div>
                    </a>`;
                } else if (min.is_private && isLoggedIn && !min.file) {
                    html += `
                    <a href="javascript:void(0);" onclick="alert('Unauthorized: You do not have permission to view these minutes.')" class="minute-row" style="border-left:4px solid #dc3545; background:#fffaf9; opacity: 0.8; cursor: not-allowed;">
                        <div class="min-date" style="background:#dc3545;">
                            <span class="d">${day}</span>
                            <span class="m">${month}</span>
                        </div>
                        <div class="min-info">
                            <strong>${title} ${privateBadge}</strong>
                            <span style="color:#dc3545;">Not Authorized <i class="fa-solid fa-ban"></i></span>
                        </div>
                    </a>`;
                } else {
                    let badgeStyles = min.is_private ? 'border-left:4px solid #8B1A1A; background:#fffdf9;' : '';
                    html += `
                    <a href="${fileUrl}" class="minute-row" target="_blank" style="${badgeStyles}">
                        <div class="min-date">
                            <span class="d">${day}</span>
                            <span class="m">${month}</span>
                        </div>
                        <div class="min-info">
                            <strong>${title} ${privateBadge}</strong>
                            <span>View PDF <i class="fa-solid fa-file-pdf"></i></span>
                        </div>
                    </a>`;
                }
            });
            html += '</div>';
            minutesContainer.innerHTML = html;

        } catch (e) {
            minutesContainer.innerHTML = '<div style="padding:40px; text-align:center; color:red;">Error loading minutes.</div>';
        }
    }

    updateAuthButtons();
    fetchMinutes();

    document.addEventListener('portalAuthStatusChanged', function() {
        updateAuthButtons();
        fetchMinutes();
    });
});
</script>
<style>
    .minutes-list-modern .minute-row{
    width: calc(33% - 12px) !important;
    flex: 0 0 calc(33% - 12px);
}
.minutes-list-modern{
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}
</style>

<?php get_footer(); ?>
