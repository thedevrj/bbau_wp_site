<?php
/**
 * Template Name: CBCS Centralized Page
 */
$api_base = getenv('DJANGO_MEDIA_URL');
$api_url = $api_base . '/api/v1/departments/';
$cbcs = $api_base . '/api/v1/cbcs/';
$page_id = get_the_ID();
define('BBAU_DEPARTMENTS_API', $api_url);
define('BBAU_CBCS_API',  $cbcs);
define('BBAU_CBCS_MAX_PAGES',  6);

function bbau_get_departments() {
    $cached = get_transient('bbau_all_departments');
    if (is_array($cached)) return $cached;

    $response = wp_remote_get(BBAU_DEPARTMENTS_API, array('timeout' => 10));
    if (is_wp_error($response)) return array();
    $data = json_decode(wp_remote_retrieve_body($response), true);
    if (!is_array($data)) return array();
    $result = isset($data['results']) ? $data['results'] : $data;

    set_transient('bbau_all_departments', $result, 30 * MINUTE_IN_SECONDS);

    return $result;
}

function bbau_get_all_cbcs() {
    $cached = get_transient('bbau_all_cbcs_courses');
    if (is_array($cached)) return $cached;

    $all = array();
    for ($page = 1; $page <= BBAU_CBCS_MAX_PAGES; $page++) {
        $url      = add_query_arg(array('page' => $page), BBAU_CBCS_API);
        $response = wp_remote_get($url, array('timeout' => 10));
        if (is_wp_error($response)) continue;

        $data    = json_decode(wp_remote_retrieve_body($response), true);
        $results = is_array($data) ? (isset($data['results']) ? $data['results'] : $data) : array();

        if (!is_array($results) || empty($results)) break;

        foreach ($results as $course) {
            $all[] = $course;
        }

        if (isset($data['next']) && !$data['next']) break;
    }
    $ttl = empty($all) ? 2 * MINUTE_IN_SECONDS : 30 * MINUTE_IN_SECONDS;
    set_transient('bbau_all_cbcs_courses', $all, $ttl);

    return $all;
}

function bbau_classify_code($code) {
    $c = strtoupper(trim((string) $code));
    if ($c === '') return '';
    if (preg_match('/^M/', $c)) return 'pg';
    if (preg_match('/^B/', $c)) return 'ug';
    return '';
}

function bbau_course_dept_id($course) {
    if (isset($course['department']) && is_array($course['department']) && isset($course['department']['id'])) {
        return (int) $course['department']['id'];
    }
    if (isset($course['department_id'])) return (int) $course['department_id'];
    if (isset($course['department']) && is_numeric($course['department'])) return (int) $course['department'];
    return 0;
}

get_header();

$departments  = bbau_get_departments();
$all_courses  = bbau_get_all_cbcs();

$courses_by_dept = array();
$level_by_dept    = array();
foreach ($all_courses as $course) {
    $dept_id = bbau_course_dept_id($course);
    if (!$dept_id) continue;

    if (!isset($courses_by_dept[$dept_id])) $courses_by_dept[$dept_id] = array();
    $courses_by_dept[$dept_id][] = $course;

    $code  = isset($course['course_code']) ? $course['course_code'] : (isset($course['code']) ? $course['code'] : '');
    $level = bbau_classify_code($code);
    if (!$level) continue;

    if (!isset($level_by_dept[$dept_id])) {
        $level_by_dept[$dept_id] = $level;
    } elseif ($level_by_dept[$dept_id] !== $level && $level_by_dept[$dept_id] !== 'mixed') {
        $level_by_dept[$dept_id] = 'mixed';
    }
}
$courses_by_dept_js = array();
foreach ($courses_by_dept as $dept_id => $dept_courses) {
    $slim = array();
    foreach ($dept_courses as $c) {
        $slim[] = array(
            'course_code'  => isset($c['course_code']) ? $c['course_code'] : (isset($c['code']) ? $c['code'] : ''),
            'course_title' => isset($c['course_title']) ? $c['course_title'] : (isset($c['title']) ? $c['title'] : ''),
            'semester'     => isset($c['semester']) ? $c['semester'] : null,
            'credits'      => isset($c['credits']) ? $c['credits'] : null,
        );
    }
    $courses_by_dept_js[$dept_id] = $slim;
}

