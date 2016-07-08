<?php
/*
Plugin Name: Mailchimp ajax register plugin
Plugin URI: #
Description: Blabla
Version: 0.1
Author: Thomas Kuhnert
Author URI:
*/

add_action('admin_menu', 'test_plugin_setup_menu');
 function test_plugin_setup_menu(){
    add_menu_page( 'Mailchimp-Ajax', 'Mailchimp-Ajax', 'manage_options', 'test-plugin', 'backend_options_page' );
}
 
/**
 * Register the settings
 */
function wporg_register_settings() {
     register_setting(
          'api_key',  // settings section
          'list_id' // setting name
     );
}
add_action( 'admin_init', 'wporg_register_settings' );


function backend_options_page(){
	?>
	<h1>WordPress Extra Post Info</h1>
	  <form method="post" action="options.php">
	    <?php settings_fields( 'extra-post-info-settings' ); ?>
	    <?php do_settings_sections( 'extra-post-info-settings' ); ?>
	    Api Key:
       <input type="text" name="api_key" value="<?php echo get_option( 'api_key' ); ?>"/>
	    List Id:
	    <input type="text" name="list_id" value="<?php echo get_option( 'list_id' ); ?>"/>
	    <?php submit_button(); ?>
	  </form>

<?php
}


