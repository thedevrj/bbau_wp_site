<?php
/*
Template Name: Foundation Course Materials Template
*/
defined('ABSPATH') || exit;
get_header();

$api_base = getenv('DJANGO_API_URL');
if (!$api_base) {
    $api_base = 'http://django-dev:8000';
}

// Fetch all courses with nested materials preloaded
$courses_url = $api_base . '/api/v1/foundation-courses/?page_size=500';
$courses_res = wp_remote_get($courses_url, array('timeout' => 15));
$courses = array();

if (!is_wp_error($courses_res) && wp_remote_retrieve_response_code($courses_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($courses_res), true);
    $courses = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="materials-hub-portal py-5">
    <div class="container">
        
        <!-- BREADCRUMB / GENERAL NAVIGATION -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div class="breadcrumb-wrap">
                <?php get_template_part('template-parts/breadcrumb'); ?>
            </div>
            <a href="/foundation-course/" class="fc-back-btn">
                <i class="fa-solid fa-arrow-left me-2"></i> View Courses Directory
            </a>
        </div>

        <?php if (!empty($courses)): ?>
            <div class="row g-4">
                
                <!-- LEFT SIDEBAR (Master Course List) -->
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="hub-sidebar-card">
                        <div class="sidebar-header mb-3">
                            <h4 class="sidebar-title">Courses List</h4>
                            <p class="sidebar-subtitle text-muted small">Select a course to view materials</p>
                            
                            <!-- Search and Filters inside Sidebar -->
                            <div class="sidebar-search-box mt-3">
                                <input type="text" id="sidebar-course-search" placeholder="Search course..." class="form-control sidebar-input">
                            </div>
                        </div>

                        <!-- Desktop Course Sidebar Menu (Hidden on Mobile) -->
                        <div class="desktop-sidebar-menu">
                            <!-- UG Section -->
                            <div class="sidebar-section-group" id="group-ug">
                                <div class="group-header">Undergraduate (UG)</div>
                                <div class="group-list" id="list-ug"></div>
                            </div>
                            
                            <!-- PG Section -->
                            <div class="sidebar-section-group mt-3" id="group-pg">
                                <div class="group-header">Postgraduate (PG)</div>
                                <div class="group-list" id="list-pg"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT CONTENT AREA (Detail View of Selected Course) -->
                <div class="col-lg-8 col-12">
                    
                    <!-- Mobile Course Dropdown (Visible only on Mobile/Tablet) -->
                    <div class="mobile-course-dropdown-card mb-4 d-lg-none">
                        <div class="mb-3">
                            <label for="mobile-course-search" class="form-label fw-bold small text-uppercase text-maroon mb-2">Search Course</label>
                            <input type="text" id="mobile-course-search" placeholder="Type course code or title..." class="form-control sidebar-input">
                        </div>
                        <div>
                            <label for="mobile-course-select" class="form-label fw-bold small text-uppercase text-maroon mb-2">Select Course</label>
                            <select id="mobile-course-select" class="form-select mobile-select">
                                <?php foreach ($courses as $c): ?>
                                    <option value="<?php echo esc_attr($c['id']); ?>">
                                        [<?php echo esc_html($c['level'] ?? ''); ?> - Sem <?php echo esc_html($c['semester'] ?? ''); ?>] <?php echo esc_html($c['course_code'] ?? ''); ?>: <?php echo esc_html($c['course_title'] ?? ''); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="hub-main-content-card">
                        
                        <!-- Course Title & Metadata Banner -->
                        <div class="selected-course-header mb-4 pb-4 border-bottom">
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="fc-badge badge-level" id="detail-level">UG</span>
                                <span class="fc-badge badge-semester" id="detail-semester">Semester 1</span>
                                <span class="fc-badge badge-credits" id="detail-credits">0 Credits</span>
                            </div>
                            <span class="course-code-sub" id="detail-code">AEC-101</span>
                            <h2 class="course-main-title mt-1" id="detail-title">Loading Course...</h2>
                            
                            <!-- Syllabus Download Link -->
                            <div class="mt-4" id="syllabus-btn-container">
                                <a href="#" target="_blank" class="fc-syllabus-download-btn" id="detail-syllabus-link">
                                    <i class="fa-solid fa-file-pdf me-2"></i> View Syllabus
                                </a>
                                <span class="fc-syllabus-download-btn disabled" id="detail-syllabus-disabled" style="display: none;">
                                    <i class="fa-solid fa-file-pdf me-2"></i> No Syllabus Uploaded
                                </span>
                            </div>
                        </div>

                        <!-- Materials Section -->
                        <div class="materials-hub-section">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="materials-section-title mb-0">Syllabus & Materials</h3>
                                <span class="materials-count-badge" id="detail-materials-count">0 Files Available</span>
                            </div>

                            <div class="row g-4" id="detail-materials-grid">
                                <!-- Dynamic Materials Cards Rendered by JS -->
                            </div>

                            <!-- Empty State for Materials -->
                            <div class="text-center py-5 no-materials-box" id="detail-empty-state" style="display: none;">
                                <i class="fa-regular fa-folder-open fa-3x text-muted mb-3"></i>
                                <h4>No study materials uploaded yet.</h4>
                                <p class="text-muted">Please check back later or contact your faculty member for reference notes.</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        <?php else: ?>
            <!-- EMPTY DIRECTORY STATE -->
            <div class="text-center py-5 error-box">
                <i class="fa-solid fa-circle-exclamation fa-3x text-danger mb-3"></i>
                <h3>No Courses Found</h3>
                <p class="text-muted">There are no courses loaded in the system to view materials for. Please verify backend configurations.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<style>
/* ============================================
   MATERIALS HUB - PREMIUM MOD-DOCS STYLE
   ============================================ */

:root {
    --fc-maroon: #8B1A1A;
    --fc-maroon-dark: #5c1010;
    --fc-gold: #c9a84c;
    --fc-gold-light: #e2d9cc;
    --fc-cream: #fdfaf6;
    --fc-text: #1e293b;
    --fc-border: rgba(226, 217, 204, 0.6);
}

.materials-hub-portal {
    background: var(--fc-cream);
    min-height: 85vh;
    font-family: 'Nunito', sans-serif;
}

.fc-back-btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    background: #fff;
    border: 1px solid var(--fc-gold-light);
    border-radius: 12px;
    color: var(--fc-maroon) !important;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02) !important;
}