$ajax_url = admin_url('admin-ajax.php');
?>


    <div class="sc-hero" style="background-image: url('<?php echo get_field('desktop_1x', $page_id); ?>');">
        <div class="sc-hero-overlay">
            <div class="sc-hero-card">
                <span class="sc-badge">Choice Based Credit System</span>
                <h1>Open-elective courses offered across all departments</h1>
                <div class="sc-hero-line"></div>
            </div>
        </div>
    </div>

<div class="container">
    <div class="cbcs-filter-bar">

        <div class="cbcs-filter-group">
            <span class="cbcs-filter-label">Filter by Level</span>
            <div class="cbcs-level-tabs">
                <button class="cbcs-level-btn active" data-level="all">All</button>
                <button class="cbcs-level-btn" data-level="ug">Undergraduate</button>
                <button class="cbcs-level-btn" data-level="pg">Postgraduate</button>
            </div>
        </div>

        <div class="cbcs-filter-group">
            <span class="cbcs-filter-label">Filter by Department</span>
            <div class="cbcs-select-wrap">
                <select id="cbcs-dept-select" class="cbcs-select">
                    <option value="0">All Departments</option>
                    <?php foreach ($departments as $d):
                        $id   = isset($d['id'])   ? (int)$d['id']  : 0;
                        $name = isset($d['name'])  ? $d['name']     : '';
                        if (!$id || !$name) continue;
                    ?>
                        <option value="<?php echo esc_attr($id); ?>"><?php echo esc_html($name); ?></option>
                    <?php endforeach; ?>
                </select>
                <i class="fa-solid fa-chevron-down cbcs-select-icon"></i>
            </div>
        </div>

        <div class="cbcs-filter-group cbcs-filter-group-grow">
            <span class="cbcs-filter-label">Search by Keyword</span>
            <div class="cbcs-search-wrap">
                <input type="text" id="cbcs-keyword" class="cbcs-search-input" placeholder="Search department, course code, or course title…">
            </div>
        </div>

    </div>
    <?php if (empty($departments)): ?>
        <p class="cbcs-no-data">No departments found. Check that <code><?php echo esc_html(BBAU_DEPARTMENTS_API); ?></code> is reachable.</p>
    <?php else: ?>

        <div class="cbcs-dept-grid" id="cbcs-dept-grid">
            <?php foreach ($departments as $dept):
                $dept_id     = isset($dept['id'])              ? (int)$dept['id']         : 0;
                $dept_name   = isset($dept['name'])            ? $dept['name']             : '';
                $school_name = isset($dept['school_name'])     ? $dept['school_name']      : '';
                $campus      = isset($dept['campus'])          ? $dept['campus']           : '';

                if (!$dept_id || !$dept_name) continue;

               $dept_courses = isset($courses_by_dept[$dept_id]) ? $courses_by_dept[$dept_id] : array();
               $course_count = count($dept_courses);
               if ($course_count === 0) continue;

               $level        = isset($level_by_dept[$dept_id]) ? $level_by_dept[$dept_id] : '';

                if ($level === 'mixed') {
                    $data_level_attr = 'ug pg';
                } elseif ($level === 'ug' || $level === 'pg') {
                    $data_level_attr = $level;
                } else {
                    $data_level_attr = 'all'; 
                }
            ?>
                <div class="cbcs-dept-card"
                     data-dept-id="<?php echo esc_attr($dept_id); ?>"
                     data-dept-name="<?php echo esc_attr($dept_name); ?>"
                     data-level="<?php echo esc_attr($data_level_attr); ?>">

                    <div class="cbcs-dept-card-head">
                        <h4><?php echo esc_html($dept_name); ?></h4>
                        <?php if ($school_name): ?>
                            <span class="cbcs-dept-school"><?php echo esc_html($school_name); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="cbcs-dept-card-body">
                        <?php if ($campus): ?>
                            <p class="cbcs-meta-row">
                                <i class="fa-solid fa-location-dot"></i>
                                <?php echo esc_html($campus); ?>
                            </p>
                        <?php endif; ?>
                        <p class="cbcs-meta-row">
                            <i class="fa-solid fa-book"></i>
                            <?php echo (int) $course_count; ?> course<?php echo $course_count === 1 ? '' : 's'; ?>
                        </p>

                        <div class="cbcs-level-badges">
                            <?php if ($level === 'ug' || $level === 'mixed'): ?>
                                <span class="cbcs-level-badge badge-ug">UG</span>
                            <?php endif; ?>
                            <?php if ($level === 'pg' || $level === 'mixed'): ?>
                                <span class="cbcs-level-badge badge-pg">PG</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="cbcs-dept-card-foot">
                        <button class="cbcs-view-btn"
                                data-dept-id="<?php echo esc_attr($dept_id); ?>"
                                data-dept-name="<?php echo esc_attr($dept_name); ?>"
                                <?php disabled($course_count, 0); ?>>
                            <?php echo $course_count ? 'View CBCS' : 'No courses'; ?>
                            <i class="fa-solid fa-chevron-down cbcs-btn-icon"></i>
                        </button>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

        <div class="cbcs-pagination cbcs-card-pagination" id="cbcs-card-pagination"></div>

    <?php endif; ?>

