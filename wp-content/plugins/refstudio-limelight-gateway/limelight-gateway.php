<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;

/**
 * Puerta de enlace de pago sin conexión
 *
 * Proporciona una puerta de enlace de pago sin conexión; principalmente para propósitos de prueba.
 * Lo cargamos más tarde para asegurar que WC se cargue primero, ya que lo estamos ampliando.
 *
 * @class WC_Gateway_Offline
 * @extender WC_Payment_Gateway
 * @version 1.0.0
 * @package WooCommerce / Classes / Payment
 * @author SkyVerge
 */
class LimelightPaymentGateway extends WC_Payment_Gateway {

    public function __construct() {
        $this->id = 'limelight';
        $this->has_fields = true;
        $this->method_title = 'Limelight';
        $this->title = 'Credit Card';
        $this->icon = null;
        $this->supports = array(
            'default_credit_card_form',
            'refunds',
            'products',
            'subscriptions',
            'subscription_cancellation',
            'subscription_suspension',
            'subscription_reactivation',
            'subscription_amount_changes',
            'subscription_date_changes',
            'subscription_payment_method_change',
            'subscription_payment_method_change_admin',
            // 'gateway_scheduled_payments',
         );
        $this->method_description = 'Is a Limelight payment method';

        $this->init_form_fields();
        $this->init_settings();

        foreach ( $this->settings as $setting_key => $value ) {
            $this->$setting_key = $value;
        }

        $this->product = $this->get_option('product');
        $this->rebill_product = $this->get_option('rebill_product');
        $this->campaign = $this->get_option('campaign');
        $this->rebill_campaign = $this->get_option('rebill_campaign');

        // add_action( 'admin_notices', array( $this,	'do_ssl_check' ) );

        if ( class_exists( 'WC_Subscriptions_Order' ) ) {
			add_action( 'woocommerce_scheduled_subscription_payment_' . $this->id, array( $this, 'scheduled_subscription_payment' ), 10, 2 );
			// add_action( 'wcs_resubscribe_order_created', array( $this, 'delete_resubscribe_meta' ), 10 );
			// add_action( 'wcs_renewal_order_created', array( $this, 'delete_renewal_meta' ), 10 );
			// add_action( 'woocommerce_subscription_failing_payment_method_updated_stripe', array( $this, 'update_failing_payment_method' ), 10, 2 );
			// // display the credit card used for a subscription in the "My Subscriptions" table
			// add_filter( 'woocommerce_my_subscriptions_payment_method', array( $this, 'maybe_render_subscription_payment_method' ), 10, 2 );
			// // allow store managers to manually set Stripe as the payment method on a subscription
			// add_filter( 'woocommerce_subscription_payment_meta', array( $this, 'add_subscription_payment_meta' ), 10, 2 );
			// add_filter( 'woocommerce_subscription_validate_payment_meta', array( $this, 'validate_subscription_payment_meta' ), 10, 2 );
		}
        
        // Save settings
        if ( is_admin() ) {
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
        }		
    }

