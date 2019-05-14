<?php 
/**
 * Template Name: The Perfect Purse Home Design 3
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
		<div class="tpc-top-ads tpp-top-ads">
			<div class="container">
				<div class="center-ad tpp-center-add"><span class="tpp-yellow-text">LOUIS VUITTON</span> PURSE GIVEAWAY EVERY WEEK. <a class="tpp-yellow-text" href="/take-style-quiz/">GET STARTED</a></div>
			</div>
		</div>
		<section class="tpp-ready tpp-video-container" style="background-color: #f0f0f0">
			<img class="tpp-video-img" src="https://www.thepurseclub.com/wp-content/uploads/2018/01/video.png" alt="video">
			<div class="tpp-video" style="line-height: 0;">
				<video id="tpp-video-id" muted="muted" autoplay="" loop="loop" playsinline="" style="line-height: 0" height="auto" width="100%" poster="https://www.thepurseclub.com/wp-content/uploads/2018/01/poster.png">
						<source src="https://www.thepurseclub.com/wp-content/uploads/videos/pc_intro_1.mp4format.mp4" type='video/mp4'>
						<source src="https://www.thepurseclub.com/wp-content/uploads/videos/pc_intro_1.webmhd.webm" type='video/webm'>
						<source src="https://www.thepurseclub.com/wp-content/uploads/videos/pc_Intro_1.oggtheora.ogv" type="video/ogg">
						<p class="vjs-no-js">
						To view this video please enable JavaScript, and consider upgrading to a web browser that
						<a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
						</p>
				</video>
			</div>
		</section>
		<section class="tpp-hero" style="background-image: url(https://www.thepurseclub.com/wp-content/uploads/2018/01/home-image-min.jpg); background-repeat: no-repeat; background-position: top center; background-size: cover; background-color: transparent">
			<h1><span>THE PERFECT PURSE</span>
			<img src="https://www.thepurseclub.com/wp-content/uploads/2018/01/home-text.png" alt="THE PERFECT PURSE">
			</h1>
			<h2>
				<span>Only $39.95 a month</span>
				<img src="https://www.thepurseclub.com/wp-content/uploads/2018/01/home-text-price.png" alt="Only $39.95 a month">
			</h2>
			<img class="tpp-members-receive" src="https://www.thepurseclub.com/wp-content/uploads/2018/01/members-receive.png" alt="Members receive a brand new purse worth $150+ delivered right to your front door">
			<div class="tpp-btn-home-s">
				<a href="https://www.thepurseclub.com/take-style-quiz/">GET STARTED</a>
			</div>
			<p>Already a member? <a class="tpp-yellow-text" href="https://www.thepurseclub.com/my-account">SIGN IN &gt;</a></p>
		</section>
		<section class="tpp-how-it-works" style="background-color: #f3f3f3">
            <div class="container">
                <div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h2 class="tpp-h2">How It Works </h2>
						<div class="tpp-hiw-text">
							<p>Saving Big with The Purse Club is easy - sign up in 3 simple steps.</p>
						</div>
						<div class="tpp-hiw-content clearfix">
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 tpp-hiw-copy">
								<img src="https://www.thepurseclub.com/wp-content/uploads/2018/01/how-blue-girl-1.png" alt="how blue girl">
								<h3>Create Your Style Profile</h3>
								<p>Get started by taking our style quiz to help our experts hand pick purses that you’ll love</p>
								<div class="tpp-right-arrow-vertical"></div>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 tpp-hiw-copy">
								<img src="https://www.thepurseclub.com/wp-content/uploads/2018/01/how-bags-1.png" alt="how bags">
								<h3>Stylist Hand Picks Purse</h3>
								<p>Whether you’re heading to work, school or a night-out, The Purse Club has the perfect purse for every occasion.</p>
								<div class="tpp-right-arrow-vertical"></div>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 tpp-hiw-copy">
								<img src="https://www.thepurseclub.com/wp-content/uploads/2018/01/how-gray-girl-2.png" alt="how gray girl">
								<h3>Receive Purses</h3>
								<p>Sit back and relax, your purse is on the way right to your front door.  Start building your dream purse collection today!</p>
							</div>
							<div class="right-arrow-vertical arrow-vertical-35"></div>
							<div class="right-arrow-vertical arrow-vertical-65"></div>
							<div class='cd-spac'></div>
						</div>	
					</div>
					<div class="tpp-btn-body-s">
						<a href="https://www.thepurseclub.com/take-style-quiz/">GET STARTED <span class="tpp-arrow-btn">&#9658;</span></a>
					</div>
				</div> <!-- row -->
            </div> <!-- container -->
		</section>
		<section class="tpp-what-you-receive" style="background-color: #fff">
			<div class="container">
				<div class="row">
					<h2 class="tpp-h2">What You Receive</h2>
					<div class="tpp-wyr-text">
						<p class="tpp-wyr-p">Every month you’ll receive a brand new purse worth up $150+ – and it’s your to keep! We partner directly with the hottest designers to bring you the latest styles at a fraction of the price.</p>
						<p>Take a look at some of the purses that our members have received recently.</p>
					</div>
					<div class="tpp-what-container clearfix">
						<?php what_you_receive_carousel(); ?>
					</div>
					<div class="tpp-btn-body-s">
						<a href="https://www.thepurseclub.com/take-style-quiz/">GET STARTED <span class="tpp-arrow-btn">&#9658;</span></a>
					</div>
				</div>
			</div>
		</section>
		<section class="tpp-hassel-free" style="background-image: url(https://www.thepurseclub.com/wp-content/uploads/2018/01/map-min-1-optim.jpg); background-repeat: no-repeat; background-position: center center; background-size: cover; background-color: transparent">
			<div class="container">
				<div class="row">
					<h2 class="tpp-map-h2">Hassle Free</h2>
					<div class="tpp-map-content clearfix">
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<h3>Free Shipping</h3>
							<p>It’s simple. We ship your purse every month to anywhere in the US for FREE.  No kidding.</p>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<h3>No Hassle Exchanges</h3>
							<p>Don’t love it? Exchange your purse for any reason.</p>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<h3>Cancel Anytime</h3>
							<p>Our Concierge Desk is open 24/7.  Call and cancel anytime without getting hassled.</p>
						</div>
					</div>
					<div class="tpp-btn-body-s">
						<a href="https://www.thepurseclub.com/take-style-quiz/">GET STARTED <span class="tpp-arrow-btn">&#9658;</span></a>
					</div>	
				</div>
			</div>
		</section>
		<section class="tpp-why-women-love">
			<div class="container">
				<div class="row">
					<h2 class="tpp-comment-h2">Why Women LOVE The Purse Club</h2>
					<div class="tpp-carousel-container clearfix">
						<ul>
							<li><img src="https://www.thepurseclub.com/wp-content/uploads/2018/01/comments-1-optim.jpg" alt="Comment1"></li>
							<li><img src="https://www.thepurseclub.com/wp-content/uploads/2018/01/comments-two-optim.jpg" alt="comments2"></li>
						</ul>	
					</div>
					<div class="tpp-btn-body-s">
						<a href="https://www.thepurseclub.com/take-style-quiz/">GET STARTED <span class="tpp-arrow-btn">&#9658;</span></a>
					</div>
				</div>
			</div>
		</section>
		<section class="tpp-weekly">
			<div class="container">
				<div class="row">
					<h2 class="tpp-week-h2">WEEKLY LOUIS VUITTON GIVEAWAY!</h2>
					<p>And just when you thought it couldn’t get any better, all of our members are entered into a weekly draw for a REAL</p>
					<img src="https://www.thepurseclub.com/wp-content/uploads/2018/01/vuitton-sec-text.png">
					<div class="tpp-btn-body-s">
						<a href="https://www.thepurseclub.com/take-style-quiz/">GET STARTED <span class="tpp-arrow-btn">&#9658;</span></a>
					</div>
				</div>
			</div>
		</section>
	</main>
	<script data-obct type=""text/javascript"">
  		/ DO NOT MODIFY THIS CODE/
		!function(_window, _document) {
			var OB_ADV_ID='00c11d980fa1f019092650c9cbcc8e3f61';
			if (_window.obApi) {var toArray = function(object) {return Object.prototype.toString.call(object) === '[object Array]' ? object : [object];};_window.obApi.marketerId = toArray(_window.obApi.marketerId).concat(toArray(OB_ADV_ID));return;}
			var api = _window.obApi = function() {api.dispatch ? api.dispatch.apply(api, arguments) : api.queue.push(arguments);};api.version = '1.1';api.loaded = true;api.marketerId = OB_ADV_ID;api.queue = [];var tag = _document.createElement('script');tag.async = true;tag.src = '//amplify.outbrain.com/cp/obtp.js';tag.type = 'text/javascript';var script = _document.getElementsByTagName('script')[0];script.parentNode.insertBefore(tag, script);}(window, document);
		obApi('track', 'PAGE_VIEW');
	</script>
<?php get_footer(); ?>
