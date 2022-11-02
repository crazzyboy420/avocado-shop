<?php
/**
 * @link              https://shopitpress.com
 * @since             1.0.0
 * @package           Sip_Reviews_Shortcode_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       SIP Reviews Shortcode for WooCommerce
 * Plugin URI:        https://shopitpress.com/plugins/sip-reviews-shortcode-woocommerce/
 * Description: 	  Creates a shortcode, [woocommerce_reviews id="n"],  that displays the reviews of any WooCommerce product. [woocommerce_reviews] will show the reviews of the current product if applicable.  This plugin requires WooCommerce.
 * Version:           1.2.3
 * Requires:		  PHP5, WooCommerce Plugin
 * Author:            ShopitPress <hello@shopitpress.com>
 * Author URI:        https://shopitpress.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Copyright: 		  © 2015 ShopitPress(email: hello@shopitpress.com)
 * Text Domain:       sip-reviews-shortcode
 * Domain Path:       /languages
 * WC requires at least: 2.6.0
 * WC tested up to: 6.5.1
 * Tested up to: 6.0
 * Last updated on: 26 March, 2021
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'plugins_loaded', 'sip_rswc_activate' );
register_activation_hook( __FILE__, 'activate_sip_reviews_shortcode' );
register_deactivation_hook( __FILE__, 'deactivate_sip_reviews_shortcode' );

define( 'SIP_RSWC_NAME', 'SIP Reviews Shortcode for WooCommerce' );
define( 'SIP_RSWC_VERSION', '1.2.3' );
define( 'SIP_RSWC_PLUGIN_SLUG', 'sip-reviews-shortcode-woocommerce' );
define( 'SIP_RSWC_BASENAME', plugin_basename( __FILE__ ) );
define( 'SIP_RSWC_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'SIP_RSWC_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'SIP_RSWC_INCLUDES', SIP_RSWC_DIR . trailingslashit( 'includes' ) );
define( 'SIP_RSWC_PUBLIC', SIP_RSWC_DIR . trailingslashit( 'public' ) );
define( 'SIP_RSWC_PLUGIN_PURCHASE_URL', 'https://shopitpress.com/plugins/sip-reviews-shortcode-woocommerce/' );

/**
 * The code that runs during plugin activation.
 * To Run the activation  code
 * This action is documented in includes/class-sip-reviews-shortcode-activator.php
 */
function activate_sip_reviews_shortcode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sip-reviews-shortcode-activator.php';
	SIP_Reviews_Shortcode_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * To Run the deactivation  code
 * This action is documented in includes/class-sip-reviews-shortcode-deactivator.php
 */
function deactivate_sip_reviews_shortcode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sip-reviews-shortcode-deactivator.php';
	SIP_Reviews_Shortcode_Deactivator::deactivate();
}

/**
 * To chek the woocommerce is active or not
 *
 * @since    1.0.0
 * @access   public
 */
function sip_rswc_activate () {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin = plugin_basename( __FILE__ );

	if( !class_exists( 'WooCommerce' ) ) {
		deactivate_plugins( $plugin );
		add_action( 'admin_notices', 'sip_reviews_shortcode_admin_notice_error' );
	}
}

function sip_reviews_shortcode_admin_notice_error() {
	$class = 'notice notice-error';
	$message = __( 'SIP Reviews Shortcode for WooCommerce requires <a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce</a> plugin to be active!', 'sip-reviews-shortcode' );

	printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sip-reviews-shortcode.php';

/**
 * Begins execution of the reviews shortcode plugin.
 *
 * @since    1.0.4
 */
function run_sip_reviews_shortcode() {

	$plugin = new SIP_Reviews_Shortcode();
	$plugin->run();
}
run_sip_reviews_shortcode();