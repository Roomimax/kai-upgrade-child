<?php
/**
 * Custom header for KAI Upgrade Child Theme.
 *
 * @package KAI_Upgrade_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! hello_get_header_display() ) {
	return;
}

$is_editor = isset( $_GET['elementor-preview'] );
$site_name = get_bloginfo( 'name' );
$tagline   = get_bloginfo( 'description', 'display' );
$header_class = did_action( 'elementor/loaded' ) ? hello_get_header_layout_class() : '';

$menu_args = [
	'theme_location' => 'menu-1',
	'fallback_cb'    => false,
	'container'      => false,
	'menu_class'     => 'kai-header-menu',
	'echo'           => false,
];

$header_nav_menu = wp_nav_menu( $menu_args );
?>

<header id="kai-site-header" class="kai-site-header dynamic-header <?php echo esc_attr( $header_class ); ?>">
	<div class="kai-header-inner">

		<div class="kai-site-branding show-<?php echo esc_attr( hello_elementor_get_setting( 'hello_header_logo_type' ) ); ?>">

			<?php if ( has_custom_logo() && ( 'title' !== hello_elementor_get_setting( 'hello_header_logo_type' ) || $is_editor ) ) : ?>
				<div class="kai-header-logo site-logo <?php echo esc_attr( hello_show_or_hide( 'hello_header_logo_display' ) ); ?>">
					<?php the_custom_logo(); ?>
				</div>
			<?php endif;

			if ( $site_name && ( 'logo' !== hello_elementor_get_setting( 'hello_header_logo_type' ) || $is_editor ) ) : ?>
				<div class="kai-site-title site-title <?php echo esc_attr( hello_show_or_hide( 'hello_header_logo_display' ) ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr__( 'Home', 'hello-elementor' ); ?>" rel="home">
						<?php echo esc_html( $site_name ); ?>
					</a>
				</div>
			<?php endif;

			if ( $tagline && ( hello_elementor_get_setting( 'hello_header_tagline_display' ) || $is_editor ) ) : ?>
				<p class="kai-site-description site-description <?php echo esc_attr( hello_show_or_hide( 'hello_header_tagline_display' ) ); ?>">
					<?php echo esc_html( $tagline ); ?>
				</p>
			<?php endif; ?>

		</div>

		<div id="kai-panel" class="kai-panel">
			<?php if ( $header_nav_menu ) : ?>
				<nav id="kai-nav" class="kai-header-nav" aria-label="<?php echo esc_attr__( 'Main menu', 'hello-elementor' ); ?>">
					<?php
					// PHPCS - escaped by WordPress with "wp_nav_menu"
					echo $header_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</nav>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'kai-header-action' ) ) : ?>
				<div id="kai-header-action" class="kai-header-action">
					<?php dynamic_sidebar( 'kai-header-action' ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $header_nav_menu ) : ?>
			<button id="kai-mobile-burger" class="kai-mobile-burger" type="button" aria-label="<?php echo esc_attr__( 'Open menu', 'hello-elementor' ); ?>" aria-expanded="false" aria-controls="kai-panel">
				<span class="kai-mobile-burger-lines" aria-hidden="true">
					<span></span>
					<span></span>
					<span></span>
				</span>
			</button>
		<?php endif; ?>

	</div>
</header>