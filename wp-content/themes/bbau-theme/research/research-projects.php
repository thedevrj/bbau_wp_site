<?php
/**
 * Template Name: Research Projects
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
                <div class="badge-new-rd1">Collaborative Research</div>
                <h1 style="font-size: 2.0rem;">Research Projects</h1>
            </div>
        </div>
    </section>

    <div class="research-container container">
        <?php get_template_part('template-parts/breadcrumb');?>

        <!-- PREMIUM GLASS FILTERS -->
        <div class="ra-glass-filters animate-up mt-4" style="animation-delay: 0.1s;">
            <div class="ra-search-box">
                <i class="fas fa-search ra-search-icon"></i>
                <input type="text" id="project-search" placeholder="Search by project title, PI or agency..."
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
                        <option value="">Any Status</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Completed">Completed</option>
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
                <h2 class="rd-section-title m-0">Project Registry</h2>
                <span class="badge bg-light text-dark px-3 py-2 border rounded-pill" id="record-count"
                    style="font-weight: 700; font-size: 0.8rem;">
                    Syncing database...
                </span>
            </div>

            <div class="table-responsive">
                <table class="premium-table" id="projects-table">
                    <thead>
                        <tr>
                            <th>Project Details</th>
                            <th>Investigator</th>
                            <th>Funding Agency</th>
                            <th>Funding Amt.</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="projects-tbody">
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="rd-loader"></div>
                                <p class="mt-3 text-muted">Retrieving institutional projects...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="pagination-controls" class="pagination-wrapper"></div>
        </div>
    </div>

    <!-- ENHANCED PROJECT MODAL -->
    <div id="projectModal" class="premium-modal">
        <div class="modal-glass-overlay"></div>
        <div class="premium-modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-badge mb-3" id="modal-status-badge">PROJECT</div>
            <h2 id="modal-title" class="mb-4" style="font-size: 1.8rem; font-weight: 700; color: var(--rd-indigo);">
                Project Title</h2>

            <div class="modal-grid mb-4">
                <div class="modal-info-item">
                    <label>Principal Investigator</label>
                    <div id="modal-pi" class="info-val"></div>
                </div>
                <div class="modal-info-item">
                    <label>Co-Investigators</label>
                    <div id="modal-copi" class="info-val"></div>
                </div>
                <div class="modal-info-item">
                    <label>Funding Agency</label>
                    <div id="modal-agency" class="info-val"></div>
                </div>
                <div class="modal-info-item">
                    <label>Grants Sanctioned</label>
                    <div id="modal-amount" class="info-val" style="color: var(--rd-emerald);"></div>
                </div>
                <div class="modal-info-item">
                    <label>Department</label>
                    <div id="modal-dept" class="info-val"></div>
                </div>
            </div>

            <div class="modal-desc-section mt-4 pt-4 border-top">
                <label class="d-block mb-2"
                    style="font-weight: 700; text-transform: uppercase; font-size: 0.75rem; color: #94a3b8;">Abstract /
                    Objectives</label>
                <div id="modal-description" class="modal-abstract"></div>
            </div>
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

    const searchInput = document.getElementById('project-search');
    const deptFilter = document.getElementById('dept-filter');
    const statusFilter = document.getElementById('status-filter');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const tbody = document.getElementById('projects-tbody');
    const recordCount = document.getElementById('record-count');
    const paginationControls = document.getElementById('pagination-controls');
    const apiBase = "<?php echo esc_js($api_base); ?>";

    const modal = document.getElementById('projectModal');
    const closeBtn = document.querySelector('.close-modal');

    let projectsData = [];
    let debounceTimer;

    function fetchProjects(url = null) {
        if (!url) {
            const query = searchInput.value.toLowerCase().trim();
            const dept = deptFilter.value;
            const status = statusFilter.value;
            const start = startDate.value;
            const end = endDate.value;

            url = `${apiBase}/api/v1/research-projects/?page_size=10&`;
            if (query) url += `search=${encodeURIComponent(query)}&`;
            if (dept) url += `department_slug=${encodeURIComponent(dept)}&`;
            if (status) url += `status=${encodeURIComponent(status)}&`;
            if (start) url += `project_date_after=${encodeURIComponent(start)}&`;
            if (end) url += `project_date_before=${encodeURIComponent(end)}&`;
        }

        tbody.innerHTML =
        `<tr><td colspan="6" class="text-center py-5"><div class="rd-loader"></div></td></tr>`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                projectsData = data.results || [];
                renderTable(projectsData);
                renderPagination(data);
                recordCount.textContent =
                    `Displaying ${projectsData.length} of ${data.count || projectsData.length} Projects`;
            })
            .catch(err => {
                tbody.innerHTML =
                    `<tr><td colspan="6" class="text-danger text-center py-4">Error loading projects.</td></tr>`;
            });
    }

    function renderTable(projects) {
        if (projects.length === 0) {
            tbody.innerHTML =
                `<tr><td colspan="6" class="text-center py-5 text-muted">No projects found.</td></tr>`;
            return;
        }

        tbody.innerHTML = projects.map((p, index) => {
            const statusClass = (p.status || '').toLowerCase().replace(' ', '-');
            const amount = p.amount_sanctioned ? '₹' + Number(p.amount_sanctioned).toLocaleString(
                'en-IN') : '-';

            return `
                <tr class="animate-up" style="animation-delay: ${index * 0.05}s">
                    <td class="fw-bold" style="color: var(--rd-royal); max-width: 350px;">${p.title}</td>
                    <td>
                        <div class="fw-bold">${p.pi_name || 'N/A'}</div>
                        ${p.co_investigators_names?.length ? `<div class="small text-muted">Co-PI: ${p.co_investigators_names[0]}${p.co_investigators_names.length > 1 ? '...' : ''}</div>` : ''}
                    </td>
                    <td class="small">${p.funding_agency || '-'}</td>
                    <td class="fw-bold text-success">${amount}</td>
                    <td><span class="status-badge ${statusClass}">${p.status}</span></td>
                    <td class="text-center">
                        <button class="btn-rd-profile" onclick="openProjectModal(${index})"><i class="fas fa-info-circle"></i> Details</button>
                    </td>
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
            btn.onclick = () => fetchProjects(data.previous);
            paginationControls.appendChild(btn);
        }

        if (data.next) {
            const btn = document.createElement('button');
            btn.className = 'btn-rd-profile';
            btn.innerHTML = 'Next <i class="fas fa-chevron-right"></i>';
            btn.onclick = () => fetchProjects(data.next);
            paginationControls.appendChild(btn);
        }
    }

    window.openProjectModal = function(index) {
        const proj = projectsData[index];
        document.getElementById('modal-title').textContent = proj.title;
        document.getElementById('modal-pi').textContent = proj.pi_name || 'N/A';
        document.getElementById('modal-copi').textContent = proj.co_investigators_names?.join(', ') ||
            'None';
        document.getElementById('modal-agency').textContent = proj.funding_agency || 'N/A';
        document.getElementById('modal-amount').textContent = proj.amount_sanctioned ? '₹' + Number(proj
            .amount_sanctioned).toLocaleString('en-IN') : 'N/A';
        document.getElementById('modal-dept').textContent = proj.department_name || 'N/A';
        document.getElementById('modal-status-badge').textContent = proj.status || 'PROJECT';
        document.getElementById('modal-status-badge').className =
            `modal-badge ${(proj.status || '').toLowerCase().replace(' ', '-')}`;
        document.getElementById('modal-description').innerHTML = proj.description ||
            '<p class="text-muted">No details available.</p>';

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };

    closeBtn.onclick = () => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    };
    window.onclick = (e) => {
        if (e.target === modal) closeBtn.onclick();
    };

    searchInput.oninput = () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchProjects(), 400);
    };
    [deptFilter, statusFilter, startDate, endDate].forEach(el => el.onchange = () => fetchProjects());

    fetchProjects();
});
</script>

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>
<style>
/* PAGE SPECIFIC MODAL STYLES */
.premium-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    justify-content: center;
    align-items: center;
}

