<?php
/**
 * Template Name: Research Publications
 */

get_header();

$api_base = getenv('DJANGO_MEDIA_URL');
// Fetch Depts for filter


// Fetch Faculty for filters

?>

<main id="primary" class="site-main research-portal">
    <?php get_template_part('banners/about-banner'); ?>

    <div class="research-container container">
        <?php get_template_part('template-parts/breadcrumb');?>
        <div class="portal-header mb-4">
            <h2 class="section-title modal-title-blue">Academic Publications</h2>
        </div>

        <!-- FILTER BAR -->
        <div class="filter-bar">
            <div class="pub-search-box">
                <i class="fas fa-search pub-search-icon"></i>
                <input type="text" id="pub-search" placeholder="Search by title, journal..." autocomplete="off">
            </div>

            <select id="pub-dept-filter" class="custom-select">
                <option value="">All Departments</option>
            </select>

            <select id="pub-faculty-filter" class="custom-select">
                <option value="">All Faculty</option>
            </select>

            <select id="year-filter" class="custom-select">
                <option value="">Publication Year</option>
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
                <table class="prog-table w-100" id="pubs-table">
                    <thead>
                        <tr>
                            <th class="w-30">Title</th>
                            <th class="w-20">Author/Faculty</th>
                            <th class="w-20">Name of Journal / Publisher </th>
                            <th class="w-10">Type</th>
                            <th class="w-10">Indexing</th>
                            <th class="w-15">Date</th>
                            <th class="w-5">Details</th>
                        </tr>
                    </thead>
                    <tbody id="pubs-tbody">
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-spinner fa-spin me-2"></i> Loading publications...
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

    <!-- PUBLICATION MODAL -->
    <div id="pubModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-modal">&times;</span>
            <h2 id="modal-title" class="mb-3 modal-title-blue">
                Publication Title</h2>

            <div class="modal-tags mb-3">
                <span id="modal-type" class="status-badge badge-light">Type</span>
                <span id="modal-indexing-badge" class="status-badge badge-indexing"
                    style="display: none;">Indexing</span>
            </div>

            <div class="modal-meta mb-4 modal-meta-custom">
                <div class="mb-2"><i class="fas fa-user-edit me-2"></i> <strong>Author:</strong> <span
                        id="modal-author"></span></div>
                <div class="mb-2"><i class="fas fa-book me-2"></i> <strong>Published In:</strong> <span
                        id="modal-venue"></span></div>
                <div class="mb-2"><i class="fas fa-calendar-alt me-2"></i> <strong>Date:</strong> <span
                        id="modal-date"></span></div>
                <div class="mb-2"><i class="fas fa-building me-2"></i> <strong>Department:</strong> <span
                        id="modal-dept"></span></div>
            </div>

            <div id="modal-link-container" class="modal-link-container" style="display: none;">
                <a href="#" id="modal-link" target="_blank" class="btn-primary modal-link-btn">View DOI <i
                        class="fas fa-external-link-alt ms-2"></i></a>
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
            const deptFilter = document.getElementById('pub-dept-filter');
            const facFilter = document.getElementById('pub-faculty-filter');

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

    const searchInput = document.getElementById('pub-search');
    const deptFilter = document.getElementById('pub-dept-filter');
    const facultyFilter = document.getElementById('pub-faculty-filter');
    const yearFilter = document.getElementById('year-filter');
    const tbody = document.getElementById('pubs-tbody');
    const recordCount = document.getElementById('record-count');
    const paginationControls = document.getElementById('pagination-controls');
    const apiBase = "<?php echo esc_js($api_base); ?>";

    const modal = document.getElementById('pubModal');
    const closeBtn = document.querySelector('.close-modal');

    let pubsData = [];
    let debounceTimer;

    function fetchPublications(url = null) {
        if (!url) {
            const query = searchInput.value.toLowerCase().trim();
            const dept = deptFilter.value;
            const fac = facultyFilter.value;
            const year = yearFilter.value;

            url = `${apiBase}/api/v1/publications/?`;
            if (query) url += `search=${encodeURIComponent(query)}&`;
            if (dept) url += `department__slug=${encodeURIComponent(dept)}&`;
            if (fac) url += `faculty__slug=${encodeURIComponent(fac)}&`;
            if (year) url += `publication_date__year=${encodeURIComponent(year)}&`;
        }

        tbody.innerHTML =
            `<tr><td colspan="6" class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin fa-2x mb-3 d-block"></i> Fetching records...</td></tr>`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                pubsData = data.results || [];
                renderTable(pubsData);
                renderPagination(data);

                const total = data.count || pubsData.length;
                const shown = pubsData.length;
                recordCount.textContent = `Showing ${shown} of ${total} records`;
            })
            .catch(err => {
                console.error('Error fetching publications:', err);
                tbody.innerHTML =
                    `<tr><td colspan="6" class="text-danger text-center py-4">Failed to load publications.</td></tr>`;
            });
    }

    function renderPagination(data) {
        paginationControls.innerHTML = '';
        if (!data.next && !data.previous) return;

        if (data.previous) {
            const prevBtn = document.createElement('button');
            prevBtn.className = 'pagination-btn';
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i> Previous';
            prevBtn.onclick = () => fetchPublications(data.previous);
            paginationControls.appendChild(prevBtn);
        }

        if (data.next) {
            const nextBtn = document.createElement('button');
            nextBtn.className = 'pagination-btn';
            nextBtn.innerHTML = 'Next <i class="fas fa-chevron-right"></i>';
            nextBtn.onclick = () => fetchPublications(data.next);
            paginationControls.appendChild(nextBtn);
        }
    }

    function renderTable(pubs) {
        if (pubs.length === 0) {
            tbody.innerHTML =
                `<tr><td colspan="6" class="text-center py-5 text-muted">No publications found </td></tr>`;
            return;
        }

        const html = pubs.map((p, index) => {
            return `
                <tr>
                    <td class="fw-bold fw-blue">${p.title}</td>
                    <td>${p.faculty_name || 'N/A'}</td>
                    <td>${p.name_of_journal_or_conference_or_publisher || '-'}</td>
                    <td><span class="status-badge badge-light">${p.publication_type || 'Other'}</span></td>
                    <td>${p.indexing ? `<span class="status-badge badge-indexing"> ${p.indexing === 'Others' && p.others_indexing ? p.others_indexing : p.indexing}</span>` : '<span class="text-muted">--</span>'}
                    <td>${p.publication_date || '-'}</td>
                    <td class="text-center">
                        <button class="btn-view-desc" data-index="${index}"><i class="fas fa-eye"></i></button>
                    </td>
                </tr>
            `;
        }).join('');

        tbody.innerHTML = html;

        document.querySelectorAll('.btn-view-desc').forEach(btn => {
            btn.addEventListener('click', function() {
                const pub = pubsData[this.getAttribute('data-index')];
                openModal(pub);
            });
        });
    }

    function openModal(pub) {
        document.getElementById('modal-title').textContent = pub.title;
        document.getElementById('modal-author').textContent = pub.faculty_name || 'Not specified';
        document.getElementById('modal-venue').textContent = pub.name_of_journal_or_conference_or_publisher ||
            'Not specified';
        document.getElementById('modal-date').textContent = pub.publication_date || 'Not specified';
        document.getElementById('modal-dept').textContent = pub.department_name || 'Not specified';
        document.getElementById('modal-type').textContent = pub.publication_type || 'Publication';

        const indexingBadge = document.getElementById('modal-indexing-badge');
        let indexingText = pub.indexing;
        if (indexingText === 'Others' && pub.others_indexing) {
            indexingText = pub.others_indexing;
        }
        if (indexingText && indexingText.trim() !== '') {
            indexingBadge.textContent = 'Indexed: ' + indexingText;
            indexingBadge.style.display = 'inline-block';
        } else {
            indexingBadge.style.display = 'none';
        }

        const linkContainer = document.getElementById('modal-link-container');
        const linkEl = document.getElementById('modal-link');
        if (pub.doi_url && pub.doi_url.trim() !== '') {
            linkEl.href = pub.doi_url;
            linkContainer.style.display = 'block';
        } else {
            linkContainer.style.display = 'none';
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
        debounceTimer = setTimeout(() => fetchPublications(), 400);
    });

    deptFilter.addEventListener('change', () => fetchPublications());
    facultyFilter.addEventListener('change', () => fetchPublications());
    yearFilter.addEventListener('change', () => fetchPublications());

    fetchPublications();
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

