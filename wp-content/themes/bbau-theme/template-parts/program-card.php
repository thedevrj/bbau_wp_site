<?php
/**
 * Template part for displaying program details in Admissions Portal
 */
$prog = get_query_var('prog_data');
if (empty($prog)) return;

$level_label = ($prog['level'] === 'Others') ? $prog['other_level'] : $prog['level'];
$syllabus_url = $prog['syllabus'] ?? '';
?>

<div class="adm-card">
    <!-- CARD HEADER -->
    <div class="adm-card-header">
        <span class="badge-level"><?php echo esc_html($level_label); ?></span>
        <span class="badge-duration"><?php echo esc_html($prog['duration'] ?? '-'); ?></span>
    </div>

    <!-- CARD BODY -->
    <div class="adm-card-body">
        <h4 class="prog-name"><?php echo esc_html($prog['name']); ?></h4>
        <div class="dept-info">
            <i class="fa-solid fa-building-columns"></i>
            <span><?php echo esc_html($prog['department_name'] ?? 'N/A'); ?></span>
        </div>

        <div class="prog-stats mt-3">
            <div class="stat-row">
                <span class="stat-label"><i class="fa-solid fa-users"></i> Intake:</span>
                <div class="stat-value"><?php echo str_replace(array('<p>', '</p>'), array('', '<br>'), wp_kses_post($prog['intake'] ?? 'Not Disclosed')); ?></div>
            </div>
            <div class="stat-row">
                <span class="stat-label"><i class="fa-solid fa-indian-rupee-sign"></i> Fees:</span>
                <div class="stat-value"><?php echo str_replace(array('<p>', '</p>'), array('', '<br>'), wp_kses_post($prog['fees'] ?? 'As per University norms')); ?></div>
            </div>
        </div>
    </div>

    <!-- CARD FOOTER -->
    <div class="adm-card-footer">
        <button class="btn-details" onclick="toggleAdmDetail(this)">View Eligibility <i
                class="fa-solid fa-chevron-down"></i></button>
        <?php if(!empty($syllabus_url)): ?>
        <a href="<?php echo esc_url($syllabus_url); ?>" target="_blank" class="btn-syllabus" title="Download Syllabus">
            <i class="fa-solid fa-file-pdf"></i>
        </a>
        <?php endif; ?>
    </div>

    <!-- HIDDEN DETAILS -->
    <div class="adm-card-details" style="display:none;">
        <div class="details-inner">
            <h5>Eligibility Criteria</h5>
            <div class="eligibility-content">
                <?php echo wp_kses_post(!empty($prog['eligibility']) ? $prog['eligibility'] : 'Contact department for details.'); ?>
            </div>
            <?php if(!empty($prog['admission_process'])): ?>
            <h5 class="mt-3">Admission Process</h5>
            <div class="process-content">
                <?php echo wp_kses_post($prog['admission_process']); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.adm-card {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
    align-self: flex-start;
}

.adm-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(139, 26, 26, 0.1);
    border-color: #c9a84c;
}

.adm-card-header {
    padding: 15px 20px 5px;
    display: flex;
    justify-content: space-between;
}

.badge-level {
    background: #8B1A1A;
    color: #fff;
    padding: 3px 10px;
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 4px;
    text-transform: uppercase;
}

.badge-duration {
    background: #f3f4f6;
    color: #4b5563;
    padding: 3px 10px;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 4px;
}

.adm-card-body {
    padding: 15px 20px;
    flex-grow: 1;
}

.prog-name {
    font-family: 'Merriweather', serif;
    font-size: 1.15rem;
    color: #5c1010;
    font-weight: 700;
    margin-bottom: 8px;
    line-height: 1.4;
}

.dept-info {
    font-size: 0.85rem;
    color: #666;
    display: flex;
    align-items: flex-start;
    gap: 8px;
    line-height: 1.4;
}

.dept-info i {
    margin-top: 3px;
    color: #8B1A1A;
}

.prog-stats {
    background: #f9fafb;
    padding: 12px;
    border-radius: 8px;
    border: 1px dashed #e2d9cc;
}

.stat-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    font-size: 0.85rem;
    margin-bottom: 10px;
    gap: 12px;
}

.stat-row:last-child {
    margin-bottom: 0;
}

.stat-label {
    color: #666;
    font-weight: 500;
    display: flex;
    align-items: flex-start;
    gap: 8px;
    flex-shrink: 0;
    white-space: nowrap;
}

.stat-label i {
    color: #8B1A1A;
    width: 22px;
    text-align: center;
    margin-top: 3px;
}

.stat-value {
    color: #111;
    font-weight: 700;
    text-align: right;
    word-break: break-word;
    line-height: 1.4;
}

.stat-value p {
    margin-bottom: 0;
}

.adm-card-footer {
    padding: 15px 20px;
    border-top: 1px solid #f3f4f6;
    display: flex;
    gap: 10px;
}

.btn-details {
    flex-grow: 1;
    background: #fdfaf6;
    border: 1px solid #c9a84c;
    color: #5c1010;
    padding: 8px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    transition: 0.2s;
}

.btn-details:hover {
    background: #c9a84c;
    color: #fff;
}

.btn-syllabus {
    width: 40px;
    height: 38px;
    background: #f3f4f6;
    color: #8B1A1A !important;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    font-size: 1.1rem;
    transition: 0.2s;
}

.btn-syllabus:hover {
    background: #8B1A1A;
    color: #fff !important;
}

.adm-card-details {
    border-top: 1px solid #e2d9cc;
    background: #fffcf8;
}

.details-inner {
    padding: 20px;
}

.details-inner h5 {
    font-size: 0.95rem;
    color: #5c1010;
    font-weight: 700;
    margin-bottom: 10px;
    border-bottom: 1px solid #e2d9cc;
    padding-bottom: 5px;
}

.eligibility-content,
.process-content {
    font-size: 0.85rem;
    color: #444;
    line-height: 1.6;
}

.eligibility-content ul {
    padding-left: 20px;
    margin-top: 5px;
}
</style>

<script>
if (typeof toggleAdmDetail !== 'function') {
    window.toggleAdmDetail = function(btn) {
        const card = btn.closest('.adm-card');
        const details = card.querySelector('.adm-card-details');

        // Close other open cards
        const allOpenDetails = document.querySelectorAll('.adm-card-details');
        allOpenDetails.forEach(openDetail => {
            if (openDetail !== details && openDetail.style.display === 'block') {
                openDetail.style.display = 'none';
                const otherCard = openDetail.closest('.adm-card');
                const otherBtn = otherCard.querySelector('.btn-details');
                if (otherBtn) {
                    otherBtn.innerHTML = 'View Eligibility <i class="fa-solid fa-chevron-down"></i>';
                }
            }
        });

        if (details.style.display === 'none' || details.style.display === '') {
            details.style.display = 'block';
            btn.innerHTML = 'Hide Details <i class="fa-solid fa-chevron-up"></i>';
        } else {
            details.style.display = 'none';
            btn.innerHTML = 'View Eligibility <i class="fa-solid fa-chevron-down"></i>';
        }
    };
}
</script>