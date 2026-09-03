<?php
/**
 * Single post template for KAI Upgrade child theme.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$sidebar_id  = 'kai-post-sidebar';
$has_sidebar = is_active_sidebar( $sidebar_id );
?>

<main id="content" class="kai-site-main kai-single-main" role="main">

	<div class="kai-container">

		<div class="kai-layout <?php echo $has_sidebar ? 'kai-layout-sidebar' : 'kai-layout-no-sidebar'; ?>">

			<div class="kai-content">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : ?>
						<?php the_post(); ?>

						<?php
						get_template_part( 'template-parts/content', 'single' ); ?>

                        <?php
                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        }
                        ?>

					<?php endwhile; ?>

				<?php endif; ?>

			</div>

			<?php if ( $has_sidebar ) : ?>

				<?php
				get_sidebar(
					null,
					array(
						'sidebar_id'    => $sidebar_id,
						'sidebar_class' => 'kai-post-sidebar',
						'sidebar_label' => esc_html__( 'Post Sidebar', 'kai-upgrade-child' ),
					)
				);
				?>

			<?php endif; ?>

		</div>

	</div>

</main>

<?php
get_footer();