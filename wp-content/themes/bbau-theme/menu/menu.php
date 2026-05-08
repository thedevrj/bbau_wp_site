<?php

/* ================================
   STEP 1: Detect Menu Group
================================ */

$current_group = '';

// 1️⃣ Cookie (main source)
if (isset($_COOKIE['current_menu']) && !empty($_COOKIE['current_menu'])) {
    $current_group = sanitize_text_field($_COOKIE['current_menu']);
}

// 2️⃣ URL param (first click only)
if (!$current_group && isset($_GET['menu'])) {
    $current_group = sanitize_text_field($_GET['menu']);
}

// 3️⃣ Fallback (default page setting)
if (!$current_group) {
    $current_group = get_field('menu_group');
}

if (!$current_group) return;


/* ================================
   STEP 2: Get Global Menus
================================ */

$all_menus = get_field('sidebar_menus', 'option');

if (!$all_menus) return;


/* ================================
   STEP 3: Find Matching Menu
================================ */

$menu_items = [];

foreach ($all_menus as $menu) {

    if (empty($menu['menu_group'])) continue;

    if (strtolower(trim($menu['menu_group'])) === strtolower(trim($current_group))) {
        $menu_items = $menu['menu_items'];
        break;
    }
}

if (!$menu_items) return;


/* ================================
   STEP 4: Prepare Menu URLs (for reset logic)
================================ */

$menu_urls = [];

foreach ($menu_items as $mi) {

    if (is_object($mi['menu_page'])) {
        $menu_urls[] = get_permalink($mi['menu_page']->ID);

    } elseif (is_numeric($mi['menu_page'])) {
        $menu_urls[] = get_permalink($mi['menu_page']);

    } elseif (is_array($mi['menu_page'])) {
        $menu_urls[] = $mi['menu_page']['url'];
    }
}

$menu_urls_json = htmlspecialchars(json_encode($menu_urls), ENT_QUOTES, 'UTF-8');

?>


<!-- ================================
     STEP 5: Render Sidebar
================================ -->

<div class="common-menu">
    <nav class="common-menu-nav">

        <?php foreach ($menu_items as $item): 

            $page_link    = $item['menu_page'];
            $custom_label = $item['menu_label'];

            if (!$page_link) continue;

            /* Handle ACF return types */
            if (is_object($page_link)) {
                $url   = get_permalink($page_link->ID);
                $title = $custom_label ?: $page_link->post_title;

            } elseif (is_array($page_link)) {
                $url   = $page_link['url'];
                $title = $custom_label ?: $page_link['title'];

            } elseif (is_numeric($page_link)) {
                $url   = get_permalink($page_link);
                $title = $custom_label ?: get_the_title($page_link);

            } else {
                $url   = $page_link;
                $title = $custom_label ?: 'Menu Item';
            }

            // Add ?menu= only for initial detection
            $final_url = $url . '?menu=' . urlencode($current_group);

            $current_url = trailingslashit(get_permalink());
            $item_url    = trailingslashit($url);

            $active = ($current_url === $item_url) ? 'active' : '';
        ?>

        <a class="common-menu-link <?php echo $active; ?>"
           href="<?php echo esc_url($final_url); ?>"
           data-menu="<?php echo esc_attr($current_group); ?>"
           data-pages='<?php echo $menu_urls_json; ?>'>

            <span class="dot"></span>
            <?php echo esc_html($title); ?>
        </a>

        <?php endforeach; ?>

    </nav>
</div>
<style>

/* ================= MENU ================= */
.common-menu {
  display: block;
  max-width: 100%;
  width: auto;

  background: #5A6A7A;

  border-radius: 12px;

  /* ✅ PREMIUM BORDER */
  border: 1px solid rgba(228, 244, 14, 0.94);

  /* ✅ ENHANCED SHADOW */
  box-shadow: 
    0 6px 20px rgba(251, 93, 25, 0.41),
    0 0 0 1px rgba(57, 7, 15, 0.82);

  margin: 20px auto;
  overflow: hidden;
}

.menu-wrapper {
  text-align: center;
  padding: 0 10px;
}

/* ================= NAV ================= */
.common-menu-nav {
  display: flex;
  flex-wrap: nowrap;

  justify-content: flex-start;      /* ✅ no left cut */
  align-items: stretch;

  overflow-x: auto;                 /* ✅ scroll enabled */
  overflow-y: hidden;

  -webkit-overflow-scrolling: touch;
  scroll-behavior: smooth;
}

/* ================= LINKS ================= */
.common-menu-link {
  flex: 0 0 auto;
  min-width: 120px;

  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 6px;

  padding: 14px 20px;

  font-size: 16px;
  font-weight: 700;
  text-align: center;

  color: #e1ebf0 !important;
  text-decoration: none;

  border-right: 1px solid rgba(255,255,255,0.2);

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
  background: #f26f1e;
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
  color: #1a2e3b !important;
}

.common-menu-link:hover .dot {
  background: #1a2e3b !important;
}

.common-menu-link:hover::after {
  transform: scaleX(1);
}

/* ================= ACTIVE ================= */
.common-menu-link.active {
  background: #eef6fa;
  color: #1a2e3b !important;
  font-weight: 600;
}

.common-menu-link.active .dot {
  background: #1a2e3b !important;
}

.common-menu-link.active::after {
  transform: scaleX(1);
}

/* ================= SCROLLBAR ================= */
.common-menu-nav::-webkit-scrollbar {
  height: 4px;
}

.common-menu-nav::-webkit-scrollbar-thumb {
  background: #c90b38;
  border-radius: 10px;
}

/* ================= LARGE DESKTOP ================= */
@media (min-width: 1200px) {
  .common-menu-link {
    min-width: 130px;
  }
}

/* ================= TABLET ================= */
@media (max-width: 992px) {

  .common-menu {
    width: 100%;
  }

  .common-menu-link {
    min-width: 110px;
    padding: 12px 16px;
    font-size: 12px;
  }
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {

  .common-menu-link {
    min-width: 100px;
    padding: 12px 14px;
    font-size: 12px;
  }
}

/* ================= SMALL MOBILE ================= */
@media (max-width: 480px) {

  .common-menu-link {
    min-width: 85px;
    font-size: 11px;
    padding: 10px 12px;
  }

  .common-menu-link .dot {
    width: 5px;
    height: 5px;
  }
}

/* ================= HOVER GLOW (OPTIONAL) ================= */
.common-menu:hover {
  box-shadow: 
    0 8px 25px rgba(26, 46, 59, 0.12),
    0 0 10px rgba(33, 150, 166, 0.2);
}
</style>