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

    <!-- MOBILE DRAWER -->
    <div class="mobile-drawer-overlay" id="drawer-overlay"></div>
    <div class="mobile-drawer" id="mobile-drawer">
        <div class="drawer-header">
            <!-- <div class="drawer-logo">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header/ambedkar.png"
                alt="Dr. B. R. Ambedkar">
            </div> -->
            <button class="drawer-close" id="mobile-drawer-close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="drawer-content">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary_mobile_menu',
                'container'      => 'nav',
                'container_class'=> 'mobile-nav',
                'menu_class'     => 'mobile-menu-inner',
                'fallback_cb'    => false,
                'depth'          => 3,
            ]);
            ?>
        </div>
    </div>
    <div class="top-bar">
        <!-- DESKTOP TOP BAR -->
        <div class="container-fluid d-none d-mg-flex justify-content-between align-items-center">
            <!-- LEFT LINKS -->
            <div class="top-left d-flex gap-3 flex-wrap">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'announcement_bar',
                    'menu_class'     => 'top-left d-flex flex-wrap list-unstyled hide-list',
                    'container'      => false,
                    'depth'          => 1,
                    'fallback_cb'    => false,
                ));
                ?>
            </div>
            <div class="top-right">
                <button class="font-btn font-big" onclick="setFontSize('big')"><span>A+</span></button>
                <button class="font-btn font-normal" onclick="setFontSize('normal')"><span>A</span></button>
                <button class="font-btn font-small" onclick="setFontSize('small')"><span>A-</span></button>

                <div id="google_translate_element" style="display:none;"></div>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header/language.png" alt="Translate"
                    class="lang-img" id="translate-toggle" title="Click to translate">

                <div class="search-box">
                    <input type="text" id="global-search-input" placeholder="Search" aria-label="Search">
                    <span class="search-icon" style="cursor:pointer;" onclick="triggerGlobalSearch()"><i
                            class="fa-solid fa-magnifying-glass"></i></span>
                </div>
            </div>
        </div>

        <!-- MOBILE TOP BAR: 2 rows - links row then controls row -->
        <div class="d-flex d-lg-none flex-column top-bar-mobile">
            <!-- ROW 1: Nav links - horizontally scrollable -->
            <div class="tb-mobile-links">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'announcement_bar_mobile',
                    'menu_class'     => 'tb-links-inner ',
                    'container'      => false,
                    'depth'          => 1,
                    'fallback_cb'    => false,
                ));
                ?>
                <!-- ROW 2: Font + Language + Search -->
                <div class="tb-mobile-controls d-flex align-items-center justify-content-between px-3 py-1">
                    <div class="tb-mobile-font d-flex gap-2 align-items-center">
                        <button class="font-btn-mobile" onclick="setFontSize('big')">A+</button>
                        <button class="font-btn-mobile" onclick="setFontSize('normal')">A</button>
                        <button class="font-btn-mobile" onclick="setFontSize('small')">A-</button>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header/language.png"
                            alt="Translate" id="translate-toggle-mobile"
                            style="height:18px; cursor:pointer; margin-left:4px;">
                    </div>
                    <div class="search-box-mobile">
                        <input type="text" id="global-search-input-mobile" placeholder="Search..." aria-label="Search">
                        <i class="fa-solid fa-magnifying-glass" onclick="triggerGlobalSearchMobile()"></i>
                    </div>
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

            <!-- MOBILE TOGGLE -->
            <div class="header-mobile-icons d-flex d-lg-none gap-2">
                <button class="mobile-toggle-btn" id="mobile-drawer-open" aria-label="Open Menu">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
            </div>

        </div>

        <script>
        function triggerGlobalSearch() {
            const query = document.getElementById('global-search-input').value.trim();
            if (query) {
                window.location.href = '<?php echo home_url('/'); ?>?s=' + encodeURIComponent(query);
            }
        }

        function triggerGlobalSearchMobile() {
            const query = document.getElementById('global-search-input-mobile').value.trim();
            if (query) {
                window.location.href = '<?php echo home_url('/'); ?>?s=' + encodeURIComponent(query);
            }
        }
        document.getElementById('global-search-input')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') triggerGlobalSearch();
        });
        document.getElementById('global-search-input-mobile')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') triggerGlobalSearchMobile();
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
            const toggleBtnMobile = document.getElementById('translate-toggle-mobile');

            function handleTranslateClick() {
                if (!isHindi) {
                    isHindi = true;
                    if (toggleBtn) toggleBtn.title = 'Click to restore English';
                    loadTranslateAndRun('hi');
                } else {
                    isHindi = false;
                    if (toggleBtn) toggleBtn.title = 'Click to translate to Hindi';
                    doTranslate('en');
                }
            }

            toggleBtn?.addEventListener('click', handleTranslateClick);
            toggleBtnMobile?.addEventListener('click', handleTranslateClick);

            // --- Mobile Drawer Implementation ---
            const drawer = document.getElementById('mobile-drawer');
            const overlay = document.getElementById('drawer-overlay');
            const openBtn = document.getElementById('mobile-drawer-open');
            const closeBtn = document.getElementById('mobile-drawer-close');

            function toggleDrawer(open) {
                if (open) {
                    drawer.classList.add('active');
                    overlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                } else {
                    drawer.classList.remove('active');
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            openBtn?.addEventListener('click', () => toggleDrawer(true));
            closeBtn?.addEventListener('click', () => toggleDrawer(false));
            overlay?.addEventListener('click', () => toggleDrawer(false));

            // --- Mobile Accordion Implementation (Exclusive) ---
            const mobileMenuItems = document.querySelectorAll('.mobile-nav .menu-item-has-children > a');
            mobileMenuItems.forEach(item => {
                const arrow = document.createElement('span');
                arrow.className = 'mobile-arrow';
                arrow.innerHTML = '<i class="fa-solid fa-chevron-down"></i>';
                item.appendChild(arrow);

                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const parent = this.parentElement;
                    const isOpen = parent.classList.contains('active');

                    // EXCLUSIVE LOGIC: Close all other siblings
                    const siblings = parent.parentElement.children;
                    for (let sibling of siblings) {
                        if (sibling !== parent) {
                            sibling.classList.remove('active');
                        }
                    }

                    if (isOpen) {
                        parent.classList.remove('active');
                    } else {
                        parent.classList.add('active');
                    }
                });
            });
            // --- Submenu overflow detection (flip 3rd-level to left when near right edge) ---
            // NOTE: sub-menu is display:none on mouseenter so getBoundingClientRect() = {0,0,0,0}
            // We use the PARENT li's right edge + expected sub-menu width to predict overflow.
            document.querySelectorAll('.main-menu .sub-menu > li').forEach(function(li) {
                li.addEventListener('mouseenter', function() {
                    const sub = this.querySelector(':scope > .sub-menu');
                    if (!sub) return;
                    const parentRect = this.getBoundingClientRect();
                    const estimatedWidth = 240; // conservative estimate for sub-menu width
                    const wouldOverflow = (parentRect.right + estimatedWidth) > (window
                        .innerWidth - 10);
                    if (wouldOverflow) {
                        sub.style.left = 'auto';
                        sub.style.right = '100%';
                        sub.style.marginLeft = '0';
                        sub.style.marginRight = '4px';
                    } else {
                        sub.style.left = '';
                        sub.style.right = '';
                        sub.style.marginLeft = '';
                        sub.style.marginRight = '';
                    }
                });
            });

            // --- Close drawer with ESC key ---
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') toggleDrawer(false);
            });
        });
        </script>
    </header>