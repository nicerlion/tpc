<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
		<link href="https://fonts.googleapis.com/css?family=Karla:400,400i,700,700i" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato:400,700,900" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Archivo+Black" rel="stylesheet">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<script>
		var wpApiSettings = {"root": "<?php echo esc_url_raw( rest_url() )?>", "nonce": "<?php echo wp_create_nonce( 'wp_rest' )?>"}
		var wpReactSettings = {
			<?php
				global $woocommerce;
				$user = wp_get_current_user();
				$customer = new WC_Customer($user->ID);
				$is_member = wc_memberships_is_user_member($customer->get_id());
				if ($user->ID) {
					$customer_orders = get_posts( array(
						'numberposts' => -1,
						'meta_key'    => '_customer_user',
						'meta_value'  => $user->ID,
						'post_type'   => wc_get_order_types(),
						'post_status' => array_keys( wc_get_order_statuses() ),
					) );
				} else {
					$customer_orders = array();
				}
			?>
			"userEmail": "<?php echo $user->user_email; ?>",
			"userID": <?php echo $user->ID; ?>,
			"billing": <?php echo json_encode($customer->get_billing()); ?>,
			"shipping": <?php echo json_encode($customer->get_shipping()); ?>,
			"created": "<?php echo (new DateTime($user->user_registered))->getTimeStamp(); ?>",
			"orders": <?php echo count($customer_orders); ?>,
			"isMember": <?php echo $is_member ? 1: 0; ?>
		}
		</script>
		<?php
		// wp_localize_script( 'wp-api', 'wpApiSettings', array( 'root' => esc_url_raw( rest_url() ), 'nonce' => wp_create_nonce( 'wp_rest' ) ) );
		wp_enqueue_script('wp-api');
		?>
		<?php
			$url = $_SERVER["REQUEST_URI"];
			$string_value = '/order-received';
			$strpos = strpos($url, $string_value);
		?>
		<?php wp_head(); ?>
		<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
		</script>
		<?php if ( !is_page_template('react.php')) {?>
			<!-- Facebook Pixel Code - All Pages -->
			<script>
				!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
				n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
				n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
				t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
				document,'script','//connect.facebook.net/en_US/fbevents.js');

				fbq('init', '559415867727666');
				fbq('track', 'PageView');
			</script>
			<noscript><img height='1' width='1' style='display:none' src='https://www.facebook.com/tr?id=559415867727666&ev=PageView&noscript=1' /></noscript>
			<!-- End Facebook Pixel Code -->

			<!-- Facebook Pixel Code -->
			<script>
				!function(f,b,e,v,n,t,s)
				{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
				n.callMethod.apply(n,arguments):n.queue.push(arguments)};
				if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
				n.queue=[];t=b.createElement(e);t.async=!0;
				t.src=v;s=b.getElementsByTagName(e)[0];
				s.parentNode.insertBefore(t,s)}(window,document,'script',
				'https://connect.facebook.net/en_US/fbevents.js');
				
				fbq('init', '333244033862295'); 
				fbq('track', 'PageView');
			</script>
			<noscript>
				<img height=""1"" width=""1"" 
				src=""https://www.facebook.com/tr?id=333244033862295&ev=PageView
				&noscript=1""/>
			</noscript>
			<!-- End Facebook Pixel Code -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-MWL42CX');</script>
			<script data-obct type="text/javascript">
				!function(_window, _document) {
					var OB_ADV_ID='00c11d980fa1f019092650c9cbcc8e3f61';
					if (_window.obApi) {var toArray = function(object) {return Object.prototype.toString.call(object) === '[object Array]' ? object : [object];};_window.obApi.marketerId = toArray(_window.obApi.marketerId).concat(toArray(OB_ADV_ID));return;}
					var api = _window.obApi = function() {api.dispatch ? api.dispatch.apply(api, arguments) : api.queue.push(arguments);};api.version = '1.1';api.loaded = true;api.marketerId = OB_ADV_ID;api.queue = [];var tag = _document.createElement('script');tag.async = true;tag.src = '//amplify.outbrain.com/cp/obtp.js';tag.type = 'text/javascript';var script = _document.getElementsByTagName('script')[0];script.parentNode.insertBefore(tag, script);}(window, document);
				obApi('track', 'PAGE_VIEW');
			</script>
		<?php } ?>
		<script>!function(s,a,e,v,n,t,z){if(s.saq)return;n=s.saq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!s._saq)s._saq=n;n.push=n;n.loaded=!0;n.version='1.0';n.queue=[];t=a.createElement(e);t.async=0;t.src=v;z=a.getElementsByTagName(e)[0];z.parentNode.insertBefore(t,z)}(window,document,'script','https://tags.srv.stackadapt.com/events.js');saq('rt', 'pucX7ZTWNYqGbBSQOfAAJQ');</script>
		<noscript><img src='https://srv.stackadapt.com/rt?sid=pucX7ZTWNYqGbBSQOfAAJQ' width='1' height='1'/></noscript>
		
		<!-- Video support IE8 -->
  		<script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
	</head>
	<body <?php body_class(); ?>>

			<!-- header -->
		<?php if ( !is_page_template('page-presell-one.php') and !is_page_template('page-presell-two.php') and !is_page_template('page-presell-three.php') and !is_page_template('page-presell-four.php') and !is_page_template('page-presell-five.php') and !is_page_template('page-presell-six.php') ) { ?>
			
			<?php if (!is_user_logged_in()) { ?>
				<div id="banner-offer" class="tpc-logged-hidden"><div class="banner-container"><p>LIMITED TIME OFFER <span class="banner-space">50% OFF</span> YOUR FIRST MONTH WITH CODE <span>50OFF</span></p></div></div>
			<?php } ?>

			<header class="header clear" role="banner">
				
			<!-- logo -->
				<div class="container header-container">
					<div class="logo">
						<a href="<?php echo home_url(); ?>">
							<!-- svg logo - toddmotto.com/mastering-svg-use-for-a-retina-web-fallbacks-with-png-script -->
							<img src="<?php echo get_template_directory_uri(); ?>/img/the-purse-club-logo.png" alt="The Purse Club" class="logo-img">
						</a>
					</div>
				<!-- /logo -->
				<div class="tpc-login-section">
					<?php get_template_part( 'template-parts/header/login', 'section' ); ?>
				</div>
				</div>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-tpc-navbar-collapse" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- nav -->
				<div class="container nav-container">
					
					<div class="collapse navbar-collapse" id="bs-tpc-navbar-collapse">
						<div class="tpc-login-section tpc-login-section-mobile">
							<?php get_template_part( 'template-parts/header/login', 'section' ); ?>
						</div>
						<?php html5blank_nav(); ?>
					</div>
				</div>
				<!-- /nav -->
			</header>
			<!-- /header -->
			<?php } ?>
