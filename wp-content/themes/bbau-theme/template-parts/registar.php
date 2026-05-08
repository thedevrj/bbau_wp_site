<?php 
/*
Template Name: Registrar Template
*/

defined('ABSPATH') || exit;
get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid page-bg page-template-about-bg py-lg-5">

<?php get_template_part('template-parts/breadcrumb'); ?>

<!-- ================= REGISTRAR ================= -->

<section class="registrar-modern-style">
<div class="container">
<div class="row justify-content-center">
<div class="col-xl-10 col-lg-11">

<div class="registrar-card">

<!-- IMAGE -->
<div class="registrar-right">
<?php 
$img = get_field('registrar_image');
if( $img && isset($img['url']) ): ?>
<img src="<?php echo esc_url($img['url']); ?>" alt="Registrar Image">
<?php endif; ?>
</div>

<!-- CONTENT -->
<div class="registrar-left">

<h3><?php echo esc_html(get_field('registrar_name')); ?></h3>

<p class="vc-designation">
<?php echo esc_html(get_field('designation')); ?>
</p>

<!-- CONTACT -->
<div class="vc-contact">

<?php if( get_field('email') ): ?>
<p>
<i class="fa fa-envelope"></i>
<a href="mailto:<?php echo esc_attr(get_field('email')); ?>">
<?php echo esc_html(get_field('email')); ?>
</a>
</p>
<?php endif; ?>

<?php if( get_field('phone') ): ?>
<p>
<i class="fa fa-phone"></i>
<a href="tel:<?php echo esc_attr(get_field('phone')); ?>">
<?php echo esc_html(get_field('phone')); ?>
</a>
</p>
<?php endif; ?>

</div>

<!-- BUTTONS -->
<div class="registrar-buttons">

<?php 
$profile = get_field('profile_link');
if( $profile && isset($profile['url']) ): ?>
<a href="<?php echo esc_url($profile['url']); ?>" class="reg-btn" target="_blank">
Profile
</a>
<?php endif; ?>

<?php 
$pdf = get_field('tenure_pdf');
if( $pdf && isset($pdf['url']) ): ?>
<a href="<?php echo esc_url($pdf['url']); ?>" class="reg-btn" target="_blank">
Tenure of Registrar
</a>
<?php endif; ?>

</div>

<!-- OFFICE -->
<div class="registrar-office">
<strong>Registrar Office:</strong>
<?php echo nl2br(esc_html(get_field('office_details'))); ?>
</div>

</div><!-- /.registrar-left -->
</div><!-- /.registrar-card -->

</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.container -->
</section>

<!-- ================= SECTIONS UNDER REGISTRAR ================= -->

<div class="container">

<h2 class="rg-sec-title">Sections Under Registrar</h2>
<div class="rg-sec-bar"></div>

<div class="rg-grid">

<?php if( have_rows('registrar_sections') ): ?>
<?php while( have_rows('registrar_sections') ): the_row(); ?>

<div class="rg-card">

<div class="rg-stripe"></div>

<div class="rg-card-inner">

<div class="rg-dept-row">
<div class="rg-dept-icon">
<svg viewBox="0 0 24 24" fill="none" stroke="#3730a3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18">
<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
<polyline points="9 22 9 12 15 12 15 22"/>
</svg>
</div>
<h3 class="rg-dept-name"><?php echo esc_html(get_sub_field('section_title')); ?></h3>
</div>

<div class="rg-divider"></div>

<div class="rg-desc">
<?php echo wp_kses_post(get_sub_field('section_description')); ?>
</div>

<?php 
$link = get_sub_field('section_link');
if( $link && isset($link['url']) ): ?>
<a href="<?php echo esc_url($link['url']); ?>" class="rg-visit-btn" target="_blank">
Visit page
<svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="12" height="12">
<path d="M5 12h14M12 5l7 7-7 7"/>
</svg>
</a>
<?php endif; ?>

</div><!-- /.rg-card-inner -->
</div><!-- /.rg-card -->

<?php endwhile; ?>
<?php endif; ?>

</div><!-- /.rg-grid -->
</div><!-- /.container -->

</div><!-- /.container-fluid -->

<?php get_footer(); ?>