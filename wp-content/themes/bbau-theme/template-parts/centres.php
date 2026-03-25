<?php
/* Template Name: Centres Page */
get_header();

$api_base = getenv('DJANGO_MEDIA_URL');
$api_url = $api_base . '/api/v1/centres/';
?>
<?php get_template_part('banners/about-banner'); ?>
<div class="container-fluid page-bg">
    <div class="container">


        <div class="centres-section">
            <h2>Centres</h2>

            <input type="text" id="search" placeholder="Search centres..." />

            <select id="schoolFilter">
                <option value="">All Schools</option>
            </select>

            <div id="centres-list"></div>
        </div>
    </div>
</div>
<script>
const API_URL = "<?php echo $api_url; ?>";

let allCentres = [];

async function fetchCentres() {
    const res = await fetch(API_URL);
    const data = await res.json();

    allCentres = data;

    renderCentres(data);
    populateSchoolFilter(data);
}

function renderCentres(centres) {
    const container = document.getElementById("centres-list");
    container.innerHTML = "";

    centres.forEach(c => {
        container.innerHTML += `
            <div class="centre-card">
                <h3>${c.name}</h3>
                ${c.school_name ? `<p><strong>School:</strong> ${c.school_name}</p>` : ""}
                <p><strong>Director:</strong> ${c.director?.name || "N/A"}</p>
            </div>
        `;
    });
}

function populateSchoolFilter(centres) {
    const select = document.getElementById("schoolFilter");

    const schools = [...new Set(centres.map(c => c.school_name).filter(Boolean))];

    schools.forEach(s => {
        select.innerHTML += `<option value="${s}">${s}</option>`;
    });
}

document.getElementById("search").addEventListener("input", function() {
    const value = this.value.toLowerCase();

    const filtered = allCentres.filter(c =>
        c.name.toLowerCase().includes(value)
    );

    renderCentres(filtered);
});

document.getElementById("schoolFilter").addEventListener("change", function() {
    const value = this.value;

    const filtered = value ?
        allCentres.filter(c => c.school_name === value) :
        allCentres;

    renderCentres(filtered);
});

fetchCentres();
</script>

<?php get_footer(); ?>