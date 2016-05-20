<?php
/**
 * Register Settings
 *
 * @copyright   Copyright (c) 2014, Alessandro Tesoro
 * @since       1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Get an option
 * @since 1.0.0
 */
function epm_get_option( $key = '', $default = false ) {
	global $epm_options;
	$value = ! empty( $epm_options[ $key ] ) ? $epm_options[ $key ] : $default;
	$value = apply_filters( 'epm_get_option', $value, $key, $default );
	return apply_filters( 'epm_get_option_' . $key, $value, $key, $default );
}

/**
 * Retrieve all plugin settings.
 * @since 1.0.0
 */
function epm_get_settings() {

	$settings = get_option( 'epm_settings' );

	if( empty( $settings ) ) {
		// Update old settings with new single option
		$general_settings = is_array( get_option( 'epm_settings_general' ) )    ? get_option( 'epm_settings_general' )  	: array();
		$settings = array_merge( $general_settings);
		update_option( 'epm_settings', $settings );
	}
	return apply_filters( 'epm_get_settings', $settings );
}

/**
 * Add settings sections and fields
 * @since 1.0.0
 */
function epm_register_settings() {

	if ( false == get_option( 'epm_settings' ) ) {
		add_option( 'epm_settings' );
	}

	foreach( epm_get_registered_settings() as $tab => $settings ) {

		add_settings_section( 'epm_settings_' . $tab, __return_null(), '__return_false', 'epm_settings_' . $tab );

		foreach ( $settings as $option ) {

			$name = isset( $option['name'] ) ? $option['name'] : '';

			add_settings_field(
				'epm_settings[' . $option['id'] . ']',
				$name,
				function_exists( 'epm_' . $option['type'] . '_callback' ) ? 'epm_' . $option['type'] . '_callback' : 'epm_missing_callback',
				'epm_settings_' . $tab,
				'epm_settings_' . $tab,
				array(
					'id'      => isset( $option['id'] ) ? $option['id'] : null,
					'desc'    => ! empty( $option['desc'] ) ? $option['desc'] : '',
					'name'    => isset( $option['name'] ) ? $option['name'] : null,
					'section' => $tab,
					'size'    => isset( $option['size'] ) ? $option['size'] : null,
					'options' => isset( $option['options'] ) ? $option['options'] : '',
					'std'     => isset( $option['std'] ) ? $option['std'] : ''
				)
			);
		}

	}

	// Creates our settings in the options table
	register_setting( 'epm_settings', 'epm_settings', 'epm_settings_sanitize' );

}
add_action('admin_init', 'epm_register_settings');

/**
 * Retrieve the array of plugin settings
 *
 * @since 1.0.0
 * @return array
*/
function epm_get_registered_settings() {

	/**
	 * Plugin settings, filters are provided for each settings so it can be extended.
	 */
	$epm_settings = array(
		/** General Settings */
		'general' => apply_filters( 'epm_settings_general',
			array(
				'mailchimp_api_key' => array(
					'id' => 'mailchimp_api_key',
					'name' => __( 'Your MailChimp API Key', 'epm' ),
					'desc' => __( 'Enter your MailChimp API key here. <a href="http://kb.mailchimp.com/article/where-can-i-find-my-api-key" target="_blank">Where can I find my api key?</a>', 'epm' ),
					'type' => 'text'
				),
				'mailchimp_list_id' => array(
					'id' => 'mailchimp_list_id',
					'name' => __( 'Your MailChimp List ID', 'epm' ),
					'desc' => __( 'Enter your MailChimp List ID here. <a href="http://kb.mailchimp.com/article/how-can-i-find-my-list-id" target="_blank">Where can I find my list ID?</a>', 'epm' ),
					'type' => 'text'
				),
				'display_name_fields' => array(
					'id' => 'display_name_fields',
					'name' => __( 'Display Name Fields?', 'epm' ),
					'desc' => __( 'Enable this option if you wish to enable the first name and last name field into the signup form.', 'epm' ),
					'type' => 'checkbox'
				),
				'enable_double_optin' => array(
					'id' => 'enable_double_optin',
					'name' => __( 'Enable Double Optin', 'epm' ),
					'desc' => __( 'Check this box to control whether a double opt-in confirmation message is sent.', 'epm' ),
					'type' => 'checkbox'
				),
				'send_welcome_message' => array(
					'id' => 'send_welcome_message',
					'name' => __( 'Send Welcome Message?', 'epm' ),
					'desc' => __( 'Check this box if you would like to send your welcome message. <br/><br/><strong>Note:</strong> if your double optin is disabled and this option is enabled, MailChimp will send your lists Welcome Email if this subscribe succeeds. <br/>A welcome email will not be sent in case of updating an existing subscriber. <br/>If Double optin is enabled, this option has no effect.', 'epm' ),
					'type' => 'checkbox'
				)
			)
		),
		
	);

	return $epm_settings;
}

/**
 * Settings Sanitization
 * @since 1.0.0
 */
