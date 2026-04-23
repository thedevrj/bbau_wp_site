<?php
/**
 * Template Name: R&D Cell 
 */

get_header();

$api_base = getenv('DJANGO_MEDIA_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'about';

// Fetch Team data for the "Team" tab
$team_members = array();
$director = null;
$team_url = $api_base . '/api/v1/rd-cell-team/';
$team_res = wp_remote_get($team_url, array('timeout' => 10));
if (!is_wp_error($team_res) && wp_remote_retrieve_response_code($team_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($team_res), true);
    $team_members = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
    foreach ($team_members as $member) {
        if (isset($member['designation']) && strtolower($member['designation']) === 'director') {
            $director = $member;
            break;
        }
    }
}
?>

<main id="primary" class="site-main page-bg research-portal">
    <!-- PREMIUM HERO BANNER -->
    <section class="premium-hero-rd">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content-glass">
                <div class="badge-new-rd">BBAU Research Hub</div>
                <h1>Research & Development Cell</h1>
            </div>
        </div>
    </section>

    <!-- ELEGANT TAB NAVIGATION -->
    <div class="rd-tab-nav-wrapper">
        <div class="container">
            <nav class="rd-tab-nav">
                <a href="?tab=about" class="<?php echo $active_tab === 'about' ? 'active' : ''; ?>">
                    <i class="fas fa-info-circle"></i> About Cell
                </a>
                <a href="?tab=team" class="<?php echo $active_tab === 'team' ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i> Our Team
                </a>
                <a href="?tab=policies" class="<?php echo $active_tab === 'policies' ? 'active' : ''; ?>">
                    <i class="fas fa-file-signature"></i> Policies & Guidelines
                </a>
                <a href="?tab=links" class="<?php echo $active_tab === 'links' ? 'active' : ''; ?>">
                    <i class="fas fa-link"></i> Important Links
                </a>
            </nav>
        </div>
    </div>

    <div class="research-container container">
        <div class="rd-content-area">

            <?php if ($active_tab === 'about'): ?>
            <!-- ABOUT TAB -->
            <div class="rd-tab-pane animate-up">
                <div class="rd-flex-layout">
                    <div class="rd-main-text">
                        <div class="rd-card-premium">
                            <h2 class="rd-section-title">Mission & Objectives</h2>
                            <p>The Research and Development (R&D) Cell at BBAU is dedicated to fostering a vibrant
                                research ecosystem. Aligned with the <strong>National Education Policy (NEP
                                    2020)</strong>, the cell acts as a central facilitator for faculty, scholars, and
                                industry partners.</p>

                            <div class="rd-objectives-grid">
                                <div class="obj-card">
                                    <i class="fas fa-rocket"></i>
                                    <h4>Innovation</h4>
                                    <p>Nurturing disruptive ideas and providing the resources to bring them to fruition.
                                    </p>
                                </div>
                                <div class="obj-card">
                                    <i class="fas fa-handshake"></i>
                                    <h4>Collaboration</h4>
                                    <p>Bridging the gap between academia and industry for mutual translational research.
                                    </p>
                                </div>
                                <div class="obj-card">
                                    <i class="fas fa-shield-alt"></i>
                                    <h4>Integrity</h4>
                                    <p>Ensuring ethical research practices and high standards of academic honesty.</p>
                                </div>
                            </div>

                            <h2 class="rd-section-title mt-5 mb-4">Core Responsibilities</h2>
                            <ul class="rd-checklist">
                                <li>Management of Externally Funded Projects (DST, DBT, UGC, CSIR).</li>
                                <li>IPR Facilitation & Patent Prosecution support.</li>
                                <li>Coordination of Interdisciplinary Research Clusters.</li>
                                <li>Incentivizing high-impact publications and citations.</li>
                                <li>Administrative oversight of Doctoral research progress.</li>
                            </ul>
                        </div>
                    </div>

                    <aside class="rd-sidebar">
                        <?php if ($director): ?>
                        <div class="director-profile-mini">
                            <div class="dir-top">
                                <img src="<?php echo $media_base . esc_url($director['faculty']['photo']); ?>"
                                    alt="Director">
                                <div class="dir-info">
                                    <h4><?php echo esc_html($director['faculty']['name']); ?></h4>
                                    <span>Director, R&D Cell</span>
                                </div>
                            </div>
                            <div class="dir-msg">
                                "Our cell is committed to providing a seamless administrative experience so that our
                                researchers can focus on what they do best: creating new knowledge."
                            </div>
                            <a href="/faculty/<?php echo esc_attr($director['faculty']['slug']); ?>"
                                class="btn-rd-profile">View Profile</a>
                        </div>
                        <?php endif; ?>
                    </aside>
                </div>
            </div>

            <?php elseif ($active_tab === 'team'): ?>
            <!-- TEAM TAB -->
            <div class="rd-tab-pane animate-up">
                <h2 class="rd-section-title text-center mb-5">Leadership & Administration</h2>
                <div class="rd-team-grid">
                    <?php foreach ($team_members as $member): ?>
                    <div class="team-card-rd">
                        <div class="team-img-wrap">
                            <?php if (!empty($member['faculty']['photo'])): ?>
                            <img src="<?php echo $media_base . esc_url($member['faculty']['photo']); ?>" alt="">
                            <?php else: ?>
                            <div class="img-placeholder"><i class="fas fa-user-tie"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="team-details-rd">
                            <h3><?php echo esc_html($member['faculty']['name']); ?></h3>
                            <span class="designation-rd"><?php echo esc_html($member['designation']); ?></span>
                            <span
                                class="dept-rd text-muted small"><?php echo esc_html($member['faculty']['department_name'] ?? ''); ?></span>
                            <a href="/faculty/<?php echo esc_attr($member['faculty']['slug']); ?>"
                                class="team-link">Profile <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php elseif ($active_tab === 'policies'): ?>
            <!-- POLICIES TAB -->
            <div class="rd-tab-pane animate-up">
                <div class="rd-card-premium">
                    <h2 class="rd-section-title">Institutional Guidelines</h2>
                    <p class="mb-4">Governing all research activities, financial management of projects, and ethical
                        standards at Babasaheb Bhimrao Ambedkar University.</p>

                    <div class="policy-list">
                        <div class="policy-item">
                            <div class="policy-icon"><i class="fas fa-file-pdf"></i></div>
                            <div class="policy-info">
                                <h4>Research & Consultancy Policy 2024</h4>
                                <p>Detailed guidelines for sponsored projects and consultancy services.</p>
                            </div>
                            <a href="#" class="btn-rd-download">Download</a>
                        </div>
                        <div class="policy-item">
                            <div class="policy-icon"><i class="fas fa-file-pdf"></i></div>
                            <div class="policy-info">
                                <h4>IPR Policy & Procedures</h4>
                                <p>Framework for invention disclosure and IP ownership management.</p>
                            </div>
                            <a href="#" class="btn-rd-download">Download</a>
                        </div>
                        <div class="policy-item">
                            <div class="policy-icon"><i class="fas fa-file-pdf"></i></div>
                            <div class="policy-info">
                                <h4>Ethics Committee Guidelines</h4>
                                <p>Standards for research involving human and animal subjects.</p>
                            </div>
                            <a href="#" class="btn-rd-download">Download</a>
                        </div>
                        <div class="policy-item">
                            <div class="policy-icon"><i class="fas fa-file-pdf"></i></div>
                            <div class="policy-info">
                                <h4>PhD Regulation 2023 (As per NEP)</h4>
                                <p>Admission, evaluation, and registration criteria for scholars.</p>
                            </div>
                            <a href="#" class="btn-rd-download">Download</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php elseif ($active_tab === 'links'): ?>
            <!-- LINKS TAB -->
            <div class="rd-tab-pane animate-up">
                <h2 class="rd-section-title text-center mb-5">Quick Access</h2>
                <div class="rd-links-grid">
                    <a href="research-areas" class="rd-portal-link">
                        <div class="icon-wrap"><i class="fas fa-th-large"></i></div>
                        <h3>Research Areas</h3>
                        <p>Explore the diverse research domains at BBAU.</p>
                    </a>
                    <a href="/doctoral-research/" class="rd-portal-link">
                        <div class="icon-wrap"><i class="fas fa-user-graduate"></i></div>
                        <h3>Doctoral Research</h3>
                        <p>Real-time tracking of PhD scholars and fellowships.</p>
                    </a>
                    <a href="/projects/" class="rd-portal-link">
                        <div class="icon-wrap"><i class="fas fa-flask"></i></div>
                        <h3>Ongoing Projects</h3>
                        <p>Comprehensive database of active research initiatives.</p>
                        <a href="/publications" class="rd-portal-link">
                            <div class="icon-wrap"><i class="fas fa-book"></i></div>
                            <h3>Research Publications</h3>
                            <p>Explore the scholarly output of our faculty members.</p>
                        </a>
                        <a href="/patents" class="rd-portal-link">
                            <div class="icon-wrap"><i class="fas fa-certificate"></i></div>
                            <h3>Patents</h3>
                            <p>Showcasing our institutional intellectual property.</p>
                        </a>
                        <a href="/research-facilities/" class="rd-portal-link">
                            <div class="icon-wrap"><i class="fas fa-microscope"></i></div>
                            <h3>Research Facilities</h3>
                            <p>Centralized equipment and laboratory instrumentation.</p>
                        </a>
                        <!-- <a href="https://vidwan.inflibnet.ac.in/" target="_blank" class="rd-portal-link">
                        <div class="icon-wrap"><i class="fas fa-id-card"></i></div>
                        <h3>Vidwan / IRINS</h3>
                        <p>National research network profiles of BBAU faculty.</p>
                    </a> -->
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</main>

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>
<style>
/* ================= PREMIUM RD STYLES ================= */
:root {
    --rd-indigo: #1e1b4b;
    --rd-royal: #1e3a8a;
    --rd-gold: #c9a84c;
    --rd-slate: #f8fafc;
}

/* HERO SECTION */
.premium-hero-rd {
    height: 350px;
    background: url('https://images.unsplash.com/photo-1532187875605-2fe35951856c?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.premium-hero-rd .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(30, 27, 75, 0.95), rgba(30, 58, 138, 0.7));
}

.hero-content-glass {
    position: relative;
    z-index: 2;
    max-width: 800px;
    color: white;
}

.badge-new-rd {
    display: inline-block;
    background: var(--rd-gold);
    color: var(--rd-indigo);
    padding: 6px 16px;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(201, 168, 76, 0.3);
}

.hero-content-glass h1 {
    line-height: 1.1;
    margin-bottom: 20px;
    text-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.hero-content-glass p {
    font-size: 1.4rem;
    opacity: 0.9;
    font-weight: 300;
}

/* TAB NAVIGATION */
.rd-tab-nav-wrapper {
    background: white;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    position: sticky;
    top: 80px;
    /* Adjust based on your header height */
    z-index: 100;
    border-bottom: 2px solid #f1f5f9;
}

.rd-tab-nav {
    display: flex;
    justify-content: center;
}

.rd-tab-nav a {
    padding: 22px 30px;
    text-decoration: none !important;
    color: #475569;
    font-weight: 700;
    font-size: 1.05rem;
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 4px solid transparent;
    transition: all 0.3s;
}

.rd-tab-nav a i {
    font-size: 1.2rem;
    opacity: 0.6;
}

.rd-tab-nav a:hover {
    color: var(--rd-royal);
    background: #f8fafc;
}

.rd-tab-nav a.active {
    color: var(--rd-royal);
    border-bottom-color: var(--rd-gold);
    background: #f1f5f9;
}

/* MAIN CONTENT AREA */
.rd-tab-pane {
    padding: 20px 0 60px;
}

.animate-up {
    animation: fadeInUpRD 0.6s ease-out forwards;
}

@keyframes fadeInUpRD {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.rd-flex-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
}

.rd-card-premium {
    background: white;
    padding: 40px;
    border-radius: 24px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
    border: 1px solid #f1f5f9;
}

/* SECTION TITLES */
.rd-section-title {
    color: var(--rd-indigo);
    position: relative;
    display: inline-block;
}

.rd-section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 60px;
    height: 5px;
    background: var(--rd-gold);
    border-radius: 10px;
}

/* OBJECTIVES GRID */
.rd-objectives-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-top: 35px;
}

.obj-card {
    padding: 30px;
    background: #f8fafc;
    border-radius: 20px;
    text-align: center;
    transition: all 0.3s;
}

.obj-card:hover {
    transform: translateY(-5px);
    background: #f1f5f9;
}

.obj-card i {
    font-size: 2rem;
    color: var(--rd-gold);
    margin-bottom: 15px;
}

.obj-card h4 {
    font-weight: 800;
    color: var(--rd-indigo);
    margin-bottom: 10px;
}

.obj-card p {
    font-size: 0.9rem;
    color: #64748b;
    line-height: 1.5;
    margin: 0;
}

/* CHECKLIST */
.rd-checklist {
    list-style: none;
    padding: 0;
}

.rd-checklist li {
    padding: 12px 0 12px 40px;
    font-size: 1.1rem;
    color: #334155;
    position: relative;
    border-bottom: 1px solid #f1f5f9;
}

.rd-checklist li::before {
    content: '\f058';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    left: 0;
    color: #10b981;
}

/* DIRECTOR MINI */
.director-profile-mini {
    background: white;
    padding: 30px;
    border-radius: 24px;
    box-shadow: 0 20px 50px rgba(30, 27, 75, 0.08);
    position: sticky;
    top: 180px;
}

.dir-top {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
}

.dir-top img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--rd-gold);
}

