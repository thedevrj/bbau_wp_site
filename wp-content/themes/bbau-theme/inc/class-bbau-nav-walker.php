<?php
defined('ABSPATH') || exit;

class BBAU_Nav_Walker extends Walker_Nav_Menu {

    // Start Level (submenu wrapper)
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $submenu_class = ($depth === 0) ? 'sub-menu dropdown-menu' : 'sub-menu dropdown-submenu';

        $output .= "\n$indent<ul class=\"$submenu_class\">\n";
    }

    // Start Element
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes, true);

        $class_names = implode(' ', array_map('esc_attr', $classes));
        $output .= $indent . '<li class="menu-item ' . $class_names . '">';

        $atts = '';
        $atts .= ! empty($item->url) ? ' href="' . esc_url($item->url) . '"' : '';
        $atts .= ' class="menu-link"';

        if ($has_children) {
            $atts .= ' aria-haspopup="true" aria-expanded="false"';
        }

        $title = apply_filters('the_title', $item->title, $item->ID);

        $output .= '<a' . $atts . '>';
        $output .= esc_html($title);

        // Dropdown icon (optional)
        if ($has_children) {
            $output .= ' <span class="dropdown-icon">▾</span>';
        }

        $output .= '</a>';
    }

    // End Element
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}
