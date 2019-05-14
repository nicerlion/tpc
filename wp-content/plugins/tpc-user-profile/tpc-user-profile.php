<?php
/**
* Plugin Name: TPC User Profile
* Plugin URI: 
* Description: This plugin adds functions to manage quiz and product shipments.
* Version: 1.0.0
* Author: Reef Studios
* Author URI: http://reefstudios.co
* License: GPL2
*/


if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

 /**
 * Do not allow any subscriptions to be changed to a new payment method.
 */
add_filter( 'woocommerce_can_subscription_be_updated_to_new-payment-method', '__return_false', 100 );

/**
 * Do not allow a customer to resubscribe to an expired or cancelled subscription.
 */
add_filter( 'wcs_can_user_resubscribe_to_subscription', '__return_false', 100 );

/**
 * Do not allow any subscriptions to switched to a different subscription, regardless of settings (more: http://docs.woothemes.com/document/subscriptions/switching-guide/).
 */
//add_filter( 'woocommerce_subscriptions_can_item_be_switched_by_user', '__return_false', 100 );
// OR
//add_filter( 'woocommerce_subscriptions_can_item_be_switched', '__return_false', 100 );


/**
 * Subscriptions Status Changes
 **/

/**
 * Do not allow any subscriptions to be activated or reactivated (not a good idea).
 */
// add_filter( 'woocommerce_can_subscription_be_updated_to_active', '__return_true', 100 );  // prohibe activar

/**
 * Do not allow any subscription to be cancelled, either by the store manager or customer (not a good idea).
 */
add_filter( 'woocommerce_can_subscription_be_updated_to_cancelled', '__return_false', 100 ); // prohibe cancelar

/**
 * Do not allow any subscription to be suspended, either by the store manager or customer (not a good idea).
 */
// add_filter( 'woocommerce_can_subscription_be_updated_to_on-hold', '__return_false', 100 );


/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    // Put your plugin code here

    if (!class_exists('Quiz')) {
        include_once(dirname(__FILE__) . '/class-quiz.php');
        include_once(dirname(__FILE__) . '/class-card-user-data.php');
        include_once(dirname(__FILE__) . '/functions.php');
    }

    function tpc_user_install() {
        Quiz::create_database();
        Card_User_Data::create_database();
    }

    add_action('init', 'test_data', 999);
    function test_data() {
        // $subscription = new WC_Subscription(841);
        // $last_order = wc_get_order($subscription->get_last_order());
        // if (!$last_order) {
        //     $last_order = $subscription;
        // }
        // $billing = $last_order->data['billing'];
        // $shipping = $last_order->data['shipping'];
        // // $last_order->get_adress();  Comented
        // $products_ids = get_products_by_subscription($subscription);  // Productos filtrados por subscripcion y membresia.
        // $customer_id = $subscription->data['customer_id'];;
        // $quiz = Quiz::get_from_user_id($customer_id);
        // $product = get_product_for_tcp_user($quiz, $products_ids);
        // // $order = create_order($product, $customer_id, $billing, $shipping);
    }

    add_action('woocommerce_subscription_payment_complete', 'set_product_for_users', 999);
    function set_product_for_users($subscription) {
        $last_order = wc_get_order($subscription->get_last_order());
        if (!$last_order) {
            $last_order = $subscription;
        }

        $data = $last_order->get_data();
        $customer_id = $data['customer_id'];
        $billing = $data['billing'];
        $shipping = $data['shipping'];
        $orders = count( get_posts(array(
            'numberposts' => -1,
            'meta_key' => '_customer_user',
            'meta_value' => $customer_id,
            'post_type' => 'shop_subscription',
            'post_status' => array_keys( wc_get_order_statuses() )
        )) );

        if ($orders) {
            $products_ids = get_products_by_subscription($subscription);  // Productos filtrados por subscripcion y membresia.
            $quiz = Quiz::get_from_user_id($customer_id);
            $product = get_product_for_tcp_user($quiz, $products_ids);
            create_order($product, $last_order);
        }
    }

    register_activation_hook(__FILE__, 'tpc_user_install');
}

?>