</div>
<template id="cbcs-inline-tpl">
    <div class="cbcs-inline-wrap">
        <div class="cbcs-inline-header">
            <div class="cbcs-inline-header-text">
                <h3 class="cbcs-inline-title"></h3>
                <p class="cbcs-inline-sub">Open-elective courses offered by this department</p>
            </div>
            <div class="cbcs-inline-header-right">
                <span class="cbcs-count-badge"></span>
                <button class="cbcs-inline-close" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>

        <div class="cbcs-table-scroll">
            <table class="cbcs-table">
                <thead>
                    <tr>
                        <th class="col-code">Course Code</th>
                        <th class="col-title">Course Title</th>
                        <th class="col-level">Level</th>
                        <th class="col-sem">Semester</th>
                        <th class="col-credits">Credits</th>
                    </tr>
                </thead>
                <tbody class="cbcs-inline-tbody">
                    <tr><td colspan="5" class="cbcs-state-row">
                        <span class="cbcs-spinner"></span> Loading…
                    </td></tr>
                </tbody>
            </table>
        </div>

        <div class="cbcs-pagination cbcs-inline-pagination"></div>
    </div>
</template>

<script>
(function () {
    const PAGE_SIZE = 20;
    const CARDS_PER_PAGE = 16;
    const coursesByDept = <?php echo wp_json_encode($courses_by_dept_js); ?>;

    function classifyCode(code) {
        const c = (code || '').toUpperCase().trim();
        if (!c) return '';
        if (/^M/.test(c)) return 'pg';
        if (/^B/.test(c)) return 'ug';
        return '';
    }

    function esc(str) {
        const d = document.createElement('div');
        d.textContent = (str == null) ? '' : String(str);
        return d.innerHTML;
    }

    const panelState = {};

    let activePanel  = null;
    let activeDeptId = null;

    const gState = { level: 'all', deptFilter: 0, keyword: '' };
    let cardPage = 1;
    const allCards   = Array.from(document.querySelectorAll('.cbcs-dept-card'));
    const allViewBtns = Array.from(document.querySelectorAll('.cbcs-view-btn'));

    function applyCardFilters() {
        const keyword = gState.keyword.toLowerCase();

        const matches = [];
        allCards.forEach(function (card) {
            const cardLevels = (card.dataset.level || 'all').split(' ');
            const deptId      = parseInt(card.dataset.deptId, 10);
            const deptName    = (card.dataset.deptName || '').toLowerCase();

            // Toggle individual UG/PG badges based on the active level filter
            const ugBadge = card.querySelector('.badge-ug');
            const pgBadge = card.querySelector('.badge-pg');
            if (ugBadge) ugBadge.style.display = (gState.level === 'all' || gState.level === 'ug') ? '' : 'none';
            if (pgBadge) pgBadge.style.display = (gState.level === 'all' || gState.level === 'pg') ? '' : 'none';

            let visible = true;
            if (gState.level !== 'all' && !cardLevels.includes('all') && !cardLevels.includes(gState.level)) {
                visible = false;
            }
            if (gState.deptFilter && deptId !== gState.deptFilter) visible = false;
            if (keyword) {
                const deptNameMatch = deptName.includes(keyword);
                const courseMatch = (coursesByDept[deptId] || []).some(function (c) {
                    const code  = (c.course_code  || '').toLowerCase();
                    const title = (c.course_title || '').toLowerCase();
                    return code.includes(keyword) || title.includes(keyword);
                });
                if (!deptNameMatch && !courseMatch) visible = false;
            }

            if (visible) matches.push(card);
            else {
                card.style.display = 'none';
                if (deptId === activeDeptId) closeInlinePanel();
            }
        });

        const totalPages = Math.max(1, Math.ceil(matches.length / CARDS_PER_PAGE));
        if (cardPage > totalPages) cardPage = totalPages;
        if (cardPage < 1) cardPage = 1;

        const start    = (cardPage - 1) * CARDS_PER_PAGE;
        const pageSet  = matches.slice(start, start + CARDS_PER_PAGE);
        const pageSetIds = new Set(pageSet);

        matches.forEach(function (card) {
            const visible = pageSetIds.has(card);
            card.style.display = visible ? '' : 'none';
            const deptId = parseInt(card.dataset.deptId, 10);
            if (!visible && deptId === activeDeptId) closeInlinePanel();
        });

        renderCardPagination(matches.length, totalPages);
    }

    function renderCardPagination(totalMatches, totalPages) {
        const pagDiv = document.getElementById('cbcs-card-pagination');
        if (!pagDiv) return;

        if (totalPages <= 1) { pagDiv.style.display = 'none'; pagDiv.innerHTML = ''; return; }

        pagDiv.style.display = 'flex';
        let html = '';

        html += '<button class="cbcs-page-btn" ' + (cardPage <= 1 ? 'disabled' : '') +
                ' data-card-page="' + (cardPage - 1) + '"><i class="fa-solid fa-chevron-left"></i></button>';

        for (let p = 1; p <= totalPages; p++) {
            const nearCurrent = Math.abs(p - cardPage) <= 1;
            const isEdge      = p === 1 || p === totalPages;
            if (!nearCurrent && !isEdge) {
                if (p === 2 || p === totalPages - 1) {
                    html += '<span class="cbcs-page-ellipsis">…</span>';
                }
                continue;
            }
            html += '<button class="cbcs-page-btn' + (p === cardPage ? ' active' : '') +
                    '" data-card-page="' + p + '">' + p + '</button>';
        }

        html += '<button class="cbcs-page-btn" ' + (cardPage >= totalPages ? 'disabled' : '') +
                ' data-card-page="' + (cardPage + 1) + '"><i class="fa-solid fa-chevron-right"></i></button>';

        pagDiv.innerHTML = html;

        pagDiv.querySelectorAll('.cbcs-page-btn:not([disabled])').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const p = parseInt(btn.dataset.cardPage, 10);
                if (!p || p === cardPage) return;
                cardPage = p;
                applyCardFilters();
                document.getElementById('cbcs-dept-grid').scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    }

    function openInlinePanel(btn, deptId, deptName) {
        closeInlinePanel();

        const card = btn.closest('.cbcs-dept-card');
        if (!card) return;
        const tpl   = document.getElementById('cbcs-inline-tpl');
        const panel = tpl.content.cloneNode(true).querySelector('.cbcs-inline-wrap');
        panel.querySelector('.cbcs-inline-title').textContent = deptName + ' — CBCS Courses';

        const spanDiv = document.createElement('div');
        spanDiv.className = 'cbcs-inline-row';
        spanDiv.appendChild(panel);
        card.after(spanDiv);

        panel.querySelector('.cbcs-inline-close').addEventListener('click', closeInlinePanel);

        activePanel  = spanDiv;
        activeDeptId = deptId;

        if (!panelState[deptId]) {
            panelState[deptId] = { page: 1, keyword: '' };
        }
        setTimeout(function () {
            spanDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 60);

        renderPanel(panel, deptId);
    }

    function closeInlinePanel() {
        if (activePanel) {
            activePanel.remove();
            activePanel  = null;
        }
        allViewBtns.forEach(function (b) {
            b.innerHTML = 'View CBCS <i class="fa-solid fa-chevron-down cbcs-btn-icon"></i>';
            b.classList.remove('open');
        });
        activeDeptId = null;
    }

    function renderPanel(panel, deptId) {
        const st      = panelState[deptId];
        const badge   = panel.querySelector('.cbcs-count-badge');
        const tbody   = panel.querySelector('.cbcs-inline-tbody');
        const pagDiv  = panel.querySelector('.cbcs-inline-pagination');

        const deptCourses = coursesByDept[deptId] || [];
        const kw   = (st.keyword || '').toLowerCase();
        const filtered = deptCourses.filter(function (r) {
            if (!kw) return true;
            const code  = (r.course_code  || '').toLowerCase();
            const title = (r.course_title || '').toLowerCase();
            return code.includes(kw) || title.includes(kw);
        });

        badge.textContent = filtered.length + ' course' + (filtered.length !== 1 ? 's' : '');

        if (!filtered.length) {
            tbody.innerHTML = '<tr><td colspan="5" class="cbcs-state-row cbcs-empty">No courses match your search.</td></tr>';
            pagDiv.style.display = 'none';
            return;
        }
        const totalPages = Math.max(1, Math.ceil(filtered.length / PAGE_SIZE));
        if (st.page > totalPages) st.page = totalPages;
        const start = (st.page - 1) * PAGE_SIZE;
        const rows  = filtered.slice(start, start + PAGE_SIZE);

        tbody.innerHTML = rows.map(function (r, i) {
            const code    = r.course_code  || '—';
            const title   = r.course_title || '—';
            const sem     = r.semester  != null ? r.semester  : '—';
            const credits = r.credits   != null ? r.credits   : '—';
            const level   = classifyCode(code);
            const levelLabel = level === 'ug' ? 'UG' : (level === 'pg' ? 'PG' : '—');
            const levelClass = level === 'ug' ? 'badge-ug' : (level === 'pg' ? 'badge-pg' : 'badge-na');
            return '<tr class="' + (i % 2 === 0 ? 'row-even' : 'row-odd') + '">' +
                '<td class="col-code"><span class="code-chip">' + esc(code) + '</span></td>' +
                '<td class="col-title">' + esc(title) + '</td>' +
                '<td class="col-level"><span class="cbcs-level-badge ' + levelClass + '">' + levelLabel + '</span></td>' +
                '<td class="col-sem">Sem&nbsp;' + esc(String(sem)) + '</td>' +
                '<td class="col-credits"><span class="credit-pill">' + esc(String(credits)) + '&nbsp;</span></td>' +
                '</tr>';
        }).join('');

        renderPagination(pagDiv, deptId, panel, filtered.length);
    }

    function renderPagination(pagDiv, deptId, panel, totalFiltered) {
        const st         = panelState[deptId];
        const totalPages = Math.ceil(totalFiltered / PAGE_SIZE);

        if (totalPages <= 1) { pagDiv.style.display = 'none'; return; }

        pagDiv.style.display = 'flex';
        let html = '';

        html += '<button class="cbcs-page-btn" ' + (st.page <= 1 ? 'disabled' : '') +
                ' data-page="' + (st.page - 1) + '"><i class="fa-solid fa-chevron-left"></i></button>';

        for (let p = 1; p <= totalPages; p++) {
            const nearCurrent = Math.abs(p - st.page) <= 1;
            const isEdge      = p === 1 || p === totalPages;
            if (!nearCurrent && !isEdge) {
                if (p === 2 || p === totalPages - 1) {
                    html += '<span class="cbcs-page-ellipsis">…</span>';
                }
                continue;
            }
            html += '<button class="cbcs-page-btn' + (p === st.page ? ' active' : '') +
                    '" data-page="' + p + '">' + p + '</button>';
        }

        html += '<button class="cbcs-page-btn" ' + (st.page >= totalPages ? 'disabled' : '') +
                ' data-page="' + (st.page + 1) + '"><i class="fa-solid fa-chevron-right"></i></button>';

        pagDiv.innerHTML = html;

        pagDiv.querySelectorAll('.cbcs-page-btn:not([disabled])').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const p = parseInt(btn.dataset.page, 10);
                if (!p || p === st.page) return;
                st.page = p;
                renderPanel(panel, deptId);
                panel.querySelector('.cbcs-table-scroll').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            });
        });
    }
    document.getElementById('cbcs-dept-grid').addEventListener('click', function (e) {
        const btn = e.target.closest('.cbcs-view-btn');
        if (!btn || btn.disabled) return;

        const deptId   = parseInt(btn.dataset.deptId, 10);
        const deptName = btn.dataset.deptName || '';
        if (activeDeptId === deptId) {
            closeInlinePanel();
            return;
        }
        allViewBtns.forEach(function (b) {
            if (!b.disabled) b.innerHTML = 'View CBCS <i class="fa-solid fa-chevron-down cbcs-btn-icon"></i>';
            b.classList.remove('open');
        });
        btn.innerHTML = 'Hide CBCS <i class="fa-solid fa-chevron-up cbcs-btn-icon"></i>';
        btn.classList.add('open');

        openInlinePanel(btn, deptId, deptName);
    });
    document.querySelectorAll('.cbcs-level-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.cbcs-level-btn').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            gState.level = btn.dataset.level;
            cardPage = 1;
            applyCardFilters();
        });
    });
    document.getElementById('cbcs-dept-select').addEventListener('change', function () {
        gState.deptFilter = parseInt(this.value, 10) || 0;
        cardPage = 1;
        applyCardFilters();
    });
    let gKwTimer;
    document.getElementById('cbcs-keyword').addEventListener('input', function () {
        clearTimeout(gKwTimer);
        const input = this;
        gKwTimer = setTimeout(function () {
            gState.keyword = input.value.trim();
            cardPage = 1;
            applyCardFilters();
        }, 240);
    });
    applyCardFilters();

})();
</script>

