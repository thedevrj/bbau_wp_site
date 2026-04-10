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
