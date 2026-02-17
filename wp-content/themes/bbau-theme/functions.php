<?php
/**
 * BBAU Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package BBAU_Theme
 */
defined('ABSPATH') || exit;

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bbau_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on BBAU Theme, use a find and replace
		* to change 'bbau-theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'bbau-theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'bbau-theme' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'bbau_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'bbau_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bbau_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bbau_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'bbau_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bbau_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'bbau-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'bbau-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'bbau_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bbau_theme_scripts() {
	wp_enqueue_style( 'bbau-theme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'bbau-theme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'bbau-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bbau_theme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

//load all cdn in this file only
require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/class-bbau-nav-walker.php';


// register custom menus
function theme_register_custom_menus() {
	register_nav_menus(array(
		'announcement_bar' => ('Announcement Bar Menu'),
		'footer_university_menu' => ('Footer University Menu'),
		'quick_links_1' => ('Footer Quick links Menu 1'),
		'quick_links_2' => ('Footer Quick links Menu 2'),
		'primary_menu' => ('Primary Menu Desktop'),
		'primary_mobile_menu' => __('Primary Menu Mobile'),
	));
}
add_action('after_setup_theme', 'theme_register_custom_menus');

// Register Old Vice Chancellor Post Type
function register_old_vice_chancellor_cpt() {

    $labels = array(
        'name'                  => 'Old Vice Chancellors',
        'singular_name'         => 'Old Vice Chancellor',
        'menu_name'             => 'Old Vice Chancellors',
        'name_admin_bar'        => 'Old Vice Chancellor',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Old Vice Chancellor',
        'new_item'              => 'New Old Vice Chancellor',
        'edit_item'             => 'Edit Old Vice Chancellor',
        'view_item'             => 'View Old Vice Chancellor',
        'all_items'             => 'All Old Vice Chancellors',
        'search_items'          => 'Search Old Vice Chancellors',
        'not_found'             => 'No Old Vice Chancellors found',
        'not_found_in_trash'    => 'No Old Vice Chancellors found in Trash',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'old_vice_chancellor'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-businessperson',
        'supports'           => array(
            'title',
            'editor',
            'thumbnail'
        ),
        'show_in_rest'       => true, // Gutenberg support
    );

    register_post_type('old_vice_chancellor', $args);
}
add_action('init', 'register_old_vice_chancellor_cpt');


// Register Eminent Lecture Series Post Type
function register_eminent_lecture_series_cpt() {

	$labels = array(
		'name'                  => 'Eminent Lecture Series',
		'singular_name'         => 'Eminent Lecture',
		'menu_name'             => 'Eminent Lecture Series',
		'name_admin_bar'        => 'Eminent Lecture',
		'add_new'               => 'Add New',
		'add_new_item'          => 'Add New Eminent Lecture',
		'new_item'              => 'New Eminent Lecture',
		'edit_item'             => 'Edit Eminent Lecture',
		'view_item'             => 'View Eminent Lecture',
		'all_items'             => 'All Eminent Lectures',
		'search_items'          => 'Search Eminent Lectures',
		'not_found'             => 'No Eminent Lectures found',
		'not_found_in_trash'    => 'No Eminent Lectures found in Trash',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array('slug' => 'eminent_lecture_series'),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 21,
		'menu_icon'          => 'dashicons-microphone',
		'supports'           => array(
			'title',
			'editor',
			'thumbnail'
		),
		'show_in_rest'       => true
	);

	register_post_type('eminent_lecture', $args);
}
add_action('init', 'register_eminent_lecture_series_cpt');