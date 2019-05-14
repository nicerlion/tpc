<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<table class='form-table'>
    <tbody>
        <tr id="error-row" style="color: red"></tr>
        <tr>
            <th class="titledesc" scope="row"><lable><?php _e( 'Rule type: ', 'woocommerce' ); ?></lable></th>
            <td>
                <select name="select_rule_type" id="select_rule_type">
                    <option value="email">Email</option>
                    <option value="ip">IP Address</option>
                    <option value="country">Country</option>
                </select>
            </td>
        </tr>
        <tr>
            <th class="titledesc" scope="row"><lable><?php _e( 'Modifier: ', 'woocommerce' ); ?></lable></th>
            <td>
                <select name="select_modifier_type" id="select_modifier_type">
                    <option value="is">Is</option>
                    <option value="include">Include</option>
                </select>
            </td>
        </tr>
        <tr id="value_row">
            <th class="titledesc" scope="row"><lable><?php _e( 'Value: ', 'woocommerce' ); ?></lable></th>
            <td>
                <input type="text" name="rule_value" id="rule_value"/>
            </td>
        </tr>
        <tr id="country_value_row">
            <th class="titledesc" scope="row"><lable><?php _e( 'Value: ', 'woocommerce' ); ?></lable></th>
            <td>
                <select name="rule_country_value" id="rule_country_value">
                <?php
                    foreach($wc_countries as $country_code => $country_name ){
                ?>
                    <option value="<?php echo $country_code ?>"><?php echo $country_name ?></option>
                <?php } ?>
                </select>
            </td>
        </tr>
    </tbody>
</table>

<script type="text/javascript">
    jQuery(function() {


        jQuery.addOptions = function(curr_elem, option_val, option_text){
            curr_elem.append(jQuery('<option>', {
                value: option_val,
                text: option_text
            }));
        }

        jQuery.showCountries = function(){
           jQuery("#country_value_row").show();
           jQuery("#value_row").hide();
        }

        jQuery.hideCountries = function(){
            jQuery("#country_value_row").hide();
            jQuery("#value_row").show();
        }

        jQuery.hideCountries();
        
        jQuery('#select_rule_type').change(function(){
          var modifier = '#select_modifier_type';
          jQuery(modifier).find('option').remove().end();
          if( jQuery(this).val() == 'email' ){
             jQuery.hideCountries();
             jQuery.addOptions(jQuery(modifier), 'is', 'Is'); 
             jQuery.addOptions(jQuery(modifier), 'includes', 'Includes'); 
          }else if( jQuery(this).val() == 'ip' ){
             jQuery.hideCountries();
             jQuery.addOptions(jQuery(modifier), 'is', 'Is'); 
          }else if( jQuery(this).val() == 'country' ){
              jQuery.showCountries();
             jQuery.addOptions(jQuery(modifier), 'is', 'Is'); 
          }
        });

        jQuery('.submit').on('click',function(event){
            if(!(jQuery('#rule_value').val() || 
                    jQuery('#rule_country_value').val() )){
                jQuery('#error-row').html("Value field cannot be empty");
                event.preventDefault();
            }
        });

    });
</script>