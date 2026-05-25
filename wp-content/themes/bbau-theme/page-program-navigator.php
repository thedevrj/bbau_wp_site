<?php
/*
Template Name: Program Navigator Template
*/
defined('ABSPATH') || exit;
get_header();

$api_base = getenv('DJANGO_API_URL');

$dept_url = $api_base . '/api/v1/departments/';
$programs_url = $api_base . '/api/v1/programs/?page_size=500' ;

// Fetch Department for the filter
$dept_res = wp_remote_get($dept_url, array('timeout' => 10));
$Departments = array();
if (!is_wp_error($dept_res) && wp_remote_retrieve_response_code($dept_res) === 200) {
    $Departments = json_decode(wp_remote_retrieve_body($dept_res), true);
}

// Fetch All Programs
$programs_res = wp_remote_get($programs_url, array('timeout' => 15));
$programs = array();
if (!is_wp_error($programs_res) && wp_remote_retrieve_response_code($programs_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($programs_res), true);
    $programs = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="admissions-portal py-lg-5">
    <div class="container">

        <!-- HEADER SECTION -->
        <div class="adm-header mb-5">
            <h2 class="adm-title">Program Navigator</h2>
        </div>

        <!-- FILTER BAR -->
        <div class="adm-filter-bar sticky-top">
            <div class="filter-group">
                <label>Filter by Level</label>
                <div class="level-tabs">
                    <button class="level-tab active" data-level="all">All</button>
                    <button class="level-tab" data-level="UG">Undergraduate</button>
                    <button class="level-tab" data-level="PG">Postgraduate</button>
                    <button class="level-tab" data-level="PHD">PhD</button>
                    <button class="level-tab" data-level="Integrated">Integrated</button>
                    <button class="level-tab" data-level="Others">Others</button>

                </div>
            </div>

            <div class="filter-group">
                <label>Filter by Department</label>
                <select id="school-select" class="adm-select">
                    <option value="all">All Departments</option>
                    <?php foreach($Departments as $department): ?>
                    <option value="<?php echo esc_attr($department['id'] ?? ''); ?>">
                        <?php echo esc_html(get_dept_display_name($department)); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group explorer-search">
                <label>Search Programs</label>
                <input type="text" id="prog-search" placeholder="Enter keywords..." class="adm-input">
            </div>
        </div>

        <!-- PROGRAMS GRID -->
        <div id="prog-grid" class="mt-5">
            <?php if(!empty($programs)): ?>
            <div class="row g-4">
                <?php foreach($programs as $prog): ?>
                <div class="col-md-6 col-lg-4 prog-card-wrapper" data-level="<?php echo esc_attr($prog['level']); ?>"
                    data-dept="<?php echo esc_attr($prog['department'] ?? ''); ?>"
                    data-name="<?php echo esc_attr(strtolower($prog['name'])); ?>">
                    <?php 
                            set_query_var('prog_data', $prog);
                            get_template_part('template-parts/program-card'); 
                            ?>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="no-results" class="text-center py-5" style="display:none;">
                <h3>No programs match your filters.</h3>
                <p>Try adjusting your criteria or reset the filters.</p>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <h3>No programs found.</h3>
            </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div id="prog-pagination" class="adm-pagination mt-5"></div>

    </div>
</div>

<style>
.admissions-portal {
    background: #fdfaf6;
    min-height: 80vh;
}

.adm-header {
    text-align: center;
    border-bottom: 2px solid #e2d9cc;
    padding-bottom: 30px;
}

.adm-title {
    font-family: 'Merriweather', serif;
    color: #5c1010;
    font-size: 3rem;
    font-weight: 700;
}


/* FILTER BAR */
.adm-filter-bar {
    background: #fff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    align-items: flex-end;
    margin-top: -40px;
    z-index: 1000;
    border: 1px solid #e2d9cc;
}

.filter-group {
    flex: 1;
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
}

.level-tab.active {
    background: #8B1A1A;
    color: #fff;
}

#prog-search,
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

/* RESPONSIVE */
@media (max-width: 991px) {
    .adm-filter-bar {
        margin-top: 0;
        flex-direction: column;
        align-items: stretch;
    }
    
    .level-tabs {
        flex-wrap: wrap;
    }
    
    .level-tab {
        flex: 1 1 auto;
    }
}

/* PAGINATION */
.adm-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-top: 40px;
    flex-wrap: wrap;
}

