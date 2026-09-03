<?php
/**
 * Template part for displaying event card.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_the_ID();

$event_date = function_exists( 'get_field' ) ? get_field( 'date', $post_id ) : get_post_meta( $post_id, 'date', true );
$event_info = function_exists( 'get_field' ) ? get_field( 'info', $post_id ) : get_post_meta( $post_id, 'info', true );

$excerpt = isset( $args['show_excerpt'] ) ? (bool) $args['show_excerpt'] : true;

$date_label = '';
$date_attr  = '';

if ( ! empty( $event_date ) ) {
	$date_string = (string) $event_date;

	if ( preg_match( '/^\d{8}$/', $date_string ) ) {
		$date_object = DateTime::createFromFormat( 'Ymd', $date_string );
	} elseif ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date_string ) ) {
		$date_object = DateTime::createFromFormat( 'Y-m-d', $date_string );
	} elseif ( preg_match( '/^\d{2}\/\d{2}\/\d{4}$/', $date_string ) ) {
		$date_object = DateTime::createFromFormat( 'd/m/Y', $date_string );
	} else {
		$date_object = false;
	}

	if ( $date_object ) {
		$timestamp  = $date_object->getTimestamp();
		$date_label = date_i18n( 'j F Y', $timestamp );
		$date_attr  = wp_date( 'Y-m-d', $timestamp );
	} else {
		$date_label = $date_string;
	}
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'kai-event' ); ?>>

	<div class="kai-event__content">

		<?php if ( ! empty( $date_label ) ) : ?>
			<div class="kai-event__date">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.66699 1.6665V4.99984" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13.333 1.6665V4.99984" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15.8333 3.3335H4.16667C3.24619 3.3335 2.5 4.07969 2.5 5.00016V16.6668C2.5 17.5873 3.24619 18.3335 4.16667 18.3335H15.8333C16.7538 18.3335 17.5 17.5873 17.5 16.6668V5.00016C17.5 4.07969 16.7538 3.3335 15.8333 3.3335Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2.5 8.3335H17.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.66699 11.6665H6.67533" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 11.6665H10.0083" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13.333 11.6665H13.3413" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.66699 15H6.67533" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 15H10.0083" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13.333 15H13.3413" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

				<?php if ( ! empty( $date_attr ) ) : ?>
					<time datetime="<?php echo esc_attr( $date_attr ); ?>">
						<?php echo esc_html( $date_label ); ?>
					</time>
				<?php else : ?>
					<span><?php echo esc_html( $date_label ); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<h2 class="kai-event__title">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h2>

		<?php if ( has_excerpt() && $excerpt ) : ?>
			<div class="kai-event__excerpt">
				<?php echo esc_html( wp_trim_words( get_the_excerpt(), 24, '...' ) ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $event_info ) ) : ?>
			<div class="kai-event__info">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.6663 8.33317C16.6663 12.494 12.0505 16.8273 10.5005 18.1657C10.3561 18.2742 10.1803 18.333 9.99967 18.333C9.81901 18.333 9.64324 18.2742 9.49884 18.1657C7.94884 16.8273 3.33301 12.494 3.33301 8.33317C3.33301 6.56506 4.03539 4.86937 5.28563 3.61913C6.53587 2.36888 8.23156 1.6665 9.99967 1.6665C11.7678 1.6665 13.4635 2.36888 14.7137 3.61913C15.964 4.86937 16.6663 6.56506 16.6663 8.33317Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 10.8335C11.3807 10.8335 12.5 9.71421 12.5 8.3335C12.5 6.95278 11.3807 5.8335 10 5.8335C8.61929 5.8335 7.5 6.95278 7.5 8.3335C7.5 9.71421 8.61929 10.8335 10 10.8335Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

				<span>
					<?php echo esc_html( $event_info ); ?>
				</span>
			</div>
		<?php endif; ?>

	</div>

	<?php if ( has_post_thumbnail() ) : ?>
		<a class="kai-event__image" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail(); ?>

			<svg class="kai-event__arrow" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
				<rect x="0.5" y="0.5" width="43" height="43" rx="21.5" fill="white"/>
				<rect x="0.5" y="0.5" width="43" height="43" rx="21.5" stroke="#E5E7EB"/>
				<path d="M15 22H29" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M22 15L29 22L22 29" stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</a>
	<?php endif; ?>

</article>