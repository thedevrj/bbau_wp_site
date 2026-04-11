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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <?php wp_head(); ?>

    <style>
    /* Google Translate toolbar suppression */
    iframe.skiptranslate,
    .goog-te-banner-frame {
        display: none !important;
        visibility: hidden !important;
    }

    body {
        top: 0 !important;
    }

    #goog-gt-tt,
    .goog-te-balloon-frame,
    .goog-tooltip {
        display: none !important;
    }
    </style>

    <!-- <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    onload="this.onload = null;this.rel = 'stylesheet'" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> -->
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div class="top-bar">
        <div class="container-fluid d-flex justify-content-between align-items-center">

            <!-- LEFT LINKS -->
            <div class="top-left d-flex gap-3 flex-wrap">
                <?php
               wp_nav_menu(array(
                   'theme_location' => 'announcement_bar',
                   'menu_class'     => 'top-left d-flex flex-wrap list-unstyled hide-list',
                   'container'      => false,
                   'link_before'    => '',
                   'link_after'     => '',
                   'fallback_cb'    => false,
                   'depth'          => 1,
               ));
               ?>
            </div>
            <div class="top-right">
                <button class="font-btn font-big" onclick="setFontSize('big')"><span>A+</span></button>
                <button class="font-btn font-normal" onclick="setFontSize('normal')"><span>A</span></button>
                <button class="font-btn font-small" onclick="setFontSize('small')"><span>A-</span></button>


                <!-- Google Translate (hidden widget, toggled by icon) -->
                <div id="google_translate_element" style="display:none;"></div>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header/language.png"
                    alt="Translate to Hindi" class="lang-img" id="translate-toggle" title="Click to translate">

                <div class="search-box">
                    <input type="text" id="global-search-input" placeholder="Search" aria-label="Search">
                    <span class="search-icon" style="cursor:pointer;" onclick="triggerGlobalSearch()"><i
                            class="fa-solid fa-magnifying-glass"></i></span>
                </div>
            </div>

        </div>
    </div>
    <header class="main-header">

        <div class="container-fluid d-flex align-items-center justify-content-between position-relative">

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
        
        <script>
        // Search
        function triggerGlobalSearch() {
            const query = document.getElementById('global-search-input').value.trim();
            if (query) {
                window.location.href = '<?php echo home_url('/'); ?>?s=' + encodeURIComponent(query);
            }
        }
        document.getElementById('global-search-input')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') triggerGlobalSearch();
        });

        // Font size / zoom controls
        const ZOOM_LEVELS = {
            big: '1.15',
            normal: '1',
            small: '0.85'
        };

        function setFontSize(size) {
            document.body.style.zoom = ZOOM_LEVELS[size];
            localStorage.setItem('bbau_font_size', size);
            document.querySelectorAll('.font-btn').forEach(b => b.classList.remove('active'));
            const map = {
                big: '.font-big',
                normal: '.font-normal',
                small: '.font-small'
            };
            document.querySelector(map[size])?.classList.add('active');
        }
        // Restore saved zoom on load
        (function() {
            const saved = localStorage.getItem('bbau_font_size') || 'normal';
            setFontSize(saved);
        })();

        // Skip to main content — smooth scroll
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll(
                'a[href$="#primary"], a[href$="#main-content"], a[href$="#content"]').forEach(
                function(link) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const id = link.hash.replace('#', '');
                        const target = document.getElementById(id);
                        if (target) {
                            target.setAttribute('tabindex', '-1');
                            target.focus({
                                preventScroll: true
                            });
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });

            // — Language toggle (Hindi ↔ English) lazy-loaded —
            let translateLoaded = false;
            let isHindi = false;

            // MutationObserver: kill the Google toolbar the moment it appears
            function suppressGoogleBar() {
                document.querySelectorAll('iframe.skiptranslate, .goog-te-banner-frame').forEach(
                    function(el) {
                        el.style.setProperty('display', 'none', 'important');
                        el.style.setProperty('visibility', 'hidden', 'important');
                    });
                document.body.style.setProperty('top', '0', 'important');
            }
            const observer = new MutationObserver(function(mutations) {
                suppressGoogleBar();
            });
            observer.observe(document.documentElement, {
                childList: true,
                subtree: true,
                attributes: true,
                attributeFilter: ['style', 'class']
            });

            function doTranslate(lang) {
                const select = document.querySelector('.goog-te-combo');
                if (select) {
                    select.value = lang;
                    select.dispatchEvent(new Event('change'));
                }
            }

            function loadTranslateAndRun(lang) {
                if (translateLoaded) {
                    doTranslate(lang);
                    return;
                }
                // Define the callback before loading the script
                window.googleTranslateElementInit = function() {
                    new google.translate.TranslateElement({
                        pageLanguage: 'en',
                        includedLanguages: 'hi,en',
                        autoDisplay: false
                    }, 'google_translate_element');
                    translateLoaded = true;
                    // Wait briefly for widget to render then trigger
                    setTimeout(function() {
                        doTranslate(lang);
                    }, 500);
                };
                const s = document.createElement('script');
                s.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
                s.async = true;
                document.head.appendChild(s);
            }

            const toggleBtn = document.getElementById('translate-toggle');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    if (!isHindi) {
                        isHindi = true;
                        toggleBtn.title = 'Click to restore English';
                        loadTranslateAndRun('hi');
                    } else {
                        isHindi = false;
                        toggleBtn.title = 'Click to translate to Hindi';
                        doTranslate('en');
                    }
                });
            }
        });
        </script>
    </header>