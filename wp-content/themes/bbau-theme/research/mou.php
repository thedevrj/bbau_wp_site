<?php
/**
 * Template Name: MOU Template
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
                <div class="badge-new-rd1">Collaborations</div>
                <h1 style="font-size: 2rem;">Memorandums of Understanding (MOU)</h1>
            </div>
        </div>
    </section>

    <div class="research-container container">
        <?php get_template_part('template-parts/breadcrumb');?>

        <!-- PREMIUM GLASS FILTERS -->
        <div class="ra-glass-filters animate-up mt-4" style="animation-delay: 0.1s;">
            <div class="ra-search-box">
                <i class="fas fa-search ra-search-icon"></i>
                <input type="text" id="mou-search" placeholder="Search by organization name or nature..."
                    autocomplete="off">
            </div>

            <div class="ra-filter-group">
                <div class="filter-item">
                    <label>From Signing Date</label>
                    <input type="date" id="start-date" class="ra-select">
                </div>
                <div class="filter-item">
                    <label>To Signing Date</label>
                    <input type="date" id="end-date" class="ra-select">
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT CARD -->
        <div class="rd-card-premium mt-5 animate-up mb-4" style="animation-delay: 0.2s;">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h2 class="rd-section-title m-0"> MOUs</h2>
                <span class="badge bg-light text-dark px-3 py-2 border rounded-pill" id="record-count"
                    style="font-weight: 700; font-size: 0.8rem;">
                    Syncing registry...
                </span>
            </div>

            <div class="table-responsive">
                <table class="premium-table" id="mou-table">
                    <thead>
                        <tr>
                            <th>Partner / Organization</th>
                            <th>Nature of Organization</th>
                            <th>Date of Signing</th>
                            <th>Valid Till</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="mou-tbody">
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="rd-loader"></div>
                                <p class="mt-3 text-muted">Accessing MOU records...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="pagination-controls" class="pagination-wrapper"></div>
        </div>
    </div>

    <!-- ENHANCED MOU MODAL -->
    <div id="mouModal" class="premium-modal">
        <div class="modal-glass-overlay"></div>
        <div class="premium-modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-badge mb-3">MOU AGREEMENT</div>
            <h2 id="modal-org-name" class="mb-4" style="font-size: 1.8rem; font-weight: 700; color: var(--rd-indigo);">
                Organization Name</h2>

            <div class="modal-grid mb-4">
                <div class="modal-info-item">
                    <label>Nature of Organization</label>
                    <div id="modal-nature" class="info-val"></div>
                </div>
                <div class="modal-info-item">
                    <label>Date of Signing</label>
                    <div id="modal-date-signing" class="info-val"></div>
                </div>
                <div class="modal-info-item">
                    <label>Valid Till</label>
                    <div id="modal-valid-till" class="info-val"></div>
                </div>
            </div>

            <div class="modal-desc-section">
                <label class="d-block mb-2"
                    style="font-weight: 700; text-transform: uppercase; font-size: 0.75rem; color: #64748b;">Description</label>
                <div id="modal-description" class="modal-abstract"></div>
            </div>
            
            <div class="mt-4" id="modal-doc-container" style="display: none;">
                <a href="#" id="modal-doc-btn" class="btn btn-primary" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-file-pdf me-2"></i> View Document
                </a>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const searchInput = document.getElementById('mou-search');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const tbody = document.getElementById('mou-tbody');
    const recordCount = document.getElementById('record-count');
    const paginationControls = document.getElementById('pagination-controls');
    const apiBase = "<?php echo esc_js($api_base); ?>";

    const modal = document.getElementById('mouModal');
    const closeBtn = document.querySelector('.close-modal');

    let mouData = [];
    let debounceTimer;

    function fetchMOUs(url = null) {
        if (!url) {
            const query = searchInput.value.toLowerCase().trim();
            const start = startDate.value;
            const end = endDate.value;

            url = `${apiBase}/api/v1/mous/?page_size=10&`;
            if (query) url += `search=${encodeURIComponent(query)}&`;
            if (start) url += `mou_date_after=${encodeURIComponent(start)}&`;
            if (end) url += `mou_date_before=${encodeURIComponent(end)}&`;
        }

        tbody.innerHTML =
        `<tr><td colspan="5" class="text-center py-5"><div class="rd-loader"></div></td></tr>`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                mouData = data.results || [];
                renderTable(mouData);
                renderPagination(data);
                recordCount.textContent =
                    `Displaying ${mouData.length} of ${data.count || mouData.length} MOUs`;
            })
            .catch(err => {
                tbody.innerHTML =
                    `<tr><td colspan="5" class="text-danger text-center py-4">Error loading records.</td></tr>`;
            });
    }

    function renderTable(mous) {
        if (mous.length === 0) {
            tbody.innerHTML =
                `<tr><td colspan="5" class="text-center py-5 text-muted">No records found.</td></tr>`;
            return;
        }

        tbody.innerHTML = mous.map((m, index) => {
            const nature = (m.Nature_of_organization === 'Others' && m.other_nature_of_organization) ? m.other_nature_of_organization : m.Nature_of_organization;
            
            // Format dates slightly nicer if possible, otherwise use original
            let signingDate = m.date_of_signing || '-';
            let validTill = m.valid_till || '-';
            
            return `
                <tr class="animate-up" style="animation-delay: ${index * 0.05}s">
                    <td class="fw-bold" data-label="Partner / Organization" style="color: var(--rd-royal); max-width: 350px;">
                        ${m.organization_name}
                    </td>
                    <td data-label="Nature">${nature || '-'}</td>
                    <td data-label="Signed">${signingDate}</td>
                    <td data-label="Valid Till">${validTill}</td>
                    <td class="text-center" data-label="Action">
                        <button class="btn-rd-profile" onclick="openMOUModal(${index})">
                            <i class="fas fa-search-plus"></i> View Details
                        </button>
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
            fetchMOUs(targetUrl);
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
    
    window.openMOUModal = function(index) {
        const m = mouData[index];
        const nature = (m.Nature_of_organization === 'Others' && m.other_nature_of_organization) ? m.other_nature_of_organization : m.Nature_of_organization;
        
        document.getElementById('modal-org-name').textContent = m.organization_name;
        document.getElementById('modal-nature').textContent = nature || 'N/A';
        document.getElementById('modal-date-signing').textContent = m.date_of_signing || 'N/A';
        document.getElementById('modal-valid-till').textContent = m.valid_till || 'N/A';
        
        document.getElementById('modal-description').innerHTML = m.description ||
            '<p class="text-muted">No description available.</p>';

        const docContainer = document.getElementById('modal-doc-container');
        const docBtn = document.getElementById('modal-doc-btn');
        if (m.document) {
            docBtn.href = m.document;
            docContainer.style.display = 'block';
        } else {
            docContainer.style.display = 'none';
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
        debounceTimer = setTimeout(() => fetchMOUs(), 400);
    };
    
    [startDate, endDate].forEach(el => el.onchange = () => fetchMOUs());

    fetchMOUs();
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
    background: #e0e7ff;
    color: #3730a3;
    letter-spacing: 1px;
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

.btn-primary {
    background-color: var(--rd-royal);
    border: none;
    padding: 10px 20px;
    border-radius: 20px;
    font-weight: 600;
    text-decoration: none;
    color: white !important;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-primary:hover {
    background-color: var(--rd-indigo);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}
</style>

<?php get_footer(); ?>
