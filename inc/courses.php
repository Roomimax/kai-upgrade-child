<?php
/**
 * Courses CPT
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom post type: Course
 */
function kai_register_course_post_type() {

	$labels = array(
		'name'               => __('Courses', 'kai-upgrade-child'),
		'singular_name'      => __('Course', 'kai-upgrade-child'),
		'menu_name'          => __('Courses', 'kai-upgrade-child'),
		'name_admin_bar'     => __('Course', 'kai-upgrade-child'),
		'add_new'            => __('Add course', 'kai-upgrade-child'),
		'add_new_item'       => __('Add new course', 'kai-upgrade-child'),
		'new_item'           => __('New course', 'kai-upgrade-child'),
		'edit_item'          => __('Edit course', 'kai-upgrade-child'),
		'view_item'          => __('Show course', 'kai-upgrade-child'),
		'all_items'          => __('All courses', 'kai-upgrade-child'),
		'search_items'       => __('Search for courses', 'kai-upgrade-child'),
		'not_found'          => __('No courses found', 'kai-upgrade-child'),
		'not_found_in_trash' => __('No courses found in the trash', 'kai-upgrade-child'),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-welcome-learn-more',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'courses' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
		'show_in_rest'       => true,
	);

	register_post_type( 'course', $args );
}

add_action( 'init', 'kai_register_course_post_type' );

/**
 * Register taxonomy: Course categories
 */
function kai_register_course_category_taxonomy() {

	$labels = array(
		'name'              => __('Course categories', 'kai-upgrade-child'),
		'singular_name'     => __('Course category', 'kai-upgrade-child'),
		'search_items'      => __('Search categories', 'kai-upgrade-child'),
		'all_items'         => __('All categories', 'kai-upgrade-child'),
		'parent_item'       => __('Parent category', 'kai-upgrade-child'),
		'parent_item_colon' => __('Parent category', 'kai-upgrade-child'),
		'edit_item'         => __('Edit category', 'kai-upgrade-child'),
		'update_item'       => __('Update category', 'kai-upgrade-child'),
		'add_new_item'      => __('Add category', 'kai-upgrade-child'),
		'new_item_name'     => __('Name of the new category', 'kai-upgrade-child'),
		'menu_name'         => __('Categories', 'kai-upgrade-child'),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'course-category' ),
		'show_in_rest'      => true,
	);

	register_taxonomy( 'course_category', array( 'course' ), $args );
}

add_action( 'init', 'kai_register_course_category_taxonomy' );

/**
 * Register taxonomy: Course format
 */
function kai_register_course_format_taxonomy() {

	$labels = array(
		'name'              => __('Learning formats', 'kai-upgrade-child'),
		'singular_name'     => __('Learning format', 'kai-upgrade-child'),
		'search_items'      => __('Search for formats', 'kai-upgrade-child'),
		'all_items'         => __('All formats', 'kai-upgrade-child'),
		'parent_item'       => __('Parental format', 'kai-upgrade-child'),
		'parent_item_colon' => __('Parental format', 'kai-upgrade-child'),
		'edit_item'         => __('Edit format', 'kai-upgrade-child'),
		'update_item'       => __('Update format', 'kai-upgrade-child'),
		'add_new_item'      => __('Add format', 'kai-upgrade-child'),
		'new_item_name'     => __('Name of the new format', 'kai-upgrade-child'),
		'menu_name'         => __('Formats', 'kai-upgrade-child'),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'course-format' ),
		'show_in_rest'      => true,
	);

	register_taxonomy( 'course_format', array( 'course' ), $args );
}

add_action( 'init', 'kai_register_course_format_taxonomy' );

/**
 * Register taxonomy: Course organizer
 */
