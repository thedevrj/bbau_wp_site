<?php
defined('ABSPATH') || exit;

class BBAU_Nav_Walker extends Walker_Nav_Menu {

    /**
     * Start Submenu Level
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    /**
     * Start Menu Item
     */
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? [] : (array) $item->classes;

        $has_children = in_array('menu-item-has-children', $classes, true);
        $is_mega      = in_array('is-mega-menu', $classes, true);

        // Base class
        $class_names = 'menu-item';

        // Append existing WP classes
        if (!empty($classes)) {
            $class_names .= ' ' . esc_attr(implode(' ', $classes));
        }

        // Add mega-menu class ONLY if marked
        if ($is_mega && $depth === 0) {
            $class_names .= ' mega-menu';
        }

        $output .= $indent . '<li class="' . trim($class_names) . '">';

        // Link attributes
        $atts  = ! empty($item->url) ? ' href="' . esc_url($item->url) . '"' : '';
        $atts .= ' class="menu-link"';

        if ($has_children) {
            $atts .= ' aria-haspopup="true" aria-expanded="false"';
        }

        $title = apply_filters('the_title', $item->title, $item->ID);

        // Output link
        $output .= '<a' . $atts . '>';
        $output .= $title;

        // Dropdown arrow
        if ($has_children) {
            $output .= ' <span class="dropdown-icon"><i class="icon-chevron-down1"></i></span>';
        }

        $output .= '</a>';
    }

    /**
     * End Menu Item
     */
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}
