<?php 
/**
 * Template Name: Selec Plan Design
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
	</main>	
	<section class="psypnewd-page-container psypnewd-page-select-your-plan">
		<section class="psypnewd-page-header" style="background-image: url(https://www.thepurseclub.com/wp-content/uploads/2017/11/background-cover.png), url(http://localhost:8888/the-purse-club/wp-content/uploads/2017/10/follow_us_2.jpg); background-repeat: ; background-attachment: ; background-position: ; background-size: ; background-color: ;">
				<div class="container">
						<h1>SELECT YOUR PLAN</h1>
						<div class="psypnewd-header-p">
						<p>Hi Krystal, Heres your account overview</p>
					</div> <!-- row -->
				</div> <!-- container -->
		</section>
		<div class="container-fluid">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-sm-12 col-md-12 col-lg-12 psypnewd-first-item-container">
						<div class="">
							<p class="psypnewd-first-text"><span class="psypnewd-wait-text">WAIT!  </span><span class="psypnewd-special-text"><a href="#">Special one time only offer for new VIP Members.</a></span><span class="psypnewd-ask-text"> Do you want to save even more?</span></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid psypnewd-big-container" style="background-image: url(https://www.thepurseclub.com/wp-content/uploads/2017/12/select-background.jpg); background-repeat: ; background-attachment: ; background-position: ; background-size: ; background-color: ;">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-sm-12 col-md-12 col-lg-12 psypnewd-item-container">
						<img class="psypnewd-badge" src="https://www.thepurseclub.com/wp-content/uploads/2017/12/Badge-select.png">
						<div class="psypnewd-item-select psypnewd-first-item-select">
							<div class="psypnewd-mini-item">
							<div class="psypnewd-month-title">
								<h2>3 MONTH PREPAY</h2>
							</div>
							
							<div class="inside-box-psypnewd">
								<p class="pice-detail"></p>
								<img src="https://www.thepurseclub.com/wp-content/uploads/2017/12/purses3.png">
							</div>
							<div class="psypnewd-text-box">
								<p><span>&#10003;</span> Save an extra 5% off of our already discounted prices</p>
								<p>&#10003; Pick your favorite styles for the season</p>
							</div>
							<div class="psypnewd-value">
								<span>$114.00</span>
							</div>

							<div class="psypnewd-black-button">
								<a href="<?php echo get_site_url() ?>/billing-information/?add-to-cart=271">SELECT PLAN</a>
							</div>
						</div>
						</div>
						<div class="psypnewd-item-select">
							<div class="psypnewd-mini-item">
							<div class="psypnewd-month-title">
								<h2>6 MONTH PREPAY</h2>
							</div>
							
							<div class="inside-box-psypnewd">
								<p class="pice-detail"></p>
								<img src="https://www.thepurseclub.com/wp-content/uploads/2017/12/purses6.png">
							</div>
							<div class="psypnewd-text-box">
								<p><span>&#10003;</span> Save an extra 10% off of our already discounted prices</p>
								<p>&#10003; Pick your favorite styles for the season</p>
							</div>
							<div class="psypnewd-value">
								<span>$216.00</span>
							</div>

							<div class="psypnewd-black-button">
								<a href="<?php echo get_site_url() ?>/billing-information/?add-to-cart=271">SELECT PLAN</a>
							</div>
						</div>
						</div>
						<div class="psypnewd-item-select">
							<div class="psypnewd-mini-item">
								<div class="psypnewd-month-title">
									<h2>12 MONTH PREPAY</h2>
								</div>
								<div class="inside-box-psypnewd">
									<p class="pice-detail"></p>
									<img src="https://www.thepurseclub.com/wp-content/uploads/2017/12/purses12.png">
								</div>
								<div class="psypnewd-text-box">
									<p><span>&#10003;</span> That's only $35 per purse!</p>
									<p>&#10003; Don't take the chance that we'll sell out on your trendiest styles!</p>
								</div>
								<div class="psypnewd-value">
									<span>$420.00</span>
								</div>
								<div class="psypnewd-black-button">
									<a href="<?php echo get_site_url() ?>/billing-information/?add-to-cart=271">SELECT PLAN</a>
								</div>
							</div>
						</div>
					</div>	
				</div> <!-- row -->
			</div> <!-- container -->
		</div> <!-- container-fluid -->
		<div class="container-fluid">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-sm-12 col-md-12 col-lg-12 psypnewd-first-item-container">
						<div class="">
							<p class="psypnewd-last-text"><a href="#">No thanks. I'll keep it monthly</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		</section>
		<div class="presell-three-footer"> 
			<div class="container"> 
				<div class="row"> 
					<p>Terms of Use - Privacy Policy - Rules</p>
					<p>This is an advertorial and not a news article, blog or consumer protection update</p>
					<p>Copyright 2017 - The Purse Club- All rights reserved </p>
					<a href="https://www.thepurseclub.com/index/"><img src="https://www.thepurseclub.com/wp-content/uploads/2017/12/presell-one-the-purse-club.png" alt="The Purse Club"></a> 
				</div> 
			</div> 
		</div> 
	</body>
</html>
