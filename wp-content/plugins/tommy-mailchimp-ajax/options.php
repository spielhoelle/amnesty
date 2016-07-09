<?php
/*
Plugin Name: Mailchimp ajax register plugin
Plugin URI: #
Description: My very own Mailchimp ajax plugin
Version: 0.1
Author: Thomas Kuhnert
Author URI:
*/


require 'shortcode.php';
require 'mc-config.php';


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
	    <div class="wrap">
	    <h1>Theme Panel</h1>
	    <form method="post" action="options.php">
	        <?php
	            settings_fields("section");
	            do_settings_sections("theme-options");      
	            submit_button(); 
	        ?>          
	    </form>
		</div>
	<?php
}


function display_twitter_element()
{
	?>
    	<input type="text" name="api_key" id="api_key" value="<?php echo get_option('api_key'); ?>" />
    <?php
}

function display_facebook_element()
{
	?>
    	<input type="text" name="list_id" id="list_id" value="<?php echo get_option('list_id'); ?>" />
    <?php
}

function display_theme_panel_fields()
{
	add_settings_section("section", "All Settings", null, "theme-options");
	
	add_settings_field("api_key", "Mailchimp Api-Key", "display_twitter_element", "theme-options", "section");
    add_settings_field("list_id", "Mailchimp List-ID", "display_facebook_element", "theme-options", "section");

    register_setting("section", "api_key");
    register_setting("section", "list_id");
}

add_action("admin_init", "display_theme_panel_fields");
