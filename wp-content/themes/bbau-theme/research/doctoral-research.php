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

    <div class="research-container container ">
        <?php get_template_part('template-parts/breadcrumb');?>

        <!-- PREMIUM GLASS FILTERS -->
        <div class="ra-glass-filters animate-up mt-4" style="animation-delay: 0.1s;">
            <div class="ra-search-box">
                <i class="fas fa-search ra-search-icon"></i>
                <input type="text" id="scholar-search" placeholder="Search by name, topic, or enrollment..."
                    autocomplete="off">
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
                    <label>From Date</label>
                    <input type="date" id="start-date" class="ra-select">
                </div>
                <div class="filter-item">
                    <label>To Date</label>
                    <input type="date" id="end-date" class="ra-select">
                </div>
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
                            <th>Research Focus</th>
                            <th>Supervisor</th>
                            <th>Status</th>
                            <th class="text-center">Year</th>
                        </tr>
                    </thead>
                    <tbody id="scholars-tbody">
                        <tr>
                            <td colspan="6" class="text-center py-5">
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
                        const displayName = d.campus === 'Satellite Campus Amethi' ? `${d.name} (Amethi)` : d.name;
                        deptFilter.innerHTML += `<option value="${d.slug}">${displayName}</option>`;
                    });
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
    const tbody = document.getElementById('scholars-tbody');
    const recordCount = document.getElementById('record-count');
    const paginationControls = document.getElementById('pagination-controls');
    const apiBase = "<?php echo esc_js($api_base); ?>";

    let debounceTimer;

    function fetchScholars(url = null) {
        if (!url) {
            const query = searchInput.value.toLowerCase().trim();
            const dept = deptFilter.value;
            const status = statusFilter.value;
            const start = startDate.value;
            const end = endDate.value;

            url = `${apiBase}/api/v1/research-scholars/?page_size=10&`;
            if (query) url += `search=${encodeURIComponent(query)}&`;
            if (dept) url += `department_slug=${encodeURIComponent(dept)}&`;
            if (status) url += `status=${encodeURIComponent(status)}&`;
            if (start) url += `registration_date_after=${encodeURIComponent(start)}&`;
            if (end) url += `registration_date_before=${encodeURIComponent(end)}&`;
        }

        tbody.innerHTML =
        `<tr><td colspan="6" class="text-center py-5"><div class="rd-loader"></div></td></tr>`;

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
                    `<tr><td colspan="6" class="text-danger text-center py-4">Error loading scholar directory.</td></tr>`;
            });
    }

    function renderTable(scholars) {
        if (scholars.length === 0) {
            tbody.innerHTML =
                `<tr><td colspan="6" class="text-center py-5 text-muted">No scholars found.</td></tr>`;
            return;
        }

        tbody.innerHTML = scholars.map((s, index) => {
            const statusClass = (s.status || '').toLowerCase().replace(' ', '-');
            const regYear = s.registration_year || '-';

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
                    <td class="font-monospace small">${s.enrollment_no || 'N/A'}</td>
                    <td style="max-width: 350px;">
                        <div style="font-size: 0.9rem; font-weight: 600; line-height: 1.4;">${s.research_topic || s.subject || 'Topic not specified'}</div>
                        <div class="small text-muted mt-1" style="font-size: 0.75rem;">${s.department_name || ''}</div>
                    </td>
                    <td>${supervisorHtml}</td>
                    <td><span class="status-badge ${statusClass}">${s.status}</span></td>
                    <td class="text-center fw-bold">${regYear}</td>
                </tr>
            `;
        }).join('');
    }

    function renderPagination(data) {
        paginationControls.innerHTML = '';
        if (!data.next && !data.previous) return;

        if (data.previous) {
            const btn = document.createElement('button');
            btn.className = 'btn-rd-profile';
            btn.innerHTML = '<i class="fas fa-chevron-left"></i> Previous';
            btn.onclick = () => fetchScholars(data.previous);
            paginationControls.appendChild(btn);
        }

        if (data.next) {
            const btn = document.createElement('button');
            btn.className = 'btn-rd-profile';
            btn.innerHTML = 'Next <i class="fas fa-chevron-right"></i>';
            btn.onclick = () => fetchScholars(data.next);
            paginationControls.appendChild(btn);
        }
    }

    searchInput.oninput = () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchScholars(), 400);
    };
    [deptFilter, statusFilter, startDate, endDate].forEach(el => el.onchange = () => fetchScholars());

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