.adm-pagination .page-btn {
    background: #fff;
    border: 1px solid #e2d9cc;
    color: #5c1010;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.adm-pagination .page-btn:hover {
    background: #fdfaf6;
    border-color: #5c1010;
}

.adm-pagination .page-btn.active {
    background: #5c1010;
    color: #fff;
    border-color: #5c1010;
}

.adm-pagination .page-btn.prev-next {
    background: transparent;
    border: none;
}

.adm-pagination .page-btn.prev-next:hover {
    color: #8B1A1A;
    background: transparent;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.level-tab');
    const schoolSelect = document.getElementById('school-select');
    const searchInput = document.getElementById('prog-search');
    const cards = document.querySelectorAll('.prog-card-wrapper');
    const noResults = document.getElementById('no-results');

    let currentLevel = 'all';
    let currentDept = 'all';
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
        // Only push if URL actually changed
        if (window.location.search !== url.search) {
            window.history.pushState({}, '', url);
        }
    }

    window.addEventListener('popstate', function() {
        const params = new URLSearchParams(window.location.search);
        currentPage = params.has('page_num') ? parseInt(params.get('page_num')) : 1;
        if (isNaN(currentPage) || currentPage < 1) currentPage = 1;

        // We shouldn't call updateURL() inside popstate because the URL is already updated
        executeFilter(false);
    });

    function executeFilter(pushUrl = true) {
        let filteredCards = [];

        cards.forEach(card => {
            const level = card.dataset.level;
            const dept = card.dataset.dept;
            const name = card.dataset.name;

            const levelMatch = (currentLevel === 'all' || level === currentLevel);
            const deptMatch = (currentDept === 'all' || dept === currentDept);
            const searchMatch = (currentSearch === '' || name.includes(currentSearch));

            if (levelMatch && deptMatch && searchMatch) {
                filteredCards.push(card);
            } else {
                card.style.display = 'none';
            }
        });

        // Ensure currentPage isn't out of bounds after filtering
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

    function filterPrograms() {
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
        
        equalizeCardHeights();
    }

    function equalizeCardHeights() {
        // Reset all min-heights first
        cards.forEach(cardWrapper => {
            const card = cardWrapper.querySelector('.adm-card');
            if(card) card.style.minHeight = '0px';
        });
        
        const visibleCards = Array.from(cards).filter(c => c.style.display !== 'none');
        if (visibleCards.length === 0) return;
        
        let maxHeight = 0;
        
        // Calculate max base height
        visibleCards.forEach(cardWrapper => {
            const card = cardWrapper.querySelector('.adm-card');
            const details = card.querySelector('.adm-card-details');
            const wasOpen = details.style.display === 'block';
            
            // Hide details temporarily to measure true base height
            if (wasOpen) details.style.display = 'none';
            
            const cardHeight = card.offsetHeight;
            if (cardHeight > maxHeight) {
                maxHeight = cardHeight;
            }
            
            if (wasOpen) details.style.display = 'block';
        });

        // Apply max height to visible cards
        visibleCards.forEach(cardWrapper => {
            const card = cardWrapper.querySelector('.adm-card');
            card.style.minHeight = maxHeight + 'px';
        });
    }

    // Recalculate on window resize
    window.addEventListener('resize', () => {
        equalizeCardHeights();
    });

    function renderPagination(totalItems) {
        const paginationContainer = document.getElementById('prog-pagination');
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
                filterPrograms();
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
                    filterPrograms();
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
                filterPrograms();
                scrollToGrid();
            };
            paginationContainer.appendChild(nextBtn);
        }
    }

    function scrollToGrid() {
        const grid = document.getElementById('prog-grid');
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
            currentPage = 1; // reset to first page on filter change
            filterPrograms();
        });
    });

    schoolSelect.addEventListener('change', function() {
        currentDept = this.value;
        currentPage = 1; // reset to first page on filter change
        filterPrograms();
    });

    searchInput.addEventListener('input', function() {
        currentSearch = this.value.toLowerCase().trim();
        currentPage = 1; // reset to first page on filter change
        filterPrograms();
    });

    // Initial load
    filterPrograms();
});
</script>

<?php get_footer(); ?>