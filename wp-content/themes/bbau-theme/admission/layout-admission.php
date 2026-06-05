<?php
/**
 * Layout for Admission Categories
 * 
 * Expected variables:
 * $admission_category (e.g. 'UG', 'PG', 'PHD')
 * $admission_title (e.g. 'Undergraduate Admissions')
 */

get_header();

$media_base = getenv('DJANGO_MEDIA_URL');
// Fallback banner
$banner_url = "/wp-content/uploads/2026/04/language.png";
?>

<div class="satellite-campus-portal admission-portal-brand">
    <!-- HERO SECTION -->
    <div class="sc-hero" style="background-image: url('<?php echo esc_url($banner_url); ?>');">
        <div class="sc-hero-overlay">
            <div class="sc-hero-card">
                <span class="sc-badge">Admission Portal</span>
                <h1><?php echo esc_html($admission_title ?? 'Admissions'); ?></h1>
                <div class="sc-hero-line"></div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div id="stream-content">
            <!-- FILTER PILLS NAVIGATION -->
            <div class="sc-filter-nav mb-5 text-center">
                <button class="sc-pill active" data-target="notices">
                    <i class="fa-solid fa-bullhorn me-2"></i> Notices
                </button>
                <button class="sc-pill" data-target="prospectuses">
                    <i class="fa-solid fa-file-pdf me-2"></i> Prospectus
                </button>
                <button class="sc-pill" data-target="registration">
                    <i class="fa-solid fa-link me-2"></i> Registration
                </button>
                <button class="sc-pill" data-target="counselling">
                    <i class="fa-solid fa-trophy me-2"></i> Counselling & Merit Lists
                </button>
            </div>

            <!-- CONTENT AREA -->
            <section class="sc-section">
                <!-- Loading State -->
                <div id="loader" class="text-center py-5 d-none">
                    <div class="spinner-border text-gold" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <!-- Notices Tab -->
                <div id="tab-notices" class="admission-tab-content">
                    <h2 class="sc-section-title mb-4 text-center d-block">Notices & Updates</h2>
                    <div id="notices-list" class="row g-4"></div>
                </div>

                <!-- Prospectuses Tab -->
                <div id="tab-prospectuses" class="admission-tab-content d-none">
                    <h2 class="sc-section-title mb-4 text-center d-block">Prospectus & Brochures</h2>
                    <div class="row g-4 justify-content-center" id="prospectuses-list"></div>
                </div>

                <!-- Registration Tab -->
                <div id="tab-registration" class="admission-tab-content d-none">
                    <h2 class="sc-section-title mb-4 text-center d-block">Registration Portals</h2>
                    <div class="row g-4 justify-content-center" id="registration-list"></div>
                </div>

                <!-- Counselling & Results Tab -->
                <div id="tab-counselling" class="admission-tab-content d-none">
                    <h2 class="sc-section-title mb-4 text-center d-block">Counselling Phases & Merit Lists</h2>
                    
                    <ul class="nav nav-pills mb-4 justify-content-center phase-tabs gap-2" id="phase-tabs" role="tablist">
                    </ul>

                    <div class="tab-content" id="phase-tabs-content">
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<style>
/* Same CSS as Satellite Campus styling token */
:root {
    --sc-midnight: #0f172a;
    --sc-slate: #1e293b;
    --sc-gold: #c9a84c;
    --sc-gold-light: #e2d9cc;
    --sc-bg: #fdfaf6;
}

.admission-portal-brand {
    background-color: var(--sc-bg);
    min-height: 100vh;
    font-family: 'Nunito', sans-serif;
    color: var(--sc-slate);
}

.text-gold {
    color: var(--sc-gold) !important;
}

/* hero banner css */
.sc-hero {
    height: 300px;
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sc-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.7));
}

.sc-hero-overlay {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 800px;
    padding: 20px;
}

.sc-hero-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 25px;
    border-radius: 30px;
    text-align: center;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    color: #fff;
    animation: fadeInScale 0.8s ease-out;
}

