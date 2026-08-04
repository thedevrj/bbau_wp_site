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

require get_template_directory() . '/dynamic-sitemap.php';
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
		'announcement_bar_mobile' => ('Announcement Bar Menu Mobile'),
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

//VC's speech post type
function vc_speech_post_type() {
	register_post_type('vc_speech',array(
		'labels' => array(
		'name' => 'VC Speeches',
		'singular_name' => 'VC Speech'
		),
		'public' => true,
		'menu_icon' => 'dashicons-media-document',
		'supports' => array('title'),
		'has_archive' => true,
		'rewrite' => array('slug' => 'vc-speeches'),
		'menu_position' => 22
		));
}
add_action('init','vc_speech_post_type');


//rewrite rules for school detail page and faculty profile
function add_custom_query_vars($vars) {
    $vars[] = 'school_slug';
    $vars[] = 'dept_slug';
    $vars[] = 'centre_slug';
    $vars[] = 'faculty_slug';
    return $vars;
}
add_filter('query_vars', 'add_custom_query_vars');

function add_school_rewrite_rule() {

	//school rewrite rule
    add_rewrite_rule(
        '^schools/([^/]+)/?$',
        'index.php?pagename=school-detail&school_slug=$matches[1]',
        'top'
    );
    
    // centre rewrite rule (only for specific centres acting as departments)
    $dept_centres = 'centre-of-post-graduate-legal-studies|centre-for-the-study-of-social-inclusion-cssi';
    add_rewrite_rule(
        '^centres/(' . $dept_centres . ')/?$',
        'index.php?pagename=centre&centre_slug=$matches[1]',
        'top'
    );
    // department rewrite rule
    add_rewrite_rule(
        '^departments/([^/]+)/?$',
        'index.php?pagename=department&dept_slug=$matches[1]',
        'top'
    );
    // faculty profile rewrite rule
    add_rewrite_rule(
        '^faculty/([^/]+)/?$',
        'index.php?pagename=faculty-profile&faculty_slug=$matches[1]',
        'top'
    );
}
add_action('init', 'add_school_rewrite_rule');

// ACF Options Page for Sidebar Menus
if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Sidebar Menus',
        'menu_title' => 'Sidebar Menus',
        'menu_slug'  => 'sidebar-menus',
        'capability' => 'edit_posts',
        'redirect'   => false
    ));
}

function custom_menu_rewrite_rule() {
    add_rewrite_rule(
        '^(.+?)/menu/([^/]+)/?$',
        'index.php?pagename=$matches[1]&menu=$matches[2]',
        'top'
    );
}
add_action('init', 'custom_menu_rewrite_rule');

function custom_menu_query_var($vars) {
    $vars[] = 'menu';
    return $vars;
}
add_filter('query_vars', 'custom_menu_query_var');

//  Smart Labeling for Departments by Campus

function get_dept_display_name($dept) {
    if (empty($dept)) return '';
    
    $name = $dept['name'] ?? '';
    $campus = $dept['campus'] ?? 'BBAU';
    
    // Check if we are on the Dedicated Satellite Campus Page
    if (is_page_template('page-satellite-campus.php')) {
        return $name;
    }
    
    if ($campus === 'Satellite Campus Amethi') {
        return $name . ' (Amethi)';
    }
    
    return $name;
}
function get_centre_display_name($centre) {
    if (empty($centre)) return '';
    return $centre['name'] ?? '';
}


//  Helper fn for dynamic SEO data from the Django API

function bbau_get_dynamic_seo_data($slug, $type) {
    if (empty($slug)) {
        return null;
    }

    static $static_cache = [];
    $cache_key = $type . '_' . $slug;

    if (isset($static_cache[$cache_key])) {
        return $static_cache[$cache_key];
    }

    // Attempt to load from WordPress Transients cache
    $transient_key = 'bbau_seo_' . $type . '_' . md5($slug);
    $cached = get_transient($transient_key);
    if ($cached !== false) {
        $static_cache[$cache_key] = $cached;
        return $cached;
    }

    $api_base = getenv('DJANGO_API_URL');
    if (empty($api_base)) {
        return null;
    }

    switch ($type) {
        case 'department':
            $url = $api_base . '/api/v1/departments/' . urlencode($slug) . '/';
            break;
        case 'centre':
            $url = $api_base . '/api/v1/centres/' . urlencode($slug) . '/';
            break;
        case 'school':
            $url = $api_base . '/api/v1/schools/' . urlencode($slug) . '/';
            break;
        case 'faculty':
            $url = $api_base . '/api/v1/faculty/' . urlencode($slug) . '/';
            break;
        default:
            return null;
    }

    $res = wp_remote_get($url, array('timeout' => 5));
    if (!is_wp_error($res) && wp_remote_retrieve_response_code($res) === 200) {
        $data = json_decode(wp_remote_retrieve_body($res), true);
        if (!empty($data)) {
            // Save to transient for 2 hours to optimize performance
            set_transient($transient_key, $data, 2 * HOUR_IN_SECONDS);
            $static_cache[$cache_key] = $data;
            return $data;
        }
    }

    return null;
}

