<?php
/*
Template Name: Departments Page
*/
defined('ABSPATH') || exit;
get_header();

$api_base = getenv('DJANGO_MEDIA_URL');
$api_url = $api_base . '/api/v1/departments/';
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="page-bg">

    <div class="container  py-lg-5">
        <div class="departments-section">

            <!-- HEADER -->
            <div class="dept-header">

                <h2>Departments</h2>

                <div class="dept-controls">
                    <select id="school-filter">
                        <option value="">Filter by School</option>
                    </select>
                    <select id="campus-filter">
                        <option value="">All Campuses</option>
                        <option value="BBAU">Main Campus (BBAU)</option>
                        <option value="Satellite Campus Amethi">Satellite Campus Amethi</option>
                    </select>
                    
                    <input type="text" id="dept-search" placeholder="Search departments...">

                   
                </div>

            </div>

            <!-- GRID -->
            <div id="departments-container"></div>

            <!-- PAGINATION -->
            <div class="dept-pagination">
                <button id="prev-page" class="pagination-btn">«</button>
                <span id="page-info" class="page-info"></span>
                <button id="next-page" class="pagination-btn">»</button>
            </div>

        </div>
    </div>

    
</div>

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
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.pagination-btn:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.page-info {
    font-weight: bold;
    min-width: 120px;
    text-align: center;
}
</style>

<script>
const API_URL = "<?php echo esc_js($api_url); ?>";
const ITEMS_PER_PAGE = 16;

let allDepartments = [];
let currentPage = 1;

/* ================= FETCH ================= */
async function fetchDepartments() {
    const container = document.getElementById('departments-container');

    try {
        container.innerHTML = "<p class='dept-empty'>Loading departments...</p>";

        const res = await fetch(API_URL);
        const data = await res.json();

        allDepartments = data;

        renderDepartments(data);
        populateSchoolFilter(data);

    } catch (err) {
        container.innerHTML =
            "<p class='dept-empty'>Failed to load departments. Please try again.</p>";
    }
}

/* ================= RENDER ================= */
function renderDepartments(departments) {
    const container = document.getElementById('departments-container');
    currentPage = 1;
    displayPage(departments);
}

function displayPage(departments) {
    const container = document.getElementById('departments-container');
    const startIdx = (currentPage - 1) * ITEMS_PER_PAGE;
    const endIdx = startIdx + ITEMS_PER_PAGE;
    const pageDepts = departments.slice(startIdx, endIdx);
    
    const totalPages = Math.ceil(departments.length / ITEMS_PER_PAGE);

    if (pageDepts.length === 0) {
        container.innerHTML = "<p class='dept-empty'>No departments found.</p>";
    } else {
        container.innerHTML = pageDepts.map(dept => {
            const displayCampus = dept.campus === 'Satellite Campus Amethi' ? ' (Amethi)' : '';            
            return `
            <div class="dept-card">
                <div class="card-header-flex">
                    <h3>${dept.name}${displayCampus}</h3>
                </div>
                <p>${dept.description || ''}</p>

                <a class="dept-btn" href="/departments/${dept.slug}">
                    View Department <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        `;}).join('');
    }

    updatePaginationControls(totalPages);
}

function updatePaginationControls(totalPages) {
    const pageInfoContainer = document.getElementById('page-info');
    let pageButtons = '';
    
    for (let i = 1; i <= totalPages; i++) {
        pageButtons += `
            <button class="page-num ${i === currentPage ? 'active' : ''}" data-page="${i}">
                ${i}
            </button>
        `;
    }
    
    pageInfoContainer.innerHTML = pageButtons;
    
    // Add click listeners to page buttons
    document.querySelectorAll('.page-num').forEach(btn => {
        btn.addEventListener('click', (e) => {
            currentPage = parseInt(e.target.dataset.page);
            displayPage(getFilteredDepartments());
        });
    });
    
    document.getElementById('prev-page').disabled = currentPage === 1;
    document.getElementById('next-page').disabled = currentPage === totalPages;
}

document.getElementById('prev-page').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        displayPage(getFilteredDepartments());
    }
});

document.getElementById('next-page').addEventListener('click', () => {
    const filtered = getFilteredDepartments();
    const totalPages = Math.ceil(filtered.length / ITEMS_PER_PAGE);
    if (currentPage < totalPages) {
        currentPage++;
        displayPage(filtered);
    }
});

function getFilteredDepartments() {
    // Apply existing filters (school filter + search)
    return allDepartments;
}

/* ================= FILTER DROPDOWN ================= */
function populateSchoolFilter(data) {
    const schools = [...new Set(data.map(d => d.school_name))];
    const filter = document.getElementById('school-filter');

    filter.innerHTML = `<option value="">Filter by School</option>`;

    schools.forEach(school => {
        const opt = document.createElement('option');
        opt.value = school;
        opt.textContent = school;
        filter.appendChild(opt);
    });
}

/* ================= FILTER FUNCTION ================= */
function applyFilters() {
    const search = document.getElementById('dept-search').value.toLowerCase();
    const school = document.getElementById('school-filter').value;
    const campus = document.getElementById('campus-filter').value;

    const filtered = allDepartments.filter(d =>
        d.name.toLowerCase().includes(search) &&
        (!school || d.school_name === school) &&
        (!campus || (d.campus || 'BBAU') === campus)
    );

    renderDepartments(filtered);
}

/* ================= EVENTS ================= */
document.getElementById('dept-search').addEventListener('input', applyFilters);
document.getElementById('school-filter').addEventListener('change', applyFilters);
document.getElementById('campus-filter').addEventListener('change', applyFilters);

/* ================= INIT ================= */
fetchDepartments();
</script>

<?php get_footer(); ?>