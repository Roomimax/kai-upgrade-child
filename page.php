<?php
/**
 * Page template for KAI Upgrade child theme.
 *
 * Displays regular WordPress pages.
 *
 * @package KAI_Upgrade
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$has_sidebar = is_active_sidebar( 'kai-page-sidebar' );

$page_classes = array(
	'kai-site-main',
	'kai-page-main',
);

if ( is_front_page() ) {
	$page_classes[] = 'kai-front-page';
} else {
	$page_classes[] = 'kai-regular-page';
}
?>

<main id="content" class="<?php echo esc_attr( implode( ' ', $page_classes ) ); ?>" role="main">

    <?php while ( have_posts() ) : the_post(); ?>

        <div class="kai-container">

            <header class="kai-page-header">

                <h1 class="kai-title kai-page-title">
                    <?php the_title(); ?>
                </h1>

            </header>

            <div class="kai-layout <?php echo $has_sidebar ? 'kai-layout-sidebar' : 'kai-layout-no-sidebar'; ?>">

                <div class="kai-content">

                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'kai-page kai-page-default' ); ?>>

                        <div class="kai-page-content">

                            <?php the_content(); ?>

                        </div>

                    </article>

                </div>

                <?php if ( $has_sidebar ) : ?>
                    <?php
                        get_sidebar(
                            null,
                            array(
                                'sidebar_id'    => 'kai-page-sidebar',
                                'sidebar_class' => 'kai-page-sidebar',
                                'sidebar_label' => esc_html__( 'Page Sidebar', 'kai-upgrade-child' ),
                            )
                        );
                    ?>
                <?php endif; ?>

            </div>

        </div>

	<?php endwhile; ?>

</main>

<?php
get_footer();