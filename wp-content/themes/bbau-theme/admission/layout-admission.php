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
                    
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-xl-9">
                            <div class="accordion sc-accordion" id="counsellingAccordion">
                                <!-- Accordion items injected via JS -->
                            </div>
                        </div>
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
    
    /* University Inspired Colors */
    --sc-navy: #1e3a5f;
    --sc-saffron: #a23c1e;
    --sc-light-bg: #f8fafc;
    --sc-light-border: #e2e8f0;
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
    background-size: contain;
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

/* Modern Accordion Styles */
#counsellingAccordion .accordion-item {
    border: none !important;
    border-radius: 12px !important;
    margin-bottom: 1.25rem !important;
    overflow: hidden !important;
    background-color: transparent !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03) !important;
    display: block !important;
    width: 100% !important;
}

#counsellingAccordion .accordion-header {
    margin: 0 !important;
    padding: 0 !important;
    display: block !important;
    width: 100% !important;
    border: none !important;
    background: none !important;
    box-shadow: none !important;
}
#counsellingAccordion .accordion-header::before,
#counsellingAccordion .accordion-header::after {
    display: none !important;
}

#counsellingAccordion .sc-accordion-header-btn {
    background-color: #fff !important;
    color: var(--sc-navy) !important;
    font-weight: 700 !important;
    font-size: 1.1rem !important;
    padding: 1.25rem 1.75rem !important;
    border: 1px solid var(--sc-light-border) !important;
    border-radius: 12px !important;
    box-shadow: 0 2px 5px rgba(0,0,0,0.02) !important;
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    width: 100% !important;
    text-align: left !important;
    text-decoration: none !important;
    margin: 0 !important;
    transition: all 0.3s ease !important;
}

#counsellingAccordion .sc-accordion-header-btn:not(.collapsed) {
    background: linear-gradient(135deg, var(--sc-midnight), var(--sc-navy)) !important;
    color: #fff !important;
    border: 1px solid transparent !important;
    border-bottom-left-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.15) !important;
}

#counsellingAccordion .sc-accordion-header-btn::after {
    content: "";
    width: 1.25rem;
    height: 1.25rem;
    margin-left: auto;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%231e3a5f'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat;
    background-size: 1.25rem;
    transition: transform .3s ease-in-out;
}
#counsellingAccordion .sc-accordion-header-btn:not(.collapsed):after {
    transform: rotate(-180deg);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
}

#counsellingAccordion .accordion-body {
    padding: 1.5rem !important;
    background-color: var(--sc-light-bg) !important;
    border: 1px solid var(--sc-light-border) !important;
    border-top: none !important;
    border-bottom-left-radius: 12px !important;
    border-bottom-right-radius: 12px !important;
}



/* Removed to use ID styling instead */

/* Modern List Style */
.sc-list-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    margin-bottom: 0.75rem;
    border: 1px solid rgba(0,0,0,0.04);
    border-radius: 10px;
    background-color: #fff;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.01);
}

.sc-list-item:hover {
    border-color: var(--sc-gold-light);
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.04);
}

.sc-list-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-grow: 1;
}

.sc-list-date {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: var(--sc-light-bg);
    border-radius: 6px;
    padding: 0.35rem 0.6rem;
    min-width: 50px;
}

.sc-list-date span:first-child {
    font-size: 0.65rem;
    color: var(--sc-slate);
    text-transform: uppercase;
    font-weight: 700;
}

.sc-list-date span:last-child {
    font-size: 1.1rem;
    color: var(--sc-saffron);
    font-weight: 800;
    line-height: 1;
}

.sc-list-title {
    font-weight: 600;
    color: var(--sc-slate);
    font-size: 1rem;
    margin: 0;
}

.sc-list-action {
    color: var(--sc-navy);
    font-size: 1rem;
    background: var(--sc-light-bg);
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.sc-list-item:hover .sc-list-action {
    background: var(--sc-navy);
    color: #fff;
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
    border: none;
    gap: 0px;
    border-left: 4px solid var(--sc-saffron);
    padding: 20px 25px;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    text-decoration: none !important;
    transition: all 0.3s ease;
    color: var(--sc-slate);
    height: 100%;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    text-align: left;
}

.sc-notice-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    border-left-color: var(--sc-navy);
}

.sc-notice-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
}

.sc-notice-icon {
    width: 40px;
    height: 40px;
    background: var(--sc-light-bg);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: var(--sc-navy);
    transition: all 0.3s ease;
}

.sc-notice-card:hover .sc-notice-icon {
    background: var(--sc-navy);
    color: #fff;
}

.sc-notice-date {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--sc-slate);
    background: var(--sc-light-bg);
    padding: 4px 10px;
    border-radius: 50px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.sc-notice-title {
    font-family: 'Merriweather', serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--sc-midnight);
    line-height: 1.5;
    margin: 0;
}

/* DOC CARDS */
.sc-doc-card {
    background: #fff;
    border: none;
    padding: 30px 20px;
    border-radius: 16px;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-decoration: none !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
}

.sc-doc-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.08);
}

