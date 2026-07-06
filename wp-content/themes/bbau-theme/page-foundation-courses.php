<?php
/*
Template Name: Foundation Courses Template
*/
defined('ABSPATH') || exit;
get_header();

$api_base = getenv('DJANGO_API_URL');

$courses_url = $api_base . '/api/v1/foundation-courses/?page_size=40';
$courses_res = wp_remote_get($courses_url, array('timeout' => 15));
$courses = array();

if (!is_wp_error($courses_res) && wp_remote_retrieve_response_code($courses_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($courses_res), true);
    $courses = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="admissions-portal py-5">
    <div class="container">
        <?php get_template_part('template-parts/breadcrumb'); ?>

        <!-- INTRO & STATS -->
        <div class="row align-items-center mb-5 g-4">
            <div class="col-lg-8">
                <div class="fc-section-intro">
                    <h2 class="fc-main-title">Foundation Courses</h2>
                    <p class="fc-lead-text">
                        Foundation courses are designed to provide students with a broad and interdisciplinary academic
                        base, bridging foundational knowledge with advanced fields of study. Explore course syllabi and
                        access curated study materials for each course.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end d-none d-md-block">
                <div class="fc-stats-badge">
                    <span class="fc-stats-number" id="courses-count"><?php echo count($courses); ?></span>
                    <span class="fc-stats-label">Total Courses</span>
                </div>
            </div>
        </div>

        <!-- FILTER BAR -->
        <div class="adm-filter-bar sticky-top mb-5">
            <div class="filter-group">
                <label>Filter by Level</label>
                <div class="level-tabs">
                    <button class="level-tab active" data-level="all">All</button>
                    <button class="level-tab" data-level="UG">Undergraduate</button>
                    <button class="level-tab" data-level="PG">Postgraduate</button>
                </div>
            </div>

            <div class="filter-group">
                <label>Filter by Semester</label>
                <select id="semester-select" class="adm-select">
                    <option value="all">All Semesters</option>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                    <option value="4">Semester 4</option>
                </select>
            </div>

            <div class="filter-group explorer-search">
                <label>Search Courses</label>
                <input type="text" id="course-search" placeholder="Enter keywords..." class="adm-input">
            </div>
        </div>

        <!-- COURSES GRID -->
        <div id="course-grid">
            <?php if(!empty($courses)): ?>
            <div class="row g-4">
                <?php foreach($courses as $course): ?>
                <div class="col-md-6 col-lg-4 course-card-wrapper"
                    data-level="<?php echo esc_attr($course['level'] ?? ''); ?>"
                    data-semester="<?php echo esc_attr($course['semester'] ?? ''); ?>"
                    data-name="<?php echo esc_attr(strtolower($course['course_title'] ?? '')); ?> <?php echo esc_attr(strtolower($course['course_code'] ?? '')); ?>">

                    <div class="fc-card">
                        <!-- Top Meta Header -->
                        <div class="fc-card-header">
                            <span
                                class="fc-badge badge-level <?php echo esc_attr(strtolower($course['level'] ?? '')); ?>">
                                <?php echo esc_html($course['level'] ?? ''); ?>
                            </span>
                            <span class="fc-badge badge-semester">
                                Sem <?php echo esc_html($course['semester'] ?? ''); ?>
                            </span>
                            <span class="fc-badge badge-credits">
                                <?php echo esc_html($course['credits'] ?? '0'); ?> Credits
                            </span>
                        </div>

                        <!-- Course Title & Code -->
                        <div class="fc-card-body">
                            <div class="fc-course-code"><?php echo esc_html($course['course_code'] ?? ''); ?></div>
                            <h3 class="fc-course-title"><?php echo esc_html($course['course_title'] ?? ''); ?></h3>
                        </div>

                        <!-- Footer Actions -->
                        <div class="fc-card-footer">
                            <div class="fc-action-row">
                                <?php if (!empty($course['syllabus_file'])): ?>
                                <a href="<?php echo esc_url($course['syllabus_file']); ?>" target="_blank"
                                    class="fc-btn fc-btn-syllabus">
                                    <i class="fa-solid fa-file-pdf me-2"></i> Syllabus
                                </a>
                                <?php else: ?>
                                <span class="fc-btn fc-btn-disabled" title="Syllabus not uploaded yet">
                                    <i class="fa-solid fa-file-pdf me-2"></i> No Syllabus
                                </span>
                                <?php endif; ?>

                                <a href="/foundation-course-materials/?course_id=<?php echo esc_attr($course['id']); ?>"
                                    class="fc-btn fc-btn-materials">
                                    <i class="fa-solid fa-book-open me-2"></i> Materials
                                    <span
                                        class="materials-count"><?php echo count($course['materials'] ?? []); ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div id="no-results" class="text-center py-5" style="display:none;">
                <div class="no-results-icon mb-3">
                    <i class="fa-regular fa-folder-open fa-3x text-muted"></i>
                </div>
                <h3>No courses match your filters.</h3>
                <p>Try adjusting your search criteria or reset filters.</p>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <div class="no-results-icon mb-3">
                    <i class="fa-solid fa-graduation-cap fa-3x text-muted"></i>
                </div>
                <h3>No foundation courses found.</h3>
                <p>Please check back later or contact the administrator.</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div id="fc-pagination" class="fc-pagination mt-5"></div>

    </div>
</div>

<style>

:root {
    --fc-maroon: #8B1A1A;
    --fc-maroon-dark: #5c1010;
    --fc-gold: #c9a84c;
    --fc-gold-light: #e2d9cc;
    --fc-cream: #fdfaf6;
    --fc-text: #1e293b;
    --fc-border: rgba(226, 217, 204, 0.6);
}

.admissions-portal {
    background: var(--fc-cream);
    min-height: 80vh;
    font-family: 'Nunito', sans-serif;
}

.fc-main-title {
    font-family: 'Merriweather', serif;
    color: var(--fc-maroon-dark);
    font-size: 2.8rem;
    font-weight: 700;
    position: relative;
    display: inline-block;
    margin-bottom: 15px;
}

.fc-main-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -6px;
    width: 60px;
    height: 4px;
    background: var(--fc-gold);
    border-radius: 2px;
}

