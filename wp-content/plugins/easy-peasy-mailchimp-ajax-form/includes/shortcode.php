<?php
/**
 * Add Shortcode to display the mailchimp form
 * @since    1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * MailChimp Signup form
 * @since    1.0.0
 */
function epm_mailchimp_form_shortcode( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'list' => '',
	), $atts));
	
	ob_start();
	get_epm_template( 'mailchimp-form.php', array(
		'list' => $list,
	));
	return ob_get_clean();
}
add_shortcode( 'epm_mailchimp', 'epm_mailchimp_form_shortcode' );