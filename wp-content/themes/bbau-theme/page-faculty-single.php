<?php
/*
Template Name: Faculty Profile
*/
defined('ABSPATH') || exit;
get_header();

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');

$faculty_slug = get_query_var('faculty_slug');
if (empty($faculty_slug)) {
    $faculty_slug = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
}

$api_url  = $api_base . '/api/v1/faculty/' . urlencode($faculty_slug) . '/';
$response = wp_remote_get($api_url, array('timeout' => 15));
$fac      = null;

if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
    $fac = json_decode(wp_remote_retrieve_body($response), true);
}
?>

<!-- PREMIUM PORTFOLIO HERO -->
<section class="premium-hero-fac">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="fac-content-glass animate-fac-up">
            <div class="d-flex align-items-center gap-4 flex-wrap">
                <div class="portfolio-avatar-wrap">
                    <?php if (!empty($fac['photo'])): ?>
                    <img src="<?php echo esc_url($media_base . $fac['photo']); ?>"
                        alt="<?php echo esc_attr($fac['name']); ?>">
                    <?php else: ?>
                    <div class="portfolio-no-photo"><i class="fas fa-user-graduate"></i></div>
                    <?php endif; ?>
                </div>
                <div class="portfolio-header-text">
                    <div class="badge-fac">Faculty Portfolio</div>
                    <h1 style="font-size: 2.1rem; margin: 0;"><?php echo esc_html($fac['name']); ?></h1>
                    <p style="font-size: 1.1rem; opacity: 0.9; margin: 5px 0 0;">
                        <?php echo esc_html($fac['designation']); ?></p>
                    <div class="d-flex gap-3 mt-3 flex-wrap">
                        <?php if (!empty($fac['school']['name'])): ?>
                        <span class="small fw-bold"><i
                                class="fas fa-school me-2"></i><?php echo esc_html($fac['school']['name']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($fac['department']['name'])): ?>
                        <span class="small fw-bold"><i
                                class="fas fa-building-columns me-2"></i><?php echo esc_html($fac['department']['name']); ?></span>
                        <?php endif; ?>
                        <span class="small fw-bold"><i
                                class="fas fa-map-marker-alt me-2"></i><?php echo (($fac['campus'] ?? '') === 'Satellite Campus Amethi') ? 'Amethi Campus' : 'Main Campus'; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<main id="primary" class="site-main faculty-profile-page" style="background:#fdfaf6; padding-bottom:60px;">
    <div class="container pt-4">

        <?php get_template_part('template-parts/breadcrumb'); ?>

        <?php if ($fac): ?>
        <div class="portfolio-layout mt-5">
            <!-- Sidebar: Quick Contact & Meta -->
            <aside class="portfolio-sidebar animate-fac-up" style="animation-delay: 0.1s;">
                <div class="fac-card-premium p-4 mb-4">
                    <h4 class="faculty-small-title">Contact Information</h4>
                    <div class="portfolio-contact-list mt-3">
                        <?php if (!empty($fac['insti_email'])): ?>
                        <a href="mailto:<?php echo esc_attr($fac['insti_email']); ?>" class="contact-item">
                            <i class="fas fa-envelope-open"></i>
                            <span><?php echo esc_html($fac['insti_email']); ?></span>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($fac['phone1'])): ?>
                        <div class="contact-item">
                            <i class="fas fa-phone-alt"></i>
                            <span>+91 <?php echo esc_html($fac['phone1']); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <?php if (!empty($fac['google_scholar_url'])): ?>
                        <a href="<?php echo esc_url($fac['google_scholar_url']); ?>" target="_blank"
                            class="social-icon-fac" title="Google Scholar"><i class="fab fa-google"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($fac['linkedin_url'])): ?>
                        <a href="<?php echo esc_url($fac['linkedin_url']); ?>" target="_blank" class="social-icon-fac"
                            title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($fac['website_url'])): ?>
                        <a href="<?php echo esc_url($fac['website_url']); ?>" target="_blank" class="social-icon-fac"
                            title="Website"><i class="fas fa-globe"></i></a>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($fac['cv_document'])): ?>
                    <a href="<?php echo esc_url($media_base . $fac['cv_document']); ?>" target="_blank"
                        class="btn-fac-profile w-100 mt-4 justify-content-center">
                        <i class="fas fa-file-pdf"></i> Download CV
                    </a>
                    <?php endif; ?>
                </div>

                <div class="fac-card-premium p-4">
                    <h4 class="faculty-small-title">Academic Experience</h4>
                    <div class="mt-3">
                        <?php if (!empty($fac['teaching_exp'])): ?>
                        <div class="exp-item mb-3">
                            <label>Teaching</label>
                            <div class="fw-bold text-dark"><?php echo esc_html($fac['teaching_exp']); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($fac['research_exp'])): ?>
                        <div class="exp-item">
                            <label>Research</label>
                            <div class="fw-bold text-dark"><?php echo esc_html($fac['research_exp']); ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </aside>

            <!-- Main Content: Tabs & Data -->
            <div class="portfolio-main animate-fac-up" style="animation-delay: 0.2s;">
                <!-- Tab Navigation -->
                <div class="portfolio-tabs">
                    <button class="portfolio-tab-btn active" data-tab="overview">Overview</button>
                    <button class="portfolio-tab-btn" data-tab="publications" data-load="true">Publications</button>
                    <button class="portfolio-tab-btn" data-tab="patents" data-load="true">Patents</button>
                    <button class="portfolio-tab-btn" data-tab="projects" data-load="true">Projects</button>
                    <button class="portfolio-tab-btn" data-tab="scholars" data-load="true">Scholars</button>
                </div>

                <!-- Tab Panes -->
                <div class="portfolio-tab-content">
                    <!-- Overview Pane -->
                    <div class="portfolio-pane active" id="overview">
                        <?php if (!empty($fac['bio'])): ?>
                        <div class="fac-card-premium mb-4">
                            <h3 class="rd-section-title">Biography</h3>
                            <div class="premium-rich-text"><?php echo wp_kses_post($fac['bio']); ?></div>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($fac['qualification'])): ?>
                        <div class="fac-card-premium mb-4">
                            <h3 class="rd-section-title">Academic Qualifications</h3>
                            <div class="premium-rich-text"><?php echo wp_kses_post($fac['qualification']); ?></div>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($fac['research_int'])): ?>
                        <div class="fac-card-premium">
                            <h3 class="rd-section-title">Research Focus</h3>
                            <div class="premium-rich-text"><?php echo wp_kses_post($fac['research_int']); ?></div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Dynamic Panes (Populated by JS) -->
                    <div class="portfolio-pane" id="publications">
                        <div class="fac-card-premium">
                            <h3 class="rd-section-title"> Publications</h3>
                            <div class="dynamic-feed-container" data-api="publications">
                                <div class="rd-loader-wrap text-center py-5">
                                    <div class="fac-loader"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="portfolio-pane" id="patents">
                        <div class="fac-card-premium">
                            <h3 class="rd-section-title">Innovations & Patents</h3>
                            <div class="dynamic-feed-container" data-api="patents">
                                <div class="rd-loader-wrap text-center py-5">
                                    <div class="fac-loader"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="portfolio-pane" id="projects">
                        <div class="fac-card-premium">
                            <h3 class="rd-section-title">Research Projects</h3>
                            <div class="dynamic-feed-container" data-api="projects">
                                <div class="rd-loader-wrap text-center py-5">
                                    <div class="fac-loader"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="portfolio-pane" id="scholars">
                        <div class="fac-card-premium">
                            <h3 class="rd-section-title">Ph.D. Scholars Supervised</h3>
                            <div class="dynamic-feed-container" data-api="scholars">
                                <div class="rd-loader-wrap text-center py-5">
                                    <div class="fac-loader"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php else: ?>
        <div class="text-center py-5" style="margin-top:40px;">
            <i class="fa-solid fa-user-slash" style="font-size:4rem; color:#cbd5e1;"></i>
            <h2 style="margin-top:20px; color:#5c1010;">Faculty Profile Not Found</h2>
            <p style="color:#64748b;">The faculty member you're looking for does not exist or has been removed.</p>
            <a href="<?php echo esc_url(home_url('/faculty')); ?>" class="btn-profile"
                style="display:inline-block; margin-top:15px; padding:12px 30px;">
                &larr; Back to Faculty Directory
            </a>
        </div>
        <?php endif; ?>

    </div>
