<?php
/**
 * Template Name: Appointment - Others
 *
 * @package BBAU_Theme
 */

get_header();

$media_base = getenv('DJANGO_MEDIA_URL');
$banner_url = "/wp-content/uploads/2026/04/language.png"; 
?>

<div class="satellite-campus-portal notice-portal-brand">
    <?php get_template_part('banners/about-banner'); ?>


    <div class="container py-5">
        <?php get_template_part('template-parts/breadcrumb'); ?>
        <?php get_template_part('menu/menu'); ?>

        <!-- SEARCH & FILTER BAR -->
        <div class="sc-content-card mb-4">
            <div class="row g-3">
                <div class="col-lg-5 col-md-6">
                    <div class="sc-search-wrap">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="notice-search" class="form-control"
                            placeholder="Search in Other Appointments...">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <select id="notice-timeline" class="form-select sc-select">
                        <option value="all">Any Time</option>
                        <option value="7">Last 7 Days</option>
                        <option value="15">Last 15 Days</option>
                        <option value="30">Last 30 Days</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <select id="notice-sort" class="form-select sc-select">
                        <option value="desc">Newest First</option>
                        <option value="asc">Oldest First</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <button id="reset-filters" class="btn sc-btn-gold w-100">Reset</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <section class="sc-section">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="sc-section-title mb-0">Other Appointments</h2>
                        <span class="sc-count-badge" id="result-count">0</span>
                    </div>

                    <div id="notices-list" class="sc-notice-grid">
                        <!-- Shimmers -->
                        <div class="sc-shimmer"></div>
                        <div class="sc-shimmer"></div>
                        <div class="sc-shimmer"></div>
                    </div>
                    <nav id="notice-pagination" class="notice-pagination" aria-label="Notice pages"></nav>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
    const mediaBase = "<?= $media_base ?>";
    const apiBase = isLocal ? 'http://localhost:8001/api/v1' : `${mediaBase}/api/v1`;
    const appointmentType = "Others";

    let allNotices = [];
    const initialPage = parseInt(new URLSearchParams(window.location.search).get('page'), 10);
    let currentPage = Number.isInteger(initialPage) && initialPage > 0 ? initialPage : 1;
    const noticesPerPage = 20;

    const listContainer = document.getElementById('notices-list');
    const searchInput = document.getElementById('notice-search');
    const timelineSelect = document.getElementById('notice-timeline');
    const sortSelect = document.getElementById('notice-sort');
    const resetBtn = document.getElementById('reset-filters');
    const resultCount = document.getElementById('result-count');

    function updatePageUrl(page) {
        const url = new URL(window.location.href);
        if (page > 1) url.searchParams.set('page', page);
        else url.searchParams.delete('page');
        window.history.replaceState({
            page
        }, '', url);
    }

    async function fetchNotices() {
        listContainer.innerHTML = `
            <div class="sc-shimmer"></div>
            <div class="sc-shimmer"></div>
            <div class="sc-shimmer"></div>`;
        try {
            const url =
                `${apiBase}/global-notices/?category=Appointment&appointment_type=${encodeURIComponent(appointmentType)}&limit=100`;
            const response = await fetch(url);
            if (!response.ok) throw new Error('Network error');
            const data = await response.json();
            const list = Array.isArray(data) ? data : (data.results || []);

            // Strict client-side filter as backup
            allNotices = list.filter(notice => {
                const cats = Array.isArray(notice.categories) ? notice.categories : [notice
                    .categories
                ];
                const isAppointment = cats.includes('Appointment');
                const matchesType = notice.appointment_type === appointmentType;
                return isAppointment && matchesType;
            });

            render();
        } catch (e) {
            console.error('Error fetching appointment notices:', e);
            listContainer.innerHTML = `
                <div class="sc-empty-state">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <h3>Unable to load notices</h3>
                    <p>Please check back shortly.</p>
                </div>`;
            resultCount.textContent = '0';
        }
    }

    function render() {
        let filtered = [...allNotices];

        const query = searchInput.value.toLowerCase().trim();
        if (query) {
            filtered = filtered.filter(n => (n.title || '').toLowerCase().includes(query));
        }

        const days = timelineSelect.value;
        if (days !== 'all') {
            const cutoff = new Date();
            cutoff.setDate(cutoff.getDate() - parseInt(days, 10));
            filtered = filtered.filter(n => new Date(n.date_posted) >= cutoff);
        }

        const sort = sortSelect.value;
        filtered.sort((a, b) => {
            const da = new Date(a.date_posted);
            const db = new Date(b.date_posted);
            return sort === 'asc' ? da - db : db - da;
        });

        resultCount.textContent = filtered.length;

        if (filtered.length === 0) {
            listContainer.innerHTML = `
                <div class="sc-empty-state">
                    <i class="fa-solid fa-folder-open"></i>
                    <h3>No notices found</h3>
                    <p>There are currently no active ${appointmentType} appointment notices.</p>
                </div>`;
            document.getElementById('notice-pagination').innerHTML = '';
            return;
        }

        const totalPages = Math.ceil(filtered.length / noticesPerPage);
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const start = (currentPage - 1) * noticesPerPage;
        const pageItems = filtered.slice(start, start + noticesPerPage);

        listContainer.innerHTML = '<div class="sc-notice-table-head text-center"><span>S.No</span><span>Date Posted</span><span>Advertisement</span><span>Action</span></div>' + pageItems.map((notice, itemIndex) => {
            const postedDate = new Date(notice.date_posted);
            const formattedDate = !isNaN(postedDate) ?
                postedDate.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                }).replace(/\//g, '/') :
                (notice.date_posted || '');

            let targetUrl = '#';
            if (notice.internal_link) {
                targetUrl = notice.internal_link;
            } else if (notice.link) {
                targetUrl = notice.link;
            } else if (notice.attachment) {
                targetUrl = notice.attachment.startsWith('http') ? notice.attachment :
                    `${mediaBase}${notice.attachment}`;
            }

            return `
                <article class="sc-notice-card text-center">
                    <div class="sc-notice-number">${start + itemIndex + 1}</div>
                    <div class="sc-notice-meta">
                        <time datetime="${notice.date_posted}" class="sc-notice-date">
                            <i class="fa-regular fa-calendar me-1"></i> ${formattedDate}
                        </time>
                    </div>
                    <h3 class="sc-notice-heading">
                        <a href="${targetUrl}" target="_blank" rel="noopener noreferrer">${notice.title}</a>
                    </h3>
                    <div class="sc-notice-footer">
                        <a href="${targetUrl}" class="sc-notice-link" target="_blank" rel="noopener noreferrer">
                            View  <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                    </div>
                </article>`;
        }).join('');

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        const pagination = document.getElementById('notice-pagination');
        pagination.innerHTML = '';
        const addButton = (label, page, disabled = false, current = false) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = `notice-page-btn${current ? ' active' : ''}`;
            button.innerHTML = label === '<' ?
                '<i class="fa-solid fa-chevron-left" style="font-size:.7rem;" aria-hidden="true"></i>' :
                label === '>' ?
                '<i class="fa-solid fa-chevron-right" style="font-size:.7rem;" aria-hidden="true"></i>' :
                label;
            button.disabled = disabled;
            if (current) button.setAttribute('aria-current', 'page');
            button.setAttribute('aria-label', label === '<' ? 'Previous page' : label === '>' ?
                'Next page' : `Page ${page}`);
            button.addEventListener('click', () => {
                currentPage = page;
                updatePageUrl(currentPage);
                render();
                document.getElementById('notices-list').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
            pagination.appendChild(button);
        };

        addButton('<', currentPage - 1, currentPage === 1);
        for (let page = 1; page <= totalPages; page++) {
            if (totalPages > 7 && page > 2 && page < totalPages - 1 && Math.abs(page - currentPage) > 1) {
                if (page === 3 || page === totalPages - 2) {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'notice-page-ellipsis';
                    ellipsis.textContent = '…';
                    pagination.appendChild(ellipsis);
                }
                continue;
            }
            addButton(String(page), page, false, page === currentPage);
        }
        addButton('>', currentPage + 1, currentPage === totalPages);
    }

    // Filter Listeners
    [searchInput, timelineSelect, sortSelect].forEach(el => {
        const updateResults = () => {
            currentPage = 1;
            render();
        };
        el.addEventListener('change', updateResults);
        if (el === searchInput) el.addEventListener('input', updateResults);
    });

    resetBtn.addEventListener('click', () => {
        searchInput.value = '';
        timelineSelect.value = 'all';
        sortSelect.value = 'desc';
        currentPage = 1;
        render();
    });

    fetchNotices();
});
</script>

<?php get_footer(); ?>
