<?php
/**
 * Template Name: Research Projects
 */

get_header();

$api_base = getenv('DJANGO_MEDIA_URL');


?>

<main id="primary" class="site-main research-portal">
    <?php get_template_part('banners/about-banner'); ?>

    <div class="research-container container">
        <?php get_template_part('template-parts/breadcrumb');?>

        <div class="portal-header mb-4">
            <h2 class="section-title modal-title-blue">Research Projects</h2>
        </div>

        <!-- FILTER BAR -->
        <div class="filter-bar">
            <div class="research-search-box">
                <i class="fas fa-search research-search-icon"></i>
                <input type="text" id="project-search" placeholder="Search by title, agency..." autocomplete="off">
            </div>

            <select id="dept-filter" class="custom-select">
                <option value="">All Departments</option>
            </select>

            <select id="faculty-filter" class="custom-select">
                <option value="">All Principal Investigators</option>
            </select>

            <select id="status-filter" class="custom-select">
                <option value="">Status</option>
                <option value="Ongoing">Ongoing</option>
                <option value="Completed">Completed</option>
            </select>

            <select id="year-filter" class="custom-select">
                <option value="">Select Year</option>
                <?php 
                    $current_year = date("Y");
                    for($y = $current_year; $y >= 2010; $y--) {
                        echo "<option value=\"$y\">$y</option>";
                    }
                ?>
            </select>
        </div>

        <div class="table-card">
            <div class="table-header-info d-flex justify-content-between align-items-center p-3 border-bottom">
                <span class="text-muted small" id="record-count">Showing 0 records</span>
            </div>
            <div class="table-responsive">
                <table class="prog-table w-100" id="projects-table">
                    <thead>
                        <tr>
                            <th class="w-30">Project Title</th>
                            <th class="w-20">Principal Investigator</th>
                            <th class="w-20">Funding Agency</th>
                            <th class="w-10">Amount</th>
                            <th class="w-10">Status</th>
                            <th class="w-10">Details</th>
                        </tr>
                    </thead>
                    <tbody id="projects-tbody">
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-spinner fa-spin me-2"></i> Loading projects...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="pagination-controls" class="pagination-wrapper p-3 border-top d-flex justify-content-center gap-3">
                <!-- Pagination buttons will be injected here -->
            </div>
        </div>
    </div>

    <!-- PROJECT MODAL -->
    <div id="projectModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-modal">&times;</span>
            <h2 id="modal-title" class="mb-3 modal-title-blue">Project Title</h2>
            <div class="modal-tags mb-3">
                <span id="modal-status" class="status-badge badge-light">Status</span>
            </div>
            <div class="modal-meta mb-4 pb-3 modal-meta-custom">
                <div class="mb-2"><i class="fas fa-user-tie me-2"></i> <strong>P.I.:</strong> <span
                        id="modal-pi"></span></div>
                <div class="mb-2"><i class="fas fa-users me-2"></i> <strong>Co-P.I.(s):</strong> <span
                        id="modal-copi"></span></div>
                <div class="mb-2"><i class="fas fa-building me-2"></i> <strong>Agency:</strong> <span
                        id="modal-agency"></span></div>
                <div class="mb-2"><i class="fas fa-rupee-sign me-2"></i> <strong>Amount:</strong> <span
                        id="modal-amount"></span></div>
                <div class="mb-2"><i class="fas fa-university me-2"></i> <strong>Department:</strong> <span
                        id="modal-dept"></span></div>
            </div>
            <div id="modal-description" class="modal-body-content modal-desc-custom">
                <!-- Description HTML goes here -->
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- DYNAMICALLY LOAD FILTERS VIA JS TO PREVENT PHP LAG ---
    async function loadDynamicFilters() {
        try {
            const apiBase = "<?php echo esc_js($api_base); ?>";
            const deptFilter = document.getElementById('dept-filter');
            const facFilter = document.getElementById('faculty-filter');

            if (deptFilter) {
                const dRes = await fetch(`${apiBase}/api/v1/departments/?page_size=500`);
                if (dRes.ok) {
                    const depts = await dRes.json();
                    const dData = depts.results || depts;
                    dData.forEach(d => {
                        let displayName = d.name;
                        if (d.campus === 'Satellite Campus Amethi') {
                            displayName += ' (Amethi)';
                        }
                        deptFilter.innerHTML += `<option value="${d.slug}">${displayName}</option>`;
                    });
                }
            }

            if (facFilter) {
                const fRes = await fetch(`${apiBase}/api/v1/faculty/?page_size=500`);
                if (fRes.ok) {
                    const facs = await fRes.json();
                    const fData = facs.results || facs;
                    fData.forEach(f => {
                        facFilter.innerHTML += `<option value="${f.slug}">${f.name}</option>`;
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
    const facultyFilter = document.getElementById('faculty-filter');
    const statusFilter = document.getElementById('status-filter');
    const yearFilter = document.getElementById('year-filter');
    const tbody = document.getElementById('projects-tbody');
    const recordCount = document.getElementById('record-count');
    const paginationControls = document.getElementById('pagination-controls');
    const apiBase = "<?php echo esc_js($api_base); ?>";

    // Modal Elements
    const modal = document.getElementById('projectModal');
    const closeBtn = document.querySelector('.close-modal');

    let projectsData = [];
    let debounceTimer;

    function fetchProjects(url = null) {
        if (!url) {
            const query = searchInput.value.toLowerCase().trim();
            const dept = deptFilter.value;
            const fac = facultyFilter.value;
            const status = statusFilter.value;
            const year = yearFilter.value;
            
            url = `${apiBase}/api/v1/research-projects/?`;
            if (query) url += `search=${encodeURIComponent(query)}&`;
            if (dept) url += `department__slug=${encodeURIComponent(dept)}&`;
            if (fac) url += `principal_investigator__slug=${encodeURIComponent(fac)}&`;
            if (status) url += `status=${encodeURIComponent(status)}&`;
            if (year) url += `start_date__year=${encodeURIComponent(year)}&`;
        }

        tbody.innerHTML =
            `<tr><td colspan="6" class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin fa-2x mb-3 d-block"></i> Fetching records...</td></tr>`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                projectsData = data.results || [];
                renderTable(projectsData);
                renderPagination(data);
                
                // Update count
                const total = data.count || projectsData.length;
                const shown = projectsData.length;
                recordCount.textContent = `Showing ${shown} of ${total} records`;
            })
            .catch(err => {
                console.error('Error fetching projects:', err);
                tbody.innerHTML =
                    `<tr><td colspan="6" class="text-danger text-center py-4">Failed to load projects. Please try again later.</td></tr>`;
            });
    }

    function renderPagination(data) {
        paginationControls.innerHTML = '';
        if (!data.next && !data.previous) return;

        if (data.previous) {
            const prevBtn = document.createElement('button');
            prevBtn.className = 'pagination-btn';
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i> Previous';
            prevBtn.onclick = () => fetchProjects(data.previous);
            paginationControls.appendChild(prevBtn);
        }

        if (data.next) {
            const nextBtn = document.createElement('button');
            nextBtn.className = 'pagination-btn';
            nextBtn.innerHTML = 'Next <i class="fas fa-chevron-right"></i>';
            nextBtn.onclick = () => fetchProjects(data.next);
            paginationControls.appendChild(nextBtn);
        }
    }

    function renderTable(projects) {
        if (projects.length === 0) {
            tbody.innerHTML =
                `<tr><td colspan="6" class="text-center py-5 text-muted">No projects found matching your criteria.</td></tr>`;
            return;
        }

        const html = projects.map((p, index) => {
            const statusClass = (p.status || '').toLowerCase().replace(' ', '-');
            const amount = p.amount_sanctioned ? '₹' + Number(p.amount_sanctioned).toLocaleString(
                'en-IN') : '-';

            let coPiHtml = '';
            if (p.co_investigators_names && p.co_investigators_names.length > 0) {
                coPiHtml =
                    `<div class="indexing-small">Co-PI: ${p.co_investigators_names.join(', ')}</div>`;
            }

            return `
                <tr>
                    <td class="fw-bold fw-blue">${p.title}</td>
                    <td>${p.pi_name || 'N/A'}${coPiHtml}</td>
                    <td>${p.funding_agency || '-'}</td>
                    <td>${amount}</td>
                    <td><span class="status-badge ${statusClass}">${p.status}</span></td>
                    <td class="text-center">
                        <button class="btn-view-desc" data-index="${index}"><i class="fas fa-eye"></i> View</button>
                    </td>
                </tr>
            `;
        }).join('');

        tbody.innerHTML = html;

        document.querySelectorAll('.btn-view-desc').forEach(btn => {
            btn.addEventListener('click', function() {
                const proj = projectsData[this.getAttribute('data-index')];
                openModal(proj);
            });
        });
    }

    function openModal(proj) {
        document.getElementById('modal-title').textContent = proj.title;
        document.getElementById('modal-pi').textContent = proj.pi_name || 'Not specified';

        let copiText = 'None';
        if (proj.co_investigators_names && proj.co_investigators_names.length > 0) {
            copiText = proj.co_investigators_names.join(', ');
        }
        document.getElementById('modal-copi').textContent = copiText;

        document.getElementById('modal-agency').textContent = proj.funding_agency || 'Not specified';
        document.getElementById('modal-amount').textContent = proj.amount_sanctioned ? '₹' + Number(proj
            .amount_sanctioned).toLocaleString('en-IN') : 'Not specified';
        document.getElementById('modal-dept').textContent = proj.department_name || 'Not specified';

        const statusEl = document.getElementById('modal-status');
        statusEl.textContent = proj.status || 'Project';
        const statusClass = (proj.status || '').toLowerCase().replace(' ', '-');
        statusEl.className = `status-badge ${statusClass}`;

        const descEl = document.getElementById('modal-description');
        if (proj.description && proj.description.trim() !== '') {
            descEl.innerHTML = proj.description;
        } else {
            descEl.innerHTML =
                '<p class="text-muted fst-italic">No detailed description available for this project.</p>';
        }

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    });

    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchProjects(), 400);
    });

    deptFilter.addEventListener('change', () => fetchProjects());
    facultyFilter.addEventListener('change', () => fetchProjects());
    statusFilter.addEventListener('change', () => fetchProjects());
    yearFilter.addEventListener('change', () => fetchProjects());

    fetchProjects();
});
</script>

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>
<style>
:root {
    --theme-blue: #1e3a8a;
    --theme-amber: #b45309;
}

