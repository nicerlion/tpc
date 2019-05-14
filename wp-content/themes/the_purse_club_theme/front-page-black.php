<?php 
/**
 * Template Name: Home Design
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
		<?php get_template_part( 'template-parts/header/top', 'ads' ); ?>
		<section class="hero" style="background-image: url(<?php the_field('background_image_s1'); ?>); background-repeat: <?php the_field('background_repeat_s1'); ?>; background-attachment: <?php the_field('background_attachment_s1'); ?>; background-position: <?php the_field('background_position_s1'); ?>; background-size: <?php the_field('background_size_s1'); ?>; background-color: <?php the_field('background_color_s1'); ?>;">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="image-video-home-container">
								<?php the_field('video'); ?>
							</div>
							<p class="slider-text"><?php the_field('content_text_s1'); ?></p>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
							<div class="hero-text">
								<?php 
								$image = get_field('image_s1');
								if( !empty($image) ): ?>
									<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
								<?php endif; ?>
							</div>
							<div class="hero-button"><?php 
								$button = get_field('button_text_s1');
								if( !empty($button) ): ?>
									<div class="tpc-big-red-button">
										<a class="tpc-button-shadow" href="<?php the_field('link_button_s1'); ?>"><?php the_field('button_text_s1'); ?></a>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div> <!-- row -->
			</div> <!-- container -->
		</section>
		<section id="whatisthepurse" class="what-is-the-purse-club" style="background-image: url(<?php the_field('background_image_s2'); ?>); background-repeat: <?php the_field('background_repeat_s2'); ?>; background-attachment: <?php the_field('background_attachment_s2'); ?>; background-position: <?php the_field('background_position_s2'); ?>; background-size: <?php the_field('background_size_s2'); ?>; background-color: <?php the_field('background_color_s2'); ?>;">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h2><?php the_field('title_s2'); ?></h2>
						<div class="underline-title"></div>
						<div class="witpc-text">
							<p><?php the_field('subtitle_s2'); ?></p>
						</div>
							<div class="witpc-big-box">
								<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 witpc-box">
									<div class="witpc-mini-box">
										<h4><?php the_field('title_c1_s2'); ?></h4>
										<p><?php the_field('content_text_c1_s2'); ?></p>
										<div class="underline-wbb"></div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 witpc-box">
									<div class="witpc-mini-box">	
										<h4><?php the_field('title_c2_s2'); ?></h4>
										<p><?php the_field('content_text_c2_s2'); ?></p>
										<div class="underline-wbb"></div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 witpc-box">
									<div class="witpc-mini-box">
										<h4><?php the_field('title_c3_s2'); ?></h4>
										<p><?php the_field('content_text_c3_s2'); ?></p>
										<div class="underline-wbb"></div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 witpc-box">
									<div class="witpc-mini-box-last">
										<h4><?php the_field('title_c4_s2'); ?></h4>
										<p><?php the_field('content_text_c4_s2'); ?></p>
									</div>
								</div>
								<div class='vertical-line vertical-line-25'></div>
								<div class='vertical-line vertical-line-50'></div>
								<div class='vertical-line vertical-line-75'></div>
								<div class="cd-spac"></div>
							</div>
					  	</div><!--ends witpc-big-box-->
					</div>
				</div> <!-- row -->
			</div> <!-- container -->
		</section>
		<section class="vip-membership-benefits" style="background-image: url(<?php the_field('background_image_s3'); ?>); background-repeat: <?php the_field('background_repeat_s3'); ?>; background-attachment: <?php the_field('background_attachment_s3'); ?>; background-position: <?php the_field('background_position_s3'); ?>; background-size: <?php the_field('background_size_s3'); ?>; background-color: <?php the_field('background_color_s3'); ?>;">
            <div class="container">
                <div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">					
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<h3><?php the_field('title_s3'); ?></h3>
						<div class="underline-vip"></div>
							<div class="vip-membership-box">
								<h4><?php the_field('title_c1_s3'); ?></h4>
								<p><?php the_field('content_text_c1_s3'); ?></p>
							</div> <!-- vip-membership-box -->
							<div class="vip-membership-box">
								<h4><?php the_field('title_c2_s3'); ?></h4>
								<p><?php the_field('content_text_c2_s3'); ?></p>
							</div> <!-- vip-membership-box -->
							<div class="vip-membership-box">
								<h4><?php the_field('title_c3_s3'); ?></h4>
								<p><?php the_field('content_text_c3_s3'); ?></p>
							</div> <!-- vip-membership-box -->
						</div>
					</div>
                </div> <!-- row -->
            </div> <!-- container -->
        </section>
		<section class="win-dream-bag" style="background-image: url(<?php the_field('background_image_s4'); ?>); background-repeat: <?php the_field('background_repeat_s4'); ?>; background-attachment: <?php the_field('background_attachment_s4'); ?>; background-position: <?php the_field('background_position_s4'); ?>; background-size: <?php the_field('background_size_s4'); ?>; background-color: <?php the_field('background_color_s4'); ?>;">
            <div class="container">
        		<div class="row">
					<?php 
					$image = get_field('image_s4');
					if( !empty($image) ): ?>
						<img class="cd-diy-none-max-768" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
					<?php endif;
					$image = get_field('image_mobile_s4');
					if( !empty($image) ): ?>
						<img class="cd-diy-none-min-768" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
					<?php endif; ?>
					<?php 
					$button = get_field('button_text_s4');
					if( !empty($button) ): ?>
						<div class="tpc-medium-red-button">
							<a class="tpc-button-shadow" href="<?php the_field('link_button_s4'); ?>"><?php the_field('button_text_s4'); ?></a>
						</div>
					<?php endif; ?>
        		</div> <!-- row -->
            </div> <!-- container -->
        </section>
		<section id="howItWorks" class="how-it-works" style="background-image: url(<?php the_field('background_image_s5'); ?>); background-repeat: <?php the_field('background_repeat_s5'); ?>; background-attachment: <?php the_field('background_attachment_s5'); ?>; background-position: <?php the_field('background_position_s5'); ?>; background-size: <?php the_field('background_size_s5'); ?>; background-color: <?php the_field('background_color_s5'); ?>;">
            <div class="container">
                <div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hitw-big-box">
						<h2><?php the_field('title_s5'); ?></h2>
						<div class="underline-title"></div>
						<div class="hiw-text">
							<p><?php the_field('subtitle_s5'); ?></p>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 hitw-box">
							<div class="section-icon">
								<?php 
								$image = get_field('image_c1_s5');
								if( !empty($image) ): ?>
									<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
								<?php endif; ?>
							</div>
							<h4><?php the_field('title_c1_s5'); ?></h4>
							<p><?php the_field('content_text_c1_s5'); ?></p>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 hitw-box">
							<div class="section-icon">
								<?php 
								$image = get_field('image_c2_s5');
								if( !empty($image) ): ?>
									<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
								<?php endif; ?>
							</div>
							<h4><?php the_field('title_c2_s5'); ?></h4>
							<p><?php the_field('content_text_c2_s5'); ?></p>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 hitw-box hitw-neg-box">
							<div class="section-icon">
								<?php 
								$image = get_field('image_c3_s5');
								if( !empty($image) ): ?>
									<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
								<?php endif; ?>
							</div>
							<h4><?php the_field('title_c3_s5'); ?></h4>
							<p><?php the_field('content_text_c3_s5'); ?></p>
						</div>
						
					</div>
				</div> <!-- row -->
				<?php 
				$button = get_field('button_text_s5');
				if( !empty($button) ): ?>
					<div class="tpc-medium-red-button">
						<a class="tpc-button-shadow" href="<?php the_field('link_button_s5'); ?>"><?php the_field('button_text_s5'); ?></a>
					</div>
				<?php endif; ?>
            </div> <!-- container -->
        </section>
		<section class="prior-collections" style="background-image: url(<?php the_field('background_image_s6'); ?>); background-repeat: <?php the_field('background_repeat_s6'); ?>; background-attachment: <?php the_field('background_attachment_s6'); ?>; background-position: <?php the_field('background_position_s6'); ?>; background-size: <?php the_field('background_size_s6'); ?>; background-color: <?php the_field('background_color_s6'); ?>;">
            <div class="container">
                <div class="row">
					<h2><?php the_field('title_s6'); ?></h2>
					<div class="underline-title"></div>
					<p><?php the_field('subtitle_s6'); ?></p>
					<?php 
					$term = get_field('prior_collections_carousel_category');
					if( $term ): ?>
						<div class="prior-collections-container">
							<?php echo do_shortcode( '[prior_collections category="'.$term->slug.'"]' );?>
						</div>
					<?php endif; ?>
                </div> <!-- row -->
				<?php 
				$button = get_field('button_text_s6');
				if( !empty($button) ): ?>
					<div class="tpc-medium-red-button">
						<a class="tpc-button-shadow" href="<?php the_field('link_button_s6'); ?>"><?php the_field('button_text_s6'); ?></a>
					</div>
				<?php endif; ?>
            </div> <!-- container -->
        </section>
		<section class="customers-love-us" style="background-image: url(<?php the_field('background_image_s7'); ?>); background-repeat: <?php the_field('background_repeat_s7'); ?>; background-attachment: <?php the_field('background_attachment_s7'); ?>; background-position: <?php the_field('background_position_s7'); ?>; background-size: <?php the_field('background_size_s7'); ?>; background-color: <?php the_field('background_color_s7'); ?>;">
            <div class="container">
                <div class="row">
					<h2><?php the_field('title_s7'); ?></h2>
					<div class="underline-title"></div>
					<p><?php the_field('subtitle_s7'); ?></p>
					<div class="testimonials-container">
						<?php echo do_shortcode( '[testimonials_carousel]' );?>
					</div>
                </div> <!-- row -->
 				<?php 
				$button = get_field('button_text_s7');
				if( !empty($button) ): ?>
					<div class="tpc-medium-red-button">
						<a class="tpc-button-shadow" href="<?php the_field('link_button_s7'); ?>"><?php the_field('button_text_s7'); ?></a>
					</div>
				<?php endif; ?>
            </div> <!-- container -->
        </section>
		<section class="follow-us" style="background-image: url(<?php the_field('background_image_s8'); ?>); background-repeat: <?php the_field('background_repeat_s8'); ?>; background-attachment: <?php the_field('background_attachment_s8'); ?>; background-position: <?php the_field('background_position_s8'); ?>; background-size: <?php the_field('background_size_s8'); ?>; background-color: <?php the_field('background_color_s8'); ?>;">
            <div class="container">
                <div class="row">
					<h2><?php the_field('title_s8'); ?></h2>
					<div class="underline-title"></div>
					<p><?php the_field('subtitle_s8'); ?></p>
					<div class="follow-us-container">
					<?php follow_the_purse_club(); ?>
					</div>
                </div> <!-- row -->
            </div> <!-- container -->
        </section>
	</main>

<?php get_footer(); ?>
