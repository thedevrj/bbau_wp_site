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

        <div class="pd-hero__inner">
            <h2 class="pd-hero__title">
                <?php echo esc_html($page_heading); ?>
            </h2>
            <?php if ($page_subheading) : ?>
                <p class="pd-hero__sub"><?php echo esc_html($page_subheading); ?></p>
            <?php endif; ?>
        </div>

        <?php if ($portals) : ?>
            <div class="pd-grid mt-4">
                <?php foreach ($portals as $i => $item) :
                    $c    = $colors[$i % count($colors)];
                    $name = esc_html($item['portal_name']);
                    $url  = esc_url($item['portal_link']);
                ?>
                    <div class="pd-card" style="background:<?php echo $c['bg']; ?> !important; border-color:<?php echo $c['border']; ?> !important;">

                        <div class="pd-card__icon" style="background:<?php echo $c['icon_bg']; ?> !important;">
                            <i class="ti ti-world"></i>
                        </div>

                        <p class="pd-card__name" style="color:<?php echo $c['name']; ?> !important;">
                            <?php echo $name; ?>
                        </p>

                        <a href="<?php echo $url; ?>"
                           class="pd-card__btn"
                           style="background:<?php echo $c['btn']; ?> !important; color:#fff !important;">
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
    font-size: 28px !important;
    font-weight: 700 !important;
    color: #1a1a1a !important;
    letter-spacing: -0.5px;
    margin-bottom: 0.4rem;
}
.pd-hero__sub {
    font-size: 15px !important;
    color: #666 !important;
}
.pd-grid {
    display: grid !important;
    grid-template-columns: repeat(5, 1fr) !important;
    gap: 16px !important;
}
.pd-card {
    border-radius: 14px !important;
    border: 1px solid transparent !important;
    padding: 1.5rem 1rem 1.2rem !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 10px !important;
    text-align: center !important;
    transition: transform 0.18s, box-shadow 0.18s !important;
    height: 100% !important;
}
.pd-card:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 8px 24px rgba(0,0,0,0.10) !important;
}
.pd-card__icon {
    width: 52px !important;
    height: 52px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
}
.pd-card__icon i {
    font-size: 24px !important;
    color: #fff !important;
}
.pd-card__name {
    font-size: 13px !important;
    font-weight: 600 !important;
    line-height: 1.4 !important;
    flex: 1 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    margin: 0 !important;
    width: 100% !important;
}

/* Button — all states locked */
.pd-card__btn,
.pd-card__btn:link,
.pd-card__btn:visited,
.pd-card__btn:hover,
.pd-card__btn:focus,
.pd-card__btn:active {
    color: #fff !important;
    text-decoration: none !important;
}
.pd-card__btn {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
    padding: 7px 0 !important;
    border-radius: 8px !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    border: none !important;
    outline: none !important;
    flex-shrink: 0 !important;
    margin-top: auto !important;
    opacity: 1 !important;
    transition: opacity 0.15s !important;
}
.pd-card__btn:hover,
.pd-card__btn:focus,
.pd-card__btn:active {
    opacity: 0.85 !important;
}

.pd-empty {
    text-align: center !important;
    color: #999 !important;
    font-size: 14px !important;
    padding: 3rem 0 !important;
}

@media (max-width: 1100px) {
    .pd-grid { grid-template-columns: repeat(4, 1fr) !important; }
}
@media (max-width: 820px) {
    .pd-grid { grid-template-columns: repeat(3, 1fr) !important; }
    .pd-hero__title { font-size: 22px !important; }
}
@media (max-width: 560px) {
    .pd-grid { grid-template-columns: repeat(2, 1fr) !important; }
    .pd-hero__title { font-size: 18px !important; }
}
</style>

<?php get_footer(); ?>