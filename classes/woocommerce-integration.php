<?php
/**
 * Provides functions for the plugin settings page in the WordPress admin.
 * @license   GPL-3.0
 */

class WoocommerceIntegration {

    public function user_has_api_key($user_id) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT consumer_key FROM wp_woocommerce_api_keys WHERE description = 'Woocommerce-Fortnox-Integration'");
        $value = true;

        if (count($result) == 1) {
            $value = false;
        } else {
            $value = true;
        }

        return $value;
    }

    public function generate_api_keys($user_id, $app_name, $scope) {
        if (!$this->user_has_api_key($user_id)) {
            return;
        }

        global $wpdb;

        $user = wp_get_current_user();

        // Created API keys.
        $permissions = in_array($scope, array('read', 'write', 'read_write'), true) ? sanitize_text_field($scope) : 'read_write';
        $consumer_key = 'ck_' . wc_rand_hash();
        $consumer_secret = 'cs_' . wc_rand_hash();

        $wpdb->insert(
            $wpdb->prefix . 'woocommerce_api_keys',
            array(
                'user_id' => $user->ID,
                'description' => $app_name,
                'permissions' => $permissions,
                'consumer_key' => wc_api_hash($consumer_key),
                'consumer_secret' => $consumer_secret,
                'truncated_key' => substr($consumer_key, -7),
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            )
        );

        add_option( 'woo_key_id', $wpdb->insert_id, '', 'yes' );

        return array(
            'key_id' => $wpdb->insert_id,
            'user_id' => $user_id,
            'consumer_key' => $consumer_key,
            'consumer_secret' => $consumer_secret,
            'key_permissions' => $permissions,
        );
    }

    public function destroy_api_keys() {
        global $wpdb;
        $key_id = get_option('woo_key_id');
        $wpdb->delete('wp_woocommerce_api_keys', array('key_id' => $key_id));
        delete_option('woo_key_id');
    }
}
