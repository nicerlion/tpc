	<?php 
	/**
	 * Template Name: shipping and billing
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

			<section class="sab-header">  
				<div class="sab-top"> 
					<div class="container"> 
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<a href="<?php echo get_site_url() ?>/index/"><img src="https://www.thepurseclub.com/wp-content/uploads/2017/12/CNBO-logo.png"></a>
								<div class="sab-button">
									<a href="#">STEP 2 OF 3</a>
								</div>
								<h1>SHIPPING AND BILLING</h1>
								<p>Enter address information</p>
							</div>
						</div> 
					</div> 
				</div> 
			</section> <!-- tpc-page-header --> 
				<section class="sab-container"> 
					<div class="container"> 
						<div class="row"> 
							<div class="sab-content">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
									<div class="sab-big-container">
										<div class="sab-container-box clearfix">
											<div class="sab-header-content clearfix">
												<span class="sab-shipping-address">Shipping Address</span>
												<span>*Required fields</span> 
											</div>
										</div>
										<div class="sab-box-data clearfix">
											<form class="sab-data">
												<div class="sab-info-data">
													<label>*First Name:</label>
													<div class="sab-input">
														<input name="firstname" type="text" placeholder="First Name">
													</div>	
												</div>
												<div class="sab-info-data">
													<label>*Last Name:</label>
													<div class="sab-input">
														<input name="lastname" type="text" placeholder="Last Name">
													</div>
												</div>
												<div class="sab-info-data">
													<label>*Address</label>
													<div class="sab-input">
														<input name="address" type="text" placeholder="Address">
													</div>
												</div>
												<div class="sab-info-data">
													<label>Address 2 (optional)</label>
													<div class="sab-input">
														<input name="address2" type="text" placeholder="Enter A Location">
													</div>
												</div>
												<div class="sab-info-data">
													<label>*City</label>
													<div class="sab-input">
														<input name="city" type="text" placeholder="City">
													</div>	
												</div>
												<div class="sab-info-data">
													<label>*State</label>
													<div class="sab-input">
														<select>
																<option value="California">California</option>
																<option value="Florida">Florida</option>	
														</select>	
														</div>	
												</div>
												<div class="sab-info-data">
													<label>*Zip Code</label>
													<div class="sab-input">
														<input name="zipcode" type="text" placeholder="Zip Code">
													</div>	
												</div>
												<div class="sab-info-data">
													<label>*Phone Number</label>
													<div class="sab-input">
														<input name="phonenumber" type="text" placeholder="Phone Number">
													</div>	
												</div>
												<div class="sab-info-data">
													<label>*Email</label>
													<div class="sab-input">
														<input name="emial" type="email" placeholder="Email">
													</div>
												</div>
											</form>
										</div>
										<div class="sab-header-content clearfix">
											<span class="sab-shipping-address">Billing Information</span>
										</div>
										<div class="sab-shipping-sec">
											<form class="sab-shipping-form">
												<div class="sab-shipping-data">
												  	<input type="radio" name="gender" value="male"><label> Same as Shipping Address</label>
												</div>
											    <div class="sab-shipping-data">
											  		<input type="radio" name="gender" value="female"><label>Different from Shipping Address</label>
											    </div>
											</form>
											<div class="sab-checkout-button">
												<a href="#">CONTINUE CHECKOUT&nbsp;>></a>
											</div>
										</div>
									</div>
								</div>
							</div> 
						</div> 
					</div> 
			</section>
		</main> 
			<div class="sab-footer"> 
				<div class="container"> 
					<div class="row"> 
						<div class="sab-social-footer">
							<a href="<?php echo get_site_url() ?>/index/"><img src="https://www.thepurseclub.com/wp-content/uploads/2017/12/cnbo-footer-logo.png"></a>
							<a href="<?php echo get_site_url() ?>/index/"><img src="https://www.thepurseclub.com/wp-content/uploads/2017/12/presell-six-social-footer.png" class="sab-social-footer-img"></a>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 sab-footer-above-container">
							<h3>INFO</h3>
							<ul>
								<li>Contact Us</li>
								<li>Shipping & Delivery</li>
								<li>Privacy Policy</li>
								<li>Terms & Conditions</li>
							</ul>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 sab-footer-above-container">
							<h3>LUXY PURSE</h3>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 sab-footer-above-container">
							<h3>PAYMENT METHODS</h3>
							<p>You may safely place your order using one of the following payment methods</p>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 sab-footer-above-container">
							<h3>FREE SHIPPING</h3>
							<p>Shipping for your order is always free and will arrive within 3-5 business days.</p>
						</div>
					</div> 
				</div> 
			</div> 
		</div> 
	</body>
</html>