<?php

/**
 * Add color box to Post and Page edit screens.
 */
add_action( 'add_meta_boxes', 'page_color_add_meta_box' );
function page_color_add_meta_box() {
	add_meta_box( 'myplugin_sectionid', 'Hintergrundfarbe für Startseiten-Block', 'color_meta_box', null, 'side' );
}



/**
 * Box markup.
 */
function color_meta_box( $post ) {
	wp_nonce_field( '_page_color_save_meta_box', 'color_meta_box_nonce' );

	$value = get_post_meta( $post->ID, '_page_color', true );
	$colors = array(
		'color1' => 'transparent',
		'color2' => 'schwarz',
		'color3' => 'gelb',
		'color4' => 'hellgrau'
	);?>
	<label for="page-color">Farbe</label>

	<select name="page_color" id="page-color" class="<?php echo $value ?>"
	        onchange="this.setAttribute( 'class', this.value )">
		<?php foreach ( $colors as $color => $label ) : ?>
			<option class="<?php echo $color; ?>" value="<?php echo $color; ?>"
				<?php selected( $value, $color ); ?>><?php echo $label; ?></option>
		<?php endforeach; ?>
	</select>
<?php }

/**
 * ...
 */
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );
function load_custom_wp_admin_style() {
	wp_enqueue_style( 'custom_wp_admin_css', get_template_directory_uri() . '/css/admin-style.css' );
}

/**
 * ...
 */
add_action( 'save_post', '_page_color_save_meta_box' );
function _page_color_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['color_meta_box_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['color_meta_box_nonce'], '_page_color_save_meta_box' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	if ( ! isset( $_POST['page_color'] ) ) {
		return;
	}

	$color = sanitize_text_field( $_POST['page_color'] );

	update_post_meta( $post_id, '_page_color', $color );
}


add_filter('manage_pages_columns', 'my_columns');
function my_columns($columns) {
	$columns['order'] 			= 'Reihenfolge';
	$columns['page_color'] 	= 'Farbe';
	return $columns;
}

add_action('manage_pages_custom_column',  'my_show_columns');
function my_show_columns($name) {
	global $post;
	switch ($name) {
		case 'order':
			$views = $post->menu_order;
			echo $views;
		}
}
add_action('manage_pages_custom_column',  'my_show_color');
function my_show_color($name) {
	global $post;
	switch ($name) {
		case 'page_color':
			$color = get_post_meta($post->ID, '_page_color', true);

			$colors = array(
				'color1' => 'transp.',
				'color2' => 'schwarz',
				'color3' => 'gelb',
				'color4' => 'hellgrau'
			);

			echo $colors[$color];
	}
}
