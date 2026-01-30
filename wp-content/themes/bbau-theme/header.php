<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BBAU_Theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicon/favicon-16x16.png">
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicon/android-chrome-192x192.png">
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicon/android-chrome-512x512.png">
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri().'/assets/img/favicon/apple-touch-icon.png'; ?>">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>

    <!-- <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    onload="this.onload = null;this.rel = 'stylesheet'" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> -->
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
        <div class="top-bar">
            <div class="container-xxl d-flex justify-content-between align-items-center">

                <!-- LEFT LINKS -->
                <div class="top-left d-flex gap-3 flex-wrap">
                    <?php
               wp_nav_menu(array(
                   'theme_location' => 'announcement_bar',
                   'menu_class'     => 'top-left d-flex flex-wrap p-0 m-0 list-unstyled hide-list',
                   'container'      => false,
                   'link_before'    => '',
                   'link_after'     => '',
                   'fallback_cb'    => false,
                   'depth'          => 1,
               ));
               ?>
                </div>
                <div class="top-right">
                    <span class="font-big">A+</span>
                    <span class="font-medium">A</span>
                    <span class="font-small">A-</span>

                    <img src="/wp-content/uploads/2026/01/H-E-converter.png" alt="Language Toggle" class="lang-img">

                    <div class="search-box">
                        <input type="text" placeholder="Search" aria-label="Search">
                        <span class="search-icon">🔍</span>
                    </div>
                </div>

            </div>
        </div>
        <header class="main-header">

            <div class="container-xxl d-flex align-items-center justify-content-between position-relative">

                <!-- LEFT BRAND -->
                <div class="d-flex align-items-center">

                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header/bbau_logo.png"
                        class="logo me-2" alt="University Logo">

                    <div class="univ-name">
                        <div class="univ-hindi">
                            बाबासाहेब भीमराव अम्बेडकर विश्वविद्यालय
                        </div>

                        <div class="univ-english">
                            BABASAHEB BHIMRAO AMBEDKAR UNIVERSITY
                        </div>

                        <div class="univ-subtitle">
                            (A CENTRAL UNIVERSITY)
                        </div>
                    </div>
                </div>

                <!-- NAVIGATION (DESKTOP) -->
                <nav class="header-nav d-none d-lg-flex">
                    <ul class="menu">
                        <li>
                            <a href="/" class="nav-home" aria-label="Home">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header/home.jpg"
                                    alt="Home">
                            </a>
                        </li>
                        <!-- ABOUT (MEGA MENU) -->

                    </ul>
                    <?php
					wp_nav_menu([
						'theme_location' => 'primary_menu',
						'container'      => false,
						'menu_class'     => 'main-menu',
						'depth'          => 3,
						'walker'         => new BBAU_Nav_Walker(),
					]);
				?>

                </nav>


                <!-- RIGHT IMAGE -->
                <div class="header-photo d-none d-lg-block">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header/ambedkar.png"
                        alt="Dr. B. R. Ambedkar">
                </div>

            </div>
        </header>