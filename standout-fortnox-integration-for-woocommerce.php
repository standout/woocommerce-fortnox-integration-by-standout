<?php

/**
 * The main plugin file for WooCommerce-Fortnox-Integration by Standout.
 *
 * @package   Standout_Fortnox_Integration_for_WooCommerce
 * @license   GPL-3.0
 * @link      https://standout.se
 *
 * @wordpress-plugin
 * Plugin Name: Standout Fortnox Integration for WooCommerce
 * Plugin URI: https://standout.se/integrationer/woocommerce-fortnox/
 * Description: Plugin that integrates Woocommerce with Fortnox.
 * Version: 1.1.4
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

require_once __DIR__ . '/classes/sfifw-integration.php';
require_once __DIR__ . '/includes/admin/sfifw-class-fortnox-settings.php';

function sfifw_set_app_name() {
    return $app_name = "Woocommerce-Fortnox-Integration";
}

function sfifw_create_api_keys() {
    if (!wp_verify_nonce($_POST['nonce'], 'ajax-fortnox-integration')) {
        wp_die();
    }

    $app_user_id = sfifw_get_user_id();
    $app_name = sfifw_set_app_name();
    $scope = "Standout";
    $woocommerce_integration = new StandoutFortnoxIntegration();
    $woocommerce_integration->sfifw_generate_api_keys($app_user_id, $app_name, $scope);
}
add_action('wp_ajax_connect_to_fortnox', 'sfifw_create_api_keys', 5);

function sfifw_collect_credentials() {
    global $wpdb;
    $key_id = get_option('woo_key_id');
    $stored_woo_api_keys = $wpdb->get_results("SELECT consumer_key,consumer_secret FROM wp_woocommerce_api_keys WHERE key_id =".$key_id);
    $fortnox_auth_key = get_option('fortnox_authorization_key');
    $fortnox_key_id = get_option('fortnox_id_key');
    $consumer_key = $stored_woo_api_keys[0]->consumer_key;
    $consumer_secret = $stored_woo_api_keys[0]->consumer_secret;
    $domain = $_SERVER['SERVER_NAME'];

    $data = array(
        'fortnox_auth_key' => $fortnox_auth_key,
        'fortnox_key_id'=> $fortnox_key_id,
        'woo_consumer_key'=> $consumer_key,
        'woo_consumer_secret' => $consumer_secret,
        'domain' => $domain
    );
    sfifw_post_credentials($data);
}
add_action('wp_ajax_connect_to_fortnox', 'sfifw_collect_credentials', 10);

function sfifw_post_credentials($data) {
    $base_url = 'https://fortnox-woocommerce.integrationer.se/users/settings/';
    $endpoint = $base_url . $data['fortnox_key_id'];

    $body = [
        'api_settings' => [
            'woocommerce' => [
                'consumer_key' => $data['woo_consumer_key'],
                'consumer_secret' => $data['woo_consumer_secret'],
                'url' => $data['domain']
            ],
            'fortnox_auth_token' => $data['fortnox_auth_key']
        ]
    ];

    $args = array(
        'headers' => array(
            'Content-Type'   => 'application/json',
            'Accept'   => 'application/json',
        ),
        'body'      => json_encode($body),
        'method'    => 'PUT'
    );

    $result = wp_remote_request( $endpoint, $args );
    return is_wp_error($result) ? false : true;
}

function sfifw_destroy_api_keys() {
    if (!wp_verify_nonce($_POST['nonce'], 'ajax-fortnox-integration')) {
        wp_die();
    }

    $woocommerce_integration = new StandoutFortnoxIntegration();
    $woocommerce_integration->sfifw_destroy_api_keys();

    $base_url = 'https://fortnox-woocommerce.integrationer.se/users/settings/';
    $endpoint = $base_url . get_option('fortnox_id_key');

    $args = array(
        'headers' => array(
            'Content-Type'   => 'application/json',
            'Accept'   => 'application/json',
        ),
        'method'    => 'DELETE'
    );

    $result = wp_remote_request( $endpoint, $args );
    return is_wp_error($result) ? false : true;
}
add_action('wp_ajax_disconnect_from_fortnox', 'sfifw_destroy_api_keys');

function sfifw_get_user_id() {
    $current_user = wp_get_current_user();

    if (!($current_user instanceof WP_User)) {
        return;
    }

    return $current_user->ID;
}
add_action('plugins_loaded', 'sfifw_get_user_id', 5);

function sfifw_admin_ajax() {
    wp_enqueue_script('ajax-script', plugins_url('/includes/admin/js/admin.js', __FILE__), array('jquery'), '1.1.4');

    wp_localize_script('ajax-script', 'fortnox', array(
        'nonce' => wp_create_nonce('ajax-fortnox-integration'),
    ));
}
add_action('admin_enqueue_scripts', 'sfifw_admin_ajax');

function sfifw_fortnox_integration_load_textdomain() {
  load_plugin_textdomain( 'fortnox-integration', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'sfifw_fortnox_integration_load_textdomain' );
