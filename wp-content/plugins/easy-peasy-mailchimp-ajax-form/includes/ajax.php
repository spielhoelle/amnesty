<?php
/**
 * Add Ajax Handler - this is the function that handles the submission of the form.
 * @since    1.0.0
 * @version  1.0.1
 */

function epm_mailchimp_submit_to_list() {
	
	global $epm_options;

	//get data from our ajax() call
	$epm_list_id = $_POST['epm_list_id'];
	if(epm_get_option('display_name_fields')):
	$epm_name = $_POST['epm_firstname'];
	$epm_lastname = $_POST['epm_lastname'];
	endif;
	$epm_email = $_POST['epm_email'];
	$epm_enable_validation = apply_filters( 'epm_filter_validation', 'enabled' ); //filter to disable/enable default validation messages
	$epm_enable_success = apply_filters( 'epm_filter_success', 'enabled' ); //filter to disable/enable default success messages

	//show error if fields are empty and validation is enabled
	if($epm_enable_validation == 'enabled') {

		// first name and last name not filled and name fields are enabled
		if(empty($epm_name) && epm_get_option('display_name_fields')) {
			echo '<div class="epm-message epm-error message error"><p>'.__('Please fill in first name and last name fields.'.$epm_options['display_name_fields'],'easy-peasy-mailchimp').'</p></div>';
		}
		// email field is empty and is not an email
		if(empty($epm_email) && !is_email( $epm_email )) {
			echo '<div class="epm-message epm-error message error"><p>'.__('Please add a correct email address.'.$epm_options['display_name_fields'],'easy-peasy-mailchimp').'</p></div>';
		}
		// email field is not empty and is not an email
		if(!empty($epm_email) && !is_email( $epm_email )) {
			echo '<div class="epm-message epm-error message error"><p>'.__('The email address seems to be wrong.','easy-peasy-mailchimp').'</p></div>';
		}

	}

	//show success if enabled and form is correctly filled
	if($epm_enable_success == 'enabled') {

		if(epm_get_option('display_name_fields') && !empty($epm_name) && !empty($epm_lastname) && !empty($epm_email) && is_email( $epm_email ) ) {
			echo '<div class="epm-message epm-success message success"><p>'.__('Thank you for signing up to the newsletter.','easy-peasy-mailchimp').'</p></div>';
		}

		if(!epm_get_option('display_name_fields') && !empty($epm_email) && is_email( $epm_email )) {
			echo '<div class="epm-message epm-success message success"><p>'.__('Thank you for signing up to the newsletter.','easy-peasy-mailchimp').'</p></div>';
		}

	}

	//proceed with submission to the mailchimp api
	if(epm_get_option('display_name_fields') && !empty($epm_name) && !empty($epm_lastname) && !empty($epm_email) && is_email( $epm_email ) || !epm_get_option('display_name_fields') && !empty($epm_email) && is_email( $epm_email ) ) {

		$MailChimp = new \Drewm\MailChimp( $epm_options['mailchimp_api_key'] );
		$result = $MailChimp->call('lists/subscribe', array(
			'id'                => $epm_options['mailchimp_list_id'],
			'email'             => array('email'=> $epm_email),
			'merge_vars'        => (epm_get_option('display_name_fields') ? array('FNAME'=>$epm_name, 'LNAME'=>$epm_lastname) : array()),
			'double_optin'      => (epm_get_option('enable_double_optin') ? true : false),
			'update_existing'   => true,
			'replace_interests' => false,
			'send_welcome'      => (epm_get_option('send_welcome_message') ? true : false),
		));

	}


	// Return String
	die();
	
}
add_action('wp_ajax_epm_mailchimp_submit_to_list', 'epm_mailchimp_submit_to_list');
add_action('wp_ajax_nopriv_epm_mailchimp_submit_to_list', 'epm_mailchimp_submit_to_list');

/**
 * Add js ajax script to footer.
 * @since    1.0.0
 */
function epm_mailchimp_footer_js() { ?>
<script>
jQuery(window).load(function() {
	jQuery('.epm-submit-chimp').click(function() {

		//get form values
		var epm_form = jQuery(this);
		var epm_list_id = jQuery(epm_form).parent().find('#epm_list_id').val();
		var epm_firstname = jQuery(epm_form).parent().find('#epm-first-name').val();
		var epm_lastname = jQuery(epm_form).parent().find('#epm-last-name').val();
		var epm_email = jQuery(epm_form).parent().find('#epm-email').val();

		//change submit button text
		var submit_wait_text = jQuery(this).data('wait-text');
		var submit_orig_text = jQuery(this).val();
		jQuery(this).val(submit_wait_text);

		jQuery.ajax({
			type: 'POST',
			context: this,
			url: "<?php echo admin_url('admin-ajax.php');?>",
			data: {
				action: 'epm_mailchimp_submit_to_list',
				epm_list_id: epm_list_id,
				epm_firstname: epm_firstname,
				epm_lastname: epm_lastname,
				epm_email: epm_email
			},
			success: function(data, textStatus, XMLHttpRequest){
				var epm_ajax_response = jQuery(data);
				jQuery(epm_form).parent().find('.epm-message').remove(); // remove existing messages on re-submission
				jQuery(epm_form).parent().prepend(epm_ajax_response);
				jQuery(epm_form).val(submit_orig_text); // restore submit button text
				<?php do_action('epm_jquery_ajax_success_event');?>
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				alert('Something Went Wrong!');
			}
		});
		return false;

	});
});
</script>
<?php }
add_action('wp_footer','epm_mailchimp_footer_js');