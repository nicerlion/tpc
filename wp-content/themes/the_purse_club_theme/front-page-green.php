<?php 
/**
 * Template Name: Green Home Design
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
		<section class="hero-s" style="background-image: url(<?php the_field('background_image_s1'); ?>); background-repeat: <?php the_field('background_repeat_s1'); ?>; background-attachment: <?php the_field('background_attachment_s1'); ?>; background-position: <?php the_field('background_position_s1'); ?>; background-size: <?php the_field('background_size_s1'); ?>; background-color: <?php the_field('background_color_s1'); ?>;">
			<div class="hero-v" style="background-image: url(<?php the_field('top_image_background_s1'); ?>); background-repeat: no-repeat; background-color: transparent; background-position: center;">
				<?php 
				$image = get_field('image_for_mobile_s1');
				if( !empty($image) ): ?>
					<img class="hero-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
				<?php endif; ?>
				<div class="hero-container">
					<?php the_field('content_text_s1'); ?>
					<?php 
					$button = get_field('button_text_s1');
					if( !empty($button) ): ?>
						<div class="tpc-btn-home-s">
							<a class="" href="<?php the_field('link_button_s1'); ?>"><?php the_field('button_text_s1'); ?></a>
						</div>
					<?php endif; ?>
				</div>
			</div> <!-- hero-v -->
		</section>
		<section class="features-s" style="background-image: url(<?php the_field('background_image_s2'); ?>); background-repeat: <?php the_field('background_repeat_s2'); ?>; background-attachment: <?php the_field('background_attachment_s2'); ?>; background-position: <?php the_field('background_position_s2'); ?>; background-size: <?php the_field('background_size_s2'); ?>; background-color: <?php the_field('background_color_s2'); ?>">
            <div class="container">
                <div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 features-s-box">
						<h2><?php the_field('title_s2'); ?></h2>
						<div class="witpc-text witpc-text-s">
							<p><?php the_field('subtitle_s2'); ?></p>
						</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 features-s-box">
						<div class=" col-xs-12 col-sm-6 col-md-6 col-lg-6 features-s-box-item">
							<h4 class="pink"><?php the_field('title_c1_s2'); ?></h4>
							<p><?php the_field('content_text_c1_s2'); ?></p>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 features-s-box-item">
							<h4 class="pink"><?php the_field('title_c2_s2'); ?></h4>
							<p><?php the_field('content_text_c2_s2'); ?></p>
						</div>
						<div class=" col-xs-12 col-sm-6 col-md-6 col-lg-6 features-s-box-item">
							<h4 class="pink"><?php the_field('title_c3_s2'); ?></h4>
							<p><?php the_field('content_text_c3_s2'); ?></p>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 features-s-box-item">
							<h4 class="pink"><?php the_field('title_c4_s2'); ?></h4>
							<p><?php the_field('content_text_c4_s2'); ?></p>
						</div>
					</div>
                </div> <!-- row -->
            </div> <!-- container -->
		</section>
		<section id="vip-membership" class="what-is-the-purse-club-s" style="background-image: url(<?php the_field('background_image_s3'); ?>); background-repeat: <?php the_field('background_repeat_s3'); ?>; background-attachment: <?php the_field('background_attachment_s3'); ?>; background-position: <?php the_field('background_position_s3'); ?>; background-size: <?php the_field('background_size_s3'); ?>; background-color: <?php the_field('background_color_s3'); ?>;">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 features-s">
						<h2><?php the_field('title_s3'); ?></h2>
						<div class="witpc-text witpc-text-s">
							<p><?php the_field('subtitle_s3'); ?></p>
						</div>
						<div class="witpc-container">
							<div class="item-witpc-mini-box-s">
								<?php 
								$image = get_field('image_c1_s3');
								if( !empty($image) ): ?>
									<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
								<?php endif; ?>
								<h4 class="pink"><?php the_field('title_c1_s3'); ?></h4>
								<p><?php the_field('content_text_c1_s3'); ?></p>
							</div>
							<div class="item-witpc-mini-box-s">	
								<?php 
								$image = get_field('image_c2_s3');
								if( !empty($image) ): ?>
									<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
								<?php endif; ?>
								<h4 class="pink"><?php the_field('title_c2_s3'); ?></h4>
								<p><?php the_field('content_text_c2_s3'); ?></p>
							</div>
							<div class="item-witpc-mini-box-s">
								<?php 
								$image = get_field('image_c3_s3');
								if( !empty($image) ): ?>
									<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
								<?php endif; ?>
								<h4 class="pink"><?php the_field('title_c3_s3'); ?></h4>
								<p><?php the_field('content_text_c3_s3'); ?></p>
							</div>
							<div class='vertical-line vertical-line-33'></div>
							<div class='vertical-line vertical-line-66'></div>
							<div class='cd-spac'></div>
						</div>
						<?php 
						$button = get_field('button_text_s3');
						if( !empty($button) ): ?>
							<div class="tpc-btn-home-s">
								<a href="<?php the_field('link_button_s3'); ?>"><?php the_field('button_text_s3'); ?></a>
							</div>
						<?php endif; ?>
					</div>
				</div><!-- row -->
			</div> <!-- container -->
		</section>
		<section class="middle-s" style="background-image: url(<?php the_field('background_image_s4'); ?>); background-repeat: <?php the_field('background_repeat_s4'); ?>; background-attachment: <?php the_field('background_attachment_s4'); ?>; background-position: 39%; background-size: <?php the_field('background_size_s4'); ?>; background-color: <?php the_field('background_color_s4'); ?>;">
			<div class="middle-b" style="background-image: url(<?php the_field('bag_image'); ?>); background-repeat: no-repeat; background-color: transparent; background-position: top right;"></div>
			<div class="middle-v" style="background-image: url(<?php the_field('top_image_background_s4'); ?>); background-repeat: no-repeat; background-color: transparent; background-position: center;">
				<?php 
				$image = get_field('image_for_mobile_s4');
				if( !empty($image) ): ?>
					<img class="middle-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
				<?php endif; ?>
				<div class="middle-container">
					<?php the_field('content_text_s4'); ?>
					<?php 
					$button = get_field('button_text_s4');
					if( !empty($button) ): ?>
						<div class="tpc-btn-home-s">
							<a href="<?php the_field('link_button_s4'); ?>"><?php the_field('button_text_s4'); ?></a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<section id="howItWorks" class="how-it-works-s"  style="background-image: url(<?php the_field('background_image_s5_green'); ?>); background-repeat: <?php the_field('background_repeat_s5_green'); ?>; background-attachment: <?php the_field('background_attachment_s5_green'); ?>; background-position: <?php the_field('background_position_s5_green'); ?>; background-size: <?php the_field('background_size_s5_green'); ?>; background-color: <?php the_field('background_color_s5_green'); ?>;">
            <div class="container">
                <div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 features-s">
						<h2><?php the_field('title_s5_green'); ?></h2>
						<div class="hiw-text witpc-text-s">
							<p><?php the_field('subtitle_s5_green'); ?></p>
						</div>
						<div class="hiw-container">
							<div class="item-hiw-box-s">
								<?php 
								$image = get_field('image_c1_s5_green');
								if( !empty($image) ): ?>
									<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
								<?php endif; ?>
								<h4 class="pink"><?php the_field('title_c1_s5_green'); ?></h4>
								<p><?php the_field('content_text_c1_s5_green'); ?></p>
							</div>
							<div class="item-hiw-box-s">
								<?php 
								$image = get_field('image_c2_s5_green');
								if( !empty($image) ): ?>
									<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
								<?php endif; ?>
								<h4 class="pink"><?php the_field('title_c2_s5_green'); ?></h4>
								<p><?php the_field('content_text_c2_s5_green'); ?></p>
							</div>
							<div class="item-hiw-box-s style-box-none">
								<?php 
								$image = get_field('image_c3_s5_green');
								if( !empty($image) ): ?>
									<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
								<?php endif; ?>
								<h4 class="pink"><?php the_field('title_c3_s5_green'); ?></h4>
								<p><?php the_field('content_text_c3_s5_green'); ?></p>
							</div>
							<div class="right-arrow-vertical arrow-vertical-33"></div>
							<div class="right-arrow-vertical arrow-vertical-66"></div>
							<div class='cd-spac'></div>
						</div>
					<?php 
					$button = get_field('button_text_s5_green');
					if( !empty($button) ): ?>
						<div class="tpc-btn-home-s">
							<a href="<?php the_field('link_button_s5_green'); ?>"><?php the_field('button_text_s5_green'); ?></a>
						</div>
					<?php endif; ?>
				</div> <!-- row -->
            </div> <!-- container -->
        </section>
		<section class="prior-collections-green gray-bg features-s" style="background-image: url(<?php the_field('background_image_s6_green'); ?>); background-repeat: <?php the_field('background_repeat_s6_green'); ?>; background-attachment: <?php the_field('background_attachment_s6_green'); ?>; background-position: <?php the_field('background_position_s6_green'); ?>; background-size: <?php the_field('background_size_s6_green'); ?>; background-color: <?php the_field('background_color_s6_green'); ?>;">
            <div class="container">
                <div class="row">
					<h2><?php the_field('title_s6_green'); ?></h2>
					<div class="witpc-text witpc-text-s">
						<p><?php the_field('subtitle_s6_green'); ?></p>
					</div>
				</div> <!-- row -->
			</div>
			<div class="prior-collections-container carousel-container container">
                <div class="row">
					<?php prior_collections_design_two(); ?>
				</div>
			</div>
        </section>
		<section class="features-s our-member-love-us white-bg" style="background-image: url(<?php the_field('background_image_s7_green'); ?>); background-repeat: <?php the_field('background_repeat_s7_green'); ?>; background-attachment: <?php the_field('background_attachment_s7_green'); ?>; background-position: <?php the_field('background_position_s7_green'); ?>; background-size: <?php the_field('background_size_s7_green'); ?>; background-color: <?php the_field('background_color_s7_green'); ?>;">
            <div class="container">
                <div class="row">
					<h2><?php the_field('title_s7_green'); ?></h2>
					<div class="hiw-text witpc-text-s">
						<p><?php the_field('subtitle_s7_green'); ?></p>
					</div>
				</div> <!-- row -->
			</div>
			<div class="testimonials-container carousel-container container">
                <div class="row">
					<?php testimonials_carousel_design_two(); ?>
				</div>
			</div>
        </section>
	</main>

<?php get_footer(); ?>
