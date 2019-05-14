<?php 
/**
 * Template Name: Faq Design
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
		<div>
		<section class="faq-page-header" style="background-image: url(https://www.thepurseclub.com/wp-content/uploads/2017/11/background-cover.png), url(<?php the_field('background_image_ph'); ?>); background-repeat: <?php the_field('background_repeat_ph'); ?>; background-attachment: <?php the_field('background_attachment_ph'); ?>; background-position: <?php the_field('background_position_ph'); ?>; background-size: <?php the_field('background_size_ph'); ?>; background-color: <?php the_field('background_color_ph'); ?>;">
			<div class="container">
					<h1><?php the_field('title_ph'); ?></h1>
					<div class="faq-header-p">
						<p><?php the_field('subtitle_ph'); ?></p>
				</div> <!-- row -->
			</div> <!-- container -->
		</section> <!-- faq-page-header -->
		<section class="faq-page-container faq-page">
			<div class="container-fluid">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 faq-big-section">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 faq-info-section">
								<div class="row faq-first-text">
									<h2><?php the_field('title'); ?></h2>
									<div class="underline-aboutus"></div>
										<?php the_field('content_text'); ?>
									</div><!--ends aboutus-first-text-->

									<div class="row faq-accordion-footer ">
										<div class="accordion col-xs-12 col-sm col-md col-lg">
											<?php 
												$args = array(
													'post_type' => 'tpc_faq_accordion',
													'posts_per_page' => -1,
													'order'   => 'DESC'
												);
												$cont = 1;
												$attractions  = new WP_Query($args); 
												while($attractions->have_posts()) : $attractions->the_post(); 
													?>
													<div class="accordion-section"><a class="accordion-section-title accordion-faq-text" href="#accordion-footer<?php echo $cont; ?>"><?php the_title(); ?></a>
														<div id="accordion-footer<?php echo $cont; ?>" class="accordion-section-content" style="display: none;">
															<?php the_field('content_text'); ?>
														</div><!-- ends accordion-footer -->
													</div><!-- ends accordion-section -->
													<?php
													$cont = $cont + 1;
												endwhile; 
											
												// Restore original post data.
												wp_reset_postdata();
											?>
										</div><!-- ends accordion -->					
									</div><!-- ends row faq-accordion-footer -->
									<div class="faq-go-button">
									<a href="<?php the_field('link_button'); ?>"><?php the_field('button_text'); ?></a>	
								</div>	
							</div><!-- ends aboutus-info-section--> 
						</div>

						</div> <!-- ends aboutus-big-section-->	
					</div> <!-- row -->
				</div> <!-- container -->
			</div> <!-- container-fluid -->
		</section> <!-- faq-page-container -->
		
	</main>

<?php get_footer(); ?>
