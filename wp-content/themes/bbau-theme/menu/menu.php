<?php

global $post;

/* Find Parent Page */

if ($post->post_parent) {
    $parent_id = $post->post_parent;
} else {
    $parent_id = $post->ID;
}

/* Get Child Pages */

$args = array(
'post_type' => 'page',
'post_parent' => $parent_id,
'sort_column' => 'menu_order'
);

$pages = get_pages($args);

if(!$pages) return;

$current = get_the_ID();

?>

<div class="common-menu">

    <nav class="common-menu-nav">

        <?php foreach($pages as $page):

$active = ($current == $page->ID) ? 'active' : '';

?>

        <a class="common-menu-link <?php echo $active;?>" href="<?php echo get_permalink($page->ID); ?>">

            <span class="dot"></span>

            <?php echo esc_html($page->post_title); ?>

        </a>

        <?php endforeach; ?>

    </nav>

</div>