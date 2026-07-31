<?php
// Inherited variables: $api_base, $slug
$api_base = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
$committees_url = $api_base . '/api/v1/dept-committees/?department__slug=' . urlencode($slug);
$minutes_url = $api_base . '/api/v1/dept-minutes/?department__slug=' . urlencode($slug);
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
            <h3>Departmental Committees</h3>
            <?php if(!empty($committees_list)): ?>
            <div class="committees-wrap accordion" id="committeesAccordion">
                <?php foreach($committees_list as $index => $committee): ?>
                <div class="committee-card">
                    <div class="committee-header d-flex justify-content-between align-items-center flex-wrap gap-3"
                        style="cursor: pointer;" data-bs-toggle="collapse"
                        data-bs-target="#collapseCommittee<?php echo $index; ?>"
                        aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-chevron-down toggle-icon"></i>
                            <h4 class="mb-0">
                                <?php echo esc_html($committee['name']=== 'Others'? $committee['other_name']:$committee['name']); ?>
                            </h4>
                        </div>
                        <?php if(!empty($committee['notification_document'])): ?>
                        <div onclick="event.stopPropagation();">
                            <a class="btn-committee-doc" target="_blank"
                                href="<?php echo esc_url($media_base . $committee['notification_document']); ?>">
                                <i class="fa-solid fa-file-pdf"></i> Notification
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div id="collapseCommittee<?php echo $index; ?>"
                        class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>"
                        data-bs-parent="#committeesAccordion">
                        <div class="committee-body">
                            <?php if(!empty($committee['description'])): ?>
                            <div class="committee-desc"><?php echo wp_kses_post($committee['description']); ?>
                            </div>
                            <?php endif; ?>

                            <?php if(!empty($committee['members'])): ?>
                            <table class="members-table">
                                <thead>
                                    <tr>
                                        <th style="width: 65%">Member Name</th>
                                        <th style="width: 35%">Role in Committee</th>
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
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p style="margin-top:20px; color:#555;">No committee information is available for this department.</p>
            <?php endif; ?>
        </div>
        <div class="col-lg-6 mb-3">
            <h3>Minutes of Meetings</h3>
            <?php if(!empty($minutes_list)): ?>
            <?php 
                $minutes_by_committee = array();
                foreach ($minutes_list as $min) {
                    $cid = $min['committee'];
                    if (!isset($minutes_by_committee[$cid])) {
                        $minutes_by_committee[$cid] = array(
                            'committee_name' => isset($min['committee_name']) ? $min['committee_name'] : 'Committee',
                            'minutes' => array()
                        );
                    }
                    $minutes_by_committee[$cid]['minutes'][] = $min;
                }
            ?>
            <div class="committees-wrap accordion" id="minutesAccordion">
                <?php $m_index = 0; foreach($minutes_by_committee as $cid => $cdata): ?>
                <div class="committee-card">
                    <div class="committee-header d-flex justify-content-between align-items-center flex-wrap gap-3"
                        style="cursor: pointer;" data-bs-toggle="collapse"
                        data-bs-target="#collapseMin<?php echo $m_index; ?>"
                        aria-expanded="<?php echo $m_index === 0 ? 'true' : 'false'; ?>">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-chevron-down toggle-icon"></i>
                            <h4 class="mb-0"><?php echo esc_html($cdata['committee_name']); ?>&nbsp;&nbsp;Minutes</h4>
                        </div>
                    </div>
                    <div id="collapseMin<?php echo $m_index; ?>"
                        class="accordion-collapse collapse <?php echo $m_index === 0 ? 'show' : ''; ?>"
                        data-bs-parent="#minutesAccordion">
                        <div class="committee-body" style="background: #fff;">
                            <div class="minutes-list-modern">
                                <?php foreach ($cdata['minutes'] as $min) : ?>
                                <a href="<?php echo $media_base . esc_url( $min['minutes_of_meeting']); ?>"
                                    class="minute-row" target="_blank">
                                    <div class="min-date">
                                        <span
                                            class="d"><?php echo date('d', strtotime($min['date_of_meeting'])); ?></span>
                                        <span
                                            class="m"><?php echo date('M', strtotime($min['date_of_meeting'])); ?></span>
                                    </div>
                                    <div class="min-info">
                                        <strong><?php echo esc_html(!empty($min['meeting_title']) ? $min['meeting_title'] : 'Board Meeting'); ?></strong>
                                        <span>View PDF <i class="fa-solid fa-file-pdf"></i></span>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $m_index++; endforeach; ?>
            </div>
            <?php else: ?>
            <p style="margin-top:20px; color:#555;">No Minutes is available for this department.</p>
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

/* .minutes-list-modern .minute-row {
    width: calc(50% - 12px) !important;
    flex: 0 0 calc(50% - 12px) !important;
} */

@media (max-width: 768px) {
    .minutes-list-modern .minute-row {
        flex: 0 0 100% !important;
    }
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
    gap: 10px;
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

.toggle-icon {
    transition: transform 0.3s ease;
}

.committee-header[aria-expanded="true"] .toggle-icon {
    transform: rotate(180deg);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleHeaders = document.querySelectorAll('.committee-header[data-bs-toggle="collapse"]');
    toggleHeaders.forEach(header => {
        header.addEventListener('click', function(e) {
            // Prevent toggling if a link or button inside the header was clicked
            if (e.target.closest('a') || e.target.closest('button') || e.target.closest(
                    '[onclick]')) {
                return;
            }

            const targetId = this.getAttribute('data-bs-target');
            const target = document.querySelector(targetId);
            if (!target) return;

            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            // Accordion behavior: close others in the same parent
            const parentSelector = target.getAttribute('data-bs-parent');
            if (parentSelector) {
                const parent = document.querySelector(parentSelector);
                if (parent) {
                    const allTargets = parent.querySelectorAll('.accordion-collapse.show');
                    const allHeaders = parent.querySelectorAll(
                        '.committee-header[aria-expanded="true"]');

                    allTargets.forEach(t => {
                        if (t !== target) t.classList.remove('show');
                    });

                    allHeaders.forEach(h => {
                        if (h !== this) h.setAttribute('aria-expanded', 'false');
                    });
                }
            }

            // Toggle current
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