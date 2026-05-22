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
        <!-- FILTER PILLS NAVIGATION -->
        <div class="sc-filter-nav mb-5 text-center">
            <button class="sc-pill active" data-target="updates">
                <i class="fa-solid fa-bullhorn me-2"></i> Updates & Notices
            </button>
            <button class="sc-pill" data-target="merit-lists">
                <i class="fa-solid fa-trophy me-2"></i> Merit Lists & Cutoffs
            </button>
            <button class="sc-pill" data-target="schedules">
                <i class="fa-solid fa-clock me-2"></i> Schedules
            </button>
            <button class="sc-pill" data-target="brochures">
                <i class="fa-solid fa-file-pdf me-2"></i> Brochures
            </button>
            <button class="sc-pill" data-target="links">
                <i class="fa-solid fa-link me-2"></i> Quick Links
            </button>
            <button class="sc-pill" data-target="helpdesk">
                <i class="fa-solid fa-headset me-2"></i> Helpdesk
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

            <!-- Updates Tab -->
            <div id="tab-updates" class="admission-tab-content d-none">
                <h2 class="sc-section-title mb-4 text-center d-block">Latest Updates & Notices</h2>
                <div id="updates-list" class="row g-4"></div>
            </div>

            <!-- Merit Lists Tab -->
            <div id="tab-merit-lists" class="admission-tab-content d-none">
                <h2 class="sc-section-title mb-4 text-center d-block">Merit Lists & Cutoffs</h2>
                <div id="merit-lists-list" class="row g-4"></div>
            </div>

            <!-- Schedules Tab -->
            <div id="tab-schedules" class="admission-tab-content d-none">
                <h2 class="sc-section-title mb-4 text-center d-block">Important Dates</h2>
                <div class="timeline mx-auto" id="schedules-list" style="max-width: 800px;"></div>
            </div>

            <!-- Brochures Tab -->
            <div id="tab-brochures" class="admission-tab-content d-none">
                <h2 class="sc-section-title mb-4 text-center d-block">Brochures & Prospectus</h2>
                <div class="row g-4 justify-content-center" id="brochures-list"></div>
            </div>

            <!-- Links Tab -->
            <div id="tab-links" class="admission-tab-content d-none">
                <h2 class="sc-section-title mb-4 text-center d-block">Quick Links</h2>
                <div class="row g-4 justify-content-center" id="links-list"></div>
            </div>

            <!-- Helpdesk Tab -->
            <div id="tab-helpdesk" class="admission-tab-content d-none">
                <h2 class="sc-section-title mb-4 text-center d-block">Contact & Helpdesk</h2>
                <div class="row g-4 justify-content-center" id="helpdesk-list"></div>
            </div>
        </section>
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
    height: 350px;
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

.sc-pill {
    background: transparent;
    border: none;
    padding: 10px 25px;
    border-radius: 50px;
    font-weight: 700;
    color: var(--sc-slate);
    transition: 0.3s;
    font-size: 0.95rem;
}

.sc-pill:hover {
    color: var(--sc-midnight);
    background: #f1f5f9;
}

