<?php
/*
 * Main WordPress API
 *
 * @package WordPress
 *
 */

include_once('class-email-manager.php');


function _get_ids_from_queryset($query_array) {
    $list = array();
    foreach($query_array as $key => $value) {
        array_push($list, $query_array[$key]->ID);
    }
    return $list;
}

function get_variable_by_pattern($pattern, $previous, $type) {

    $types = array(
        'color' => 'pa_colors',
        'size' => 'pa_sizes',
        'type' => 'product_cat'
    );

    $index = 0;

    if (count($previous)) {
        foreach ($previous as $_o => $value) {
            foreach ($value->get_items() as $_l => $product) {
                if ($product->get_product() instanceof WC_Product_Variation) {
                    $product_variation = $product->get_product();
                    if ($type == 'type') {
                        $last = get_the_terms($product->get_product_id(), $types[$type])[0];
                    } else {
                        $attributes = $product_variation->get_attributes();
                        $last = $attributes[$types[$type]];
                    }
                    $slice = array_slice($pattern, $index, count($pattern) - $index, true);
                    $key = array_search($last, $slice);
                    if (!$key) {
                        $key = array_search($last, $pattern);
                        $index = $key;
                    }
                    $index = $key;
                } else {
                    continue;
                }

                if ($index == count($pattern) - 1) {
                    $index = 0;
                }
            }
        }
        if ($index + 1 == count($pattern)) {  // before sum
            $index = -1;
        }
        $index++;
        $item = $pattern[$index];
    } else {
        $item = $pattern[0];
    }
    if (isset($item->slug)) {
        $item = $item->slug;
    }
    $term = get_term_by('slug', $item, $types[$type]);
    return $term;
}

function _get_size_variation($previous, $quiz=null, $different=false) {
    $pattern = array('m', 's', 'l', 'm', 's', 'm', 'l');
    $size = get_variable_by_pattern($pattern, $previous, 'size');
    return $size;
}

function _get_color_variation($previous, $quiz, $different=false) {
    $terms = get_terms(array(
        'taxonomy' => 'pa_colors'
    ));

    $ordered_terms = $quiz->get_color();

    if (!function_exists('_ord')) {
        function _ord($a, $b) {
            $first = (float) $a->description;
            $second = (float) $b->description;
            if ($first == $second) return 0;
            return ($first < $second) ? 1: -1;
        }
    }

    usort($terms, '_ord');
    usort($ordered_terms, '_ord');

    foreach ($terms as $key => $value) {
        array_push($ordered_terms, $value->slug);
    }

    $color = get_variable_by_pattern($ordered_terms, $previous, 'color');
    return $color;
}

function _get_type_variation($previous, $quiz, $different=false) {
    $types = $quiz->get_type();
    $pattern = array();
    foreach ($types as $_a => $type) {
        array_push($pattern, $type->slug);
    }
    $type = get_variable_by_pattern($pattern, $previous, 'type');
    return $type;
}

function _customer_orders($user_id) {
    $customer_orders = get_posts( array(
        'meta_key' => '_customer_user',
        'meta_value' => $user_id,
        'post_type' => 'shop_order',
        'post_status' => 'wc-completed',
        'order'=> 'ASC',
        'orderby' => 'date', 
        'numberposts' => -1
    ));

    return $customer_orders;
}

function get_customer_orders($user_id) {
    $posts_ = array();

    $customer_orders = _customer_orders($user_id);

    foreach ($customer_orders as $_order) {
        $order = wc_get_order($_order->ID);
        array_push($posts_, $order);
    }
    return $posts_;
}

function get_customer_products($user_id) {
    $posts_exclude = array();

    $customer_orders = _customer_orders($user_id);

    foreach ($customer_orders as $_order) {
        $order = wc_get_order($_order->ID);
        $items = $order->get_items();
        foreach ($items as $item) {
            // $product_id = $item['variation_id'];
            $product_id = $item['product_id'];
            array_push($posts_exclude, $product_id);
        }
    }
    return $posts_exclude;
}

