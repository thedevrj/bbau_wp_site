<?php
// Inherited variables: $api_base, $slug
$prog_url = $api_base . '/api/v1/programs/?centre_slug=' . urlencode($slug);
$prog_res = wp_remote_get($prog_url, array('timeout' => 10));
$programs_list = array();

if (!is_wp_error($prog_res) && wp_remote_retrieve_response_code($prog_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($prog_res), true);
    $programs_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

$cbcs_url = $api_base . '/api/v1/cbcs/?centre_slug=' . urlencode($slug);
$cbcs_res = wp_remote_get($cbcs_url, array('timeout' => 10));
$cbcs_list = array();
if (!is_wp_error($cbcs_res) && wp_remote_retrieve_response_code($cbcs_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($cbcs_res), true);
    $cbcs_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<div class="section">
    <h3>Academic Programmes</h3>
    <?php if(!empty($programs_list)): ?>
    <div class="prog-table-wrap">
        <table class="prog-table">
            <thead>
                <tr>
                    <th style="width: 25%">Programme Name</th>
                    <th style="width: 8%">Level</th>
                    <th style="width: 10%">Duration</th>
                    <th>Intake & Fees</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($programs_list as $prog): ?>
                <tr>
                    <td style="font-weight:700; color:#5c1010;"><?php echo esc_html($prog['name']); ?></td>
                    <td><?php echo esc_html($prog['level'] === 'Others' ? $prog['other_level'] : $prog['level']); ?>
                    </td>
                    <td><?php echo esc_html($prog['duration'] ?? '-'); ?></td>
                    <td>
                        <strong>Intake:</strong> <?php echo str_replace(array('<p>', '</p>'), array('', '<br>'), wp_kses_post($prog['intake'] ?? '-')); ?><br>
                        <strong>Fees:</strong> <?php echo str_replace(array('<p>', '</p>'), array('', '<br>'), wp_kses_post($prog['fees'] ?? '-')); ?>
                    </td>
                    <td>
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <?php if(!empty($prog['syllabus'])): ?>
                            <a href="<?php echo esc_url($prog['syllabus']); ?>" target="_blank" class="syllabus-btn"><i
                                    class="fas fa-file-alt"></i>
                                Syllabus</a>
                            <?php endif; ?>

                            <button class="curriculum-btn"
                                onclick="toggleCurriculum('prog-<?php echo esc_attr($prog['id']); ?>')">📚 Course
                                Structure</button>
                            <?php if(!empty($prog['notification_or_document_file'])): ?>
                            <a href="<?php echo esc_url($prog['notification_or_document_file']); ?>" target="_blank"
                                class="syllabus-btn"><i class="fas fa-file-alt"></i>
                                Course Notification</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <!-- HIDDEN CURRICULUM ROW -->
                <tr id="prog-<?php echo esc_attr($prog['id']); ?>" class="curriculum-row"
                    style="display:none; background:#fdfaf6;">
                    <td colspan="5">
                        <div class="curriculum-content" style="padding:20px;">
                            <?php 
                            $courses = $prog['courses'] ?? array();
                            if(!empty($courses)): 
                                // Group by semester
                                $semesters = array();
                                foreach($courses as $c) {
                                    $semesters[$c['semester']][] = $c;
                                }
                                ksort($semesters);
                            ?>
                            <div class="sem-tabs">
                                <?php foreach($semesters as $sem => $s_courses): ?>
                                <div class="sem-box">
                                    <h5 class="sem-title">Semester <?php echo esc_html($sem); ?></h5>
                                    <table class="course-mini-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 15%">Course Code</th>
                                                <th style="width: 50%">Course Title</th>
                                                <th style="width: 10%">Credits</th>
                                                <th style="width: 25%">Course Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($s_courses as $sc): ?>
                                            <tr>
                                                <td><code><?php echo esc_html($sc['course_code']); ?></code></td>
                                                <td style="font-weight:600;">
                                                    <?php echo esc_html($sc['course_title']); ?></td>
                                                <td><?php echo esc_html($sc['credits']); ?></td>
                                                <td>
                                                    <span
                                                        class="type-badge <?php echo strtolower(esc_attr($sc['course_type'])); ?>">
                                                        <?php echo esc_html($sc['course_type'] === 'Others' ? $sc['other_course_type'] : $sc['course_type']); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php else: ?>
                            <p>Course details for this program are currently being updated.</p>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <p style="margin-top:20px; color:#555;">No academic programmes are currently documented for this centre.</p>
    <?php endif; ?>
</div>

<?php if(!empty($cbcs_list)): ?>
<div class="section" style="margin-top:50px;">
    <h3>Open Electives (CBCS Courses)</h3>
    <p style="font-size:0.9rem; color:#666; margin-bottom:15px;">Inter-disciplinary courses offered by the centre to
        students of other departments.</p>
    <div class="prog-table-wrap">
        <table class="prog-table">
            <thead>
                <tr>
                    <th style="width: 15%">Course Code</th>
                    <th style="width: 50%">Title</th>
                    <th style="width: 15%">Semester</th>
                    <th style="width: 20%">Credits</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($cbcs_list as $cc): ?>
                <tr>
                    <td><code><?php echo esc_html($cc['course_code']); ?></code></td>
                    <td style="font-weight:700; color:#5c1010;"><?php echo esc_html($cc['course_title']); ?></td>
                    <td>Semester <?php echo esc_html($cc['semester']); ?></td>
                    <td><?php echo esc_html($cc['credits']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<style>
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
    text-align: center;
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
}

.prog-table td {
    padding: 15px;
    border-bottom: 1px solid #e2d9cc;
    color: #444;
    vertical-align: top;
}

.course-mini-table td {
    text-align: center;
}

.prog-table tr:hover {
    background: #fdfaf6;
}

.syllabus-btn,
.curriculum-btn {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 700;
    text-align: center;
    cursor: pointer;
    text-decoration: none;
    transition: 0.2s;
    border: 1px solid transparent;
}

.syllabus-btn {
    background: #c9a84c;
    color: #5c1010 !important;
}

.syllabus-btn:hover {
    background: #b8933b;
}

.curriculum-btn {
    background: #fff;
    border-color: #5c1010;
    color: #5c1010;
}

.curriculum-btn:hover {
    background: #5c1010 !important;
    color: #fff;
}

.sem-box {
    margin-bottom: 30px;
}

.sem-title {
    color: #8B1A1A;
    font-weight: 700;
    border-bottom: 2px solid #e2d9cc;
    padding-bottom: 5px;
    margin-bottom: 15px;
}

.course-mini-table {
    width: 100%;
    border-collapse: collapse;
}

.course-mini-table th {
    background: #f1f5f9;
    color: #475569;
    padding: 8px 12px;
    font-size: 0.75rem;
    border: none;
}

.course-mini-table td {
    padding: 8px 12px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.85rem;
}

.type-badge {
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
}

.type-badge.core {
    background: #dcfce7;
    color: #166534;
}

.type-badge.elective {
    background: #fef9c3;
    color: #854d0e;
}
</style>

<script>
function toggleCurriculum(id) {
    const row = document.getElementById(id);
    
    // Close other open curriculum rows
    const allRows = document.querySelectorAll('.curriculum-row');
    allRows.forEach(r => {
        if (r.id !== id && r.style.display === 'table-row') {
            r.style.display = 'none';
        }
    });

    if (row.style.display === 'none') {
        row.style.display = 'table-row';
    } else {
        row.style.display = 'none';
    }
}
</script>