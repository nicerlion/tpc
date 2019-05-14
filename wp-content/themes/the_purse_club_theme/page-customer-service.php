<?php 
/**
 * Template Name: Customer Service Design
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
<div class="container woocommerce-account">
	<div class="row account-login">
		<?php do_action( 'woocommerce_account_navigation' ); ?>
	</div>
</div>
<div class="woocommerce-MyAccount-content">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 cs-contact-first">
					<div class="cs-contact-sec">
						<h2>CONTACT US!</h2>
						<div class="underline-customer"></div>
						<div class="cs-icons-box">
						<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/email-customer.png"><p>EMAIL US</p>
						<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/call-customer.png"><p>GIVE US A CALL</p>
						<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/chat-customer.png"><p>CHAT WITH US</p>
					</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 cs-contact-second">
					<div class="cs-contact-second-sec">
						<h3>LET'S GET</h3>
						<h2>SOCIAL!</h2>
						<div class="underline-customer-second"></div>
						<div class="cs-social-box">
							<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/customer-facebook-logo.png">
							<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/customer-instagram-logo.png">
							<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/customer-pinterest-logo.png">
							<img src="https://www.thepurseclub.com/wp-content/uploads/2017/11/customer-youtube-logo.png">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
		
	</main>

<?php get_footer(); ?>
