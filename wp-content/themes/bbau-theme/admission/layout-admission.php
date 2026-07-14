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
                <a href="/virtual-helpdesk/" class="sc-pill text-decoration-none d-inline-block">
                    <i class="fa-solid fa-headset me-2"></i> Virtual Helpdesk
                </a>
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

.sc-pill,
.sc-pill-sm {
    background: transparent;
    border: none;
    padding: 10px 25px;
    border-radius: 50px;
    font-weight: 700;
    color: var(--sc-slate) !important;
    transition: 0.3s;
    font-size: 0.95rem;
}

.sc-pill-sm {
    padding: 8px 20px;
    font-size: 0.9rem;
    border: 1px solid var(--sc-gold-light);
    background: #fff;
}

.sc-pill:hover,
.sc-pill-sm:hover {
    color: var(--sc-midnight);
    background: #f1f5f9;
}

.sc-pill.active,
.sc-pill-sm.active {
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
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
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
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02) !important;
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
    padding: 20px 25px;
    margin-bottom: 12px;
    border: 1px solid var(--sc-light-border);
    border-radius: 16px;
    background-color: #ffffff;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    position: relative;
    overflow: hidden;
}

.sc-list-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background: var(--sc-gold);
    transform: scaleY(0);
    transition: transform 0.3s ease;
    transform-origin: bottom;
}

.sc-list-item:hover::before {
    transform: scaleY(1);
}

.sc-list-item:hover {
    border-color: var(--sc-gold);
    transform: translateX(5px);
    box-shadow: 0 10px 25px -5px rgba(201, 168, 76, 0.15);
}

.sc-list-meta {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-grow: 1;
}

.sc-list-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: rgba(201, 168, 76, 0.1);
    color: var(--sc-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.sc-list-item:hover .sc-list-icon {
    background: var(--sc-gold);
    color: #fff;
    transform: rotate(-10deg);
}

.sc-list-title {
    font-weight: 700;
    color: var(--sc-midnight);
    font-size: 1.15rem;
    margin: 0;
    transition: color 0.3s ease;
}

.sc-list-item:hover .sc-list-title {
    color: var(--sc-navy);
}

.sc-list-date {
    display: inline-flex;
    align-items: center;
    background: var(--sc-light-bg);
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 0.8rem;
    color: var(--sc-slate);
    font-weight: 700;
}

.sc-list-action {
    color: var(--sc-navy);
    font-size: 0.9rem;
    font-weight: 700;
    background: var(--sc-light-bg);
    padding: 8px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50px;
    transition: all 0.3s ease;
    gap: 8px;
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
    background: #ffffff;
    border: 1px solid var(--sc-light-border);
    padding: 20px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    gap: 20px;
    text-decoration: none !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    height: 100%;
}

.sc-notice-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px -5px rgba(15, 23, 42, 0.08);
    border-color: var(--sc-gold);
}

.sc-notice-date-box {
    background: var(--sc-light-bg);
    border: 1px solid var(--sc-light-border);
    min-width: 65px;
    height: 70px;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--sc-navy);
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.sc-notice-card:hover .sc-notice-date-box {
    background: var(--sc-navy);
    color: #ffffff;
    border-color: var(--sc-navy);
}

.sc-notice-date-box .day {
    font-size: 1.4rem;
    font-weight: 800;
    line-height: 1.1;
}

.sc-notice-date-box .month {
    font-size: 0.75rem;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 1px;
}

.sc-notice-content {
    flex-grow: 1;
}

.sc-notice-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--sc-midnight);
    margin: 0 0 8px 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    overflow: hidden;
    transition: color 0.3s ease;
}

.sc-notice-card:hover .sc-notice-title {
    color: var(--sc-navy);
}

.sc-notice-meta {
    font-size: 0.85rem;
    color: var(--sc-slate);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.sc-notice-action {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: var(--sc-light-bg);
    color: var(--sc-slate);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.3s ease;
    opacity: 0;
    transform: translateX(-10px);
}

.sc-notice-card:hover .sc-notice-action {
    opacity: 1;
    transform: translateX(0);
    background: var(--sc-gold);
    color: #ffffff;
}

/* DOC CARDS */
.sc-doc-card {
    background: #ffffff;
    border: 1px solid var(--sc-light-border);
    padding: 25px 20px;
    border-radius: 16px;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    text-decoration: none !important;
    box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    position: relative;
    overflow: hidden;
}

.sc-doc-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: var(--sc-navy);
    transform: scaleX(0);
    transition: transform 0.3s ease;
    transform-origin: left;
}

