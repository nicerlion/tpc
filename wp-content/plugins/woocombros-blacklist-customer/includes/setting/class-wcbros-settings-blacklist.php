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

if ( ! class_exists( 'WCBros_Settings_Blacklist' ) ) :

class WCBros_Settings_Blacklist extends WC_Settings_Page{

    public function __construct() {
        $this->id = 'wcbros_blacklist';
        $this->option_name = 'wcbros_blacklist_rules';
        $wc_countries_obj = new WC_Countries(); 
        $this->countries = $wc_countries_obj->get_countries();

        add_filter( 'woocommerce_settings_tabs_array', array($this, 'add_settings_tab'), 50 );
		add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
		add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );
    }


	/**
	 * Get sections
	 *
	 * @return array
	 */
	public function get_sections() {

		$sections = array(
			''          	=> __( 'Current Rules', 'woocommerce' ),
			'add_new_rule'          	=> __( 'Add New Rule', 'woocommerce' ),
			'violations'       => __( 'Violations', 'woocommerce' )
		);

		return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
	}


    function save(){
        global $current_section;
        write_log($_POST);
        if ( $current_section == 'add_new_rule' ){
            $saved_rules = json_decode(get_option( $this->option_name ));
            if( !$saved_rules ){
                $saved_rules = array();
            }
            $new_rule_arr = array();
            $new_rule_arr['rt'] = $_POST['select_rule_type']; //rule type
            $new_rule_arr['m1'] = $_POST['select_modifier_type']; //rule modifier
            if ( $new_rule_arr['rt'] == 'country' ) {
              $country_code = $_POST['rule_country_value']; 
              $new_rule_arr['val'] = $this->countries[$country_code]; //val
            } else {
              $new_rule_arr['val'] = $_POST['rule_value']; //val
            }
            $saved_rules[] = $new_rule_arr; 
            update_option( $this->option_name , json_encode($saved_rules));
        } else if ( $current_section == 'violations' ){
           $deleted_ids = $_POST['deleted-ids']; 
           if( $deleted_ids ){
               $deleted_ids = explode(',', $deleted_ids);
               foreach ($deleted_ids as $deleted_id) {
                   wp_delete_post($deleted_id);
               }
           }
        } else {
           $deleted_ids = $_POST['deleted-ids']; 
           if( $deleted_ids ){
               $deleted_ids = explode(',', $deleted_ids);
               $decoded_saved_rules = json_decode(get_option($this->option_name));
               $saved_rules = array();
               for ($i=0; $i<sizeof($decoded_saved_rules); $i++){
                   write_log($i);
                   write_log($deleted_ids);
                   if (!in_array(strval($i), $deleted_ids)) {
                       $saved_rules[] = (array)$decoded_saved_rules[$i];
                   }
               }
               update_option( $this->option_name, json_encode($saved_rules) );
           }
        }
    }


    public function add_settings_tab($settings_tabs){
        $settings_tabs['wcbros_blacklist'] = __( 'Blacklist', 'wcbros_blacklist' );
        return $settings_tabs; 
    }

    public function output(){
        global $current_section;
        write_log('Inside get_blacklist_setting');
        if ( $current_section == 'add_new_rule' ) {
            $wc_countries = $this->countries; 
            include( 'views/html-settings-new-rule.php' );
        } elseif ( $current_section == 'violations' ) {
            $violations = get_posts(array(
                'post_type' => 'blacklist_violation',
                'post_status' => 'draft'
                ));
            write_log($violations);
            include( 'views/html-settings-violations.php' );
        } else {
            $saved_rules_json = get_option($this->option_name);
            $saved_rules = json_decode($saved_rules_json);
            if( $saved_rules && sizeof($saved_rules) > 0 ){
                include( 'views/html-settings-current-rules.php' );
            }
        }
        //return $sections;
    }

    public function generate_new_rule_html(){
        write_log("Inside generate_new_rule_html method");
    }
}

endif;

return new WCBros_Settings_Blacklist();

?>

