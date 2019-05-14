<?php
include_once 'utils/class-pagination.php';
include_once 'utils/functions.php';

/*
*
* Register the routes for the objects of the controller.
*
*/ 
class TPC_Order_Endpoints extends API_Custom_Woocommerce {

    static public function tpc_register_routes() {

        $Class = get_called_class();
        $instance = new $Class();

        register_rest_route( self::$prefix, '/orders', array(
            'methods' => 'POST',
            'callback' => array( $instance, 'create_order')
        ));
        register_rest_route( self::$prefix, '/orders/customer', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( $instance, 'get_orders_by_customer' ),
            'permission_callback' => array( $instance, 'get_user_logged' )
        ));

    }

    public function create_order( WP_REST_Request $request ) {
        $data = $request->get_params();
        $client = $this->get_client();

        $current_user = wp_get_current_user();
        $customer = new WC_Customer($current_user->ID);

        if (!isset($data['shipping']['first_name']) || !$data['shipping']['first_name']) {
            $data['shipping'] = $data['billing'];
        }

        if ($current_user->ID) {
            if (!((bool) $customer->get_id())) {
                $data['billing']['email'] = $current_user->user_email;

                if (isset($data['billing']['password'])) {
                    $client_data = array(
                        'email' => $data['billing']['email'],
                        'first_name' => $data['billing']['first_name'],
                        'last_name' => $data['billing']['last_name'],
                        'username' => $data['billing']['email'],
                        'password' => $data['billing']['password'],
                        'billing' => $data['billing'],
                        'shipping' => isset($data['shipping']) ? $data['shipping']: $data['billing']
                    );

                    $customer = new WC_Customer($client->post('customers', $client_data)->id);
                } else {
                    return new WP_REST_Response(array(
                        'code' => 'error_form',
                        'message' => 'Form has errors',
                        'data' => array(
                            'status' => 400,
                            'fields' => array(
                                'billing' => array(
                                    'password' => 'This field is required'
                                )
                            )
                        )
                    ), 400);
                }
            } else {
                $data['customer_id'] = $current_user->ID;
                if (!$customer->get_billing()['first_name']) {
                    function get_address_data($params) {
                        $types = ['shipping', 'billing'];
                        $_exclude = ['email', 'phone'];
                        $_data = array();

                        foreach ($types as $type) {
                            $consult = $type;
                            if (!isset($params[$type])) {
                                $consult = 'billing';
                            }
                            foreach ($params[$consult] as $key => $value) {
                                $key_eclude = array_search($key, $_exclude);
                                $in_array = $key_eclude == false ? false: (bool) ($key_eclude + 1);
                                if ($type == 'shipping' and $in_array) {
                                    continue;
                                }
                                $_data[$type . '_' . $key] = $value;
                            }
                        }
                        return $_data;
                    }

                    $customer_data = get_address_data( $data );
                    foreach ($customer_data as $meta_key => $meta_value ) {
                        update_user_meta( $current_user->ID, $meta_key, $meta_value );
                    }
                }
            }
        } else {
            return new WP_REST_Response(
                array(
                    'code' => 'not_user_logged_in',
                    'status' => 403,
                    'message' => 'Not user credentials'
                ), 403);
        }

        $is_past_member = wc_memberships_is_user_member($customer->get_id());

        if (isset($data['id'])) {
            $order = wc_get_order($data['id']);
            if (isset($data['id'])) unset($data['line_items']);
            $response_order = $client->put('orders/' . (string) $order->get_id(), $data);
        } else {
            $response_order = $client->post('orders/', $data);
            if (isset($response_order->id)) {
                $order = wc_get_order($response_order->id);
            } else {
                return new WP_REST_Response(array(
                    'status' => 400,
                    'message' => 'Order cannot been created'
                ), 400);
            }
        }

        $products = $order->get_items();
        $subscription_product = null;

        function is_upsell ($array) {
            $upsell_category = get_term_by('slug', 'upsell', 'product_cat');

            foreach ($array as $term) {
                if (!is_integer($term)) {
                    if ($term && isset($term->term_id)) {
                        $term = $term->term_id;
                    } else {
                        $term = 0;
                    }
                }
                if ($term == $upsell_category->term_id) {
                    return true;
                }
            }
            return false;
        }

        foreach ($products as $key => $product_item) {
            $product = $product_item->get_product();
            if (!$subscription_product && WC_Subscriptions_Product::is_subscription($product->get_id())) {
                $subscription_product = $product;
            }
        }

        $order_id = $order->get_id();

        if (isset($data['coupons']) && is_array($data['coupons'])) {
            foreach ($data['coupons'] as $coupon) {
                $order->apply_coupon($coupon['code']);
            }
        }

        if ($subscription_product) {
            WC_Subscriptions_Manager::create_pending_subscription_for_order($order, $subscription_product->get_id());

            $order->set_total(0.0);
            $free_product = false;
            $_memberships = array();
            foreach ($products as $key => $product_item) {
                $product = $product_item->get_product();
                $terms = get_the_terms($product->get_id(), 'product_cat');
                $membership_subscription_product = get_product_membership($product, $_memberships);
                if (is_array($terms) && call_user_func_array('is_upsell', $terms)) continue;

                if ($product->get_id() == $subscription_product->get_id()) {
                    continue;
                } elseif (!$free_product && $membership_subscription_product->get_id() == $subscription_product->get_id()) {
                    $product_item->set_subtotal(0);
                    $product_item->set_total(0);
                    $free_product = true;
                    continue;
                }

                if ($membership_subscription_product) {
                    $product_item->set_subtotal($membership_subscription_product->get_price());
                    $product_item->set_total($membership_subscription_product->get_price());
                }
            }
            $order->calculate_totals();

            if (!$is_past_member) {
                $order->apply_coupon('__signUpWithMembershipCouponCode**__');
            }

            $result_payment = $this->process_order_payment($order_id, $data['payment_method'], $data);
            if (isset($result_payment['result']) and $result_payment['result'] == 'fail') {
                return new WP_REST_Response(
                    array_merge($result_payment, ['id' => $order_id])
                    , 200);
            }
            WC_Subscriptions_Manager::activate_subscriptions_for_order($order);

            $subscriptions = wcs_get_subscriptions_for_order($order);
            $available_gateways = WC()->payment_gateways->get_available_payment_gateways();

            foreach ($subscriptions as $subscription) {
                update_post_meta( $subscription->get_id(), 'card-number', $data['limelight-card-number'] );
                update_post_meta( $subscription->get_id(), 'card-expiry', $data['limelight-card-expiry'] );
                update_post_meta( $subscription->get_id(), 'card-type', $data['limelight-card-type'] );
                update_post_meta( $subscription->get_id(), 'card-cvc', $data['limelight-card-cvc'] );
                update_post_meta( $subscription->get_id(), 'shipping-cost', $order->get_shipping_total());

                $subscription->set_address($order->get_address('billing'), 'billing');
                $subscription->set_address($order->get_address('shipping'), 'shipping');
                // wcs_get_subscription
                if (isset($available_gateways[$data['payment_method']])) {
                    $subscription->set_payment_method( $available_gateways[ $data['payment_method'] ] );
                    $subscription->save(); 
                }
            }
        } else {
            $is_member = wc_memberships_is_user_member($customer->get_id());
            $active_memberships = wc_memberships_get_user_active_memberships($customer->get_id());

            if ($is_member && $active_memberships) {
                // wc_memberships_get_membership_plan, also can search by slug
                $_subscriptions = array();

                $order->set_total(0.0);
                foreach ($products as $key => $product_item) {
                    $product = $product_item->get_product();
                    $subscription_product = get_product_membership($product, $_subscriptions);
                    if ($subscription_product && $product->get_id() == $subscription_product->get_id()) continue;

                    $terms = get_the_terms($product->get_id(), 'product_cat');
                    if (is_array($terms) && call_user_func_array('is_upsell', $terms)) continue;

                    if ($subscription_product) {
                        $product_item->set_subtotal($subscription_product->get_price());
                        $product_item->set_total($subscription_product->get_price());
                    }
                }
                $order->calculate_totals(); 
            }

            $result_payment = $this->process_order_payment($order_id, $data['payment_method'], $data);
            if (isset($result_payment['result']) and $result_payment['result'] == 'fail') {
                return new WP_REST_Response(
                    array_merge($result_payment, ['id' => $order_id])
                    , 200);
            }
        }

        foreach ($products as $product_item) {
            $product = $product_item->get_product();
            $products_response[] = array(
                'id' => $product_item->get_id(),
                'product_id' => $product->get_id(),
                'name' => $product->get_name(),
                'sku' => $product->get_sku(),
                'total' => $product_item->get_total(),
                'subtotal' => $product_item->get_subtotal()
            );;
        }

        return new WP_REST_Response(
            array_merge(
                (array) $response_order,
                array('total' => $order->get_total(), 'products' => $products_response)
            )
        , 200);
    }

    protected function process_order_payment( $order_id, $payment_method, $data ) {
        $available_gateways = WC()->payment_gateways->get_available_payment_gateways();

        if ( ! isset( $available_gateways[ $payment_method ] ) ) {
            return;
        }

        // Store Order ID in session so it can be re-used after payment failure
        WC()->session->set( 'order_awaiting_payment', $order_id );

        // Process Payment
        $order = wc_get_order($order_id);
        $order->set_payment_method( $available_gateways[ $payment_method ] );
        $order->save();
        $result = $available_gateways[ $payment_method ]->process_payment( $order_id, $data );

        // Redirect to success/confirmation/payment page
        if ( isset( $result['result'] ) && 'success' === $result['result'] ) {
            $result = apply_filters( 'woocommerce_payment_successful_result', $result, $order_id );
        }
        return $result;
    }

    public function get_orders_by_customer( $request ) {
        $id = get_current_user_id();
        $params = $request->get_params();
        $status = isset($params['status']) ? $params['status'] : null;
        $ignore = isset($params['ignore']) ? $params['ignore'] : null;

        $parameters = array(
            'url' => '/orders/customer',
            'limit' => isset($params['limit']) ? $params['limit']: 10,
            'page' => isset($params['page']) ? $params['page']: 1,
            'status' => $status,
            'ignore' => $ignore,
        );

        if (!$status) {
            $status = array_keys( wc_get_order_statuses() );
            $status = $ignore != null ? array_diff($status, array($ignore)) : $status;
        }

        $orders = get_posts( array(
            'numberposts' => -1,
            'meta_key'    => '_customer_user',
            'meta_value'  => $id,
            'post_type'   => wc_get_order_types( 'view-orders' ),
            'post_status' => $status,
            'order' => 'DESC'
        ) );

        $paginator = new TPC_Pagination($orders, $parameters);

        $paginated_response = $paginator->get_paginated_response(function ($order_post, $key, $params) {
            $order = wc_get_order($order_post->ID);
            $order_data = $order->get_data();

            return array(
                'id' => $order->get_id(),
                'date' => date( "F j, Y", strtotime($order_post->post_date) ),
                'status' => $order_data['status'],
                'total' => $order_data['total']
            );
        });

        return new WP_REST_Response(array(
            'orders' => $paginated_response['data'],
            'pagination' => $paginated_response['pagination']
        ), 200);
    }

}
?>
