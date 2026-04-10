<?php
/*
Template Name: Heads of Departments
*/
defined('ABSPATH') || exit;
get_header();

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
$api_url    = $api_base . '/api/v1/departments/';

$response = wp_remote_get($api_url, array('timeout' => 15));
$departments = array();

if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
    $departments = json_decode(wp_remote_retrieve_body($response), true);
}
?>
<?php  get_template_part('banners/about-banner');?>


<main id="primary" class="site-main leadership-page" style="background:#fdfaf6; padding-bottom:60px;">
    
    <!-- <div class="leadership-header py-5 text-center" style="background: linear-gradient(135deg, #0f172a, #1e293b); color: #fff;">
        <div class="container">
            <h1 style="font-family: 'Merriweather', serif; font-weight: 800; font-size: 3rem;">Heads of Departments</h1>
            <p style="font-size: 1.2rem; opacity: 0.9;">The Academic Pillars leading our Departmental Excellence</p>
        </div>
    </div> -->

    <div class="container pt-4">
    <?php get_template_part('template-parts/breadcrumb');?>

        <?php if (!empty($departments)): ?>
        <div class="leadership-grid">
            <?php foreach ($departments as $dept): 
                $hod = $dept['hod'] ?? null;
                if (!$hod) continue; // Skip departments without an HOD assigned
            ?>
            <div class="leader-card">
                <div class="leader-photo-wrap">
                    <?php if (!empty($hod['photo'])): ?>
                        <img src="<?php echo esc_url($media_base . $hod['photo']); ?>" alt="<?php echo esc_attr($hod['name']); ?>">
                    <?php else: ?>
                        <div class="no-photo-placeholder"><i class="fa-solid fa-user-tie"></i></div>
                    <?php endif; ?>
                </div>
                <div class="leader-info">
                    <span class="leader-label">HEAD OF DEPARTMENT</span>
                    <h3 class="leader-name"><?php echo esc_html($hod['name']); ?></h3>
                    <p class="school-name"><?php echo esc_html($dept['name']); ?></p>
                    <p style="font-size:0.75rem; color:#888; margin-top:-5px;">(<?php echo esc_html($dept['school_name'] ?? ''); ?>)</p>
                    
                    <div class="leader-contact">
                        <?php if (!empty($hod['insti_email'])): ?>
                            <a href="mailto:<?php echo esc_attr($hod['insti_email']); ?>" title="Email"><i class="fa-solid fa-envelope"></i></a>
                        <?php else: ?>
                            <a href="mailto:<?php echo esc_attr($hod['other_email']); ?>" title="Email"><i class="fa-solid fa-envelope"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($hod['phone1'])): ?>
                            <a href="tel:<?php echo esc_attr($hod['phone1']); ?>" title="Call"><i class="fa-solid fa-phone"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($hod['phone2'])): ?>
                            <a href="tel:<?php echo esc_attr($hod['phone2']); ?>" title="Call"><i class="fa-solid fa-phone"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="leader-footer">
                    <a href="/departments/<?php echo esc_attr($dept['slug'] ?? '#'); ?>" class="btn-profile">View Department</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <div class="text-center py-5">
                <h3>No data found.</h3>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
/* Reusing shared leadership styles */
.leadership-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
}

.leader-card {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    border: 1px solid #e2d9cc;
    transition: 0.3s;
    display: flex;
    flex-direction: column;
}

.leader-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(139, 26, 26, 0.12);
    border-color: #c9a84c;
}

.leader-photo-wrap {
    height: 280px;
    overflow: hidden;
    background: #f1f5f9;
}

.leader-photo-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.5s;
}

.leader-card:hover .leader-photo-wrap img {
    transform: scale(1.05);
}

.no-photo-placeholder {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 5rem;
    color: #cbd5e1;
}

.leader-info {
    padding: 20px;
    text-align: center;
    flex-grow: 1;
}

.leader-label {
    display: inline-block;
    font-size: 0.65rem;
    font-weight: 800;
    color: #1e293b;
    background: #f1f5f9;
    padding: 3px 12px;
    border-radius: 20px;
    border: 1px solid #cbd5e1;
    margin-bottom: 12px;
    letter-spacing: 1.5px;
}

.leader-name {
    font-family: 'Merriweather', serif;
    font-size: 1.2rem;
    color: #1e293b;
    margin-bottom: 5px;
    font-weight: 800;
}

.school-name {
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 700;
    min-height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1.3;
}

.leader-contact {
    margin-top: 15px;
    display: flex;
    justify-content: center;
    gap: 12px;
}

.leader-contact a {
    width: 32px;
    height: 32px;
    background: #f1f5f9;
    color: #1e293b;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: 0.2s;
}

.leader-contact a:hover {
    background: #1e293b;
    color: #fff;
}

.leader-footer {
    padding: 15px;
    border-top: 1px solid #f1f5f9;
}

.btn-profile {
    display: block;
    width: 100%;
    padding: 10px;
    text-align: center;
    background: #1e293b;
    color: #fff !important;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.85rem;
    transition: 0.2s;
}

.btn-profile:hover {
    background: #0f172a;
    transform: scale(1.02);
}
</style>

<?php get_footer(); ?>
