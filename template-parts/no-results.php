<?php
/**
 * Template part for displaying no results message on archive pages.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="kai-empty-state">
	<h2><?php esc_html_e( 'There are no posts yet', 'kai-upgrade-child' ); ?></h2>
	<p><?php esc_html_e( 'The materials will be added shortly.', 'kai-upgrade-child' ); ?></p>
</div>