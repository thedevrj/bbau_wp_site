<?php
/*
Template Name: Departments Page
*/
defined('ABSPATH') || exit;
get_header();

$api_base = getenv('DJANGO_API_URL');
$api_url = $api_base . '/api/v1/departments/';

// Fetch data from API
$response = wp_remote_get($api_url . '?page_size=100', array('timeout' => 15));
$all_departments = array();

if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
    $all_departments = json_decode(wp_remote_retrieve_body($response), true);
    if (isset($all_departments['results'])) {
        $all_departments = $all_departments['results'];
    }
}

$schools = array();
if (is_array($all_departments)) {
    foreach ($all_departments as $d) {
        if (!empty($d['school_name'])) {
            $schools[] = $d['school_name'];
        }
    }
}
$schools = array_unique($schools);
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="page-bg">
    <div class="container py-lg-5">
        <div class="departments-section">

            <!-- HEADER -->
            <div class="dept-header">
                <h2>Departments</h2>

                <div class="dept-controls">
                    <select id="school-filter">
                        <option value="">Filter by School</option>
                        <?php foreach ($schools as $s): ?>
                            <option value="<?php echo esc_attr($s); ?>">
                                <?php echo esc_html($s); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select id="campus-filter">
                        <option value="">All Campuses</option>
                        <option value="BBAU">Main Campus (BBAU)</option>
                        <option value="Satellite Campus Amethi">Satellite Campus Amethi</option>
                    </select>

                    <input type="text" id="dept-search" placeholder="Search departments...">
                    <a href="<?php echo esc_url(get_permalink()); ?>"
                        class="btn-fac-profile">Reset</a>
                </div>
            </div>

            <!-- GRID -->
            <div id="departments-container">
                <?php if (empty($all_departments)): ?>
                    <p class="dept-empty" style="grid-column: 1 / -1; text-align: center; padding: 40px; font-weight: bold; color: #6b6880;">No departments found.</p>
                <?php else: ?>
                    <?php foreach ($all_departments as $dept): 
                        $displayCampus = ($dept['campus'] ?? 'BBAU') === 'Satellite Campus Amethi' ? ' (Amethi)' : '';
                    ?>
                        <div class="dept-card" data-school="<?php echo esc_attr($dept['school_name'] ?? ''); ?>" data-campus="<?php echo esc_attr($dept['campus'] ?? 'BBAU'); ?>">
                            <div class="card-header-flex">
                                <h3><?php echo esc_html($dept['name'] . $displayCampus); ?></h3>
                            </div>
                            <p><?php echo esc_html($dept['description'] ?? ''); ?></p>
                            <a class="dept-btn" href="<?php echo esc_url(home_url('/departments/' . $dept['slug'])); ?>">
                                View Department <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- PAGINATION -->
            <div class="dept-pagination">
                <button id="prev-page" class="pagination-btn">«</button>
                <span id="page-info" class="page-info"></span>
                <button id="next-page" class="pagination-btn">»</button>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('dept-search');
    const schoolFilter = document.getElementById('school-filter');
    const campusFilter = document.getElementById('campus-filter');
    const container = document.getElementById('departments-container');
    const prevBtn = document.getElementById('prev-page');
    const nextBtn = document.getElementById('next-page');
    const pageInfo = document.getElementById('page-info');

    const ITEMS_PER_PAGE = 16;
    let currentPage = 1;
    let filteredCards = [];

    // Parse initial state from URL query parameters
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('search') && searchInput) searchInput.value = urlParams.get('search');
    if (urlParams.get('school') && schoolFilter) schoolFilter.value = urlParams.get('school');
    if (urlParams.get('campus') && campusFilter) campusFilter.value = urlParams.get('campus');
    currentPage = parseInt(urlParams.get('page_num')) || 1;

    function updateURL() {
        const url = new URL(window.location.href);
        
        // Update page_num
        if (currentPage > 1) {
            url.searchParams.set('page_num', currentPage);
        } else {
            url.searchParams.delete('page_num');
        }

        // Update search query
        if (searchInput && searchInput.value.trim()) {
            url.searchParams.set('search', searchInput.value.trim());
        } else {
            url.searchParams.delete('search');
        }

        // Update school
        if (schoolFilter && schoolFilter.value) {
            url.searchParams.set('school', schoolFilter.value);
        } else {
            url.searchParams.delete('school');
        }

        // Update campus
        if (campusFilter && campusFilter.value) {
            url.searchParams.set('campus', campusFilter.value);
        } else {
            url.searchParams.delete('campus');
        }

        window.history.replaceState(null, '', url.toString());
    }

    function applyFiltersAndPagination(shouldUpdateURL = true) {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const school = schoolFilter ? schoolFilter.value : '';
        const campus = campusFilter ? campusFilter.value : '';
        const allCards = Array.from(container.querySelectorAll('.dept-card'));
        
        // 1. Filter
        filteredCards = allCards.filter(card => {
            const name = card.querySelector('h3').textContent.toLowerCase();
            const desc = card.querySelector('p').textContent.toLowerCase();
            const cardSchool = card.dataset.school;
            const cardCampus = card.dataset.campus;

            const matchesSearch = !query || name.includes(query) || desc.includes(query);
            const matchesSchool = !school || cardSchool === school;
            const matchesCampus = !campus || cardCampus === campus;

            return matchesSearch && matchesSchool && matchesCampus;
        });

        // Hide all cards first
        allCards.forEach(card => card.style.display = 'none');

        // Handle empty state
        let emptyMsg = container.querySelector('.dept-empty');
        const paginationContainer = document.querySelector('.dept-pagination');

        if (filteredCards.length === 0) {
            if (!emptyMsg) {
                emptyMsg = document.createElement('p');
                emptyMsg.className = 'dept-empty';
                emptyMsg.style.cssText = 'grid-column: 1 / -1; text-align: center; padding: 40px; font-weight: bold; color: #6b6880;';
                emptyMsg.textContent = 'No departments found.';
                container.appendChild(emptyMsg);
            } else {
                emptyMsg.style.display = '';
            }
            prevBtn.disabled = true;
            nextBtn.disabled = true;
            pageInfo.innerHTML = '';
            if (paginationContainer) paginationContainer.style.display = 'none';
            if (shouldUpdateURL) updateURL();
            return;
        } else {
            if (emptyMsg) emptyMsg.style.display = 'none';
        }

        // 2. Paginate
        const totalPages = Math.ceil(filteredCards.length / ITEMS_PER_PAGE);
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        if (paginationContainer) {
            if (totalPages <= 1) {
                paginationContainer.style.display = 'none';
            } else {
                paginationContainer.style.display = 'flex';
            }
        }

        const startIdx = (currentPage - 1) * ITEMS_PER_PAGE;
        const endIdx = startIdx + ITEMS_PER_PAGE;
        const pageCards = filteredCards.slice(startIdx, endIdx);

        // Show page cards
        pageCards.forEach(card => card.style.display = '');

        // Render page numbers in pageInfo
        let pageButtons = '';
        for (let i = 1; i <= totalPages; i++) {
            pageButtons += `
                <button class="page-num-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">
                    ${i}
                </button>
            `;
        }
        pageInfo.innerHTML = pageButtons;

        // Add event listeners to page numbers
        pageInfo.querySelectorAll('.page-num-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                currentPage = parseInt(e.target.dataset.page);
                applyFiltersAndPagination();
            });
        });

        // Enable/Disable navigation buttons
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;

        if (shouldUpdateURL) updateURL();
    }

    prevBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            applyFiltersAndPagination();
        }
    });

    nextBtn.addEventListener('click', () => {
        const totalPages = Math.ceil(filteredCards.length / ITEMS_PER_PAGE);
        if (currentPage < totalPages) {
            currentPage++;
            applyFiltersAndPagination();
        }
    });

    if (searchInput) searchInput.addEventListener('input', () => {
        currentPage = 1;
        applyFiltersAndPagination();
    });
    if (schoolFilter) schoolFilter.addEventListener('change', () => {
        currentPage = 1;
        applyFiltersAndPagination();
    });
    if (campusFilter) campusFilter.addEventListener('change', () => {
        currentPage = 1;
        applyFiltersAndPagination();
    });

    // Initial load (do not push state on page load)
    applyFiltersAndPagination(false);
});
</script>

<style>
.dept-pagination {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 40px;
    align-items: center;
}

.pagination-btn {
    padding: 10px 20px;
    background-color: #6c3fc5;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.pagination-btn:hover {
    background-color: #4b2aa8;
}

.pagination-btn:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.page-info {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 4px;
}

.page-num-btn {
    padding: 6px 12px;
    border: none;
    background: none;
    font-weight: bold;
    cursor: pointer;
    color: #333;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.page-num-btn:hover {
    background-color: rgba(108, 63, 197, 0.1);
}

.page-num-btn.active {
    color: #6c3fc5;
    background-color: rgba(108, 63, 197, 0.15);
}
</style>

<?php get_footer(); ?>