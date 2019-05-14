<?php

include_once 'class-api.php';
include_once 'utils/class-pagination.php';

/*
*
* @class TPC_Products_Endpoints
*
*/ 
class TPC_Products_Endpoints extends API_Custom_Woocommerce {

    static $base = '/products';

    static public function tpc_register_routes() {

        $Class = get_called_class();
        $instance = new $Class();

        register_rest_route( self::$prefix, self::$base, array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( $instance, 'get_products')
        ));
        register_rest_route( self::$prefix, self::$base . '/memberships', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( $instance, 'get_products_with_membership' )
        ));
        register_rest_route( self::$prefix, self::$base. '/user/memberships', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( $instance, 'get_products_by_user_membership'),
            'permission_callback' =>  array( $instance, 'get_user_logged')
        ));
        register_rest_route( self::$prefix, self::$base . '/user/purse', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( $instance, 'get_customer_purse_for_next_billing'),
            'permission_callback' =>  array( $instance, 'get_user_logged')
        ));
        register_rest_route( self::$prefix, self::$base. '/category', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( $instance, 'products_by_category')
        ));
        register_rest_route( self::$prefix, self::$base. '/subscriptions/purse', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( $instance, 'get_subscription_product_by_purse')
        ));
    }

    /**
     * Returns available memberships like products of Month to Month
     * 
     * @param $request WP_REST_Request
     * @return WP_REST_Response
     */
    public function get_products_with_membership( $request ) {

        $memberships = ['gold', 'platinum'];
        $response = array();

        foreach ($memberships as $key => $membership) {
            $index = (string) ($key + 1);

            try {
                $page = get_pages(array(
                    'meta_key' => '_wp_page_template',
                    'meta_value' => 'page-membership.php',
                    'posts_per_page' => 1,
                    'order' => 'ASC'
                ))[0];

                $page_fields = get_fields($page->ID);
                $membership_carousel_category = $page_fields['membership_carousel_category_s' . $index];
                $term = $page_fields[$membership == 'gold' ? 'membership_product_category_s1': 'product_category_s2'];
                $thumbnails = array();

                $carousels = get_posts(array(
                    'post_type' => 'membership_carousel',
                    'category_name' => $membership_carousel_category->slug,
                    'posts_per_page' => -1,
                    'order' => 'DESC'
                ));

                foreach ($carousels as $key => $carousel) {
                    $image = get_field('image', $carousel->ID);
                    if( !empty($image) ) {
                        $thumbnails[] = array(
                            'url' => $image['url'],
                            'alt' => $image['alt']
                        );
                    }
                }

                if ($term) {
                    try {
                        global $product;
                        $post_product = get_posts(array(
                            'post_type' => 'product',
                            'product_cat' => $term->slug,
                            'posts_per_page' => 1,
                            'order' => 'ASC'
                        ))[0];

                        $_product = wc_get_product($post_product->ID);
                    } catch (Exception $exception) {
                        continue;
                    }
                }

                $response['memberships'][$membership] = array(
                    'title' => $page_fields['title_s' . $index],
                    'subtitle' => $page_fields['subtitle_s' . $index],
                    'description' => $page_fields['detail_of_the_value_s' . $index],
                    'message' => $page_fields['content_text_s' . $index],
                    'see_details' => $page_fields['see_details_s' . $index],
                    'popup_detail' => $page_fields['popup_detail_s' . $index],
                    'button_text' => $page_fields['button_text_s' . $index],
                    'thumbnails' => $thumbnails,
                    'product' => array(
                        'id' => $post_product->ID,
                        'price' => $_product->get_price()
                    )
                );

                if (!isset($response['header'])) {
                    $response['header'] = array(
                        'title' => $page_fields['title_ph'],
                        'image' => $page_fields['background_image_ph'],
                        'repeat' => $page_fields['background_repeat_ph'],
                        'attachment' => $page_fields['background_attachment_ph'],
                        'position' => $page_fields['background_position_ph'],
                        'size' => $page_fields['background_size_ph'],
                        'color' => $page_fields['background_color_ph']
                    );
                }

            } catch (Exception $exception) {
                break;
            }
        }

        return new WP_REST_Response( $response, 200 );
    }

    /**
     * Returns all available purses for user active membership
     * 
     * @param $request WP_REST_Request
     * @return WP_REST_Response
     */
    public function get_products_by_user_membership( $request ) {

        $params = $request->get_params();
        $id = get_current_user_id();
        $products_ids = $objects_ids = array();
        $user_is_member = wc_memberships_is_user_member($id);

        if ($user_is_member) {
            $memberships = wc_memberships_get_user_active_memberships($id);

            if (sizeof($memberships) > 0) {

                $rules = get_option('wc_memberships_rules');
                $plan = $memberships[0]->plan_id;

                foreach ($rules as $_rule) {
                    if ($_rule['membership_plan_id'] === $plan) {
                        $objects_ids = $_rule['object_ids'];
                        break;
                    }
                }

                foreach ($objects_ids as $objects_id) {
                    $object_id = wp_get_post_parent_id($object_id) || $object_id;
                    if ($objects_id != 0 and !in_array($objects_id, $products_ids)) {
                        $products_ids[] = $objects_id;
                    }
                }

                $args = array(
                    'include' => $products_ids,
                    'type' => 'variable',
                );
                $products = wc_get_products($args);

                $parameters = array(
                    'url' => '/products/user/memberships',
                    'limit' => isset($params['limit']) ? $params['limit']: 10,
                    'page' => isset($params['page']) ? $params['page']: 1,
                );

                $paginator = new TPC_Pagination($products, $parameters);

                $paginated_response = $paginator->get_paginated_response(function ($product_post, $key, $params) {

                    $childrens = $product_post->get_children();
                    $product_attributes = $product_post->get_variation_attributes();
                    $product_data = $product_post->get_data();
                    $product_category = get_the_terms( $product_post->get_id(), 'product_cat' );

                    $attributes = array(
                        'colors' => isset($product_attributes['pa_colors']) ? $product_attributes['pa_colors'] : array(),
                        'sizes' => isset($product_attributes['pa_sizes']) ? $product_attributes['pa_sizes'] : array()
                    );
                    
                    return array(
                        'id' => $product_post->get_id(),
                        'price' => $product_data['price'],
                        'name' => $product_data['name'],
                        'sku' => $product_data['sku'],
                        'short_description' => $product_data['short_description'],
                        'images' =>  $this->get_images($product_post),
                        'attributes' => $attributes,
                        'category' => isset($product_category[0]) ? $product_category[0]->name : false,
                        'variations' => isset($childrens[0]) ? $this->_get_variations($childrens) : array()
                    );

                });

                return new WP_REST_Response(array(
                    'products' => $paginated_response['data'],
                    'pagination' => $paginated_response['pagination']
                ), 200);

            }

            return new WP_REST_Response( array('message' => 'error, the user has no active membership', 'status' => 403 ), 403);

        }

        return new WP_REST_Response( array('message' => 'error, the user is not a member', 'status' => 403 ), 403);

    }

    /**
     * Returns all products given by query `include`
     * 
     * @param $request WP_REST_Request
     * @return WP_REST_Response
     */
    public function get_products ( $request ) {
        $params = $request->get_params();

        $products_to_include = isset($params['include']) ? explode(',', $params['include']): array();
        if (count($products_to_include)) {
            foreach ($products_to_include as $product_id) {
                $products[] = wc_get_product($product_id);
            }
            $self = $this;
            $_products_subscriptions = array();

            return new WP_REST_Response(
                array_map(function ($product) use ($self, $_products_subscriptions) {
                    $product_type = $product->get_type();
                    $childrens = array();
                    $attributes = array();

                    $product_response = array(
                        'id' => $product->get_id(),
                        'price' => $product->get_price(),
                        'name' => $product->get_name(),
                        'sku' => $product->get_sku(),
                        'short_description' => $product->get_short_description(),
                        'images' => $this->get_images($product),
                        'variations' => &$childrens,
                        'attributes' => &$attributes
                    );

                    $product_subscription = get_product_membership($product, $_products_subscriptions);
                    if ($product_subscription) {
                        $product_response['price_subscription'] = $product_subscription->get_price();
                    } else {
                        $product_response['price_subscription'] = 0.0;
                    }

                    if ($product_type == 'variable') {
                        $childrens = $self->_get_variations($product->get_children());
                        $product_attributes = $product->get_variation_attributes();
                        $attributes = array(
                            'colors' => isset($product_attributes['pa_colors']) ? $product_attributes['pa_colors'] : array(),
                            'sizes' => isset($product_attributes['pa_sizes']) ? $product_attributes['pa_sizes'] : array(),
                        );
                    } else if ($product_type === 'variation') {
                        $product_data = $product->get_data();
                        $product_attributes = $product->get_attributes();
                        $attributes = array(
                            'color' => isset($product_attributes['pa_colors']) ? ($product_attributes['pa_colors']): '',
                            'sizes' => isset($product_attributes['pa_sizes']) ? ($product_attributes['pa_sizes']): '',
                        );

                        $product_response['stock_quantity'] = $product_data['stock_quantity'];
                        $product_response['stock_status'] = $product_data['stock_status'];
                        $product_response['weight'] = $product_data['weight'];
                        $product_response['length'] = $product_data['length'];
                        $product_response['width'] = $product_data['width'];
                        $product_response['height'] = $product_data['height'];
                    }

                    return $product_response;
                }, $products)
            , 200);
        }
        return new WP_REST_Response(array(), 200);
    }
    
    /**
     * Returns the actual purse selected by algorithm in current billing date
     * 
     * @param $request WP_REST_Request
     * @return WP_REST_Response
     */
    public function get_customer_purse_for_next_billing( $request ) {

        $user = wp_get_current_user();

        $user_is_member = wc_memberships_is_user_member($user->ID);

        if ($user_is_member) {

            $customer_order = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
                'numberposts' => 1,
                'meta_key'    => '_customer_user',
                'meta_value'  => $user->ID,
                'post_type'   => wc_get_order_types( 'view-orders' ),
                'post_status' => 'wc-processing',
                'order' => 'DESC'
            ) ) );

            if  (isset($customer_order[0])){

                $order = wc_get_order( $customer_order[0]->ID );
                $order_items = $order->get_items();
                
                foreach ($order_items as $key => $order_item) {

                    $order_data = $order_item->get_data();

                    if (isset($order_data['variation_id']) and $order_data['variation_id'] > 0) {

                        $product = wc_get_product($order_data['variation_id']);
                        $product_data = $product->get_data();

                        $product_category = get_the_terms( $order_data['product_id'], 'product_cat' );

                        return new WP_REST_Response( array(
                            'id' => $order_data['variation_id'],
                            'price' => $product_data['price'],
                            'name' => $product_data['name'],
                            'sku' => $product_data['sku'],
                            'short_description' => $product_data['description'],
                            'stock_quantity' => $product_data['stock_quantity'],
                            'stock_status' => $product_data['stock_status'],
                            'weight' => $product_data['weight'],
                            'length' => $product_data['length'],
                            'width' => $product_data['width'],
                            'height' => $product_data['height'],
                            'category' => isset($product_category[0]) ? $product_category[0]->name : false ,
                            'images' => $this->get_images($product)
                        ), 200 );

                    }

                }

                return new WP_REST_Response( array('message' => 'error, no product was found', 'status' => 400 ), 400);

            }

            return new WP_REST_Response( array('message' => 'error, no order was found in processing', 'status' => 400 ), 400);

        }

        return new WP_REST_Response( array('message' => 'error, the user is not a member', 'status' => 405 ), 405);
        
    }

    private function _get_variations ( $products_ids ) {
        foreach ($products_ids as $product_id) {
            $product = wc_get_product($product_id);
            $product_data = $product->get_data();
            $_product_attributes = $product->get_attributes();
            $attributes = array(
                'color' => isset($_product_attributes['pa_colors']) ? $_product_attributes['pa_colors']: '',
                'sizes' => isset($_product_attributes['pa_sizes']) ? $_product_attributes['pa_sizes']: ''
            );

            $products_variations[] = array(
                'id' => $product_id,
                'price' => $product_data['price'],
                'name' => $product_data['name'],
                'short_description' => $product_data['description'],
                'stock_quantity' => $product_data['stock_quantity'],
                'stock_status' => $product_data['stock_status'],
                'weight' => $product_data['weight'],
                'length' => $product_data['length'],
                'width' => $product_data['width'],
                'height' => $product_data['height'],
                'attributes' => $attributes,
                'images' => $this->get_images($product)
            );
        }
        return $products_variations;
    }

    /**
     * Returns all products related to the category
     * 
     * @param $request WP_REST_Request
     * @return WP_REST_Response
     */
    public function products_by_category( $request ) {

        $params = $request->get_params();

        if (isset($params['category'])) {

            $parameters = array(
                'url' => '/products/category',
                'limit' => isset($params['limit']) ? $params['limit']: 10,
                'page' => isset($params['page']) ? $params['page']: 1,
            );

            $banner = null;

            if (isset($params['banner'])) {
                $banner = array(
                    'desktop' => array(
                        'src' => get_option('TpcShop' . $params['category'] . 'DesktopUrl'),
                        'alt' => get_option('TpcShop' . $params['category'] . 'DesktopAlt'),
                    ),
                    'mobile' => array(
                        'src' => get_option('TpcShop' . $params['category'] . 'MobileUrl'),
                        'alt' => get_option('TpcShop' . $params['category'] . 'MobileAlt'),
                    )
                );
            }

            $products = get_posts(array(
                'post_type' => 'product',
                'product_cat' => $params['category'],
                'posts_per_page' => -1,
                'meta_query' => array(array('key' => '_subscription_price', 'compare' => 'NOT EXISTS')),
                'order' => 'DESC'
            ));

            $paginator = new TPC_Pagination($products, $parameters);

            $paginated_response = $paginator->get_paginated_response(function ($product_post, $key, $params) {

                $product = wc_get_product( $product_post->ID );
                $product_data = $product->get_data();
                $product_categories = get_the_terms( $product_post->ID, 'product_cat' );
                $category = false;
                $product_type = $product->get_type();
                $childrens = array();
                $attributes = array();

                if ($product_type == 'variable') {
                    $childrens = $product->get_children();
                    $product_attributes = $product->get_variation_attributes();
                    $attributes = array(
                        'colors' => isset($product_attributes['pa_colors']) ? $product_attributes['pa_colors'] : array(),
                        'sizes' => isset($product_attributes['pa_sizes']) ? $product_attributes['pa_sizes'] : array()
                    );
                }

                foreach ($product_categories as $product_category) {
                    if ($product_category->parent > 0) {
                        $category = $product_category->name;
                        break;
                    }
                }

                return array(
                    'id' => $product_post->ID,
                    'price' => $product->get_price(),
                    'name' => $product_data['name'],
                    'sku' => $product_data['sku'],
                    'short_description' => $product_data['short_description'],
                    'images' => $this->get_images($product),
                    'attributes' => $attributes,
                    'category' => $category,
                    'variations' => isset($childrens[0]) ? $this->_get_variations($childrens) : array()
                );

            });

            if (!isset($paginated_response['data'][0])) {
                return new WP_REST_Response(array(
                    'code' => 'category_not_exist',
                    'message' => 'Category does not exists',
                    'data' => array('status' => 404)
                ), 404);
            }

            return new WP_REST_Response(array(
                'products' => $paginated_response['data'],
                'banner' => $banner,
                'pagination' => $paginated_response['pagination']
            ), 200);

        }

        return new WP_REST_Response(array(
            'code' => 'missing_category_parameter',
            'message' => 'error, there is no category parameter',
            'data' => array('status' => 400))
        , 400);
    }

    function get_subscription_product_by_purse($request) {
        $params = $request->get_params();
        $product = isset($params['product']) ? wc_get_product($params['product']) : false;

        if ($product) {
            $terms = get_the_terms(
                $product->get_type() === 'variation' ? $product->get_parent_id(): $product->get_id(),
                'product_cat'
            );
            foreach ($terms as $term) {
                if ($term->parent > 0) {
                    continue;
                }
                $category = $term->slug;

                $products = get_posts(array(
                    'post_type' => 'product',
                    'product_cat' => $category,
                    'posts_per_page' => 1,
                    'meta_query' => array(array('key' => '_subscription_price', 'compare' => 'EXISTS')),
                    'order' => 'DESC'
                ));
                $subscription = (bool) count($products) ? wc_get_product($products[0]->ID): false;
    
                if ($subscription) {
                    $subscription_data = $subscription->get_data();
                    return new WP_REST_Response(array(
                        'id' => $subscription->get_id(),
                        'price' => $subscription->get_price(),
                        'name' => $subscription_data['name'],
                        'sku' => $subscription_data['sku'],
                        'short_description' => $subscription_data['short_description']
                    ), 200);
                }
            }
        }
        return new WP_REST_Response(array(
            'code' => 'subscription_not_found',
            'message' => 'Subscription not found for this product',
            'data' => array(
                'status' => 404
            )
        ), 404);
    }

}

?>