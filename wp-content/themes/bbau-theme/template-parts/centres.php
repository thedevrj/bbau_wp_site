<?php
/* Template Name: Centres Page */
get_header();

$api_base = getenv('DJANGO_MEDIA_URL');
$api_url = $api_base . '/api/v1/centres/';
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="centres-page">
    <div class="container-fluid">
        <div class="container">
        <?php get_template_part('menu/menu'); ?>

            <div class="centres-section">

                <!-- Controls -->
                <div class="controls-bar">

                    <div class="search-wrap">
                        <span class="search-icon">🔍</span>
                        <input type="text" id="search" placeholder="Search centres..." />
                    </div>

                    <div class="filter-wrap">
                        <span class="filter-icon">🎓</span>
                        <select id="schoolFilter">
                            <option value="">All Schools</option>
                        </select>
                    </div>

                </div>

                <!-- Cards -->
                <div id="centres-list"></div>

            </div>
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

    if (!centres.length) {
        container.innerHTML = `<div class="empty-state">No centres found</div>`;
        return;
    }

    centres.forEach((c, index) => {
        container.innerHTML += `
            <div class="centre-card">

                <!-- Header -->
                <div class="card-header">
                    <div class="card-header-name">${c.name}</div>
                </div>

                <!-- Body -->
                <div class="card-body">
                  ${c.school_name ? `
                  <div class="info-row">
                     <div class="info-icon ii-school">🏫</div>

                       <div class="info-text">
                       <span class="info-label">School</span>
                        <span class="info-val">${c.school_name}</span>
                  </div>
                 </div>` : ""}

                    <div class="info-row">
                        <div class="info-icon ii-dir">👤</div>
                        <div>
                            <span class="info-label">Director</span>
                            <span class="info-val">${c.director?.name}</span>
                        </div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="card-footer">
                    <a href="${c.slug}" class="view-btn">View</a>
                </div>

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

/* Search */
document.getElementById("search").addEventListener("input", function() {
    const value = this.value.toLowerCase();

    const filtered = allCentres.filter(c =>
        c.name.toLowerCase().includes(value)
    );

    renderCentres(filtered);
});

/* Filter */
document.getElementById("schoolFilter").addEventListener("change", function() {
    const value = this.value;

    const filtered = value ?
        allCentres.filter(c => c.school_name === value) :
        allCentres;

    renderCentres(filtered);
});

fetchCentres();
</script>
<style>
/* ============================================================
   CENTRES PAGE - FINAL CSS (FIXED SAME SIZE CARDS)
============================================================ */
/* ============================================================
   CENTRES PAGE - FINAL CSS (CLEAN + SAME SIZE + SEPARATE SEARCH)
============================================================ */

/* MAIN WRAPPER */
.centres-page {
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
    background: linear-gradient(140deg, #f0f7ff 0%, #e8f0fb 40%, #fdf0f8 75%, #f5f0ff 100%);
}

/* SECTION */
.centres-page .centres-section {
    padding: 35px 55px;
    max-width: 1400px;
    margin: auto;
}

/* ===============================
   CONTROLS (SEARCH + FILTER)
================================ */
.centres-page .controls-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 24px;
    padding: 14px 18px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 18px rgba(0, 0, 0, 0.05);
}

/* SEARCH */
.centres-page .search-wrap {
    flex: 1;
    max-width: 500px;
    position: relative;
}

.centres-page #search {
    width: 100%;
    padding: 10px 14px 10px 38px;
    border-radius: 10px;
    border: 1px solid #e0e6f2;
    background: #f6f8fd;
    font-size: 13px;
}

/* FILTER */
.centres-page .filter-wrap {
    min-width: 200px;
    position: relative;
}

.centres-page #schoolFilter {
    width: 100%;
    padding: 10px 12px 10px 36px;
    border-radius: 10px;
    border: 1px solid #e0e6f2;
    background: #f6f8fd;
    font-size: 13px;
    cursor: pointer;
}

/* ICONS */
.centres-page .search-icon,
.centres-page .filter-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 13px;
    color: #9aa3b5;
}

/* ===============================
   GRID
================================ */
.centres-page #centres-list {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}

/* ============================================================
   FORCE OVERRIDE (REMOVE THEME CONFLICT)
============================================================ */

/* TARGET ONLY CENTRES PAGE */
.centres-page .card-body {
    max-width: 100% !important;     /* FULL WIDTH */
    width: 100% !important;

    justify-content: flex-start !important; /* REMOVE CENTER */
    align-items: flex-start !important;

    padding: 12px 16px !important;  /* YOUR CUSTOM */
}

/* ALSO FIX INNER TEXT WRAPPER */
.centres-page .card-body * {
    max-width: 100% !important;
}

/* ENSURE FLEX WORKS PROPERLY */
.centres-page .card-body {
    display: flex !important;
    flex-direction: column !important;
}
/* ===============================
   CARD
================================ */
.centres-page .centre-card {
    height: 240px;
    display: flex;
    
    flex-direction: column;
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #e6ebf5;
    box-shadow: 0 6px 20px rgba(0,0,0,0.06);
    transition: 0.3s ease;
}

.centres-page .centre-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 35px rgba(0,0,0,0.12);
}

/* HEADER COLORS */
.centres-page .centre-card:nth-child(6n+1) .card-header {
    background: linear-gradient(135deg, #6c63ff, #8f87ff);
}
.centres-page .centre-card:nth-child(6n+2) .card-header {
    background: linear-gradient(135deg, #e85d8a, #f094b0);
}
.centres-page .centre-card:nth-child(6n+3) .card-header {
    background: linear-gradient(135deg, #2a9d8f, #52c5b8);
}
.centres-page .centre-card:nth-child(6n+4) .card-header {
    background: linear-gradient(135deg, #f4a261, #f7c48a);
}
.centres-page .centre-card:nth-child(6n+5) .card-header {
    background: linear-gradient(135deg, #4361ee, #7b9cff);
}
.centres-page .centre-card:nth-child(6n+6) .card-header {
    background: linear-gradient(135deg, #9d4edd, #c77dff);
}

/* HEADER */
.centres-page .card-header {
    height: 70px;
    display: flex;
    align-items: center;
    padding: 12px 16px;
    color: #fff;
}

/* TITLE */
.centres-page .card-header-name {
    flex: 1;
    min-width: 0;
    font-size: 15px;
    font-weight: 700;
    line-height: 1.3;

    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* BODY */
.centres-page .card-body {
    flex: 1;
    padding: 12px 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    overflow: hidden;
}

/* INFO ROW */
.centres-page .info-row {
    display: flex;
    gap: 8px;
    align-items: flex-start;
}

/* ICON */
.centres-page .info-icon {
    width: 30px;
    height: 30px;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: #fff;
    flex-shrink: 0;
}

.centres-page .ii-school {
    background: linear-gradient(135deg, #6c63ff, #9b8fff);
}
.centres-page .ii-dir {
    background: linear-gradient(135deg, #2a9d8f, #52c5b8);
}

/* TEXT FIX */
.centres-page .info-text,
.centres-page .info-row > div:last-child {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
}

/* LABEL */
.centres-page .info-label {
    font-size: 9px;
    color: #8c97b2;
}

/* VALUE */
.centres-page .info-val {
    font-size: 12.5px;
    font-weight: 600;
    color: #2a3555;

    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* FOOTER */
.centres-page .card-footer {
    padding: 8px 16px;
    border-top: 1px solid #eef1f7;
    display: flex;
    justify-content: flex-end;
}

/* BUTTON */
.centres-page .view-btn {
    font-size: 11px;
    padding: 5px 12px;
    border-radius: 18px;
    background: linear-gradient(135deg, #6c63ff, #8f87ff);
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.centres-page .view-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 14px rgba(108, 99, 255, 0.4);
}

/* EMPTY */
.centres-page .empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px;
}

/* ===============================
   RESPONSIVE
================================ */
@media (max-width: 1100px) {
    .centres-page #centres-list {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 700px) {
    .centres-page .centres-section {
        padding: 20px;
    }

    .centres-page .controls-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .centres-page .search-wrap,
    .centres-page .filter-wrap {
        max-width: 100%;
        width: 100%;
    }

    .centres-page #centres-list {
        grid-template-columns: 1fr;
    }
}
</style>
<?php get_footer(); ?>