.sc-doc-card:hover::before {
    transform: scaleX(1);
}

.sc-doc-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px -5px rgba(30, 58, 95, 0.12);
    border-color: transparent;
}

.sc-doc-icon-wrapper {
    width: 65px;
    height: 65px;
    background: rgba(30, 58, 95, 0.05);
    color: var(--sc-navy);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.sc-doc-card:hover .sc-doc-icon-wrapper {
    background: var(--sc-navy);
    color: #ffffff;
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 10px 20px rgba(30, 58, 95, 0.2);
}

.sc-doc-title {
    font-weight: 700;
    font-size: 1.0rem;
    color: var(--sc-midnight);
    margin-bottom: 12px;
    line-height: 1.4;
    transition: color 0.3s ease;
}

.sc-doc-card:hover .sc-doc-title {
    color: var(--sc-navy);
}

.sc-doc-meta {
    font-size: 0.85rem;
    color: var(--sc-slate);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: auto;
}

.sc-doc-action-btn {
    display: inline-block;
    padding: 8px 18px;
    border-radius: 50px;
    background: var(--sc-light-bg);
    color: var(--sc-navy);
    font-size: 0.85rem;
    font-weight: 700;
    transition: all 0.3s ease;
}

.sc-doc-card:hover .sc-doc-action-btn {
    background: var(--sc-navy);
    color: #ffffff;
}

/* REGISTRATION CARDS */
.sc-reg-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border: 1px solid var(--sc-light-border);
    border-radius: 20px;
    padding: 24px;
    display: flex;
    text-decoration: none !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    position: relative;
    overflow: hidden;
}

.sc-reg-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 6px;
    height: 100%;
    background: #2563eb;
    transition: width 0.3s ease;
}

.sc-reg-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.15);
    border-color: #bfdbfe;
}

.reg-card-inner {
    display: flex;
    align-items: center;
    width: 100%;
    gap: 24px;
    z-index: 1;
}

.reg-icon-wrapper {
    width: 64px;
    height: 64px;
    background: #eff6ff;
    color: #2563eb;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.sc-reg-card:hover .reg-icon-wrapper {
    background: #2563eb;
    color: #ffffff;
    transform: scale(1.05) rotate(-5deg);
    box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
}

.reg-content {
    flex-grow: 1;
}

.reg-title {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--sc-midnight);
    margin-bottom: 8px;
    line-height: 1.3;
}

.sc-reg-card:hover .reg-title {
    color: #1d4ed8;
}

.reg-deadline {
    font-size: 0.85rem;
    font-weight: 700;
    color: #dc2626;
    background: #fef2f2;
    padding: 6px 12px;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    border: 1px solid #fecaca;
}

.reg-deadline.text-success {
    color: #059669;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
}

.reg-action {
    flex-shrink: 0;
}

.reg-btn {
    background: #2563eb;
    color: #ffffff;
    padding: 12px 24px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.95rem;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
}

