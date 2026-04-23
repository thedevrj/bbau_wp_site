<?php
/**
 * Template Name: Doctoral Research
 */

get_header();

$api_base = getenv('DJANGO_MEDIA_URL');

?>

<main id="primary" class="site-main research-portal">
    <?php get_template_part('banners/about-banner'); ?>

    <div class="research-container container">
        <?php get_template_part('template-parts/breadcrumb');?>
        
        <div class="portal-header mb-4">
            <h2 class="section-title modal-title-blue">Doctoral Research (PhD Scholars)</h2>
        </div>

        <!-- FILTER BAR -->
        <div class="filter-bar">
            <div class="scholars-search-box">
                <i class="fas fa-search search-icon-custom"></i>
                <input type="text" id="scholar-search" placeholder="Search by name, topic, or enrollment..." autocomplete="off">
            </div>
            
            <select id="dept-filter" class="custom-select">
                <option value="">All Departments</option>
            </select>

            <select id="status-filter" class="custom-select">
                <option value="">All Status</option>
                <option value="Pursuing">Pursuing</option>
                <option value="Thesis Submitted">Thesis Submitted</option>
                <option value="Awarded">Awarded</option>
            </select>

            <select id="year-filter" class="custom-select">
                <option value="">Registration Year</option>
                <?php 
                    $current_year = date("Y");
                    for($y = $current_year; $y >= 2000; $y--) {
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
                <table class="prog-table w-100" id="scholars-table">
                    <thead>
                        <tr>
                            <th class="w-20">Scholar Name</th>
                            <th class="w-15">Enrollment No.</th>
                            <th class="w-30">Research Topic</th>
                            <th class="w-20">Supervisor</th>
                            <th class="w-10">Status</th>
                            <th class="w-5">Year</th>
                        </tr>
                    </thead>
                    <tbody id="scholars-tbody">
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-spinner fa-spin me-2"></i> Loading scholars...
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
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- DYNAMICALLY LOAD FILTERS VIA JS ---
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
                        let displayName = d.name;
                        if (d.campus === 'Satellite Campus Amethi') {
                            displayName += ' (Amethi)';
                        }
                        deptFilter.innerHTML += `<option value="${d.slug}">${displayName}</option>`;
                    });
                }
            }
        } catch(e) {
            console.error("Filter Load Error:", e);
        }
    }
    loadDynamicFilters();
    
    const searchInput = document.getElementById('scholar-search');
    const deptFilter = document.getElementById('dept-filter');
    const statusFilter = document.getElementById('status-filter');
    const yearFilter = document.getElementById('year-filter');
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
            const year = yearFilter.value;
            
            url = `${apiBase}/api/v1/research-scholars/?`;
            if (query) url += `search=${encodeURIComponent(query)}&`;
            if (dept) url += `department__slug=${encodeURIComponent(dept)}&`;
            if (status) url += `status=${encodeURIComponent(status)}&`;
            if (year) url += `date_of_registration__year=${encodeURIComponent(year)}&`;
        }

        tbody.innerHTML = `<tr><td colspan="6" class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin fa-2x mb-3 d-block"></i> Fetching records...</td></tr>`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                const scholars = data.results || [];
                renderTable(scholars);
                renderPagination(data);
                
                const total = data.count || scholars.length;
                const shown = scholars.length;
                recordCount.textContent = `Showing ${shown} of ${total} records`;
            })
            .catch(err => {
                console.error('Error fetching scholars:', err);
                tbody.innerHTML = `<tr><td colspan="6" class="text-danger text-center py-4">Failed to load scholar records. Please try again later.</td></tr>`;
            });
    }

    function renderPagination(data) {
        paginationControls.innerHTML = '';
        if (!data.next && !data.previous) return;

        if (data.previous) {
            const prevBtn = document.createElement('button');
            prevBtn.className = 'pagination-btn';
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i> Previous';
            prevBtn.onclick = () => fetchScholars(data.previous);
            paginationControls.appendChild(prevBtn);
        }

        if (data.next) {
            const nextBtn = document.createElement('button');
            nextBtn.className = 'pagination-btn';
            nextBtn.innerHTML = 'Next <i class="fas fa-chevron-right"></i>';
            nextBtn.onclick = () => fetchScholars(data.next);
            paginationControls.appendChild(nextBtn);
        }
    }

    function renderTable(scholars) {
        if (scholars.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center py-5 text-muted">No scholars found matching your criteria.</td></tr>`;
            return;
        }

        const html = scholars.map((s) => {
            const statusClass = (s.status || '').toLowerCase().replace(' ', '-');
            const regDate = s.date_of_registration || '-';
            const regYear = s.registration_year || '-';
            
            let supervisorHtml = `<strong>${s.supervisor_name || 'N/A'}</strong>`;
            if (s.co_supervisors_names && s.co_supervisors_names.length > 0) {
                supervisorHtml += `<div class="sub-text">Co-Sup: ${s.co_supervisors_names.join(', ')}</div>`;
            }

            return `
                <tr>
                    <td class="fw-bold fw-blue">${s.scholar_name}</td>
                    <td><code class="text-dark">${s.enrollment_no || 'N/A'}</code></td>
                    <td>
                        <div class="research-topic-text">"${s.research_topic || s.subject || 'Topic not specified'}"</div>
                        <div class="sub-text">${s.department_name || ''}</div>
                    </td>
                    <td>${supervisorHtml}</td>
                    <td><span class="status-badge ${statusClass}">${s.status}</span></td>
                    <td class="text-center">${regYear}</td>
                </tr>
            `;
        }).join('');
        
        tbody.innerHTML = html;
    }

    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchScholars(), 400);
    });
    
    deptFilter.addEventListener('change', () => fetchScholars());
    statusFilter.addEventListener('change', () => fetchScholars());
    yearFilter.addEventListener('change', () => fetchScholars());

    fetchScholars();
});
</script>

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>
<style>
:root {
    --theme-blue: #1e3a8a;
}

.filter-bar {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    margin-bottom: 30px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    align-items: center;
    border: 1px solid #f1f5f9;
}

.scholars-search-box {
    flex: 2;
    min-width: 250px;
    position: relative;
}

.search-icon-custom {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.scholars-search-box input {
    width: 100%;
    padding: 10px 15px 10px 40px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
}

.fw-blue { color: var(--theme-blue); }

.research-topic-text {
    font-size: 0.95rem;
    font-weight: 600;
    line-height: 1.4;
    color: #334155;
}

.sub-text {
    font-size: 0.75rem;
    color: #64748b;
    margin-top: 5px;
}

.table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
    overflow: hidden;
    border: 1px solid #f1f5f9;
}

.table-responsive {
    overflow-x: auto;
}

.prog-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px;
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
    vertical-align: top;
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

.status-badge.pursuing { background: #e0f2fe; color: #0284c7; }
.status-badge.awarded { background: #dcfce7; color: #166534; }
.status-badge.thesis-submitted { background: #fef9c3; color: #854d0e; }

@media (max-width: 768px) {
    .filter-bar { grid-template-columns: 1fr; }
}
</style>

<?php get_footer(); ?>
