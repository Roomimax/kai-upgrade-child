<?php
/**
 * KAI UPGRADE Child theme functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue parent and child theme styles/scripts.
 */
function kai_upgrade_child_enqueue_assets() {

	// Parent theme style.
	wp_enqueue_style(
		'hello-elementor-style',
		get_template_directory_uri() . '/style.css',
		[],
		wp_get_theme( 'hello-elementor' )->get( 'Version' )
	);

	// Bootstrap CSS.
	wp_enqueue_style(
		'kai-bootstrap-style',
		get_stylesheet_directory_uri() . '/assets/vendor/bootstrap/css/bootstrap.min.css',
		[],
		filemtime( get_stylesheet_directory() . '/assets/vendor/bootstrap/css/bootstrap.min.css' )
	);

	// Slick CSS.
	wp_enqueue_style(
		'kai-slick-style',
		get_stylesheet_directory_uri() . '/assets/vendor/slick/css/slick.css',
		[],
		filemtime( get_stylesheet_directory() . '/assets/vendor/slick/css/slick.css' )
	);

	// Child theme main style.css.
	wp_enqueue_style(
		'kai-upgrade-child-style',
		get_stylesheet_uri(),
		array(
			'hello-elementor',
			'hello-elementor-style',
			'kai-bootstrap-style',
			'hello-elementor-theme-style',
			'hello-elementor-header-footer',
		),
		wp_get_theme()->get( 'Version' )
	);

	// Child theme custom CSS.
	wp_enqueue_style(
		'kai-upgrade-main-style',
		get_stylesheet_directory_uri() . '/assets/css/main.css',
		[ 'kai-upgrade-child-style', 'kai-bootstrap-style' ],
		filemtime( get_stylesheet_directory() . '/assets/css/main.css' )
	);

	// Bootstrap JS.
	wp_enqueue_script(
		'kai-bootstrap-script',
		get_stylesheet_directory_uri() . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js',
		['jquery'],
		filemtime( get_stylesheet_directory() . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js' ),
		true
	);

	// Slick JS.
	wp_enqueue_script(
		'kai-slick-script',
		get_stylesheet_directory_uri() . '/assets/vendor/slick/js/slick.min.js',
		['jquery'],
		filemtime( get_stylesheet_directory() . '/assets/vendor/slick/js/slick.min.js' ),
		true
	);

	// Child theme custom JS.
	wp_enqueue_script(
		'kai-upgrade-main-script',
		get_stylesheet_directory_uri() . '/assets/js/main.js',
		[ 'jquery','kai-bootstrap-script' ],
		filemtime( get_stylesheet_directory() . '/assets/js/main.js' ),
		true
	);

	wp_localize_script(
		'kai-upgrade-main-script',
		'kaiData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'kai_courses_nonce' ),
			'i18n'    => array(
				'loading'  => __( 'Loading...', 'kai-upgrade-child' ),
				'notFound' => __( 'No courses found.', 'kai-upgrade-child' ),
				'error'    => __( 'Loading error.', 'kai-upgrade-child' ),
			),
		)
	);
}

add_action( 'wp_enqueue_scripts', 'kai_upgrade_child_enqueue_assets' );

/**
 * Add custom body class.
 */
function kai_add_custom_body_class( $classes ) {
	$classes[] = 'kai-site';

	return $classes;
}
add_filter( 'body_class', 'kai_add_custom_body_class' );

/**
 * Theme includes.
 */
require_once get_stylesheet_directory() . '/inc/theme.php'; // THEME
require_once get_stylesheet_directory() . '/inc/widgets.php'; // WIDGETS
require_once get_stylesheet_directory() . '/inc/courses.php'; // COURSES TYPE