.dir-top h4 {
    margin: 0;
    font-weight: 800;
    color: var(--rd-indigo);
}

.dir-top span {
    display: block;
    font-size: 0.85rem;
    color: #ef4444;
    font-weight: 700;
    text-transform: uppercase;
}

.dir-msg {
    font-style: italic;
    color: #475569;
    line-height: 1.7;
    font-size: 0.95rem;
    margin-bottom: 20px;
    position: relative;
    padding: 20px;
    background: #f8fafc;
    border-radius: 12px;
}

.dir-msg::before {
    content: '“';
    position: absolute;
    top: 0;
    left: 5px;
    font-size: 3rem;
    color: var(--rd-gold);
    opacity: 0.3;
}

.btn-rd-profile {
    display: block;
    width: 100%;
    text-align: center;
    background: var(--rd-royal);
    color: white !important;
    padding: 12px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.3s;
}

.btn-rd-profile:hover {
    background: var(--rd-indigo);
    transform: scale(1.02);
}

/* TEAM GRID */
.rd-team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
}

.team-card-rd {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    border: 1px solid #f1f5f9;
    transition: all 0.3s;
}

.team-card-rd:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
}

.team-img-wrap {
    height: 250px;
    position: relative;
}

.team-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.img-placeholder {
    height: 100%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    color: #cbd5e1;
}

