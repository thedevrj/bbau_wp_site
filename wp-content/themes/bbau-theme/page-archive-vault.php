<?php
/**
 * Template Name: Archive Vault
 *
 */

get_header();

$media_base = getenv('DJANGO_MEDIA_URL');
?>

<div class="notice-portal-brand">

    <?php get_template_part('banners/new-banner'); ?>

    <div class="container py-5">

        <!-- ── UNAUTHENTICATED STATE ─────────────────────────────────── -->
        <div id="vault-locked-screen" class="text-center py-5">
            <div class="sc-content-card mx-auto" style="max-width:460px;">
                <i class="fa-solid fa-vault fa-3x mb-3" style="color:var(--sc-gold,#b8960c);"></i>
                <h2 class="">Archive Vault</h2>
                <p class="text-muted mb-4">Historical records are restricted to authorized University personnel. Please
                    authenticate to proceed.</p>
                <button class="btn sc-btn-midnight w-100" onclick="toggleModal('login-modal', true)">
                    <i class="fa-solid fa-user-lock me-2"></i> Authenticate to Access
                </button>
            </div>
        </div>

        <!-- ── AUTHENTICATED STATE ────────────────────────────────────── -->
        <div id="vault-open-screen" class="d-none">

            <!-- TOP BAR -->
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="sc-user-avatar" style="width:40px;height:40px;font-size:.9rem;">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div>
                        <p class="mb-0 fw-semibold" id="logged-username">User</p>
                        <span class="sc-status-dot" style="font-size:.75rem;">Verified Session</span>
                    </div>
                </div>
                <button class="btn btn-outline-danger btn-sm" id="btn-logout">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Sign Out
                </button>
            </div>

            <div class="row g-4">

                <!-- ── LEFT: GROUPED ACCORDION NAVIGATION ──────────── -->
                <div class="col-lg-3">
                    <aside class="sc-sidebar">
                        <h2 class="sc-section-title">Vault Categories</h2>

                        <!-- Group: General -->
                        <div class="vault-group mb-2">
                            <button class="vault-group-header" data-bs-toggle="collapse" data-bs-target="#grp-general">
                                <i class="fa-solid fa-layer-group me-2"></i> General
                                <i class="fa-solid fa-chevron-down vault-chevron ms-auto"></i>
                            </button>
                            <div class="collapse show" id="grp-general">
                                <div class="vault-group-body">
                                    <a href="#" class="vault-nav-item active" data-endpoint="/archived-global-notices/"
                                        data-label="General Notices Archive">
                                        <i class="fa-solid fa-bullhorn me-2 text-muted"></i> General Notices
                                    </a>
                                    <a href="#" class="vault-nav-item" data-endpoint="/archived-mous/"
                                        data-label="MOUs Archive">
                                        <i class="fa-solid fa-handshake me-2 text-muted"></i> MOUs
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Group: Admission -->
                        <div class="vault-group mb-2">
                            <button class="vault-group-header" data-bs-toggle="collapse"
                                data-bs-target="#grp-admission">
                                <i class="fa-solid fa-graduation-cap me-2"></i> Admission
                                <i class="fa-solid fa-chevron-down vault-chevron ms-auto"></i>
                            </button>
                            <div class="collapse" id="grp-admission">
                                <div class="vault-group-body">
                                    <a href="#" class="vault-nav-item" data-endpoint="/admission/archived-notices/"
                                        data-label="Admission Notices Archive">
                                        <i class="fa-solid fa-bell me-2 text-muted"></i> Notices
                                    </a>
                                    <a href="#" class="vault-nav-item"
                                        data-endpoint="/admission/archived-committee-minutes/"
                                        data-label="Admission Committee Minutes Archive">
                                        <i class="fa-solid fa-file-signature me-2 text-muted"></i> Committee Minutes
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Group: Authorities -->
                        <div class="vault-group mb-2">
                            <button class="vault-group-header" data-bs-toggle="collapse" data-bs-target="#grp-auth">
                                <i class="fa-solid fa-building-columns me-2"></i> Authorities
                                <i class="fa-solid fa-chevron-down vault-chevron ms-auto"></i>
                            </button>
                            <div class="collapse" id="grp-auth">
                                <div class="vault-group-body">
                                    <a href="#" class="vault-nav-item"
                                        data-endpoint="/authorities/archived-board-of-management-minutes/"
                                        data-label="Board of Management Minutes Archive">
                                        <i class="fa-solid fa-users-gear me-2 text-muted"></i> BoM Minutes
                                    </a>
                                    <a href="#" class="vault-nav-item"
                                        data-endpoint="/authorities/archived-academic-council-minutes/"
                                        data-label="Academic Council Minutes Archive">
                                        <i class="fa-solid fa-book-open-reader me-2 text-muted"></i> Academic Council
                                    </a>
                                    <a href="#" class="vault-nav-item"
                                        data-endpoint="/authorities/archived-planning-board-minutes/"
                                        data-label="Planning Board Minutes Archive">
                                        <i class="fa-solid fa-chalkboard-user me-2 text-muted"></i> Planning Board
                                    </a>
                                    <a href="#" class="vault-nav-item"
                                        data-endpoint="/authorities/archived-finance-committee-minutes/"
                                        data-label="Finance Committee Minutes Archive">
                                        <i class="fa-solid fa-coins me-2 text-muted"></i> Finance Committee
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Group COE -->

                        <!-- Group COE -->
                        <div class="vault-group mb-2">
                            <button class="vault-group-header" data-bs-toggle="collapse" data-bs-target="#grp-coe">
                                <i class="fa-solid fa-building-columns me-2"></i> Controller of Examinations
                                <i class="fa-solid fa-chevron-down vault-chevron ms-auto"></i>
                            </button>

                            <div class="collapse" id="grp-coe">
                                <div class="vault-group-body">

                                    <a href="#" class="vault-nav-item" data-endpoint="/coe/archived-coe-notices/"
                                        data-label="COE Notice Archive">
                                        <i class="fa-solid fa-bell me-2 text-muted"></i>
                                        COE Notices
                                    </a>

                                    <a href="#" class="vault-nav-item"
                                        data-endpoint="/coe/archived-mphil-viva-voce-dates/"
                                        data-label="Mphil Viva Voce Archive">
                                        <i class="fa-solid fa-user-graduate me-2 text-muted"></i>
                                        M.Phil Viva Voce
                                    </a>

                                    <a href="#" class="vault-nav-item"
                                        data-endpoint="/coe/archived-phd-viva-voce-dates/"
                                        data-label="Ph.D Viva Voce Archive">
                                        <i class="fa-solid fa-user-graduate me-2 text-muted"></i>
                                        Ph.D Viva Voce
                                    </a>

                                    <a href="#" class="vault-nav-item"
                                        data-endpoint="/coe/archived-phd-pre-submission-seminars/"
                                        data-label="Ph.D Pre Submission Seminar Archive">
                                        <i class="fa-solid fa-file-signature me-2 text-muted"></i>
                                        Pre Ph.D Submission Seminars
                                    </a>

                                    <a href="#" class="vault-nav-item" data-endpoint="/coe/archived-rdcu-notices/"
                                        data-label="RDCU Notice Archive">
                                        <i class="fa-solid fa-flask me-2 text-muted"></i>
                                        RDCU Notice
                                    </a>

                                </div>
                            </div>
                        </div>


                        <!-- Group Proctor -->
                        <div class="vault-group mb-2">
                            <button class="vault-group-header" data-bs-toggle="collapse" data-bs-target="#grp-proctor">
                                <i class="fa-solid fa-user-shield me-2"></i> Proctor
                                <i class="fa-solid fa-chevron-down vault-chevron ms-auto"></i>
                            </button>

                            <div class="collapse" id="grp-proctor">
                                <div class="vault-group-body">

                                    <a href="#" class="vault-nav-item"
                                        data-endpoint="/proctor/archived-proctorial-board-notices/"
                                        data-label="Proctorial Boards Notice Archive">
                                        <i class="fa-solid fa-bullhorn me-2 text-muted"></i>
                                        Proctorial Board Notice
                                    </a>

                                    <a href="#" class="vault-nav-item"
                                        data-endpoint="/proctor/archived-proctorial-board-minutes/"
                                        data-label="Proctorial Board Minutes Archive">
                                        <i class="fa-solid fa-file-lines me-2 text-muted"></i>
                                        Proctorial Board Minutes
                                    </a>

                                </div>
                            </div>
                        </div>

                    </aside>
                </div>

                <!-- ── RIGHT: VIEWER ────────────────────────────────── -->
                <div class="col-lg-9">
                    <div class="sc-content-card">

                        <!-- Header row -->
                        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                            <h2 class="sc-section-title mb-0" id="current-view-title">General Notices Archive</h2>
                            <span class="sc-count-badge" id="result-count">0 records</span>
                        </div>

                        <!-- Filter Bar -->
                        <div class="row g-2 mb-4 vault-filter-bar">
                            <div class="col-md-5">
                                <div class="sc-search-wrap">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <input type="text" id="archive-search" class="form-control"
                                        placeholder="Search records...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="filter-year" class="form-select sc-select">
                                    <option value="">All Years</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="filter-sort" class="form-select sc-select">
                                    <option value="desc">Latest First</option>
                                    <option value="asc">Oldest First</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button id="reset-vault-filters" class="btn sc-btn-gold w-100" title="Reset Filters">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Records List -->
                        <div id="archive-list">
                            <div class="sc-shimmer"></div>
                            <div class="sc-shimmer"></div>
                            <div class="sc-shimmer"></div>
                        </div>

                        <!-- Pagination -->
                        <div id="vault-pagination" class="vault-pagination mt-3"></div>
                    </div>
                </div>

            </div><!-- /row -->
        </div><!-- /vault-open-screen -->

    </div>
