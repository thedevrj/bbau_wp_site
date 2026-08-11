<?php
/**
 * Template Name: Proctorial Board Members & Minutes Page
 */
defined('ABSPATH') || exit;

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');

$BBAU_PB_MEMBERS_API = $media_base . '/api/v1/proctor/proctorial-board-members/';
$BBAU_PB_MINUTES_API = $media_base . '/api/v1/proctor/proctorial-board-minutes/';

$response_members  = wp_remote_get($BBAU_PB_MEMBERS_API, array('timeout' => 15));
$response_minutes  = wp_remote_get($BBAU_PB_MINUTES_API, array('timeout' => 15));

$members        = array();
$minutes        = array();
$members_error  = '';
$minutes_error  = '';

if (is_wp_error($response_members)) {
    $members_error = $response_members->get_error_message();
} elseif (wp_remote_retrieve_response_code($response_members) !== 200) {
    $members_error = 'API Error : HTTP ' . wp_remote_retrieve_response_code($response_members);
} else {
    $decoded = json_decode(wp_remote_retrieve_body($response_members), true);
    $members = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

if (is_wp_error($response_minutes)) {
    $minutes_error = $response_minutes->get_error_message();
} elseif (wp_remote_retrieve_response_code($response_minutes) !== 200) {
    $minutes_error = 'API Error : HTTP ' . wp_remote_retrieve_response_code($response_minutes);
} else {
    $decoded = json_decode(wp_remote_retrieve_body($response_minutes), true);
    $minutes = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid page-bg py-5">

    <div class="container">

        <?php get_template_part('template-parts/breadcrumb'); ?>

        <h2 class="pb-page-title">
            Proctorial Board
        </h2>

        <div class="row">

            <div class="col-lg-6 mb-4">

                <h3 class="pb-col-title">Members</h3>

                <?php if ($members_error): ?>

                    <div class="alert alert-danger"><?php echo esc_html($members_error); ?></div>

                <?php elseif (empty($members)): ?>

                    <div class="alert alert-warning">No members found.</div>

                <?php else: ?>

                    <div class="committees-wrap" id="pbCommitteesAccordion">

                        <div class="committee-card">

                            <div class="committee-header" data-bs-toggle="collapse"
                                 data-bs-target="#pbMembersPanel"
                                 data-bs-parent="#pbCommitteesAccordion"
                                 aria-expanded="true" role="button">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4>Proctorial Board</h4>
                                    <span class="toggle-icon">&#9660;</span>
                                </div>
                            </div>

                            <div id="pbMembersPanel" class="accordion-collapse collapse show" data-bs-parent="#pbCommitteesAccordion">

                                <div class="committee-body">

                                    <table class="members-table">
                                        <thead>
                                            <tr>
                                                <th>Member Name</th>
                                                <th>Role in Committee</th>
                                                <th>Contact</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($members as $member): ?>

                                                <?php
                                                $name        = esc_html($member['name'] ?? '');
                                                $designation = esc_html($member['designation'] ?? '');
                                                $role        = esc_html($member['in_the_capacity_of'] ?? '');
                                                $other       = esc_html($member['others_in_the_capacity_of'] ?? '');
                                                $contact     = esc_html($member['contact'] ?? '');
                                                $email       = esc_html($member['email_id'] ?? '');
                                                ?>

                                                <tr>
                                                    <td>
                                                        <strong><?php echo $name; ?></strong>
                                                        <?php if ($designation): ?>
                                                            <div style="font-size:12.5px;color:#777;margin-top:2px;"><?php echo $designation; ?></div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($role): ?>
                                                            <span class="role-badge"><?php echo mb_strtoupper($role); ?></span>
                                                        <?php endif; ?>
                                                        <?php if ($other): ?>
                                                            <span class="role-badge"><?php echo mb_strtoupper($other); ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($contact): ?>
                                                            <div><?php echo $contact; ?></div>
                                                        <?php endif; ?>
                                                        <?php if ($email): ?>
                                                            <div>
                                                                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo $email; ?></a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>

                                            <?php endforeach; ?>

                                        </tbody>
                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php endif; ?>

            </div>


            <div class="col-lg-6 mb-4">

                <h3 class="pb-col-title">Minutes of Meetings</h3>

                <?php if ($minutes_error): ?>

                    <div class="alert alert-danger"><?php echo esc_html($minutes_error); ?></div>

                <?php elseif (empty($minutes)): ?>

                    <div class="alert alert-warning">No minutes available.</div>

                <?php else: ?>

                    <div class="section-card">

                        <div class="minutes-list-modern">

                            <?php foreach ($minutes as $minute): ?>

                                <?php
                                $title    = esc_html($minute['meeting_title'] ?? '');
                                $date_raw = $minute['date_of_meeting'] ?? '';
                                $day      = '';
                                $mon      = '';
                                $file     = '';

                                if ($date_raw) {
                                    $ts = strtotime($date_raw);
                                    if ($ts) {
                                        $day = date('d', $ts);
                                        $mon = date('M', $ts);
                                    }
                                }

                                if (!empty($minute['file'])) {
                                    if (filter_var($minute['file'], FILTER_VALIDATE_URL)) {
                                        $file = $minute['file'];
                                    } else {
                                        $file = $media_base . $minute['file'];
                                    }
                                }
                                ?>

                                <a class="minute-row" <?php if ($file): ?>href="<?php echo esc_url($file); ?>" target="_blank" rel="noopener"<?php endif; ?>>

                                    <div class="min-date">
                                        <span class="d"><?php echo esc_html($day); ?></span>
                                        <span class="m"><?php echo esc_html($mon); ?></span>
                                    </div>

                                    <div class="min-info">
                                        <strong><?php echo $title; ?></strong>
                                        <span><?php echo $file ? 'View PDF' : 'No file attached'; ?></span>
                                    </div>

                                </a>

                            <?php endforeach; ?>

                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</section>

<style>

.pb-page-title{
    color:#5c1010;
    font-weight:700;
    margin-bottom:25px;
    border-left:5px solid #c9a84c;
    padding-left:15px;
}

.pb-col-title{
    color:#5c1010;
    font-weight:700;
    font-size:20px;
    margin-bottom:18px;
}

.section-card {
    background: #fff;
    border: 1px solid #5c1010;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    margin-top: 20px;
}

@media (max-width: 768px) {
    .minutes-list-modern .minute-row {
        flex: 0 0 100% !important;
    }
}

.minute-row {
    display: flex;
    align-items: center;
    gap: 20px;
    padding:5px;
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
    gap: 10px;
    margin-top: 20px;
}

.committee-card {
    background: #fff;
    border: 1px solid #5c1010;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
}

.committee-header {
    background: linear-gradient(135deg, #5c1010, #8B1A1A);
    padding: 20px 25px;
    color: #fff;
    cursor: pointer;
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
    font-weight: 700;
}

.members-table td {
    padding: 12px;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.95rem;
    color: #333 !important;
    vertical-align: top;
}

.members-table td a,
.members-table td a:visited {
    color:#8B1A1A !important;
    text-decoration:none !important;
    font-weight:600;
}

.members-table td a:hover {
    color:#5c1010 !important;
    text-decoration:underline !important;
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
    margin: 2px 4px 2px 0;
}

.toggle-icon {
    transition: transform 0.3s ease;
    font-size: 12px;
}

.committee-header[aria-expanded="true"] .toggle-icon {
    transform: rotate(180deg);
}

.accordion-collapse {
    display: none;
}

.accordion-collapse.show {
    display: block;
}

@media (max-width: 577px) {
    .members-table thead{
        display:none;
    }
    .members-table, .members-table tbody, .members-table tr, .members-table td{
        display:block;
        width:100%;
    }
    .members-table td{
        padding:10px 16px;
    }
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleHeaders = document.querySelectorAll('.committee-header[data-bs-toggle="collapse"]');
    toggleHeaders.forEach(header => {
        header.addEventListener('click', function(e) {
            if (e.target.closest('a') || e.target.closest('button') || e.target.closest('[onclick]')) {
                return;
            }

            const targetId = this.getAttribute('data-bs-target');
            const target = document.querySelector(targetId);
            if (!target) return;

            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            const parentSelector = target.getAttribute('data-bs-parent');
            if (parentSelector) {
                const parent = document.querySelector(parentSelector);
                if (parent) {
                    const allTargets = parent.querySelectorAll('.accordion-collapse.show');
                    const allHeaders = parent.querySelectorAll('.committee-header[aria-expanded="true"]');

                    allTargets.forEach(t => {
                        if (t !== target) t.classList.remove('show');
                    });

                    allHeaders.forEach(h => {
                        if (h !== this) h.setAttribute('aria-expanded', 'false');
                    });
                }
            }

            if (isExpanded) {
                target.classList.remove('show');
                this.setAttribute('aria-expanded', 'false');
            } else {
                target.classList.add('show');
                this.setAttribute('aria-expanded', 'true');
            }
        });
    });
});
</script>

<?php get_footer(); ?>