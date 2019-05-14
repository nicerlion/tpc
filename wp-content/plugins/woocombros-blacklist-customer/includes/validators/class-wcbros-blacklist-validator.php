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

if ( ! class_exists( 'WCBros_Blacklist_Validator' ) ) :

    class WCBros_Blacklist_Validator{

        /**
         * Constructor. 
         * Declaring all the filters in constructor. 
         */
        function __construct() {
            

        }

        public function validate_checkout($checkout){
            $saved_rules = json_decode(get_option( 'wcbros_blacklist_rules' ));
            $billing_email = $checkout->posted['billing_email'];
            $user_ip = $this->get_the_user_ip();
            $wc_countries_obj = new WC_Countries(); 
            $countries = $wc_countries_obj->get_countries();
            $user_country_code = $checkout->posted['billing_country'];
            $user_country = $countries[$user_country_code]; 
            $is_blacklist = false;
            $curr_rule = NULL;
            foreach( $saved_rules as $rule ){
                $rule = (array) $rule;
                if ( $rule['rt'] == 'email' ) {
                    $is_blacklist = $this->validate_email($rule, $billing_email);
                    //TODO separation of concern, remove formatting for curr_rule
                    //from here. UI should take resp of this.
                    $curr_rule = 'Email ' . $rule['m1'] . ' ' . $rule['val'];
                }else if( $rule['rt'] == 'ip' ){
                    write_log($user_ip);
                    write_log($rule['val']);
                    $is_blacklist = $this->validate_ip($rule, $user_ip);
                    $curr_rule = 'IP address ' . $rule['m1'] . ' ' . $rule['val'];
                }else if( $rule['rt'] == 'country' ){
                    $is_blacklist = $this->validate_country($rule, $user_country);
                    $curr_rule = 'Country ' . $rule['m1'] . ' ' . $rule['val'];
                }

                if( $is_blacklist ){
                    return array(false, $curr_rule);
                }
            }
            return array(true, $curr_rule);
        }

        function validate_country($rule, $user_country){
            return $rule['val'] == $user_country;
        }

        function validate_email($rule, $email){
            if( $rule['m1'] == 'is' ) {
               return $rule['val'] == $email; 
            }else if ( $rule['m1'] == 'include' ){
               $pattern = '/' . $rule['val'] . '/';
               $m = preg_match($pattern, $email);
               return $m == 1; //$m = 1 means matched
            }
        }

        function validate_ip($rule, $user_ip){
            return $rule['val'] == $user_ip;
        }

        function get_the_user_ip() {
            if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
                //check ip from share internet
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
                //to check ip is pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return apply_filters( 'wpb_get_ip', $ip );
        }

    }
    
endif;


?>
