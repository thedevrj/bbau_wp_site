<?php
/**
 * Template Name: Doctoral Research
 */

get_header();

$api_base = getenv('DJANGO_MEDIA_URL');

?>

<main id="primary" class="site-main research-portal">
    <!-- PREMIUM HERO BANNER -->
    <section class="premium-hero-rd1 mb-4">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content-glass1 animate-up">
                <div class="badge-new-rd1">Advanced Scholarship</div>
                <h1 style="font-size: 2.0rem;">Doctoral Research</h1>
            </div>
        </div>
    </section>
    <div id="main-content"></div>

    <div class="research-container container ">
        <?php get_template_part('template-parts/breadcrumb');?>

        <!-- PREMIUM GLASS FILTERS -->
        <div class="ra-glass-filters animate-up mt-4" style="animation-delay: 0.1s;">
            <div class="ra-search-box">
                <i class="fas fa-search ra-search-icon"></i>
                <input type="text" id="scholar-search"
                    placeholder="Search by name, topic, or enrollment no, supervisior.." autocomplete="off">
            </div>

            <div class="ra-filter-group">
                <div class="filter-item">
                    <label>Department</label>
                    <select id="dept-filter" class="ra-select">
                        <option value="">All Departments</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label>Status</label>
                    <select id="status-filter" class="ra-select">
                        <option value="">By Status</option>
                        <option value="Pursuing">Pursuing</option>
                        <option value="Thesis Submitted">Thesis Submitted</option>
                        <option value="Awarded">Awarded</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label id="start-date-label">From Date</label>
                    <input type="date" id="start-date" class="ra-select">
                </div>
                <div class="filter-item">
                    <label id="end-date-label">To Date</label>
                    <input type="date" id="end-date" class="ra-select">
                </div>
                <a href="<?php echo esc_url(get_permalink()); ?>" class="btn-fac-profile">Reset</a>
            </div>
        </div>

        <!-- MAIN CONTENT CARD -->
        <div class="rd-card-premium mt-5 animate-up mb-4" style="animation-delay: 0.2s;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="rd-section-title m-0">PhD Scholar Directory</h2>
                <span class="badge bg-light text-dark px-3 py-2 border rounded-pill" id="record-count"
                    style="font-weight: 700; font-size: 0.8rem;">
                    Syncing directory...
                </span>
            </div>

            <div class="table-responsive">
                <table class="premium-table" id="scholars-table">
                    <thead>
                        <tr>
                            <th>Scholar Details</th>
                            <th>Enrollment</th>
                            <th>Title</th>
                            <th>Supervisor(s)</th>
                            <th>Status</th>
                            <th class="text-center">Year of Reg.</th>
                            <th class="text-center"> Date of Award</th>
                        </tr>
                    </thead>
                    <tbody id="scholars-tbody">
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="rd-loader"></div>
                                <p class="mt-3 text-muted">Retrieving scholarship records...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="pagination-controls" class="pagination-wrapper"></div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Parse department from URL query parameters
    const urlParams = new URLSearchParams(window.location.search);
    const deptParam = urlParams.get('department') || urlParams.get('department_slug') || '';

    // --- DYNAMIC FILTERS ---
    async function loadDynamicFilters() {
        try {
            const apiBase = "<?php echo esc_js($api_base); ?>";
            const deptFilter = document.getElementById('dept-filter');

            if (deptFilter) {
                const dRes = await fetch(`${apiBase}/api/v1/departments/?page_size=500`);
                if (dRes.ok) {
                    const depts = await dRes.json();
                    const dData = depts.results || depts;
                    dData.forEach(d => {
                        const displayName = d.campus === 'Satellite Campus Amethi' ?
                            `${d.name} (Amethi)` : d.name;
                        deptFilter.innerHTML += `<option value="${d.slug}">${displayName}</option>`;
                    });
                    if (deptParam) {
                        deptFilter.value = deptParam;
                    }
                }
            }
        } catch (e) {
            console.error("Filter Load Error:", e);
        }
    }
    loadDynamicFilters();

    const searchInput = document.getElementById('scholar-search');
    const deptFilter = document.getElementById('dept-filter');
    const statusFilter = document.getElementById('status-filter');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const startDateLabel = document.getElementById('start-date-label');
    const endDateLabel = document.getElementById('end-date-label');
    const tbody = document.getElementById('scholars-tbody');
    const recordCount = document.getElementById('record-count');
    const paginationControls = document.getElementById('pagination-controls');
    const apiBase = "<?php echo esc_js($api_base); ?>";

    let debounceTimer;

    function updateDateLabels() {
        const status = statusFilter ? statusFilter.value : '';
        if (status === 'Awarded') {
            if (startDateLabel) startDateLabel.textContent = 'Award Date From';
            if (endDateLabel) endDateLabel.textContent = 'Award Date To';
        } else if (status === 'Thesis Submitted') {
            if (startDateLabel) startDateLabel.textContent = 'Submission Date From';
            if (endDateLabel) endDateLabel.textContent = 'Submission Date To';
        } else {
            if (startDateLabel) startDateLabel.textContent = 'Reg. Date From';
            if (endDateLabel) endDateLabel.textContent = 'Reg. Date To';
        }
    }

    function fetchScholars(url = null) {
        if (!url) {
            const query = searchInput.value.toLowerCase().trim();
            const dept = (deptFilter && deptFilter.options.length > 1) ? deptFilter.value : deptParam;
            const status = statusFilter.value;
            const start = startDate.value;
            const end = endDate.value;

            // Update the URL with the new department slug
            if (typeof dept !== 'undefined') {
                const currentUrl = new URL(window.location);
                if (dept) {
                    currentUrl.searchParams.set('department', dept);
                } else {
                    currentUrl.searchParams.delete('department');
                }

                // Reset page on filter change
                currentUrl.searchParams.delete('page');
                window.history.pushState({}, '', currentUrl);
            }

            url = `${apiBase}/api/v1/research-scholars/?page_size=10&`;
            const browserUrl = new URL(window.location);
            if (browserUrl.searchParams.has('page')) {
                url += `page=${browserUrl.searchParams.get('page')}&`;
            }
            if (query) url += `search=${encodeURIComponent(query)}&`;
            if (dept) url += `department_slug=${encodeURIComponent(dept)}&`;
            if (status) url += `status=${encodeURIComponent(status)}&`;

            // Dynamic date filter according to selected status:
            if (status === 'Awarded') {
                if (start) url += `award_date_after=${encodeURIComponent(start)}&`;
                if (end) url += `award_date_before=${encodeURIComponent(end)}&`;
            } else if (status === 'Thesis Submitted') {
                if (start) url += `thesis_submission_date_after=${encodeURIComponent(start)}&`;
                if (end) url += `thesis_submission_date_before=${encodeURIComponent(end)}&`;
            } else {
                if (start) url += `registration_date_after=${encodeURIComponent(start)}&`;
                if (end) url += `registration_date_before=${encodeURIComponent(end)}&`;
            }
        }

        tbody.innerHTML =
            `<tr><td colspan="7" class="text-center py-5"><div class="rd-loader"></div></td></tr>`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                const scholars = data.results || [];
                renderTable(scholars);
                renderPagination(data);
                recordCount.textContent =
                    `Displaying ${scholars.length} of ${data.count || scholars.length} Scholars`;
            })
            .catch(err => {
                tbody.innerHTML =
                    `<tr><td colspan="7" class="text-danger text-center py-4">Error loading scholar directory.</td></tr>`;
            });
    }

    function renderTable(scholars) {
        if (scholars.length === 0) {
            tbody.innerHTML =
                `<tr><td colspan="7" class="text-center py-5 text-muted">No scholars found.</td></tr>`;
            return;
        }

        tbody.innerHTML = scholars.map((s, index) => {
            const statusClass = (s.status || '').toLowerCase().replace(' ', '-');
            const regYear = s.registration_year || '-';
            const awardYear = s.award_date ?
                new Date(s.award_date).toLocaleDateString('en-US', {
                    month: 'short',
                    year: 'numeric'
                }).replace(' ', ', ') :
                '-';
            let supervisorHtml =
                `<div class="fw-bold" style="color: var(--rd-indigo);">${s.supervisor?.name || 'N/A'}</div>`;
            if (s.co_supervisor?.length > 0) {
                const names = s.co_supervisor.map(cs => cs.name).join(', ');
                supervisorHtml +=
                    `<div class="small text-muted" style="font-size: 0.75rem;">Co-Sup: ${names}</div>`;
            }

            return `
                <tr class="animate-up" style="animation-delay: ${index * 0.05}s">
                    <td class="fw-bold" style="color: var(--rd-royal);">${s.scholar_name}</td>
                    <td class="font-monospace small text-center">${s.enrollment_no || '-'}</td>
                    <td style="max-width: 350px;">
                        <div style="font-size: 0.9rem; font-weight: 600; line-height: 1.4;">${s.research_topic || s.subject || 'Topic not specified'}</div>
                        <div class="small text-muted mt-1" style="font-size: 0.75rem;">${s.department_name || ''}</div>
                    </td>
                    <td>${supervisorHtml}</td>
                    <td><span class="status-badge ${statusClass}">${s.status}</span></td>
                    <td class="text-center fw-bold">${regYear}</td>
                    <td class="text-center fw-bold">${awardYear}</td>
                </tr>
            `;
        }).join('');
    }

    function renderPagination(data) {
        paginationControls.innerHTML = '';
        if (!data.count) return;

        let pageSizeNum = 10;
        if (data.next) {
            const u = new URL(data.next);
            if (u.searchParams.has('page_size')) pageSizeNum = parseInt(u.searchParams.get('page_size'));
        } else if (data.previous) {
            const u = new URL(data.previous);
            if (u.searchParams.has('page_size')) pageSizeNum = parseInt(u.searchParams.get('page_size'));
        }

        const totalPages = Math.ceil(data.count / pageSizeNum);
        if (totalPages <= 1) return;

        let currentPage = 1;
        const browserUrl = new URL(window.location);
        if (browserUrl.searchParams.has('page')) {
            currentPage = parseInt(browserUrl.searchParams.get('page')) || 1;
        }

        const paginationWrapper = document.createElement('div');
        paginationWrapper.className = 'd-flex justify-content-center gap-2 mt-4 flex-wrap';

        const generatePageUrl = (pageNum) => {
            let base = data.next || data.previous;
            const urlObj = new URL(base);
            urlObj.searchParams.set('page', pageNum);
            return urlObj.toString();
        };

        const fetchPage = (pageNum, targetUrl) => {
            const currentUrl = new URL(window.location);
            if (pageNum === 1) currentUrl.searchParams.delete('page');
            else currentUrl.searchParams.set('page', pageNum);
            window.history.pushState({}, '', currentUrl);
            fetchScholars(targetUrl);
        };

        const prevBtn = document.createElement('button');
        prevBtn.className = `btn-rd-profile ${currentPage === 1 ? 'disabled' : ''}`;
        prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
        if (currentPage > 1) {
            prevBtn.onclick = () => fetchPage(currentPage - 1, generatePageUrl(currentPage - 1));
        }
        paginationWrapper.appendChild(prevBtn);

        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, currentPage + 2);

        if (startPage > 1) {
            const firstBtn = document.createElement('button');
            firstBtn.className = 'btn-rd-profile';
            firstBtn.innerText = '1';
            firstBtn.onclick = () => fetchPage(1, generatePageUrl(1));
            paginationWrapper.appendChild(firstBtn);
            if (startPage > 2) {
                const dots = document.createElement('span');
                dots.innerText = '...';
                dots.className = 'px-2 align-self-center text-muted';
                paginationWrapper.appendChild(dots);
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.className = `btn-rd-profile ${i === currentPage ? 'active' : ''}`;
            if (i === currentPage) {
                pageBtn.style.background = 'var(--rd-royal)';
                pageBtn.style.color = 'white';
            }
            pageBtn.innerText = i;
            pageBtn.onclick = () => fetchPage(i, generatePageUrl(i));
            paginationWrapper.appendChild(pageBtn);
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                const dots = document.createElement('span');
                dots.innerText = '...';
                dots.className = 'px-2 align-self-center text-muted';
                paginationWrapper.appendChild(dots);
            }
            const lastBtn = document.createElement('button');
            lastBtn.className = 'btn-rd-profile';
            lastBtn.innerText = totalPages;
            lastBtn.onclick = () => fetchPage(totalPages, generatePageUrl(totalPages));
            paginationWrapper.appendChild(lastBtn);
        }

        const nextBtn = document.createElement('button');
        nextBtn.className = `btn-rd-profile ${currentPage === totalPages ? 'disabled' : ''}`;
        nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
        if (currentPage < totalPages) {
            nextBtn.onclick = () => fetchPage(currentPage + 1, generatePageUrl(currentPage + 1));
        }
        paginationWrapper.appendChild(nextBtn);

        paginationControls.appendChild(paginationWrapper);
    }

    searchInput.oninput = () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchScholars(), 400);
    };
    [deptFilter, startDate, endDate].forEach(el => el.onchange = () => fetchScholars());
    if (statusFilter) {
        statusFilter.onchange = () => {
            updateDateLabels();
            fetchScholars();
        };
    }

    updateDateLabels();
    fetchScholars();
});
</script>

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>
<style>
/* PAGE SPECIFIC STATUS BADGES */
.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
    white-space: nowrap;
}

.status-badge.pursuing {
    background: #e0f2fe;
    color: #0284c7;
}

.status-badge.awarded {
    background: #dcfce7;
    color: #166534;
}

.status-badge.thesis-submitted {
    background: #fef9c3;
    color: #854d0e;
}
</style>

<?php get_footer(); ?>