.fc-lead-text {
    color: #475569;
    font-size: 1.05rem;
    line-height: 1.6;
}

.fc-stats-badge {
    background: #fff;
    border: 1px solid var(--fc-gold-light);
    border-radius: 20px;
    padding: 20px 30px;
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
}

.fc-stats-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--fc-maroon-dark);
    line-height: 1;
}

.fc-stats-label {
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--fc-gold);
    margin-top: 5px;
}

.adm-filter-bar {
    background: #fff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    align-items: flex-end;
    margin-top: 0px;
    z-index: 1000;
    border: 1px solid #e2d9cc;
}

.filter-group {
    flex: 1;
    min-width: 200px;
}

.filter-group label {
    display: block;
    font-weight: 700;
    color: #5c1010;
    margin-bottom: 8px;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.level-tabs {
    display: flex;
    background: #f3f4f6;
    padding: 5px;
    border-radius: 8px;
    gap: 5px;
}

.level-tab {
    flex: 1;
    border: none;
    background: transparent;
    padding: 8px 12px;
    font-size: 0.85rem;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
    color: #444;
    white-space: nowrap;
}

.level-tab.active {
    background: #8B1A1A;
    color: #fff;
}

#course-search,
.adm-select,
.adm-input {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #e2d9cc;
    border-radius: 10px;
    font-size: 0.95rem;
    background-color: #fff;
    color: #444;
    transition: all 0.3s ease;
}

.adm-select:focus,
.adm-input:focus {
    outline: none;
    border-color: #8B1A1A;
    box-shadow: 0 0 0 3px rgba(139, 26, 26, 0.1);
}

/* CARDS STYLING */
.fc-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid var(--fc-border);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.fc-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 25px -5px rgba(139, 26, 26, 0.08), 0 10px 10px -5px rgba(139, 26, 26, 0.04);
    border-color: var(--fc-gold);
}

.fc-card-header {
    padding: 20px 24px 10px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
}

.fc-badge {
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-level.ug {
    background: #e0f2fe;
    color: #0369a1;
}

.badge-level.pg {
    background: #f3e8ff;
    color: #6b21a8;
}

.badge-semester {
    background: #f1f5f9;
    color: #475569;
}

.badge-credits {
    background: #fef3c7;
    color: #b45309;
    margin-left: auto;
}

.fc-card-body {
    padding: 10px 24px 20px;
    flex-grow: 1;
}

.fc-course-code {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--fc-gold);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

.fc-course-title {
    font-family: 'Merriweather', serif;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--fc-text);
    margin: 0;
    line-height: 1.4;
}

