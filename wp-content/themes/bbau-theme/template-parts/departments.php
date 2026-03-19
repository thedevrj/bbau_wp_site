<?php
/*
Template Name: Departments Page
*/
defined('ABSPATH') || exit;
get_header();

$api_base = getenv('DJANGO_MEDIA_URL');
$api_url = $api_base . '/api/v1/departments/';
?>

<?php get_template_part( 'banners/about-banner' ); ?>
<div class="container-fluid page-bg py-lg-5 overflow-hidden">

    <div class="departments-section">

        <h2>Departments</h2>

        <!-- Search -->
        <input type="text" id="dept-search" placeholder="Search departments...">

        <!-- Filter -->
        <select id="school-filter">
            <option value="">Filter by Schools</option>
        </select>

        <!-- Grid -->
        <div id="departments-container"></div>

    </div>

    <script>
    const API_URL = "<?php echo $api_url; ?>";

    let allDepartments = [];

    async function fetchDepartments() {
        const res = await fetch(API_URL);
        const data = await res.json();

        allDepartments = data;
        renderDepartments(data);
        populateSchoolFilter(data);
    }

    function renderDepartments(data) {
        const container = document.getElementById('departments-container');
        container.innerHTML = '';

        data.forEach(dept => {
            container.innerHTML += `
            <div class="dept-card">
                 <h3>${dept.name}</h3>
              
                <a class="link-new" href="/department/${dept.slug}">View Department</a>
            </div>
        `;
        });
    }

    function populateSchoolFilter(data) {
        const schools = [...new Set(data.map(d => d.school_name))];
        const filter = document.getElementById('school-filter');

        schools.forEach(school => {
            filter.innerHTML += `<option value="${school}">${school}</option>`;
        });
    }

    // 🔍 Search
    document.getElementById('dept-search').addEventListener('input', function() {
        const value = this.value.toLowerCase();

        const filtered = allDepartments.filter(d =>
            d.name.toLowerCase().includes(value)
        );

        renderDepartments(filtered);
    });

    // 🎯 Filter
    document.getElementById('school-filter').addEventListener('change', function() {
        const value = this.value;

        if (!value) return renderDepartments(allDepartments);

        const filtered = allDepartments.filter(d =>
            d.school_name === value
        );

        renderDepartments(filtered);
    });

    fetchDepartments();
    </script>
</div>
    <?php get_footer(); ?>