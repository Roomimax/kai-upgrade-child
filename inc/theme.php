<?php
/**
 * Sort Events category archives by custom date meta field.
 */
add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		if ( ! $query->is_category( array( 19, 21 ) ) ) {
			return;
		}

		$query->set( 'meta_key', 'date' );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'order', 'DESC' );
	}
);

/**
 * Shortcode for displaying KAI posts or events.
 *
 * Usage:
 * [kai_posts]
 * [kai_posts type="posts"]
 * [kai_posts type="events"]
 * [kai_posts type="posts" category_id="19"]
 * [kai_posts type="events" category_id="19,21"]
 * [kai_posts type="events" posts_per_page="4"]
 * [kai_posts type="posts" tag="aviation"]
 */
function kai_upgrade_posts_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'type'           => 'posts',
			'posts_per_page' => 3,
			'category_id'    => '',
			'tag'            => '',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'display_order'  => '',
			'excerpt'   	 => 'yes',
			'class'          => '',
		),
		$atts,
		'kai_posts'
	);

	$type = sanitize_key( $atts['type'] );

	$allowed_types = array(
		'posts',
		'events',
	);

	if ( ! in_array( $type, $allowed_types, true ) ) {
		$type = 'posts';
	}

	$posts_per_page = absint( $atts['posts_per_page'] );

	if ( 0 === $posts_per_page ) {
		$posts_per_page = 3;
	}

	$allowed_orderby = array(
		'date',
		'title',
		'menu_order',
		'rand',
		'modified',
		'meta_value',
		'meta_value_num',
	);

	$orderby = in_array( $atts['orderby'], $allowed_orderby, true ) ? $atts['orderby'] : 'date';

	$order = strtoupper( $atts['order'] );

	if ( ! in_array( $order, array( 'ASC', 'DESC' ), true ) ) {
		$order = 'DESC';
	}

	$display_order = sanitize_key( $atts['display_order'] );

	$show_excerpt = strtolower( trim( $atts['excerpt'] ) );

	$show_excerpt = ! in_array(
		$show_excerpt,
		array( 'no', 'false', '0', 'off' ),
		true
	);

	if ( ! in_array( $display_order, array( 'asc', 'desc' ), true ) ) {
		$display_order = '';
	}

	$query_args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $posts_per_page,
		'orderby'             => $orderby,
		'order'               => $order,
		'ignore_sticky_posts' => true,
	);

	/*
	* If the shortcode is displayed on a single post page,
	* exclude the current post from the results.
	*/
	if ( is_singular( 'post' ) ) {
		$current_post_id = get_queried_object_id();

		if ( $current_post_id ) {
			$query_args['post__not_in'] = array( $current_post_id );
		}
	}

	/*
	 * Default categories by type.
	 * category_id 19, 21.
	 */
	if ( empty( $atts['category_id'] ) && 'events' === $type ) {
		$atts['category_id'] = '19,21';
	}

	if ( ! empty( $atts['category_id'] ) ) {
		$category_ids = array_filter(
			array_map(
				'absint',
				explode( ',', $atts['category_id'] )
			)
		);

		if ( ! empty( $category_ids ) ) {
			$query_args['category__in'] = $category_ids;
		}
	}

	if ( ! empty( $atts['tag'] ) ) {
		$query_args['tag'] = sanitize_text_field( $atts['tag'] );
	}

	/*
	 * Sorting for events by custom date meta field.
	 * Використовуємо те саме поле, що і в pre_get_posts: date.
	 */
	if ( 'events' === $type ) {
		$query_args['meta_key'] = 'date';
		$query_args['orderby']  = 'meta_value_num';
		$query_args['order']    = 'DESC';
	}

	$posts_query = new WP_Query( $query_args );

	$wrapper_classes = array(
		'kai-posts-shortcode',
		'kai-posts-shortcode-' . $type,
	);

	$list_classes = array(
		'kai-posts',
	);

	if ( 'events' === $type ) {
		$list_classes[] = 'kai-events';
	}

	if ( ! empty( $atts['class'] ) ) {
		$custom_classes = preg_split( '/\s+/', $atts['class'] );

		foreach ( $custom_classes as $custom_class ) {
			$custom_class = sanitize_html_class( $custom_class );

			if ( ! empty( $custom_class ) ) {
				$wrapper_classes[] = $custom_class;
			}
		}
	}

	ob_start();

	if ( $posts_query->have_posts() ) :
		?>

		<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>">
			<div class="<?php echo esc_attr( implode( ' ', $list_classes ) ); ?>">
				<?php
				$shortcode_posts = $posts_query->posts;

				if ( 'asc' === $display_order ) {
					$shortcode_posts = array_reverse( $shortcode_posts );
				}

				global $post;

				foreach ( $shortcode_posts as $shortcode_post ) :
					$post = $shortcode_post;
					setup_postdata( $post );

					$template_args = array(
						'show_excerpt' => $show_excerpt,
					);

					if ( 'events' === $type ) {
						get_template_part(
							'template-parts/event',
							null,
							$template_args
						);
					} else {
						get_template_part(
							'template-parts/post',
							null,
							$template_args
						);
					}

				endforeach;
				?>
			</div>
		</div>

		<?php
	else :
		?>

		<div class="kai-empty-state">
			<h2><?php esc_html_e( 'Записів не знайдено', 'kai-upgrade-child' ); ?></h2>
			<p><?php esc_html_e( 'Наразі немає записів для відображення.', 'kai-upgrade-child' ); ?></p>
		</div>

		<?php
	endif;

	wp_reset_postdata();

	return ob_get_clean();
}

add_shortcode( 'kai_posts', 'kai_upgrade_posts_shortcode' );