.fc-back-btn:hover {
    background: var(--fc-maroon);
    color: #fff !important;
    border-color: var(--fc-maroon);
}

/* SIDEBAR CARD */
.hub-sidebar-card {
    background: #fff;
    border: 1px solid var(--fc-border);
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    position: sticky;
    top: 100px;
    max-height: calc(100vh - 140px);
    display: flex;
    flex-direction: column;
}

.sidebar-title {
    font-family: 'Merriweather', serif;
    color: var(--fc-maroon-dark);
    font-weight: 700;
    margin-bottom: 4px;
}

.sidebar-input {
    border: 1px solid var(--fc-gold-light);
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 0.9rem;
}

.sidebar-input:focus {
    border-color: var(--fc-maroon);
    box-shadow: 0 0 0 3px rgba(139, 26, 26, 0.1);
    outline: none;
}

.desktop-sidebar-menu {
    overflow-y: auto;
    flex-grow: 1;
    margin-top: 15px;
    padding-right: 5px;
}

/* Scrollbar styling for sidebar */
.desktop-sidebar-menu::-webkit-scrollbar {
    width: 6px;
}
.desktop-sidebar-menu::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}
.desktop-sidebar-menu::-webkit-scrollbar-thumb {
    background: var(--fc-gold-light);
    border-radius: 10px;
}
.desktop-sidebar-menu::-webkit-scrollbar-thumb:hover {
    background: var(--fc-gold);
}

.sidebar-section-group .group-header {
    font-weight: 800;
    font-size: 0.8rem;
    text-transform: uppercase;
    color: var(--fc-gold);
    letter-spacing: 1px;
    padding-bottom: 8px;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 8px;
}

.sidebar-course-link {
    display: block;
    padding: 10px 12px;
    border-radius: 8px;
    color: var(--fc-text);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 4px;
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
}

.sidebar-course-link:hover {
    background: #fdfaf6;
    color: var(--fc-maroon);
    border-left-color: var(--fc-gold-light);
}

.sidebar-course-link.active {
    background: #fef2f2;
    color: var(--fc-maroon);
    border-left-color: var(--fc-maroon);
    font-weight: 700;
}

.mobile-course-dropdown-card {
    background: #fff;
    border: 1px solid var(--fc-border);
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
}