.w-30 {
    width: 30%;
}

.w-20 {
    width: 20%;
}

.w-15 {
    width: 15%;
}

.w-10 {
    width: 10%;
}

.w-5 {
    width: 5%;
}

.fw-blue {
    color: var(--theme-blue);
}

.modal-title-blue {
    color: var(--theme-blue);
    font-size: 1.5rem !important;
    font-weight: 700 !important;
}

.modal-title-blue::after {
    background: none;
}

.modal-meta-custom {
    font-size: 0.95rem;
    color: #64748b;
    line-height: 1.6;
}

.badge-light {
    background: #f1f5f9;
    color: #475569;
}

.badge-indexing {
    background: #dbeafe;
    color: #1e40af;
}

.indexing-small {
    font-size: 0.75rem;
    font-weight: 600;
    color: #1e40af;
    margin-top: 4px;
}

.modal-link-container {
    border-top: 1px solid #e2e8f0;
    padding-top: 20px;
}

.modal-link-btn {
    display: inline-block;
    padding: 10px 20px;
    background: var(--theme-blue);
    color: white !important;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}

.pub-search-box {
    flex: 2;
    min-width: 200px;
    position: relative;
}

.pub-search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.pub-search-box input {
    width: 100%;
    padding: 10px 15px 10px 40px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.pub-search-box input:focus {
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