.modal-glass-overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(8px);
}

.premium-modal-content {
    position: relative;
    background: white;
    width: 90%;
    max-width: 850px;
    padding: 50px;
    border-radius: 32px;
    box-shadow: 0 40px 100px rgba(0, 0, 0, 0.3);
    max-height: 85vh;
    overflow-y: auto;
    animation: modalSlide 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes modalSlide {
    from {
        opacity: 0;
        transform: translateY(50px) scale(0.9);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.close-modal {
    position: absolute;
    top: 30px;
    right: 30px;
    font-size: 2rem;
    color: #94a3b8;
    cursor: pointer;
    transition: 0.2s;
}

.close-modal:hover {
    color: var(--rd-crimson);
    transform: rotate(90deg);
}

.modal-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 30px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    background: #f1f5f9;
    color: #475569;
    letter-spacing: 1px;
}

.modal-badge.ongoing {
    background: #e0f2fe;
    color: #0284c7;
}

.modal-badge.completed {
    background: #dcfce7;
    color: #166534;
}

.modal-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
}

.modal-info-item label {
    display: block;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 5px;
}

.info-val {
    font-weight: 700;
    color: var(--rd-indigo);
    font-size: 1rem;
    line-height: 1.4;
}

.modal-abstract {
    line-height: 1.8;
    color: #475569;
    font-size: 1.05rem;
}

/* REUSE GLOBAL STATUS BADGES */
.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
    white-space: nowrap;
}

.status-badge.ongoing {
    background: #e0f2fe;
    color: #0284c7;
}

.status-badge.completed {
    background: #dcfce7;
    color: #166534;
}
</style>

<?php get_footer(); ?>