</div>

<!-- ── STYLES ─────────────────────────────────────────────────────── -->
<style>
/* Vault Group Navigation */
.vault-group {
    border: 1px solid #e4e4e4;
    border-radius: 10px;
    overflow: hidden;
}

.vault-group-header {
    display: flex;
    align-items: center;
    width: 100%;
    background: #f7f7f5;
    border: none;
    padding: .7rem 1rem;
    font-weight: 600;
    font-size: .88rem;
    cursor: pointer;
    color: #1a2140;
    transition: background .2s;
}

.vault-group-header:hover {
    background: #eee;
}

.vault-chevron {
    transition: transform .3s;
}

.vault-group-header[aria-expanded="false"] .vault-chevron {
    transform: rotate(-90deg);
}

.vault-group-body {
    padding: .4rem .5rem;
    background: #fff;
}

.vault-group .collapse:not(.show) {
    display: none;
}

.vault-nav-item {
    display: flex;
    align-items: center;
    padding: .55rem .75rem;
    border-radius: 8px;
    font-size: .85rem;
    color: #444;
    text-decoration: none;
    transition: background .15s, color .15s;
}

.vault-nav-item:hover {
    background: #f0f4ff;
    color: #1a2140;
}

.vault-nav-item.active {
    background: #1a2140;
    color: #fff !important;
    font-weight: 600;
}

