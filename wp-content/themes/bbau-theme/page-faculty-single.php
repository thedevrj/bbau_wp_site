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
                    <h1 class="fac-name-main"><?php echo esc_html($fac['name']); ?></h1>
                    <p class="fac-designation-main">
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
                            <i class="fas fa-envelope"></i>
                            <span><?php echo esc_html($fac['insti_email']); ?></span>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($fac['other_email'])): ?>
                        <a href="mailto:<?php echo esc_attr($fac['other_email']); ?>" class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span><?php echo esc_html($fac['other_email']); ?></span>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($fac['phone1'])): ?>

                        <a class="contact-item" href="tel:+91<?php echo preg_replace('/\D+/', '', $fac['phone1']); ?>">
                            <i class="fas fa-phone-alt"></i>+91 <?php echo esc_html($fac['phone1']); ?></a>

                        <?php endif; ?>
                        <?php if (!empty($fac['phone2'])): ?>

                        <a class="contact-item" href="tel:+91<?php echo preg_replace('/\D+/', '', $fac['phone2']); ?>">
                            <i class="fas fa-phone-alt"></i>+91 <?php echo esc_html($fac['phone2']); ?></a>

                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <?php if (!empty($fac['google_scholar_url'])): ?>
                        <a href="<?php echo esc_url($fac['google_scholar_url']); ?>" target="_blank"
                            class="social-icon-fac" title="Google Scholar"><i class="fab fa-google"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($fac['research_gate_url'])): ?>
                        <a href="<?php echo esc_url($fac['research_gate_url']); ?>" target="_blank"
                            class="social-icon-fac" title="Research Gate"><i class="fa-brands fa-researchgate"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($fac['linkedin_url'])): ?>
                        <a href="<?php echo esc_url($fac['linkedin_url']); ?>" target="_blank" class="social-icon-fac"
                            title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($fac['scopus_url'])): ?>
                        <a href="<?php echo esc_url($fac['scopus_url']); ?>" target="_blank" class="social-icon-fac"
                            title="Scopus Url"><svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                id="Scopus--Streamline-Simple-Icons" height="24" width="24">
                                <title>Scopus</title>
                                <path
                                    d="m24 19.059 -0.14 -1.777c-1.426 0.772 -2.945 1.076 -4.465 1.076 -3.319 0 -5.96 -2.782 -5.96 -6.475 0 -3.903 2.595 -6.31 5.633 -6.31 1.917 0 3.39 0.303 4.792 1.075L24 4.895c-1.286 -0.608 -2.337 -0.889 -4.698 -0.889 -4.534 0 -7.97 3.53 -7.97 8.017 0 5.12 4.09 7.924 7.9 7.924 1.916 0 3.506 -0.257 4.768 -0.888zm-14.954 -3.46c0 -2.22 -1.964 -3.225 -3.857 -4.347C3.716 10.364 2.15 9.756 2.15 8.12c0 -1.215 0.889 -2.548 2.642 -2.548 1.519 0 2.57 0.234 3.903 1.029l0.117 -1.847c-1.239 -0.514 -2.127 -0.748 -4.137 -0.748C1.8 4.006 0.047 5.876 0.047 8.26c0 2.384 2.103 3.413 4.02 4.581 1.426 0.865 2.922 1.45 2.922 2.992 0 1.496 -1.333 2.571 -2.922 2.571 -1.566 0 -2.594 -0.35 -3.786 -1.075L0 19.176c1.215 0.56 2.454 0.818 4.16 0.818 2.385 0 4.885 -1.473 4.885 -4.395z"
                                    fill="#1e1b4b" stroke-width="1"></path>
                            </svg></a>
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
                    <h4 class="faculty-small-title">Experience</h4>
                    <div class="mt-2">
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
                    <button class="portfolio-tab-btn" data-tab="projects" data-load="true">Projects</button>
                    <button class="portfolio-tab-btn" data-tab="scholars" data-load="true">Research Supervision</button>
                    <button class="portfolio-tab-btn" data-tab="talks">Invited Talks</button>
                    <button class="portfolio-tab-btn" data-tab="others" data-load="true">Others</button>
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

                    <!-- Talks Pane (Pre-loaded via PHP) -->
                    <div class="portfolio-pane" id="talks">
                        <div class="fac-card-premium">
                            <h3 class="rd-section-title">Invited Talks & Lectures</h3>
                            <?php if (!empty($fac['invited_talks'])): ?>
                            <div class="table-responsive">
                                <table class="fac-table">
                                    <thead>
                                        <tr>
                                            <th>Talk Title</th>
                                            <th>Event / Venue</th>
                                            <th>Role</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($fac['invited_talks'] as $talk): ?>
                                        <tr>
                                            <td class="fw-bold" data-label="Title">
                                                <?php echo esc_html($talk['title']); ?>
                                                <?php if (!empty($talk['link'])): ?>
                                                <a href="<?php echo esc_url($talk['link']); ?>" target="_blank"
                                                    class="ms-1" title="View Link"><i class="fas fa-external-link-alt"
                                                        style="font-size:0.8rem; color:#b91c1c;"></i></a>
                                                <?php endif; ?>
                                            </td>
                                            <td data-label="Event">
                                                <?php echo esc_html($talk['event_name']); ?>
                                                <?php if (!empty($talk['venue'])): ?>
                                                <br><small class="text-muted"><i
                                                        class="fas fa-map-marker-alt me-1"></i><?php echo esc_html($talk['venue']); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td data-label="Role">
                                                <?php if (!empty($talk['role'])): ?>
                                                <span
                                                    class="fac-status-badge active"><?php echo esc_html($talk['role']); ?></span>
                                                <?php else: ?>
                                                -
                                                <?php endif; ?>
                                            </td>
                                            <td data-label="Date">
                                                <?php echo !empty($talk['date']) ? date('M d, Y', strtotime($talk['date'])) : '-'; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-microphone-alt mb-3" style="font-size: 2rem; opacity: 0.1;"></i>
                                <p class="text-muted">No invited talks found for this faculty member.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Others Pane (Courses pre-loaded, Patents dynamic) -->
                    <div class="portfolio-pane" id="others">
                        <div class="fac-card-premium mb-4">
                            <h3 class="rd-section-title">Innovations & Patents</h3>
                            <div class="dynamic-feed-container" data-api="others">
                                <div class="rd-loader-wrap text-center py-5">
                                    <div class="fac-loader"></div>
                                </div>
                            </div>
                        </div>

                        <div class="fac-card-premium mb-4">
                            <h3 class="rd-section-title">Consultancy</h3>
                            <div class="dynamic-feed-container" data-api="consultancies">
                                <div class="rd-loader-wrap text-center py-5">
                                    <div class="fac-loader"></div>
                                </div>
                            </div>
                        </div>

                        <div class="fac-card-premium mb-4">
                            <h3 class="rd-section-title">Courses Designed & Developed</h3>
                            <?php if (!empty($fac['course_designs'])): ?>
                            <div class="table-responsive">
                                <table class="fac-table">
                                    <thead>
                                        <tr>
                                            <th>Course Name</th>
                                            <th>Description</th>
                                            <th>Level</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($fac['course_designs'] as $course): ?>
                                        <tr>
                                            <td class="fw-bold" data-label="Course">
                                                <?php echo esc_html($course['course_name']); ?>
                                            </td>
                                            <td class="fw-bold" data-label="Description">
                                                <?php if (!empty($course['description'])): ?>
                                                <div><?php echo wp_kses_post($course['description']); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td data-label="Level">
                                                <?php if (!empty($course['course_level'])): ?>
                                                <span
                                                    class="fac-status-badge active"><?php echo esc_html($course['course_level']); ?></span>
                                                <?php else: ?>
                                                -
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-book-open mb-3" style="font-size: 2rem; opacity: 0.1;"></i>
                                <p class="text-muted">No courses designed by this faculty member.</p>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="fac-card-premium mb-4">
                            <h3 class="rd-section-title">Memberships / Experts</h3>
                            <?php if (!empty($fac['memberships'])): ?>
                            <div class="table-responsive">
                                <table class="fac-table">
                                    <thead>
                                        <tr>
                                            <th>Membership Name</th>
                                            <th>Order No.</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($fac['memberships'] as $mem): ?>
                                        <tr>
                                            <td class="fw-bold" data-label="Name">
                                                <?php echo esc_html($mem['name']); ?>
                                            </td>
                                            <td data-label="Order No.">
                                                <?php echo !empty($mem['order_no']) ? esc_html($mem['order_no']) : '-'; ?>
                                            </td>
                                            <td data-label="Start Date">
                                                <?php echo !empty($mem['start_date']) ? date('M d, Y', strtotime($mem['start_date'])) : '-'; ?>
                                            </td>
                                            <td data-label="End Date">
                                                <?php echo !empty($mem['end_date']) ? date('M d, Y', strtotime($mem['end_date'])) : '-'; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-users mb-3" style="font-size: 2rem; opacity: 0.1;"></i>
                                <p class="text-muted">No memberships found for this faculty member.</p>
                            </div>
                            <?php endif; ?>
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

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.portfolio-tab-btn');
    const panes = document.querySelectorAll('.portfolio-pane');
    const facultyName = "<?php echo esc_js($fac['name']); ?>";
    const facultySlug = "<?php echo esc_js($fac['slug']); ?>";
    const apiBase = "<?php echo esc_js($media_base); ?>";

    // TAB SWITCHING
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.tab;

            tabs.forEach(t => t.classList.remove('active'));
            panes.forEach(p => p.classList.remove('active'));

            tab.classList.add('active');
            document.getElementById(target).classList.add('active');

            if (tab.dataset.load === 'true') {
                if (target === 'others') {
                    loadTabData('patents', document.querySelector(
                        '.dynamic-feed-container[data-api="others"]'));
                    loadTabData('consultancies', document.querySelector(
                        '.dynamic-feed-container[data-api="consultancies"]'));
                } else {
                    loadTabData(target);
                }
                tab.dataset.load = 'false'; // Load only once
            }
        });
    });

    // DYNAMIC DATA LOADER
    async function loadTabData(type, customContainer = null) {
        const container = customContainer || document.querySelector(`#${type} .dynamic-feed-container`);
        let endpoint = '';
        let filterParam = 'faculty__slug'; // Default filter param

        switch (type) {
            case 'publications':
                endpoint = '/api/v1/publications/';
                filterParam = 'faculty__slug';
                break;
            case 'patents':
                endpoint = '/api/v1/patents/';
                filterParam = 'faculty__slug';
                break;
            case 'consultancies':
                endpoint = '/api/v1/consultancies/';
                filterParam = 'faculty__slug';
                break;
            case 'projects':
                endpoint = '/api/v1/research-projects/';
                filterParam = 'pi__slug';
                break;
            case 'scholars':
                endpoint = '/api/v1/research-scholars/';
                filterParam = 'supervisor__slug';
                break;
        }

        try {
            const url =
                `${apiBase}${endpoint}?${filterParam}=${encodeURIComponent(facultySlug)}&page_size=250`;
            const response = await fetch(url);
            const data = await response.json();
            const records = data.results || data;

            if (!records || records.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-folder-open mb-3" style="font-size: 2rem; opacity: 0.1;"></i>
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
        } else if (type === 'consultancies') {
            html += '<th>Nature of Consultancy</th><th>Agency/Organization</th><th>Amount</th>';
        } else if (type === 'projects') {
            html += '<th>Project Title</th><th>Agency</th><th>Amount sanctioned</th><th>Status</th>';
        } else if (type === 'scholars') {
            html +=
                '<th>Enrollment No</th><th>Scholar Name</th><th>Specialization</th><th>Reg Year</th><th>Status</th>';
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
            } else if (type === 'consultancies') {
                html +=
                    `<td class="fw-bold" data-label="Nature">${r.nature_of_consultancy}</td><td data-label="Agency">${r.name_of_awarding_agency_organization || '-'}</td><td data-label="Amount">${r.amount ? '₹'+r.amount : '-'}</td>`;
            } else if (type === 'projects') {
                html +=
                    `<td class="fw-bold" data-label="Project Title">${r.title}</td><td data-label="Agency">${r.funding_agency || '-'}</td><td data-label="Amount">${r.amount_sanctioned || '-'}</td><td data-label="Status"><span class="fac-status-badge ${(r.status||'').toLowerCase()}">${r.status}</span></td>`;
            } else if (type === 'scholars') {
                html +=
                    `<td data-label="Enroll No.">${r.enrollment_no || '-'}</td><td class="fw-bold" data-label="Scholar Name">${r.scholar_name}</td><td data-label="Topic">${r.subject || '-'}</td><td data-label="Topic">${r.registration_year || '-'}</td><td data-label="Status"><span class="fac-status-badge ${(r.status||'').toLowerCase()}">${r.status}</span></td>`;
            }
            html += '</tr>';
        });

        html += '</tbody></table></div>';
        container.innerHTML = html;
    }
});
</script>

<?php get_footer(); ?>
<style>
.rd-section-title {
    margin: 20px;
    font-size: 27px;
}

.empty-state {
    padding: 0 40px;
}

.portfolio-contact-list .contact-item span,
.portfolio-contact-list .contact-item {
    word-break: break-all;
    overflow-wrap: break-word;
    flex: 1;
}
</style>