<?php
/**
 * Template part for displaying a single post.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id    = get_the_ID();
$categories = get_the_category( $post_id );
$tags       = get_the_tags( $post_id );

$has_categories = ! empty( $categories );
$has_tags       = ! empty( $tags ) && ! is_wp_error( $tags );

$is_event = has_category( array( 19, 21 ), $post_id );

$display_date  = get_the_date();
$datetime_date = get_the_date( DATE_W3C );

if ( $is_event && function_exists( 'get_field' ) ) {
	$event_date_raw = get_field( 'date', $post_id );

	if ( ! empty( $event_date_raw ) ) {
		$event_date = DateTimeImmutable::createFromFormat(
			'!Ymd',
			$event_date_raw,
			wp_timezone()
		);

		if ( $event_date instanceof DateTimeImmutable ) {
			$display_date = wp_date(
				get_option( 'date_format' ),
				$event_date->getTimestamp(),
				wp_timezone()
			);

			$datetime_date = $event_date->format( 'Y-m-d' );
		}
	}
}

$show_featured_image = true;

if ( function_exists( 'get_field' ) ) {
	$featured_image_field = get_field(
		'show_featured_image',
		$post_id
	);

	if ( null !== $featured_image_field ) {
		$show_featured_image = (bool) $featured_image_field;
	}
}
?>

<article
	id="post-<?php the_ID(); ?>"
	<?php post_class( 'kai-single-post' ); ?>
>

	<header class="kai-single-header">

		<?php if ( $has_categories || $has_tags ) : ?>

			<div class="kai-single-taxonomies">

				<?php if ( $has_categories ) : ?>

					<div class="kai-single-categories">

						<?php foreach ( $categories as $category ) : ?>

							<a
								class="kai-tag kai-tag_lg"
								href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"
							>
								<?php echo esc_html( $category->name ); ?>
							</a>

						<?php endforeach; ?>

					</div>

				<?php endif; ?>

				<?php if ( $has_categories && $has_tags ) : ?>

					<span
						class="kai-single-taxonomies__separator"
						aria-hidden="true"
					>
						/
					</span>

				<?php endif; ?>

				<?php if ( $has_tags ) : ?>

					<div class="kai-post__tags">

						<?php foreach ( $tags as $tag ) : ?>

							<?php
							$tag_class = '';

							if ( function_exists( 'get_field' ) ) {
								$tag_class = get_field(
									'tag_class',
									'post_tag_' . $tag->term_id
								);
							}

							$tag_classes = array(
								'kai-tag',
								'kai-post__tag',
								'kai-tag_sm',
							);

							if ( ! empty( $tag_class ) ) {
								$tag_classes[] = sanitize_html_class(
									$tag_class
								);
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

			</div>

		<?php endif; ?>

		<div class="kai-single-meta">

			<time
				class="kai-single-date"
				datetime="<?php echo esc_attr( $datetime_date ); ?>"
			>
				<i
					class="far fa-calendar-alt"
					aria-hidden="true"
				></i>

				<?php echo esc_html( $display_date ); ?>
			</time>

		</div>

		<h1 class="kai-title kai-single-title">
			<?php the_title(); ?>
		</h1>

	</header>

	<?php if ( $show_featured_image && has_post_thumbnail() ) : ?>

		<figure class="kai-single-thumbnail">

			<?php
			the_post_thumbnail(
				'full',
				array(
					'class'   => 'kai-single-thumbnail__image',
					'loading' => 'eager',
				)
			);
			?>

		</figure>

	<?php endif; ?>

	<div class="kai-single-content">
		<?php the_content(); ?>
	</div>

</article>