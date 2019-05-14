<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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

wc_print_notices();



// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>
<section class="tpc-page-header"  style="background-image: url(<?php the_field('background_image_ph'); ?>); background-repeat: <?php the_field('background_repeat_ph'); ?>; background-attachment: <?php the_field('background_attachment_ph'); ?>; background-position: <?php the_field('background_position_ph'); ?>; background-size: <?php the_field('background_size_ph'); ?>; background-color: <?php the_field('background_color_ph'); ?>;">
	<div class="container">
		<div class="row">
			<h1><?php the_field('title_ph'); ?></h1>
			<?php 
			$subtitle_ph = get_field('subtitle_ph');
			if( !empty($subtitle_ph) ): ?>
				<h4><?php the_field('subtitle_ph'); ?></h4>
			<?php endif; ?>
			<?php 
			$content_text_ph = get_field('content_text_ph');
			if( !empty($content_text_ph) ): ?>
				<div class="tpc-header-p">
					<p><?php the_field('content_text_ph'); ?></p>
				</div>
			<?php endif; ?>
		</div> <!-- row -->
	</div> <!-- container -->
</section> <!-- tpc-page-header -->
<section class="tpc-page-container tpc-page-billing-information">
	<div class="container">
		<div class="row">
			<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

			<?php if ( $checkout->get_checkout_fields() ) : ?>

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<div class="col2-set" id="customer_details">
					<div class="col-1">
					<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>
					<div class="col-2">
						<?php do_action( 'woocommerce_checkout_shipping' ); ?>
					</div>
				</div>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<?php endif; ?>

			

			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>

			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

			</form>
			<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
		</div><!-- row -->
	</div><!-- container -->
</section><!-- tpc-page-header -->