.text-maroon {
    color: var(--fc-maroon) !important;
}

/* MOBILE DROPDOWN SELECTOR */
.mobile-select {
    display: block;
    width: 100%;
    box-sizing: border-box;
    border: 2px solid var(--fc-gold-light);
    border-radius: 12px;
    padding: 12px 40px 12px 16px;
    font-size: 0.95rem;
    font-weight: 600;
    line-height: 1.5;
    background: #fff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%238B1A1A' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") no-repeat right 16px center;
    background-size: 16px 12px;
    color: var(--fc-text);
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    cursor: pointer;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}
.mobile-select:focus {
    border-color: var(--fc-maroon);
    box-shadow: 0 0 0 3px rgba(139, 26, 26, 0.15);
    outline: none;
}

/* MAIN CONTENT CARD */
.hub-main-content-card {
    background: #fff;
    border: 1px solid var(--fc-border);
    border-radius: 20px;
    padding: 35px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    min-height: 500px;
}

.course-code-sub {
    font-size: 0.95rem;
    font-weight: 800;
    color: var(--fc-gold);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.course-main-title {
    font-family: 'Merriweather', serif;
    color: var(--fc-maroon-dark);
    font-size: 2rem;
    font-weight: 700;
    line-height: 1.3;
}

.fc-badge {
    padding: 5px 14px;
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
}

.fc-syllabus-download-btn {
    display: inline-flex;
    align-items: center;
    padding: 12px 24px;
    background: var(--fc-maroon);
    color: #fff !important;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 12px rgba(139, 26, 26, 0.15);
}

.fc-syllabus-download-btn:hover {
    background: var(--fc-maroon-dark);
    color: #fff !important;
    transform: translateY(-1px);
}

.fc-syllabus-download-btn.disabled {
    background: #f1f5f9;
    color: #94a3b8 !important;
    cursor: not-allowed;
    box-shadow: none;
}

/* MATERIALS */
.materials-section-title {
    font-family: 'Merriweather', serif;
    color: var(--fc-text);
    font-size: 1.4rem;
    font-weight: 700;
}

.materials-count-badge {
    background: #fff;
    border: 1px solid var(--fc-gold-light);
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--fc-gold);
}

.material-card {
    background: #fff;
    border: 1px solid var(--fc-border);
    border-radius: 16px;
    padding: 20px;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.material-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(139, 26, 26, 0.05);
    border-color: var(--fc-gold);
}

.material-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.material-icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.material-icon-circle.video {
    background: #fef2f2;
    color: #ef4444;
}

.material-icon-circle.link {
    background: #eff6ff;
    color: #3b82f6;
}

.material-icon-circle.document,
.material-icon-circle.others {
    background: #f0fdf4;
    color: #22c55e;
}

.material-type-tag {
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    color: #64748b;
    letter-spacing: 1px;
}

.material-card-body {
    flex-grow: 1;
    margin-bottom: 20px;
}

.material-title {
    font-family: 'Merriweather', serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--fc-text);
    margin: 0;
    line-height: 1.4;
}

.material-card-footer {
    display: flex;
    border-top: 1px solid #f1f5f9;
    padding-top: 15px;
}

.material-btn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
}

.material-btn.btn-download {
    background: var(--fc-maroon);
    color: #fff;
}

.material-btn.btn-download:hover {
    background: var(--fc-maroon-dark);
}

.material-btn.btn-link {
    background: #fff;
    border: 1px solid var(--fc-gold);
    color: var(--fc-maroon);
}

.material-btn.btn-link:hover {
    background: var(--fc-cream);
}

/* ERROR STATE / BOXES */
.error-box, .no-materials-box {
    background: #fff;
    border: 1px solid var(--fc-border);
    border-radius: 20px;
    padding: 50px 30px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.01);
}

/* ============================================
   RESPONSIVENESS
   ============================================ */

@media (max-width: 991px) {
    .hub-sidebar-card {
        position: relative;
        top: 0;
        max-height: none;
    }
    .hub-main-content-card {
        padding: 24px;
        min-height: auto;
    }
    .course-main-title {
        font-size: 1.7rem;
    }
}

@media (max-width: 576px) {
    .material-card-footer .d-flex {
        flex-direction: column;
        gap: 8px !important;
    }
}
</style>