    /**
     * Initialize Gateway Settings Form Fields
     */
    public function init_form_fields() {
        $this->form_fields = array(
            'enabled' => array(
                'title' => __('Enable/Disable', 'limelight'),
                'type' => 'checkbox',
                'label' => __('Enable Limelight Payment', 'limelight'),
                'default' => 'yes'
            ),
            'title' => array(
                'title' => __('Title', 'limelight'),
                'description' => __('This controls the title for the payment method the customer sees during checkout.', 'limelight'),
                'default' => __('Limelight Payment', 'limelight'),
                'desc_tip' => true,
            ),
            'description' => array(
                'title' => __('Description', 'limelight'),
                'type' => 'textarea',
                'description' => __('Payment method description that the customer will see on your checkout.', 'limelight'),
                'default' => __('Limelight payment method in woocomerce', 'limelight'),
                'desc_tip' => true,
            ),
            'url' => array(
                'title' => 'API URL',
                'description' => __('URL where API requests to limelight.', 'limelight'),
                'default' => __('https://thepurseclub.limelightcrm.com/admin/transact.php'),
                'desc_tip' => true,
            ),
            'username' => array(
                'title' => 'API Username',
                'description' => __('Username to login in limelight API.', 'limelight'),
                'default' => __('developer'),
                'desc_tip' => true,
            ),
            'pass' => array(
                'title' => 'API Password',
                'type' => 'password',
                'description' => __('Password to login in limelight API.', 'limelight'),
                'default' => 'UtsmSMSyTc7F7',
                'desc_tip' => true,
            ),
            'product' => array(
                'title' => __('Limelight Product ID', 'limelight'),
                'label' => __('Product to buy in limelight', 'limelight'),
                'description' => __('It\'s the product used for assign to an order.', 'limelight'),
                'default' => '42',
            ),
            'rebill_product' => array(
                'title' => __('Limelight Product ID for rebill', 'limelight'),
                'label' => __('Product to buy in limelight rebill', 'limelight'),
                'description' => __('It\'s the product used for assign to an order.', 'limelight'),
                'default' => '42',
            ),
            'campaign' => array(
                'title' => __('Limelight Campaign ID', 'limelight'),
                'label' => __('Campaign used in limelight', 'limelight'),
                'description' => __('Campaign used in limelight.', 'limelight'),
                'default' => '2',
            ),
            'rebill_campaign' => array(
                'title' => __('Limelight Campaign ID for rebill', 'limelight'),
                'label' => __('Campaign used in limelight for rebill', 'limelight'),
                'description' => __('Campaign used in limelight for rebill', 'limelight'),
                'default' => '2',
            ),
            'environment' => array(
                'title' => __('Test Mode', 'limelight'),
                'label' => __('Enable Test Mode', 'limelight'),
                'type' => 'checkbox',
                'description' => __('Place the payment gateway in test mode.', 'limelight'),
                'default' => 'no',
            )
        );
    }

