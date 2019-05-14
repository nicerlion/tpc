<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Credit Card Payment Gateway
 *
 * @since       2.6.0
 * @package		WooCommerce/Classes
 * @author 		WooThemes
 */
class Limelight_Payment_CC extends WC_Payment_Gateway {

	/**
	 * Builds our payment fields area - including tokenization fields for logged
	 * in users, and the actual payment fields.
	 * @since 2.6.0
	 */
	public function payment_fields() {
		if ( $this->supports( 'tokenization' ) && is_checkout() ) {
			$this->tokenization_script();
			$this->saved_payment_methods();
			$this->form();
			$this->save_payment_method_checkbox();
		} else {
			$this->form();
		}
	}

	/**
	 * Output field name HTML
	 *
	 * Gateways which support tokenization do not require names - we don't want the data to post to the server.
	 *
	 * @since  2.6.0
	 * @param  string $name
	 * @return string
	 */
	public function field_name( $name ) {
		return $this->supports( 'tokenization' ) ? '' : ' name="' . esc_attr( $this->id . '-' . $name ) . '" ';
	}

	/**
	 * Outputs fields for entering credit card information.
	 * @since 2.6.0
	 */
	public function form() {
		wp_enqueue_script( 'wc-credit-card-form' );

		$args = array(
    		'post_type' => 'page',
    		'meta_key' => '_wp_page_template',
    		'meta_value' => 'page-billing-information.php',
    		'posts_per_page' => 1,
    		'order'   => 'DESC'
		);
		$attractions  = new WP_Query($args); 
		while($attractions->have_posts()) : $attractions->the_post(); 
			$label_ct = get_field('label_ct');
			$description_ct = get_field('description_ct');
		   	$card_image = get_field('card_image');
			$label_cn = get_field('label_cn');
			$description_cn = get_field('description_cn');
			$label_ex = get_field('label_ex');
			$description_ex = get_field('description_ex');
			$label_cc = get_field('label_cc');
			$description_cc = get_field('description_cc');
			$cvc_image = get_field('cvc_image');
		endwhile; 
		// Restore original post data.
		wp_reset_postdata();

		$fields = array();
		$cvc_img = "";
		if( !empty($cvc_image) ){
			$cvc_img = "<img src='".$cvc_image['url']."' alt='".$cvc_image['alt']."' class='img-cvc' />";
		}
		$card_img = "";
		if( !empty($card_image) ){
			$card_img = "<img src='".$card_image['url']."' alt='".$card_image['alt']."' class='tpc-card-img' />";
		}

		$cvc_field = '<p class="form-row form-row-last">
			<label for="' . esc_attr( $this->id ) . '-card-cvc">' . esc_html__( $label_cc , 'woocommerce' ) . ' <span class="required">*</span></label>
			<span class="' . esc_attr( $this->id ) . '-card-description">'.$description_cc.'</span>
			<input id="' . esc_attr( $this->id ) . '-card-cvc" class="input-text wc-credit-card-form-card-cvc" inputmode="numeric" autocomplete="off" autocorrect="no" autocapitalize="no" spellcheck="no" type="tel" maxlength="4" placeholder="' . esc_attr__( 'CVC', 'woocommerce' ) . '" ' . $this->field_name( 'card-cvc' ) . ' style="width:100px" />
			'.$cvc_img.'
		</p>';

		$default_fields = array(
			'card-type-field' => '<p class="form-row form-row-wide">
				<label for="' . esc_attr($this->id) . '-card-type">' . esc_html__($label_ct , 'woocommerce') . '<span class="required">*</span></label>
				<span class="' . esc_attr( $this->id ) . '-card-description">'.$description_ct.'</span>
				<select id="' . esc_attr($this->id) . '-card-type" class="input-select wc-credit-card-form-card-type" inputmode="select" autocomplete="cc-type" autocorrect="no" autocapitalize="no" spellcheck="no" ' . $this->field_name('card-type') . '>
					<option value="visa">Visa</option>
					<option value="discover">Discover</option>
					<option value="amex">AMEX</option>
					<option value="master">Mastercard</option>
				</select>
				'.$card_img.'
				<script>
				jQuery(document).ready(function () {
					jQuery("#' . esc_attr($this->id) . '-card-type").selectWoo();
				})
				</script>
			</p>',
			'card-number-field' => '<p class="form-row form-row-wide">
				<label for="' . esc_attr( $this->id ) . '-card-number">' . esc_html__( $label_cn , 'woocommerce' ) . ' <span class="required">*</span></label>
				<span class="' . esc_attr( $this->id ) . '-card-description">'.$description_cn.'</span>
				<input id="' . esc_attr( $this->id ) . '-card-number" class="input-text wc-credit-card-form-card-number" inputmode="numeric" autocomplete="cc-number" autocorrect="no" autocapitalize="no" spellcheck="no" type="tel" placeholder="&bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull;" ' . $this->field_name( 'card-number' ) . ' />
			</p>',
			'card-expiry-field' => '<p class="form-row form-row-first">
				<label for="' . esc_attr( $this->id ) . '-card-expiry">' . esc_html__(  $label_ex , 'woocommerce' ) . ' <span class="required">*</span></label>
				<span class="' . esc_attr( $this->id ) . '-card-description">'.$description_ex.'</span>
				<input id="' . esc_attr( $this->id ) . '-card-expiry" class="input-text wc-credit-card-form-card-expiry" inputmode="numeric" autocomplete="cc-exp" autocorrect="no" autocapitalize="no" spellcheck="no"  maxlength="7" type="tel" placeholder="' . esc_attr__( 'MM / YY', 'woocommerce' ) . '" ' . $this->field_name( 'card-expiry' ) . ' />
            </p>',
		);

		if ( ! $this->supports( 'credit_card_form_cvc_on_saved_method' ) ) {
			$default_fields['card-cvc-field'] = $cvc_field;
		}

		$fields = wp_parse_args( $fields, apply_filters( 'woocommerce_credit_card_form_fields', $default_fields, $this->id ) );
		?>

		<fieldset id="wc-<?php echo esc_attr( $this->id ); ?>-cc-form" class='wc-credit-card-form wc-payment-form'>
			<?php do_action( 'woocommerce_credit_card_form_start', $this->id ); ?>
			<?php
				foreach ( $fields as $field ) {
				echo $field;
				}
			?>
			<?php do_action( 'woocommerce_credit_card_form_end', $this->id ); ?>
			<div class="clear"></div>
		</fieldset>
		<?php

		if ( $this->supports( 'credit_card_form_cvc_on_saved_method' ) ) {
			echo '<fieldset>' . $cvc_field . '</fieldset>';
		}
	}
}