<style>
/* ═══════════════════════════════════════════════════════════
   CBCS PAGE — BBAU
   Palette: #5c1010 · #8B1A1A · #c9a84c · #fdfaf6 · #fff
   ═══════════════════════════════════════════════════════════ */
.cbcs-filter-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 20px 36px;
    align-items: flex-end;
    background: #fff;
    border: 1px solid #e8dfd0;
    border-radius: 14px;
    padding: 22px 28px;
    margin-top: 28px;
    margin-bottom: 28px;
    box-shadow: 0 2px 12px rgba(92,16,16,.04);
}
.cbcs-filter-group { display: flex; flex-direction: column; gap: 8px; }
.cbcs-filter-group-grow { flex: 1 1 240px; }
.cbcs-filter-group-grow .cbcs-search-input { width: 100%; }
.cbcs-filter-label {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #8B1A1A;
}

/* Level tabs */
.cbcs-level-tabs {
    display: flex;
    gap: 4px;
    background: #f3ede3;
    border-radius: 8px;
    padding: 3px;
}
.cbcs-level-btn {
    border: none;
    background: none;
    padding: 7px 18px;
    border-radius: 6px;
    font-size: .82rem;
    font-weight: 600;
    color: #666;
    cursor: pointer;
    transition: all .18s;
    white-space: nowrap;
}
.cbcs-level-btn:hover { color: #5c1010; }
.cbcs-level-btn.active {
    background: #8B1A1A;
    color: #fff;
    box-shadow: 0 2px 8px rgba(139,26,26,.28);
}

/* Select */
.cbcs-select-wrap { position: relative; }
.cbcs-select {
    appearance: none;
    -webkit-appearance: none;
    border: 1.5px solid #d9cfc0;
    border-radius: 8px;
    padding: 9px 38px 9px 14px;
    font-size: .85rem;
    color: #333;
    background: #fff;
    min-width: 220px;
    cursor: pointer;
    outline: none;
    transition: border-color .18s;
}
.cbcs-select:focus { border-color: #c9a84c; }
.cbcs-select-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
    font-size: .75rem;
    pointer-events: none;
}
.cbcs-search-wrap { position: relative; }
.cbcs-search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #aaa;
    font-size: .8rem;
    pointer-events: none;
}
.cbcs-search-input {
    border: 1.5px solid #d9cfc0;
    border-radius: 8px;
    padding: 9px 14px 9px 34px;
    font-size: .85rem;
    color: #333;
    background: #fff;
    min-width: 220px;
    outline: none;
    transition: border-color .18s;
}
.cbcs-search-input:focus { border-color: #c9a84c; }
.cbcs-search-input::placeholder { color: #bbb; }
.cbcs-dept-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    grid-auto-rows: auto;
    gap: 18px;
    align-items: start;
}
.cbcs-inline-row {
    grid-column: 1 / -1;
    grid-row: auto;
    height: auto;
}

.cbcs-dept-card {
    background: #fff;
    border: 5px solid #7a1919;
    border-radius: 14px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 230px;
    transition: all .25s;
    box-shadow: 0 4px 6px rgba(0,0,0,.03);
}
.cbcs-dept-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(139,26,26,.1);
    border-color: #c9a84c;
}

