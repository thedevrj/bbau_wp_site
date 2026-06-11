<?php
/*
Template Name: Deans of Schools
*/
defined('ABSPATH') || exit;
get_header();

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
$api_url    = $api_base . '/api/v1/schools/';

$response = wp_remote_get($api_url, array('timeout' => 15));
$schools = array();

if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
    $schools = json_decode(wp_remote_retrieve_body($response), true);
}
?>
<?php  get_template_part('banners/about-banner');?>

<main id="primary" class="site-main leadership-page" style="background:#fdfaf6; padding-bottom:60px;">
    
    <!-- <div class="leadership-header py-5 text-center" style="background: linear-gradient(135deg, #5c1010, #8B1A1A); color: #fff;">
        <div class="container">
            <h1 style="font-family: 'Merriweather', serif; font-weight: 700; font-size: 3rem;">Deans of Schools</h1>
            <p style="font-size: 1.2rem; opacity: 0.9;">Leading the Academic Excellence across BBAU</p>
        </div>
    </div> -->
    <div class="container pt-4">
    
    <?php get_template_part('template-parts/breadcrumb');?>

        <?php if (!empty($schools)): ?>
        <div class="leadership-grid">
            <?php foreach ($schools as $school): 
                $dean = $school['dean'] ?? null;
                if (!$dean) continue; // Skip schools without a Dean assigned
            ?>
            <div class="leader-card">
                <div class="leader-photo-wrap">
                    <?php if (!empty($dean['photo'])): ?>
                        <img src="<?php echo esc_url($media_base . $dean['photo']); ?>" alt="<?php echo esc_attr($dean['name']); ?>">
                    <?php else: ?>
                        <div class="no-photo-placeholder"><i class="fa-solid fa-user-tie"></i></div>
                    <?php endif; ?>
                </div>
                <div class="leader-info">
                    <!-- <span class="leader-label">DEAN</span> -->
                    <h3 class="leader-name"><?php echo esc_html($dean['name']); ?></h3>
                    <p class="school-name"><?php echo esc_html($school['name']); ?></p>
                    
                    <div class="leader-contact">
                        <?php if (!empty($dean['insti_email'])): ?>
                            <a href="mailto:<?php echo esc_attr($dean['insti_email']); ?>" title="Email"><i class="fa-solid fa-envelope"></i></a>
                        <?php else: ?>
                            <a href="mailto:<?php echo esc_attr($dean['other_email']); ?>" title="Email"><i class="fa-solid fa-envelope"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($dean['phone1'])): ?>
                            <a href="tel:<?php echo esc_attr($dean['phone1']); ?>" title="Call"><i class="fa-solid fa-phone"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($dean['phone2'])): ?>
                            <a href="tel:<?php echo esc_attr($dean['phone2']); ?>" title="Call"><i class="fa-solid fa-phone"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="leader-footer">
                    <a href="/schools/<?php echo esc_attr($school['slug'] ?? '#'); ?>" class="btn-profile">View School</a>
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
.leadership-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
}

.leader-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    border: 1px solid #e2d9cc;
    transition: 0.3s;
    display: flex;
    flex-direction: column;
    position: relative;
}

.leader-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 120px;
    background: linear-gradient(135deg, #8B1A1A, #5c1010);
    z-index: 0;
    border-radius: 20px 20px 0 0;
}

.leader-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(139, 26, 26, 0.12);
    border-color: #c9a84c;
}

.leader-photo-wrap {
    height: 180px;
    width: 180px;
    margin: 30px auto 15px;
    position: relative;
    background: #f1f5f9;
    border-radius: 50%;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    z-index: 1;
    border: 5px solid white;
}

.leader-photo-wrap img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: inherit;
    transition: 0.5s;
}

.leader-card:hover .leader-photo-wrap img {
    transform: scale(1.08);
}

.no-photo-placeholder {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 5rem;
    color: #cbd5e1;
}

.leader-info {
    position: relative;
    z-index: 1;
    padding: 25px;
    text-align: center;
    flex-grow: 1;
    padding-bottom: 8px;
}

.leader-label {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 700;
    color: #8B1A1A;
    background: #fdfaf6;
    padding: 4px 15px;
    border-radius: 20px;
    border: 1px solid #c9a84c;
    margin-bottom: 12px;
    letter-spacing: 2px;
}

.leader-name {
    font-family: 'Merriweather', serif;
    font-size: 1.1rem;
    color: #5c1010;
    margin-bottom: 8px;
    font-weight: 700;
}

.school-name {
    font-size: 1rem;
    color: #64748b;
    font-weight: 600;
    min-height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.leader-contact {
    margin-top: 15px;
    display: flex;
    justify-content: center;
    gap: 15px;
}

.leader-contact a {
    width: 35px;
    height: 35px;
    background: #f1f5f9;
    color: #5c1010;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: 0.2s;
}

.leader-contact a:hover {
    background: #8B1A1A;
    color: #fff;
}

.leader-footer {
    padding: 20px;
    border-top: 1px solid #f1f5f9;
}

.btn-profile {
    display: block;
    width: 100%;
    padding: 12px;
    text-align: center;
    background: #5c1010;
    color: #fff !important;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: 0.2s;
}

.btn-profile:hover {
    background: #8B1A1A;
    transform: scale(1.02);
}
</style>

<?php get_footer(); ?>