/**
 * Returns contextual SEO title and meta description based on current page and query parameters.
 */
function bbau_get_dynamic_seo_meta() {
    $seo = [
        'title' => '',
        'desc'  => '',
    ];

    $request_slug = isset($_GET['slug']) ? sanitize_title(wp_unslash($_GET['slug'])) : '';
    $dept_slug    = get_query_var('dept_slug');
    $centre_slug  = get_query_var('centre_slug');
    $school_slug  = get_query_var('school_slug');

    // The legacy `slug` query parameter is used by several page templates.
    // Apply it only to the current template so one slug cannot match all types.
    if (empty($dept_slug) && is_page('department')) {
        $dept_slug = $request_slug;
    } elseif (empty($centre_slug) && is_page('centre')) {
        $centre_slug = $request_slug;
    } elseif (empty($school_slug) && is_page('school-detail')) {
        $school_slug = $request_slug;
    }
    $faculty_slug = get_query_var('faculty_slug');

    // Fallback detection for faculty slug from request URI.
    $request_uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
    if (empty($faculty_slug) && (is_page('faculty-profile') || strpos($request_uri, '/faculty/') !== false)) {
        $parts = explode('/faculty/', $request_uri);
        if (isset($parts[1])) {
            $faculty_slug = sanitize_title(current(explode('/', $parts[1])));
        }
    }

    $tab = isset($_GET['tab']) ? sanitize_text_field(wp_unslash($_GET['tab'])) : 'about';

    $tab_labels = [
        'about'        => 'About',
        'thrust'       => 'Thrust Areas',
        'programs'     => 'Programmes Offered',
        'faculty'      => 'Faculty & People',
        'notices'      => 'Announcements & Notices',
        'research'     => 'Research Activities',
        'timetable'    => 'Time Table',
        'committees'   => 'Committees',
        'gallery'      => 'Gallery',
        'school_board' => 'School Board Members',
        'minutes'      => 'School Board Minutes',
        'departments'  => 'Departments',
        'centers'      => 'Centers',
    ];

    // Department templates
    if (!empty($dept_slug)) {
        $data = bbau_get_dynamic_seo_data($dept_slug, 'department');
        if ($data && !empty($data['name'])) {
            $name = $data['name'];
            $is_amethi = ($data['campus'] ?? '') === 'Satellite Campus Amethi';
            $campus_suffix = $is_amethi ? ' (Amethi Campus)' : '';
            $campus_text = $is_amethi ? 'Satellite Campus, Amethi' : 'Babasaheb Bhimrao Ambedkar University (BBAU)';

            $label = $tab_labels[$tab] ?? 'About';

            $seo['title'] = ($tab === 'about')
                ? "Department of {$name}{$campus_suffix} | BBAU"
                : "{$label} - Department of {$name}{$campus_suffix} | BBAU";

            switch ($tab) {
                case 'faculty':
                    $seo['desc'] = "Meet the faculty members, staff, and researchers in the Department of {$name} at {$campus_text}. Access profiles, designations, and contacts.";
                    break;
                case 'programs':
                    $seo['desc'] = "View all undergraduate, postgraduate, and PhD academic programmes, admission details, and courses offered by the Department of {$name} at {$campus_text}.";
                    break;
                case 'research':
                    $seo['desc'] = "Discover the core research thrust areas, research publications, journals, and doctoral research activities in the Department of {$name} at {$campus_text}.";
                    break;
                case 'notices':
                    $seo['desc'] = "Stay updated with the latest circulars, semester exams, admission alerts, and official notices from the Department of {$name} at {$campus_text}.";
                    break;
                default:
                    $seo['desc'] = "Explore the Department of {$name} at {$campus_text}. Read about our department profile, course structures, activities, and faculty directories.";
                    break;
            }
        }
    }
    // Centre templates
    elseif (!empty($centre_slug)) {
        $data = bbau_get_dynamic_seo_data($centre_slug, 'centre');
        if ($data && !empty($data['name'])) {
            $name = $data['name'];
            $label = $tab_labels[$tab] ?? 'About';

            $seo['title'] = ($tab === 'about')
                ? "{$name} | BBAU"
                : "{$label} - {$name} | BBAU";

            $seo['desc'] = "Explore the {$name} at Babasaheb Bhimrao Ambedkar University (BBAU). Find academic programmes, research thrust areas, news notifications, and board members.";
        }
    }
    // School templates
    elseif (!empty($school_slug)) {
        $data = bbau_get_dynamic_seo_data($school_slug, 'school');
        if ($data && !empty($data['name'])) {
            $name = $data['name'];
            $label = $tab_labels[$tab] ?? 'About';

            $seo['title'] = ($tab === 'about')
                ? "{$name} | BBAU"
                : "{$label} - {$name} | BBAU";

            $seo['desc'] = "Learn about the {$name} at Babasaheb Bhimrao Ambedkar University (BBAU). Access departments, centers under the school, and dean messages.";
        }
    }
    // Faculty templates
    elseif (!empty($faculty_slug)) {
        $data = bbau_get_dynamic_seo_data($faculty_slug, 'faculty');
        if ($data && !empty($data['name'])) {
            $name = $data['name'];
            $designation = $data['designation'] ?? 'Faculty Member';
            $dept_name = $data['department']['name'] ?? '';

            if (!empty($dept_name)) {
                $seo['title'] = "{$name} - {$designation}, Department of {$dept_name} | BBAU";
                $seo['desc'] = "View the academic profile of {$name}, {$designation} in the Department of {$dept_name} at Babasaheb Bhimrao Ambedkar University (BBAU). Learn about qualifications, research focus, publications, supervision, and contacts.";
            } else {
                $seo['title'] = "{$name} - {$designation} | BBAU";
                $seo['desc'] = "View the academic profile of {$name}, {$designation} at Babasaheb Bhimrao Ambedkar University (BBAU). Learn about qualifications, research focus, publication history, supervision, and contacts.";
            }
        }
    }

    return array_filter($seo);
}

