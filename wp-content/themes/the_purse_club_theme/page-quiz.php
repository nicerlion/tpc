<?php 
/**
 * Template Name: Quiz Design
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
		<section class="tpc-page-header"  style="background-image: url(https://www.thepurseclub.com/wp-content/uploads/2017/11/background-cover.png), url(<?php the_field('background_image_ph'); ?>); background-repeat: <?php the_field('background_repeat_ph'); ?>; background-attachment: <?php the_field('background_attachment_ph'); ?>; background-position: <?php the_field('background_position_ph'); ?>; background-size: <?php the_field('background_size_ph'); ?>; background-color: <?php the_field('background_color_ph'); ?>;">
			<div class="container">
				<div class="row">
					<h1><?php the_field('title_ph'); ?></h1>
					<?php 
					$subtitsubtitle = get_field('subtitle_ph');
					if( !empty($subtitsubtitle) ): ?>
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
		<section class="tpc-page-container style-quiz">
			<div class="container">
				<div class="row">
					<form id="theQuiz" action="<?php echo get_site_url()?>/buy-subscription/#/register" method="POST">
						<div id="size-selection" class="size-selection-section quiz-selection-container">
							<h5>STEP 1 OF 3</h5>
							<?php 
							$title = get_field('title_s1');
							if( !empty($title) ): ?>
								<h3><?php the_field('title_s1'); ?></h3>
							<?php endif; ?>
							<?php 
							$subtitle = get_field('subtitle_s1');
							if( !empty($subtitle) ): ?>
								<p class="section-desc"><?php the_field('subtitle_s1'); ?>
									<?php 
									$text = get_field('text_s1');
									if( !empty($text) ): ?>
											<br/><span><?php the_field('text_s1'); ?></span>
									<?php endif; ?>
								</p>
							<?php endif; ?>
							<div class="size-selection-container">
								<fieldset id="sizeSelection">
									<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 size-selection" id="tpc-small">
										<div class="tpc-purse-selection">
											<label for="s-small">
											<input type="checkbox" id="s-small" name="ss[]" size="s"/>
												<?php 
												$image = get_field('image_1');
												if( !empty($image) ): ?>
													<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
												<?php endif; ?>
												<span>Extra-Small</span>
											</label>
										</div>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 size-selection" id="tpc-medium">
										<div class="tpc-purse-selection">
											<input type="checkbox" id="s-medium" name="ss[]" value="medium" size="m"/>
											<label for="s-medium">
												<?php 
												$image = get_field('image_2');
												if( !empty($image) ): ?>
													<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
												<?php endif; ?>
												<span>Small</span>
											</label>
										</div>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 size-selection" id="tpc-large">
										<div class="tpc-purse-selection">
											<input type="checkbox" id="s-large" name="ss[]" value="large" size="l"/>
											<label for="s-large">
												<?php 
												$image = get_field('image_3');
												if( !empty($image) ): ?>
													<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
												<?php endif; ?>
												<span>Medium</span>
											</label>
										</div>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 size-selection" id="tpc-xlarge">
										<div class="tpc-purse-selection">
											<input type="checkbox" id="s-xlarge" name="ss[]" value="xlarge" size="x"/>
											<label for="s-xlarge">
												<?php 
												$image = get_field('image_4');
												if( !empty($image) ): ?>
													<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
												<?php endif; ?>
												<span>Large</span>
											</label>
										</div>
									</div>
								</fieldset>
							</div> <!-- size-selection-container -->
							<div class="quiz-next-button" id="QuizNextSizeButton">
								<a href="#" id="quizNextSizeButton">NEXT STEP</a>
							</div>
						</div> <!-- size-selection-section -->
						<div id="typeSelection" class="quiz-selection-container type-selection-section display-none">
							<h5>STEP 2 OF 3</h5>
							<?php 
							$title = get_field('title_s2');
							if( !empty($title) ): ?>
								<h3><?php the_field('title_s2'); ?></h3>
							<?php endif; ?>
							<?php 
							$subtitle = get_field('subtitle_s2');
							if( !empty($subtitle) ): ?>
								<p class="section-desc"><?php the_field('subtitle_s2'); ?>
									<?php 
									$text = get_field('text_s2');
									if( !empty($text) ): ?>
											<br/><span><?php the_field('text_s2'); ?></span>
									<?php endif; ?>
								</p>
							<?php endif; ?>
							<div class="type-selection-container">
								<div class="col-xs-6 col-sm-6 col-md-5ths col-lg-5ths type-container">
									<div class="tpc-purse-type">
										<input type="checkbox" id="t-crossbody" value="crossbody" ptype="crossbody"/>
										<label for="t-crossbody">											
											<?php 
											$image = get_field('image_5');
											if( !empty($image) ): ?>
												<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
											<?php endif; ?>
											<span>CROSSBODY</span>
										</label>
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-5ths col-lg-5ths type-container">
									<div class="tpc-purse-type">
										<input type="checkbox" id="t-tote" value="tote" ptype="tote"/>
										<label for="t-tote">											
											<?php 
											$image = get_field('image_6');
											if( !empty($image) ): ?>
												<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
											<?php endif; ?>
											<span>TOTE</span>
										</label>
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-5ths col-lg-5ths type-container">
									<div class="tpc-purse-type">
										<input type="checkbox" id="t-clutche" value="clutch" ptype="clutch"/>
										<label for="t-clutche">											
											<?php 
											$image = get_field('image_7');
											if( !empty($image) ): ?>
												<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
											<?php endif; ?>
											<span>CLUTCH</span>
										</label>
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-5ths col-lg-5ths type-container">
									<div class="tpc-purse-type">
										<input type="checkbox" id="t-backpack" value="backpack" ptype="backpack"/>
										<label for="t-backpack">											
											<?php 
											$image = get_field('image_8');
											if( !empty($image) ): ?>
												<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
											<?php endif; ?>
											<span>BACKPACK</span>
										</label>
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-5ths col-lg-5ths type-container">
									<div class="tpc-purse-type">
										<input type="checkbox" id="t-hobo" value="hobo" ptype="hobo"/>
										<label for="t-hobo">											
											<?php 
											$image = get_field('image_9');
											if( !empty($image) ): ?>
												<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
											<?php endif; ?>
											<span>HOBO</span>
										</label>
									</div>
								</div>
							</div>
							<div class="quiz-next-button" id="QuizNextTypeButton">
								<a href"#" id="quizNextTypeButton">NEXT STEP</a>
							</div>
						</div> <!-- type-selection-section -->
						<div id="colorSelection" class="quiz-selection-container color-selection-section display-none">
							<h5>STEP 3 OF 3</h5>
							<?php 
							$title = get_field('title_s3');
							if( !empty($title) ): ?>
								<h3><?php the_field('title_s3'); ?></h3>
							<?php endif; ?>
							<?php 
							$subtitle = get_field('subtitle_s3');
							if( !empty($subtitle) ): ?>
								<p class="section-desc"><?php the_field('subtitle_s3'); ?>
									<?php 
									$text = get_field('text_s3');
									if( !empty($text) ): ?>
											<br/><span><?php the_field('text_s3'); ?></span>
									<?php endif; ?>
								</p>
							<?php endif; ?>
							<div class="color-selection-container">
								<div class="col-xs-4 col-sm-4 col-md-6ths col-lg-6ths color-box">
									<div class="tpc-color-selection">
										<a href="#">
											<input type="checkbox" id="brown" name="brown-bucket" color="brown-bucket"/>
											<label for="brown">
												<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/transparent-bg.gif" alt=""  style="background-color: #653827;">
												<span class="quiz-color-text">BROWN</span>
											</label>
										</a>
									</div>
								</div> <!-- color-selection-container -->
								<div class="col-xs-4 col-sm-4 col-md-6ths col-lg-6ths color-box">
									<div class="tpc-color-selection">
										<a href="#">
											<input type="checkbox" id="green" name="multi" color="multi"/>
											<label for="green">
												<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/transparent-bg.gif" alt=""  style="background-color: #46b459;">
												<span class="quiz-color-text">GREEN</span>
											</label>
										</a>
									</div>
								</div> <!-- color-selection-container -->
								<div class="col-xs-4 col-sm-4 col-md-6ths col-lg-6ths color-box">
									<div class="tpc-color-selection">
										<a href="#">
											<input type="checkbox" id="red" name="red" color="red"/>
											<label for="red">
												<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/transparent-bg.gif" alt=""  style="background-color: #d80000;">
												<span class="quiz-color-text">RED</span>
											</label>
										</a>
									</div>
								</div> <!-- color-selection-container -->
								<div class="col-xs-4 col-sm-4 col-md-6ths col-lg-6ths color-box">
									<div class="tpc-color-selection">
										<a href="#">
											<input type="checkbox" id="yellow" name="multi" color="multi"/>
											<label for="yellow">
												<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/transparent-bg.gif" alt="" style="background-color: #FFF61E;">
												<span class="quiz-color-text">YELLOW</span>
											</label>
										</a>
									</div>
								</div> <!-- color-selection-container -->
								<div class="col-xs-4 col-sm-4 col-md-6ths col-lg-6ths color-box">
									<div class="tpc-color-selection">
										<a href="#">
											<input type="checkbox" id="gray" name="gray" color="gray"/>
											<label for="gray">
												<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/transparent-bg.gif" alt=""  style="background-color: #aaaaaa;">
												<span class="quiz-color-text">GREY</span>
											</label>
										</a>
									</div>
								</div> <!-- color-selection-container -->
								<div class="col-xs-4 col-sm-4 col-md-6ths col-lg-6ths color-box">
									<div class="tpc-color-selection">
										<a href="#">
											<input type="checkbox" id="pink" name="multi" color="multi"/>
											<label for="pink">
												<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/transparent-bg.gif" alt="" style="background-color: #ffb7b7;">
												<span class="quiz-color-text">PINK</span>
											</label>
										</a>
									</div>
								</div> <!-- color-selection-container -->
								<div class="col-xs-4 col-sm-4 col-md-6ths col-lg-6ths color-box">
									<div class="tpc-color-selection">
										<a href="#">
											<input type="checkbox" id="taupe" name="brown-bucket" color="brown-bucket"/>
											<label for="taupe">
												<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/transparent-bg.gif" alt="" style="background-color: #bc987e;">
												<span class="quiz-color-text">BEIGE</span>
											</label>
										</a>
									</div>
								</div> <!-- color-selection-container -->
								<div class="col-xs-4 col-sm-4 col-md-6ths col-lg-6ths color-box">
									<div class="tpc-color-selection">
										<a href="#">
											<input type="checkbox" id="black" name="black" color="black"/>
											<label for="black">
												<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/transparent-bg.gif" alt="" style="background-color: #000000;">
												<span class="quiz-color-text">BLACK</span>
											</label>
										</a>
									</div>
								</div> <!-- color-selection-container -->
								<div class="col-xs-4 col-sm-4 col-md-6ths col-lg-6ths color-box">
									<div class="tpc-color-selection">
										<a href="#">
											<input type="checkbox" id="orange" name="multi" color="multi"/>
											<label for="orange">
												<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/transparent-bg.gif" alt=""  style="background-color: #FFA500;">
												<span class="quiz-color-text">ORANGE</span>
											</label>
										</a>
									</div>
								</div> <!-- color-selection-container -->
								<div class="col-xs-4 col-sm-4 col-md-6ths col-lg-6ths color-box">
									<div class="tpc-color-selection">
										<a href="#">
											<input type="checkbox" id="blue" name="multi" color="multi"/>
											<label for="blue">
												<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/transparent-bg.gif" alt="" style="background-color: #0047AB;">
												<span class="quiz-color-text">BLUE</span>
											</label>
										</a>
									</div>
								</div> <!-- color-selection-container -->
								<div class="col-xs-4 col-sm-4 col-md-6ths col-lg-6ths color-box">
									<div class="tpc-color-selection">
										<a href="#">
											<input type="checkbox" id="beige" name="beige" color="beige"/>
											<label for="beige">
												<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/transparent-bg.gif" alt="" style="background-color: #f5ecdc;">
												<span class="quiz-color-text">TAN</span>
											</label>
										</a>
									</div>
								</div> <!-- color-selection-container -->
								<div class="col-xs-4 col-sm-4 col-md-6ths col-lg-6ths color-box">
									<div class="tpc-color-selection">
										<a href="#">
											<input type="checkbox" id="white" name="white" color="white"/>
											<label for="white">
												<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/transparent-bg.gif" alt="" style="background-color: #ffffff;">
												<span class="quiz-color-text">WHITE</span>
											</label>
										</a>
									</div>
								</div> <!-- color-selection-container -->
							</div>
							<div class="quiz-error-container">
								<div class="quizError display-none">
									<button type="button" class="close x-button-error" data-dismiss="modal">×</button>
									<div class="mini-quiz-error">
										<p class="error-size display-none">Please select a <strong>size.</strong></p>
										<p class="error-type display-none">Please select a <strong>type.</strong></p>
										<p class="error-color display-none">Please select a <strong>color.</strong></p>
									</div>
								</div>
							</div>
							
							<div class="continue tpc-button-shadow">
								<button type="submit" value="CONTINUE" name="action" id="sq-submit">CONTINUE</button>
							</div>
						</div> <!-- color-selection-section -->
						
						
					</form>
				</div> <!-- row -->
			</div> <!-- container -->
		</section> <!-- tpc-page-container -->
	</main>

<?php get_footer(); ?>
