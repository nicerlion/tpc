<?php


/*------------------------------------*\
    Css Style
\*------------------------------------*/

function on__style(){
    wp_enqueue_style('style-pwc', WP_PLUGIN_URL.'/pwc_carousel_section/css/style.css','style-pwc');
}
add_action('wp_print_styles', 'on__style');

/*------------------------------------*\
    Scripts
\*------------------------------------*/

function dcms_insertar_js(){
    
    wp_register_script('pwc_masonry_pkgd', WP_PLUGIN_URL.'/pwc_carousel_section/js/masonry.pkgd.min.js', array('jquery'), '1', true );
    wp_enqueue_script('pwc_masonry_pkgd');
    
    wp_register_script('pwc_flexslider', WP_PLUGIN_URL.'/pwc_carousel_section/js/jquery.flexslider-min.js', array('jquery'), '2', true );
    wp_enqueue_script('pwc_flexslider');

    wp_register_script('pwc_main', WP_PLUGIN_URL.'/pwc_carousel_section/js/main.js', array('jquery'), '3', true );
    wp_enqueue_script('pwc_main');

    wp_register_script('pwc_accordion', WP_PLUGIN_URL.'/pwc_carousel_section/js/accordion.js', array('jquery'), '3', true );
    wp_enqueue_script('pwc_accordion');
}
add_action("wp_enqueue_scripts", "dcms_insertar_js");

function tpc_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Terms Of User', '' ),
        'id'            => 'tpc-terms-of-user',
        'before_widget' => '<div id="%1$s" class="modal-body pt-text-box">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="modal-header pt-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title">',
        'after_title'   => '</h4> <div class="underline-pt"></div> </div>',
    ) );
}
add_action( 'widgets_init', 'tpc_widgets_init' );


add_action('rest_api_init', function () {
    register_rest_route('myplugin/v1', '/user/email', array('methods' => 'GET', 'callback' => 'my_awesome_func2'));
});

function my_awesome_func2( $data ) {
    $params = $data->get_params();

    $current_user = wp_get_current_user();
    $b = $current_user->user_email; 
    if ($current_user->user_email == $params['email']) {
        $user = false;
    } else {
        $user = get_user_by('email', $params['email']);
    }

    return new WP_REST_Response(array(
        "exists" => (bool) $user ? true: false
    ), 200);
}