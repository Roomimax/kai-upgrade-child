<?php
/**
 * Courses archive template.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$initial_limit = 8;
$category_ids = array( 38, 40, 46 );

$initial_courses = kai_get_courses_html(
	array(
		'search'        => '',
		'category'      => 'all',
		'limit'         => $initial_limit,
		'main_term_ids' => $category_ids,
		'return_data'   => true,
	)
);
?>

<main id="content" class="kai-site-main kai-archive kai-courses-archive" role="main">

	<div class="kai-container">

		<header class="kai-archive-header kai-courses-archive__header">
			<h1 class="kai-title kai-archive-title">
				<?php esc_html_e( 'Course сatalog', 'kai-upgrade-child' ); ?>
			</h1>
		</header>

		<div
			class="kai-courses-block kai-courses-archive__block"
			data-limit="<?php echo esc_attr( $initial_limit ); ?>"
			data-main-term-ids="<?php echo esc_attr( implode( ',', $category_ids ) ); ?>"
		>

			<div class="kai-courses-filter">

				<div class="kai-courses-search">
					<span class="kai-courses-search__icon" aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M17.5005 17.5L13.8838 13.8833" stroke="#6B7280" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M9.16667 15.8333C12.8486 15.8333 15.8333 12.8486 15.8333 9.16667C15.8333 5.48477 12.8486 2.5 9.16667 2.5C5.48477 2.5 2.5 5.48477 2.5 9.16667C2.5 12.8486 5.48477 15.8333 9.16667 15.8333Z" stroke="#6B7280" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</span>

					<input
						type="search"
						class="kai-courses-search__input"
						placeholder="<?php echo esc_attr__( 'Search', 'kai-upgrade-child' ); ?>"
						aria-label="<?php echo esc_attr__( 'Search courses', 'kai-upgrade-child' ); ?>"
					>
				</div>

				<div class="kai-courses-categories" aria-label="<?php echo esc_attr__( 'Course categories', 'kai-upgrade-child' ); ?>">
					<button type="button" class="kai-btn kai-btn_light kai-btn_active kai-courses__btn" data-category="all">
						<?php esc_html_e( 'All', 'kai-upgrade-child' ); ?>
					</button>

					<?php foreach ( $category_ids as $category_id ) : ?>
						<?php
						$term = get_term( $category_id, 'course_category' );

						if ( ! $term || is_wp_error( $term ) ) {
							continue;
						}
						?>

						<button
							type="button"
							class="kai-btn kai-btn_light kai-courses__btn"
							data-category="<?php echo esc_attr( $term->term_id ); ?>"
						>
							<?php echo esc_html( $term->name ); ?>
						</button>
					<?php endforeach; ?>

					<button type="button" class="kai-btn kai-btn_light kai-courses__btn" data-category="other">
						<?php esc_html_e( 'Other', 'kai-upgrade-child' ); ?>
					</button>
				</div>

			</div>

			<div class="kai-courses-results" aria-live="polite">
				<?php echo $initial_courses['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>

			<div
				class="kai-courses-actions"
				<?php echo ! empty( $initial_courses['has_more'] ) ? '' : 'hidden="hidden"'; ?>
			>
				<button
					type="button"
					class="kai-btn kai-btn_light kai-courses-load-more"
					<?php echo ! empty( $initial_courses['has_more'] ) ? '' : 'hidden="hidden"'; ?>
				>
					<span class="kai-courses-load-more__text">
						<?php esc_html_e( 'Show more', 'kai-upgrade-child' ); ?>
					</span>

					<span class="kai-courses-load-more__icon" aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M10 4.16675V15.8334" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M15.8337 10.0001L10.0003 15.8334L4.16699 10.0001" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</span>

					<span class="kai-courses-load-more__loader" aria-hidden="true" hidden>
						<span class="spinner-border" role="status" aria-hidden="true"></span>
					</span>
				</button>
			</div>

		</div>

	</div>

</main>

<?php
get_footer();