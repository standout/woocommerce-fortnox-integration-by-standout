<?php

/**
 * The main plugin file for WooCommerce-Fortnox-Integration by Standout.
 *
 * @package   WooCommerce_Fortnox_Integration_by_Standout
 * @license   GPL-3.0
 * @link      https://standout.se
 *
 * @wordpress-plugin
 * Plugin Name: Woocommerce-Fortnox-Integration by Standout
 * Plugin URI: https://standout.se/integrationer/woocommerce-fortnox/
 * Description: Plugin that integrates Woocommerce with Fortnox.
 * Version: 1.1.1
 * Author: Standout
 * Author URI: https://standout.se
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: fortnox-integration
 * Domain Path: /languages
 * Copyright: Standout AB
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/classes/woocommerce-integration.php';
require_once __DIR__ . '/includes/admin/class-fortnox-settings.php';

function set_app_name() {
    return $app_name = "Woocommerce-Fortnox-Integration";
}

function create_api_keys() {
    if (!wp_verify_nonce($_POST['nonce'], 'ajax-fortnox-integration')) {
        wp_die();
    }

    $app_user_id = get_user_id();
    $app_name = set_app_name();
    $scope = "Standout";
    $woocommerce_integration = new WoocommerceIntegration();
    $woocommerce_integration->generate_api_keys($app_user_id, $app_name, $scope);
}
add_action('wp_ajax_connect_to_fortnox', 'create_api_keys', 5);

function json_to_fortnox() {
    global $wpdb;
    $current_user_id = get_user_id();
    $stored_woo_api_keys = $wpdb->get_results("SELECT consumer_key,consumer_secret FROM wp_woocommerce_api_keys WHERE user_id =".$current_user_id);
    $fortnox_auth_key = get_option('fortnox_authorization_key');
    $fortnox_key_id = get_option('fortnox_id_key');
    $consumer_key = $stored_woo_api_keys[0]->consumer_key;
    $consumer_secret = $stored_woo_api_keys[0]->consumer_secret;
    $domain = $_SERVER['SERVER_NAME'];

    $response = array(
        'fortnox_auth_key' => $fortnox_auth_key,
        'fortnox_key_id'=> $fortnox_key_id,
        'woo_consumer_key'=> $consumer_key,
        'woo_consumer_secret' => $consumer_secret,
        'domain' => $domain
    );

    wp_send_json($response);
}
add_action('wp_ajax_connect_to_fortnox', 'json_to_fortnox', 10);

function destroy_api_keys() {
    if (!wp_verify_nonce($_POST['nonce'], 'ajax-fortnox-integration')) {
        wp_die();
    }

    $woocommerce_integration = new WoocommerceIntegration();
    $woocommerce_integration->destroy_api_keys();
}
add_action('wp_ajax_disconnect_from_fortnox', 'destroy_api_keys');

function get_user_id() {
    $current_user = wp_get_current_user();

    if (!($current_user instanceof WP_User)) {
        return;
    }

    return $current_user->ID;
}
add_action('plugins_loaded', 'get_user_id', 5);

function admin_ajax() {
    wp_enqueue_script('ajax-script', plugins_url('/includes/admin/js/admin.js', __FILE__), array('jquery'), '1.1.1');

    wp_localize_script('ajax-script', 'fortnox', array(
        'nonce' => wp_create_nonce('ajax-fortnox-integration'),
    ));
}
add_action('admin_enqueue_scripts', 'admin_ajax');

function fortnox_integration_load_textdomain() {
  load_plugin_textdomain( 'fortnox-integration', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'fortnox_integration_load_textdomain' );
