<?php
namespace BootstrapWidgets;
use BootstrapWidgets\Widgets\Bootstrap_Modal;
use BootstrapWidgets\Controls\Post_Selector;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class Plugin {
	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}
	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'on_widgets_registered' ) );
		add_action( 'elementor/controls/controls_registered', array( $this, 'register_controls'), 10, 1 );
		// add_action( 'elementor/element/global-settings/style/before_section_end', array( $this, 'add_elementor_page_settings_controls' ) );

		add_action( 'elementor/frontend/after_register_scripts', function() {
			wp_register_script( 
				'bootstrap-widgets-modal', 
				plugins_url( '/assets/js/bootstrap-widgets-modal.js', ELEMENTOR_BOOTSTRAP_WIDGETS__FILE__ ), 
				[ 'jquery' ], 
				false, false );
			wp_enqueue_script( 'bootstrap-widgets-modal' );
		} );
		add_action( 'elementor/frontend/after_register_styles', function() {
			wp_register_style(
				'bootstrap-widgets-modal',
				plugins_url( '/assets/css/bootstrap-widgets-modal.css', ELEMENTOR_BOOTSTRAP_WIDGETS__FILE__ ),
				[],
				'v1.0.0'
			);
			wp_enqueue_style( 'bootstrap-widgets-modal' );
		} );
	}
	/**
	 * On Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}
	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function includes() {
		$official_path = 'plugins/elementor/';
		$plugin_widgets_path = plugin_dir_path(__FILE__) . 'widgets/';

		$widget_files = ['bootstrap-modal.php'];

		// We look for any theme overrides for this custom Elementor element.
		// If no theme overrides are found we use the default one in this plugin.
		foreach ($widget_files as $widget_file) {
			$template_file = locate_template($official_path . $widget_file);
			if ( !$template_file || !is_readable( $template_file ) ) {
				$template_file = $plugin_widgets_path . $widget_file;
			}
			if ( $template_file && is_readable( $template_file ) ) {
				require_once $template_file;
			}
		}
	}

	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_widget() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Bootstrap_Modal() );
		//Plugin::instance()->widgets_manager->register_widget_type( new Ele_Bootstrap_Modal );

	}

	/**
	 * Register Controls
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function register_controls() {

		$plugin_controls_path = plugin_dir_path(__FILE__) . 'controls/';
		$controls_file = $plugin_controls_path . 'post_selector_control.php';

		if ( $controls_file && is_readable( $controls_file ) ) {
			require($controls_file);

			$control_id = 'multiselect';
			$controls_manager = \Elementor\Plugin::$instance->controls_manager;
			$controls_manager->register_control(  $control_id, new \BootstrapWidgets\Controls\Control_Multiselect  );
		}
	}

	/**
	 * 
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	// private function add_elementor_page_settings_controls( $page, $args ) {
	// 	$page->add_control(
	// 		'menu_item_color',
	// 		[
	// 			'label' => __( 'Menu Item Color', 'elementor' ),
	// 			'type' => Elementor\Controls_Manager::COLOR,
	// 			// 'selectors' => [
	// 			// 	'{{WRAPPER}} .menu-item a' => 'color: {{VALUE}}',
	// 			// ],
	// 		]
	// 	);
	// }
}
new Plugin();