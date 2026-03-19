<?php
/*
Template Name: Departments Page
*/
defined('ABSPATH') || exit;
get_header();

$api_base = getenv('DJANGO_API_URL');
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
                    
                    <input type="text" id="dept-search" placeholder="Search departments...">

                   
                </div>

            </div>

            <!-- GRID -->
            <div id="departments-container"></div>

        </div>
    </div>

</div>

<script>
const API_URL = "<?php echo esc_js($api_url); ?>";

let allDepartments = [];

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
function renderDepartments(data) {
    const container = document.getElementById('departments-container');
    container.innerHTML = '';

    if (!data.length) {
        container.innerHTML = "<p class='dept-empty'>No departments found.</p>";
        return;
    }

    let html = '';

    data.forEach((dept, i) => {
        html += `
        <div class="dept-card" style="animation-delay:${i * 0.05}s">
            <h3>${dept.name}</h3>

            <a class="link-new1" href="/department/${dept.slug}">
                View Department
            </a>
        </div>
        `;
    });

    container.innerHTML = html;
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

    const filtered = allDepartments.filter(d =>
        d.name.toLowerCase().includes(search) &&
        (!school || d.school_name === school)
    );

    renderDepartments(filtered);
}

/* ================= EVENTS ================= */
document.getElementById('dept-search').addEventListener('input', applyFilters);
document.getElementById('school-filter').addEventListener('change', applyFilters);

/* ================= INIT ================= */
fetchDepartments();
</script>

<?php get_footer(); ?>