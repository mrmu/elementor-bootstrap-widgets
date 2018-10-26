<?php
/**
 * Plugin Name: Elementor Bootstrap Widgets
 * Description: To provide a eazy way to add elementor widgets that compatible with bootstrap theme.
 * Plugin URI: 
 * Version: 1.0.0
 * Author: Audi Lu
 * Author URI: http://audilu.com
 * Text Domain: ele-bootstrap-widgets
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'ELEMENTOR_BOOTSTRAP_WIDGETS__FILE__', __FILE__ );

/**
 * Load Bootstrap Widgets
 *
 * Load the plugin after Elementor (and other plugins) are loaded.
 *
 * @since 1.0.0
 */
function bootstrap_widgets_load() {

	// Load localization file
	load_plugin_textdomain( 
		'ele-bootstrap-widgets',
		false,
		dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
	);

	// Notice if the Elementor is not active
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'bootstrap_widgets_fail_load' );
		return;
	}
	
	// Check required version
	$elementor_version_required = '1.8.0';
	if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_required, '>=' ) ) {
		add_action( 'admin_notices', 'bootstrap_widgets_fail_load_out_of_date' );
		return;
	}
	// Require the main plugin file
	require( __DIR__ . '/plugin.php' );
}
add_action( 'plugins_loaded', 'bootstrap_widgets_load' );

function bootstrap_widgets_fail_load_out_of_date() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}
	$file_path = 'elementor/elementor.php';
	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
	$message = '<p>' . __( 'Elementor Bootstrap Widgets is not working because you are using an old version of Elementor.', 'ele-bootstrap-widgets' ) . '</p>';
	$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, __( 'Update Elementor Now', 'ele-bootstrap-widgets' ) ) . '</p>';
	echo '<div class="error">' . $message . '</div>';
}