.sc-reg-card:hover .reg-btn {
    background: #1d4ed8;
    transform: translateX(5px);
    box-shadow: 0 8px 15px rgba(37, 99, 235, 0.3);
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

/*   RESPONSIVE DESIGN */
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
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }

    .sc-filter-nav::-webkit-scrollbar {
        display: none;
    }

    .sc-pill {
        flex: 0 0 auto;
        /* Prevent shrinking */
        font-size: 0.9rem;
        padding: 10px 18px;
    }

    /* Section Titles */
    .sc-section-title {
        font-size: 1.3rem;
    }

    /* Notice Cards */
    .sc-notice-card {
        padding: 15px;
        gap: 15px;
    }

    .sc-notice-date-box {
        min-width: 55px;
        height: 60px;
    }

    .sc-notice-date-box .day {
        font-size: 1.2rem;
    }

    .sc-notice-date-box .month {
        font-size: 0.7rem;
    }

    .sc-notice-title {
        font-size: 1rem;
    }

    .sc-notice-action {
        display: none;
        /* Hide on mobile to save space */
    }

    .reg-card-inner {
        flex-direction: column;
        text-align: center;
        gap: 16px;
    }
    .sc-reg-card::before {
        width: 100%;
        height: 6px;
    }
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

    const tabs = document.querySelectorAll('.sc-pill[data-target]');
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
        const container = tab === 'counselling' ? document.getElementById('counsellingAccordion') : document
            .getElementById(`${tab}-list`);

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
                const hrefAttr = isClickable ? `href="${getFullMediaUrl(item.file)}" target="_blank"` :
                    '';

                return `
                <div class="col-md-6 col-lg-4 d-flex">
                    <${WrapperTag} ${hrefAttr} class="sc-notice-card w-100">
                        <div class="sc-notice-date-box">
                            <span class="day">${new Date(item.date_posted).getDate()}</span>
                            <span class="month">${new Date(item.date_posted).toLocaleString('en-US', {month: 'short'})}</span>
                        </div>
                        <div class="sc-notice-content">
                            <h3 class="sc-notice-title">${item.title}</h3>
                            <div class="sc-notice-meta">
                                ${item.file 
                                    ? '<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1" style="font-size:0.75rem;"><i class="fa-solid fa-file-pdf me-1"></i> View PDF</span>' 
                                    : '<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1" style="font-size:0.75rem;"><i class="fa-solid fa-bullhorn me-1"></i> Announcement</span>'}
                            </div>
                        </div>
                        <div class="sc-notice-action">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                    </${WrapperTag}>
                </div>
                `;
            }).join('');
            container.innerHTML = html;
        } else if (tab === 'prospectuses') {
            html = data.map(item => `
                <div class="col-md-6 col-lg-4 col-xl-3 d-flex">
                    <a href="${getFullMediaUrl(item.file)}" target="_blank" class="sc-doc-card w-100">
                        <div class="sc-doc-icon-wrapper">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <h4 class="sc-doc-title">${item.title}</h4>
                        <div class="sc-doc-meta mb-2">
                            <i class="fa-regular fa-calendar text-muted"></i> ${new Date(item.upload_date).toLocaleDateString('en-GB', {day: 'numeric', month: 'short', year: 'numeric'})}
                        </div>
                        <div class="mt-auto">
                            <span class="sc-doc-action-btn">Download <i class="fa-solid fa-download ms-1"></i></span>
                        </div>
                    </a>
                </div>
            `).join('');
            container.innerHTML = html;
        } else if (tab === 'registration') {
            html = data.map(item => `
                <div class="col-lg-6 mb-4 d-flex">
                    <a href="${item.url}" target="_blank" class="sc-reg-card w-100">
                        <div class="reg-card-inner">
                            <div class="reg-icon-wrapper">
                                <i class="fa-solid fa-laptop-file"></i>
                            </div>
                            <div class="reg-content">
                                <h4 class="reg-title">${item.portal_name}</h4>
                                ${item.registration_end ? `<span class="reg-deadline"><i class="fa-regular fa-clock me-1"></i> Deadline: ${new Date(item.registration_end).toLocaleDateString('en-GB', {day: 'numeric', month: 'short', year: 'numeric'})}</span>` : '<span class="reg-deadline text-success"><i class="fa-solid fa-circle-check me-1"></i> Open for Registration</span>'}
                            </div>
                            <div class="reg-action">
                                <span class="reg-btn">Apply Now <i class="fa-solid fa-arrow-right ms-1"></i></span>
                            </div>
                        </div>
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
            document.getElementById('counsellingAccordion').innerHTML =
                `<div class="empty-state"><i class="fa-solid fa-folder-open"></i><h4>No Phases Found</h4></div>`;
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
                container.innerHTML =
                    `<div class="empty-state py-4"><i class="fa-solid fa-folder-open mb-3" style="font-size: 2rem; color: var(--sc-gold);"></i><h4>No Merit Lists Yet</h4><p class="text-muted mb-0">Merit lists for this phase will be published soon.</p></div>`;
                return;
            }

            container.innerHTML = results.map(result => `
                <a href="${getFullMediaUrl(result.pdf_file)}" target="_blank" class="text-decoration-none d-block">
                    <div class="sc-list-item">
                        <div class="sc-list-meta">
                            <div class="sc-list-icon">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                            <div class="sc-list-meta-info d-flex flex-column" style="gap: 6px;">
                                <h3 class="sc-list-title mb-0">${result.department_name}</h3>
                                <div class="sc-list-date">
                                    <i class="fa-regular fa-calendar-alt me-2" style="color: var(--sc-gold);"></i>
                                    ${new Date(result.upload_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' })}
                                </div>
                            </div>
                        </div>
                        <div class="sc-list-action">
                            View PDF <i class="fa-solid fa-download"></i>
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