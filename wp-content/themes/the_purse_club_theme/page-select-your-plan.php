<?php 
/**
 * Template Name: Select you Plan Design
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
		<?php 
		$section_categoy = "";
		if(isset($_GET["membership"])){ 
			$categoy = $_GET["membership"];
			if ($categoy == "gold-membership") {
				$section_categoy = "_s1";
			}elseif ($categoy == "platinum-membership") {
				$section_categoy = "_s2";
			}
		}
		?>
		<?php 			
		$field = get_field_object('show_the_top_header');
		if ( $field['value'] == "yes") { ?>
			<section class="tpc-page-header"  style="background-image: url(<?php the_field('background_image_ph'); ?>); background-repeat: <?php the_field('background_repeat_ph'); ?>; background-attachment: <?php the_field('background_attachment_ph'); ?>; background-position: <?php the_field('background_position_ph'); ?>; background-size: <?php the_field('background_size_ph'); ?>; background-color: <?php the_field('background_color_ph'); ?>;">
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
		<?php }else{
			echo "<div class='display-none'><h1>".get_the_title()."</h1></div>";
		} ?>
		<?php if ($section_categoy != "") {?>
			<section class="tpc-page-container tpc-page-select-your-plan">
				<div class="container-fluid">
					<div class="container">
						<div class="row">
							<div class="hidden-xs hidden-sm col-md-4 col-lg-4 tpc-woman-border">
								<div class="tpc-woman-img">
									<div class="tpc-woman-container">
										<h2><?php the_field('title'.$section_categoy); ?></h2>
										<hr>
										<p><?php the_field('content_text'.$section_categoy); ?></p>
									</div>
									<?php 
									$image = get_field('image'.$section_categoy);
									if( !empty($image) ): ?>
										<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
									<?php endif; ?>
								</div>
							</div>
							<div class="col-sm-12 col-sm-12 col-md-8 col-lg-8 tpc-item-container">
								<?php 
								global $product;
									$args = array(
										'post_type' => 'product',
										'product_cat' => $categoy,
										'posts_per_page' => -1,
										'order'   => 'DESC'
									);
									$attractions  = new WP_Query($args); 
									while($attractions->have_posts()) : $attractions->the_post(); 
										?>
										<div class="tpc-item-select">
											<div class="month-title-syp">
												<h2><?php the_title(); ?></h2>
											</div>
											<div class="black-line">
												<h3></h3>
											</div>
											<div class="inside-box-syp">
												<?php if ( $price_html = $product->get_price_html() ) : 
													$price_product	= str_replace('</span>','</span><sub>', $price_html);

													$price_product	.= '</sub></sub></sub></sub></sub>';
													$price_product	= str_replace('<sub></sub>','', $price_product);
												?>
													<h3 class="tpc-price-info"><?php echo $price_product; ?></h3>
												<?php endif;  ?>
												<!--<h3><sup>$</sup><?php // echo $product->get_sign_up_fee(); ?></h3>-->
												<p class="pice-detail"><?php the_field('price_details'); ?></p>
												<div class="tpc-message pice-detail">
													<div class="suggestion-message"><?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?></div>
													<div id="suggestion-message"></div>
												</div>
												<?php 
												$thumbID = get_post_thumbnail_id( $post->ID );
												$imgDestacada = wp_get_attachment_image_src( $thumbID, 'full' );
												?>
												<img src="<?php echo $imgDestacada[0]; ?>">
											</div>
											<div class="tpc-black-button">
												<a href="<?php echo esc_url( home_url( '/billing-information/?add-to-cart='.$post->ID ) ); ?>">SELECT PLAN</a>
											</div>
										</div>
										<?php
									endwhile; 
								
									// Restore original post data.
									wp_reset_postdata();
								?>
								
							</div>	
						</div> <!-- row -->
					</div> <!-- container -->
				</div> <!-- container-fluid -->
			</section> <!-- tpc-page-container -->
		<?php }else{ ?>
			<section class="tpc-page-container tpc-page-select-your-plan-message">
				<div class="container"  style="background-image: url(<?php the_field('background_image_s3'); ?>); background-repeat: <?php the_field('background_repeat_s3'); ?>; background-attachment: <?php the_field('background_attachment_s3'); ?>; background-position: <?php the_field('background_position_s3'); ?>; background-size: <?php the_field('background_size_s3'); ?>; background-color: <?php the_field('background_color_s3'); ?>;">
					<div class="tpc-vertical-center"><?php the_field('content_text_s3'); ?></div>
				</div> <!-- container -->
			</section> <!-- tpc-page-container -->
		<?php } ?>
	</main>

<?php get_footer(); ?>
