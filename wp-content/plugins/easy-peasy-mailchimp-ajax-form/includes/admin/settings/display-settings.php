<?php
/**
 * Admin Options Page
 *
 * @copyright   Copyright (c) 2014, Alessandro Tesoro
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Options Page
 *
 * Renders the options page contents.
 * @since 1.0
 */
function epm_options_page() {
	global $epm_options;

	$active_tab = isset( $_GET[ 'tab' ] ) && array_key_exists( $_GET['tab'], epm_get_settings_tabs() ) ? $_GET[ 'tab' ] : 'general';

	ob_start();
	?>
	<div class="wrap">

		<h2><?php _e('Easy Peasy MailChimp Settings','easy-peasy-mailchimp');?> <?php do_action('epm_next_to_settings_title');?></h2>
		<br/>

		<h2 class="nav-tab-wrapper">
			<?php
			foreach( epm_get_settings_tabs() as $tab_id => $tab_name ) {

				$tab_url = add_query_arg( array(
					'settings-updated' => false,
					'tab' => $tab_id
				) );

				$active = $active_tab == $tab_id ? ' nav-tab-active' : '';

				echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $tab_name ) . '" class="nav-tab' . $active . '">';
					echo esc_html( $tab_name );
				echo '</a>';
			}
			?>
		</h2>

		<div id="poststuff" class="metabox-holder has-right-sidebar">
		    
		    <div class="inner-sidebar">
		        <div id="side-sortables" class="meta-box-sortables ui-sortable">
		            <?php do_action('epm_settings_sidebar');?>
		        </div>
		    </div>
		 
		    <div id="post-body">
		        <div id="post-body-content">
		            <div id="normal-sortables" class="meta-box-sortables ui-sortable">
		                <form method="post" action="options.php">
							<table class="form-table">
							<?php
							settings_fields( 'epm_settings' );
							do_settings_fields( 'epm_settings_' . $active_tab, 'epm_settings_' . $active_tab );
							?>
							</table>
							<?php submit_button(); ?>
						</form>
		            </div>
		        </div>
		    </div>
		    <br class="clear">
		</div>

	</div><!-- .wrap -->
	<?php
	echo ob_get_clean();
}