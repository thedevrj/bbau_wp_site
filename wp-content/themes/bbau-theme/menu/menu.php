<?php

global $post;

/* Step 1: Detect Parent */
$parent_id = ($post->post_parent) ? $post->post_parent : $post->ID;

/* Step 2: Check toggle from parent */
$show_menu = get_field('show_menu', $parent_id);

if ($show_menu):

    /* Step 3: Get menu from parent */
    $menu_items = get_field('menus', $parent_id);

    if ($menu_items): ?>

        <div class="common-menu">
            <nav class="common-menu-nav">

                <?php foreach ($menu_items as $item): 

                    $page_link   = $item['menu_page'];
                    $custom_label = $item['menu_label'];

                    if (!$page_link) continue;

                    // Handle all formats
                    if (is_array($page_link)) {
                        $url   = $page_link['url'];
                        $title = $custom_label ? $custom_label : $page_link['title'];
                    } elseif (is_numeric($page_link)) {
                        $url   = get_permalink($page_link);
                        $title = $custom_label ? $custom_label : get_the_title($page_link);
                    } else {
                        $url   = $page_link;
                        $title = $custom_label ? $custom_label : 'Menu Item';
                    }

                    $current_url = trailingslashit(get_permalink());
                    $item_url    = trailingslashit($url);

                    $active = ($current_url === $item_url) ? 'active' : '';
                ?>

                    <a class="common-menu-link <?php echo $active; ?>" href="<?php echo esc_url($url); ?>">
                        <span class="dot"></span>
                        <?php echo esc_html($title); ?>
                    </a>

                <?php endforeach; ?>

            </nav>
        </div>

    <?php endif;

endif;
?>