</main>

<?php include_once(get_template_directory() . '/styles-faculty.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.portfolio-tab-btn');
    const panes = document.querySelectorAll('.portfolio-pane');
    const facultyName = "<?php echo esc_js($fac['name']); ?>";
    const apiBase = "<?php echo esc_js($api_base); ?>";

    // TAB SWITCHING
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.tab;

            tabs.forEach(t => t.classList.remove('active'));
            panes.forEach(p => p.classList.remove('active'));

            tab.classList.add('active');
            document.getElementById(target).classList.add('active');

            if (tab.dataset.load === 'true') {
                loadTabData(target);
                tab.dataset.load = 'false'; // Load only once
            }
        });
    });

    // DYNAMIC DATA LOADER
    async function loadTabData(type) {
        const container = document.querySelector(`#${type} .dynamic-feed-container`);
        let endpoint = '';

        switch (type) {
            case 'publications':
                endpoint = '/api/v1/publications/';
                break;
            case 'patents':
                endpoint = '/api/v1/patents/';
                break;
            case 'projects':
                endpoint = '/api/v1/research-projects/';
                break;
            case 'scholars':
                endpoint = '/api/v1/research-scholars/';
                break;
        }

        try {
            const response = await fetch(
                `${apiBase}${endpoint}?faculty_name=${encodeURIComponent(facultyName)}&page_size=100`);
            const data = await response.json();
            const records = data.results || data;

            if (!records || records.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-folder-open mb-3" style="font-size: 3rem; opacity: 0.1;"></i>
                        <p class="text-muted">No records found for this faculty member.</p>
                    </div>`;
                return;
            }

            renderData(type, records, container);
        } catch (error) {
            container.innerHTML = `<div class="alert alert-danger">Failed to load academic records.</div>`;
        }
    }

    function renderData(type, records, container) {
        let html = '<div class="table-responsive"><table class="fac-table"><thead><tr>';

        // Dynamic Headers
        if (type === 'publications') {
            html += '<th>Title</th><th>Journal</th><th>Year</th>';
        } else if (type === 'patents') {
            html += '<th>Innovation</th><th>Patent ID</th><th>Status</th>';
        } else if (type === 'projects') {
            html += '<th>Project Title</th><th>Agency</th><th>Status</th>';
        } else if (type === 'scholars') {
            html += '<th>Scholar Name</th><th>Topic</th><th>Status</th>';
        }

        html += '</tr></thead><tbody>';

        // Rows
        records.forEach(r => {
            html += '<tr>';
            if (type === 'publications') {
                html +=
                    `<td class="fw-bold" data-label="Title">${r.title}</td><td data-label="Journal">${r.name_of_journal_or_conference_or_publisher || '-'}</td><td data-label="Year">${r.publication_date ? new Date(r.publication_date).getFullYear() : '-'}</td>`;
            } else if (type === 'patents') {
                html +=
                    `<td class="fw-bold" data-label="Innovation">${r.title}</td><td data-label="Patent ID">${r.patent_number || '-'}</td><td data-label="Status"><span class="fac-status-badge ${(r.status||'').toLowerCase()}">${r.status}</span></td>`;
            } else if (type === 'projects') {
                html +=
                    `<td class="fw-bold" data-label="Project Title">${r.title}</td><td data-label="Agency">${r.funding_agency || '-'}</td><td data-label="Status"><span class="fac-status-badge ${(r.status||'').toLowerCase()}">${r.status}</span></td>`;
            } else if (type === 'scholars') {
                html +=
                    `<td class="fw-bold" data-label="Scholar Name">${r.scholar_name}</td><td data-label="Topic">${r.research_topic || '-'}</td><td data-label="Status"><span class="fac-status-badge ${(r.status||'').toLowerCase()}">${r.status}</span></td>`;
            }
            html += '</tr>';
        });

        html += '</tbody></table></div>';
        container.innerHTML = html;
    }
});
</script>

<?php get_footer(); ?>