.sc-doc-icon-wrapper {
    width: 60px;
    height: 60px;
    background: rgba(30, 58, 95, 0.05);
    color: var(--sc-navy);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.sc-doc-card:hover .sc-doc-icon-wrapper {
    background: var(--sc-navy);
    color: #fff;
    transform: scale(1.1);
}

.sc-doc-title {
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--sc-midnight);
    margin-bottom: 10px;
    line-height: 1.4;
}

.sc-doc-meta {
    font-size: 0.8rem;
    color: var(--sc-slate);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
}
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

/* =========================================
   RESPONSIVE DESIGN 
   ========================================= */
@media (max-width: 768px) {
    /* Hero Section */
    .sc-hero {
        height: auto;
        min-height: 220px;
        padding: 40px 0;
    }
    .sc-hero-card {
        padding: 20px 15px;
        border-radius: 20px;
    }
    .sc-hero-card h1 {
        font-size: 1.5rem;
    }
    .sc-hero-card p {
        font-size: 0.9rem;
        letter-spacing: 1px;
    }

    /* Filter Nav (Scrollable row) */
    .sc-filter-nav {
        flex-wrap: nowrap;
        justify-content: flex-start;
        overflow-x: auto;
        border-radius: 16px;
        padding: 10px;
        /* Hide scrollbar */
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    .sc-filter-nav::-webkit-scrollbar {
        display: none;
    }
    .sc-pill {
        flex: 0 0 auto; /* Prevent shrinking */
        font-size: 0.9rem;
        padding: 10px 18px;
    }

    /* Section Titles */
    .sc-section-title {
        font-size: 1.3rem;
    }

    /* Notice Cards */
    .sc-notice-card {
        padding: 15px 20px;
    }
    .sc-notice-header {
        margin-bottom: 12px;
    }
    .sc-notice-icon {
        width: 35px;
        height: 35px;
        font-size: 0.95rem;
    }
    .sc-notice-title {
        font-size: 1rem;
    }

    /* Doc Cards */
    .sc-doc-card {
        padding: 20px 15px;
    }
    .sc-doc-icon-wrapper {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
        margin-bottom: 15px;
    }
    .sc-doc-title {
        font-size: 1rem;
    }

    /* Accordions */
    #counsellingAccordion .sc-accordion-header-btn {
        padding: 1rem 1.25rem !important;
        font-size: 1rem !important;
    }
    #counsellingAccordion .accordion-body {
        padding: 1.25rem 1rem !important;
    }

    /* Merit List Items */
    .sc-list-item {
        padding: 0.85rem 1rem;
    }
    .sc-list-title {
        font-size: 0.95rem;
    }
}

