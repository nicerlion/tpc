<?php 
/**
 * Template Name: About Us
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
		<section class="tpc-page-header" style="background-image: url(https://www.thepurseclub.com/wp-content/uploads/2017/11/background-cover.png), url(<?php the_field('background_image_ph'); ?>); background-repeat: <?php the_field('background_repeat_ph'); ?>; background-attachment: <?php the_field('background_attachment_ph'); ?>; background-position: <?php the_field('background_position_ph'); ?>; background-size: <?php the_field('background_size_ph'); ?>; background-color: <?php the_field('background_color_ph'); ?>;">
			<div class="container">
					<h1 class="title-page-header"><?php the_field('title_ph'); ?></h1>
					<h4 class="transform-normal"><?php the_field('subtitle_ph'); ?></h4>
			</div> <!-- container -->
		</section> <!-- tpc-page-header -->
		<section class="aboutus-page-container aboutus-page">
			<div class="container-fluid">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 aboutus-big-section">
							<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 aboutus-img-section">
								<div class="aboutus-woman-img">
									<?php 
									$image = get_field('image');
									if( !empty($image) ): ?>
										<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
									<?php endif; ?>
								</div>
							</div><!-- ends aboutus-img-section-->	
							<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 aboutus-info-section">
								<div class="aboutus-first-text">
									<h2><?php the_field('title_1'); ?></h2>
									<div class="underline-aboutus"></div>
										<?php the_field('content_text_1'); ?>
								</div><!--ends aboutus-first-text-->
								<hr class="line-about">
								<div class="aboutus-second-text">
									<h2><?php the_field('title_2'); ?></h2>
									<div class="underline-aboutus"></div>
										<?php the_field('content_text_2'); ?>
								</div><!--ends aboutus-second-text-->
								<?php 
								$button = get_field('button_text');
								if( !empty($button) ): ?>
									<div class="tpc-button-shadow aboutus-button">
										<a href="<?php the_field('link_button'); ?>"><?php the_field('button_text'); ?></a>
									</div>
								<?php endif; ?>
							</div><!-- ends aboutus-info-section--> 
						</div> <!-- ends aboutus-big-section-->	
					</div> <!-- row -->
				</div> <!-- container -->
			</div> <!-- container-fluid -->
		</section> <!-- tpc-page-container -->
		
	</main>

<?php get_footer(); ?>
