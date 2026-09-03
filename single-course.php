<?php
/**
 * Single course template for KAI Upgrade child theme.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="content" class="kai-single-course-main" role="main">

	<div class="kai-container">

		<div class="kai-layout kai-layout-no-sidebar">

			<div class="kai-content kai-course-content">

				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>

					<?php
					get_template_part(
						'template-parts/content',
						'single-course'
					);
					?>

				<?php endwhile; ?>

			</div>

		</div>

	</div>

</main>

<?php
get_footer();