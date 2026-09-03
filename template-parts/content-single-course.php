<?php
/**
 * Template part for displaying a single course.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<article
	id="post-<?php the_ID(); ?>"
	<?php post_class( 'kai-single-course' ); ?>
>

	<?php if ( has_post_thumbnail() ) : ?>

		<figure class="kai-single-course__thumbnail">

			<?php
			the_post_thumbnail(
				'full',
				array(
					'class'   => 'kai-single-course__image',
					'loading' => 'eager',
				)
			);
			?>

		</figure>

	<?php endif; ?>

	<div class="kai-single-course__content">
		<?php the_content(); ?>
	</div>

</article>