function select_product_by_color_size($products, $size, $color) {
    $selected_product = null;
    foreach ($products as $product) {
        $product = wc_get_product($product->ID);
        if ($product->get_available_variations()) {
            $variable_products = $product->get_available_variations();
            foreach($variable_products as $variable) {  // max_qty
                $_variable_product = new WC_Product_Variation($variable['variation_id']);
                $stock = (int) $_variable_product->get_stock_quantity();
                if ($variable['is_in_stock'] && $stock > 4) {
                    if ($variable['attributes']['attribute_pa_sizes'] === $size->slug && $variable['attributes']['attribute_pa_colors'] === $color->slug) {
                        $selected_product = wc_get_product($variable['variation_id']);
                        break;
                    }
                }
            }
            if ($selected_product) {
                break;
            }
        }
    }
    return $selected_product;
}

/**
 * Gets product for a tcp user
 * 
 * @param Quiz $quiz is the default data
 * @param array $products_ids an array of products
 */
function get_product_for_tcp_user($quiz, $products_ids) {

    if (sizeof($products_ids) === 0) {
        return null;
    }

    $user = $quiz->get_user();

    $posts_exclude = get_customer_products($user->ID);
    $orders_shipped = get_customer_orders($user->ID);

    $category = _get_type_variation($orders_shipped, $quiz);
    $category_id = $category->term_id;
    $size = _get_size_variation($orders_shipped, $quiz);
    $color = _get_color_variation($orders_shipped, $quiz);

    $products = get_posts(array(
        'post_in' => $products_ids,
        'post_type' => 'product',
        'post_status' => 'publish',
        'numberposts' => -1,
        'exclude' => $posts_exclude,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category_id,
            ),
        )
    ));

    $_colors = get_terms(array('taxonomy' => 'pa_colors'));
    $_sizes = get_terms(array('taxonomy' => 'pa_sizes'));
    $_types = get_terms(array('taxonomy' => 'product_cat'));

    foreach ($_sizes as $_j => $_size) {
        foreach ($_colors as $_k => $_color) {
            $selected_product = select_product_by_color_size($products, $size, $color);

            if (!$selected_product) {
                $color = $_color;
            } else {
                break;
            }
        }

        if (!$selected_product) {
            $size = $_size;
        } else {
            break;
        }
    }
    return $selected_product;
}

/**
 * Gets products of a subscription, by a membership rules
 * 
 * @param WC_Susbcription $subscription the subscription payed by customer
 */
function get_products_by_subscription($subscription) {
    $items = $subscription->get_items();
    $customer_id = $subscription->get_data()['customer_id'];
    // $f = $c->get_items();  // ->data['product_id']
    $objects_ids = array();
    $user_is_member = wc_memberships_is_user_member($customer_id);
    // $user_membership_active = wc_memberships_is_user_active_member($customer_id, $subscription);
    if ($user_is_member) {
        $memberships = wc_memberships_get_user_active_memberships($customer_id);
        $rules = get_option('wc_memberships_rules');  // aqui estan los productos
        if (sizeof($memberships) > 0) {
            $plan = $memberships[0]->plan_id;
    
            foreach ($rules as $_rule) {
                if ($_rule['membership_plan_id'] === $plan) {
                    $objects_ids = $_rule['object_ids'];
                    break;
                }
            }
        }
    }

    return $objects_ids;
}

/**
 * Create an order for a subscription payment
 * 
 * @param WC_Product $product
 */
function create_order($product, $order) {
    if ($product) {
        $order->add_product($product);
        $order->calculate_totals();
        $order->reduce_order_stock();
        $order->update_status("processing", 'Imported order', TRUE);
    }
}

function tcp_user_email($id) {
    global $wpdb;
    $query = "SELECT user_email FROM {$wpdb->users} WHERE ID='$id'";
    $user_email = $wpdb->get_var($query);
    return $user_email;
}

