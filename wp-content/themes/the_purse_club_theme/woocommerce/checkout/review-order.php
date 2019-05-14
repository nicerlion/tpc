<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
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
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php 
    $args = array(
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-billing-information.php',
        'posts_per_page' => 1,
        'order'   => 'DESC'
    );
    $attractions  = new WP_Query($args); 
    while($attractions->have_posts()) : $attractions->the_post(); 
       $title_s3 = get_field('title_s3');
       $content_text_s3 = get_field('content_text_s3');
       $shipping_estimate = do_shortcode( get_field('shipping_estimate'));
       $title_terms_conditions = get_field('title_terms_conditions');
       $text_terms_conditions = get_field('text_terms_conditions');
    endwhile; 
    // Restore original post data.
    wp_reset_postdata();
?>
<table class="shop_table woocommerce-checkout-review-order-table">
	<thead>
		<tr>
			<th colspan="3" class="product-label-titel">
				<h2><?php echo $title_s3; ?></h2>
			</th>
		</tr>
		<tr>
			<th class="product-titel-label-left"></th>
			<th class="product-titel-label-left">
				<p><?php echo $content_text_s3; ?></p>
			</th>
			<th class="product-titel-label-right">
				<p>Price</p>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
			do_action( 'woocommerce_review_order_before_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
						<td class="product-img">
							<?php 
							$thumbID = get_post_thumbnail_id( $cart_item["product_id"] );
							$imgDestacada = wp_get_attachment_image_src( $thumbID, 'full' );
							?>
							<img src="<?php echo $imgDestacada[0]; ?>">
						</td>
						<td class="product-name">
							<p class="tpc-td-big"><?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;'; ?>
							<?php if ($cart_item['quantity'] != 1): ?>
								<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
								<?php echo WC()->cart->get_item_data( $cart_item ); ?>
							<?php endif ?>
							</p>
							<p class="tpc-td-text"><?php echo get_post($cart_item["product_id"])->post_excerpt; ?></p>
						</td>
						<td class="tpc-td-big product-total">
							<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );  ?>
							<!--<p>$<?php // echo $_product->get_sign_up_fee(); ?></p>
							<?php // var_dump($cart_item); ?>
							<?php // echo $_product->_subscription_sign_up_fee; ?>-->
						</td>
					</tr>
					<?php
				}
			}

			do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot>

		<?php /* <tr class="cart-subtotal">
			<th><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr> */ ?>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<td class="tpc-boder-none"></td>
				<td class="tpc-td-big"><?php wc_cart_totals_coupon_label( $coupon ); ?></td>
				<td class="tpc-coupon-cart tpc-td-big"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php /* if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) { ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php } */ ?>

		<tr class="shipping">
			<td class="tpc-boder-none"></td>
			<td class="tpc-td-big">Shipping and Handling</td>
			<td class="tpc-td-big tpc-shipping">$0.00</td>
		</tr>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<td class="tpc-boder-none"></td>
				<td  class="tpc-td-big"><?php echo esc_html( $fee->name ); ?></td>
				<td  class="tpc-td-big"><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
						<td class="tpc-boder-none"></td>
						<td  class="tpc-td-big"><?php echo esc_html( $tax->label ); ?></td>
						<td  class="tpc-td-big"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<td class="tpc-boder-none"></td>
					<td  class="tpc-td-big"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></td>
					<td  class="tpc-td-big"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total">
			<td class="tpc-boder-none"></td>
			<td  class="tpc-td-big">Your Total<?php //_e( 'Total', 'woocommerce' ); ?></td>
			<td  class="tpc-td-big"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>
		<tr class="tpc-order-detail">
			<td  class="tpc-td-big tpc-order-date" colspan="3"><?php echo $shipping_estimate; ?></td>
		</tr>
		<tr class="tpc-order-detail">
			<td  class="tpc-boder-none tpc-coupon" colspan="3"><?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?></td>
		</tr>
		<tr class="tpc-order-detail">
			<td  class="tpc-boder-none" colspan="3">
				<?php 
				    $args = array(
				    'post_type' => 'page',
				    'meta_key' => '_wp_page_template',
				    'meta_value' => 'page-billing-information.php',
				    'posts_per_page' => 1,
				    'order'   => 'DESC'
					);
					$attractions  = new WP_Query($args); 
					while($attractions->have_posts()) : $attractions->the_post(); 
					   $title_terms_conditions = get_field('title_terms_conditions');
					   $text_terms_conditions = get_field('text_terms_conditions');
					endwhile; 
					// Restore original post data.
					wp_reset_postdata();
				?>
				<div class="tpc-terms-conditions-detail">
					<?php if (!empty($title_terms_conditions)): ?>			
				        <h4><?php echo $title_terms_conditions; ?></h4>
					<?php endif ?>
				    <p><?php echo $text_terms_conditions; ?></p>
				</div>
   		 	</td>
		</tr>
		<?php // do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>
