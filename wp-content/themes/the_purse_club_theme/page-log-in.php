<?php 
/**
 * Template Name: Log In Design
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
		
		<section class="loginp-page-container loginp-page">
			<div class="container-fluid loginp-main-container">
				<div class="loginp-bar-contain">
				<div class="loginp-subscribe-bar">
				<p>DON'T HAVE AN ACCOUNT?
					<a href="">SUBSCRIBE HERE!</a>
				</p>
				</div
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 loginp-big-section">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 loginp-info-section">
								<div class="loginp-logo-box">
									<img src="https://www.thepurseclub.com/wp-content/uploads/2017/10/the-purse-club-logo-1.png">
								</div>	
								<h3>ACCOUNT LOGIN</h3>
								<div class="loginp-box">
									<form action="">
										<div class="email-container">
											<input type="email" placeholder="EMAIL ADDRESS">
										</div>
										<div class="password-container">
											<input type="password" placeholder="PASSWORD">
										</div>
										<div class="logp-submit-container">
											<button type="submit">LOG IN</button>
										</div>
									</form>
										<h5>FORGOT PASSWORD</h5>
										<a href="#">RESET HERE</a>
								</div>	
							</div><!-- ends login-info-section--> 

						</div> <!-- ends login-big-section-->	
					</div> <!-- row -->
				</div> <!-- container -->
				</div>
			</div> <!-- container-fluid -->
		</section> <!-- faq-page-container -->
		
	</main>

<?php get_footer(); ?>