.vault-nav-item.active .text-muted {
    color: rgba(255, 255, 255, .7) !important;
}

/* Filter bar */
.vault-filter-bar .sc-select {
    border-radius: 8px;
    font-size: .875rem;
}

/* Archive record card */
.vault-record-card {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: .9rem 1rem;
    border-radius: 10px;
    border: 1px solid #ececec;
    text-decoration: none;
    color: inherit !important;
    transition: box-shadow .2s, border-color .2s;
    margin-bottom: .6rem;
    background: #fff;
}

.vault-record-card:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, .08);
    border-color: #b8960c;
    color: #1a2140;
}

.vault-record-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #f0f4ff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1rem;
}

.vault-record-title {
    font-weight: 600;
    font-size: .9rem;
    margin-bottom: .25rem;
    line-height: 1.35;
}

.vault-record-meta {
    font-size: .78rem;
    color: #888;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.vault-record-meta span {
    display: flex;
    align-items: center;
    gap: 4px;
}

.vault-record-arrow {
    margin-left: auto;
    color: #ccc;
    align-self: center;
    font-size: .9rem;
    transition: color .2s;
}

.vault-record-card:hover .vault-record-arrow {
    color: #b8960c;
}

/* No-attachment state */
.vault-record-card.no-link {
    opacity: .65;
    cursor: default;
    pointer-events: none;
}

