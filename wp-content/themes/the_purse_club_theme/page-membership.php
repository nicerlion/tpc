<?php 
/**
 * Template Name: Membership Design
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

		</section>
		<!-- /POST section -->
		<?php
			$price_product1	= "";
			$product_id1 = "";
			global $product;
			$term1 = get_field('membership_product_category_s1');
			if( $term1 ){
				$args1 = array(
					'post_type' => 'product',
					'product_cat' => $term1->slug,
					'posts_per_page' => 1,
					'order'   => 'ASC'
				);
				$attractions  = new WP_Query($args1); 
				while($attractions->have_posts()) : $attractions->the_post(); 
					if ($price_html1 = $product->get_price_html()){
						$price_product1	= str_replace('</span>','</span><sub>', $price_html1);
						$price_product1	.= '</sub></sub></sub></sub></sub>';
						$price_product1	= str_replace('<sub></sub>','', $price_product1);
					}
					$product_id1 = $post->ID;
				endwhile; 
				// Restore original post data.
				wp_reset_postdata();
			}

			$price_product2	= "";
			$product_id2 = "";
			$term2 = get_field('product_category_s2');
			if( $term2 ){
				$args2 = array(
					'post_type' => 'product',
					'product_cat' => $term2->slug,
					'posts_per_page' => 1,
					'order'   => 'ASC'
				);
				$attractions  = new WP_Query($args2); 
				while($attractions->have_posts()) : $attractions->the_post(); 
					if ($price_html2 = $product->get_price_html()){
						$price_product2	= str_replace('</span>','</span><sub>', $price_html2);
						$price_product2	.= '</sub></sub></sub></sub></sub>';
						$price_product2	= str_replace('<sub></sub>','', $price_product2);
					}
					$product_id2 = $post->ID;
				endwhile; 
				// Restore original post data.
				wp_reset_postdata();
			}
		?>
		<section class="tpc-page-header"  style="background-image: url(https://www.thepurseclub.com/wp-content/uploads/2017/11/background-cover.png), url(<?php the_field('background_image_ph'); ?>); background-repeat: <?php the_field('background_repeat_ph'); ?>; background-attachment: <?php the_field('background_attachment_ph'); ?>; background-position: <?php the_field('background_position_ph'); ?>; background-size: <?php the_field('background_size_ph'); ?>; background-color: <?php the_field('background_color_ph'); ?>;">
			<div class="container">
				<div class="row">
					<h1 class="title-page-header"><?php the_field('title_ph'); ?></h1>
					<?php 
					$subtitle_ph = get_field('subtitle_ph');
					if( !empty($subtitle_ph) ): ?>
							<h4 class="transform-normal"><?php the_field('subtitle_ph'); ?></h4>					
					<?php endif; ?>
					<?php 
					$content_text_ph = get_field('content_text_ph');
					if( !empty($content_text_ph) ): ?>
						<div class="tpc-header-p">
							<p><?php the_field('content_text_ph'); ?></p>
						</div>
					<?php endif; ?>
				</div> <!-- row -->
			</div> <!-- container -->
		</section> <!-- tpc-page-header -->
		<section class="tpc-page-container tpc-page-membership">
			<div class="container">
				<div class="row">
					<div class="tpc-marg-b-57 col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="tpc-left-offer">
							<div class="tpc-header-offer">
								<h2><?php the_field('title_s1'); ?></h2>
							</div>
							<div class="tpc-container-offer">
								<h3><span><?php the_field('subtitle_s1'); ?></span></h3>
								<div class="tpc-info-offer">
									<div class="tpc-info-offer-container">
										<p class="tpc-price-info"><?php echo $price_product1; ?><?php echo do_shortcode(get_field('value_for_time_s1')); ?></p>
										<p><?php the_field('detail_of_the_value_s1'); ?></p>
										<div class="tpc-message">	
											<p class="suggestion-message"><?php the_field('content_text_s1'); ?></p>
											<div id="suggestion-message"></div>
										</div>
										<?php 
										$term = get_field('membership_carousel_category_s1');
										if( $term ): ?>
											<?php bootstrap_carousel($term->slug); ?>
										<?php endif; ?>
									</div>
								</div>
								<div class="hint-container">
									<div class="tpc-details">
										<p>
											<span class="tpc-ico-question" data-popup-open="popup-1"><?php the_field('see_details_s1'); ?></span>
										</p>
										<div class="hover-popup">
											<div class="hover-popup-content">
												<?php the_field('popup_detail_s1'); ?>
											</div>
											<img src="<?php echo get_template_directory_uri(); ?>/img/hint-arrow.png" alt="">
										</div>
									</div>
									<?php 
									$button = get_field('button_text_s1');
									if( !empty($button) ): ?>
										<div class="tpc-membership-button">
											<div id="tpc-disabled-1"></div>
											<a id="<?php echo "TpcProductId-".$product_id1 ?>" href="<?php echo esc_url( home_url( '/billing-information/?add-to-cart='.$product_id1 ) ); ?>"><?php the_field('button_text_s1'); ?></a>
										</div>
									<?php endif; ?>
								</div> <!-- hint-container  -->
							</div>
						</div>
					</div>
					<div class="tpc-marg-b-57 col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="tpc-right-offer">
							<div class="tpc-header-offer">
								<h2><?php the_field('title_s2'); ?></h2>
							</div>
							<div class="tpc-container-offer">
								<h3><span><?php the_field('subtitle_s2'); ?></span></h3>
								<div class="tpc-info-offer">
									<div class="tpc-info-offer-container">
										<p class="tpc-price-info"><?php echo $price_product2; ?><?php echo do_shortcode(get_field('value_for_time_s2')); ?></p>
										<p><?php the_field('detail_of_the_value_s2'); ?></p>
										<div class="tpc-message">	
											<p class="suggestion-message"><?php the_field('content_text_s2'); ?></p>
										<div id="suggestion-message"></div>
										</div>
										<?php 
										$term = get_field('membership_carousel_category_s2');
										if( $term ): ?>
											<?php bootstrap_carousel($term->slug); ?>
										<?php endif; ?>
									</div>
								</div>
								<div class="hint-container">
									<div class="tpc-details">
										<p>
											<span class="tpc-ico-question" data-popup-open="popup-1"><?php the_field('see_details_s2'); ?></span>
										</p>
										<div class="hover-popup sec-mem-col">
											<div class="hover-popup-content">
												<?php the_field('popup_detail_s2'); ?>
											</div>
											<img src="<?php echo get_template_directory_uri(); ?>/img/hint-arrow.png" alt="">
										</div>
									</div>
									<?php 
									$button = get_field('button_text_s2');
									if( !empty($button) ): ?>
										<div class="tpc-membership-button">
											<div id="tpc-disabled-2"></div>
											<a id="<?php echo "TpcProductId-".$product_id2 ?>" href="<?php echo esc_url( home_url( '/billing-information/?add-to-cart='.$product_id2 ) ); ?>"><?php the_field('button_text_s2'); ?></a>
										</div>
									<?php endif; ?>
								</div> <!-- hint-container  -->
							</div>
						</div>
					</div>
				</div> <!-- row -->
				<input type="hidden" id="TpcProductId">
			</div> <!-- container -->
		</section> <!-- tpc-page-container -->
	</main>
	<script type="text/javascript">
		function TpcProductIdValidate(){
			var productCartMembership = localStorage.getItem('productCartMembership');
			if (productCartMembership != null && productCartMembership != "false") {
				var TpcProductId = "#"+productCartMembership;
				jQuery(TpcProductId).attr("href", "<?php echo esc_url( home_url( '/billing-information/' ) ); ?>");
			}
		}
		jQuery('#<?php echo "TpcProductId-".$product_id1 ?>').live("hover", function(){
			jQuery("#TpcProductId").val('<?php echo "TpcProductId-".$product_id1 ?>');
			TpcProductIdValidate();
		});
		jQuery('#<?php echo "TpcProductId-".$product_id1 ?>').live("focus", function(){
			jQuery("#TpcProductId").val('<?php echo "TpcProductId-".$product_id1 ?>');
			TpcProductIdValidate();
		});
		jQuery('#<?php echo "TpcProductId-".$product_id2 ?>').live("hover", function(){
			jQuery("#TpcProductId").val('<?php echo "TpcProductId-".$product_id2 ?>');
			TpcProductIdValidate();
		});
		jQuery('#<?php echo "TpcProductId-".$product_id2 ?>').live("focus", function(){
			jQuery("#TpcProductId").val('<?php echo "TpcProductId-".$product_id2 ?>');
			TpcProductIdValidate();
		});
		jQuery('#<?php echo "TpcProductId-".$product_id1 ?>').live("click", function(){
			jQuery("#tpc-disabled-1").attr("class", "tpc-disabled");
		});
		jQuery('#<?php echo "TpcProductId-".$product_id2 ?>').live("click", function(){
			jQuery("#tpc-disabled-2").attr("class", "tpc-disabled");
		});		
	</script>
<?php get_footer(); ?>
