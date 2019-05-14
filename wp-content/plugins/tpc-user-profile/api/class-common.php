<?php

/*
*
* Register the routes for the objects of the controller.
*
*/ 
class TPC_Common_Endpoints extends API_Custom_Woocommerce {

    static public function tpc_register_routes() {

        $Class = get_called_class();
        $self = new $Class();

        register_rest_route( self::$prefix, '/countries', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array( $self, 'get_countries' )
            ),
        ));
        register_rest_route( self::$prefix, '/states/(?P<country>\w{2})', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array( $self, 'get_states_by_country' )
            ),
        ));
        register_rest_route( self::$prefix, '/users/email-registered', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array( $self, 'email_registered' )
            ),
        ));
        register_rest_route( self::$prefix, '/coupons', array(
            'methods' => 'GET',
            'callback' => array( $self, 'get_coupons' )
        ));
        register_rest_route( self::$prefix, '/users/register', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => array( $self, 'user_register' )
        ));

    }

    public function get_countries( $request ) {
        $instance = new WC_Countries();
        $countries = $instance->get_countries();
        return new WP_REST_Response( $countries, 200 );
    }

    public function get_states_by_country( $request ) {
        try {
            $country = (string) $request['country'];
            $instance = new WC_Countries();
            $states = $instance->get_states($country);
            return new WP_REST_Response( array(
                'states' => $states
            ), 200 );
        } catch (Exception $exception) {
            return new WP_REST_Response( array(
                'states' => array()
            ), 400 );
        }
    }

    public function email_registered( $request ) {
        $params = $request->get_params();
        $current_user = wp_get_current_user();

        try {
            if ($current_user->user_email == $params['email']) {
                $user = false;
            } else {
                $user = get_user_by('email', $params['email']);
            }
        } catch (Exception $exception) {
            $user = false;
        }

        return new WP_REST_Response(array(
            "exists" => (bool) $user ? true: false
        ), 200);
    }

    public function get_coupons( $request ) {
        $params = $request->get_params();
        $client = $this->get_client();

        if (isset($params['code']) and $params['code'] !== '') {
            $response = $client->get('coupons', ["code" => $params['code']]);

            if (!isset($response[0])) {
                $response = $client->get('coupons', ["id" => $params['code']]);
            }

            if (isset($response[0])) {
                $coupon = $response[0];
    
                if ($coupon->date_expires) {
                    $date_expires = new DateTime($coupon->date_expires);
                    $today_date = new DateTime(date('Y-m-d') . 'T00:00:00');
                    if ($today_date > $date_expires) {
                        return new WP_REST_Response(array(), 200);
                    }
                }

                if ($coupon->usage_limit and $coupon->usage_count >= $coupon->usage_limit) {
                    return new WP_REST_Response(array(), 200);
                }

                return new WP_REST_Response(array(
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'amount' => $coupon->amount,
                    'discount_type' => $coupon->discount_type,
                    'description' => $coupon->description,
                    'product_ids' => $coupon->product_ids), 200);
            }
        }
        return new WP_REST_Response(array(), 200);
    }

    /**
     * Function API to register users. Users are customers by default
     * and will asign username equals to email
     */
    public function user_register( $request ) {
        
        $params = $request->get_params();

        $email = isset($params['email']) ? wp_slash($params['email']): '';
        $password = isset($params['password']) ? $params['password']: '';
        $name = isset($params['name']) ? wp_slash($params['name']): '';
        $size = isset($params['size']) ? $params['size']: '';
        $type = isset($params['type']) ? $params['type']: '';
        $color = isset($params['color']) ? $params['color']: '';

        if ($email && $password && $name && $size && $type && $color) {
            if (!username_exists($email) and !email_exists($email)) {
                $user = wp_insert_user(array(
                    'user_login' => $email,
                    'user_email' => $email,
                    'first_name' => $name,
                    'user_pass' => $password
                ));

                if (is_wp_error($user)) {
                    return new WP_REST_Response(array(
                        'code' => 'user_creation_error',
                        'message' => $user->get_error_message(),
                        'data' => array(
                            'status' => 400
                        )
                    ), 400);
                }

                $credentials = array(
                    'user_login' => $email,
                    'user_password' => $password,
                    'remember' => true
                );
                $user = wp_signon( $credentials, false );
                $date_created = new DateTime($user->user_registered);

                $quiz = new Quiz(array(
                    "size" => $size,
                    "type" => $type,
                    "color" => $color,
                    "member_id" => $user->ID,
                    "membership_id" => 99,
                ));
                $quiz->save();

                return new WP_REST_Response(array(
                    'id' => $user->ID,
                    'email' => $user->user_email,
                    'created' => $date_created->getTimeStamp()
                ), 200);
            }

            return new WP_REST_Response(array(
                'code' => 'user_already_exists',
                'message' => 'User already exists',
                'data' => array(
                    'status' => 400
                )
            ), 400);
        }

        return new WP_REST_Response(array(
            'code' => 'ivalid_request',
            'message' => 'Invalid request',
            'data' => array(
                'status' => 400
            )
        ), 400);
    }

}
?>