<!-- Preload the PHP courses array into JS -->
<script>
    const coursesData = <?php echo json_encode($courses); ?>;
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (!coursesData || coursesData.length === 0) return;

    const listUg = document.getElementById('list-ug');
    const listPg = document.getElementById('list-pg');
    const searchInput = document.getElementById('sidebar-course-search');
    const mobileSelect = document.getElementById('mobile-course-select');
    const mobileSearchInput = document.getElementById('mobile-course-search');

    // Detail Panel Elements
    const detailTitle = document.getElementById('detail-title');
    const detailCode = document.getElementById('detail-code');
    const detailLevel = document.getElementById('detail-level');
    const detailSemester = document.getElementById('detail-semester');
    const detailCredits = document.getElementById('detail-credits');
    const detailSyllabusLink = document.getElementById('detail-syllabus-link');
    const detailSyllabusDisabled = document.getElementById('detail-syllabus-disabled');
    const detailMaterialsCount = document.getElementById('detail-materials-count');
    const detailMaterialsGrid = document.getElementById('detail-materials-grid');
    const detailEmptyState = document.getElementById('detail-empty-state');

    let activeCourseId = null;

    // 1. Group Courses and Render Desktop Sidebar Links
    function renderSidebar(filterQuery = '') {
        listUg.innerHTML = '';
        listPg.innerHTML = '';

        let ugCount = 0;
        let pgCount = 0;

        coursesData.forEach(course => {
            const code = course.course_code || '';
            const title = course.course_title || '';
            const combinedName = `${code} ${title}`.toLowerCase();

            if (filterQuery !== '' && !combinedName.includes(filterQuery)) {
                return; // skip if searched and not matching
            }

            const level = course.level || 'UG';
            
            // Create sidebar link
            const a = document.createElement('a');
            a.href = '#';
            a.className = 'sidebar-course-link';
            if (course.id === activeCourseId) {
                a.classList.add('active');
            }
            a.innerHTML = `<span class="fw-bold me-1">${code}:</span> ${title}`;
            a.dataset.id = course.id;

            a.addEventListener('click', function(e) {
                e.preventDefault();
                selectCourse(course.id);
            });

            if (level === 'UG') {
                listUg.appendChild(a);
                ugCount++;
            } else {
                listPg.appendChild(a);
                pgCount++;
            }
        });

        // Toggle visibility of sidebar headings based on results
        document.getElementById('group-ug').style.display = (ugCount > 0) ? 'block' : 'none';
        document.getElementById('group-pg').style.display = (pgCount > 0) ? 'block' : 'none';
    }

    // 1b. Render Options for Mobile Select Dropdown
    function renderMobileSelect(filterQuery = '') {
        if (!mobileSelect) return;
        mobileSelect.innerHTML = '';

        coursesData.forEach(course => {
            const code = course.course_code || '';
            const title = course.course_title || '';
            const combinedName = `${code} ${title}`.toLowerCase();

            if (filterQuery !== '' && !combinedName.includes(filterQuery)) {
                return; // skip if searched and not matching
            }

            const option = document.createElement('option');
            option.value = course.id;
            option.textContent = `[${course.level || ''} - Sem ${course.semester || ''}] ${code}: ${title}`;
            if (course.id === activeCourseId) {
                option.selected = true;
            }
            mobileSelect.appendChild(option);
        });
    }

    // 2. Select a course and update Detail view
    function selectCourse(courseId) {
        activeCourseId = parseInt(courseId);
        
        // Find course data
        const course = coursesData.find(c => parseInt(c.id) === activeCourseId);
        if (!course) return;

        // Update URL Parameter quietly
        const url = new URL(window.location);
        url.searchParams.set('course_id', activeCourseId);
        window.history.pushState({}, '', url);

        // Update active class in sidebar links
        document.querySelectorAll('.sidebar-course-link').forEach(link => {
            if (parseInt(link.dataset.id) === activeCourseId) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });

        // Sync mobile dropdown select
        if (mobileSelect) {
            // Check if option exists in filtered set. If not, reset filter
            if (![...mobileSelect.options].some(o => parseInt(o.value) === activeCourseId)) {
                renderMobileSelect('');
                if (mobileSearchInput) mobileSearchInput.value = '';
            }
            mobileSelect.value = activeCourseId;
        }

        // Render main content area details
        renderCourseDetails(course);
    }

    // 3. Render course details inside the Right panel
    function renderCourseDetails(course) {
        detailTitle.textContent = course.course_title || 'Untitled';
        detailCode.textContent = course.course_code || '';
        detailCredits.textContent = `${course.credits || 0} Credits`;
        detailSemester.textContent = `Semester ${course.semester || ''}`;

        // Level badge class and text
        const lvl = (course.level || 'UG').toUpperCase();
        detailLevel.textContent = lvl;
        detailLevel.className = `fc-badge badge-level ${lvl.toLowerCase()}`;

        // Syllabus handling
        if (course.syllabus_file) {
            detailSyllabusLink.href = course.syllabus_file;
            detailSyllabusLink.style.display = 'inline-flex';
            detailSyllabusDisabled.style.display = 'none';
        } else {
            detailSyllabusLink.style.display = 'none';
            detailSyllabusDisabled.style.display = 'inline-flex';
        }

        // Materials grid rendering
        const materials = course.materials || [];
        detailMaterialsCount.textContent = `${materials.length} File${materials.length !== 1 ? 's' : ''} Available`;
        
        detailMaterialsGrid.innerHTML = '';

        if (materials.length > 0) {
            detailEmptyState.style.display = 'none';
            
            materials.forEach(material => {
                const col = document.createElement('div');
                col.className = 'col-md-6';
                
                const type = material.material_type || 'Document';
                const typeLower = type.toLowerCase();
                
                let iconHtml = '<i class="fa-solid fa-file-pdf"></i>';
                if (type === 'Video') {
                    iconHtml = '<i class="fa-solid fa-play"></i>';
                } else if (type === 'Link') {
                    iconHtml = '<i class="fa-solid fa-link"></i>';
                }

                let buttonsHtml = '';
                if (material.file) {
                    buttonsHtml += `
                        <a href="${material.file}" target="_blank" class="material-btn btn-download">
                            Download File <i class="fa-solid fa-download ms-2"></i>
                        </a>
                    `;
                }
                if (material.link) {
                    buttonsHtml += `
                        <a href="${material.link}" target="_blank" class="material-btn btn-link">
                            Open Link <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                        </a>
                    `;
                }

                col.innerHTML = `
                    <div class="material-card">
                        <div class="material-card-header">
                            <div class="material-icon-circle ${typeLower}">
                                ${iconHtml}
                            </div>
                            <span class="material-type-tag">${type}</span>
                        </div>
                        <div class="material-card-body">
                            <h4 class="material-title">${material.title || 'Untitled Material'}</h4>
                        </div>
                        <div class="material-card-footer">
                            <div class="d-flex gap-2 w-100">
                                ${buttonsHtml}
                            </div>
                        </div>
                    </div>
                `;
                
                detailMaterialsGrid.appendChild(col);
            });
        } else {
            detailEmptyState.style.display = 'block';
        }
    }

    // 4. Initial Selection & URL Routing
    const urlParams = new URLSearchParams(window.location.search);
    let initId = urlParams.get('course_id');
    
    // Default to first course if no query var is set
    if (!initId && coursesData.length > 0) {
        initId = coursesData[0].id;
    }

    activeCourseId = parseInt(initId);
    
    // First render & selection
    renderSidebar();
    renderMobileSelect();
    selectCourse(activeCourseId);

    // 5. Search Bar Keyup Event
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            renderSidebar(query);
        });
    }

    // 5b. Mobile Search Bar Keyup Event
    if (mobileSearchInput) {
        mobileSearchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            renderMobileSelect(query);
            // Auto-select first match on typing to update detail view instantly
            if (mobileSelect.options.length > 0) {
                selectCourse(mobileSelect.options[0].value);
            }
        });
    }

    // 6. Mobile Dropdown Change Event
    if (mobileSelect) {
        mobileSelect.addEventListener('change', function() {
            selectCourse(this.value);
        });
    }

    // 7. Popstate event for back navigation sync
    window.addEventListener('popstate', function() {
        const params = new URLSearchParams(window.location.search);
        let currentId = params.get('course_id');
        if (!currentId && coursesData.length > 0) {
            currentId = coursesData[0].id;
        }
        if (currentId && parseInt(currentId) !== activeCourseId) {
            selectCourse(currentId);
        }
    });
});
</script>

<?php get_footer(); ?>