/**
 * Filter default WordPress title tag
 */
add_filter('document_title_parts', function($title_parts) {
    $seo = bbau_get_dynamic_seo_meta();
    if (!empty($seo['title'])) {
        $title_parts['title'] = $seo['title'];
    }
    return $title_parts;
}, 100);

/**
 * Native Rank Math Filter Overrides
 */
add_filter('rank_math/frontend/title', function($title) {
    $seo = bbau_get_dynamic_seo_meta();
    return !empty($seo['title']) ? $seo['title'] : $title;
}, 100);

add_filter('rank_math/frontend/description', function($desc) {
    $seo = bbau_get_dynamic_seo_meta();
    return !empty($seo['desc']) ? $seo['desc'] : $desc;
}, 100);

// fix duplicate content issue in rank math

add_filter('rank_math/frontend/canonical', function($canonical) {
    $request_slug = isset($_GET['slug']) ? sanitize_title(wp_unslash($_GET['slug'])) : '';
    $dept_slug    = get_query_var('dept_slug');
    $centre_slug  = get_query_var('centre_slug');
    $school_slug  = get_query_var('school_slug');

    if (empty($dept_slug) && is_page('department')) {
        $dept_slug = $request_slug;
    } elseif (empty($centre_slug) && is_page('centre')) {
        $centre_slug = $request_slug;
    } elseif (empty($school_slug) && is_page('school-detail')) {
        $school_slug = $request_slug;
    }

    // Set canonical to the clean dynamic page structure 
    if (!empty($dept_slug)) {
        return home_url("/departments/{$dept_slug}/");
    } elseif (!empty($centre_slug)) {
        return home_url("/centres/{$centre_slug}/");
    } elseif (!empty($school_slug)) {
        return home_url("/schools/{$school_slug}/");
    }
    return $canonical;
}, 100);