.fc-card-footer {
    padding: 20px 24px;
    background: #fafaf9;
    border-top: 1px solid var(--fc-border);
}

.fc-action-row {
    display: flex;
    gap: 12px;
}

.fc-btn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 16px;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    white-space: nowrap;
}

.fc-btn-syllabus {
    background: #fff;
    border: 1px solid var(--fc-gold);
    color: var(--fc-maroon) !important;
}

.fc-btn-syllabus:hover {
    background: var(--fc-cream);
    color: var(--fc-maroon-dark);
}

.fc-btn-materials {
    background: var(--fc-maroon);
    color: #fff !important;
}

.fc-btn-materials:hover {
    background: var(--fc-maroon-dark);
}

.fc-btn-disabled {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    color: #94a3b8;
    cursor: not-allowed;
}

.materials-count {
    background: rgba(255, 255, 255, 0.25);
    color: #fff;
    padding: 2px 8px;
    border-radius: 50px;
    font-size: 0.75rem;
    margin-left: 6px;
}

/* MATERIALS PANEL */
.fc-materials-panel {
    background: #fff;
    border-radius: 12px;
    border: 1px solid var(--fc-gold-light);
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
    overflow: hidden;
    animation: slideDown 0.3s ease-out;
}

.fc-panel-inner {
    padding: 15px;
}

.fc-panel-title {
    font-size: 0.85rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--fc-maroon-dark);
    margin-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 8px;
}

.fc-materials-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.fc-material-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #f8fafc;
}

.fc-material-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.fc-material-icon {
    font-size: 1.1rem;
    margin-top: 2px;
}

.fc-material-info {
    flex-grow: 1;
}

.fc-material-title {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: #334155;
    line-height: 1.3;
    margin-bottom: 4px;
}

.fc-material-links {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.fc-material-link-btn {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--fc-gold);
    text-decoration: none;
    transition: color 0.2s;
}

.fc-material-link-btn:hover {
    color: var(--fc-maroon);
}

/* PAGINATION */
.fc-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-top: 40px;
    flex-wrap: wrap;
}

.fc-pagination .page-btn {
    background: #fff;
    border: 1px solid var(--fc-gold-light);
    color: var(--fc-maroon);
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
}

.fc-pagination .page-btn:hover {
    background: var(--fc-cream);
    border-color: var(--fc-maroon);
}

.fc-pagination .page-btn.active {
    background: var(--fc-maroon);
    color: #fff;
    border-color: var(--fc-maroon);
}

.fc-pagination .page-btn.prev-next {
    background: transparent;
    border: none;
}

.fc-pagination .page-btn.prev-next:hover {
    color: var(--fc-maroon-dark);
}

/* ANIMATIONS */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 1200px) {
    .fc-action-row {
        flex-direction: column;
        gap: 8px;
    }

    .fc-btn {
        width: 100%;
    }
}

/* Medium tablets and down */
@media (max-width: 991px) {
    .fc-section-intro {
        text-align: center;
    }

    .fc-main-title::after {
        left: 50%;
        transform: translateX(-50%);
    }

    .fc-stats-badge {
        display: flex;
        max-width: 250px;
        margin: 15px auto 0;
    }

    .admissions-portal .text-lg-end {
        text-align: center !important;
    }

    .adm-filter-bar {
        margin-top: 0;
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }

    .level-tabs {
        flex-wrap: wrap;
    }

    .level-tab {
        flex: 1 1 auto;
    }
}

