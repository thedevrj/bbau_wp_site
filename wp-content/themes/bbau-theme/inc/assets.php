<?php
defined('ABSPATH') || exit;

function bbau_enqueue_assets() {

    // Theme CSS
    wp_enqueue_style(
        'bbau-style',
        get_stylesheet_directory_uri() . '/assets/css/style.css',
        [],
        filemtime(get_stylesheet_directory() . '/assets/css/style.css')
    );

    // Swiper CSS
    wp_enqueue_style(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        '11'
    );

    // Swiper JS
    wp_enqueue_script(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        '11',
        true
    );

    // Theme JS (depends on Swiper)
    wp_enqueue_script(
        'bbau-main',
        get_stylesheet_directory_uri() . '/assets/js/main.js',
        ['swiper'],
        filemtime(get_stylesheet_directory() . '/assets/js/main.js'),
        true
    );
}

add_action('wp_enqueue_scripts', 'bbau_enqueue_assets');

function load_bootstrap() {
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css'
    );

    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
        array('jquery'),
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'load_bootstrap');
