<?php

include_once 'class-api.php';

/*
*
* Register the routes for the objects of the controller.
*
*/ 
class TPC_Gateway_Endpoints extends API_Custom_Woocommerce {

    static public function tpc_register_routes() {

        $instance = new TPC_Gateway_Endpoints();

        register_rest_route( self::$prefix, '/gateways', array(
            'methods' => 'GET',
            'callback' => array( $instance, 'get_gateways')
        ));
        register_rest_route( self::$prefix, '/gateways/(?P<id>\w+)', array(
            'methods' => 'GET',
            'callback' => array( $instance, 'get_gateway')
        ));

    }

    public function get_gateways( $request ) {
        $client = $this->get_client();
        $response = $client->get('payment_gateways', array('enabled' => true));

        if (isset($response[0])) {
            return new WP_REST_Response(array_map(
                function($gateway) {
                    return array(
                        'id' => $gateway->id,
                        'title' => $gateway->title,
                        'enabled' => $gateway->enabled
                    );
                }
            , $response), 200);
        }
        return new WP_REST_Response(array(), 200);
    }

    public function get_gateway( $request ) {
        $client = $this->get_client();
        $response = $client->get('payment_gateways/' . $request['id']);

        if ($response) {
            return new WP_REST_Response(array(
                'id' => $response->id,
                'title' => $response->title,
                'enabled' => $response->enabled
            ), 200);
        }
        return new WP_REST_Response(array(), 200);
    }

}

?>