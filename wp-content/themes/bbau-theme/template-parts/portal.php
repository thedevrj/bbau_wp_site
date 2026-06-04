<?php
/**
 * Template Name: Portal Directory
 *
 * ACF FIELDS:
 *  page_heading     — Text
 *  page_subheading  — Text
 *  portals          — Repeater
 *    portal_name    — Text
 *    portal_link    — URL
 */

get_header();
?>

<!-- Banner -->
<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid page-bg page-template-about-bg py-5 overflow-hidden">

<?php get_template_part('template-parts/breadcrumb'); ?>

<!-- Menu -->
<?php get_template_part('template-parts/page-menu'); ?>

<?php
$page_heading    = get_field('page_heading')    ?: get_the_title();
$page_subheading = get_field('page_subheading') ?: '';
$portals         = get_field('portals');

$colors = [
    ['bg' => '#FBEAF0', 'border' => '#F4C0D1', 'icon_bg' => '#993556', 'name' => '#72243E', 'btn' => '#993556'],
    ['bg' => '#E6F1FB', 'border' => '#B5D4F4', 'icon_bg' => '#185FA5', 'name' => '#0C447C', 'btn' => '#185FA5'],
    ['bg' => '#EAF3DE', 'border' => '#C0DD97', 'icon_bg' => '#3B6D11', 'name' => '#27500A', 'btn' => '#3B6D11'],
    ['bg' => '#FAEEDA', 'border' => '#FAC775', 'icon_bg' => '#BA7517', 'name' => '#633806', 'btn' => '#BA7517'],
    ['bg' => '#EEEDFE', 'border' => '#CECBF6', 'icon_bg' => '#534AB7', 'name' => '#3C3489', 'btn' => '#534AB7'],
    ['bg' => '#E1F5EE', 'border' => '#9FE1CB', 'icon_bg' => '#0F6E56', 'name' => '#085041', 'btn' => '#0F6E56'],
    ['bg' => '#FAECE7', 'border' => '#F5C4B3', 'icon_bg' => '#993C1D', 'name' => '#712B13', 'btn' => '#993C1D'],
    ['bg' => '#FCEBEB', 'border' => '#F7C1C1', 'icon_bg' => '#A32D2D', 'name' => '#791F1F', 'btn' => '#A32D2D'],
    ['bg' => '#F1EFE8', 'border' => '#D3D1C7', 'icon_bg' => '#5F5E5A', 'name' => '#444441', 'btn' => '#5F5E5A'],
    ['bg' => '#E6F1FB', 'border' => '#85B7EB', 'icon_bg' => '#378ADD', 'name' => '#185FA5', 'btn' => '#378ADD'],
];
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <div class="container">

        <!-- Hero -->
        <div class="pd-hero__inner">
            <div class="pd-hero__badge">
               
            </div>
            <h2 class="pd-hero__title">
                <?php echo esc_html($page_heading); ?>
            </h2>
            <?php if ($page_subheading) : ?>
                <p class="pd-hero__sub"><?php echo esc_html($page_subheading); ?></p>
            <?php endif; ?>
        </div>

        <!-- Grid -->
        <?php if ($portals) : ?>
            <div class="pd-grid mt-4">
                <?php foreach ($portals as $i => $item) :
                    $c    = $colors[$i % count($colors)];
                    $name = esc_html($item['portal_name']);
                    $url  = esc_url($item['portal_link']);
                ?>
                    <div class="pd-card" style="background:<?php echo $c['bg']; ?>; border-color:<?php echo $c['border']; ?>;">

                        <div class="pd-card__icon" style="background:<?php echo $c['icon_bg']; ?>;">
                            <i class="ti ti-world"></i>
                        </div>

                        <p class="pd-card__name" style="color:<?php echo $c['name']; ?>;">
                            <?php echo $name; ?>
                        </p>

                        <a href="<?php echo $url; ?>" class="pd-card__btn" style="background:<?php echo $c['btn']; ?>;">
                            View More
                        </a>

                    </div>
                <?php endforeach; ?>
            </div>

        <?php else : ?>
            <p class="pd-empty">No items found. Please add entries via ACF.</p>
        <?php endif; ?>

    </div>
</section>



<style>
.pd-hero__title {
    font-size: 32px;
    font-weight: 700;
    color: #fff;
    letter-spacing: -0.5px;
    margin-bottom: 0.4rem;
}
.pd-hero__sub {
    font-size: 15px;
    color: rgba(255,255,255,0.72);
}
.pd-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
}
.pd-card {
    border-radius: 14px;
    border: 1px solid transparent;
    padding: 1.5rem 1rem 1.2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    text-align: center;
    transition: transform 0.18s, box-shadow 0.18s;
}
.pd-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.10);
}
.pd-card__icon {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pd-card__icon i {
    font-size: 24px;
    color: #fff;
}
.pd-card__name {
    font-size: 13px;
    font-weight: 600;
    line-height: 1.4;
    min-height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pd-card__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 7px 0;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    color: #fff;
    text-decoration: none;
    transition: opacity 0.15s;
}
.pd-card__btn:hover {
    opacity: 0.85;
    text-decoration: none;
    color: #fff;
}
.pd-empty {
    text-align: center;
    color: #999;
    font-size: 14px;
    padding: 3rem 0;
}
@media (max-width: 1100px) {
    .pd-grid { grid-template-columns: repeat(4, 1fr); }
}
@media (max-width: 820px) {
    .pd-grid { grid-template-columns: repeat(3, 1fr); }
    .pd-hero__title { font-size: 26px; }
}
@media (max-width: 560px) {
    .pd-grid { grid-template-columns: repeat(2, 1fr); }
    .pd-hero__title { font-size: 22px; }
}
</style>
<?php get_footer(); ?>