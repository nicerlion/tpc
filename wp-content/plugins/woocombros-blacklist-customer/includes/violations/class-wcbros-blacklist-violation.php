<?php
/**
 * WooComBros Blacklist Settings
 *
 * @author   WooComBros
 * @category Admin
 * @package  WooCommerce/Admin
 * @version  2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


if ( ! class_exists( 'WCBros_Blacklist_Violation' ) ) :
   
    class WCBros_Blacklist_Violation{
        
        /**
         * Constructor. 
         * Declaring all the filters in constructor. 
         */
        function __construct($rule_val, $checkout) {
            $this->rule_val = $rule_val;
            $this->customer_name = $checkout->posted['billing_first_name'] . ' ' . $checkout->posted['billing_last_name'];
            write_log($this->customer_name);
            $this->customer_address = $checkout->posted['billing_address_1'] . ' ' . $checkout->posted['billing_address_2']
                                      . ', ' . $checkout->posted['billing_city'] . ', '  
                                      . ', ' . $checkout->posted['billing_state'] . ', '
                                      . ', ' . $checkout->posted['billing_country'];
            //TODO set timezone to UTC
            $this->date = date('l, F j, Y');
        }
        
    }
    
endif;


?>
