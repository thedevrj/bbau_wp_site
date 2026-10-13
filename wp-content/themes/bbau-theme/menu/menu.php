<?php
if (!defined('ABSPATH')) {
    exit;
}
$current_group = '';
$page_menu_group = get_field('menu_group');
if (is_string($page_menu_group) && trim($page_menu_group) !== '') {
    $current_group = sanitize_text_field(trim($page_menu_group));
} elseif (isset($_GET['menu']) && is_string($_GET['menu'])) {
    $current_group = sanitize_text_field(
        wp_unslash($_GET['menu'])
    );
}
if ($current_group === '') {
    return;
}
$all_menus = get_field('sidebar_menus', 'option');
if (!is_array($all_menus) || empty($all_menus)) {
    return;
}
$menu_items = [];
foreach ($all_menus as $menu) {
    if (empty($menu['menu_group'])) {
        continue;
    }
    if (
        strtolower(trim((string) $menu['menu_group'])) ===
        strtolower(trim($current_group))
    ) {
        $menu_items = $menu['menu_items'] ?? [];
        break;
    }
}
if (!is_array($menu_items) || empty($menu_items)) {
    return;
}
if (!function_exists('bbau_menu_resolve_url')) {
    function bbau_menu_resolve_url($value) {
        if (empty($value)) {
            return '';
        }

        // ACF Link field or ACF File field array.
        if (is_array($value)) {
            if (!empty($value['url']) && is_string($value['url'])) {
                return esc_url_raw($value['url']);
            }
            $id = $value['ID'] ?? $value['id'] ?? 0;
            if (is_numeric($id)) {
                return bbau_menu_resolve_url((int) $id);
            }
            return '';
        }

        // ACF Post Object or WordPress post object.
        if ($value instanceof WP_Post) {
            $id = (int) $value->ID;
            if ($value->post_type === 'attachment') {
                $attachment_url = wp_get_attachment_url($id);
                if ($attachment_url) {
                    return $attachment_url;
                }
            }
            return get_permalink($id) ?: '';
        }

        // ACF Post Object field returning an ID.
        if (is_numeric($value)) {
            $id = (int) $value;
            if (get_post_type($id) === 'attachment') {
                $attachment_url = wp_get_attachment_url($id);
                if ($attachment_url) {
                    return $attachment_url;
                }
            }
            return get_permalink($id) ?: '';
        }

        // Direct URL string.
        if (is_string($value)) {
            return esc_url_raw(trim($value));
        }
        return '';
    }
}
$menu_urls = [];
foreach ($menu_items as $mi) {
    $page_link = $mi['menu_page'] ?? null;
    $url = bbau_menu_resolve_url($page_link);
    if ($url !== '') {
        $menu_urls[] = $url;
    }
}
$menu_urls_json = wp_json_encode(
    array_values(array_unique($menu_urls)),
    JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
);
if (!$menu_urls_json) {
    $menu_urls_json = '[]';
}
$current_permalink = get_permalink(get_queried_object_id());
$current_url = $current_permalink
    ? untrailingslashit($current_permalink)
    : '';
?>
<div class="common-menu">
    <div class="menu-fade-left"></div>
    <button class="menu-scroll-btn menu-scroll-left" aria-label="Scroll left" type="button">‹</button>
    <nav class="common-menu-nav">
        <?php foreach ($menu_items as $item) : ?>
        <?php
            $page_link = $item['menu_page'] ?? null;
            $custom_label = $item['menu_label'] ?? '';
            if (empty($page_link)) {
                continue;
            }
            $url = bbau_menu_resolve_url($page_link);
            if ($url === '') {
                continue;
            }
            if (is_string($custom_label) && trim($custom_label) !== '') {
                $title = trim($custom_label);
            } elseif ($page_link instanceof WP_Post) {
                $title = $page_link->post_title;
            } elseif (is_array($page_link)) {
                $title = $page_link['title']
                    ?? $page_link['filename']
                    ?? 'Menu Item';
            } elseif (is_numeric($page_link)) {
                $title = get_the_title((int) $page_link) ?: 'Menu Item';
            } else {
                $title = 'Menu Item';
            }
            $link_target = '_self';
            if (is_array($page_link) && !empty($page_link['target'])) {
                $link_target = $page_link['target'] === '_blank'
                    ? '_blank'
                    : '_self';
            }
            $path = wp_parse_url($url, PHP_URL_PATH);
            $is_pdf = is_string($path)
                && strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf';

            /*
             * For PDFs and external links, preserve the URL.
             * For internal pages, add the menu group query parameter.
             */
            $host = wp_parse_url($url, PHP_URL_HOST);
            $site_host = wp_parse_url(home_url('/'), PHP_URL_HOST);
            $is_external = $host
                && $site_host
                && strtolower($host) !== strtolower($site_host);
            if ($is_pdf || $is_external) {
                $final_url = $url;
            } else {
                $final_url = add_query_arg('menu', $current_group, $url);
            }
            if ($is_pdf) {
                $link_target = '_blank';
            }

            /*
             * Determine active state for normal pages.
             */
            $item_url = untrailingslashit($url);
            $active = (
                !$is_pdf
                && !$is_external
                && $current_url !== ''
                && $current_url === $item_url
            ) ? 'active' : '';
            ?>
        <a class="common-menu-link <?php echo esc_attr($active); ?>" href="<?php echo esc_url($final_url); ?>"
            data-menu="<?php echo esc_attr($current_group); ?>" data-pages="<?php echo esc_attr($menu_urls_json); ?>"
            target="<?php echo esc_attr($link_target); ?>" <?php if ($link_target === '_blank') : ?>
            rel="noopener noreferrer" <?php endif; ?>>
            <span class="dot"></span>
            <?php echo esc_html($title); ?>
        </a>
        <?php endforeach; ?>
    </nav>
    <button class="menu-scroll-btn menu-scroll-right" aria-label="Scroll right" type="button">›</button>
    <div class="menu-fade-right"></div>
