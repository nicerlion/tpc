<?php 
/**
 * Template Name: Pre-sell 1
 */
get_header(); ?>

<?php
	$field = get_field_object('the_link_is');
	if ($field['value'] == 'external') {
		$link = get_field('external_link_for_images');
		$target = 'target="_blank"';
	}else{
		$link = get_field('link_for_images');
		$target = '';
	}
?>
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
		<section class="presell-one-header" style=" background-color: <?php the_field('background_color_header'); ?>; ">
			<div class="container">
				<div class="row">
					<?php 
					$image = get_field('logo');
					if( !empty($image) ): ?>
						<a href="<?php echo $link; ?>" <?php echo $target; ?>><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="presell-one-logo"/></a>
					<?php endif; ?>
				</div>
			</div>
		</section> <!-- tpc-page-header -->
		<section class="presell-one-ads">
			<div class="container">
				<div class="row">
					<div class="presell-one-top-header-container">
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 remove-left-padding remove-right-padding">
							<a href="<?php echo $link; ?>" <?php echo $target; ?> class="presell-one-top-a">
								<div class="presell-one-top-header" style="background-image: url(<?php the_field('background_image'); ?>); background-repeat: no-repeat;">
									<h1><?php the_field('content_text_left'); ?></h1>
								</div>
							</a>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 remove-left-padding remove-right-padding">
							<div class="presell-one-top-right-ad">
								<a href="<?php echo $link; ?>" <?php echo $target; ?> class="presell-one-top-a"><h2><?php the_field('content_text_right'); ?></h2></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="presell-one-container">
			<div class="container">
				<div class="row">
					<div class="presell-one-content">
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<div class="presell-one-header-content">
								<?php 
								$publication_date = get_field('publication_date');
								if( !empty($publication_date) ): ?>
									<div class="presell-one-date">Posted on <a href="<?php echo $link; ?>" <?php echo $target; ?>><span><?php echo $publication_date; ?></span></a></div>
								<?php endif; ?>
								<h2><?php the_field('title'); ?></h2>
								<div class="presell-one-subtitle"><?php the_field('detail'); ?></div>
								<?php the_field('content_text_1'); ?>
							</div>
							<?php 
							$image = get_field('image_1');
							if( !empty($image) ): ?>
								<a href="<?php echo $link; ?>" <?php echo $target; ?>><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="presell-one-brands-img" /></a>
							<?php endif; ?>
							<div class="presell-one-copy">
								<div class="presell-one-copy-img">
									<?php 
									$image = get_field('image_2');
									if( !empty($image) ): ?>
										<a href="<?php echo $link; ?>" <?php echo $target; ?>><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="align-r" /></a>
									<?php endif; ?>
									<?php the_field('content_text_2'); ?>
								</div>
							</div>
							<div class="presell-one-copy">
								<?php 
								$content_text_3 = get_field('content_text_3');
								if( !empty($content_text_3) ): ?>
									<div class="bold-light-yellow">
										<?php the_field('content_text_3'); ?>
									</div>
								<?php endif; ?>
								<?php the_field('content_text_4'); ?>
								<?php 
								$video = get_field('video');
								if( !empty($video) ): ?>
									<div class="image-video-home-container">
										<div class="video-box"><?php the_field('video'); ?></div>
									</div>
								<?php endif; ?>
							</div>
							<div class="presell-one-copy">
								<h3><?php the_field('subtitle_1'); ?></h3>
								<?php the_field('content_text_5'); ?>
								<div class="presell-one-copy-img">
									<?php 
									$image = get_field('image_3');
									if( !empty($image) ): ?>
										<a href="<?php echo $link; ?>" <?php echo $target; ?>><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="align-l" /></a>
									<?php endif; ?>
									<?php the_field('content_text_6'); ?>
								</div>
							</div>
							<div class="presell-one-copy">
								<?php 
								$content_text_7 = get_field('content_text_7');
								$subtitle_2 = get_field('subtitle_2');
								if( !empty($content_text_7) or !empty($subtitle_2)): ?>
									<div class="bold-light-yellow">
										<h4><?php the_field('subtitle_2'); ?></h4>
										<?php the_field('content_text_7'); ?>
									</div>
								<?php endif; ?>
								<?php 
								$image = get_field('image_4');
								if( !empty($image) ): ?>
									<a href="<?php echo $link; ?>" <?php echo $target; ?>><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="presell-one-centered-img"></a>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<?php 
							$image = get_field('image_1_sidebar');
							if( !empty($image) ): ?>
								<a href="<?php echo $link; ?>" <?php echo $target; ?>><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="float-r margin-b-20"></a>
							<?php endif; ?>
							<?php 
							$image = get_field('image_2_sidebar');
							if( !empty($image) ): ?>
								<a href="<?php echo $link; ?>" <?php echo $target; ?>><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="float-r"></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	<div class="presell-one-footer" style=" background-color: <?php the_field('background_color_footer'); ?>; ">
		<div class="container">
			<div class="row">
				<?php the_field('content_text_footer'); ?>
				<?php 
				$image = get_field('logo_footer');
				if( !empty($image) ): ?>
					<a href="<?php echo $link; ?>" <?php echo $target; ?>><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"></a>
				<?php endif; ?>
			</div>
		</div>
	</div>


	<div class="modal fade" id="privacyModal" role="dialog">
		<div class="modal-dialog modal-lg">
		
			<!-- Modal content-->
			<div class="modal-content pt-content-box">
				<div class="pt-modal-box">
					<?php dynamic_sidebar( 'tpc-terms-of-user' ); ?>
					<div class="modal-footer pt-footer-box">
					</div>
				</div>      
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="termsModal" role="dialog">
		<div class="modal-dialog modal-lg">
	
		<!-- Modal content-->
			<div class="modal-content pt-content-box">
				<div class="pt-modal-box">
				<?php dynamic_sidebar( 'tpc-privacy-and-terms' ); ?>
					<div class="modal-footer pt-footer-box">
						
					</div>
				</div>      
			</div>
		</div>
	</div>
	</body>
</html>
