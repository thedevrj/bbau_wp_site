<?php
/**
 * Template Name: Proctorial Board Members & Minutes Page
 */
defined('ABSPATH') || exit;

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');

$BBAU_PB_MEMBERS_API = $media_base . '/api/v1/proctor/proctorial-board-members/';
$BBAU_PB_MINUTES_API = $media_base . '/api/v1/proctor/proctorial-board-minutes/';

$members       = array();
$minutes       = array();
$members_error = '';
$minutes_error = '';


function bbau_pb_fetch_all($url, &$error) {

    $all      = array();
    $next_url = $url;
    $safety_i = 0;

    while ($next_url && $safety_i < 50) {

        $response = wp_remote_get($next_url, array('timeout' => 15));

        if (is_wp_error($response)) {
            $error = $response->get_error_message();
            break;
        }

        if (wp_remote_retrieve_response_code($response) !== 200) {
            $error = 'API Error : HTTP ' . wp_remote_retrieve_response_code($response);
            break;
        }

        $decoded = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($decoded['results']) && is_array($decoded['results'])) {
            $all      = array_merge($all, $decoded['results']);
            $next_url = !empty($decoded['next']) ? $decoded['next'] : null;
        } elseif (is_array($decoded)) {
            $all      = array_merge($all, $decoded);
            $next_url = null;
        } else {
            $next_url = null;
        }

        $safety_i++;
    }

    return $all;
}


$members_cache_key = 'bbau_pb_members_all';
$members_cached     = get_transient($members_cache_key);

if ($members_cached !== false) {
    $members = $members_cached;
} else {
    $members = bbau_pb_fetch_all($BBAU_PB_MEMBERS_API, $members_error);
    if (!$members_error) {
        set_transient($members_cache_key, $members, 10 * MINUTE_IN_SECONDS);
    }
}
$minutes_cache_key = 'bbau_pb_minutes_all';
$minutes_cached     = get_transient($minutes_cache_key);

if ($minutes_cached !== false) {
    $minutes = $minutes_cached;
} else {
    $minutes = bbau_pb_fetch_all($BBAU_PB_MINUTES_API, $minutes_error);
    if (!$minutes_error) {
        set_transient($minutes_cache_key, $minutes, 10 * MINUTE_IN_SECONDS);
    }
}

$bbau_pb_year_options = array();
if (!empty($minutes) && is_array($minutes)) {
    foreach ($minutes as $minute) {
        $date_raw = $minute['date_of_meeting'] ?? '';
        if (!$date_raw) {
            continue;
        }
        $ts = strtotime($date_raw);
        if (!$ts) {
            continue;
        }
        $year = date('Y', $ts);
        $bbau_pb_year_options[$year] = $year;
    }
    krsort($bbau_pb_year_options);
}

$bbau_pb_month_options = array(
    '01' => 'January',
    '02' => 'February',
    '03' => 'March',
    '04' => 'April',
    '05' => 'May',
    '06' => 'June',
    '07' => 'July',
    '08' => 'August',
    '09' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December',
);

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid page-bg py-5">

    <div class="container">

        <?php get_template_part('template-parts/breadcrumb'); ?>
        <?php get_template_part('menu/menu'); ?>

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
                                   <span class="toggle-icon"><i class="fa-solid fa-chevron-down"></i></span>
                                </div>
                            </div>

                            <div id="pbMembersPanel" class="accordion-collapse collapse show" data-bs-parent="#pbCommitteesAccordion">

                                <div class="committee-body">

                                    <table class="members-table" id="pbMembersTable">
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

                    <div class="pb-filter-bar">
                        <div class="pb-search-wrap">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="pbMinutesSearch" class="pb-search-input"
                                   placeholder="Search by name...">
                        </div>
                        <div class="pb-select-wrap">
                            <select id="pbMinutesYearFilter" class="pb-select-input">
                                <option value="">All Years</option>
                                <?php foreach ($bbau_pb_year_options as $year): ?>
                                    <option value="<?php echo esc_attr($year); ?>"><?php echo esc_html($year); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="pb-select-wrap">
                            <select id="pbMinutesMonthFilter" class="pb-select-input">
                                <option value="">All Months</option>
                                <?php foreach ($bbau_pb_month_options as $key => $label): ?>
                                    <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="button" id="pbMinutesClear" class="pb-clear-btn">
                            <i class="fa-solid fa-xmark"></i> Clear
                        </button>
                    </div>

                    <div class="section-card">

                        <div class="minutes-list-modern" id="pbMinutesList">

                            <?php foreach ($minutes as $minute): ?>

                                <?php
                                $title    = esc_html($minute['meeting_title'] ?? '');
                                $date_raw = $minute['date_of_meeting'] ?? '';
                                $day       = '';
                                $mon       = '';
                                $file      = '';
                                $year_key  = '';
                                $month_key = '';

                                if ($date_raw) {
                                    $ts = strtotime($date_raw);
                                    if ($ts) {
                                        $day       = date('d', $ts);
                                        $mon       = date('M', $ts);
                                        $year_key  = date('Y', $ts);
                                        $month_key = date('m', $ts);
                                    }
                                }

                                if (!empty($minute['file'])) {
                                    if (filter_var($minute['file'], FILTER_VALIDATE_URL)) {
                                        $file = $minute['file'];
                                    } else {
                                        $file = $media_base . $minute['file'];
                                    }
                                }

                                $search_blob = mb_strtolower(trim($minute['meeting_title'] ?? ''));
                                ?>

                                <a class="minute-row"
                                   data-search="<?php echo esc_attr($search_blob); ?>"
                                   data-year="<?php echo esc_attr($year_key); ?>"
                                   data-month="<?php echo esc_attr($month_key); ?>"
                                   <?php if ($file): ?>href="<?php echo esc_url($file); ?>" target="_blank" rel="noopener"<?php endif; ?>>

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

                        <div class="pb-no-results" id="pbMinutesNoResults" style="display:none;">
                            No minutes match your filters.
                        </div>

                        <nav class="pb-pagination" aria-label="Minutes pagination">
                            <button type="button" class="pb-page-btn pb-prev" disabled>
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <div class="pb-page-numbers"></div>
                            <button type="button" class="pb-page-btn pb-next">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </nav>

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
    font-weight: 700;
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
.pb-filter-bar{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
    margin-top:20px;
}

