<?php
/**
 * Resource for SiteOrigin widgets.
 */
class SiteOrigin_Widgets_Resource extends WP_REST_Controller {
	public $widgetAnchor;

	public function register_routes() {
		$version = '1';
		$namespace = 'sowb/v' . $version;
		$resource = 'widgets';

		$subresource = 'forms';
		register_rest_route( $namespace, '/' . $resource . '/' . $subresource, array(
			'methods' => WP_REST_Server::CREATABLE,
			'callback' => array( $this, 'get_widget_form' ),
			'args' => array(
				'widgetClass' => array(
					'validate_callback' => array( $this, 'validate_widget_class' ),
				),
				'widgetData' => array(
					'validate_callback' => array( $this, 'validate_widget_data' ),
				),
			),
			'permission_callback' => array( $this, 'permissions_check' ),
		) );

		$subresource = 'previews';
		register_rest_route( $namespace, '/' . $resource . '/' . $subresource, array(
			'methods' => WP_REST_Server::CREATABLE,
			'callback' => array( $this, 'get_widget_preview' ),
			'args' => array(
				'widgetClass' => array(
					'validate_callback' => array( $this, 'validate_widget_class' ),
				),
				'widgetData' => array(
					'validate_callback' => array( $this, 'validate_widget_data' ),
				),
			),
			'permission_callback' => array( $this, 'permissions_check' ),
		) );
	}

	/**
	 * @param WP_REST_Request $request Request.
	 *
	 * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
	 */
	public function permissions_check( $request ) {
		if ( ! current_user_can( 'edit_posts' ) ) {
			$status_code = rest_authorization_required_code();

			return new WP_Error(
				$status_code,
				__( 'Insufficient permissions.', 'so-widgets-bundle' ),
				array(
					'status' => $status_code,
				)
			);
		}

		return true;
	}

	/**
	 * Validate passed in widgetClass arg only contains alphanumeric and underscores.
	 *
	 * @return bool
	 */
	public function validate_widget_class( $param, $request, $key ) {
		return preg_match( '/\w+/', $param ) == 1;
	}

	/**
	 * Get the collection of widgets.
	 *
	 * @param WP_REST_Request $request
	 *
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_widget_form( $request ) {
		$widget_class = $request['widgetClass'];
		$widget_data = empty( $request['widgetData'] ) ? array() : $request['widgetData'];

		/* @var $widget SiteOrigin_Widget */
		$widget = SiteOrigin_Widgets_Widget_Manager::get_widget_instance( $widget_class );
		// Attempt to activate the widget if it's not already active.
		if ( ! empty( $widget_class ) && empty( $widget ) ) {
			$widget = SiteOrigin_Widgets_Bundle::single()->load_missing_widget( false, $widget_class );
		}

		if ( ! empty( $widget ) && is_object( $widget ) && is_subclass_of( $widget, 'SiteOrigin_Widget' ) ) {
			if ( ! empty( $widget_data ) ) {
				$widget_data = $widget->update( $widget_data, $widget_data );
			}
			ob_start();
			$widget->form( $widget_data );
			$widget_form = ob_get_clean();
		} else {
			$widget_form = new WP_Error(
				400,
				'Invalid or missing widget class: ' . $widget_class,
				array(
					'status' => 400,
				)
			);
		}

		return rest_ensure_response( $widget_form );
	}

	/**
	 * For now widget data is validated in the below `get_widget_preview` function.
	 * Leaving this here for possible later implementation.
	 *
	 * @return bool
	 */
	public function validate_widget_data( $param, $request, $key ) {
		return true;
	}

	public function add_widget_id( $id, $instance, $widget ) {
		return $this->widgetAnchor;
	}

	/**
	 * Get the collection of widgets.
	 *
	 * @param WP_REST_Request $request
	 *
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_widget_preview( $request ) {
		$widget_class = $request['widgetClass'];
		$widget_data = $request['widgetData'];

		$widget = SiteOrigin_Widgets_Widget_Manager::get_widget_instance( $widget_class );
		// Attempt to activate the widget if it's not already active.
		if ( ! empty( $widget_class ) && empty( $widget ) ) {
			$widget = SiteOrigin_Widgets_Bundle::single()->load_missing_widget( false, $widget_class );
		}

		// This ensures styles are added inline.
		add_filter( 'siteorigin_widgets_is_preview', '__return_true' );
		$GLOBALS[ 'SO_WIDGETS_BUNDLE_PREVIEW_RENDER' ] = true;

		$valid_widget_class = ! empty( $widget ) &&
							  is_object( $widget ) &&
							  is_subclass_of( $widget, 'SiteOrigin_Widget' );

		if ( $valid_widget_class && ! empty( $widget_data ) ) {
			ob_start();
			// Add anchor to widget wrapper.
			if ( ! empty( $request['anchor'] ) ) {
				$this->widgetAnchor = $request['anchor'];
				add_filter( 'siteorigin_widgets_wrapper_id_' . $widget->id_base, array( $this, 'add_widget_id' ), 10, 3 );
			}
			/* @var $widget SiteOrigin_Widget */
			$instance = $widget->update( $widget_data, $widget_data );
			$widget->widget( array(), $instance );
			$rendered_widget = array();
			$rendered_widget['html'] = ob_get_clean();

			if ( ! empty( $request['anchor'] ) ) {
				remove_filter( 'siteorigin_widgets_wrapper_id_' . $widget->id_base, array( $this, 'add_widget_id' ), 10 );
			}

			// Check if this widget loaded any icons, and if it has, store them.
			$styles = wp_styles();

			if ( ! empty( $styles->queue ) ) {
				$rendered_widget['icons'] = array();

				foreach ( $styles->queue as $style ) {
					if ( strpos( $style, 'siteorigin-widget-icon-font' ) !== false ) {
						$rendered_widget['icons'][] = $style;
					}
				}
			}
		} else {
			if ( empty( $valid_widget_class ) ) {
				$rendered_widget = new WP_Error(
					400,
					'Invalid or missing widget class: ' . $widget_class,
					array(
						'status' => 400,
					)
				);
			} elseif ( empty( $widget_data ) ) {
				$rendered_widget = new WP_Error(
					400,
					'Unable to render preview. Invalid or missing widget data.',
					array(
						'status' => 400,
					)
				);
			}
		}

		unset( $GLOBALS['SO_WIDGETS_BUNDLE_PREVIEW_RENDER'] );

		return rest_ensure_response( $rendered_widget );
	}
}