function epm_settings_sanitize( $input = array() ) {

	global $epm_options;

	if ( empty( $_POST['_wp_http_referer'] ) ) {
		return $input;
	}

	parse_str( $_POST['_wp_http_referer'], $referrer );

	$settings = epm_get_registered_settings();
	$tab      = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';

	$input = $input ? $input : array();
	$input = apply_filters( 'epm_settings_' . $tab . '_sanitize', $input );

	// Loop through each setting being saved and pass it through a sanitization filter
	foreach ( $input as $key => $value ) {

		// Get the setting type (checkbox, select, etc)
		$type = isset( $settings[$tab][$key]['type'] ) ? $settings[$tab][$key]['type'] : false;

		if ( $type ) {
			// Field type specific filter
			$input[$key] = apply_filters( 'epm_settings_sanitize_' . $type, $value, $key );
		}

		// General filter
		$input[$key] = apply_filters( 'epm_settings_sanitize', $value, $key );
	}

	// Loop through the whitelist and unset any that are empty for the tab being saved
	if ( ! empty( $settings[$tab] ) ) {
		foreach ( $settings[$tab] as $key => $value ) {

			// settings used to have numeric keys, now they have keys that match the option ID. This ensures both methods work
			if ( is_numeric( $key ) ) {
				$key = $value['id'];
			}

			if ( empty( $input[$key] ) ) {
				unset( $epm_options[$key] );
			}

		}
	}

	// Merge our new settings with the existing
	$output = array_merge( $epm_options, $input );

	add_settings_error( 'epm-notices', '', __( 'Settings updated.', 'epm' ), 'updated' );

	return $output;
}

/**
 * Sanitize text fields
 * @since 1.0.0
 */
function epm_sanitize_text_field( $input ) {
	return trim( $input );
}
add_filter( 'epm_settings_sanitize_text', 'epm_sanitize_text_field' );

/**
 * Retrieve settings tabs
 * @since 1.0.0
 */
function epm_get_settings_tabs() {

	$settings = epm_get_registered_settings();

	$tabs             = array();
	$tabs['general']  = __( 'General', 'epm' );

	return apply_filters( 'epm_settings_tabs', $tabs );
}

/**
 * Retrieve a list of all published pages only on plugin settings page.
 * @since 1.0.0
 */
function epm_get_pages( $force = false ) {

	$pages_options = array( 0 => '' ); // Blank option

	if( ( ! isset( $_GET['page'] ) || 'epm-settings' != $_GET['page'] ) && ! $force ) {
		return $pages_options;
	}

	$pages = get_pages();
	if ( $pages ) {
		foreach ( $pages as $page ) {
			$pages_options[ $page->ID ] = $page->post_title;
		}
	}

	return $pages_options;
}

/**
 * Header Callback
 * @since 1.0.0
 */
function epm_header_callback( $args ) {
	echo '<hr/>';
}

/**
 * Checkbox Callback
 * @since 1.0.0
 */
