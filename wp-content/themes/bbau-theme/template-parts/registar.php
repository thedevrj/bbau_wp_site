<?php 
/*
Template Name: Registrar Template
*/

defined('ABSPATH') || exit;
get_header();
$reg_img         = get_field('registrar_image');
$reg_name        = get_field('registrar_name');
$reg_designation = get_field('designation');
$reg_email       = get_field('email');
$reg_phone       = get_field('phone');
$reg_profile     = get_field('profile_link');
$reg_pdf         = get_field('tenure_pdf');
$reg_office      = get_field('office_details');
$tel_href    = $reg_phone ? preg_replace('/[^0-9+]/', '', $reg_phone) : '';
$has_profile = $reg_profile && !empty($reg_profile['url']);
$has_pdf     = $reg_pdf && !empty($reg_pdf['url']);
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid page-bg page-template-about-bg page-registrar py-lg-5">

<?php get_template_part('template-parts/breadcrumb'); ?>

<section class="registrar-modern-style">
<div class="container">
<div class="row justify-content-center">
<div class="col-xl-10 col-lg-11">

<div class="registrar-card">

    <!-- Photo -->
    <div class="registrar-right">
    <?php if( $reg_img && !empty($reg_img['url']) ): ?>
        <img src="<?php echo esc_url($reg_img['url']); ?>"
             alt="<?php echo esc_attr( !empty($reg_img['alt']) ? $reg_img['alt'] : $reg_name ); ?>">
    <?php endif; ?>
    </div>

    <!-- Details -->
    <div class="registrar-left">

        <?php if( $reg_name ): ?>
        <h3><?php echo esc_html($reg_name); ?></h3>
        <?php endif; ?>

        <?php if( $reg_designation ): ?>
        <p class="registrar-designation"><?php echo esc_html($reg_designation); ?></p>
        <?php endif; ?>

        <?php if( $reg_email || $reg_phone ): ?>
        <div class="registrar-contact">

            <?php if( $reg_email ): ?>
            <p>
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <a href="mailto:<?php echo esc_attr($reg_email); ?>"><?php echo esc_html($reg_email); ?></a>
            </p>
            <?php endif; ?>

            <?php if( $reg_phone ): ?>
            <p>
                <i class="fa fa-phone" aria-hidden="true"></i>
                <a href="tel:<?php echo esc_attr($tel_href); ?>"><?php echo esc_html($reg_phone); ?></a>
            </p>
            <?php endif; ?>

        </div>
        <?php endif; ?>

        <?php if( $has_profile || $has_pdf ): ?>
        <div class="registrar-buttons">

            <?php if( $has_profile ): ?>
            <a href="<?php echo esc_url($reg_profile['url']); ?>" class="reg-btn" target="_blank" rel="noopener noreferrer">Profile</a>
            <?php endif; ?>

            <?php if( $has_pdf ): ?>
            <a href="<?php echo esc_url($reg_pdf['url']); ?>" class="reg-btn" target="_blank" rel="noopener noreferrer">Tenure of Registrar</a>
            <?php endif; ?>

        </div>
        <?php endif; ?>

        <?php if( $reg_office ): ?>
        <div class="registrar-office">
            <strong>Registrar Office:</strong>
            <?php echo nl2br(esc_html($reg_office)); ?>
        </div>
        <?php endif; ?>

    </div>

</div>

</div>
</div>
</div>
</section>
<?php if( have_rows('registrar_sections') ): ?>
<div class="container">

    <h3 class="rg-sec-title">Sections Under Registrar</h3>
    <div class="rg-sec-bar"></div>

    <div class="rg-grid">

    <?php while( have_rows('registrar_sections') ): the_row();
        $sec_title = get_sub_field('section_title');
        $sec_desc  = get_sub_field('section_description');
        $sec_link  = get_sub_field('section_link');
    ?>

        <div class="rg-card">

            <div class="rg-stripe"></div>

            <div class="rg-card-inner">

                <div class="rg-dept-row">
                    <div class="rg-dept-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20" aria-hidden="true" focusable="false">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                    <h4 class="rg-dept-name"><?php echo esc_html($sec_title); ?></h4>
                </div>

                <div class="rg-divider"></div>

                <div class="rg-desc">
                    <?php echo wp_kses_post($sec_desc); ?>
                </div>

                <?php if( $sec_link && !empty($sec_link['url']) ): ?>
                <a href="<?php echo esc_url($sec_link['url']); ?>" class="rg-visit-btn" target="_blank" rel="noopener noreferrer">
                    Visit page
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="12" height="12" aria-hidden="true" focusable="false">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <?php endif; ?>

            </div>
        </div>

    <?php endwhile; ?>

    </div>
</div>
<?php endif; ?>

</div>

<?php get_footer(); ?>