function tpc_results_quiz() {

    //this is the main item for the menu
    add_menu_page('Quiz Results', //page title
    'Results Of The Quiz', //menu title
    'manage_options', //capabilities
    'tpc_see_results_quiz', //menu slug
    'tpc_see_results_quiz' //function
    );
}

function tpc_see_results_quiz() {
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/tpc-user-profile/custom.css" rel="stylesheet" />
    <div class='wrap tpc-titel'>
        <h2>Quiz Results</h2>
    </div>
    <div class='tpc-content tpc-results-quiz'>
        <?php 
            if (!class_exists('Quiz')) {
                include_once( WP_PLUGIN_URL . "/tpc-user-profile/class-quiz.php");
            }
            global $wpdb;
            $tpcTable = Quiz::_table();

            $rows = $wpdb->get_results("SELECT * FROM $tpcTable WHERE 1");
            echo "<table class='tpc-table-admin' border=1 frame=hsides rules=rows >";
            echo "<thead><tr><th>Email</th><th>Color</th><th>Size</th><th>Type</th></tr></thead>";
            echo "<tbody>";
            foreach ($rows as $row ){
                $member_id = $row->member_id;
                $color = $row->color;
                $size = $row->size;
                $type = $row->type;
                if (tcp_user_email($member_id)) {
                    echo "<tr><td>".tcp_user_email($member_id)."</td><td>".$color."</td><td>".$size."</td><td>".$type."</td></tr>";
                }
            }
            echo "</tbody>";
            echo "</table>";

        ?>
    </div>
    <?php 
}

add_action('admin_menu','tpc_results_quiz');


add_action( 'rest_api_init', function () {
    if (!function_exists('tpc_register_routes')) {
        include_once(WP_PLUGIN_DIR . "/tpc-user-profile/api/api.php");
    }
    tpc_register_routes();
});

function protect_data ($protected, $meta_key, $meta_type) {
    switch ($meta_key) {
        case 'card-number':
            $protected = true;
            break;
        case 'card-cvc':
            $protected = true;
            break;
        case 'card-type':
            $protected = true;
            break;
        case 'card-expiry':
            $protected = true;
            break;
    }
    return $protected;
}
add_filter('is_protected_meta', 'protect_data', 10, 3);


function custom_checkout_field_display_admin_order_meta( $order ){
    $card_number = get_post_meta( $order->get_id(), 'card-number', true );
    if ( ! empty( $card_number )) {
        $card_number = implode('', explode(' ', $card_number));
        $first = substr($card_number, 0, 6);
        $second = substr($first, strlen($first) - 2, strlen($first) - 1);
        $last = substr($card_number, strlen($card_number) - 4, strlen($card_number) - 1);
        echo '<p><strong>'.__('Card Number', 'woocommerce').':</strong> ' . substr($first, 0, 4) . ' ' . $second . '** **** ' . $last . ' </p>';
    }
}
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'custom_checkout_field_display_admin_order_meta', 10, 1 );



function search_orders_custom_fields( $search_fields ) {
    $search_fields[] = '_order_total';
    $search_fields[] = 'limelight-order-id';
    $search_fields[] = 'limelight-gateway-customer-service';
    $search_fields[] = 'limelight-gateway-id';
    $search_fields[] = 'chargeback';
    $search_fields[] = 'Chargeback';
    $search_fields[] = 'card-number';
    $search_fields[] = 'card-type';
    $search_fields[] = 'card-cvc';
    $search_fields[] = 'card-expiry';

    return $search_fields;
}
add_filter( 'woocommerce_shop_order_search_fields', 'search_orders_custom_fields' );


function fue_register_variable_replacements( $var, $email_data, $fue_email, $queue_item ) {
    $month = date('F');
    $variables = array(
        'month'	=> $month
	);
    
    $var->register( $variables );
}
add_action( 'fue_before_variable_replacements', 'fue_register_variable_replacements', 10, 4);
?>
