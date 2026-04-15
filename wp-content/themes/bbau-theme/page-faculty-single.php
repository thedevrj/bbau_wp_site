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

<?php get_template_part('banners/about-banner'); ?>

<main id="primary" class="site-main faculty-profile-page" style="background:#fdfaf6; padding-bottom:60px;">
    <div class="container pt-4">

        <?php get_template_part('template-parts/breadcrumb'); ?>

        <?php if ($fac): ?>
        <div class="fp-layout">
            <!-- Left Column: Photo & Quick Info -->
            <aside class="fp-sidebar">
                <div class="fp-photo-card">
                    <?php if (!empty($fac['photo'])): ?>
                    <img src="<?php echo esc_url($media_base . $fac['photo']); ?>"
                        alt="<?php echo esc_attr($fac['photo_alt_text'] ?? $fac['name']); ?>" class="fp-photo">
                    <?php else: ?>
                    <div class="fp-no-photo"><i class="fa-solid fa-user-tie"></i></div>
                    <?php endif; ?>
                </div>

                <div class="fp-quick-info">
                    <h1 class="fp-name"><?php echo esc_html($fac['name']); ?></h1>
                    <p class="fp-designation"><?php echo esc_html($fac['designation']); ?></p>

                    <?php if (!empty($fac['department']['name'])): ?>
                    <a href="<?php echo esc_url(home_url('/departments/' . $fac['department']['slug'])); ?>"
                        class="fp-tag">
                        <i class="fa-solid fa-building-columns"></i> <?php echo esc_html($fac['department']['name']); ?>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($fac['school']['name'])): ?>
                    <a href="<?php echo esc_url(home_url('/schools/' . $fac['school']['slug'])); ?>" class="fp-tag">
                        <i class="fa-solid fa-school"></i> <?php echo esc_html($fac['school']['name']); ?>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($fac['centre']['name'])): ?>
                    <span class="fp-tag"><i class="fa-solid fa-landmark"></i>
                        <?php echo esc_html($fac['centre']['name']); ?></span>
                    <?php endif; ?>

                    <div class="fp-contact-list">
                        <?php if (!empty($fac['insti_email'])): ?>
                        <a href="mailto:<?php echo esc_attr($fac['insti_email']); ?>">
                            <i class="fa-solid fa-envelope"></i> <?php echo esc_html($fac['insti_email']); ?>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($fac['other_email'])): ?>
                        <a href="mailto:<?php echo esc_attr($fac['other_email']); ?>">
                            <i class="fa-regular fa-envelope"></i> <?php echo esc_html($fac['other_email']); ?>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($fac['phone1'])): ?>
                        <a href="tel:<?php echo esc_attr($fac['phone1']); ?>">
                            <i class="fa-solid fa-phone"></i> +91 <?php echo esc_html($fac['phone1']); ?>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($fac['phone2'])): ?>
                        <a href="tel:<?php echo esc_attr($fac['phone2']); ?>">
                            <i class="fa-solid fa-phone"></i> +91 <?php echo esc_html($fac['phone2']); ?>
                        </a>
                        <?php endif; ?>
                    </div>

                    <!-- External Links -->
                    <div class="fp-social-links">
                        <?php if (!empty($fac['google_scholar_url'])): ?>
                        <a href="<?php echo esc_url($fac['google_scholar_url']); ?>" target="_blank"
                            title="Google Scholar">
                            <i class="fa-brands fa-google-scholar"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($fac['linkedin_url'])): ?>
                        <a href="<?php echo esc_url($fac['linkedin_url']); ?>" target="_blank" title="LinkedIn">
                            <i class="fa-brands fa-linkedin"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($fac['website_url'])): ?>
                        <a href="<?php echo esc_url($fac['website_url']); ?>" target="_blank" title="Personal Website">
                            <i class="fa-solid fa-globe"></i>
                        </a>
                        <?php endif; ?>
                    </div>

                    <!-- CV Download -->
                    <?php if (!empty($fac['cv_document'])): ?>
                    <a href="<?php echo esc_url($media_base . $fac['cv_document']); ?>" target="_blank"
                        class="fp-cv-btn">
                        <i class="fa-solid fa-file-pdf"></i> Download CV
                    </a>
                    <?php endif; ?>
                </div>
            </aside>

            <!-- Right Column: Profile Details -->
            <div class="fp-content">

                <!-- Meta Tags -->
                <div class="fp-meta-bar">
                    <?php if (!empty($fac['faculty_type'])): ?>
                    <span class="fp-meta-chip"><i class="fa-solid fa-chalkboard-user"></i>
                        <?php echo esc_html($fac['faculty_type']); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($fac['campus'])): ?>
                    <span class="fp-meta-chip"><i class="fa-solid fa-location-dot"></i>
                        <?php echo esc_html($fac['campus']); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($fac['teaching_exp'])): ?>
                    <span class="fp-meta-chip"><i class="fa-solid fa-clock"></i> Teaching Exp:
                        <?php echo esc_html($fac['teaching_exp']); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($fac['research_exp'])): ?>
                    <span class="fp-meta-chip"><i class="fa-solid fa-flask"></i> Research Exp:
                        <?php echo esc_html($fac['research_exp']); ?></span>
                    <?php endif; ?>
                </div>

                <!-- Qualification -->
                <?php if (!empty($fac['qualification'])): ?>
                <div class="fp-section">
                    <h2><i class="fa-solid fa-graduation-cap"></i> Qualification</h2>
                    <div class="fp-rich-content"><?php echo wp_kses_post($fac['qualification']); ?></div>
                </div>
                <?php endif; ?>

                <!-- Bio -->
                <?php if (!empty($fac['bio'])): ?>
                <div class="fp-section">
                    <h2><i class="fa-solid fa-user"></i> About</h2>
                    <div class="fp-rich-content"><?php echo wp_kses_post($fac['bio']); ?></div>
                </div>
                <?php endif; ?>

                <!-- Research Interest -->
                <?php if (!empty($fac['research_int'])): ?>
                <div class="fp-section">
                    <h2><i class="fa-solid fa-microscope"></i> Research Interests</h2>
                    <div class="fp-rich-content"><?php echo wp_kses_post($fac['research_int']); ?></div>
                </div>
                <?php endif; ?>

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

