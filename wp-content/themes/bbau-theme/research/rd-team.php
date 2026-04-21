<?php
/**
 * Template Name: R&D Cell Members
 */

get_header();

$api_base = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
$team_url = $api_base . '/api/v1/rd-cell-team/';
$team_res = wp_remote_get($team_url, array('timeout' => 10));
$team = array();

if (!is_wp_error($team_res) && wp_remote_retrieve_response_code($team_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($team_res), true);
    $team = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<main id="primary" class="site-main research-portal">
    <?php get_template_part('banners/about-banner'); ?>

    <div class="research-container container">
        <?php get_template_part('template-parts/breadcrumb');?>

        <div class="team-grid">
            <?php if(!empty($team)): ?>
            <?php foreach($team as $member): ?>
            <div class="member-card">
                <div class="member-photo">
                    <?php if(!empty($member['faculty']['photo'])): ?>
                    <img src="<?php echo $media_base .  esc_url($member['faculty']['photo']); ?>"
                        alt="<?php echo esc_attr($member['faculty']['name']); ?>">
                    <?php else: ?>
                    <div class="photo-placeholder"><i class="fas fa-user"></i></div>
                    <?php endif; ?>
                </div>
                <div class="member-info">
                    <h3><?php echo esc_html($member['faculty']['name']); ?></h3>
                    <div class="member-designation"><?php echo esc_html($member['designation']); ?></div>
                    <div class="member-dept"><?php echo esc_html($member['faculty']['department_name'] ?? ''); ?></div>
                    <a href="/faculty/<?php echo esc_attr($member['faculty']['slug']); ?>" class="profile-link">View
                        Profile</a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="no-data">R&D Cell members details are being updated.</div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>
<style>
.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
}

.member-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
    text-align: center;
}

.member-card:hover {
    transform: translateY(-10px);
}

.member-photo {
    height: 250px;
    background: #f1f5f9;
}

.member-photo img {
    width: 100%;
    height: 100%;
    object-fit: inherit;
}

.photo-placeholder {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    color: #cbd5e1;
}

.member-info {
    padding: 25px;
}

.member-info h3 {
    font-size: 1.25rem;
    color: #1e293b;
    margin-bottom: 5px;
}

.member-designation {
    color: #e11d48;
    font-weight: 700;
    font-size: 0.9rem;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.member-dept {
    font-size: 0.85rem;
    color: #64748b;
    margin-bottom: 20px;
}

.profile-link {
    display: inline-block;
    color: #1e3a8a;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    border-bottom: 2px solid transparent;
}

.profile-link:hover {
    border-bottom: 2px solid #1e3a8a;
}
</style>

<?php get_footer(); ?>