.sc-pill.active {
    background: var(--sc-midnight);
    color: var(--sc-gold);
    box-shadow: 0 5px 15px rgba(15, 23, 42, 0.2);
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

/* TIMELINE */
.timeline {
    position: relative;
    padding-left: 30px;
    border-left: 2px solid var(--sc-gold-light);
    margin-top: 20px;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -40px;
    top: 0;
    width: 18px;
    height: 18px;
    background: var(--sc-gold);
    border: 4px solid var(--sc-bg);
    border-radius: 50%;
}

.timeline-date {
    font-weight: 700;
    color: var(--sc-gold);
    margin-bottom: 5px;
    display: block;
}

.timeline-content {
    background: #fff;
    border: 1px solid var(--sc-gold-light);
    padding: 20px;
    border-radius: 14px;
}

.timeline-content h4 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--sc-midnight);
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
    0% { opacity: 0; transform: scale(0.95); }
    100% { opacity: 1; transform: scale(1); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mediaBase = "<?= $media_base ?>";
    const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
    const apiBase = isLocal ? 'http://localhost:8001/api/v1/admission' :`${mediaBase}/api/v1/admission`;

    const category = '<?php echo esc_js($admission_category ?? "UG"); ?>';

    const tabs = document.querySelectorAll('.sc-pill');
    const contents = document.querySelectorAll('.admission-tab-content');
    const loader = document.getElementById('loader');

    const containers = {
        updates: document.getElementById('updates-list'),
        'merit-lists': document.getElementById('merit-lists-list'),
        schedules: document.getElementById('schedules-list'),
        brochures: document.getElementById('brochures-list'),
        links: document.getElementById('links-list'),
        helpdesk: document.getElementById('helpdesk-list')
    };

    const dataCache = {};

    function switchTab(targetId) {
        tabs.forEach(t => t.classList.remove('active'));
        contents.forEach(c => c.classList.add('d-none'));

        const activeTab = document.querySelector(`.sc-pill[data-target="${targetId}"]`);
        if (activeTab) activeTab.classList.add('active');

        const activeContent = document.getElementById(`tab-${targetId}`);
        if (activeContent) activeContent.classList.remove('d-none');

        loadDataForTab(targetId);
    }

    async function loadDataForTab(tab) {
        if (dataCache[tab]) {
            renderTab(tab, dataCache[tab]);
            return;
        }

        loader.classList.remove('d-none');
        try {
            let endpoint = `/${tab}/?category=${category}`;
            if (tab === 'helpdesk') endpoint = `/contacts/?category=${category}`;

            const res = await fetch(`${apiBase}${endpoint}`);
            const data = await res.json();

            const items = Array.isArray(data) ? data : (data.results || []);
            dataCache[tab] = items;

            renderTab(tab, items);
        } catch (e) {
            console.error(e);
            containers[tab].innerHTML =
                `<div class="alert alert-danger mt-3 w-100 text-center">Failed to load data. Please try again later.</div>`;
        } finally {
            loader.classList.add('d-none');
        }
    }

    function renderTab(tab, data) {
        if (!data || data.length === 0) {
            containers[tab].innerHTML = `
                <div class="empty-state">
                    <i class="fa-solid fa-folder-open"></i>
                    <h4>No data available</h4>
                    <p class="text-muted mb-0">Check back later for updates in this category.</p>
                </div>
            `;
            return;
        }

        const getTagsHTML = (item) => {
            let tags = '';
            if (item.departments_display && item.departments_display.length > 0) {
                tags += item.departments_display.map(d => `<span class="badge bg-secondary me-1 mb-1" style="font-size: 0.75rem;">${d}</span>`).join('');
            }
            if (item.programs_display && item.programs_display.length > 0) {
                tags += item.programs_display.map(p => `<span class="badge bg-primary me-1 mb-1" style="font-size: 0.75rem; background-color: var(--sc-gold) !important;">${p}</span>`).join('');
            }
            return tags ? `<div class="mt-3 d-flex flex-wrap">${tags}</div>` : '';
        };

        let html = '';
        if (tab === 'updates' || tab === 'merit-lists') {
            html = data.map(item => `
                <div class="col-md-6 col-lg-4">
                    <a href="${item.attachment || '#'}" target="_blank" class="sc-notice-card">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="sc-notice-icon"><i class="fa-solid ${item.attachment ? 'fa-file-pdf' : (tab === 'merit-lists' ? 'fa-trophy' : 'fa-bullhorn')}"></i></div>
                            <div class="sc-notice-meta">
                                <div><i class="fa-regular fa-calendar me-1"></i> ${new Date(item.date_posted).toLocaleDateString('en-GB')}</div>
                                <div><i class="fa-solid fa-layer-group me-1"></i> ${item.session_details?.session_name || 'Current Session'}</div>
                            </div>
                        </div>
                        <div class="sc-notice-info flex-grow-1">
                            <h3>${item.title}</h3>
                            ${item.session_details?.samarth_url ? `<a href="${item.session_details.samarth_url}" target="_blank" class="text-gold fw-bold mt-2 d-inline-block"><i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Apply via Samarth</a>` : ''}
                        </div>
                        ${getTagsHTML(item)}
                    </a>
                </div>
            `).join('');
        } else if (tab === 'schedules') {
            html = data.map(item => `
                <div class="timeline-item">
                    <span class="timeline-date"><i class="fa-solid fa-calendar-day me-2"></i>${new Date(item.event_date).toLocaleString('en-GB', { dateStyle: 'medium', timeStyle: 'short' })}</span>
                    <div class="timeline-content shadow-sm">
                        <h4>${item.event_name}</h4>
                        ${getTagsHTML(item)}
                    </div>
                </div>
            `).join('');
        } else if (tab === 'brochures') {
            html = data.map(item => `
                <div class="col-md-4 col-lg-3">
                    <a href="${item.file}" target="_blank" class="sc-doc-card">
                        <i class="fa-solid fa-file-pdf sc-doc-icon"></i>
                        <h4>${item.title}</h4>
                        <span class="text-muted small mt-2 d-block"><i class="fa-regular fa-calendar me-1"></i> ${new Date(item.upload_date).toLocaleDateString('en-GB')}</span>
                        ${getTagsHTML(item)}
                    </a>
                </div>
            `).join('');
        } else if (tab === 'links') {
            html = data.map(item => `
                <div class="col-md-4 col-lg-3">
                    <a href="${item.url}" target="_blank" class="sc-doc-card">
                        <i class="fa-solid fa-arrow-up-right-from-square sc-doc-icon"></i>
                        <h4>${item.title}</h4>
                    </a>
                </div>
            `).join('');
        } else if (tab === 'helpdesk') {
            html = data.map(item => `
                <div class="col-md-6 col-lg-4">
                    <div class="sc-contact-card shadow-sm h-100 d-flex flex-column justify-content-center">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="sc-notice-icon" style="width:45px; height:45px; font-size:1.1rem;"><i class="fa-solid fa-user"></i></div>
                            <div>
                                <h4 class="mb-1">${item.name}</h4>
                                <p class="text-gold mb-0 small fw-bold">${item.designation}</p>
                            </div>
                        </div>
                        ${item.email ? `<p class="mb-1"><i class="fa-solid fa-envelope me-2 text-gold"></i> ${item.email}</p>` : ''}
                        ${item.phone_number ? `<p class="mb-0"><i class="fa-solid fa-phone me-2 text-gold"></i> ${item.phone_number}</p>` : ''}
                    </div>
                </div>
            `).join('');
        }

        containers[tab].innerHTML = html;
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            switchTab(tab.getAttribute('data-target'));
        });
    });

    // Init
    switchTab('updates');
});
</script>

<?php get_footer(); ?>