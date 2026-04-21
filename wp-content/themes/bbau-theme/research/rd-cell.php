<?php
/**
 * Template Name: R&D Cell 
 */

get_header();

$api_base = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');

// Fetch Team to find Director
$team_url = $api_base . '/api/v1/rd-cell-team/';
$team_res = wp_remote_get($team_url, array('timeout' => 10));
$director = null;
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

<main id="primary" class="site-main research-portal">
    <div class="research-hero" style="background: linear-gradient(135deg, #312e81 0%, #4338ca 100%);">
        <div class="container">
            <h1>Research & Development Cell</h1>
            <p>Fostering academic industrial collaborations and promoting a vibrant research culture at the University.
            </p>
        </div>
    </div>

    <div class="research-container container">
        <?php get_template_part('template-parts/breadcrumb');?>
        <div class="info-grid">
            <div class="main-content">
                <?php if ($director): ?>
                <section class="director-profile-card">
                    <div class="director-header">
                        <div class="director-photo-container">
                            <?php if (!empty($director['faculty']['photo'])): ?>
                            <img src="<?php echo $media_base . esc_url($director['faculty']['photo']); ?>"
                                alt="<?php echo esc_attr($director['faculty']['name']); ?>">
                            <?php else: ?>
                            <div class="photo-placeholder-circle"><i class="fas fa-user"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="director-meta">
                            <h2 class="director-name"><?php echo esc_html($director['faculty']['name']); ?></h2>
                            <div class="director-title"><?php echo esc_html($director['designation']); ?>, R&D Cell
                            </div>
                            <div class="director-dept">
                                <?php echo esc_html($director['faculty']['department_name'] ?? ''); ?></div>
                        </div>
                    </div>
                    <div class="director-message">
                        <p>Research and Development Cell is functional as per University Guidelines and guidelines of
                            National Education Policy (NEP 2020). The objective of this cell is to facilitate all the
                            stakeholders with smooth functioning in the domain of research and development.

                        </p>
                        <a href="/faculty/<?php echo esc_attr($director['faculty']['slug'] ?? ''); ?>"
                            class="view-profile-btn">View Profile <i class="fas fa-external-link-alt"></i></a>
                    </div>
                </section>
                <?php endif; ?>

                <section class="info-cards">
                    <h2>Mission & Vision</h2>
                    <p>The R&D Cell acts as a catalyst in promoting the research activities of the University. It
                        provides specialized administrative and technical support for research projects, consultancy,
                        and intellectual property management.</p>
                </section>

                <section class="info-cards" style="margin-top:40px;">
                    <h2>Key Responsibilities</h2>
                    <ul class="fancy-list">
                        <li>Facilitating funded research projects from national and international agencies.</li>
                        <li>Assisting in filing patents and commercialization of technology.</li>
                        <li>Organizing research workshops, seminars, and training programs.</li>
                        <li>Monitoring the progress of PhD scholars and research associates.</li>
                        <li>Promoting inter-departmental and inter-university research collaborations.</li>
                    </ul>
                </section>
            </div>

            <aside class="sidebar">
                <div class="action-card">
                    <h3>Quick Links</h3>
                    <ul class="sidebar-links">
                        <li><a href="/publications"><i class="fas fa-file-alt"></i> Research Publications</a>
                        </li>
                        <li><a href="/patents"><i class="fas fa-certificate"></i> Granted Patents</a></li>
                        <li><a href="/research-facilities/"><i class="fas fa-vial"></i> Research Facilities</a></li>
                        <li><a href="#"><i class="fas fa-download"></i> R&D Guidelines (PDF)</a></li>
                    </ul>
                </div>
        </div>
    </div>
    </div>
</main>

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>
<style>
.sub-nav {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 30px;
}

.sub-nav a {
    color: white;
    text-decoration: none;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 4px;
    opacity: 0.8;
}

.sub-nav a.active,
.sub-nav a:hover {
    opacity: 1;
    background: rgba(255, 255, 255, 0.2);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 40px;
}

@media (min-width: 993px) {
    .info-grid {
        grid-template-columns: 2fr 1fr;
    }
}

.info-cards {
    background: white;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
}

/* DIRECTOR PROFILE CARD */
.director-profile-card {
    background: white;
    padding: 2.5rem;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    margin-bottom: 40px;
    border: 1px solid #f1f5f9;
    position: relative;
    overflow: hidden;
}

.director-header {
    display: flex;
    align-items: center;
    gap: 25px;
    margin-bottom: 25px;
    flex-wrap: wrap;
}

.director-photo-container {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid #f8fafc;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
}

.director-photo-container img {
    width: 100%;
    height: 100%;
    object-fit: inherit;
}

.photo-placeholder-circle {
    width: 100%;
    height: 100%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: #cbd5e1;
}

.director-name {
    font-size: 1.75rem;
    font-weight: 800;
    color: #1e3a8a;
    margin: 0 0 5px 0;
}

.director-title {
    font-size: 1rem;
    font-weight: 700;
    color: #e11d48;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.director-dept {
    font-size: 0.9rem;
    color: #64748b;
}

.director-message {
    border-top: 1px solid #f1f5f9;
    padding-top: 20px;
}

.director-message p {
    font-style: italic;
    color: #475569;
    line-height: 1.8;
}

.view-profile-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin-top: 15px;
    color: #1e3a8a !important;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: all 0.3s;
}

.view-profile-btn:hover {
    color: #3b82f6 !important;
    transform: translateX(5px);
}

.info-cards h2 {
    color: #1e3a8a;
    font-weight: 700;
    margin-bottom: 20px;
    font-size: 1.75rem;
}

.info-cards p {
    line-height: 1.8;
    color: #475569;
    font-size: 1.1rem;
}

.fancy-list {
    list-style: none;
    padding: 0;
}

.fancy-list li {
    padding: 15px 0 15px 35px;
    border-bottom: 1px solid #f1f5f9;
    position: relative;
    color: #334155;
}

.fancy-list li::before {
    content: "\f058";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    left: 0;
    color: #10b981;
}

.sidebar-links {
    list-style: none;
    padding: 0;
}

.sidebar-links li a {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    color: #475569;
    text-decoration: none;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s;
}

.sidebar-links li a:hover {
    background: #f1f5f9;
    color: #1e3a8a;
}

.action-card {
    background: white;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
}

.action-card h3 {
    margin-bottom: 20px;
    font-weight: 700;
    color: #1e293b;
}

@media (max-width: 640px) {
    .director-header {
        flex-direction: column;
        text-align: center;
    }

    .director-photo-container {
        margin: 0 auto;
    }

    .info-cards,
    .director-profile-card,
    .action-card {
        padding: 1.5rem;
    }

    .research-hero h1 {
        font-size: 1.75rem;
    }

    .research-hero p {
        font-size: 1rem;
    }
}
</style>

<?php get_footer(); ?>