<?php
/**
 * Template part for displaying post card.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_the_ID();
$day     = get_the_date( 'd', $post_id );
$month   = get_the_date( 'M', $post_id );
$tags    = get_the_tags( $post_id );
$excerpt = isset( $args['show_excerpt'] ) ? (bool) $args['show_excerpt'] : true;

$label = '';

if ( ! empty( $categories ) ) {
	$label = $categories[0]->name;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'kai-post' ); ?>>

	<a class="kai-post__date" href="<?php echo esc_url( get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ) ); ?>" aria-label="<?php echo esc_attr( get_the_date() ); ?>">
		<span class="kai-post__day">
			<?php echo esc_html( $day ); ?>
		</span>

		<span class="kai-post__month">
			<?php echo esc_html( mb_strtolower( $month ) ); ?>
		</span>
	</a>

	<div class="kai-post__content">

		<?php if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) : ?>
			<div class="kai-post__tags">

				<?php foreach ( $tags as $tag ) : ?>
					<?php
					$tag_class = get_field( 'tag_class', 'post_tag_' . $tag->term_id );

					$tag_classes = array(
						'kai-tag',
						'kai-post__tag',
						'kai-tag_sm',
					);

					if ( ! empty( $tag_class ) ) {
						$tag_classes[] = sanitize_html_class( $tag_class );
					}
					?>

					<a
						class="<?php echo esc_attr( implode( ' ', $tag_classes ) ); ?>"
						href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
					>
						<?php echo esc_html( $tag->name ); ?>
					</a>
				<?php endforeach; ?>

			</div>
		<?php endif; ?>

		<h2 class="kai-post__title">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h2>

		<?php if ( $excerpt ) : ?>
			<div class="kai-post__excerpt">
				<?php echo esc_html( wp_trim_words( get_the_excerpt(), 24, '...' ) ); ?>
			</div>
		<?php endif; ?>

		<a class="kai-post__more" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'More', 'kai-upgrade-child' ); ?>
			<span aria-hidden="true">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
					<path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M12 5L19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</span>
		</a>

	</div>

	<a class="kai-post__image" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>

			<?php the_post_thumbnail(); ?>

		<?php else : ?>

			<img
				src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/kai.jpg' ); ?>"
				alt="<?php the_title_attribute(); ?>"
				loading="lazy"
			>

		<?php endif; ?>

		<svg class="kai-post__arrow" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
			<rect x="0.5" y="0.5" width="43" height="43" rx="21.5" fill="white"/>
			<rect x="0.5" y="0.5" width="43" height="43" rx="21.5" stroke="#E5E7EB"/>
			<path d="M15 22H29" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M22 15L29 22L22 29" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
	</a>

</article>