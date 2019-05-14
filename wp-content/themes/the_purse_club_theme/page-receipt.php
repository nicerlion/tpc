<?php 
/**
 * Template Name: Receipt Design
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
		<section class="receipt-page-header" style="background: url('https://www.thepurseclub.com/wp-content/uploads/2017/10/quiz-header-image.jpg') center right no-repeat; background-size: cover;">
			<div class="container">
				<div class="row">
					<h1>WELCOME TO THE PURSE CLUB</h1>
					<div class="receipt-header-p">
						<p>Hi Krystal, Heres your account overview</p>
					</div>
				</div> <!-- row -->
			</div> <!-- container -->
		</section> <!-- receipt-page-header -->
		<section class="receipt-page-container receipt-page">
			<div class="container-fluid">
				<div class="container">
					<div class="row">
						<div class="receipt-big-box">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 receipt-big-section">	
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 receipt-info-section">
									<div class="receipt-first-text">
										<h2>SHIPPING DETAILS</h2>
										<div class="receipt-button">
											<a href="">EDIT</a>	
										</div>	
										<div class="underline-receipt"></div>
											<p>Kystel Bravo</p>
											<p>Manhattan, 099, a-23</p>
											<p>New York, NY, 9999</p>
											<p>US</p>
										</div><!--ends receipt-first-text-->
									</div><!-- ends receipt-info-section--> 
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 receipt-info-section">
									<div class="receipt-second-text">
										<h2>PAYMENT DETAILS</h2>
										<div class="receipt-button">
											<a href="">EDIT</a>	
										</div>
										<div class="underline-receipt"></div>
											<p>Card Holder Name: Krystal Bravo</p>
											<p>Card Number: xxxxxxxxxxxx</p>
											<p>Expiration Date: 10/25/2018</p>
										</div><!--ends receipt-second-text-->
								</div><!-- ends receipt-info-section--> 
							</div> <!-- ends receipt-big-section-->	
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 receipt-big-section">	
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 receipt-info-section">
										<div class="receipt-third-text">	
											<h2><strong>MEMBERSHIP TYPE</strong></h2>
											<div class="receipt-button">
											<a href="">EDIT</a>	
											</div>
											<div class="underline-receipt"></div>
											<div class="receipt-inside-third">
												<h3>SILVER</h3>
												<p class="receipt-black-sect">LOREM IPSUM DOLOREM</p>
												<h4>$ <sub>275</sub> / MONTH</h4>
												<p>Purses worth $500 - &1,000</p>
											</div>
											<h5> > SEE PLAN FOR DETAILS < </h5>
										</div><!--ends receipt-thrid-text-->
								</div><!-- ends receipt-info-section--> 
							</div><!-- ends receipt-big-section -->
						</div> <!-- ends receipt-big-box -->
						<div class="receipt-go-button">
									<a href="">GO BACK TO HOME</a>	
								</div>
					</div> <!-- row -->
				</div> <!-- container -->
			</div> <!-- container-fluid -->
		</section> <!-- receipt-page-container -->
		
	</main>

<?php get_footer(); ?>
