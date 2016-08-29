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

    add_options_page( 
            'Mailchimp-Ajax',
            'Mailchimp-Ajax',
            'manage_options',
            __FILE__,
            'form_for_mailchimp_settings'
        );
}
 

function form_for_mailchimp_settings(){
    ?>
	    <div class="wrap">
	    <h1>Tommys Mailchimp-Ajax Plugin</h1>
	    <form method="post" action="options.php">
            <?php
                settings_fields("section");
                do_settings_sections("theme-options");      
                submit_button(); 
                ?>

        </form>

        <form action="<?php echo $_SERVER['REQUEST_URI']?>" method="post">
            <p class="submit">
            <input type="submit" name="subscribers" id="subscribers" class="button-primary" value="Liste löschen" onclick="return confirm('<?php echo htmlspecialchars("Sicher? Dies löscht die Liste in der Wordpress Datenbank. Hoffentlich sind alle diese Adressen bei Mailchimp importiert."); ?>')"/>
            </p>
        </form>

		</div>
	<?php
}

function display_api_key_input(){
	?>
    	<input type="text" name="api_key" id="api_key" value="<?php echo get_option('api_key'); ?>" />
    <?php
}

function display_list_id(){
    ?>
        <input type="text" name="list_id" id="list_id" value="<?php echo get_option('list_id'); ?>" />
    <?php
}

function display_opt_in_box(){
    ?>
        <input type="checkbox" id="opt_in" name="opt_in" value="1" <?php checked(checked( get_option('opt_in'), 1 )) ?>/>
    <?php
}

function display_subscribers()
{   
    $subscribers = get_option('tma_subscribers');
    echo "<table>";
    foreach ($subscribers as $key => $value) {
        echo "<tr>";
            echo "<td>";
            echo $value['email'];
            echo "</td>";

            echo "<td>";
            echo date("d.m.Y H:i", $value['date']);
            echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function display_theme_panel_fields()
{
	add_settings_section("section", "Einstellugen", null, "theme-options");
	
	add_settings_field("api_key", "Mailchimp Api-Key", "display_api_key_input", "theme-options", "section");
    add_settings_field("list_id", "Mailchimp List-ID", "display_list_id", "theme-options", "section");
    add_settings_field("opt_in", "Wenn sich jemand einträgt, Bestätigungslink oder sofort eintragen?", "display_opt_in_box", "theme-options", "section");
    add_settings_field("subscribers", "Subscribers", "display_subscribers", "theme-options", "section");

    register_setting("section", "api_key");
    register_setting("section", "list_id");
    register_setting("section", "opt_in");
    register_setting("section", "subscribers");
}

add_action("admin_init", "display_theme_panel_fields");




add_filter('plugin_action_links', 'myplugin_plugin_action_links', 10, 2);

function myplugin_plugin_action_links($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        // The "page" query string value must be equal to the slug
        // of the Settings admin page we defined earlier, which in
        // this case equals "myplugin-settings".
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=tommy-mailchimp-ajax">Settings</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
}