function epm_checkbox_callback( $args ) {
	global $epm_options;

	$checked = isset($epm_options[$args['id']]) ? checked(1, $epm_options[$args['id']], false) : '';
	$html = '<input type="checkbox" id="epm_settings[' . $args['id'] . ']" name="epm_settings[' . $args['id'] . ']" value="1" ' . $checked . '/>';
	$html .= '<label for="epm_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Multicheck Callback
 * @since 1.0.0
 */
function epm_multicheck_callback( $args ) {
	global $epm_options;

	if ( ! empty( $args['options'] ) ) {
		foreach( $args['options'] as $key => $option ):
			if( isset( $epm_options[$args['id']][$key] ) ) { $enabled = $option; } else { $enabled = NULL; }
			echo '<input name="epm_settings[' . $args['id'] . '][' . $key . ']" id="epm_settings[' . $args['id'] . '][' . $key . ']" type="checkbox" value="' . $option . '" ' . checked($option, $enabled, false) . '/>&nbsp;';
			echo '<label for="epm_settings[' . $args['id'] . '][' . $key . ']">' . $option . '</label><br/>';
		endforeach;
		echo '<p class="description">' . $args['desc'] . '</p>';
	}
}

/**
 * Radio Callback
 * @since 1.0.0
 */
function epm_radio_callback( $args ) {
	global $epm_options;

	foreach ( $args['options'] as $key => $option ) :
		$checked = false;

		if ( isset( $epm_options[ $args['id'] ] ) && $epm_options[ $args['id'] ] == $key )
			$checked = true;
		elseif( isset( $args['std'] ) && $args['std'] == $key && ! isset( $epm_options[ $args['id'] ] ) )
			$checked = true;

		echo '<input name="epm_settings[' . $args['id'] . ']"" id="epm_settings[' . $args['id'] . '][' . $key . ']" type="radio" value="' . $key . '" ' . checked(true, $checked, false) . '/>&nbsp;';
		echo '<label for="epm_settings[' . $args['id'] . '][' . $key . ']">' . $option . '</label><br/>';
	endforeach;

	echo '<p class="description">' . $args['desc'] . '</p>';
}

/**
 * Text Callback
 * @since 1.0.0
 */
function epm_text_callback( $args ) {
	global $epm_options;

	if ( isset( $epm_options[ $args['id'] ] ) )
		$value = $epm_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
	$html = '<input type="text" class="' . $size . '-text" id="epm_settings[' . $args['id'] . ']" name="epm_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
	$html .= '<label for="epm_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Number Callback
 * @since 1.0.0
 */
function epm_number_callback( $args ) {
	global $epm_options;

	if ( isset( $epm_options[ $args['id'] ] ) )
		$value = $epm_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$max  = isset( $args['max'] ) ? $args['max'] : 999999;
	$min  = isset( $args['min'] ) ? $args['min'] : 0;
	$step = isset( $args['step'] ) ? $args['step'] : 1;

	$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
	$html = '<input type="number" step="' . esc_attr( $step ) . '" max="' . esc_attr( $max ) . '" min="' . esc_attr( $min ) . '" class="' . $size . '-text" id="epm_settings[' . $args['id'] . ']" name="epm_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
	$html .= '<label for="epm_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Textarea Callback
 * @since 1.0
 */
function epm_textarea_callback( $args ) {
	global $epm_options;

	if ( isset( $epm_options[ $args['id'] ] ) )
		$value = $epm_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
	$html = '<textarea class="large-text" cols="50" rows="5" id="epm_settings[' . $args['id'] . ']" name="epm_settings[' . $args['id'] . ']">' . esc_textarea( stripslashes( $value ) ) . '</textarea>';
	$html .= '<label for="epm_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Password Callback
 * @since 1.0.0
 */
function epm_password_callback( $args ) {
	global $epm_options;

	if ( isset( $epm_options[ $args['id'] ] ) )
		$value = $epm_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
	$html = '<input type="password" class="' . $size . '-text" id="epm_settings[' . $args['id'] . ']" name="epm_settings[' . $args['id'] . ']" value="' . esc_attr( $value ) . '"/>';
	$html .= '<label for="epm_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Missing Callback
 * @since 1.0.0
 */
function epm_missing_callback($args) {
	printf( __( 'The callback function used for the <strong>%s</strong> setting is missing.', 'epm' ), $args['id'] );
}

/**
 * Select Callback
 * @since 1.0.0
 */
function epm_select_callback($args) {
	global $epm_options;

	if ( isset( $epm_options[ $args['id'] ] ) )
		$value = $epm_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$html = '<select id="epm_settings[' . $args['id'] . ']" name="epm_settings[' . $args['id'] . ']"/>';

	foreach ( $args['options'] as $option => $name ) :
		$selected = selected( $option, $value, false );
		$html .= '<option value="' . $option . '" ' . $selected . '>' . $name . '</option>';
	endforeach;

	$html .= '</select>';
	$html .= '<label for="epm_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Rich Editor Callback
 * @since 1.0
 */
function epm_rich_editor_callback( $args ) {
	global $epm_options, $wp_version;

	if ( isset( $epm_options[ $args['id'] ] ) )
		$value = $epm_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	if ( $wp_version >= 3.3 && function_exists( 'wp_editor' ) ) {
		ob_start();
		wp_editor( stripslashes( $value ), 'epm_settings[' . $args['id'] . ']', array( 'textarea_name' => 'epm_settings[' . $args['id'] . ']' ) );
		$html = ob_get_clean();
	} else {
		$html = '<textarea class="large-text" rows="10" id="epm_settings[' . $args['id'] . ']" name="epm_settings[' . $args['id'] . ']">' . esc_textarea( stripslashes( $value ) ) . '</textarea>';
	}

	$html .= '<br/><label for="epm_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Upload Callback
 * @since 1.0.0
 */
function epm_upload_callback( $args ) {
	global $epm_options;

	if ( isset( $epm_options[ $args['id'] ] ) )
		$value = $epm_options[$args['id']];
	else
		$value = isset($args['std']) ? $args['std'] : '';

	$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
	$html = '<input type="text" class="' . $size . '-text epm_upload_field" id="epm_settings[' . $args['id'] . ']" name="epm_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
	$html .= '<span>&nbsp;<input type="button" class="epm_settings_upload_button button-secondary" value="' . __( 'Upload File', 'epm' ) . '"/></span>';
	$html .= '<label for="epm_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}


/**
 * Color picker Callback
 * @since 1.0.0
 */
function epm_color_callback( $args ) {
	global $epm_options;

	if ( isset( $epm_options[ $args['id'] ] ) )
		$value = $epm_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$default = isset( $args['std'] ) ? $args['std'] : '';

	$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
	$html = '<input type="text" class="epm-color-picker" id="epm_settings[' . $args['id'] . ']" name="epm_settings[' . $args['id'] . ']" value="' . esc_attr( $value ) . '" data-default-color="' . esc_attr( $default ) . '" />';
	$html .= '<label for="epm_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Hook Callback
 *
 * Adds a do_action() hook in place of the field
 *
 * @since 1.0.8.2
 * @param array $args Arguments passed by the setting
 * @return void
 */
function epm_hook_callback( $args ) {
	do_action( 'epm_' . $args['id'] );
}