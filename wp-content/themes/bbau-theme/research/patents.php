<?php
/**
 * Template Name: Research Patents
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
                <div class="badge-new-rd1">Intellectual Property</div>
                <h1 style="font-size: 2rem;">Research Patents</h1>
            </div>
        </div>
    </section>

    <div class="research-container container">
        <?php get_template_part('template-parts/breadcrumb');?>

        <!-- PREMIUM GLASS FILTERS -->
        <div class="ra-glass-filters animate-up mt-4" style="animation-delay: 0.1s;">
            <div class="ra-search-box">
                <i class="fas fa-search ra-search-icon"></i>
                <input type="text" id="patent-search" placeholder="Search by title, inventor or patent no..."
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
                        <option value="Filed">Filed</option>
                        <option value="Published">Published</option>
                        <option value="Granted">Granted</option>
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
                <h2 class="rd-section-title m-0">Patents</h2>
                <span class="badge bg-light text-dark px-3 py-2 border rounded-pill" id="record-count"
                    style="font-weight: 700; font-size: 0.8rem;">
                    Syncing registry...
                </span>
            </div>

            <div class="table-responsive">
                <table class="premium-table" id="patents-table">
                    <thead>
                        <tr>
                            <th>Innovation Title</th>
                            <th>Lead Inventor</th>
                            <th>Patent ID</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="patents-tbody">
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="rd-loader"></div>
                                <p class="mt-3 text-muted">Accessing IP records...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="pagination-controls" class="pagination-wrapper"></div>
        </div>
    </div>

    <!-- ENHANCED PATENT MODAL -->
    <div id="patentModal" class="premium-modal">
        <div class="modal-glass-overlay"></div>
        <div class="premium-modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-badge mb-3" id="modal-status-badge">PATENT</div>
            <h2 id="modal-title" class="mb-4" style="font-size: 1.8rem; font-weight: 700; color: var(--rd-indigo);">
                Patent Title</h2>

            <div class="modal-grid mb-4">
                <div class="modal-info-item">
                    <label>Inventor</label>
                    <div id="modal-inventor" class="info-val"></div>
                </div>
                <div class="modal-info-item">
                    <label>Patent Number</label>
                    <div id="modal-number" class="info-val"></div>
                </div>
                <div class="modal-info-item">
                    <label>Filing Date</label>
                    <div id="modal-date" class="info-val"></div>
                </div>
            </div>

            <div class="modal-desc-section">
                <label class="d-block mb-2"
                    style="font-weight: 700; text-transform: uppercase; font-size: 0.75rem; color: #64748b;">Detailed
                    Abstract</label>
                <div id="modal-description" class="modal-abstract"></div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Parse department from URL query parameters
    const urlParams = new URLSearchParams(window.location.search);
    const deptParam = urlParams.get('department') || urlParams.get('department_slug') || '';

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

    const searchInput = document.getElementById('patent-search');
    const deptFilter = document.getElementById('dept-filter');
    const statusFilter = document.getElementById('status-filter');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const tbody = document.getElementById('patents-tbody');
    const recordCount = document.getElementById('record-count');
    const paginationControls = document.getElementById('pagination-controls');
    const apiBase = "<?php echo esc_js($api_base); ?>";

    const modal = document.getElementById('patentModal');
    const closeBtn = document.querySelector('.close-modal');

    let patentsData = [];
    let debounceTimer;

    function fetchPatents(url = null) {
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

            url = `${apiBase}/api/v1/patents/?page_size=10&`;
            if (query) url += `search=${encodeURIComponent(query)}&`;
            if (dept) url += `department_slug=${encodeURIComponent(dept)}&`;
            if (status) url += `status=${encodeURIComponent(status)}&`;
            if (start) url += `filing_date_after=${encodeURIComponent(start)}&`;
            if (end) url += `filing_date_before=${encodeURIComponent(end)}&`;
        }

        tbody.innerHTML =
        `<tr><td colspan="5" class="text-center py-5"><div class="rd-loader"></div></td></tr>`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                patentsData = data.results || [];
                renderTable(patentsData);
                renderPagination(data);
                recordCount.textContent =
                    `Displaying ${patentsData.length} of ${data.count || patentsData.length} Innovations`;
            })
            .catch(err => {
                tbody.innerHTML =
                    `<tr><td colspan="5" class="text-danger text-center py-4">Error loading records.</td></tr>`;
            });
    }

    function renderTable(patents) {
        if (patents.length === 0) {
            tbody.innerHTML =
                `<tr><td colspan="5" class="text-center py-5 text-muted">No records found.</td></tr>`;
            return;
        }

        tbody.innerHTML = patents.map((p, index) => {
            const statusClass = (p.status || '').toLowerCase();
            return `
                <tr class="animate-up" style="animation-delay: ${index * 0.05}s">
                    <td class="fw-bold" data-label="Innovation Title" style="color: var(--rd-royal); max-width: 400px;">${p.title}</td>
                    <td data-label="Inventors">${p.full_inventor_list || 'N/A'}</td>
                    <td class="font-monospace small" data-label="Patent ID">${p.patent_number || '-'}</td>
                    <td data-label="Status"><span class="status-badge ${statusClass}">${p.status}</span></td>
                    <td class="text-center" data-label="Action">
                        <button class="btn-rd-profile" onclick="openPatentModal(${index})"><i class="fas fa-search-plus"></i> View Details</button>
                    </td>
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
        } else if (window.location.href.includes('areas')) {
            pageSizeNum = 12; 
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
            fetchPatents(targetUrl);
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
    window.openPatentModal = function(index) {
        const pat = patentsData[index];
        document.getElementById('modal-title').textContent = pat.title;
        document.getElementById('modal-inventor').textContent = pat.full_inventor_list || 'N/A';
        document.getElementById('modal-number').textContent = pat.patent_number || 'N/A';
        document.getElementById('modal-date').textContent = pat.date_of_filing || 'N/A';
        document.getElementById('modal-status-badge').textContent = pat.status || 'PATENT';
        document.getElementById('modal-status-badge').className =
            `modal-badge ${(pat.status || '').toLowerCase()}`;
        document.getElementById('modal-description').innerHTML = pat.description ||
            '<p class="text-muted">No abstract available.</p>';

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
        debounceTimer = setTimeout(() => fetchPatents(), 400);
    };
    [deptFilter, statusFilter, startDate, endDate].forEach(el => el.onchange = () => fetchPatents());

    fetchPatents();
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
    max-width: 800px;
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

.modal-badge.granted {
    background: #dcfce7;
    color: #15803d;
}

.modal-badge.published {
    background: #fef3c7;
    color: #d97706;
}

.modal-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 30px;
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
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
    white-space: nowrap;
}

.status-badge.filed {
    background: #e0f2fe;
    color: #0284c7;
}

.status-badge.published {
    background: #fef3c7;
    color: #d97706;
}

.status-badge.granted {
    background: #dcfce7;
    color: #166534;
}
</style>

<?php get_footer(); ?>