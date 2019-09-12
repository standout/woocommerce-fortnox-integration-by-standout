<?php

/**
 * Provides the settings page for the plugin in the WordPress admin.
 * Settings can be accessed at WooCommerce -> Settings -> Fortnox Integration.
 * @license   GPL-3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WC_Settings_Fortnox', false)):
    function fortnox_add_settings() {
        class WC_Settings_Fortnox extends WC_Settings_Page {

            public function __construct() {
                $this->id = 'fortnox-integration';
                $this->label = __('Fortnox Integration', 'fortnox-integration');
                add_filter('woocommerce_settings_fortnox_integration', array($this, 'link_button'), 20);
                add_action('woocommerce_settings_' . $this->id, array($this, 'output'));
                parent::__construct();
            }

            public function get_sections() {
                $sections = array(
                    '' => __('General', 'fortnox-integration'),
                );

                return apply_filters('woocommerce_get_sections_' . $this->id, $sections);
            }

            public function link_button() {
                $woocommerce_integration = new WoocommerceIntegration();

                $connected = $woocommerce_integration->user_has_api_key(get_user_id());
                if (get_option('fortnox_authorization_key') == "" or get_option('fortnox_id_key') == "") {
                    echo __('Please enter the Fortnox API Key and ID Key before you can connect to Fortnox.', 'fortnox-integration');
                } else {
                    echo '<tr valign="top">';
                    echo '<th scope="row">';
                    if ($connected) {
                        echo '<label for="connect_to_fortnox">' . __('Connect to Fortnox', 'fortnox-integration') . '<span class="woocommerce-help-tip" data-tip="' . __('Connect the plugin to Fortnox', 'fortnox-integration') . '"></span></label>';
                    } else {
                        echo '<label for="disconnect_from_fortnox">' . __('Disconnect from Fortnox', 'fortnox-integration') . '<span class="woocommerce-help-tip" data-tip="' . __('Disconnect the plugin from Fortnox', 'fortnox-integration') . '"></span></label>';
                    }
                    echo '</th>';
                    echo '<td class="forminp forminp-button">';
                    if ($connected) {
                        echo '<button name="connect_to_fortnox" id="connect_to_fortnox" class="button">' . __('Connect', 'fortnox-integration') . '</button>';
                    } else {
                        echo '<button name="disconnect_from_fortnox" id="disconnect_from_fortnox" class="button">' . __('Disconnect', 'fortnox-integration') . '</button>';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
            }

            public function output() {
                global $current_section;
                $settings = $this->get_settings($current_section);
                WC_Admin_Settings::output_fields($settings);
            }

            public function save() {
                global $current_section;

                $settings = $this->get_settings($current_section);
                WC_Admin_Settings::save_fields($settings);
            }

            public function get_settings($current_section = '') {
                $settings = array();
                if ($current_section == '') {
                    $settings = array(
                        array(
                            'title' => __('Fortnox Integration Options', 'fortnox-integration'),
                            'type' => 'title',
                            'desc' => '',
                            'id' => 'fortnox_integration',
                        ),
                        array(
                            'title' => __('Fortnox API Key', 'fortnox-integration'),
                            'type' => 'text',
                            'desc' => __('We use this to connect Fortnox with our integration', 'fortnox-integration'),
                            'desc_tip' => true,
                            'default' => '',
                            'id' => 'fortnox_authorization_key',
                        ),
                        array(
                            'title' => __('Your ID-Key', 'fortnox-integration'),
                            'type' => 'text',
                            'desc' => __('The key you received in connection with the purchase', 'fortnox-integration'),
                            'desc_tip' => true,
                            'default' => '',
                            'id' => 'fortnox_id_key',
                        ),
                        array(
                            'type' => 'sectionend',
                            'id' => 'fortnox_integration',
                        ),
                    );
                }
                return apply_filters('woocommerce_get_settings_' . $this->id, $settings, $current_section);
            }
        }
        return new WC_Settings_Fortnox();
    }
    add_filter('woocommerce_get_settings_pages', 'fortnox_add_settings', 15);
endif;