<style>
/* ── Layout ── */
.fp-layout {
    display: grid;
    grid-template-columns: 340px 1fr;
    gap: 35px;
    align-items: start;
}

/* ── Sidebar ── */
.fp-sidebar {
    position: sticky;
    top: 100px;
}

.fp-photo-card {
    border-radius: 20px;
    overflow: hidden;
    border: 3px solid #c9a84c;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.fp-photo {
    width: 100%;
    height: 380px;
    object-fit: cover;
    display: block;
}

.fp-no-photo {
    width: 100%;
    height: 380px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 5rem;
    color: #cbd5e1;
}

.fp-quick-info {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 20px;
    padding: 25px;
    margin-top: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
}

.fp-name {
    font-family: 'Merriweather', serif;
    font-size: 1.5rem;
    color: #5c1010;
    margin: 0 0 6px;
    font-weight: 800 !important;
}

.fp-designation {
    font-size: 1rem;
    color: #8B1A1A;
    font-weight: 600;
    margin: 0 0 15px;
}

.fp-tag {
    display: inline-block;
    font-size: 0.8rem;
    background: #fdfaf6;
    border: 1px solid #e2d9cc;
    padding: 5px 14px;
    border-radius: 25px;
    color: #64748b !important;
    font-weight: 600;
    margin: 0 5px 8px 0;
    text-decoration: none;
    transition: 0.2s;
}

.fp-tag:hover {
    border-color: #c9a84c;
    color: #5c1010;
}

/* Contact */
.fp-contact-list {
    margin-top: 18px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.fp-contact-list a {
    font-size: 0.88rem;
    color: #475569;
    text-decoration: none;
    transition: 0.2s;
    display: flex;
    align-items: center;
    gap: 10px;
}

.fp-contact-list a:hover {
    color: #8B1A1A;
}

.fp-contact-list i {
    width: 16px;
    text-align: center;
    color: #8B1A1A;
}

/* Social */
.fp-social-links {
    margin-top: 18px;
    display: flex;
    gap: 12px;
}

.fp-social-links a {
    width: 40px;
    height: 40px;
    background: #f1f5f9;
    color: #5c1010;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 1.1rem;
    transition: 0.2s;
}

.fp-social-links a:hover {
    background: #8B1A1A;
    color: #fff;
}

/* CV Button */
.fp-cv-btn {
    display: block;
    width: 100%;
    margin-top: 20px;
    padding: 12px;
    text-align: center;
    background: #5c1010;
    color: #fff !important;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.95rem;
    transition: 0.2s;
}

.fp-cv-btn:hover {
    background: #8B1A1A;
    transform: scale(1.02);
}

/* ── Content Area ── */
.fp-meta-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 25px;
}

.fp-meta-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #5c1010;
    background: #fff;
    border: 1px solid #e2d9cc;
    padding: 8px 16px;
    border-radius: 25px;
}

.fp-section {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 16px;
    padding: 25px 30px;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
}

.fp-section h2 {
    font-family: 'Merriweather', serif !important;
    font-size: 1.2rem !important;
    color: #5c1010;
    margin: 0 0 15px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 10px;
}

.fp-section h2 i {
    color: #c9a84c;
}

.fp-rich-content {
    font-size: 0.95rem;
    line-height: 1.8;
    color: #334155;
}

.fp-rich-content p {
    margin-bottom: 10px;
}

.fp-rich-content ul,
.fp-rich-content ol {
    padding-left: 20px;
}

/* ── Responsive ── */
@media (max-width: 900px) {
    .fp-layout {
        grid-template-columns: 1fr;
    }

    .fp-sidebar {
        position: static;
    }

    .fp-photo {
        height: 300px;
    }

    .fp-no-photo {
        height: 300px;
    }
}
</style>

<?php get_footer(); ?>