.cbcs-dept-card-head { padding: 16px 18px 6px; }
.cbcs-dept-card-head h4 {
    font-family: 'Merriweather', Georgia, serif;
    font-size: 1rem;
    color: #5c1010;
    font-weight: 700;
    margin: 0 0 4px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: calc(1.4em * 2);
}
.cbcs-dept-school {
    font-size: .78rem;
    color: #5c1414;
    font-weight: 700;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.cbcs-dept-card-body { padding: 6px 18px 14px; flex-grow: 1; }
.cbcs-meta-row {
    font-size: .8rem;
    font-weight: 700;
    color: #555;
    margin: 5px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.cbcs-meta-row i { color: #8B1A1A; width: 14px; text-align: center; }

.cbcs-level-badges {
    display: flex;
    gap: 6px;
    margin-top: 8px;
}
.cbcs-level-badge {
    display: inline-block;
    font-size: .68rem;
    font-weight: 800;
    letter-spacing: .04em;
    padding: 3px 9px;
    border-radius: 20px;
    line-height: 1.4;
}
.badge-ug { background: rgba(139,26,26,.1);  color: #8B1A1A; border: 1px solid rgba(139,26,26,.25); }
.badge-pg { background: rgba(92,16,16,.1);   color: #5c1010; border: 1px solid rgba(92,16,16,.25); }
.badge-na { background: #f3ede3; color: #999; border: 1px solid #e4d8c4; }

.cbcs-dept-card-foot {
    padding: 12px 18px;
    border-top: 1px solid #f3f4f6;
}
.cbcs-view-btn {
    width: 100%;
    background: #fdfaf6;
    border: 1px solid #c9a84c;
    color: #5c1010;
    padding: 9px;
    border-radius: 6px;
    font-size: .82rem;
    font-weight: 700;
    cursor: pointer;
    transition: .2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.cbcs-view-btn:hover,
.cbcs-view-btn.open {
    background: #8B1A1A;
    color: #fff;
    border-color: #8B1A1A;
}
.cbcs-view-btn[disabled] {
    opacity: .45;
    cursor: not-allowed;
}
.cbcs-view-btn[disabled]:hover { background: #fdfaf6; color: #5c1010; }
.cbcs-inline-wrap {
    background: #fff;
    border: 2px solid #c9a84c;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(92,16,16,.12);
    margin-top: 4px;
    margin-bottom: 4px;
    /* Animated entrance */
    animation: cbcs-slide-in .22s ease;
}
@keyframes cbcs-slide-in {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}

.cbcs-inline-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    padding: 18px 24px 14px;
    background: linear-gradient(135deg, #fdfaf6 0%, #f8f2e8 100%);
    border-bottom: 1px solid #ede4d4;
}
.cbcs-inline-title {
    font-family: 'Merriweather', Georgia, serif;
    font-size: 1.1rem;
    color: #5c1010;
    font-weight: 700;
    margin: 0 0 4px;
}
.cbcs-inline-sub { font-size: .8rem; color: #888; margin: 0; }
.cbcs-inline-header-right {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
}
.cbcs-count-badge {
    display: inline-block;
    background: linear-gradient(135deg, #5c1010, #8B1A1A);
    color: #fff;
    font-size: .73rem;
    font-weight: 700;
    padding: 4px 14px;
    border-radius: 20px;
    white-space: nowrap;
}
.cbcs-inline-close {
    background: none;
    border: none;
    color: #aaa;
    font-size: 1.1rem;
    cursor: pointer;
    padding: 4px 6px;
    border-radius: 4px;
    transition: color .15s;
}
.cbcs-inline-close:hover { color: #8B1A1A; }
.cbcs-table-scroll { overflow-x: auto; }
.cbcs-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .84rem;
}
.cbcs-table thead tr {
    background: linear-gradient(90deg, #5c1010, #8B1A1A);
}
.cbcs-table th {
    color: #fff;
    padding: 12px 20px;
    font-size: .73rem;
    font-weight: 700;
    letter-spacing: .05em;
    text-transform: uppercase;
    white-space: nowrap;
}
.cbcs-table th.col-code    { text-align: left;   width: 18%; }
.cbcs-table th.col-title   { text-align: left; }
.cbcs-table th.col-level   { text-align: center; width: 9%; }
.cbcs-table th.col-sem     { text-align: center; width: 10%; }
.cbcs-table th.col-credits { text-align: center; width: 10%; }

.cbcs-table td {
    padding: 12px 20px;
    border-bottom: 1px solid #f4ede0;
    vertical-align: middle;
    line-height: 1.45;
}
.cbcs-table .col-code    { text-align: left; }
.cbcs-table .col-title   { text-align: left; color: #fffff; font-weight: 500; }
.cbcs-table .col-level   { text-align: center; }
.cbcs-table .col-sem     { text-align: center; color: #fffff; }
.cbcs-table .col-credits { text-align: center; }

.cbcs-table .row-even td { background: #fff; }
.cbcs-table .row-odd  td { background: #fdfaf6; }
.cbcs-table tr:last-child td { border-bottom: none; }
.cbcs-table tr:hover td { background: #fdf5e6 !important; }

.code-chip {
    display: inline-block;
    background: #f3ede3;
    color: #8B1A1A;
    font-family: 'Courier New', monospace;
    font-size: .75rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 5px;
    border: 1px solid #e4d8c4;
    white-space: nowrap;
}
.credit-pill {
    display: inline-block;
    background: rgba(201,168,76,.15);
    color: #7a5e1a;
    font-size: .73rem;
    font-weight: 700;
    padding: 3px 11px;
    border-radius: 20px;
    border: 1px solid rgba(201,168,76,.4);
}
.cbcs-state-row {
    text-align: center;
    color: #aaa;
    padding: 36px 20px !important;
    font-size: .88rem;
    font-style: italic;
}
.cbcs-empty { color: #ccc; }
.cbcs-spinner {
    display: inline-block;
    width: 15px; height: 15px;
    border: 2px solid #e8dfd0;
    border-top-color: #8B1A1A;
    border-radius: 50%;
    animation: cbcs-spin .7s linear infinite;
    vertical-align: middle;
    margin-right: 7px;
}
@keyframes cbcs-spin { to { transform: rotate(360deg); } }
.cbcs-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    padding: 16px 20px;
    border-top: 1px solid #f0e8d8;
    background: #fdfaf6;
    flex-wrap: wrap;
}
.cbcs-page-btn {
    min-width: 36px;
    height: 36px;
    padding: 0 10px;
    border: 1.5px solid #e0d4c0;
    border-radius: 7px;
    background: #fff;
    color: #555;
    font-size: .82rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .15s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.cbcs-page-btn:hover:not([disabled]) {
    border-color: #c9a84c;
    color: #5c1010;
}
.cbcs-page-btn.active {
    background: #8B1A1A;
    border-color: #8B1A1A;
    color: #fff;
    box-shadow: 0 2px 8px rgba(139,26,26,.28);
}
.cbcs-page-btn[disabled] { opacity: .3; cursor: not-allowed; }
.cbcs-page-ellipsis {
    color: #ccc;
    font-size: .85rem;
    padding: 0 4px;
    line-height: 36px;
}
.cbcs-no-data { color: #888; padding: 20px 0; }
@media (max-width: 768px) {
    .cbcs-filter-bar { padding: 16px; gap: 16px; }
    .cbcs-dept-grid  { grid-template-columns: 1fr 1fr; gap: 12px; }
    .cbcs-inline-header { padding: 14px 16px 10px; flex-direction: column; }
    .cbcs-table th,
    .cbcs-table td  { padding: 10px 12px; }
    .cbcs-select, .cbcs-search-input { min-width: 0; width: 100%; }
    .cbcs-filter-group { width: 100%; }
}
@media (max-width: 480px) {
    .cbcs-dept-grid { grid-template-columns: 1fr; }
}
</style>

<?php get_footer(); ?>