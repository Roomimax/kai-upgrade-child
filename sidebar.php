<?php
/**
 * Sidebar template.
 *
 * @package KAI_Upgrade_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sidebar_id    = $args['sidebar_id'] ?? '';
$sidebar_class = $args['sidebar_class'] ?? '';
$sidebar_label = $args['sidebar_label'] ?? esc_html__( 'Sidebar', 'kai-upgrade-child' );

if ( empty( $sidebar_id ) || ! is_active_sidebar( $sidebar_id ) ) {
	return;
}

$sidebar_classes = array(
	'kai-sidebar',
);

if ( ! empty( $sidebar_class ) ) {
	$sidebar_classes[] = $sidebar_class;
}
?>

<aside class="<?php echo esc_attr( implode( ' ', $sidebar_classes ) ); ?>" role="complementary" aria-label="<?php echo esc_attr( $sidebar_label ); ?>">
	<?php dynamic_sidebar( $sidebar_id ); ?>
</aside>