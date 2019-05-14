<?php 
/**
 * Template Name: Upsell Design
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
		<?php 
			global $product;
			$args = array(
				'post_type' => 'product',
				'product_cat' => 'upsell',
				'posts_per_page' => 1,
				'order'   => 'DESC'
			);
			$attractions  = new WP_Query($args); 
			while($attractions->have_posts()) : $attractions->the_post(); 
				$thumbID = get_post_thumbnail_id( $post->ID );
				$imgDestacada = wp_get_attachment_image_src( $thumbID, 'full' );
				if ( $price_html = $product->get_price_html() ) : 
					$price_product	= str_replace('<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">','<span id="tpc-value-price" class="woocommerce-Price-amount amount"><span id="tpc-symbol" class="woocommerce-Price-currencySymbol">', $price_html);
					echo "<div style='display: none;'>".$price_product.'</div>';
				endif;
				$add_to_cart = '?add-to-cart='.$post->ID; 
			endwhile; 
		
			// Restore original post data.
			wp_reset_postdata();
		?>
		<!-- /POST section -->
		<section class="tpc-page-header" style="background-image: url(<?php the_field('background_image_ph'); ?>); background-repeat: <?php the_field('background_repeat_ph'); ?>; background-attachment: <?php the_field('background_attachment_ph'); ?>; background-position: <?php the_field('background_position_ph'); ?>; background-size: <?php the_field('background_size_ph'); ?>; background-color: <?php the_field('background_color_ph'); ?>;">
			<div class="container">
				<div class="row">
					<h1><?php the_field('title_ph'); ?></h1>
					<?php 
					$subtitle_ph = get_field('subtitle_ph');
					if( !empty($subtitle_ph) ): ?>
						<h4><?php the_field('subtitle_ph'); ?></h4>
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
		<section class="ups-page-container ups-page-select-your-plan">
			<div class="container-fluid ups-container">
				<div class="col-sm-12 col-sm-12 col-md-12 col-lg-12 upd-item-container">
					<div class="hidden-xs hidden-sm col-md-6 col-lg-6 upd-woman-border">
						<?php 
						$image = get_field('image');
						if( !empty($image) ): ?>
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
						<?php endif; ?>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 upd-purse">
						<img src="<?php echo $imgDestacada[0]; ?>">
						<div class="upd-inside-purse">
							<div class="upd-inside-purse-container">
								<h2><?php the_field('title'); ?></h2>
								<?php the_field('details'); ?>
							</div>
							<div class="checkbox upd-check">
					    		<label>
					    	  		<input class="micheckbox" type="checkbox">
					    	  		<p class=""><?php the_field('text_checkbox'); ?></p>
					    		</label>
					  		</div>
					  	</div>
					</div><!-- ends upd-purse-->							
				</div><!-- end upd-item-container-->
				</div> <!-- container-fluid -->
					<div class="upd-button">
							<a id="url-add-to-cart" class="tpc-button-shadow" href="<?php echo esc_url( home_url( '/billing-information/' ) ); ?>"><?php the_field('button_text'); ?></a>	
					</div>
		</section> <!-- tpc-page-container -->
		
	</main>
<?php get_footer(); ?>
<script>
	jQuery(document).ready(function(){
	    jQuery("#tpc-symbol").remove();
	    jQuery("#tpc-price-value").text(jQuery("#tpc-value-price").text());
	});
	jQuery(".micheckbox").on( 'change', function() {
	    if( jQuery(".micheckbox").is(':checked') ) {
	    	jQuery("#url-add-to-cart").attr("href", "<?php echo esc_url( home_url( '/billing-information/'.$add_to_cart ) ); ?>");   
	    } else {
	    	jQuery("#url-add-to-cart").attr("href", "<?php echo esc_url( home_url( '/billing-information/' ) ); ?>");    
	    }
	});
</script>