@media (max-width: 480px) {
    /* Stack Merit List Items */
    .sc-list-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    .sc-list-meta {
        width: 100%;
    }
    .sc-list-action {
        align-self: flex-end;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mediaBase = "<?= $media_base ?>";
    const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
    const apiBase = isLocal ? 'http://localhost:8001/api/v1/admission' : `${mediaBase}/api/v1/admission`;
    const category = '<?php echo esc_js($admission_category ?? "UG"); ?>';

    function getFullMediaUrl(url) {
        if (!url) return '#';
        if (url.startsWith('http://') || url.startsWith('https://')) return url;
        // Ensure single slash between mediaBase and url
        const base = mediaBase.endsWith('/') ? mediaBase.slice(0, -1) : mediaBase;
        const path = url.startsWith('/') ? url : '/' + url;
        return base + path;
    }

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
        const containerId = tab === 'counselling' ? 'counsellingAccordion' : `${tab}-list`;
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
        const container = tab === 'counselling' ? document.getElementById('counsellingAccordion') : document.getElementById(`${tab}-list`);
        
        if (!data || data.length === 0) {
            const emptyHtml = `
                <div class="empty-state">
                    <i class="fa-solid fa-folder-open"></i>
                    <h4>No data available</h4>
                    <p class="text-muted mb-0">Check back later for updates.</p>
                </div>`;
            container.innerHTML = emptyHtml;
            return;
        }

        let html = '';
        if (tab === 'notices') {
            html = data.map(item => {
                const isClickable = !!item.file;
                const WrapperTag = isClickable ? 'a' : 'div';
                const hrefAttr = isClickable ? `href="${getFullMediaUrl(item.file)}" target="_blank"` : '';
                
                return `
                <div class="col-md-6 col-lg-4">
                    <${WrapperTag} ${hrefAttr} class="sc-notice-card">
                        <div class="sc-notice-header">
                            <div class="sc-notice-icon">
                                <i class="fa-solid ${item.file ? 'fa-file-pdf' : 'fa-bullhorn'}"></i>
                            </div>
                            <div class="sc-notice-date">
                                <i class="fa-regular fa-calendar"></i>
                                ${new Date(item.date_posted).toLocaleDateString('en-GB', {day: 'numeric', month: 'short', year: 'numeric'})}
                            </div>
                        </div>
                        <h3 class="sc-notice-title">${item.title}</h3>
                    </${WrapperTag}>
                </div>
                `;
            }).join('');
            container.innerHTML = html;
        } else if (tab === 'prospectuses') {
            html = data.map(item => `
                <div class="col-md-4 col-lg-3">
                    <a href="${getFullMediaUrl(item.file)}" target="_blank" class="sc-doc-card">
                        <div class="sc-doc-icon-wrapper">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <h4 class="sc-doc-title">${item.title}</h4>
                        <div class="sc-doc-meta">
                            <i class="fa-regular fa-calendar"></i> ${new Date(item.upload_date).toLocaleDateString('en-GB', {day: 'numeric', month: 'short', year: 'numeric'})}
                        </div>
                    </a>
                </div>
            `).join('');
            container.innerHTML = html;
        } else if (tab === 'registration') {
            html = data.map(item => `
                <div class="col-md-4 col-lg-3">
                    <a href="${item.url}" target="_blank" class="sc-doc-card">
                        <div class="sc-doc-icon-wrapper" style="color: #2563eb; background: rgba(37, 99, 235, 0.05);">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </div>
                        <h4 class="sc-doc-title">${item.portal_name}</h4>
                        ${item.registration_end ? `<span class="badge bg-danger mt-2">Deadline: ${new Date(item.registration_end).toLocaleDateString('en-GB', {day: 'numeric', month: 'short', year: 'numeric'})}</span>` : ''}
                    </a>
                </div>
            `).join('');
            container.innerHTML = html;
        } else if (tab === 'counselling') {
            renderCounsellingPhases(data);
        }
    }

    function renderCounsellingPhases(phases) {
        if (!phases || phases.length === 0) {
            document.getElementById('counsellingAccordion').innerHTML = `<div class="empty-state"><i class="fa-solid fa-folder-open"></i><h4>No Phases Found</h4></div>`;
            return;
        }

        const accordionHtml = phases.map((phase, index) => {
            const isExpanded = index === 0 ? 'true' : 'false';
            const collapseClass = index === 0 ? 'show' : '';
            const buttonClass = index === 0 ? '' : 'collapsed';

            return `
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading-${phase.id}">
                    <div class="sc-accordion-header-btn sc-accordion-button ${buttonClass}" role="button" data-target-collapse="collapse-${phase.id}" aria-expanded="${isExpanded}" aria-controls="collapse-${phase.id}">
                        ${phase.phase_name}
                    </div>
                </h2>
                <div id="collapse-${phase.id}" class="accordion-collapse collapse ${collapseClass}" aria-labelledby="heading-${phase.id}" data-bs-parent="#counsellingAccordion">
                    <div class="accordion-body">
                        <div class="text-center py-4 d-none phase-loader" id="loader-phase-${phase.id}">
                            <div class="spinner-border text-gold" role="status"><span class="visually-hidden">Loading...</span></div>
                        </div>
                        <div class="phase-results-container" id="results-phase-${phase.id}"></div>
                    </div>
                </div>
            </div>
            `;
        }).join('');

        document.getElementById('counsellingAccordion').innerHTML = accordionHtml;

        // Use vanilla JS to handle toggling to avoid Bootstrap dynamic DOM issues
        document.querySelectorAll('.sc-accordion-button').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target-collapse');
                const targetPane = document.getElementById(targetId);
                const isCurrentlyOpen = targetPane.classList.contains('show');

                // Close all
                document.querySelectorAll('.accordion-collapse').forEach(pane => {
                    pane.classList.remove('show');
                });
                document.querySelectorAll('.sc-accordion-button').forEach(b => {
                    b.classList.add('collapsed');
                    b.setAttribute('aria-expanded', 'false');
                });

                // Toggle clicked
                if (!isCurrentlyOpen) {
                    targetPane.classList.add('show');
                    this.classList.remove('collapsed');
                    this.setAttribute('aria-expanded', 'true');

                    const phaseId = targetId.replace('collapse-', '');
                    loadPhaseResults(phaseId);
                }
            });
        });

        // Load the first phase by default
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
                container.innerHTML = `<div class="empty-state py-4"><i class="fa-solid fa-folder-open mb-3" style="font-size: 2rem; color: var(--sc-gold);"></i><h4>No Merit Lists Yet</h4><p class="text-muted mb-0">Merit lists for this phase will be published soon.</p></div>`;
                return;
            }

            container.innerHTML = results.map(result => `
                <a href="${getFullMediaUrl(result.pdf_file)}" target="_blank" class="text-decoration-none d-block">
                    <div class="sc-list-item">
                        <div class="sc-list-meta">
                            <div class="sc-list-meta-info d-flex flex-column" style="gap: 6px;">
                                <h3 class="sc-list-title mb-0">${result.department_name}</h3>
                                <div class="text-muted fw-medium" style="font-size: 0.85rem;">
                                    <i class="fa-regular fa-calendar-alt me-2" style="color: var(--sc-saffron);"></i>
                                    ${new Date(result.upload_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' })}
                                </div>
                            </div>
                        </div>
                        <div class="sc-list-action">
                            <i class="fa-solid fa-download"></i>
                        </div>
                    </div>
                </a>
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