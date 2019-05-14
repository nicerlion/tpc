<?php 
/**
 * Template Name: Billing Information Design
 */
get_header(); ?>


	<main role="main">
		<!-- section -->
		<section>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php the_content(); ?>

				<?php comments_template( '', true ); // Remove if you don't want comments ?>

				<?php edit_post_link(); ?>

			</article>
			<!-- /article -->

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>
		<!-- /POST section -->
		</section>
		<div id="tpc-script-validation"></div>
		<div id="tpc-script"></div>
		<?php
		    $url = $_SERVER["REQUEST_URI"];
		    $string_value = 'billing-information/?add-to-cart';
		    $strpos = strpos($url, $string_value);
		    if ($strpos != false) {
		    	$IdProduct = $_GET["add-to-cart"];
		    	WC()->cart->empty_cart();
				WC()->cart->add_to_cart($IdProduct);
				header ("Location: ". home_url("/billing-information/"));
			}
			$category_memberhip_1 = "";
			$category_memberhip_2 = "";
			$category_memberhip_product_id_1 = "";
			$category_memberhip_product_id_2 = "";
			$args = array(
			    'post_type' => 'page',
			    'meta_key' => '_wp_page_template',
			    'meta_value' => 'page-membership.php',
			    'posts_per_page' => 1,
			    'order'   => 'DESC'
			);
			$attractions  = new WP_Query($args); 
			while($attractions->have_posts()) : $attractions->the_post(); 
			    $category_memberhip_1 = get_field('membership_product_category_s1');
			    $category_memberhip_2 = get_field('product_category_s2');
			endwhile; 
			// Restore original post data.
			wp_reset_postdata();
			if($category_memberhip_1 != ""){
			    $args1 = array(
			        'post_type' => 'product',
			        'product_cat' => $category_memberhip_1->slug,
			        'posts_per_page' => 1,
			        'order'   => 'ASC'
			    );
			    $attractions  = new WP_Query($args1); 
			    while($attractions->have_posts()) : $attractions->the_post(); 
			        $category_memberhip_product_id_1 = $post->ID;
			    endwhile; 
			    // Restore original post data.
			    wp_reset_postdata();
			}
			if($category_memberhip_2 != ""){
			    $args1 = array(
			        'post_type' => 'product',
			        'product_cat' => $category_memberhip_2->slug,
			        'posts_per_page' => 1,
			        'order'   => 'ASC'
			    );
			    $attractions  = new WP_Query($args1); 
			    while($attractions->have_posts()) : $attractions->the_post(); 
			        $category_memberhip_product_id_2 = $post->ID;
			    endwhile; 
			    // Restore original post data.
			    wp_reset_postdata();
			}
			$select_category = "";
			$select_your_plan_gold = get_field('select_your_plan_1');
			$select_your_plan_platinum = get_field('select_your_plan_2');
			$productItemCart = "";
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			    if ($category_memberhip_product_id_1 != "" and $category_memberhip_product_id_1 == $cart_item["product_id"]) {
					$select_category = $select_your_plan_gold->slug;
					$productItemCart = $cart_item["product_id"];
			    }elseif ($category_memberhip_product_id_2 != "" and $category_memberhip_product_id_2 == $cart_item["product_id"]) {
					$select_category = $select_your_plan_platinum->slug;
					$productItemCart = $cart_item["product_id"];
			    }
			}
		?>
		<?php if ($select_category != "") { ?>
			<div class="modal fade" id="SelectYourPlanModal" role="dialog">
				<div id="SelectBackPopup" class="back-popup"></div>
				<div class="modal-dialog select-your-plan-modal">
					<div class="modal-content pt-content-box">
						<section class="tpc-page-header"  style="background-image: url(<?php the_field('background_image_select_ph'); ?>); background-repeat: <?php the_field('background_repeat_select_ph'); ?>; background-attachment: <?php the_field('background_attachment_select_ph'); ?>; background-position: <?php the_field('background_position_select_ph'); ?>; background-size: <?php the_field('background_size_select_ph'); ?>; background-color: <?php the_field('background_color_select_ph'); ?>;">
							<h2 class="title-page-header"><?php the_field('title_select_ph'); ?></h2>
						</section> <!-- tpc-page-header -->
						<p class="psypnewd-first-text"><?php the_field('title_select_pb'); ?></p>
						<section class="popup-select-content"  style="background-image: url(<?php the_field('background_image_select_pb'); ?>); background-color: <?php the_field('background_color_select_pb'); ?>; background-repeat: no-repeat; background-position: center; background-size: cover;">
							<?php 
								global $product;
								$args = array(
									'post_type' => 'product',
									'product_cat' => $select_category,
									'posts_per_page' => -1,
									'order'   => 'DESC'
								);
								$attractions  = new WP_Query($args); 
								while($attractions->have_posts()) : $attractions->the_post(); 
									if ($productItemCart != $post->ID) {
							?>
								<div class="psypnewd-item-select">
									<?php 
									$image = get_field('promotion_image');
									if( !empty($image) ): ?>
										<img class="item-select-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
									<?php endif; ?>
									<div class="psypnewd-mini-item">
										<div class="psypnewd-month-title">
											<h2><span><?php the_title(); ?></span></h2>
										</div>
										<div class="inside-box-psypnewd">
											<p class="pice-detail"></p>
											<?php 
											$thumbID = get_post_thumbnail_id( $post->ID );
											$imgDestacada = wp_get_attachment_image_src( $thumbID, 'full' );
											?>
											<img src="<?php echo $imgDestacada[0]; ?>">
										</div>
										<div class="psypnewd-text-box">
											<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?>
										</div>
										<div class="psypnewd-value">
											<?php if ( $price_html = $product->get_price_html() ) { 
												echo $price_html;
											}
											?>
										</div>
										<div class="psypnewd-black-button">
											<a id="product-item-<?php echo $post->ID; ?>" href="#">SELECT PLAN</a>
											<div class="sp-clear"></div>
										</div>
									</div>
								</div>
							<?php
									}
								endwhile; 
							
								// Restore original post data.
								wp_reset_postdata();
							?>
							<div class="sp-clear"></div>
						</section> <!-- tpc-page-header -->
						<p class="psypnewd-last-text"><a id="noThanks" href="#"><?php the_field('no_thanks'); ?></a></p>
					</div>
				</div>
				<button type="button" class="select_your_plan_close close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<script>
					jQuery('#noThanks').live('click', function(e){
						e.preventDefault();
						jQuery( ".modal-backdrop.fade.in").css("display", "none");
						jQuery( "#SelectYourPlanModal").css("display", "none");
						jQuery("#upsellModal").modal("show");
					});
					jQuery('#SelectBackPopup').live('click', function(){
						jQuery( ".modal-backdrop.fade.in").css("display", "none");
						jQuery( "#SelectYourPlanModal").css("display", "none");
						jQuery("#upsellModal").modal("show");
					});
					function addToCart(p_id) {
						jQuery( "#loadingSelection").css("display", "block");
						jQuery.get("<?php echo esc_url( home_url( '/?add-to-cart=' ) ); ?>" + p_id, function() {
							jQuery( "#loadingSelection").css("display", "none");
						});
						jQuery( ".modal-backdrop.fade.in").css("display", "none");
						jQuery( "#SelectYourPlanModal").css("display", "none");
						jQuery("#upsellModal").modal("show");
						localStorage.setItem('productCartMembership',false);
					}
				</script>
				<?php while($attractions->have_posts()) : $attractions->the_post(); ?>
					<script>    
						jQuery('#product-item-<?php echo $post->ID; ?>').live('click', function(e) {
							e.preventDefault();
							addToCart(<?php echo $post->ID; ?>);
						});    
					</script>
				<?php
				endwhile; 
				// Restore original post data.
				wp_reset_postdata();
				?>
			</div>
			<div id="loadingSelection"><img src="https://www.thepurseclub.com/wp-content/uploads/2018/01/loding-select.gif" alt="loding"></div>
		<?php }else{ ?>
			<script>
				jQuery('#selectSubmit[data-toggle="modal"]').live('click', function(e){
					jQuery("#upsellModal").modal("show");
				});
			</script>
		<?php } ?>
<?php get_footer(); ?>