.sc-badge {
    background: var(--sc-gold);
    color: var(--sc-midnight);
    padding: 6px 20px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 2px;
    display: inline-block;
    margin-bottom: 15px;
}

.sc-hero-card h1 {
    font-family: 'Merriweather', serif;
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 10px;
    text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
}

.sc-hero-card p {
    font-size: 1.2rem;
    letter-spacing: 3px;
    text-transform: uppercase;
    opacity: 0.9;
}

.sc-hero-line {
    width: 80px;
    height: 4px;
    background: var(--sc-gold);
    margin: 20px auto 0;
    border-radius: 2px;
}

/* PILL NAVIGATION */
.sc-filter-nav {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    background: #fff;
    padding: 15px;
    border-radius: 50px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--sc-gold-light);
}

.sc-pill, .sc-pill-sm {
    background: transparent;
    border: none;
    padding: 10px 25px;
    border-radius: 50px;
    font-weight: 700;
    color: var(--sc-slate);
    transition: 0.3s;
    font-size: 0.95rem;
}

.sc-pill-sm {
    padding: 8px 20px;
    font-size: 0.9rem;
    border: 1px solid var(--sc-gold-light);
    background: #fff;
}

.sc-pill:hover, .sc-pill-sm:hover {
    color: var(--sc-midnight);
    background: #f1f5f9;
}

.sc-pill.active, .sc-pill-sm.active {
    background: var(--sc-midnight) !important;
    color: var(--sc-gold) !important;
    box-shadow: 0 5px 15px rgba(15, 23, 42, 0.2);
    border-color: var(--sc-midnight);
}

/* SECTION TITLES */
.sc-section-title {
    font-family: 'Merriweather', serif;
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--sc-midnight);
    position: relative;
    display: inline-block;
}

.sc-section-title::after {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: -8px;
    width: 60px;
    height: 3px;
    background: var(--sc-gold);
}

/* CARDS GRID */
.sc-notice-card {
    background: #fff;
    border: 1px solid var(--sc-gold-light);
    padding: 25px;
    border-radius: 18px;
    display: flex;
    flex-direction: column;
    gap: 15px;
    text-decoration: none !important;
    transition: all 0.3s ease;
    color: var(--sc-slate);
    height: 100%;
}

.sc-notice-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
    border-color: var(--sc-gold);
}

.sc-notice-icon {
    width: 50px;
    height: 50px;
    background: #fdfaf6;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: var(--sc-gold);
    margin-bottom: 5px;
}

.sc-notice-info h3 {
    font-family: 'Merriweather', serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--sc-midnight);
    margin-bottom: 10px;
}

.sc-notice-meta {
    font-size: 0.85rem;
    font-weight: 600;
    color: #64748b;
}

/* DOC CARDS */
.sc-doc-card {
    background: #fff;
    border: 1px solid var(--sc-gold-light);
    padding: 25px;
    border-radius: 18px;
    text-align: center;
    transition: 0.3s;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-decoration: none !important;
}

.sc-doc-card:hover {
    transform: translateY(-5px);
    border-color: var(--sc-gold);
    box-shadow: 0 10px 20px rgba(201, 168, 76, 0.15);
}

.sc-doc-icon {
    font-size: 3rem;
    color: var(--sc-gold);
    margin-bottom: 15px;
}

.sc-doc-card h4 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--sc-midnight);
    margin-bottom: 5px;
}

/* EMPTY STATE */
.empty-state {
    text-align: center;
    padding: 50px 20px;
    background: #fff;
    border-radius: 18px;
    border: 1px dashed var(--sc-gold);
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
}

.empty-state i {
    font-size: 3rem;
    color: var(--sc-gold-light);
    margin-bottom: 15px;
}

