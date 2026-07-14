<?php
/*
Template Name: Virtual Helpdesk Template
*/
defined('ABSPATH') || exit;
get_header();

$media_base = getenv('DJANGO_MEDIA_URL');
$banner_url = "/wp-content/uploads/2026/04/language.png";

?>
<div class="sc-hero" style="background-image: url('<?php echo esc_url($banner_url); ?>');">
    <div class="sc-hero-overlay">
        <div class="sc-hero-card">
            <span class="sc-badge">Virtual Helpdesk</span>
            <h1><?php echo esc_html($admission_title ?? 'Admissions'); ?></h1>
            <div class="sc-hero-line"></div>
        </div>
    </div>
</div>

<div class="admission-portal-brand helpdesk-portal py-5">

    <div class="container">
        <?php get_template_part('template-parts/breadcrumb'); ?>

        <div class="helpdesk-header mb-4 mt-3">
            <h2 class="helpdesk-title">Virtual Helpdesk (Admissions 2026-2027)</h2>
        </div>

        <div class="helpdesk-banner welcome-banner mb-4">
            <div class="banner-icon">
                <i class="fa-solid fa-circle-info"></i>
            </div>
            <div class="banner-text">
                <span class="fw-bold">Welcome!</span> Applicants seeking admission to Babasaheb Bhimrao Ambedkar
                University for the Academic Session 2026-2027 may contact the Helpdesk through the details provided
                below.
            </div>
        </div>

        <div class="helpdesk-card mb-5">
            <div class="helpdesk-table-wrapper">
                <table class="helpdesk-table">
                    <tbody>
                        <tr>
                            <th>Helpdesk Helpline Number</th>
                            <td><a href="tel:1800-180-5789" class="helpdesk-link"><i
                                        class="fa-solid fa-phone me-2"></i>1800-180-5789</a></td>
                        </tr>
                        <tr>
                            <th>Physical Helpdesk</th>
                            <td><i class="fa-solid fa-location-dot me-2 text-muted"></i>Birsa Munda Student Activity
                                Centre, Babasaheb Bhimrao Ambedkar University, Lucknow - 226025</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><a href="mailto:admission@bbau.ac.in" class="helpdesk-link"><i
                                        class="fa-solid fa-envelope me-2"></i>admission@bbau.ac.in</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="instructions-section mb-4">
            <h4 class="instructions-title"><i class="fa-solid fa-clipboard-list me-2"></i>Instructions for Applicants
            </h4>
            <ul class="instructions-list">
                <li>Please keep your <strong>Application Number</strong> ready while contacting the Helpdesk.</li>
                <li>Applicants are advised to check the University Website regularly for updates.</li>
            </ul>
        </div>

        <div class="helpdesk-banner note-banner">
            <div class="banner-icon">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div class="banner-text">
                <span class="fw-bold">Note:</span> The Helpdesk is intended solely for admission-related queries for the
                Academic Session 2026-2027.
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --hd-blue-bg: #e0f2fe;
    --hd-blue-text: #0369a1;
    --hd-blue-border: #bae6fd;
    --hd-yellow-bg: #fef3c7;
    --hd-yellow-text: #b45309;
    --hd-yellow-border: #fde68a;
    --hd-border: #e2e8f0;
    --hd-red: #dc2626;
    --hd-maroon: #8B1A1A;
    --hd-bg: #fdfaf6;
}

.admission-portal-brand {
    background-color: var(--sc-bg, #fdfaf6);
    min-height: 100vh;
}

.helpdesk-portal {
    font-family: 'Nunito', sans-serif;
    color: #1e293b;
}

.helpdesk-title {
    font-family: 'Merriweather', serif;
    color: var(--hd-maroon);
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.helpdesk-banner {
    padding: 1.25rem 1.5rem;
    border-radius: 12px;
    font-size: 1.05rem;
    line-height: 1.6;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
}

.banner-icon {
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.welcome-banner {
    background-color: var(--hd-blue-bg);
    color: var(--hd-blue-text);
    border: 1px solid var(--hd-blue-border);
}

.welcome-banner .banner-icon {
    color: #0284c7;
}

.note-banner {
    background-color: var(--hd-yellow-bg);
    color: var(--hd-yellow-text);
    border: 1px solid var(--hd-yellow-border);
}

.note-banner .banner-icon {
    color: #d97706;
}

.helpdesk-card {
    background: #ffffff;
    border: 1px solid var(--hd-border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.helpdesk-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
}

.helpdesk-table {
    width: 100%;
    margin: 0;
    border-collapse: collapse;
}

.helpdesk-table th {
    background-color: #f8fafc;
    width: 35%;
    padding: 22px 28px;
    font-weight: 700;
    color: #475569;
    border-bottom: 1px solid var(--hd-border);
    border-right: 1px solid var(--hd-border);
    text-align: left;
}

.helpdesk-table td {
    padding: 22px 28px;
    color: #334155;
    border-bottom: 1px solid var(--hd-border);
    font-weight: 500;
}

.helpdesk-table tr:last-child th,
.helpdesk-table tr:last-child td {
    border-bottom: none;
}


.helpdesk-link {
    color: var(--hd-maroon);
    text-decoration: none;
    font-weight: 700;
    font-size: 1.1rem;
    position: relative;
    transition: color 0.3s ease;
}

.helpdesk-link:hover {
    color: #6a1414;
}

.helpdesk-link::after {
    content: '';
    position: absolute;
    width: 100%;
    transform: scaleX(0);
    height: 2px;
    bottom: -2px;
    left: 0;
    background-color: var(--hd-maroon);
    transform-origin: bottom right;
    transition: transform 0.25s ease-out;
}

.helpdesk-link:hover::after {
    transform: scaleX(1);
    transform-origin: bottom left;
}

.instructions-section {
    background: transparent;
}

.instructions-title {
    color: #334155;
    font-weight: 700;
    margin-bottom: 20px;
    font-size: 1.4rem;
    display: flex;
    align-items: center;
}

.instructions-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.instructions-list li {
    position: relative;
    padding-left: 35px;
    margin-bottom: 16px;
    color: #475569;
    line-height: 1.6;
}

.instructions-list li::before {
    content: '\f058';
    /* FontAwesome circle-check */
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    left: 0;
    top: 2px;
    color: var(--hd-maroon);
}

@media (max-width: 768px) {

    .helpdesk-table th,
    .helpdesk-table td {
        display: block;
        width: 100%;
        border-right: none;
    }

    .helpdesk-table th {
        border-bottom: none;
        padding-bottom: 8px;
        background-color: #f1f5f9;
    }

    .helpdesk-table td {
        padding-top: 8px;
        border-bottom: 1px solid var(--hd-border);
    }

    .helpdesk-table tr:last-child td {
        border-bottom: none;
    }

    .helpdesk-banner {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
        gap: 10px;
    }
}
</style>

<?php get_footer(); ?>