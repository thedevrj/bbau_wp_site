<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package BBAU_Theme
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<div class="error-404-hero">
				<div class="row">
					<div class="col-lg-6">
						<div class="text-center illustration-wrapper">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/404-illustration.png' ); ?>" alt="<?php esc_attr_e( '404 - Page Not Found', 'bbau-theme' ); ?>" class="error-404-illustration">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="content-wrapper">
							<h1 class="page-title"><?php esc_html_e( '404 - Page Not Found', 'bbau-theme' ); ?></h1>
							<p class="page-subtitle"><?php esc_html_e( ' The page you are looking for does not exist in our current records.', 'bbau-theme' ); ?></p>
						</div>
					</div>
				</div>
			</div>

			<div class="page-content">
				<div class="search-wrapper">
					<?php get_search_form(); ?>
				</div>

				<div class="error-404-suggestions">
					<h2><?php esc_html_e( 'Explore Other Pathways', 'bbau-theme' ); ?></h2>
					<div class="suggestion-grid">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="suggestion-card">
							<span class="dashicons dashicons-admin-home"></span>
							<span><?php esc_html_e( 'Home Page', 'bbau-theme' ); ?></span>
						</a>
						<a href="<?php echo esc_url( home_url( '/admissions' ) ); ?>" class="suggestion-card">
							<span class="dashicons dashicons-welcome-learn-more"></span>
							<span><?php esc_html_e( 'Admissions', 'bbau-theme' ); ?></span>
						</a>
						<a href="<?php echo esc_url( home_url( '/faculty' ) ); ?>" class="suggestion-card">
							<span class="dashicons dashicons-businessman"></span>
							<span><?php esc_html_e( 'Faculty Profiles', 'bbau-theme' ); ?></span>
						</a>
						<a href="<?php echo esc_url( home_url( '/research' ) ); ?>" class="suggestion-card">
							<span class="dashicons dashicons-search"></span>
							<span><?php esc_html_e( 'Research', 'bbau-theme' ); ?></span>
						</a>
					</div>
				</div>
			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();