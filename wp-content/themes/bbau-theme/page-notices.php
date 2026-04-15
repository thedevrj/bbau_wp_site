<?php
/**
 * Template Name: Notice Portal
 *
 * @package BBAU_Theme
 */

get_header();
?>

<div class="notice-portal-page">
    <div class="container-fluid">
        <div class="container">

    
    
        <h1 class="portal-title mb-4">Notice Portal</h1>

        <!-- Filter Section -->
        <div class="filter-section p-4 mb-4 bg-light rounded shadow-sm">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Search Notices</label>
                    <input type="text" id="notice-search" class="form-control" placeholder="Search by title or keyword...">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Category</label>
                    <select id="notice-category" class="form-select">
                        <option value="">All Categories</option>
                        <option value="Academic">Academic</option>
                        <option value="Examination">Examination</option>
                        <option value="Admission">Admission</option>
                        <option value="Scholarship">Scholarship</option>
                        <option value="Recruitment">Recruitment</option>
                        <option value="Tenders">Tenders</option>
                        <option value="Event">Events</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Source</label>
                    <select id="notice-source" class="form-select">
                        <option value="all">All Sources</option>
                        <option value="global">University Wide</option>
                        <option value="dept">Departmental</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button id="reset-filters" class="btn btn-outline-secondary w-100">Reset</button>
                </div>
            </div>
        </div>

        <!-- Notices Container -->
        <div id="notices-list" class="notices-container">
            <div class="text-center py-5 loading-spinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted text-uppercase fw-bold">Fetching latest notices...</p>
            </div>
        </div>

        <!-- Pagination -->
        <div id="pagination-container" class="mt-4 d-flex justify-content-center"></div>
    </div>
</div>
</div>

<style>
    .notice-portal-page {
        background-color: #f8fafc;
        min-height: 80vh;
    }
    .portal-title {
        color: #1e293b;
        font-weight: 800;
        border-bottom: 4px solid #4169e1;
        display: inline-block;
        padding-bottom: 5px;
    }
    .filter-section {
        background: #fff !important;
        border: 1px solid #e2e8f0;
    }
    .notice-card {
        background: #fff;
        border-radius: 8px;
        border-left: 5px solid #4169e1;
        transition: all 0.3s ease;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .notice-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .notice-card.source-global {
        border-left-color: #dc2626; /* Red for University-wide */
    }
    .notice-card.source-dept {
        border-left-color: #059669; /* Green for Dept */
    }
    .notice-date {
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 600;
    }
    .notice-category-badge {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
        text-transform: uppercase;
        font-weight: 700;
        margin-right: 10px;
    }
    .badge-Academic { background: #dbeafe; color: #1e40af; }
    .badge-Examination { background: #fef3c7; color: #92400e; }
    .badge-Admission { background: #dcfce7; color: #166534; }
    .badge-Recruitment { background: #f3e8ff; color: #6b21a8; }
    .badge-Tenders { background: #ffedd5; color: #9a3412; }
    .badge-General { background: #e2e8f0; color: #475569; }

    .new-badge {
        background: #ef4444;
        color: #fff;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 4px;
        vertical-align: middle;
        margin-left: 8px;
        animation: blink 1.5s infinite;
    }
    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    .download-btn {
        background-color: #4169e1;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: background 0.2s;
    }
    .download-btn:hover {
        background-color: #191970;
        color: white;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const apiBase = 'http://172.35.0.45:8001/api/v1';
    let allNotices = [];
    let filteredNotices = [];

    const listContainer = document.getElementById('notices-list');
    const searchInput = document.getElementById('notice-search');
    const categorySelect = document.getElementById('notice-category');
    const sourceSelect = document.getElementById('notice-source');
    const resetBtn = document.getElementById('reset-filters');

    async function fetchAllNotices() {
        try {
            // Fetch both endpoints
            const [globalRes, deptRes] = await Promise.all([
                fetch(`${apiBase}/global-notices/`),
                fetch(`${apiBase}/notices/`)
            ]);

            const globalData = await globalRes.json();
            const deptData = await deptRes.json();

            // Tag sources
            const global = (globalData.results || globalData).map(n => ({
                ...n,
                source: 'global',
                sourceLabel: 'University Wide',
                // Global notice uses 'categories' array, we'll take the first or join them
                portalCategory: n.categories ? n.categories[0] : 'General',
                date: new Date(n.date_posted)
            }));

            const dept = (deptData.results || deptData).map(n => ({
                ...n,
                source: 'dept',
                sourceLabel: n.department_name || 'Departmental',
                portalCategory: n.category || 'General',
                date: new Date(n.date_posted)
            }));

            allNotices = [...global, ...dept].sort((a, b) => b.date - a.date);
            applyFilters();

        } catch (error) {
            console.error('Error fetching notices:', error);
            listContainer.innerHTML = '<div class="alert alert-danger">Failed to load notices. Please check your connection to the backend.</div>';
        }
    }

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const categoryVal = categorySelect.value;
        const sourceVal = sourceSelect.value;

        filteredNotices = allNotices.filter(notice => {
            const matchesSearch = notice.title.toLowerCase().includes(searchTerm);
            const matchesCategory = !categoryVal || notice.portalCategory === categoryVal || (notice.categories && notice.categories.includes(categoryVal));
            const matchesSource = sourceVal === 'all' || notice.source === sourceVal;
            return matchesSearch && matchesCategory && matchesSource;
        });

        renderNotices();
    }

    function renderNotices() {
        if (filteredNotices.length === 0) {
            listContainer.innerHTML = '<div class="text-center py-5"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/no-results.png" style="width:100px; opacity:0.5;"><p class="mt-3 text-muted">No notices found matching your criteria.</p></div>';
            return;
        }

        const now = new Date();
        const oneWeekAgo = new Date(now.getTime() - (7 * 24 * 60 * 60 * 1000));

        listContainer.innerHTML = filteredNotices.map(notice => {
            const isNew = notice.date >= oneWeekAgo;
            const formattedDate = notice.date.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });

            const category = notice.portalCategory || 'General';
            const attachmentUrl = notice.attachment;

            return `
                <div class="notice-card source-${notice.source} d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div class="notice-info flex-grow-1 pe-md-4">
                        <div class="mb-2">
                             <span class="notice-category-badge badge-${category}">${category}</span>
                             <span class="notice-date">${formattedDate}</span>
                             <span class="ms-3 text-muted" style="font-size:0.8rem;">[${notice.sourceLabel}]</span>
                        </div>
                        <h5 class="mb-1 fw-bold">
                            ${notice.title}
                            ${isNew ? '<span class="new-badge">NEW</span>' : ''}
                        </h5>
                    </div>
                    <div class="notice-actions mt-3 mt-md-0 d-flex gap-2">
                        ${attachmentUrl ? `<a href="${attachmentUrl}" target="_blank" class="download-btn"><i class="fas fa-download me-1"></i> Download</a>` : ''}
                        ${notice.link ? `<a href="${notice.link}" target="_blank" class="btn btn-outline-primary btn-sm">External Link</a>` : ''}
                    </div>
                </div>
            `;
        }).join('');
    }

    // Event Listeners
    searchInput.addEventListener('input', applyFilters);
    categorySelect.addEventListener('change', applyFilters);
    sourceSelect.addEventListener('change', applyFilters);
    resetBtn.addEventListener('click', () => {
        searchInput.value = '';
        categorySelect.value = '';
        sourceSelect.value = 'all';
        applyFilters();
    });

    fetchAllNotices();
});
</script>

<?php get_footer(); ?>
