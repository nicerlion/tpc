<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}

$args = array(
    'post_type' => 'page',
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-billing-information.php',
    'posts_per_page' => 1,
    'order'   => 'DESC'
);
$attractions  = new WP_Query($args); 
while($attractions->have_posts()) : $attractions->the_post(); 
   $security_image = get_field('security_image');
   $title_security = get_field('title_security');
   $description_security = get_field('description_security');
endwhile; 
// Restore original post data.
wp_reset_postdata();

?>
<div id="payment" class="woocommerce-checkout-payment">
	<?php 
	if( !empty($security_image) ): ?>
		<div class="secure-box">
			<img src="<?php echo $security_image['url']; ?>" alt="<?php echo $security_image['alt']; ?>" />
			<div class="secure-text">
			<p><?php echo $title_security; ?></p>
			<p class="sm-note"><?php echo $description_security; ?></p>
			</div>
			<div class="cd-spac"></div>
		</div>
	<?php endif; ?>
	<?php if ( WC()->cart->needs_payment() ) : ?>
		<ul class="wc_payment_methods payment_methods methods">
			<?php
				if ( ! empty( $available_gateways ) ) {
					foreach ( $available_gateways as $gateway ) {
						wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
					}
				} else {
					echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? __( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : __( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</li>';
				}
			?>
		</ul>
	<?php endif; ?>
	<div class="validation-terms">
		<?php wc_get_template( 'checkout/terms.php' ); ?>
    	<div class="validation-hover-popup">
    	    <div class="validation-hover-popup-content">
    	        Please check before continue
    	    </div>
    	    <img src="<?php echo get_template_directory_uri(); ?>/img/hint-arrow.png" alt="">
    	</div>
	</div>
	<div class="validation-box-action">
		<div class="form-row place-order display-none" id="place-order-container">
			<noscript>
				<?php _e( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ); ?>
				<br/><input type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>" />
			</noscript>


			<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

			<?php echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />' ); ?>

			<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

			<?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>
		</div>
	</div>
    <?php show_upsell_btn_function(esc_attr( $order_button_text )); ?>
	
	<div class="modal fade" id="upsellModalV1" role="dialog">
		<div id="upsellV1BackPopup" class="back-popup"></div>
		<div class="modal-dialog upsell-modal">
			<div class="modal-content pt-content-box">
					<?php do_action( 'show_upsell_modal_one' ); ?>
			</div>
		</div>
		<div class="sp-clear"></div>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
		<script>
			jQuery('#place_order').live('click', function(){
				jQuery( ".close" ).trigger( "click" );
			});
			jQuery('#upsellV1BackPopup').live('click', function(){
				jQuery( ".close" ).trigger( "click" );
			});
		</script>
	</div>
	<?php show_upsell_modal_two(); ?>
</div>
<?php
if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