.pb-search-wrap{
    position:relative;
    flex:1 1 200px;
    min-width:180px;
}

.pb-search-wrap i{
    position:absolute;
    left:18px;
    top:50%;
    transform:translateY(-50%);
    color:#9691a8;
    font-size:15px;
    pointer-events:none;
}

.pb-search-input{
    width:100%;
    padding:10px 15px 10px 41px !important;
    border:1px solid #ddd9ec;
    border-radius:999px !important;
    font-size:0.95rem;
    color:#333;
    background:#fff;
    outline:none;
    transition:.2s;
}

.pb-search-input::placeholder{
    color:#9691a8;
}

.pb-search-input:focus{
    border-color:#b7b0d6;
    box-shadow:0 0 0 3px rgba(155,145,200,0.12);
}

.pb-select-wrap{
    position:relative;
    flex:0 0 auto;
}

.pb-select-input{
    padding:10px 34px 10px 18px;
    border:1px solid #d9d9d9;
    border-radius:999px;
    font-size:0.9rem;
    color:#5c1010;
    font-weight:600;
    background:#fff url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%235c1010' d='M1 1l5 5 5-5'/%3E%3C/svg%3E") no-repeat right 14px center;
    outline:none;
    cursor:pointer;
    appearance:none;
    -webkit-appearance:none;
    min-width:130px;
}

.pb-select-input:focus{
    border-color:#8B1A1A;
    box-shadow:0 0 0 3px rgba(139,26,26,0.10);
}

.pb-clear-btn{
    display:flex;
    align-items:center;
    gap:6px;
    padding:10px 18px;
    border:1px solid #d9d9d9;
    border-radius:999px;
    background:#fff;
    color:#5c1010;
    font-size:0.9rem;
    font-weight:600;
    cursor:pointer;
    transition:.2s;
    flex:0 0 auto;
    white-space:nowrap;
}

.pb-clear-btn i{
    font-size:11px;
    color:#8B1A1A;
}

.pb-clear-btn:hover{
    background:#fdfbf7;
    border-color:#8B1A1A;
}

.pb-no-results{
    text-align:center;
    padding:20px;
    color:#777;
    font-size:0.9rem;
    font-style:italic;
}

@media (max-width: 577px){
    .pb-filter-bar{
        gap:8px;
    }
    .pb-search-wrap{
        flex:1 1 100%;
    }
    .pb-select-wrap{
        flex:1 1 auto;
    }
    .pb-select-input{
        width:100%;
        min-width:0;
    }
    .pb-clear-btn{
        flex:1 1 auto;
        justify-content:center;
    }
}

.pb-pagination{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    margin-top:20px;
    flex-wrap:wrap;
}

.pb-page-btn{
    width:38px;
    height:38px;
    border-radius:8px;
    border:1px solid #5c1010;
    background:#fff;
    color:#5c1010;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    transition:.2s;
    flex-shrink:0;
}

.pb-page-btn:hover:not(:disabled){
    background:#5c1010;
    color:#fff;
}

.pb-page-btn:disabled{
    opacity:.4;
    cursor:not-allowed;
}

.pb-page-numbers{
    display:flex;
    align-items:center;
    gap:6px;
    flex-wrap:wrap;
    justify-content:center;
}

.pb-page-num{
    min-width:38px;
    height:38px;
    padding:0 10px;
    border-radius:8px;
    border:1px solid #ddd;
    background:#fff;
    color:#1a1a1a;
    font-weight:600;
    cursor:pointer;
    transition:.2s;
    flex-shrink:0;
}

.pb-page-num:hover{
    border-color:#5c1010;
}

.pb-page-num.active{
    background:#c9a84c;
    border-color:#c9a84c;
    color:#5c1010;
}

.pb-page-num.ellipsis{
    cursor:default;
    border:none;
    background:transparent;
    min-width:20px;
}

