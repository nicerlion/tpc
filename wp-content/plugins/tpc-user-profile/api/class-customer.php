<?php

/*
*
* Register the routes for the objects of the controller.
*
*/ 
class TPC_Customer_Endpoints extends APITPC {

    static $base = '/customer';

    static public function tpc_register_routes() {

        $Class = get_called_class();
        $instance = new $Class();

        register_rest_route( self::$prefix, self::$base, array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array( $instance, 'get_customer'),
                'permission_callback' => array( $instance, 'get_user_logged' )
            ),
            array(
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => array( $instance, 'customer_update'),
                'permission_callback' => array( $instance, 'get_user_logged' )
            )
        ));
        register_rest_route( self::$prefix, self::$base . '/change-purse/(?P<id>\d+)', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( $instance, 'change_purse' ),
            'permission_callback' => array( $instance, 'get_user_logged' )
        ));
        register_rest_route( self::$prefix, self::$base . '/login', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => array( $instance, 'customer_login' )
        ));

    }

    public function customer_update ( $request ) {

        $params = $request->get_params();

        if (isset($params['billing']) or isset($params['shipping'])) {

            function get_address_data($params) {

                $types = ['shipping', 'billing'];
                $_exclude = ['email', 'phone'];
                $data = array();

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
                        $data[$type . '_' . $key] = $value;

                    }

                }

                return $data;

            }

            $data = get_address_data( $params );
            $user = wp_get_current_user();

            foreach ($data as $meta_key => $meta_value ) {
                update_user_meta( $user->ID, $meta_key, $meta_value );
            }

            $customer = new WC_Customer($user->ID);

            return new WP_REST_Response( array(
                'id' => $user->ID,
                'billing' => $customer->get_billing(),
                'shipping' => $customer->get_shipping()
            ), 200);

        }

        return new WP_REST_Response( array('message' => 'error, there is no billing or shipping parameter', 'status' => 405 ), 405);

    }

    public function get_customer ( $request ) {
        $user = wp_get_current_user();
        $customer = new WC_Customer($user->ID);
        $date_created = new DateTime($user->user_registered);  // for count-down banner

        $orders = get_posts( array(
            'numberposts' => -1,
            'meta_key'    => '_customer_user',
            'meta_value'  => $user->ID,
            'post_type'   => wc_get_order_types( 'view-orders' ),
            'post_status' => array_keys( wc_get_order_statuses() ),
        ) );

        return new WP_REST_Response( array(
            'id' => $user->ID,
            'billing' => $customer->get_billing(),
            'shipping' => $customer->get_shipping(),
            'created' => $date_created->getTimeStamp(),
            'orders' => count($orders)
        ), 200);
    }

    /**
     * Take the purse selected by algorithm and change it from user choice
     * 
     * @param $request WP_REST_Request
     * @return WP_REST_Response
     */
    public function change_purse( $request ) {
        $params = $request->get_params();

        $customer_orders = get_posts( array(
            'numberposts' => 1,
            'meta_key'    => '_customer_user',
            'meta_value'  => get_current_user_id(),
            'post_type'   => wc_get_order_types(),
            'post_status' => 'wc-processing',
            'order' => 'DESC'
        ) );

        if (!isset($customer_orders[0])) {
            return new WP_REST_Response([
                'message' => 'No order with "processing" status found',
                'status' => '400'
            ], 400);
        }

        $post_order = $customer_orders[0];
        $order = new WC_Order($post_order->ID);
        $items = $order->get_items();
        $product = null;

        foreach ($items as $item) {
            $data = $item->get_data();
            $product = wc_get_product($data['product_id']);
            $product_type = $product->get_type();

            if ($product_type == 'variable') {
                $variation = wc_get_product($data['variation_id']);
                $order->remove_item($item->get_id());
                $order->save();  // reduce_order_stock reduce stock from order saved in memory
                $new_product = wc_get_product($params['id']);
                $order->add_product($new_product);
                $order->reduce_order_stock();
                $order->save();

                wc_update_product_stock($variation->get_id(), $variation->get_stock_quantity() + 1);
                $variation->save();
                break;
            }
            $product = null;
        }

        if (!$product) {
            $new_product = wc_get_product($params['id']);
            $order->add_product($new_product);
            $order->reduce_order_stock();
            $order->save();
        }

        $product_data = $new_product->get_data();
        $product_attributes = $new_product->get_variation_attributes();

        return new WP_REST_Response([
            'id' => $new_product->get_id(),
            'price' => $product_data['price'],
            'name' => $product_data['name'],
            'short_description' => $product_data['short_description'],
            'sku' => $product_data['sku'],
            'images' =>  $this->get_images($new_product),
            'colors' => isset($product_attributes['pa_colors']) ? $product_attributes['pa_colors'] : false,
            'sizes' => isset($product_attributes['pa_sizes']) ? $product_attributes['pa_sizes'] : false,
        ], 200);

    }
    
    public function customer_login( $request ) {
        
        $params = $request->get_params();

        if (isset($params['user']) and isset($params['password'])) {
            $creds = array(
                'user_login'    => $params['user'],
                'user_password' => $params['password'],
                'remember'      => true
            );
            $user = wp_signon( $creds, false );
            if ( is_wp_error($user) ){
                return new WP_REST_Response( array('message' => 'error, the user could not log in', 'status' => 405 ), 405);
            }
            return new WP_REST_Response( array('id' => $user->ID), 200);
        }
        return new WP_REST_Response( array('message' => 'error, there is no user parameter or password', 'status' => 405 ), 405);
    }

}

?>