.team-details-rd {
    padding: 25px;
    text-align: center;
}

.team-details-rd h3 {
    font-size: 1.25rem;
    font-weight: 800;
    margin-bottom: 5px;
    color: var(--rd-indigo);
}

.designation-rd {
    display: block;
    color: #ef4444;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 1px;
    margin-bottom: 10px;
}

.team-link {
    color: var(--rd-royal) !important;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.team-link i {
    margin-left: 5px;
    font-size: 0.8rem;
}

/* POLICY LIST */
.policy-item {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 25px;
    border-radius: 16px;
    background: #f8fafc;
    margin-bottom: 20px;
    border: 1px solid #f1f5f9;
    transition: all 0.3s;
}

.policy-item:hover {
    background: #f1f5f9;
    border-color: var(--rd-gold);
}

.policy-icon {
    width: 60px;
    height: 60px;
    background: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #ef4444;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.policy-info {
    flex-grow: 1;
}

.policy-info h4 {
    margin: 0 0 5px 0;
    font-weight: 800;
    color: var(--rd-indigo);
}

.policy-info p {
    margin: 0;
    font-size: 0.9rem;
    color: #64748b;
}

.btn-rd-download {
    background: var(--rd-royal);
    color: white !important;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 700;
    text-decoration: none;
    font-size: 0.85rem;
}

/* PORTAL LINKS GRID */
.rd-links-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.rd-portal-link {
    background: white;
    padding: 40px 30px;
    border-radius: 24px;
    text-align: center;
    text-decoration: none !important;
    border: 1px solid #f1f5f9;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.rd-portal-link:hover {
    transform: translateY(-15px);
    border-color: var(--rd-gold);
    box-shadow: 0 30px 60px rgba(30, 27, 75, 0.1);
}

.rd-portal-link .icon-wrap {
    width: 80px;
    height: 80px;
    background: #f1f5f9;
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.9rem;
    color: var(--rd-royal);
    margin: 0 auto 25px;
    transition: all 0.3s;
}

.rd-portal-link:hover .icon-wrap {
    background: var(--rd-indigo);
    color: white;
    transform: rotate(10deg);
}

.rd-portal-link h3 {
    font-weight: 800;
    color: var(--rd-indigo);
    margin-bottom: 12px;
}

.rd-portal-link p {
    color: #64748b;
    font-size: 0.95rem;
    line-height: 1.5;
    margin: 0;
}

@media (max-width: 1024px) {

    .rd-flex-layout,
    .rd-objectives-grid,
    .rd-links-grid {
        grid-template-columns: 1fr;
    }

    .hero-content-glass h1 {
        font-size: 2rem;
    }

    .rd-tab-nav a {
        padding: 18px 20px;
        font-size: 0.95rem;
    }

    .rd-links-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .rd-tab-nav {
        flex-wrap: wrap;
    }

    .rd-tab-nav a {
        width: 50%;
        border-bottom: 2px solid #f1f5f9;
    }

    .rd-links-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>