function kai_register_course_organizer_taxonomy() {

	$labels = array(
		'name'              => __('Organizers', 'kai-upgrade-child'),
		'singular_name'     => __('Organizer', 'kai-upgrade-child'),
		'search_items'      => __('Search organizers', 'kai-upgrade-child'),
		'all_items'         => __('All organizers', 'kai-upgrade-child'),
		'parent_item'       => __('Parent organizer', 'kai-upgrade-child'),
		'parent_item_colon' => __('Parent organizer', 'kai-upgrade-child'),
		'edit_item'         => __('Edit organizer', 'kai-upgrade-child'),
		'update_item'       => __('Update organizer', 'kai-upgrade-child'),
		'add_new_item'      => __('Add organizer', 'kai-upgrade-child'),
		'new_item_name'     => __('Name of the new organizer', 'kai-upgrade-child'),
		'menu_name'         => __('Organizers', 'kai-upgrade-child'),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'course-organizer' ),
		'show_in_rest'      => true,
	);

	register_taxonomy( 'course_organizer', array( 'course' ), $args );
}

add_action( 'init', 'kai_register_course_organizer_taxonomy' );

/**
 * Add course meta box
 */
function kai_add_course_meta_box() {
	add_meta_box(
		'kai_course_meta_box',
		__('Course Information', 'kai-upgrade-child'),
		'kai_render_course_meta_box',
		'course',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'kai_add_course_meta_box' );

/**
 * Render course meta box
 */
function kai_render_course_meta_box( $post ) {

	wp_nonce_field( 'kai_save_course_meta', 'kai_course_meta_nonce' );

	$is_popular        = get_post_meta( $post->ID, '_kai_course_popular', true );
    $hours             = get_post_meta( $post->ID, '_kai_course_hours', true );
    $price             = get_post_meta( $post->ID, '_kai_course_price', true );
    $short_description = get_post_meta( $post->ID, '_kai_course_short_description', true );
	?>

	<p>
		<label>
			<input
				type="checkbox"
				name="kai_course_popular"
				value="1"
				<?php checked( $is_popular, '1' ); ?>
			>
			<?php _e('Popular', 'kai-upgrade-child') ?>
		</label>
	</p>

    <div style="margin: 20px 0;">
        <label for="kai_course_short_description">
            <strong><?php _e( 'Short description', 'kai-upgrade-child' ); ?></strong>
        </label>

        <?php
        wp_editor(
            $short_description,
            'kai_course_short_description',
            array(
                'textarea_name' => 'kai_course_short_description',
                'textarea_rows' => 6,
                'media_buttons' => false,
                'teeny'         => true,
                'quicktags'     => true,
            )
        );
        ?>
    </div>

	<p>
		<label for="kai_course_hours"><?php _e('Number of hours', 'kai-upgrade-child') ?></label><br>
		<input
			type="number"
			id="kai_course_hours"
			name="kai_course_hours"
			value="<?php echo esc_attr( $hours ); ?>"
			min="0"
			style="width: 100%; max-width: 300px;"
		>
	</p>

	<p>
		<label for="kai_course_price"><?php _e('Price', 'kai-upgrade-child') ?></label><br>
		<input
			type="text"
			id="kai_course_price"
			name="kai_course_price"
			value="<?php echo esc_attr( $price ); ?>"
			style="width: 100%; max-width: 300px;"
		>
	</p>

	<?php
}

/**
 * Save course meta fields
 */
function kai_save_course_meta( $post_id ) {

	if ( ! isset( $_POST['kai_course_meta_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['kai_course_meta_nonce'], 'kai_save_course_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$is_popular = isset( $_POST['kai_course_popular'] ) ? '1' : '0';
	update_post_meta( $post_id, '_kai_course_popular', $is_popular );

    if ( isset( $_POST['kai_course_short_description'] ) ) {
        update_post_meta(
            $post_id,
            '_kai_course_short_description',
            wp_kses_post( $_POST['kai_course_short_description'] )
        );
    }

	if ( isset( $_POST['kai_course_hours'] ) ) {
		update_post_meta(
			$post_id,
			'_kai_course_hours',
			sanitize_text_field( $_POST['kai_course_hours'] )
		);
	}

	if ( isset( $_POST['kai_course_price'] ) ) {
		update_post_meta(
			$post_id,
			'_kai_course_price',
			sanitize_text_field( $_POST['kai_course_price'] )
		);
	}
}
add_action( 'save_post_course', 'kai_save_course_meta' );

/**
 * Add CSS class field to course category add form.
 */
function kai_course_category_add_class_field() {
	?>
	<div class="form-field term-class-wrap">
		<label for="kai_course_category_class">
			<?php esc_html_e( 'CSS class', 'kai-upgrade-child' ); ?>
		</label>

		<input
			type="text"
			name="kai_course_category_class"
			id="kai_course_category_class"
			value=""
			placeholder="kai-tag_success"
		>

		<p>
			<?php esc_html_e( 'Add a CSS class for this course category badge.', 'kai-upgrade-child' ); ?>
		</p>
	</div>
	<?php
}

add_action( 'course_category_add_form_fields', 'kai_course_category_add_class_field' );

/**
 * Add CSS class field to course category edit form.
 */
function kai_course_category_edit_class_field( $term ) {

	$class = get_term_meta( $term->term_id, '_kai_course_category_class', true );
	?>

	<tr class="form-field term-class-wrap">
		<th scope="row">
			<label for="kai_course_category_class">
				<?php esc_html_e( 'CSS class', 'kai-upgrade-child' ); ?>
			</label>
		</th>

		<td>
			<input
				type="text"
				name="kai_course_category_class"
				id="kai_course_category_class"
				value="<?php echo esc_attr( $class ); ?>"
				placeholder="kai-tag_success"
			>

			<p class="description">
				<?php esc_html_e( 'Add a CSS class for this course category badge.', 'kai-upgrade-child' ); ?>
			</p>
		</td>
	</tr>

	<?php
}

add_action( 'course_category_edit_form_fields', 'kai_course_category_edit_class_field' );

/**
 * Save course category CSS class.
 */
function kai_save_course_category_class_field( $term_id ) {

	if ( ! isset( $_POST['kai_course_category_class'] ) ) {
		return;
	}

	$class = sanitize_html_class( wp_unslash( $_POST['kai_course_category_class'] ) );

	update_term_meta(
		$term_id,
		'_kai_course_category_class',
		$class
	);
}

add_action( 'created_course_category', 'kai_save_course_category_class_field' );
add_action( 'edited_course_category', 'kai_save_course_category_class_field' );

/**
 * Add color field to course format taxonomy add form.
 */
function kai_course_format_add_color_field() {
	?>
	<div class="form-field term-color-wrap">
		<label for="kai_course_format_color">
			<?php esc_html_e( 'Format color', 'kai-upgrade-child' ); ?>
		</label>

		<input
			type="color"
			name="kai_course_format_color"
			id="kai_course_format_color"
			value="#267ceb"
		>

		<p>
			<?php esc_html_e( 'Select the color for this learning format badge.', 'kai-upgrade-child' ); ?>
		</p>
	</div>
	<?php
}
add_action( 'course_format_add_form_fields', 'kai_course_format_add_color_field' );

/**
 * Add color field to course format taxonomy edit form.
 */
function kai_course_format_edit_color_field( $term ) {

	$color = get_term_meta( $term->term_id, '_kai_course_format_color', true );

	if ( empty( $color ) ) {
		$color = '#267ceb';
	}
	?>

	<tr class="form-field term-color-wrap">
		<th scope="row">
			<label for="kai_course_format_color">
				<?php esc_html_e( 'Format color', 'kai-upgrade-child' ); ?>
			</label>
		</th>

		<td>
			<input
				type="color"
				name="kai_course_format_color"
				id="kai_course_format_color"
				value="<?php echo esc_attr( $color ); ?>"
			>

			<p class="description">
				<?php esc_html_e( 'Select the color for this learning format badge.', 'kai-upgrade-child' ); ?>
			</p>
		</td>
	</tr>

	<?php
}
add_action( 'course_format_edit_form_fields', 'kai_course_format_edit_color_field' );

/**
 * Save course format color.
 */
function kai_save_course_format_color_field( $term_id ) {

	if ( ! isset( $_POST['kai_course_format_color'] ) ) {
		return;
	}

	$color = sanitize_hex_color( wp_unslash( $_POST['kai_course_format_color'] ) );

	if ( empty( $color ) ) {
		$color = '#267ceb';
	}

	update_term_meta(
		$term_id,
		'_kai_course_format_color',
		$color
	);
}
add_action( 'created_course_format', 'kai_save_course_format_color_field' );
add_action( 'edited_course_format', 'kai_save_course_format_color_field' );


/**
 * Shortcode: Courses block
 *
 * Usage:
 * [kai_courses ids="12,13,14" catalog_url="/courses/" limit="8"]
 */
function kai_courses_block ( $atts ) {

	$atts = shortcode_atts(
		array(
			'limit'       => 8,
			'ids'         => '',
			'load_more'   => 'false',
		),
		$atts,
		'kai_courses_block'
	);

	$block_id = 'kai-courses-block-' . wp_rand( 1000, 9999 );
	$category_ids = kai_parse_course_category_ids( $atts['ids'] );
	$show_load_more = filter_var( $atts['load_more'], FILTER_VALIDATE_BOOLEAN );

	$initial_courses = kai_get_courses_html(
		array(
			'search'        => '',
			'category'      => 'all',
			'limit'         => $atts['limit'],
			'main_term_ids' => $category_ids,
			'return_data'   => true,
		)
	);

	ob_start();
	?>

	<div
		id="<?php echo esc_attr( $block_id ); ?>"
		class="kai-courses-block"
		data-limit="<?php echo esc_attr( $atts['limit'] ); ?>"
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

			<div class="kai-courses-categories">
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

		<div class="kai-courses-results">
			<?php echo $initial_courses['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>

		<?php if ( $show_load_more ) : ?>
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
						<?php esc_html_e( 'Show more programs', 'kai-upgrade-child' ); ?>
					</span>

					<span class="kai-courses-load-more__icon" aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M10 4.16675V15.8334" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M15.8337 10.0001L10.0003 15.8334L4.16699 10.0001" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</span>
				</button>
			</div>
		<?php endif; ?>

	</div>

	<?php
	return ob_get_clean();
}

add_shortcode( 'kai_courses', 'kai_courses_block' );

/**
 * Parse category IDs
 */
function kai_parse_course_category_ids( $ids_string ) {

	if ( empty( $ids_string ) ) {
		return array();
	}

	$ids = explode( ',', $ids_string );
	$ids = array_map( 'trim', $ids );
	$ids = array_map( 'absint', $ids );
	$ids = array_filter( $ids );

	return array_values( $ids );
}

/**
 * Get courses HTML.
 */
function kai_get_courses_html( $args = array() ) {

	$defaults = array(
		'search'        => '',
		'category'      => 'all',
		'limit'         => 8,
		'main_term_ids' => array(),
		'return_data'   => false,
	);

	$args = wp_parse_args( $args, $defaults );

	$current_limit = absint( $args['limit'] );

	if ( $current_limit < 1 ) {
		$current_limit = 8;
	}

	$query_args = array(
		'post_type'      => 'course',
		'post_status'    => 'publish',
		'posts_per_page' => $current_limit,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( ! empty( $args['search'] ) ) {
		$query_args['s'] = sanitize_text_field( $args['search'] );
		add_filter( 'posts_search', 'kai_courses_search_by_title_only', 10, 2 );
	}

	if ( 'all' !== $args['category'] && 'other' !== $args['category'] ) {
		$category_id = absint( $args['category'] );

		if ( $category_id ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'course_category',
					'field'    => 'term_id',
					'terms'    => array( $category_id ),
				),
			);
		}
	}

	if ( 'other' === $args['category'] && ! empty( $args['main_term_ids'] ) ) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'course_category',
				'field'    => 'term_id',
				'terms'    => array_map( 'absint', $args['main_term_ids'] ),
				'operator' => 'NOT IN',
			),
		);
	}

	$query = new WP_Query( $query_args );

	if ( ! empty( $args['search'] ) ) {
		remove_filter( 'posts_search', 'kai_courses_search_by_title_only', 10 );
	}

	ob_start();

	if ( $query->have_posts() ) {
		echo '<div class="kai-courses-grid">';

		while ( $query->have_posts() ) {
			$query->the_post();

			kai_render_course_card( get_the_ID() );
		}

		echo '</div>';
	} else {
		echo '<div class="kai-courses-empty">';
		esc_html_e( 'No courses found.', 'kai-upgrade-child' );
		echo '</div>';
	}

	$html = ob_get_clean();

	$found_posts = (int) $query->found_posts;
	$has_more = $current_limit < $found_posts;

	wp_reset_postdata();

	if ( ! empty( $args['return_data'] ) ) {
		return array(
			'html'        => $html,
			'found_posts' => $found_posts,
			'has_more'    => $has_more,
			'limit'       => $current_limit,
		);
	}

	return $html;
}

/**
 * Render single course card.
 */
function kai_render_course_card( $post_id ) {

	$is_popular = get_post_meta( $post_id, '_kai_course_popular', true );
	$hours = get_post_meta( $post_id, '_kai_course_hours', true );
	$price = get_post_meta( $post_id, '_kai_course_price', true );
	$short_description = get_post_meta( $post_id, '_kai_course_short_description', true );

	$categories = get_the_terms( $post_id, 'course_category' );
	$formats    = get_the_terms( $post_id, 'course_format' );
	?>

	<a 
		href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" 
		class="kai-course-card kai-card"
		aria-label="<?php echo esc_attr( get_the_title( $post_id ) ); ?>"
	>
		<div class="kai-card__content kai-card__content_lg">
			<div class="kai-card__main">
				<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>

					<?php if ( '1' === $is_popular ) : ?>

						<div class="kai-card__tags kai-card__tags_first">

							<?php
							$primary_category = $categories[0];

							$category_class = get_term_meta(
								$primary_category->term_id,
								'_kai_course_category_class',
								true
							);

							$tag_classes = array( 'kai-tag', 'kai-card__tag', 'kai-tag_sm' );

							if ( ! empty( $category_class ) ) {
								$tag_classes[] = sanitize_html_class( $category_class );
							}
							?>

							<span class="<?php echo esc_attr( implode( ' ', $tag_classes ) ); ?>">
								<?php echo esc_html( $primary_category->name ); ?>
							</span>

							<span class="kai-tag kai-card__tag kai-tag_sm kai-tag_popular">
								<span class="kai-tag__icon" aria-hidden="true">
									<img 
										src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/fire.png' ); ?>" 
										alt=""
									>
								</span>
								<?php esc_html_e( 'Popular', 'kai-upgrade-child' ); ?>
							</span>

						</div>

						<?php if ( count( $categories ) > 1 ) : ?>
							<div class="kai-card__tags">

								<?php foreach ( array_slice( $categories, 1 ) as $category ) : ?>

									<?php
									$category_class = get_term_meta(
										$category->term_id,
										'_kai_course_category_class',
										true
									);

									$tag_classes = array( 'kai-tag', 'kai-card__tag', 'kai-tag_sm' );

									if ( ! empty( $category_class ) ) {
										$tag_classes[] = sanitize_html_class( $category_class );
									}
									?>

									<span class="<?php echo esc_attr( implode( ' ', $tag_classes ) ); ?>">
										<?php echo esc_html( $category->name ); ?>
									</span>

								<?php endforeach; ?>

							</div>
						<?php endif; ?>

					<?php else : ?>

						<div class="kai-card__tags">

							<?php foreach ( $categories as $category ) : ?>

								<?php
								$category_class = get_term_meta(
									$category->term_id,
									'_kai_course_category_class',
									true
								);

								$tag_classes = array( 'kai-tag', 'kai-card__tag', 'kai-tag_sm' );

								if ( ! empty( $category_class ) ) {
									$tag_classes[] = sanitize_html_class( $category_class );
								}
								?>

								<span class="<?php echo esc_attr( implode( ' ', $tag_classes ) ); ?>">
									<?php echo esc_html( $category->name ); ?>
								</span>

							<?php endforeach; ?>

						</div>

					<?php endif; ?>

				<?php elseif ( '1' === $is_popular ) : ?>

					<div class="kai-card__tags kai-card__tags_first">
						<span class="kai-tag kai-card__tag kai-tag_sm kai-tag_popular">
							<span class="kai-tag__icon" aria-hidden="true">
								<img 
									src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/fire.png' ); ?>" 
									alt=""
								>
							</span>
							<?php esc_html_e( 'Popular', 'kai-upgrade-child' ); ?>
						</span>
					</div>

				<?php endif; ?>

				<h3 class="kai-card__title">
					<?php echo esc_html( get_the_title( $post_id ) ); ?>
				</h3>

				<?php if ( ! empty( $short_description ) ) : ?>
					<div class="kai-card__text">
						<?php echo wp_kses_post( wpautop( $short_description ) ); ?>
					</div>
				<?php endif; ?>

			</div>

			<div class="kai-card__footer">

				<?php if ( ! empty( $formats ) && ! is_wp_error( $formats ) ) : ?>
					<div class="kai-card__format">
						<?php foreach ( $formats as $format ) : 

							$format_color = get_term_meta(
								$format->term_id,
								'_kai_course_format_color',
								true
							);

							if ( empty( $format_color ) ) {
								$format_color = '#3b82f6';
							}
						?>
							<span style="--kai-format-color: <?php echo esc_attr( $format_color ); ?>;" class="kai-tag kai-tag_sm kai-tag_format">
								<?php echo esc_html( $format->name ); ?>
							</span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

			
				<div class="kai-card__info">
					<?php if ( $hours ) : ?>
						<span class="kai-card__hours">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M10.0003 18.3334C14.6027 18.3334 18.3337 14.6025 18.3337 10.0001C18.3337 5.39771 14.6027 1.66675 10.0003 1.66675C5.39795 1.66675 1.66699 5.39771 1.66699 10.0001C1.66699 14.6025 5.39795 18.3334 10.0003 18.3334Z" stroke="#6B7280" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M10 5V10L13.3333 11.6667" stroke="#6B7280" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<?php echo esc_html( $hours ); ?> <?php esc_html_e( 'hours', 'kai-upgrade-child' ); ?>
						</span>
					<?php endif; ?>

					<?php if ( $price ) : ?>
						<span class="kai-card__price">
							<?php echo esc_html( $price ); ?>
						</span>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</a>

	<?php
}

/**
 * AJAX: Load courses
 */
function kai_ajax_load_courses() {

	check_ajax_referer( 'kai_courses_nonce', 'nonce' );

	$search = isset( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '';
	$category = isset( $_POST['category'] ) ? sanitize_text_field( wp_unslash( $_POST['category'] ) ) : 'all';
	$limit = isset( $_POST['limit'] ) ? absint( $_POST['limit'] ) : 8;
	$main_term_ids = array();

	if ( isset( $_POST['main_term_ids'] ) ) {
		$main_term_ids = kai_parse_course_category_ids(
			sanitize_text_field( wp_unslash( $_POST['main_term_ids'] ) )
		);
	}

	$result = kai_get_courses_html(
		array(
			'search'        => $search,
			'category'      => $category,
			'limit'         => $limit,
			'main_term_ids' => $main_term_ids,
			'return_data'   => true,
		)
	);

	wp_send_json_success(
		array(
			'html'        => $result['html'],
			'found_posts' => $result['found_posts'],
			'has_more'    => $result['has_more'],
			'limit'       => $result['limit'],
		)
	);
}

add_action( 'wp_ajax_kai_load_courses', 'kai_ajax_load_courses' );
add_action( 'wp_ajax_nopriv_kai_load_courses', 'kai_ajax_load_courses' );

/**
 * Search courses by title only.
 */
function kai_courses_search_by_title_only( $search, $wp_query ) {
	global $wpdb;

	if ( empty( $search ) || empty( $wp_query->query_vars['s'] ) ) {
		return $search;
	}

	$search_term = $wp_query->query_vars['s'];
	$like = '%' . $wpdb->esc_like( $search_term ) . '%';

	return $wpdb->prepare(
		" AND {$wpdb->posts}.post_title LIKE %s ",
		$like
	);
}