</div>
<style>
/* ================= MENU ================= */
.common-menu {
    display: block;
    max-width: 100%;
    width: auto;
    background: transparent;
    border-radius: 12px;
    margin: 20px auto 40px;
    overflow: hidden;
    position: relative;
}

/* ================= ARROW BUTTONS ================= */
.menu-scroll-btn {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 32px;
    z-index: 10;
    border: none;
    cursor: pointer;
    background: #4a0d0d;
    color: #fff;
    font-size: 22px;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity .25s ease, background .2s ease;
    opacity: 0;
    pointer-events: none;
}

.menu-scroll-btn.show {
    opacity: 1;
    pointer-events: all;
}

.menu-scroll-btn:hover {
    background: #3a0808;
}

.menu-scroll-left {
    left: 0;
    border-radius: 12px 0 0 12px;
}

.menu-scroll-right {
    right: 0;
    border-radius: 0 12px 12px 0;
}

/* ================= FADE EDGES ================= */
.menu-fade-left,
.menu-fade-right {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 30px;
    pointer-events: none;
    z-index: 9;
    opacity: 0;
    transition: opacity .3s ease;
}

.menu-fade-left {
    left: 32px;
    background: linear-gradient(to right, #5c1010, transparent);
}

.menu-fade-right {
    right: 32px;
    background: linear-gradient(to left, #5c1010, transparent);
}

.menu-fade-left.show,
.menu-fade-right.show {
    opacity: 1;
}

/* ================= NAV ================= */
.common-menu-nav {
    display: flex;
    flex-wrap: nowrap;
    align-items: stretch;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    scroll-behavior: smooth;
    cursor: grab;
    scrollbar-width: none;
    width: 100%;
    background: #5c1010;
    border-radius: 12px;
}

.common-menu-nav::-webkit-scrollbar {
    display: none;
}

.common-menu-nav.is-dragging {
    cursor: grabbing;
    scroll-behavior: auto;
    user-select: none;
}

.common-menu-nav.is-fit {
    width: fit-content;
    margin: 0 auto;
}

.common-menu-nav.is-fit .common-menu-link {
    flex: 0 0 auto;
    min-width: 0;
}

.common-menu-nav:not(.is-fit) .common-menu-link {
    flex: 0 0 auto;
    min-width: 110px;
}

/* ================= LINKS ================= */
.common-menu-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: 700;
    text-align: center;
    white-space: nowrap;
    color: #e1ebf0 !important;
    text-decoration: none;
    border-right: 1px solid rgba(255, 255, 255, .2);
    position: relative;
    transition: all .25s ease;
}

.common-menu-link:last-child {
    border-right: none;
}

/* ================= DOT ================= */
.common-menu-link .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #efbe1d;
    transition: all .25s ease;
}

