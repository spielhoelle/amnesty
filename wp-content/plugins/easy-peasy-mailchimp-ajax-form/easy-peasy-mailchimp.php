<?php
/*
Plugin Name: Easy Peasy MailChimp Ajax Form
Plugin URI: http://themesdepot.org
Description: Easy Peasy MailChimp allows you to easily include an ajax powered mailchimp newsletter signup form into your website through widget or shortcode.
Author: Alessandro Tesoro
Version: 1.0.5
Author URI: http://alessandrotesoro.me
Requires at least: 3.8
Tested up to: 4.0
Text Domain: easy-peasy-mailchimp
Domain Path: /languages
License: GPLv2 or later
*/

/*
Copyright 2014  Alessandro Tesoro

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Easy Google Analytics class.
 */
class Easy_Peasy_MailChimp {

	/**
	 * Constructor - get the plugin hooked in and ready
	 * @since    1.0.0
	 */
	public function __construct() {
		
		// Define constants
		define( 'EPM_VERSION', '1.0.5' );
		define( 'EPM_SLUG', plugin_basename(__FILE__));
		define( 'EPM_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'EPM_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );

		//Filters
		register_activation_hook(__FILE__, array( $this,'plugin_activation_check')); 

		add_filter( "plugin_action_links_".EPM_SLUG , array( $this,'epm_add_settings_link') );
		add_filter( 'plugin_row_meta', array( $this,'epm_plugin_row_meta'), 10, 2 );

		//Actions
		add_action('plugins_loaded', array($this,'epm_load_plugin_textdomain'));
		add_action('admin_menu', array($this,'epm_add_options_link'), 10);
		add_action('epm_settings_sidebar', array($this,'epm_add_settings_box'), 10);
		add_action('epm_settings_sidebar', array($this,'epm_add_settings_box_advert'), 10);
		add_action('epm_next_to_settings_title', array($this, 'epm_add_links_to_title'));

		// Load required files
		$this->epm_includes();

	}

	/**
	 * Add Settings Link To WP-Plugin Page
	 * @since    1.0.0
	 */
	public function epm_add_settings_link( $links ) {
	    $settings_link = '<a href="options-general.php?page=epm-settings">'.__('Settings','easy-peasy-mailchimp').'</a>';
	  	array_push( $links, $settings_link );
	  	return $links;
	}

	/**
	 * Plugin row meta links
	 * @since 1.8
	 */
	function epm_plugin_row_meta( $input, $file ) {
		if ( $file != 'easy-peasy-mailchimp/easy-peasy-mailchimp.php' )
			return $input;

		$links = array(
			'<a href="http://themeforest.net/user/ThemesDepot/portfolio" target="_blank">' . esc_html__( 'Get Premium WordPress Themes', 'easy-peasy-mailchimp' ) . '</a>',
			'<a href="http://profiles.wordpress.org/alessandrotesoro/" target="_blank">' . esc_html__( 'Get More Free Plugins', 'easy-peasy-mailchimp' ) . '</a>',
		);

		$input = array_merge( $input, $links );

		return $input;
	}

	/**
	 * Localization
	 * @since 1.0.0
	 */
	public function epm_load_plugin_textdomain() {
		load_plugin_textdomain( 'easy-peasy-mailchimp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Include required files
	 * @since 1.0.0
	 */
	private function epm_includes() {

		// Plugin options handler
		global $epm_options;
		require_once EPM_PLUGIN_DIR . '/includes/admin/settings/register-settings.php';
		$epm_options = epm_get_settings();

		if(is_admin()) {
			require_once EPM_PLUGIN_DIR . '/includes/admin/settings/display-settings.php';
		}

		// Load MailChimp API Class
		require_once EPM_PLUGIN_DIR . '/includes/MailChimp.php';

		// Easy Peasy MailChimp Template Manager
		require_once EPM_PLUGIN_DIR . '/includes/template.php';

		// Easy Peasy MailChimp Shortcode
		require_once EPM_PLUGIN_DIR . '/includes/shortcode.php';

		// Easy Peasy Ajax Handler
		require_once EPM_PLUGIN_DIR . '/includes/ajax.php';		

	}

	/**
	 * Add Plugin Menu Page
	 * @since 1.0.0
	 */
	public function epm_add_options_link() {
		global $epm_settings_page;
		$epm_settings_page 	    = add_submenu_page( 'options-general.php', __( 'Easy Peasy MailChimp Settings', 'easy-peasy-mailchimp' ), __( 'MailChimp Settings', 'easy-peasy-mailchimp' ), 'manage_options', 'epm-settings', 'epm_options_page' );
	}

	/**
	 * Add box into the sidebar of the settings page.
	 * @since 1.0.0
	 */
	public function epm_add_settings_box() {

		echo '<div class="postbox">
				<h3 class="hndle">'.__('MailChimp Form Usage','easy-peasy-mailchimp').'</h3>
				<div class="inside">
					'.__('To display a mailchimp signup form use the shortcode below here.','easy-peasy-mailchimp').'
					<br/><br/>
					<code>[epm_mailchimp]</code>
				</div>

				<div id="major-publishing-actions">
					<a href="http://kb.mailchimp.com/article/where-can-i-find-my-api-key" target="_blank" class="button">'.__('Get Your API Key','easy-peasy-mailchimp').'</a>
					<a href="http://kb.mailchimp.com/article/how-can-i-find-my-list-id" target="_blank" class="button">'.__('Get Your List ID','easy-peasy-mailchimp').'</a>				
				</div>
			</div>';
	}

	/**
	 * Add box into the sidebar of the settings page.
	 * @since 1.0.0
	 */
	public function epm_add_settings_box_advert() {

		echo '<div class="postbox">
				<h3 class="hndle">'.__('Premium WordPress Themes','easy-peasy-mailchimp').'</h3>
				<div class="inside">
					'.__('Are you looking for Premium WordPress Themes? <a href="http://themesdepot.org" target="_blank">ThemesDepot</a> provides premium and affordable WordPress themes for any kind of website.','easy-peasy-mailchimp').'
				</div>

				<div id="major-publishing-actions">
					<a href="http://themeforest.net/user/ThemesDepot/portfolio?ref=ThemesDepot" target="_blank" class="button-primary">'.__('Browse Premium Themes','easy-peasy-mailchimp').'</a>
				</div>
			</div>';
	}

	/**
	 * Add links next to title in settings page
	 * @since 1.0.0
	 */
	public function epm_add_links_to_title() {

		echo '<a href="http://profiles.wordpress.org/alessandrotesoro/" class="add-new-h2" target="_blank">'.__('Get More Free Plugins', 'easy-peasy-mailchimp').'</a>';
		echo '<a href="http://themeforest.net/user/ThemesDepot/portfolio?ref=ThemesDepot" class="add-new-h2" target="_blank">'.__('Browse Premium WordPress Themes', 'easy-peasy-mailchimp').'</a>';
	}

	/**
	 * Prevents Plugin Activation if host is crap.
	 * Yes, my darling friends, php 5.2 was deprecated in 2011 
	 * Run away from your host if you're still using php 5.2
	 * @since 1.0.4
	 */
	function plugin_activation_check(){ 
        if (version_compare(PHP_VERSION, '5.3', '<')) { 
                deactivate_plugins(basename(__FILE__)); // Deactivate ourself 
                wp_die("Sorry, but you can't run this plugin, it requires PHP 5.3 or higher. Contact your host and request a php update."); 
        } 
	}

}

$GLOBALS['easy_peasy_mailchimp'] = new Easy_Peasy_MailChimp();