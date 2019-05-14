<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
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
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="container">
	<div class="woocommerce-order">

			<?php if ( $order ) : ?>

				<?php if ( $order->has_status( 'failed' ) ) : ?>

					<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

					<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
						<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
						<?php if ( is_user_logged_in() ) : ?>
							<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'woocommerce' ); ?></a>
						<?php endif; ?>
					</p>

				<?php else : ?>

				<div class="Thank-you-box">

					<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); ?></p>

						<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

							<li class="woocommerce-order-overview__order order">
								<?php _e( 'Order number:', 'woocommerce' ); ?>
								<strong><?php echo $order->get_order_number(); ?></strong>
							</li>

							<li class="woocommerce-order-overview__date date">
								<?php _e( 'Date:', 'woocommerce' ); ?>
								<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
							</li>

							<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
								<li class="woocommerce-order-overview__email email">
									<?php _e( 'Email:', 'woocommerce' ); ?>
									<strong><?php echo $order->get_billing_email(); ?></strong>
								</li>
							<?php endif; ?>

							<li class="woocommerce-order-overview__total total">
								<?php _e( 'Total:', 'woocommerce' ); ?>
								<strong><?php echo $order->get_formatted_order_total(); ?></strong>
							</li>

							<?php if ( $order->get_payment_method_title() ) : ?>
								<li class="woocommerce-order-overview__payment-method method">
									<?php _e( 'Payment method:', 'woocommerce' ); ?>
									<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
								</li>
							<?php endif; ?>

						</ul>
					</div>
				<?php endif; ?>

				<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
				<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

			<?php else : ?>

				<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

			<?php endif; ?>
			<div class="receipt-go-button">
				<a href="<?php echo esc_url( home_url(  ) ); ?>">GO BACK TO HOME</a>	
			</div>
		
	</div>
</div>
<?php
	$url = $_SERVER["REQUEST_URI"];
	$string_value = '/order-received';
	$strpos = strpos($url, $string_value);
?>
<?php  if ( $strpos != false ){ ?>
	<!-- Facebook Pixel Code -->
	<script>
		!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
		n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
		document,'script','//connect.facebook.net/en_US/fbevents.js');

		fbq('init', '559415867727666');
		fbq('track', 'PageView');
		fbq('track', 'Purchase', {value: <?php echo $order->get_total(); ?>,currency: 'USD'});
	</script>
	<noscript><img height='1' width='1' style='display:none' src='https://www.facebook.com/tr?id=559415867727666&ev=PageView&noscript=1' /></noscript>
	<!-- End Facebook Pixel Code -->

	<script>!function(s,a,e,v,n,t,z){if(s.saq)return;n=s.saq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!s._saq)s._saq=n;n.push=n;n.loaded=!0;n.version='1.0';n.queue=[];t=a.createElement(e);t.async=0;t.src=v;z=a.getElementsByTagName(e)[0];z.parentNode.insertBefore(t,z)}(window,document,'script','https://tags.srv.stackadapt.com/events.js');saq('conv','Ef9XveXNVxwqxOFLKMKL9A');</script>
	<noscript><img src='https://srv.stackadapt.com/conv?cid=Ef9XveXNVxwqxOFLKMKL9A' width='1' height='1'/></noscript>
	
	<!-- Retargeting Exclusion -->
	<script>!function(s,a,e,v,n,t,z){if(s.saq)return;n=s.saq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!s._saq)s._saq=n;n.push=n;n.loaded=!0;n.version='1.0';n.queue=[];t=a.createElement(e);t.async=0;t.src=v;z=a.getElementsByTagName(e)[0];z.parentNode.insertBefore(t,z)}(window,document,'script','https://tags.srv.stackadapt.com/events.js');saq('rt', 'CgqCW1JkfKNE3Qw-jSaTpA');</script>
	<noscript><img src='https://srv.stackadapt.com/rt?sid=CgqCW1JkfKNE3Qw-jSaTpA' width='1' height='1'/></noscript>
	<!-- End Retargeting Exclusion -->

	<script data-obct type="text/javascript">
 		!function(_window, _document) {var OB_ADV_ID='00b5a9b1dadfa04dd7ff405d1b456a9f8b';if (_window.obApi) {var toArray = function(object) {return Object.prototype.toString.call(object) === '[object Array]' ? object : [object];};_window.obApi.marketerId = toArray(_window.obApi.marketerId).concat(toArray(OB_ADV_ID));return;} var api = _window.obApi = function() {api.dispatch ? api.dispatch.apply(api, arguments) : api.queue.push(arguments);};api.version = '1.1';api.loaded = true;api.marketerId = OB_ADV_ID;api.queue = [];var tag = _document.createElement('script');tag.async = true;tag.src = '//amplify.outbrain.com/cp/obtp.js';tag.type = 'text/javascript';var script = _document.getElementsByTagName('script')[0];script.parentNode.insertBefore(tag, script);}(window, document); obApi('track', 'PAGE_VIEW');
	</script>

	<script type="text/javascript">
		window._tfa = window._tfa || [];
		_tfa.push({ notify: 'action',name: 'Conversion' });
	</script>
	<script src="//cdn.taboola.com/libtrc/vader-sc-sc/tfa.js"></script>

<?php } ?>

