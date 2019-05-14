<?php

/*
*
* Register the routes for the objects of the controller.
*
*/ 
class TPC_Upsell_Endpoints extends APITPC {

    static $base = '/upsells';

    static public function tpc_register_routes() {

        $instance = new TPC_Upsell_Endpoints();

        register_rest_route( self::$prefix, self::$base . '/select-your-plan', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array( $instance, 'get_select_your_plan' )
            ),
        ));
        register_rest_route( self::$prefix, self::$base . '/upsell-v2', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array( $instance, 'get_upsell_v2' )
            ),
        ));
        register_rest_route( self::$prefix, self::$base . '/upsell-v1', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array( $instance, 'get_upsell_v1' )
            ),
        ));

    }

    public function get_select_your_plan( $request ) {

        $params = $request->get_params();

        function organize($plan_1, $plan_2) {

            $plan_date_1 = get_the_date('YmdHis', $plan_1['id']);
            $plan_date_2 = get_the_date('YmdHis', $plan_2['id']);

            if ($plan_date_1 == $plan_date_2) {
                return 0;
            }

            return ($plan_date_1 > $plan_date_2) ? -1 : 1;

        }

        if (isset($params['product_id']) and $params['product_id'] !== '') {

            $membership_plans = array();

            $posts = get_posts(array(
                'post_type' => 'wc_membership_plan',
                'posts_per_page' => -1,
                'order' => 'DESC'
            ));

            foreach ($posts as $key => $value) {

                $plan = wc_memberships_get_membership_plan($value);
                $products = $plan->get_products();

                foreach ($products as $product_id => $product_value) {
                    if ($product_id == $params['product_id']) {
                        unset($products[$product_id]);
                        $membership_plans = $products;
                        break;
                    } 
                }
                if (count($membership_plans) > 0) break;
            }

            if (!(count($membership_plans) > 0)) {
                return new WP_REST_Response( array(), 200 );
            }

            $page = get_pages(array(
                'meta_key' => '_wp_page_template',
                'meta_value' => 'page-billing-information.php',
                'posts_per_page' => 1,
                'order' => 'ASC'
            ))[0];

            $page_fields = get_fields($page->ID);

            $response = array(
                'header' => array(
                    'title' => isset($page_fields['title_select_ph']) ? $page_fields['title_select_ph']: 'SELECT YOUR PLAN' ,
                    'image' => isset($page_fields['background_image_select_ph']) ? $page_fields['background_image_select_ph']: false ,
                    'repeat' => isset($page_fields['background_repeat_select_ph']) ? $page_fields['background_repeat_select_ph']: false ,
                    'attachment' => isset($page_fields['background_attachment_select_ph']) ? $page_fields['background_attachment_select_ph']: false ,
                    'position' => isset($page_fields['background_position_select_ph']) ? $page_fields['background_position_select_ph']: false ,
                    'size' => isset($page_fields['background_size_select_ph']) ? $page_fields['background_size_select_ph']: false ,
                    'color' => isset($page_fields['background_color_select_ph']) ? $page_fields['background_color_select_ph']: '#343434'
                ),
                'promotion_text' => isset($page_fields['title_select_pb']) ? $page_fields['title_select_pb']: false ,
                'body_image' => array(
                    'image' => isset($page_fields['background_image_select_pb']) ? $page_fields['background_image_select_pb']: false ,
                    'color' => isset($page_fields['background_color_select_pb']) ? $page_fields['background_color_select_pb']: '#c2c2c2'
                )
            );
            $response['plans'] = array_map(function ($plan) {
                $plan_id = $plan->get_id();
                $data = $plan->get_data();
                $promotion_image = get_field("promotion_image", $plan_id);
                return array(
                    'id' => $plan_id,
                    'name' => $data['name'],
                    'short_description' => $data['short_description'],
                    'price' => $data['price'],
                    'images' => $this->get_images($plan),
                    'best_value' => $promotion_image ? array(
                        'url' => $promotion_image['url'],
                        'alt' => $promotion_image['alt']
                    ): false
                );
            }, $membership_plans);

            usort($response['plans'], "organize");

            return new WP_REST_Response( $response, 200 );
        }

        return new WP_REST_Response( array(), 200 );
    }

    public function get_upsell_v2( $request ) {

        $products = get_posts(array(
            'post_type' => 'product',
            'product_cat' => 'upsell',
            'posts_per_page' => -1,
            'order' => 'DESC'
        ));

        foreach ($products as $key => $product_post) {

            $product_fields = get_fields($product_post->ID);

            if (isset($product_fields['upsell_templates']) and $product_fields['upsell_templates'] == 'template_2') {

                $product = wc_get_product( $product_post->ID );
                $price = $product->get_price();

                return new WP_REST_Response( array(
                    'id' => $product_post->ID,
                    'image' => isset($product_fields['image_background_d_t2']) ? $product_fields['image_background_d_t2']: false ,
                    'subtitle' => isset($product_fields['title_popup_t2']) ? $product_fields['title_popup_t2']: false ,
                    'price' => $price,
                    'title' => isset($product_fields['subtitle_popup_t2']) ? $product_fields['subtitle_popup_t2']: false ,
                    'body' => isset($product_fields['details_popup_t2']) ? $product_fields['details_popup_t2']: false
                ), 200 );

            }

        }

        return new WP_REST_Response( array(), 200 );

    }

    public function get_upsell_v1( $request ) {

        $products = get_posts(array(
            'post_type' => 'product',
            'product_cat' => 'upsell',
            'posts_per_page' => -1,
            'order' => 'DESC'
        ));

        foreach ($products as $key => $product_post) {

            $upsell_templates = get_field("upsell_templates", $product_post->ID);

            if ($upsell_templates == 'template_1') {

                $page = get_pages(array(
                    'meta_key' => '_wp_page_template',
                    'meta_value' => 'page-billing-information.php',
                    'posts_per_page' => 1,
                    'order' => 'ASC'
                ))[0];

                $page_fields = get_fields($page->ID);
                $thumbID = get_post_thumbnail_id($product_post->ID);
                $thumbnailImage = wp_get_attachment_image_src( $thumbID, 'full' );
                $product = wc_get_product( $product_post->ID );
                $price = $product->get_price();

                return new WP_REST_Response( array(
                    'id' => $product_post->ID,
                    'body_image' => isset($thumbnailImage[0]) ? $thumbnailImage[0]: false ,
                    'title' => isset($page_fields['text_popup']) ? $page_fields['text_popup']: false ,
                    'subtitle' => isset($page_fields['title_popup']) ? $page_fields['title_popup']: false ,
                    'subtitle_2' => isset($page_fields['subtitle_popup']) ? $page_fields['subtitle_popup']: false ,
                    'circle_image' => $page_fields['image_popup'] ? array(
                        'url' => $page_fields['image_popup']['url'],
                        'alt' => $page_fields['image_popup']['alt']
                    ): false ,
                    'body' => isset($page_fields['details_1_popup']) ? $page_fields['details_1_popup']: false ,
                    'feature_list' => isset($page_fields['details_2_popup']) ? $page_fields['details_2_popup']: false ,
                    'price' => $price,
                ), 200 );

            }

        }

        return new WP_REST_Response( array(), 204 );

    }

}

?>