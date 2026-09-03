<?php
/**
 * Archive template for KAI Upgrade child theme.
 *
 * Displays WordPress archive pages.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$has_sidebar = is_active_sidebar( 'kai-archive-sidebar' );

$archive_classes = array(
	'kai-site-main',
	'kai-archive',
);

$queried_object = get_queried_object();

// For events
$is_events_archive = is_category( array( 19, 21 ) );

if ( is_category() && $queried_object && ! is_wp_error( $queried_object ) ) {
	$archive_classes[] = 'kai-category';
	$archive_classes[] = 'kai-category-' . sanitize_html_class( $queried_object->slug );

} elseif ( is_tag() && $queried_object && ! is_wp_error( $queried_object ) ) {
	$archive_classes[] = 'kai-tag';
	$archive_classes[] = 'kai-tag-' . sanitize_html_class( $queried_object->slug );

} elseif ( is_tax() && $queried_object && ! is_wp_error( $queried_object ) ) {
	$archive_classes[] = 'kai-taxonomy';
	$archive_classes[] = 'kai-taxonomy-' . sanitize_html_class( $queried_object->taxonomy );
	$archive_classes[] = 'kai-term-' . sanitize_html_class( $queried_object->slug );

} elseif ( is_author() ) {
	$archive_classes[] = 'kai-author';

} elseif ( is_day() ) {
	$archive_classes[] = 'kai-date';
	$archive_classes[] = 'kai-date-day';

} elseif ( is_month() ) {
	$archive_classes[] = 'kai-date';
	$archive_classes[] = 'kai-date-month';

} elseif ( is_year() ) {
	$archive_classes[] = 'kai-date';
	$archive_classes[] = 'kai-date-year';

} else {
	$archive_classes[] = 'kai-archive-default';
}
?>

<main id="content" class="<?php echo esc_attr( implode( ' ', $archive_classes ) ); ?>" role="main">

	<div class="kai-container">

		<header class="kai-archive-header">

			<h1 class="kai-title kai-archive-title">
				<?php
				if ( is_category() || is_tag() || is_tax() ) {
					single_term_title();

				} elseif ( is_author() && $queried_object && ! is_wp_error( $queried_object ) ) {
					echo esc_html( $queried_object->display_name );

				} elseif ( is_day() ) {
					echo esc_html( get_the_date() );

				} elseif ( is_month() ) {
					echo esc_html( get_the_date( 'F Y' ) );

				} elseif ( is_year() ) {
					echo esc_html( get_the_date( 'Y' ) );

				} else {
					echo esc_html__( 'Posts', 'kai-upgrade-child' );
				}
				?>
			</h1>

			<?php if ( is_category() || is_tag() || is_tax() ) : ?>
				<?php
				$term_description = term_description();

				if ( ! empty( $term_description ) ) :
					?>
					<div class="kai-archive-description">
						<?php echo wp_kses_post( $term_description ); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>

		</header>

		<div class="kai-layout <?php echo $has_sidebar ? 'kai-layout-sidebar' : 'kai-layout-no-sidebar'; ?>">

			<div class="kai-content">

				<?php if ( have_posts() ) : ?>

					<div class="kai-posts <?php echo $is_events_archive ? 'kai-events' : ''; ?>">

						<?php
						while ( have_posts() ) :
							the_post();

                            if ( $is_events_archive ) {
								get_template_part( 'template-parts/event' );
							} else {
								get_template_part( 'template-parts/post' );
							}
							
                        endwhile; ?>

					</div>

					<?php get_template_part( 'template-parts/navigation' ); ?>

				<?php else : ?>

					<?php get_template_part( 'template-parts/no-results' ); ?>

				<?php endif; ?>

			</div>

			<?php if ( $has_sidebar ) : ?>
                <?php
					get_sidebar(
						null,
						array(
							'sidebar_id'    => 'kai-archive-sidebar',
							'sidebar_class' => 'kai-archive-sidebar',
							'sidebar_label' => esc_html__( 'Archive Sidebar', 'kai-upgrade-child' ),
						)
					);
				?>
            <?php endif; ?>

		</div>

	</div>

</main>

<?php

get_footer();