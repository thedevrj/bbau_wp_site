<?php
/**
 * Template Name: R&D Cell Hub
 */

get_header();

$api_base = getenv('DJANGO_API_URL');
?>

<main id="primary" class="site-main research-portal">
    <div class="research-hero" style="background: linear-gradient(135deg, #312e81 0%, #4338ca 100%);">
        <div class="container">
            <h1>Research & Development Cell</h1>
            <p>Fostering academic industrial collaborations and promoting a vibrant research culture at the University.</p>
            <div class="sub-nav">
                <a href="/research-hub">Research Home</a>
                <a href="#" class="active">About R&D Cell</a>
                <a href="/rd-cell-team">Our Team</a>
            </div>
        </div>
    </div>

    <div class="research-container container">
        <div class="info-grid">
            <div class="main-content">
                <section class="info-card">
                    <h2>Mission & Vision</h2>
                    <p>The R&D Cell acts as a catalyst in promoting the research activities of the University. It provides specialized administrative and technical support for research projects, consultancy, and intellectual property management.</p>
                </section>

                <section class="info-card" style="margin-top:40px;">
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
                        <li><a href="/research/publications"><i class="fas fa-file-alt"></i> Research Publications</a></li>
                        <li><a href="/research/patents"><i class="fas fa-certificate"></i> Granted Patents</a></li>
                        <li><a href="/research-facilities"><i class="fas fa-vial"></i> Research Facilities</a></li>
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
.sub-nav a.active, .sub-nav a:hover {
    opacity: 1;
    background: rgba(255,255,255,0.2);
}

.info-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
}

.info-card {
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}

.info-card h2 {
    color: #1e3a8a;
    font-weight: 700;
    margin-bottom: 20px;
    font-size: 1.75rem;
}

.info-card p {
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
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}

.action-card h3 {
    margin-bottom: 20px;
    font-weight: 700;
    color: #1e293b;
}

@media (max-width: 992px) {
    .info-grid { grid-template-columns: 1fr; }
}
</style>

<?php get_footer(); ?>
