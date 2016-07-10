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


function display_api_key_input()
{
	?>
    	<input type="text" name="api_key" id="api_key" value="<?php echo get_option('api_key'); ?>" />
    <?php
}

function display_list_id()
{
    ?>
        <input type="text" name="list_id" id="list_id" value="<?php echo get_option('list_id'); ?>" />
    <?php
}

function display_opt_in_box()
{

	?>
    	<input type="checkbox" id="opt_in" name="opt_in" value="1" <?php checked(checked( get_option('opt_in'), 1 )) ?>/>
    <?php
}

function display_theme_panel_fields()
{
	add_settings_section("section", "All Settings", null, "theme-options");
	
	add_settings_field("api_key", "Mailchimp Api-Key", "display_api_key_input", "theme-options", "section");
    add_settings_field("list_id", "Mailchimp List-ID", "display_list_id", "theme-options", "section");
    add_settings_field("opt_in", "If opt in mail shall be sent?", "display_opt_in_box", "theme-options", "section");

    register_setting("section", "api_key");
    register_setting("section", "list_id");
    register_setting("section", "opt_in");
}

add_action("admin_init", "display_theme_panel_fields");