    public function get_data($name, $data) {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        }
        return isset($data[$name]) ? $data[$name]: '';
    }

    public function process_payment ($order_id, $data = array()) {
        include_once(ABSPATH . 'wp-content/plugins/tpc-user-profile/class-quiz.php');
        include_once(ABSPATH . 'wp-content/plugins/tpc-user-profile/class-card-user-data.php');

        $order = wc_get_order($order_id);
        // $customer_id = $order->data['customer_id'];
        $customer_id = $order->get_customer_id();
        $order->update_status('on-hold', __('Waiting payment on limelight', 'wc-gateway-offline'));

        $card_number = $this->get_data('limelight-card-number', $data);
        $card_expiry = $this->get_data('limelight-card-expiry', $data);
        $card_cvc = $this->get_data('limelight-card-cvc', $data);
        $card_type = $this->get_data('limelight-card-type', $data);
        $card_number = str_replace(' ', '', $card_number);
        $card_expiry = str_replace('/', '', str_replace(' ', '', $card_expiry));

        $quiz_size = $this->get_data('purse_size', $data);
        $quiz_type = $this->get_data('purse_type', $data);
        $quiz_color = $this->get_data('purse_color', $data);

        $payload = array(
            "username" => $this->username,
            "password" => $this->pass,
            "method" => "NewOrder",

            "creditCardType" => $card_type,
            "creditCardNumber" => $card_number,
            "expirationDate" => $card_expiry,
            "CVV" => $card_cvc,
            "tranType" => "Sale",

            // billing information
            "firstName" => $order->get_billing_first_name(),
            "lastName" => $order->get_billing_last_name(),
            "phone" => $order->get_billing_phone(),
            "email" => $order->get_billing_email(),
            "billingAddress1" => $order->get_billing_address_1(),
            "billingAddress2" => $order->get_billing_address_2(),
            "billingCity" => $order->get_billing_city(),
            "billingState" => $order->get_billing_state(),
            "billingZip" => $order->get_billing_postcode(),
            "billingCountry" => $order->get_billing_country(),

            // shipping information
            "shippingId" => 4,
            "shippingAddress1" => null != $order->get_shipping_address_1() ? $order->get_shipping_address_1(): $order->get_billing_address_1(),
            "shippingAddress2" => null != $order->get_shipping_address_2() ? $order->get_shipping_address_2() : $order->get_billing_address_2(),
            "shippingCity" => null != $order->get_shipping_city() ? $order->get_shipping_city() : $order->get_billing_city(),
            "shippingState" => null != $order->get_shipping_state() ? $order->get_shipping_state() : $order->get_billing_state(),
            "shippingZip" => null != $order->get_shipping_postcode() ? $order->get_shipping_postcode() : $order->get_billing_postcode(),
            "shippingCountry" => null != $order->get_shipping_country() ? $order->get_shipping_country() : $order->get_billing_country(),

            "billingSameAsShipping" => 'no',
            "upsellCount" => 0,
            "productId" => $this->product,
            "campaignId" => $this->environment == 'yes' ? 1 : $this->campaign,
            "notes" => "Test",
            "dynamic_product_price_" . $this->product => $order->get_total(),
            "product_qty_" . $this->product => 1,
            "ipAddress" => $_SERVER['REMOTE_ADDR']
        );

        if (count($data['meta_data'])) {
            foreach ($data['meta_data'] as $meta) {
                if (isset($meta['key']) && $meta['key']) {
                    $payload[$meta['key']] = $meta['value'];
                }
            }
        }

        $response = wp_remote_post($this->url, array(
			'method' => 'POST',
			'body' => http_build_query($payload),
			'timeout' => 90,
			'sslverify' => true,
        ));

        if (is_wp_error($response)) {
            $message = __( 'There is an issue connecting the payment gateway. Sorry for the inconvenience.', 'cwoa-authorizenet-aim' );
            $this->add_error_order($order, $message);
            return array(
				'result'   => 'fail',
                'redirect' => '',
                'message' => $message
			);
        }

		if (empty($response['body'])) {
            $message = __('Limelight\'s Response was not get any data.', 'cwoa-authorizenet-aim');
            $this->add_error_order($order, $message);
            return array(
				'result'   => 'fail',
                'redirect' => '',
                'message' => $message
			);
        }

        $response_body = wp_remote_retrieve_body($response);

        foreach (preg_split("/\r?\n/", $response_body) as $line) {
			$_response = explode("&", $line);
		}

        $response_data = array();
        foreach ($_response as $data) {
            $temp = explode("=", $data);
            $response_data[$temp[0]] = $temp[1];
        }

        $order->add_order_note(((string) $response_body));

        if ((int) $response_data['errorFound']) {
            $message = urldecode($response_data['errorMessage']);
            $this->add_error_order($order, $message);
            return array(
				'result'   => 'fail',
                'redirect' => '',
                'message' => $message
			);
        }

		if ((int) $response_data['responseCode'] == 100) {
            global $woocommerce;

            $quiz = Quiz::get_from_user_id($customer_id);
            $_card = Card_User_Data::get_from_user_id($customer_id);

            if (!isset($quiz->id)) {
                $quiz = new Quiz(array(
                    "size" => $quiz_size,
                    "type" => $quiz_type,
                    "color" => $quiz_color,
                    "member_id" => $customer_id,
                    "membership_id" => 99,
                ));
                $quiz->save();
            }

            if (!isset($_card->id)) {
                $_card = new Card_User_Data(array(
                    "type" => $card_type,
                    "cvv" => $card_cvc,
                    "expiration_date" => $card_expiry,
                    "member_id" => $customer_id,
                    "number" => $card_number,
                    "order_limelight_id" => $response_data['orderId']
                ));
                $_card->save();
            }
			// Payment successful
            $order->add_order_note(__( 'Limelight complete order processing.', 'cwoa-authorizenet-aim' ));
            update_post_meta( $order->get_id(), 'limelight-gateway-id', $response_data['gatewayId'] );
            update_post_meta( $order->get_id(), 'limelight-gateway-descriptor', $response_data['gatewayDescriptor'] );
            update_post_meta( $order->get_id(), 'limelight-gateway-customer-service', $response_data['gatewayCustomerService'] );
            update_post_meta( $order->get_id(), 'limelight-order-id', $response_data['orderId'] );

            // $order->reduce_order_stock();
            // Eliminar carro
            WC()->cart->empty_cart();
			// paid order marked
			$order->payment_complete();

			// this is important part for empty cart
			$woocommerce->cart->empty_cart();

			// Redirect to thank you page
			return array(
				'result' => 'success',
				'redirect' => !count($data) ? $this->get_return_url($order) : '',
			);
		} else {
            // transaction fail
            $message = 'Error: '. $response_data['errorMessage'];
            $this->add_error_order($order, $message);
            return array(
				'result'   => 'fail',
                'redirect' => '',
                'message' => $message
			);
		}
    }

    public function scheduled_subscription_payment( $amount_to_charge, $renewal_order ) {
        include_once(ABSPATH . 'wp-content/plugins/tpc-user-profile/class-quiz.php');
        include_once(ABSPATH . 'wp-content/plugins/tpc-user-profile/class-card-user-data.php');

        $order = $renewal_order; // wc_get_order($order_id);
        $customer_id = $order->get_customer_id();
        $order->update_status('on-hold', __('Waiting payment on limelight', 'wc-gateway-offline'));

        $_parent = WC_Subscriptions_Renewal_Order::get_parent_order($order);
        $_subscriptions = wcs_get_subscriptions_for_renewal_order($order);

        $data = array();
        foreach ($_subscriptions as $subscription) {
            foreach ($subscription->get_meta_data() as $key_data => $meta) {
                $meta_data = $meta->get_data();
                $data[$meta_data['key']] = $meta_data['value'];
            }
            break;
        }
        foreach ($_parent->get_meta_data() as $_m => $meta) {
            $meta_data = $meta->get_data();
            $data[$meta_data['key']] = $meta_data['value'];
        }

        // $parent = wc_get_order($_parent->id);

        $upsells = get_posts(array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'numberposts' => -1,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => 'upsell',
                ),
            )
        ));

        WC()->shipping->load_shipping_methods();
        $shipping_methods = WC()->shipping->get_shipping_methods();
        $shipping_method = $shipping_methods['flat_rate'];

        foreach ($_parent->get_items() as $product) {
            foreach ($upsells as $upsell) {
                if ($product->get_product_id() == $upsell->ID) {
                    $add_product = wc_get_product($product->get_product_id());
                    $order->add_product($add_product);
                    // $cost = $shipping_method->cost;
                    // $_cost = $shipping_method->get_option('cost');
                    $item = new WC_Order_Item_Shipping();
                    $item->set_props( array(
                        'method_title' => $shipping_method->title,
                        'method_id'    => $shipping_method->id,
                        'total'        => $data['shipping-cost'] ? $data['shipping-cost']: 0,
                        'taxes'        => array(),
                        'order_id'     => $order->get_id(),
                    ) );
                    $item->save();
		            $order->add_item( $item );
                    $order->calculate_totals();
                }
            }
        }

        $card_number = $data['card-number'];
        $card_expiry = $data['card-expiry'];
        $card_type = $data['card-type'];
        $card_cvc = $data['card-cvc'];

        // gateway support for older orders
        $exists_gateway = array_key_exists('limelight-gateway-id', $data);

        if ($exists_gateway) {
            $limelight_gateway_id = $data['limelight-gateway-id'];
        } else {
            $limelight_gateway_id = null;
        }

        $card_number = str_replace(' ', '', $card_number);
        $card_expiry = str_replace('/', '', str_replace(' ', '', $card_expiry));

        $payload = array(
            "username" => $this->username,
            "password" => $this->pass,
            "method" => "NewOrder",

            "forceGatewayId" => $limelight_gateway_id,
            "preserve_force_gateway" => 1,
            "creditCardType" => $card_type,
            "creditCardNumber" => $card_number,
            "expirationDate" => $card_expiry,
            "CVV" => $card_cvc,
            "tranType" => "Sale",

            // billing information
            "firstName" => $order->get_billing_first_name(),
            "lastName" => $order->get_billing_last_name(),
            "phone" => $order->get_billing_phone(),
            "email" => $order->get_billing_email(),
            "billingAddress1" => $order->get_billing_address_1(),
            "billingAddress2" => $order->get_billing_address_2(),
            "billingCity" => $order->get_billing_city(),
            "billingState" => $order->get_billing_state(),
            "billingZip" => $order->get_billing_postcode(),
            "billingCountry" => $order->get_billing_country(),

            // shipping information
            "shippingId" => 4,
            "shippingAddress1" => null != $order->get_shipping_address_1() ? $order->get_shipping_address_1(): $order->get_billing_address_1(),
            "shippingAddress2" => null != $order->get_shipping_address_2() ? $order->get_shipping_address_2() : $order->get_billing_address_2(),
            "shippingCity" => null != $order->get_shipping_city() ? $order->get_shipping_city() : $order->get_billing_city(),
            "shippingState" => null != $order->get_shipping_state() ? $order->get_shipping_state() : $order->get_billing_state(),
            "shippingZip" => null != $order->get_shipping_postcode() ? $order->get_shipping_postcode() : $order->get_billing_postcode(),
            "shippingCountry" => null != $order->get_shipping_country() ? $order->get_shipping_country() : $order->get_billing_country(),


            "billingSameAsShipping" => 'no',
            "upsellCount" => 0,
            "productId" => $this->rebill_product,
            "campaignId" => $this->environment == 'yes' ? 1 : $this->rebill_campaign,
            "notes" => "Test",
            "dynamic_product_price_" . $this->rebill_product => $order->get_total(),
            "product_qty_" . $this->rebill_product => 1,
            "ipAddress" => $_SERVER['REMOTE_ADDR']
        );

        $response = wp_remote_post($this->url, array(
			'method' => 'POST',
			'body' => http_build_query($payload),
			'timeout' => 90,
			'sslverify' => true,
        ));

        if (is_wp_error($response)) {
            $message = __('There is an issue connecting the payment gateway. Sorry for the inconvenience.', 'wc-gateway-offline');
            $order->add_order_note($message);
            $order->update_status('failed', $message);
        }

		if (empty($response['body'])) {
            $message =  __('Limelight\'s Response didn\'t not get any data.', 'wc-gateway-offline');
            $order->add_order_note($message);
            $order->update_status('failed', $message);
        }

        $response_body = wp_remote_retrieve_body($response);

        $order->add_order_note(((string) $response_body));

        foreach (preg_split("/\r?\n/", $response_body) as $line) {
			$_response = explode("&", $line);
		}

        $response_data = array();
        foreach ($_response as $data) {
            $temp = explode("=", $data);
            $response_data[$temp[0]] = $temp[1];
        }

        if ((int) $response_data['errorFound']) {
            $message = urldecode($response_data['errorMessage']);
            $order->add_order_note($message);
            $order->update_status('failed', $message);
        }

		if ((int) $response_data['responseCode'] == 100) {
            global $woocommerce;

            if (!$exists_gateway) {
                update_post_meta( $_parent->get_id(), 'limelight-gateway-id', $response_data['gatewayId'] );
                update_post_meta( $_parent->get_id(), 'limelight-gateway-descriptor', $response_data['gatewayDescriptor'] );
                update_post_meta( $_parent->get_id(), 'limelight-gateway-customer-service', $response_data['gatewayCustomerService'] );
            }
			// Payment successful
            $order->add_order_note(__( 'Limelight complete order processing.', 'cwoa-authorizenet-aim' ));
            update_post_meta( $order->get_id(), 'limelight-order-id', $response_data['orderId'] );

			// paid order marked
			$order->payment_complete();
		} else {
			// transaction fail
            $message = 'Error: '. $response_data['errorMessage'];
            $order->add_order_note($message);
            $order->update_status('failed', $message);
		}
    }

    public function process_refund( $order_id, $amount = null, $reason = '' ) {
        $ERROR_CODES = array(
            '200' => 'Invalid credentials',
            '350' => 'Invalid order Id supplied',
            '370' => 'Invalid amount supplied',
            '372' => 'Refund amount exceeds current order total',
            '701' => 'Action not permitted by gateway',
            '800' => 'Transaction was declined',
        );
        $url = str_replace('transact', 'membership', $this->url);

        $order = wc_get_order($order_id);
        $customer_id = $order->data['customer_id'];

        $limelight_order_id = get_post_meta($order_id, 'limelight-order-id', true);
        if (!$limelight_order_id) {
            if (!class_exists('Card_User_Data')) {
                include_once(ABSPATH . 'wp-content/plugins/tpc-user-profile/class-card-user-data.php');
            }
            $card_user_data = Card_User_Data::get_from_user_id($customer_id);
            $limelight_order_id = $card_user_data->order_limelight_id;
        }

        if ($limelight_order_id) {
            $payload = array(
                'username' => $this->username,
                'password' => $this->pass,
                'method' => 'order_refund',
                'order_id' => $limelight_order_id,
                'amount' => $amount,
                'keep_recurring' => 1,
            );
    
            $response = wp_remote_post($url, array(
                'method' => 'POST',
                'body' => http_build_query($payload),
                'timeout' => 90,
                'sslverify' => true,
            ));
    
            if (is_wp_error($response)) {
                $message = __('There is an issue connecting the payment gateway for refund. Sorry for the inconvenience.', 'wc-gateway-offline');
                $order->add_order_note($message);
            }
    
            if (empty($response['body'])) {
                $message =  __('Limelight\'s Response didn\'t not get any data for refund.', 'wc-gateway-offline');
                $order->add_order_note($message);
            }
    
            $response_body = wp_remote_retrieve_body($response);
    
            $order->add_order_note(((string) $response_body));
    
            foreach (preg_split("/\r?\n/", $response_body) as $line) {
                $_response = explode("&", $line);
            }
    
            $response_data = array();
            foreach ($_response as $data) {
                $temp = explode("=", $data);
                $response_data[$temp[0]] = $temp[1];
            }
    
            if ($response_data['response_code'] == 100) {
                $order->add_order_note(__('Order refunded: $' . (string) $amount, 'limelight'));
                return true;
            }
            return new WP_Error(
                'limelight-refund', $ERROR_CODES[(string) $response_data['response_code']]);
        }
        return false;
	}

    public function credit_card_form( $args = array(), $fields = array() ) {
        wc_deprecated_function('credit_card_form', '2.6', 'WC_Payment_Gateway_CC->form');
        include_once('limelight-payment-gateway-cc.php');
		$cc_form = new Limelight_Payment_CC;
		$cc_form->id = $this->id;
		$cc_form->supports = $this->supports;
		$cc_form->form();
    }

    public function add_error_order($order, $message, $error = true) {
        $order->add_order_note($message);
        $order->update_status($error == true ? 'failed': 'success', $message);
        wc_add_notice($message, $error == true ? 'error': 'success');
    }
}
?>
