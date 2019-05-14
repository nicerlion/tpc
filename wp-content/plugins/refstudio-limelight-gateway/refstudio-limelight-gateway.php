<?php
/**
* Plugin Name: Reefstudios Payment Gateway
* Plugin URI: 
* Description: This plugin is a gateway to connect Woocommerce to Limelight CRM
* Version: 1.0.0
* Author: Reef Studios
* Author URI: http://reefstudios.co
* License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}


if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    global $woocommerce;
    add_action ('plugins_loaded', 'wc_offline_gateway_init', 0); 
    function wc_offline_gateway_init () {
        include_once( 'limelight-gateway.php' );
    
        add_filter ('woocommerce_payment_gateways', 'wc_offline_add_to_gateways');
        function wc_offline_add_to_gateways($gateways) { 
            $gateways[] = 'LimelightPaymentGateway';
            return $gateways; 
        }
    }

    /**
     * Update the order meta with field value
     */
    add_action( 'woocommerce_checkout_update_order_meta', 'custom_payment_update_order_meta' );
    function custom_payment_update_order_meta( $order_id ) {

        if($_POST['payment_method'] != 'limelight')
            return;

        $order = wc_get_order($order_id);
        update_post_meta( $order_id, 'card-number', $_POST['limelight-card-number'] );
        update_post_meta( $order_id, 'card-expiry', $_POST['limelight-card-expiry'] );
        update_post_meta( $order_id, 'card-type', $_POST['limelight-card-type'] );
        update_post_meta( $order_id, 'card-cvc', $_POST['limelight-card-cvc'] );
        update_post_meta( $order_id, 'shipping-cost', $order->get_shipping_total());
    }
};




?>
