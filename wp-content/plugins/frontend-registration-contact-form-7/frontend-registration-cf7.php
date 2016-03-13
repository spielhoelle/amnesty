<?php
/**
 * Plugin Name: Frontend Registration - Contact Form 7
 * Plugin URL: http://jquerybuilder.com/product/frontend-registration-contact-form-7/
 * Description:  This plugin will convert your Contact form 7 in to registration form for WordPress. PRO Plugin available now. Please visit our wordpress plugin page for Pro version Updates. 
 * Version: 1.1
 * Author: David Pokorny
 * Author URI: http://jquerybuilder.com
 * Developer: Pokorny David
 * Developer E-Mail: pokornydavid4@gmail.com
 * Text Domain: contact-form-7-freg
 * Domain Path: /languages
 * 
 * Copyright: © 2009-2015 izept.com.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * 
 * @access      public
 * @since       1.1
 * @return      $content
*/
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

require_once (dirname(__FILE__) . '/frontend-registration-opt-cf7.php');

function cf7fr_editor_panels_reg ( $panels ) {
		
		$new_page = array(
			'Error' => array(
				'title' => __( 'Registration Settings', 'contact-form-7' ),
				'callback' => 'cf7fr_admin_reg_additional_settings'
			)
		);
		
		$panels = array_merge($panels, $new_page);
		
		return $panels;
		
	}
	add_filter( 'wpcf7_editor_panels', 'cf7fr_editor_panels_reg' );

function cf7fr_admin_reg_additional_settings( $cf7 )
{
	
	$post_id = sanitize_text_field($_GET['post']);
	$tags = $cf7->form_scan_shortcode();
	$enable = get_post_meta($post_id, "_cf7fr_enable_registration", true);
	$cf7fru = get_post_meta($post_id, "_cf7fru_", true);
	$cf7fre = get_post_meta($post_id, "_cf7fre_", true);
	
	if ($enable == "1") { $checked = "CHECKED"; } else { $checked = ""; }
	
	$selected = "";
	$admin_cm_output = "";
	
	$admin_cm_output .= "<div id='additional_settings-sortables' class='meta-box'><div id='additionalsettingsdiv'>";
	$admin_cm_output .= "<div class='handlediv' title='Click to toggle'><br></div><h3 class='hndle ui-sortable-handle'><span>Frontend Registration Settings</span></h3>";
	$admin_cm_output .= "<div class='inside'>";
	
	$admin_cm_output .= "<div class='mail-field'>";
	$admin_cm_output .= "<input name='enable' value='1' type='checkbox' $checked>";
	$admin_cm_output .= "<label>Enable Registration on this form</label>";
	$admin_cm_output .= "</div>";

	$admin_cm_output .= "<br /><table>";
	
	$admin_cm_output .= "<tr><td>Selected Field Name For User Name :</td></tr>";
	$admin_cm_output .= "<tr><td><select name='_cf7fru_'>";
	$admin_cm_output .= "<option value=''>Select Field</option>";
	foreach ($tags as $key => $value) {
		if($cf7fru==$value['name']){$selected='selected=selected';}else{$selected = "";}			
		$admin_cm_output .= "<option ".$selected." value='".$value['name']."'>".$value['name']."</option>";
	}
	$admin_cm_output .= "</select>";
	$admin_cm_output .= "</td></tr>";

	$admin_cm_output .= "<tr><td>Selected Field Name For Email :</td></tr>";
	$admin_cm_output .= "<tr><td><select name='_cf7fre_'>";
	$admin_cm_output .= "<option value=''>Select Field</option>";
	foreach ($tags as $key => $value) {
		if($cf7fre==$value['name']){$selected='selected=selected';}else{$selected = "";}
		$admin_cm_output .= "<option ".$selected." value='".$value['name']."'>".$value['name']."</option>";
	}
	$admin_cm_output .= "</select>";
	$admin_cm_output .= "</td></tr><tr><td>";
	
	$admin_cm_output .= "<input type='hidden' name='email' value='2'>";
	
	$admin_cm_output .= "<input type='hidden' name='post' value='$post_id'>";
	
	$admin_cm_output .= "</td></tr></table>";
	$admin_cm_output .= "</div>";
	$admin_cm_output .= "</div>";
	$admin_cm_output .= "</div>";

	echo $admin_cm_output;
	
}
// hook into contact form 7 admin form save
add_action('wpcf7_save_contact_form', 'cf7_save_reg_contact_form');

function cf7_save_reg_contact_form( $cf7 ) {

		$tags = $cf7->form_scan_shortcode();
	
		$post_id = sanitize_text_field($_POST['post']);
		
		if (!empty($_POST['enable'])) {
			$enable = sanitize_text_field($_POST['enable']);
			update_post_meta($post_id, "_cf7fr_enable_registration", $enable);
		} else {
			update_post_meta($post_id, "_cf7fr_enable_registration", 0);
		}

		$key = "_cf7fru_";
		$vals = sanitize_text_field($_POST[$key]);
		update_post_meta($post_id, $key, $vals);

		$key = "_cf7fre_";
		$vals = sanitize_text_field($_POST[$key]);
		update_post_meta($post_id, $key, $vals);

		
}
?>