.filter-bar {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
    align-items: center;
    border: 1px solid #f1f5f9;
}

.pagination-btn {
    background: #f1f5f9;
    color: var(--theme-blue);
    border: 1px solid #e2e8f0;
    padding: 8px 20px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.pagination-btn:hover {
    background: var(--theme-blue);
    color: white;
}

.w-30 {
    width: 30%;
}

.w-20 {
    width: 20%;
}

.w-10 {
    width: 10%;
}

.fw-blue {
    color: var(--theme-blue);
}

.modal-title-blue {
    color: var(--theme-blue);
    font-size: 1.5rem;
    font-weight: 700;
}

.modal-meta-custom {
    border-bottom: 1px solid #e2e8f0;
    font-size: 0.95rem;
    color: #64748b;
    line-height: 1.6;
}

.modal-desc-custom {
    line-height: 1.8;
    color: #334155;
}

.research-search-box {
    flex: 1;
    min-width: 200px;
    position: relative;
}

.research-search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.research-search-box input {
    width: 100%;
    padding: 10px 15px 10px 40px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.research-search-box input:focus {
    border-color: var(--theme-blue);
    outline: none;
    box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
}

.custom-select {
    flex: 1;
    padding: 10px 15px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    color: #475569;
    background-color: #f8fafc;
    min-width: 120px;
    cursor: pointer;
}

.table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    border: 1px solid #f1f5f9;
}

.table-responsive {
    overflow-x: auto;
}

.prog-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

.prog-table th {
    background-color: #f8fafc;
    color: #475569;
    font-size: 0.8rem;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 0.05em;
    padding: 18px 20px;
    text-align: center;
    border-bottom: 2px solid #e2e8f0;
}

.prog-table td {
    padding: 18px 20px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
    vertical-align: middle;
}

.prog-table tr:hover {
    background-color: #f8fafc;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
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

.badge-light {
    background: #f1f5f9;
    color: #475569;
}

.indexing-small {
    font-size: 0.75rem;
    font-weight: 600;
    color: #475569;
    margin-top: 4px;
}

.btn-view-desc {
    background: #f1f5f9;
    color: var(--theme-blue);
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.btn-view-desc:hover {
    background: var(--theme-blue);
    color: white;
}

.custom-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.7);
    z-index: 10000;
    backdrop-filter: blur(4px);
    justify-content: center;
    align-items: center;
}

.custom-modal-content {
    background: white;
    border-radius: 16px;
    padding: 40px;
    width: 90%;
    max-width: 800px;
    max-height: 85vh;
    overflow-y: auto;
    position: relative;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    animation: modalFadeIn 0.3s ease-out;
}

.close-modal {
    position: absolute;
    top: 20px;
    right: 25px;
    font-size: 2rem;
    line-height: 1;
    color: #94a3b8;
    cursor: pointer;
    transition: color 0.2s;
}

.close-modal:hover {
    color: #ef4444;
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@media (max-width: 768px) {
    .filter-bar {
        flex-direction: column;
    }

    .custom-select {
        width: 100%;
    }

    .custom-modal-content {
        padding: 25px;
        width: 95%;
    }
}
</style>

<?php get_footer(); ?>