/* ================= UNDERLINE ================= */
.common-menu-link::after {
    content: '';
    position: absolute;
    left: 10%;
    right: 10%;
    bottom: 0;
    height: 3px;
    background: linear-gradient(90deg, #1a2e3b, #2196a6);
    transform: scaleX(0);
    transform-origin: center;
    transition: transform .3s ease;
}

/* ================= HOVER ================= */
.common-menu-link:hover {
    background: #f5fafc;
    color: #441608 !important;
}

.common-menu-link:hover .dot {
    background: #541c10 !important;
}

.common-menu-link:hover::after {
    transform: scaleX(1);
}

/* ================= ACTIVE ================= */
.common-menu-link.active {
    background: #eef6fa;
    color: #5a170f !important;
    font-weight: 600;
}

.common-menu-link.active .dot {
    background: #5e1212 !important;
}

.common-menu-link.active::after {
    transform: scaleX(1);
}

/* ================= LARGE DESKTOP ================= */
@media (min-width: 1200px) {
    .common-menu-nav:not(.is-fit) .common-menu-link {
        min-width: 130px;
    }
}

/* ================= TABLET ================= */
@media (max-width: 992px) {
    .common-menu-nav:not(.is-fit) .common-menu-link {
        min-width: 110px;
        padding: 12px 16px;
        font-size: 12px;
    }
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {
    .common-menu-nav:not(.is-fit) .common-menu-link {
        min-width: 100px;
        padding: 12px 14px;
        font-size: 12px;
    }
}

/* ================= SMALL MOBILE ================= */
@media (max-width: 480px) {
    .common-menu-nav:not(.is-fit) .common-menu-link {
        min-width: 85px;
        font-size: 11px;
        padding: 10px 12px;
    }

    .common-menu-nav:not(.is-fit) .common-menu-link .dot {
        width: 5px;
        height: 5px;
    }
}

/* ================= HOVER GLOW ================= */
.common-menu-nav:hover {
    box-shadow:
        0 8px 25px rgba(26, 46, 59, .12),
        0 0 10px rgba(33, 150, 166, .2);
}
</style>
<script>
(function() {
    'use strict';

    function initializeCommonMenu(menu) {
        if (!menu || menu.dataset.menuInitialized === 'true') {
            return;
        }
        menu.dataset.menuInitialized = 'true';
        var nav = menu.querySelector('.common-menu-nav');
        var btnL = menu.querySelector('.menu-scroll-left');
        var btnR = menu.querySelector('.menu-scroll-right');
        var fadeL = menu.querySelector('.menu-fade-left');
        var fadeR = menu.querySelector('.menu-fade-right');
        if (!nav || !btnL || !btnR || !fadeL || !fadeR) {
            return;
        }
        var STEP = 200;

        function updateArrows() {
            var overflowing = nav.scrollWidth > nav.clientWidth + 4;
            var atStart = nav.scrollLeft <= 4;
            var atEnd =
                nav.scrollLeft >= nav.scrollWidth - nav.clientWidth - 4;
            btnL.classList.toggle('show', overflowing && !atStart);
            btnR.classList.toggle('show', overflowing && !atEnd);
            fadeL.classList.toggle('show', overflowing && !atStart);
            fadeR.classList.toggle('show', overflowing && !atEnd);
        }

        function checkFit() {
            nav.classList.remove('is-fit');
            nav.style.width = '100%';
            var naturalWidth = 0;
            nav.querySelectorAll('.common-menu-link').forEach(function(link) {
                naturalWidth += link.getBoundingClientRect().width;
            });
            if (naturalWidth <= nav.clientWidth) {
                nav.classList.add('is-fit');
                nav.style.width = '';
            }
            updateArrows();
        }
        btnL.addEventListener('click', function() {
            nav.scrollBy({
                left: -STEP,
                behavior: 'smooth'
            });
        });
        btnR.addEventListener('click', function() {
            nav.scrollBy({
                left: STEP,
                behavior: 'smooth'
            });
        });
        nav.addEventListener('scroll', updateArrows);
        if (typeof ResizeObserver !== 'undefined') {
            new ResizeObserver(checkFit).observe(menu);
        } else {
            window.addEventListener('resize', checkFit);
        }
        var drag = false;
        var startX = 0;
        var scrollStart = 0;
        nav.addEventListener('mousedown', function(e) {
            if (e.target.closest('a')) {
                return;
            }
            drag = true;
            startX = e.pageX;
            scrollStart = nav.scrollLeft;
            nav.classList.add('is-dragging');
        });
        window.addEventListener('mousemove', function(e) {
            if (!drag) {
                return;
            }
            nav.scrollLeft = scrollStart - (e.pageX - startX);
        });
        window.addEventListener('mouseup', function() {
            drag = false;
            nav.classList.remove('is-dragging');
        });
        nav.addEventListener('touchstart', function(e) {
            if (!e.touches.length) {
                return;
            }
            startX = e.touches[0].pageX;
            scrollStart = nav.scrollLeft;
        }, {
            passive: true
        });
        nav.addEventListener('touchmove', function(e) {
            if (!e.touches.length) {
                return;
            }
            nav.scrollLeft =
                scrollStart - (e.touches[0].pageX - startX);
        }, {
            passive: true
        });

        /*
         * Recalculate after fonts and layout have settled.
         */
        requestAnimationFrame(checkFit);
        window.addEventListener('load', checkFit, {
            once: true
        });
    }

    function initializeAllMenus() {
        document.querySelectorAll('.common-menu').forEach(
            initializeCommonMenu
        );
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeAllMenus);
    } else {
        initializeAllMenus();
    }
})();
</script>