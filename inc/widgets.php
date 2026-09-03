<?php
/**
 * Widget areas for KAI Upgrade Child Theme.
 *
 * @package KAI_Upgrade_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enable shortcodes in WordPress widgets.
 */
add_filter( 'widget_custom_html_content', 'do_shortcode' );
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Register widget areas.
 */
add_action( 'widgets_init', 'kai_upgrade_register_widget_areas' );

function kai_upgrade_register_widget_areas() {
	register_sidebar(
		[
			'name'          => esc_html__( 'Header Action', 'kai-upgrade-child' ),
			'id'            => 'kai-header-action',
			'description'   => esc_html__( 'Button at the top of the website', 'kai-upgrade-child' ),
			'before_widget' => '<div id="%1$s" class="kai-header-action-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
		]
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Archive Sidebar', 'kai-upgrade-child' ),
			'id'            => 'kai-archive-sidebar',
			'description'   => esc_html__( 'Sidebar for archive pages', 'kai-upgrade-child' ),
			'before_widget' => '<section id="%1$s" class="kai-sidebar-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="kai-sidebar-widget__title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Page Sidebar', 'kai-upgrade-child' ),
			'id'            => 'kai-page-sidebar',
			'description'   => esc_html__( 'Sidebar for pages', 'kai-upgrade-child' ),
			'before_widget' => '<section id="%1$s" class="kai-sidebar-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="kai-sidebar-widget__title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Post Sidebar', 'kai-upgrade-child' ),
			'id'            => 'kai-post-sidebar',
			'description'   => esc_html__( 'Sidebar for posts', 'kai-upgrade-child' ),
			'before_widget' => '<section id="%1$s" class="kai-sidebar-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="kai-sidebar-widget__title">',
			'after_title'   => '</h2>',
		)
	);
}