/* Small mobile devices */
@media (max-width: 480px) {
    .fc-card-header {
        flex-direction: row;
        justify-content: flex-start;
    }

    .badge-credits {
        margin-left: 0;
    }

    .fc-card-body {
        padding: 10px 16px 15px;
    }

    .fc-card-footer {
        padding: 15px 16px;
    }

    .fc-main-title {
        font-size: 2.2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.level-tab');
    const semesterSelect = document.getElementById('semester-select');
    const searchInput = document.getElementById('course-search');
    const cards = document.querySelectorAll('.course-card-wrapper');
    const noResults = document.getElementById('no-results');
    const coursesCountEl = document.getElementById('courses-count');

    let currentLevel = 'all';
    let currentSemester = 'all';
    let currentSearch = '';

    const urlParams = new URLSearchParams(window.location.search);
    let currentPage = urlParams.has('page_num') ? parseInt(urlParams.get('page_num')) : 1;
    if (isNaN(currentPage) || currentPage < 1) currentPage = 1;

    const itemsPerPage = 12;

    function updateURL() {
        const url = new URL(window.location);
        if (currentPage === 1) {
            url.searchParams.delete('page_num');
        } else {
            url.searchParams.set('page_num', currentPage);
        }
        if (window.location.search !== url.search) {
            window.history.pushState({}, '', url);
        }
    }

    window.addEventListener('popstate', function() {
        const params = new URLSearchParams(window.location.search);
        currentPage = params.has('page_num') ? parseInt(params.get('page_num')) : 1;
        if (isNaN(currentPage) || currentPage < 1) currentPage = 1;
        executeFilter(false);
    });

    function executeFilter(pushUrl = true) {
        let filteredCards = [];

        cards.forEach(card => {
            const level = card.dataset.level;
            const semester = card.dataset.semester;
            const name = card.dataset.name;

            const levelMatch = (currentLevel === 'all' || level === currentLevel);
            const semMatch = (currentSemester === 'all' || semester === currentSemester);
            const searchMatch = (currentSearch === '' || name.includes(currentSearch));

            if (levelMatch && semMatch && searchMatch) {
                filteredCards.push(card);
            } else {
                card.style.display = 'none';
            }
        });

        // Update count dynamically
        if (coursesCountEl) {
            coursesCountEl.textContent = filteredCards.length;
        }

        const maxPages = Math.ceil(filteredCards.length / itemsPerPage);
        if (maxPages > 0 && currentPage > maxPages) {
            currentPage = maxPages;
        }

        noResults.style.display = (filteredCards.length === 0) ? 'block' : 'none';

        renderPagination(filteredCards.length);
        showPage(filteredCards, currentPage);

        if (pushUrl) {
            updateURL();
        }
    }

    function filterCourses() {
        executeFilter(true);
    }

    function showPage(filteredCards, page) {
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        filteredCards.forEach((card, index) => {
            if (index >= startIndex && index < endIndex) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function renderPagination(totalItems) {
        const paginationContainer = document.getElementById('fc-pagination');
        if (!paginationContainer) return;

        paginationContainer.innerHTML = '';

        const totalPages = Math.ceil(totalItems / itemsPerPage);
        if (totalPages <= 1) return;

        // Previous button
        if (currentPage > 1) {
            const prevBtn = document.createElement('button');
            prevBtn.className = 'page-btn prev-next';
            prevBtn.innerHTML = '<i class="fas fa-chevron-left me-2"></i> Previous';
            prevBtn.onclick = () => {
                currentPage--;
                filterCourses();
                scrollToGrid();
            };
            paginationContainer.appendChild(prevBtn);
        }

        // Page buttons
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                const pageBtn = document.createElement('button');
                pageBtn.className = 'page-btn' + (i === currentPage ? ' active' : '');
                pageBtn.textContent = i;
                pageBtn.onclick = () => {
                    currentPage = i;
                    filterCourses();
                    scrollToGrid();
                };
                paginationContainer.appendChild(pageBtn);
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                const dots = document.createElement('span');
                dots.className = 'px-2 text-muted';
                dots.textContent = '...';
                paginationContainer.appendChild(dots);
            }
        }

        // Next button
        if (currentPage < totalPages) {
            const nextBtn = document.createElement('button');
            nextBtn.className = 'page-btn prev-next';
            nextBtn.innerHTML = 'Next <i class="fas fa-chevron-right ms-2"></i>';
            nextBtn.onclick = () => {
                currentPage++;
                filterCourses();
                scrollToGrid();
            };
            paginationContainer.appendChild(nextBtn);
        }
    }

    function scrollToGrid() {
        const grid = document.getElementById('course-grid');
        if (grid) {
            const offset = grid.getBoundingClientRect().top + window.scrollY - 120;
            window.scrollTo({
                top: offset,
                behavior: 'smooth'
            });
        }
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentLevel = this.dataset.level;
            currentPage = 1;
            filterCourses();
        });
    });

    semesterSelect.addEventListener('change', function() {
        currentSemester = this.value;
        currentPage = 1;
        filterCourses();
    });

    searchInput.addEventListener('input', function() {
        currentSearch = this.value.toLowerCase().trim();
        currentPage = 1;
        filterCourses();
    });



    // Initial load
    filterCourses();
});
</script>

<?php get_footer(); ?>