@media (max-width: 577px){

    .pb-pagination{
        gap:6px;
        margin-top:16px;
    }

    .pb-page-btn{
        width:32px;
        height:32px;
        font-size:13px;
    }

    .pb-page-numbers{
        gap:4px;
    }

    .pb-page-num{
        min-width:32px;
        height:32px;
        padding:0 8px;
        font-size:13px;
    }

    .pb-page-num.ellipsis{
        min-width:14px;
        padding:0 2px;
    }
}

@media (max-width: 360px){

    .pb-page-btn{
        width:30px;
        height:30px;
        font-size:12px;
    }

    .pb-page-num{
        min-width:30px;
        height:30px;
        padding:0 6px;
        font-size:12px;
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

    const minutesWrap   = document.getElementById('pbMinutesList');
    if (!minutesWrap) return;

    const minutesSearchInput = document.getElementById('pbMinutesSearch');
    const yearFilterSelect   = document.getElementById('pbMinutesYearFilter');
    const monthFilterSelect  = document.getElementById('pbMinutesMonthFilter');
    const clearBtn           = document.getElementById('pbMinutesClear');
    const minutesNoResults   = document.getElementById('pbMinutesNoResults');

    const allRows      = Array.prototype.slice.call(minutesWrap.querySelectorAll('.minute-row'));
    const perPage       = 20;
    let filteredRows   = allRows.slice();
    let currentPage    = 1;

    const pagination   = document.querySelector('.pb-pagination');
    const numbersWrap  = pagination ? pagination.querySelector('.pb-page-numbers') : null;
    const prevBtn      = pagination ? pagination.querySelector('.pb-prev') : null;
    const nextBtn       = pagination ? pagination.querySelector('.pb-next') : null;

    function applyFilters() {
        const q     = minutesSearchInput ? minutesSearchInput.value.trim().toLowerCase() : '';
        const year  = yearFilterSelect ? yearFilterSelect.value : '';
        const month = monthFilterSelect ? monthFilterSelect.value : '';

        filteredRows = allRows.filter(function (row) {
            const haystack = row.getAttribute('data-search') || '';
            const rowYear  = row.getAttribute('data-year') || '';
            const rowMonth = row.getAttribute('data-month') || '';

            const matchesSearch = !q || haystack.indexOf(q) !== -1;
            const matchesYear   = !year || rowYear === year;
            const matchesMonth  = !month || rowMonth === month;

            return matchesSearch && matchesYear && matchesMonth;
        });

        allRows.forEach(function (row) {
            row.style.display = 'none';
        });

        currentPage = 1;
        renderPage();
    }

    function renderPage() {
        const totalPages = Math.max(1, Math.ceil(filteredRows.length / perPage));
        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * perPage;
        const end   = start + perPage;

        allRows.forEach(function (row) {
            row.style.display = 'none';
        });

        filteredRows.slice(start, end).forEach(function (row) {
            row.style.display = '';
        });

        if (minutesNoResults) {
            minutesNoResults.style.display = filteredRows.length === 0 ? '' : 'none';
        }

        if (pagination) {
            pagination.style.display = (totalPages <= 1) ? 'none' : 'flex';
            renderNumbers(totalPages);
        }
    }

    function renderNumbers(totalPages) {
        if (!numbersWrap) return;
        numbersWrap.innerHTML = '';

        const pagesToShow = [];
        const delta = 1;

        for (let p = 1; p <= totalPages; p++) {
            if (p === 1 || p === totalPages || (p >= currentPage - delta && p <= currentPage + delta)) {
                pagesToShow.push(p);
            }
        }

        let lastPushed = 0;
        pagesToShow.forEach(function (p) {
            if (lastPushed && p - lastPushed > 1) {
                const dots = document.createElement('span');
                dots.className = 'pb-page-num ellipsis';
                dots.textContent = '…';
                numbersWrap.appendChild(dots);
            }

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'pb-page-num' + (p === currentPage ? ' active' : '');
            btn.textContent = p;
            btn.addEventListener('click', function () {
                currentPage = p;
                renderPage();
            });
            numbersWrap.appendChild(btn);

            lastPushed = p;
        });

        if (prevBtn) prevBtn.disabled = currentPage === 1;
        if (nextBtn) nextBtn.disabled = currentPage === totalPages;
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function () {
            if (currentPage > 1) {
                currentPage--;
                renderPage();
            }
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function () {
            const totalPages = Math.max(1, Math.ceil(filteredRows.length / perPage));
            if (currentPage < totalPages) {
                currentPage++;
                renderPage();
            }
        });
    }

    if (minutesSearchInput) {
        minutesSearchInput.addEventListener('input', applyFilters);
    }

    if (yearFilterSelect) {
        yearFilterSelect.addEventListener('change', applyFilters);
    }

    if (monthFilterSelect) {
        monthFilterSelect.addEventListener('change', applyFilters);
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            if (minutesSearchInput) minutesSearchInput.value = '';
            if (yearFilterSelect) yearFilterSelect.value = '';
            if (monthFilterSelect) monthFilterSelect.value = '';
            applyFilters();
        });
    }

    applyFilters();
});
</script>

<?php get_footer(); ?>