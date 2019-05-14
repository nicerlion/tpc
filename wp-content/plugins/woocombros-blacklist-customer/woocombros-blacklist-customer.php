<?php

/**
 * Plugin Name: WooComBros Blacklist Customer
 * Plugin URI: http://woocombros.com/blacklist_customer
 * Description: WooCommerce plugin to block fraud users from making purchases.
 * Version: 1.0.0
 * Author: WooComBros
 * Author URI: http://woocombros.com/
 * Text Domain: woocommerce-extension
 * Domain Path: /languages
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (!function_exists('write_log')) {

    function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

}
    

/**
 * Check if WooCommerce is active
 * */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {


    function wcbros_blacklist_activate() {
        if ( post_type_exists( 'blacklist_violation' ) ) {
            register_post_type( 'blacklist_violation',
                        array(
                          'public' => false
                        )
                      );
        }
    }
    register_activation_hook( __FILE__, 'wcbros_blacklist_activate' );


    require_once 'includes/validators/class-wcbros-blacklist-validator.php';
    require_once 'includes/violations/class-wcbros-blacklist-violation.php';

    class WCBros_Blacklist_Customer {

        /**
         * Constructor. 
         * Declaring all the filters in constructor. 
         */
        function __construct() {
            add_action('woocommerce_after_checkout_validation', array($this, 'woocommerce_after_checkout_validation'));
            add_filter( 'woocommerce_get_settings_pages', array($this, 'add_blacklist_settings_page'));
        }

        function woocommerce_after_checkout_validation(){
            global $woocommerce;
            write_log('Inside after checkout method');
            $validator = new WCBros_Blacklist_Validator();
            $checkout = $woocommerce -> checkout();
            list($status, $rule) = $validator -> validate_checkout($checkout);
            if(!$status){
                //Create blacklist violation object
                $violation = new WCBros_Blacklist_Violation($rule, $checkout);
                //Create custom post 
                $violation_post = array(
                    'post_title' => 'violation',
                    'post_content' => base64_encode(serialize($violation)),
                    'post_type' => 'blacklist_violation'
                ); 
                //Save custom post in database
                wp_insert_post($violation_post);
                wc_add_notice('Due to some technical difficulty checkout is '
                                    . 'not possible', 'error');
                return false;
            }
            return true;
        }


        function add_blacklist_settings_page( $settings ) {
            $settings[] = include( 'includes/setting/class-wcbros-settings-blacklist.php' );  
            return $settings;
        }
        
    }

    new WCBros_Blacklist_Customer();
}
?>
