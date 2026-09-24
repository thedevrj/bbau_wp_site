<?php
/**
 * Template Name: Research Publications
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
                <div class="badge-new-rd1">Academic Excellence</div>
                <h1 style="font-size: 2.0rem;">Research Publications</h1>
            </div>
        </div>
    </section>
    <div id="main-content"></div>

    <div class="research-container container">
        <?php get_template_part('template-parts/breadcrumb');?>

        <!-- PREMIUM GLASS FILTERS -->
        <div class="ra-glass-filters animate-up mt-4" style="animation-delay: 0.1s;">
            <div class="ra-search-box">
                <i class="fas fa-search ra-search-icon"></i>
                <input type="text" id="pub-search" placeholder="Search by title, author, or journal..."
                    autocomplete="off">
            </div>

            <div class="ra-filter-group">
                <div class="filter-item">
                    <label>Department</label>
                    <select id="pub-dept-filter" class="ra-select">
                        <option value="">All Departments</option>
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
                <a href="<?php echo esc_url(get_permalink()); ?>" class="btn-fac-profile">Reset</a>

            </div>
        </div>

        <!-- MAIN CONTENT CARD -->
        <div class="rd-card-premium mt-5 animate-up mb-4" style="animation-delay: 0.2s;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="rd-section-title m-0">Publications Registry</h2>
                <span class="badge bg-light text-dark px-3 py-2 border rounded-pill" id="record-count"
                    style="font-weight: 700; font-size: 0.8rem;">
                    Syncing archive...
                </span>
            </div>

            <div class="table-responsive">
                <table class="premium-table" id="pubs-table">
                    <thead>
                        <tr>
                            <th style="width: 30%">Publication Title</th>
                            <th style="width: 25%">Lead Author</th>
                            <th style="width: 20%">Journal / Publisher</th>
                            <th>Type & Indexing</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="pubs-tbody">
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="rd-loader"></div>
                                <p class="mt-3 text-muted">Accessing scholarly database...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="pagination-controls" class="pagination-wrapper"></div>
        </div>
    </div>

    <!-- ENHANCED PUBLICATION MODAL -->
    <div id="pubModal" class="premium-modal">
        <div class="modal-glass-overlay"></div>
        <div class="premium-modal-content">
            <span class="close-modal">&times;</span>
            <div class="d-flex gap-2 mb-3">
                <div class="modal-badge" id="modal-type">PUBLICATION</div>
                <div class="modal-badge indexing" id="modal-indexing-badge" style="display: none;">INDEXED</div>
            </div>
            <h2 id="modal-title" class="mb-4" style="font-size: 1.8rem; font-weight: 700; color: var(--rd-indigo);">
                Publication Title</h2>

            <div class="modal-grid mb-4">
                <div class="modal-info-item">
                    <label>Lead Author</label>
                    <div id="modal-author" class="info-val"></div>
                </div>
                <div class="modal-info-item">
                    <label>Journal / Venue</label>
                    <div id="modal-venue" class="info-val"></div>
                </div>
                <div class="modal-info-item">
                    <label>Publication Date</label>
                    <div id="modal-date" class="info-val"></div>
                </div>
                <div class="modal-info-item">
                    <label>Department</label>
                    <div id="modal-dept" class="info-val"></div>
                </div>
            </div>

            <div id="modal-link-container" class="mt-4 pt-4 border-top" style="display: none;">
                <a href="#" id="modal-link" target="_blank" class="btn-rd-profile" style="width: auto;">
                    Access Full Article / DOI <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
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
            const deptFilter = document.getElementById('pub-dept-filter');

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

    const searchInput = document.getElementById('pub-search');
    const deptFilter = document.getElementById('pub-dept-filter');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
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
            const dept = (deptFilter && deptFilter.options.length > 1) ? deptFilter.value : deptParam;
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

            url = `${apiBase}/api/v1/publications/?page_size=10&`;
            if (query) url += `search=${encodeURIComponent(query)}&`;
            if (dept) url += `department_slug=${encodeURIComponent(dept)}&`;
            if (start) url += `publication_date_range_after=${encodeURIComponent(start)}&`;
            if (end) url += `publication_date_range_before=${encodeURIComponent(end)}&`;
        }

        tbody.innerHTML =
            `<tr><td colspan="5" class="text-center py-5"><div class="rd-loader"></div></td></tr>`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                pubsData = data.results || [];
                renderTable(pubsData);
                renderPagination(data);
                recordCount.textContent =
                    `Displaying ${pubsData.length} of ${data.count || pubsData.length} Records`;
            })
            .catch(err => {
                tbody.innerHTML =
                    `<tr><td colspan="5" class="text-danger text-center py-4">Error loading archive.</td></tr>`;
            });
    }

    function renderTable(pubs) {
        if (pubs.length === 0) {
            tbody.innerHTML =
                `<tr><td colspan="5" class="text-center py-5 text-muted">No records found.</td></tr>`;
            return;
        }

        tbody.innerHTML = pubs.map((p, index) => {
            let indexingText = p.indexing;
            if (indexingText === 'Others' && p.others_indexing) {
                indexingText = p.others_indexing;
            }
            return `
                <tr class="animate-up" style="animation-delay: ${index * 0.05}s">
                    <td class="fw-bold" data-label="Publication Title" style="color: var(--rd-royal); max-width: 400px;">${p.title}</td>
                    <td data-label="Authors">${p.full_author_list || 'N/A'}</td>
                    <td class="small text-muted" data-label="Journal / Publisher">${p.name_of_journal_or_conference_or_publisher || '-'}</td>
                    <td data-label="Type & Indexing">
                        <span class="status-badge bg-light text-dark border mb-1">${p.publication_type || 'Paper'}</span>
                        ${indexingText ? `<div class="small fw-bold text-primary" style="font-size: 0.7rem;">Indexed: ${indexingText}</div>` : ''}
                    </td>
                    <td class="text-center" data-label="Action">
                        <button class="btn-rd-profile" onclick="openPubModal(${index})"><i class="fas fa-external-link-alt"></i> View</button>
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
            fetchPublications(targetUrl);
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
    window.openPubModal = function(index) {
        const pub = pubsData[index];
        document.getElementById('modal-title').textContent = pub.title;
        document.getElementById('modal-author').textContent = pub.full_author_list || 'N/A';
        document.getElementById('modal-venue').textContent = pub
            .name_of_journal_or_conference_or_publisher || 'N/A';
        document.getElementById('modal-date').textContent = pub.publication_date || 'N/A';
        document.getElementById('modal-dept').textContent = pub.department_name || 'N/A';
        document.getElementById('modal-type').textContent = pub.publication_type || 'PUBLICATION';

        const indexingBadge = document.getElementById('modal-indexing-badge');
        let indexingText = pub.indexing;
        if (indexingText === 'Others' && pub.others_indexing) {
            indexingText = pub.others_indexing;
        }
        if (indexingText) {
            indexingBadge.textContent = indexingText;
            indexingBadge.style.display = 'inline-block';
        } else {
            indexingBadge.style.display = 'none';
        }

        const linkContainer = document.getElementById('modal-link-container');
        const linkEl = document.getElementById('modal-link');
        if (pub.doi_url) {
            linkEl.href = pub.doi_url;
            linkContainer.style.display = 'block';
        } else {
            linkContainer.style.display = 'none';
        }

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
        debounceTimer = setTimeout(() => fetchPublications(), 400);
    };
    [deptFilter, startDate, endDate].forEach(el => el.onchange = () => fetchPublications());

    fetchPublications();
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

.modal-badge.indexing {
    background: #dbeafe;
    color: #1e40af;
}

.modal-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 25px;
    padding-top: 10px;
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

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
    white-space: nowrap;
}
</style>

<?php get_footer(); ?>