/* Pagination */
.vault-pagination {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: .5rem;
    padding-top: .75rem;
    border-top: 1px solid #ececec;
}

.vault-page-info {
    font-size: .8rem;
    color: #888;
}

.vault-page-btns {
    display: flex;
    gap: 4px;
    flex-wrap: wrap;
}

.vault-page-btn {
    min-width: 34px;
    height: 34px;
    border: 1px solid #ddd;
    background: #fff;
    border-radius: 7px;
    font-size: .82rem;
    cursor: pointer;
    color: #444;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 8px;
    transition: background .15s, border-color .15s, color .15s;
    text-decoration: none;
}

.vault-page-btn:hover {
    background: #f0f4ff;
    border-color: #b8960c;
    color: #1a2140;
}

.vault-page-btn.active {
    background: #1a2140;
    border-color: #1a2140;
    color: #fff;
    font-weight: 700;
}

.vault-page-btn:disabled {
    opacity: .4;
    cursor: not-allowed;
    pointer-events: none;
}

.vault-page-ellipsis {
    min-width: 28px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #aaa;
    font-size: .82rem;
}
</style>

<!-- Login Modal -->
<div class="sc-modal" id="login-modal">
    <div class="sc-modal-overlay" onclick="toggleModal('login-modal', false)"></div>
    <div class="sc-modal-box">
        <button class="sc-modal-close" onclick="toggleModal('login-modal', false)">&times;</button>
        <div class="sc-modal-header">
            <h3>Vault Authentication</h3>
            <p class="sc-modal-subtitle">Secure access for Faculty &amp; Staff</p>
        </div>
        <div class="sc-modal-body">
            <form id="staff-login-form">
                <div class="sc-input-group">
                    <label class="sc-input-label">Username</label>
                    <input type="text" name="username" class="sc-input" placeholder="Enter your Username" required
                        autocomplete="username">
                </div>
                <div class="sc-input-group">
                    <label class="sc-input-label">Password</label>
                    <input type="password" name="password" class="sc-input" placeholder="••••••••" required
                        autocomplete="current-password">
                </div>
                <div id="login-error" class="alert alert-danger d-none mb-4"></div>
                <button type="submit" class="btn-sc-submit" id="btn-login-submit">Unlock Vault</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mediaBase = "<?= $media_base ?>";
    const djangoBase = mediaBase;
    const apiBase = `${djangoBase}/api/v1`;

    /* ── Media URL resolver ─────────────────────────────────── */
    function resolveMediaUrl(path) {
        if (!path) return null;
        if (path.startsWith('http://') || path.startsWith('https://')) return path;
        return `${djangoBase}/media/${path.replace(/^\/?(media\/)?/, '')}`;
    }

    /* ── State ─────────────────────────────────────────────── */
    let allRecords = [];
    let currentEndpoint = '/archived-global-notices/';
    const initialPage = parseInt(new URLSearchParams(window.location.search).get('page'), 10);
    let currentPage = Number.isInteger(initialPage) && initialPage > 0 ? initialPage : 1;
    const PAGE_SIZE = 15;

    const listContainer = document.getElementById('archive-list');
    const searchInput = document.getElementById('archive-search');
    const yearSelect = document.getElementById('filter-year');
    const sortSelect = document.getElementById('filter-sort');
    const resetBtn = document.getElementById('reset-vault-filters');
    const viewTitle = document.getElementById('current-view-title');
    const resultCount = document.getElementById('result-count');
    const loggedUsername = document.getElementById('logged-username');
    const lockedScreen = document.getElementById('vault-locked-screen');
    const openScreen = document.getElementById('vault-open-screen');

    function updatePageUrl(page) {
        const url = new URL(window.location.href);
        if (page > 1) url.searchParams.set('page', page);
        else url.searchParams.delete('page');
        window.history.replaceState({ page }, '', url);
    }

    /* ── Accordion navigation (Bootstrap-independent) ───────── */
    function setGroupOpen(collapse, open) {
        collapse.classList.toggle('show', open);
        const header = document.querySelector(
            `.vault-group-header[data-bs-target="#${collapse.id}"]`
        );
        if (header) {
            header.setAttribute('aria-expanded', String(open));
        }
    }

    document.querySelectorAll('.vault-group-header').forEach(header => {
        const target = header.getAttribute('data-bs-target');
        const collapse = target ? document.querySelector(target) : null;
        if (!collapse) return;

        header.setAttribute('aria-expanded', String(collapse.classList.contains('show')));
        header.addEventListener('click', () => {
            setGroupOpen(collapse, !collapse.classList.contains('show'));
        });
    });

    /* ── Auth UI ───────────────────────────────────────────── */
    async function updateAuthUI() {
        const user = localStorage.getItem('portal_user');
        let authenticated = false;
        try {
            const session = await fetch(`${djangoBase}/portal/api/session/`, {
                credentials: 'include'
            });
            authenticated = session.ok;
        } catch (e) {}

        if (authenticated) {
            lockedScreen.classList.add('d-none');
            openScreen.classList.remove('d-none');
            loggedUsername.textContent = user || 'Authorized User';
            fetchArchives(currentEndpoint);
        } else {
            lockedScreen.classList.remove('d-none');
            openScreen.classList.add('d-none');
        }
    }

    /* ── Fetch ─────────────────────────────────────────────── */
    async function fetchArchives(endpoint) {
        listContainer.innerHTML = `
            <div class="sc-shimmer"></div>
            <div class="sc-shimmer"></div>
            <div class="sc-shimmer"></div>`;

        try {
            const res = await fetch(`${apiBase}${endpoint}?page_size=500`, {
                headers: {
                    // Authentication is provided by the HttpOnly cookie.
                },
                credentials: 'include'
            });

            if (res.status === 401 || res.status === 403) {
                updateAuthUI();
                return;
            }

            const data = await res.json();

            allRecords = (data.results || data || []).map(r => {
                const rawLink = r.attachment || r.file || r.document || r.link || null;

                const rawDate = r.archive_date ||
                    r.date_posted ||
                    r.date_of_signing ||
                    r.date_of_meeting ||
                    r.date ||
                    null;

                const title = r.title ||
                    r.organization_name ||
                    r.meeting_title ||
                    'Archived Record';

                let meta = 'Archived Document';
                if (r.categories && r.categories.length) {
                    meta = r.categories.join(', ');
                } else if (r.category_display) {
                    meta = r.category_display;
                } else if (r.Nature_of_organization) {
                    meta = r.Nature_of_organization;
                } else if (r.session_details && r.session_details.session_name) {
                    meta = r.session_details.session_name;
                }

                return {
                    title,
                    date: rawDate ? new Date(rawDate) : null,
                    link: resolveMediaUrl(rawLink),
                    meta
                };
            });

            populateYearFilter();
            render();
        } catch (e) {
            listContainer.innerHTML =
                '<p class="text-danger py-3"><i class="fa-solid fa-triangle-exclamation me-2"></i>Error securely retrieving records. Please try again.</p>';
        }
    }

    /* ── Year filter dropdown ── */
    function populateYearFilter() {
        const years = [...new Set(
            allRecords
            .filter(r => r.date)
            .map(r => r.date.getFullYear())
        )].sort((a, b) => b - a);

        yearSelect.innerHTML = '<option value="">All Years</option>' +
            years.map(y => `<option value="${y}">${y}</option>`).join('');
    }

    function render() {
        const search = searchInput.value.toLowerCase();
        const year = yearSelect.value ? parseInt(yearSelect.value) : null;
        const sortVal = sortSelect.value;

        let filtered = allRecords.filter(r => {
            const matchSearch = r.title.toLowerCase().includes(search);
            const matchYear = !year || (r.date && r.date.getFullYear() === year);
            return matchSearch && matchYear;
        });

        filtered.sort((a, b) => {
            const da = a.date ? a.date.getTime() : 0;
            const db = b.date ? b.date.getTime() : 0;
            return sortVal === 'asc' ? da - db : db - da;
        });

        const total = filtered.length;
        const totalPages = Math.ceil(total / PAGE_SIZE);

        // Clamp currentPage in case filters reduced total pages
        if (currentPage > totalPages) currentPage = Math.max(1, totalPages);
        updatePageUrl(currentPage);

        resultCount.textContent = `${total} record${total !== 1 ? 's' : ''}`;

        if (total === 0) {
            listContainer.innerHTML = `
                <div class="text-center py-5 text-muted">
                    <i class="fa-solid fa-box-open fa-2x mb-2"></i>
                    <p>No archived records match your filters.</p>
                </div>`;
            document.getElementById('vault-pagination').innerHTML = '';
            return;
        }

        // Slice for current page
        const start = (currentPage - 1) * PAGE_SIZE;
        const paged = filtered.slice(start, start + PAGE_SIZE);

        listContainer.innerHTML = paged.map(r => {
            const dateStr = r.date ? r.date.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            }) : '—';
            const hasLink = r.link && r.link !== '#';
            return `
            <a href="${hasLink ? r.link : '#'}" target="${hasLink ? '_blank' : '_self'}"
               class="vault-record-card${!hasLink ? ' no-link' : ''}">
                <div class="vault-record-icon">
                    <i class="fa-solid fa-file-pdf" style="color:#c0392b;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="vault-record-title">${r.title}</div>
                    <div class="vault-record-meta">
                        <span><i class="fa-solid fa-tag"></i> ${r.meta}</span>
                        <span><i class="fa-solid fa-calendar-days"></i> ${dateStr}</span>
                        ${!hasLink ? '<span style="color:#e67e22;"><i class="fa-solid fa-ban"></i> No attachment</span>' : ''}
                    </div>
                </div>
                ${hasLink ? '<i class="fa-solid fa-arrow-up-right-from-square vault-record-arrow"></i>' : ''}
            </a>`;
        }).join('');

        renderPagination(total, totalPages);
    }

    /* ── Pagination bar ─────────────────────────────────────── */
    function renderPagination(total, totalPages) {
        const paginEl = document.getElementById('vault-pagination');
        if (totalPages <= 1) {
            paginEl.innerHTML = '';
            return;
        }

        const start = (currentPage - 1) * PAGE_SIZE + 1;
        const end = Math.min(currentPage * PAGE_SIZE, total);

        // Build page numbers with ellipsis
        function pageButtons() {
            const pages = [];
            const delta = 2; // pages shown around current

            let left = Math.max(2, currentPage - delta);
            let right = Math.min(totalPages - 1, currentPage + delta);

            pages.push(1); // always first

            if (left > 2) pages.push('...');

            for (let i = left; i <= right; i++) pages.push(i);

            if (right < totalPages - 1) pages.push('...');

            if (totalPages > 1) pages.push(totalPages); // always last

            return pages.map(p => {
                if (p === '...') return `<span class="vault-page-ellipsis">…</span>`;
                return `<button class="vault-page-btn${p === currentPage ? ' active' : ''}" data-page="${p}">${p}</button>`;
            }).join('');
        }

        paginEl.innerHTML = `
            <span class="vault-page-info">Showing ${start}–${end} of ${total}</span>
            <div class="vault-page-btns">
                <button class="vault-page-btn" data-page="${currentPage - 1}" ${currentPage === 1 ? 'disabled' : ''}>
                    <i class="fa-solid fa-chevron-left" style="font-size:.7rem;"></i>
                </button>
                ${pageButtons()}
                <button class="vault-page-btn" data-page="${currentPage + 1}" ${currentPage === totalPages ? 'disabled' : ''}>
                    <i class="fa-solid fa-chevron-right" style="font-size:.7rem;"></i>
                </button>
            </div>`;

        // Attach click handlers
        paginEl.querySelectorAll('.vault-page-btn[data-page]').forEach(btn => {
            btn.addEventListener('click', () => {
                const p = parseInt(btn.getAttribute('data-page'));
                if (!isNaN(p) && p >= 1 && p <= totalPages) {
                    currentPage = p;
                    updatePageUrl(currentPage);
                    render();
                    // Scroll list into view
                    listContainer.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    /* ── Sidebar navigation ─────────────────────────────────── */
    document.querySelectorAll('.vault-nav-item').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            document.querySelectorAll('.vault-nav-item').forEach(b => b.classList.remove(
                'active'));
            btn.classList.add('active');

            currentEndpoint = btn.getAttribute('data-endpoint');
            viewTitle.textContent = btn.getAttribute('data-label') || 'Archive';
            searchInput.value = '';
            yearSelect.value = '';
            sortSelect.value = 'desc';
            currentPage = 1;

            /* Open the parent collapse group */
            const parentCollapse = btn.closest('.collapse');
            if (parentCollapse && !parentCollapse.classList.contains('show')) {
                setGroupOpen(parentCollapse, true);
            }

            fetchArchives(currentEndpoint);
        });
    });

    /* ── Filters — always reset to page 1 ──────────────────── */
    function filterChanged() {
        currentPage = 1;
        render();
    }

    searchInput.addEventListener('input', filterChanged);
    yearSelect.addEventListener('change', filterChanged);
    sortSelect.addEventListener('change', filterChanged);
    resetBtn.addEventListener('click', () => {
        searchInput.value = '';
        yearSelect.value = '';
        sortSelect.value = 'desc';
        filterChanged();
    });

    /* ── Login ───────────────────────────────────────────────── */
    document.getElementById('staff-login-form').addEventListener('submit', async e => {
        e.preventDefault();
        const fd = Object.fromEntries(new FormData(e.target).entries());
        const loginError = document.getElementById('login-error');
        loginError.classList.add('d-none');

        try {
            const res = await fetch(`${djangoBase}/portal/api/login/`, {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(fd)
            });
            const resData = await res.json();

            if (res.ok) {
                if (resData.force_password_change) {
                    loginError.textContent =
                        "Please update your password on the Notice Portal first.";
                    loginError.classList.remove('d-none');
                    return;
                }
                localStorage.setItem('portal_user', fd.username);
                toggleModal('login-modal', false);
                updateAuthUI();
            } else {
                loginError.textContent = resData.detail || "Authentication failed.";
                loginError.classList.remove('d-none');
            }
        } catch {
            loginError.textContent = "Network error. Please try again.";
            loginError.classList.remove('d-none');
        }
    });

    document.getElementById('btn-logout').addEventListener('click', () => {
        fetch(`${djangoBase}/portal/logout/`, {
            method: 'POST',
            credentials: 'include',
            headers: {
                'X-CSRFToken': document.cookie.split('; ').find(row => row.startsWith('csrftoken='))?.split('=')[1] || ''
            }
        }).finally(() => {
            localStorage.removeItem('portal_user');
            updateAuthUI();
        });
    });

    updateAuthUI();
});

function toggleModal(id, show) {
    document.getElementById(id).classList.toggle('active', show);
}
</script>

<?php get_footer(); ?>
