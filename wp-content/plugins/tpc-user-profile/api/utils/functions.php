<?php


function get_product_membership($product, &$_cache) {
    $membership_plans_slugs = array_map(function($membership) {
        return $membership->slug;
    }, wc_memberships_get_membership_plans());

    $terms = get_the_terms($product->get_id(), 'product_cat');
    if (!is_array($terms)) {
        $terms = get_the_terms($product->get_parent_id(), 'product_cat');
    }
    if (is_array($terms)) {
        foreach ($terms as $term) {
            if ($term && isset($term->slug) && in_array($term->slug, $membership_plans_slugs)) {
                if (!in_array($term->slug, $_cache)) {
                    $_query_products = get_posts(array(
                        'post_type' => 'product',
                        'product_cat' => $term->slug,
                        'posts_per_page' => 1,
                        'meta_query' => array(array('key' => '_subscription_price', 'compare' => 'EXISTS')),
                        'order' => 'DESC'
                    ));
                    $subscription_product = !empty($_query_products) ? wc_get_product($_query_products[0]->ID): false;
                    if ($subscription_product && WC_Subscriptions_Product::is_subscription($subscription_product->get_id())) {
                        $_cache[$term->slug] = $subscription_product;
                    }
                }
                return isset($_cache[$term->slug]) ? $_cache[$term->slug] : false;
            }
        }
    }
    return false;
}

?>