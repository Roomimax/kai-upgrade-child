<?php
/**
 * 404 Page Template
 *
 * @package KAI_Upgrade_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$page_id_404 = 6275;
?>

<main id="primary" class="site-main kai-404">

	<?php
	if ( did_action( 'elementor/loaded' ) ) {

		echo \Elementor\Plugin::instance()
			->frontend
			->get_builder_content_for_display( $page_id_404 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	} else {
		?>

		<section class="kai-404__fallback">
			<div class="kai-container">

				<h1>404</h1>

				<p>
					Сторінку не знайдено.
				</p>

				<a
					href="<?php echo esc_url( home_url( '/' ) ); ?>"
					class="kai-button"
				>
					На головну
				</a>

			</div>
		</section>

		<?php
	}
	?>

</main>

<?php
get_footer();