@keyframes fadeInScale {
    0% {
        opacity: 0;
        transform: scale(0.95);
    }

    100% {
        opacity: 1;
        transform: scale(1);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mediaBase = "<?= $media_base ?>";
    const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
    const apiBase = isLocal ? 'http://localhost:8001/api/v1/admission' : `${mediaBase}/api/v1/admission`;
    const category = '<?php echo esc_js($admission_category ?? "UG"); ?>';

    const tabs = document.querySelectorAll('.sc-pill');
    const contents = document.querySelectorAll('.admission-tab-content');
    const loader = document.getElementById('loader');

    function init() {
        // Initialize with notices tab
        switchTab('notices');
    }

    function switchTab(targetId) {
        tabs.forEach(t => t.classList.remove('active'));
        contents.forEach(c => c.classList.add('d-none'));

        const activeTab = document.querySelector(`.sc-pill[data-target="${targetId}"]`);
        if (activeTab) activeTab.classList.add('active');

        const activeContent = document.getElementById(`tab-${targetId}`);
        if (activeContent) activeContent.classList.remove('d-none');

        fetchTabData(targetId);
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            switchTab(tab.getAttribute('data-target'));
        });
    });

    async function fetchTabData(tab) {
        const containerId = tab === 'counselling' ? 'phase-tabs-content' : `${tab}-list`;
        const container = document.getElementById(containerId);
        
        loader.classList.remove('d-none');
        container.classList.add('d-none');

        try {
            let endpoint = '';
            const streamParam = `stream__category=${category}`;
            
            if (tab === 'notices') endpoint = `/notices/?category=${category}`;
            if (tab === 'prospectuses') endpoint = `/prospectuses/?category=${category}`;
            if (tab === 'registration') endpoint = `/registration-portals/?category=${category}`;
            if (tab === 'counselling') endpoint = `/counselling-phases/?${streamParam}`;

            const res = await fetch(`${apiBase}${endpoint}`);
            const data = await res.json();
            const items = Array.isArray(data) ? data : (data.results || []);

            renderTabData(tab, items);
        } catch (e) {
            console.error(e);
            container.innerHTML = `<div class="alert alert-danger">Failed to load data.</div>`;
        } finally {
            loader.classList.add('d-none');
            container.classList.remove('d-none');
        }
    }

    function renderTabData(tab, data) {
        const container = document.getElementById(`${tab}-list`);
        
        if (!data || data.length === 0) {
            const emptyHtml = `
                <div class="empty-state">
                    <i class="fa-solid fa-folder-open"></i>
                    <h4>No data available</h4>
                    <p class="text-muted mb-0">Check back later for updates.</p>
                </div>`;
            if (tab === 'counselling') {
                document.getElementById('phase-tabs').innerHTML = '';
                document.getElementById('phase-tabs-content').innerHTML = emptyHtml;
            } else {
                container.innerHTML = emptyHtml;
            }
            return;
        }

        let html = '';
        if (tab === 'notices') {
            html = data.map(item => `
                <div class="col-md-6 col-lg-4">
                    <a href="${item.file || '#'}" target="_blank" class="sc-notice-card">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="sc-notice-icon"><i class="fa-solid ${item.file ? 'fa-file-pdf' : 'fa-bullhorn'}"></i></div>
                            <div class="sc-notice-meta">
                                <div><i class="fa-regular fa-calendar me-1"></i> ${new Date(item.date_posted).toLocaleDateString('en-GB')}</div>
                            </div>
                        </div>
                        <div class="sc-notice-info flex-grow-1">
                            <h3>${item.title}</h3>
                            ${item.description ? `<p class="text-muted small mt-2 mb-0">${item.description}</p>` : ''}
                        </div>
                    </a>
                </div>
            `).join('');
            container.innerHTML = html;
        } else if (tab === 'prospectuses') {
            html = data.map(item => `
                <div class="col-md-4 col-lg-3">
                    <a href="${item.file}" target="_blank" class="sc-doc-card">
                        <i class="fa-solid fa-file-pdf sc-doc-icon"></i>
                        <h4>${item.title}</h4>
                        <span class="text-muted small mt-2 d-block"><i class="fa-regular fa-calendar me-1"></i> ${new Date(item.upload_date).toLocaleDateString('en-GB')}</span>
                    </a>
                </div>
            `).join('');
            container.innerHTML = html;
        } else if (tab === 'registration') {
            html = data.map(item => `
                <div class="col-md-4 col-lg-3">
                    <a href="${item.url}" target="_blank" class="sc-doc-card" style="border-color: #2563eb;">
                        <i class="fa-solid fa-arrow-up-right-from-square sc-doc-icon" style="color: #2563eb;"></i>
                        <h4>${item.portal_name}</h4>
                        ${item.registration_end ? `<span class="badge bg-danger mt-2">Deadline: ${new Date(item.registration_end).toLocaleDateString('en-GB')}</span>` : ''}
                    </a>
                </div>
            `).join('');
            container.innerHTML = html;
        } else if (tab === 'counselling') {
            renderCounsellingPhases(data);
        }
    }

    function renderCounsellingPhases(phases) {
        const tabsHtml = phases.map((phase, index) => `
            <li class="nav-item" role="presentation">
                <button class="nav-link sc-pill-sm phase-pill-btn ${index === 0 ? 'active' : ''}" data-target-phase="${phase.id}" type="button" role="tab">
                    ${phase.phase_name}
                </button>
            </li>
        `).join('');

        const contentHtml = phases.map((phase, index) => `
            <div class="tab-pane fade phase-content-pane ${index === 0 ? 'show active' : ''}" id="phase-content-${phase.id}" role="tabpanel">
                <div class="text-center py-4 d-none phase-loader" id="loader-phase-${phase.id}">
                    <div class="spinner-border text-gold" role="status"><span class="visually-hidden">Loading...</span></div>
                </div>
                <div class="row g-4 justify-content-center" id="results-phase-${phase.id}"></div>
            </div>
        `).join('');

        document.getElementById('phase-tabs').innerHTML = tabsHtml;
        document.getElementById('phase-tabs-content').innerHTML = contentHtml;

        document.querySelectorAll('.phase-pill-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all pills
                document.querySelectorAll('.phase-pill-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Hide all panes
                document.querySelectorAll('.phase-content-pane').forEach(pane => {
                    pane.classList.remove('show', 'active');
                });

                // Show target pane
                const targetId = this.getAttribute('data-target-phase');
                document.getElementById(`phase-content-${targetId}`).classList.add('show', 'active');

                // Load data
                loadPhaseResults(targetId);
            });
        });

        if (phases.length > 0) {
            loadPhaseResults(phases[0].id);
        }
    }

    window.loadPhaseResults = async function(phaseId) {
        const container = document.getElementById(`results-phase-${phaseId}`);
        const loader = document.getElementById(`loader-phase-${phaseId}`);
        
        if (container.innerHTML.trim() !== '') return;

        loader.classList.remove('d-none');
        try {
            const res = await fetch(`${apiBase}/merit-lists/?phase=${phaseId}`);
            const data = await res.json();
            const results = Array.isArray(data) ? data : (data.results || []);

            if (results.length === 0) {
                container.innerHTML = `<div class="empty-state"><i class="fa-solid fa-folder-open"></i><h4>No Merit Lists Yet</h4><p class="text-muted mb-0">Merit lists for this phase will be published soon.</p></div>`;
                return;
            }

            container.innerHTML = results.map(result => `
                <div class="col-md-6 col-lg-4">
                    <a href="${result.pdf_file}" target="_blank" class="sc-notice-card">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="sc-notice-icon"><i class="fa-solid fa-list-check"></i></div>
                            <div class="sc-notice-meta">
                                <div><i class="fa-regular fa-calendar me-1"></i> ${new Date(result.upload_date).toLocaleDateString('en-GB')}</div>
                            </div>
                        </div>
                        <div class="sc-notice-info">
                            <h3 class="mb-0 text-gold">${result.department_name}</h3>
                        </div>
                    </a>
                </div>
            `).join('');

        } catch (e) {
            container.innerHTML = `<div class="alert alert-danger">Failed to load merit lists.</div>`;
        } finally {
            loader.classList.add('d-none');
        }
    };

    init();
});
</script>

<?php get_footer(); ?>