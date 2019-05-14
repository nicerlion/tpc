			<!-- footer -->
			<section class="features" style="">
			    <div class="container">
			        <div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 features-box"> 
							<div class=" col-xs-6 col-sm-6 col-md-6 col-lg-6 features-left">
								<?php 
								$image = get_option('TPCfooterImg1');
								if( !empty($image) ): ?>
									<p><img src="<?php echo get_option('TPCfooterImg1'); ?>" alt="<?php echo img_alt(get_option('TPCfooterImg1')); ?>"/></p>
								<?php endif; ?>
								<h5><?php echo get_option('TPCfooterContentText1'); ?></h5>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 features-right">
								<?php 
								$image = get_option('TPCfooterImg2');
								if( !empty($image) ): ?>
									<p><img src="<?php echo get_option('TPCfooterImg2'); ?>" alt="<?php echo img_alt(get_option('TPCfooterImg2')); ?>"/></p>
								<?php endif; ?>
								<h5><?php echo get_option('TPCfooterContentText2'); ?></h5>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 features-box fb-down">
							<div class=" col-xs-6 col-sm-6 col-md-6 col-lg-6 features-left features-down">
								<?php 
								$image = get_option('TPCfooterImg3');
								if( !empty($image) ): ?>
									<p><img src="<?php echo get_option('TPCfooterImg3'); ?>" alt="<?php echo img_alt(get_option('TPCfooterImg3')); ?>"/></p>
								<?php endif; ?>
								<h5><?php echo get_option('TPCfooterContentText3'); ?></h5>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 features-right features-down">
								<?php 
								$image = get_option('TPCfooterImg4');
								if( !empty($image) ): ?>
									<p><img src="<?php echo get_option('TPCfooterImg4'); ?>" alt="<?php echo img_alt(get_option('TPCfooterImg4')); ?>"/></p>
								<?php endif; ?>
								<h5><?php echo get_option('TPCfooterContentText4'); ?></h5>
							</div>
						</div>
			        </div> <!-- row -->
			    </div> <!-- container -->
			    <div class='vertical-line vertical-line-50'></div>
			</section>
			<?php
			$field = get_field_object('show_social_bar');
			if ( is_active_sidebar( 'tpc-social-bar' ) and $field['value'] == "yes") : ?>
				<div class="tpc-social-bar-container">
					<div class="container">
						<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8">
							<img src="https://www.thepurseclub.com/wp-content/uploads/2018/02/accepted-cards.png" alt="Accepted cards" class="accepted-cards"/>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
							<div class="tpc-social-container">
								<?php dynamic_sidebar( 'tpc-social-bar' ); ?>
							</div><!-- #tpc-social-container -->
						</div>
					</div>
				</div><!-- #tpc-social-bar-container -->
			<?php endif; ?>
			<footer class="footer" role="contentinfo">
				<div class="container">
					<div class="row">
					<h3>Subscribe for Access to Exclusive Offers and Discounts</h3>
						<form class="form-inline">
							<div class="col-xs-12 col-md-6 home-form-container">
								<div class="email-input-container">
									<input type="email" class="form-control subscription-input" id="inputPassword2" placeholder="EMAIL">
								</div>
								<div class="submit-input-container">
									<button type="submit" class="btn btn-join">JOIN</button>
								</div>
							</div>
						</form>						
					</div>
					<?php if ( is_active_sidebar( 'tpc-footer' )): ?>
						<div class="row tpc-accordion-footer">
							<?php dynamic_sidebar( 'tpc-footer' ); ?>
						</div>
					<?php endif ?>
				</div>
				<!-- copyright -->
				<?php if ( is_active_sidebar( 'tpc-copyright' )): ?>
						<div class="tpc-container-copyright">
							<div class="container">
								<div class="row">
									<?php dynamic_sidebar( 'tpc-copyright' ); ?>
								</div>
							</div>
						</div>
				<?php endif ?>
				<!-- /copyright -->
			</footer>
			<!-- /footer -->
		<?php wp_footer(); ?>
		<!-- Login Modal -->
		<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<p class="modal-title" id="exampleModalLabel">DON'T HAVE AN ACCOUNT? <a href="">SUBSCRIBE HERE</a></p>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="modal-logo">
							<img src="https://www.thepurseclub.com/wp-content/uploads/2017/10/the-purse-club-logo-1.png" alt="">
						</div>
						<h3>ACCOUNT LOGIN</h3>
						<div class="login-container">
							<h5>FORGOT PASSWORD</h5>
							<a href="<?php echo esc_url( site_url( '/my-account/lost-password/') ); ?>">RESET HERE</a>
						</div>
						<!-- /login container -->
					</div>
					<!-- /modal body -->
				</div>
				<!-- /modal content -->
			</div>
			<!-- /modal dialog -->
		</div>
		<!-- /Login Modal -->
		<!-- Contact Us Modal -->
		<div class="modal fade" id="contactUsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog contactus-modal-dialog" role="document">
				<div class="contactus-content">
					<div class="contactus-modal-body">
						<?php dynamic_sidebar( 'tpc-contact-us' ); ?>
					</div>
					<!-- /modal body -->
				</div>
				<!-- /modal content -->
			</div>
			<!-- /modal dialog -->
		</div>
		<!-- /Contact us Modal -->
		<!-- analytics -->


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


			  <!-- Modal -->
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
		<script type="text/javascript">
		jQuery(document).ready(function() {    
			jQuery('#user_login').blur(function(){

				jQuery('#Info').html('<img src="loader.gif" alt="" />').fadeOut(1000);

				var username = jQuery(this).val();        
				var dataString = 'username='+username;

				jQuery.ajax({
					type: "POST",
					url: "<?php echo esc_url( site_url( 'check_username_availablity.php') ); ?>",
					data: dataString,
					success: function(data) {
						jQuery('#Info').fadeIn(1000).html(data);
					}
				});
			});              
		});    
		</script>

		<?php if ( is_page_template('front-page-green.php') or is_page_template('front-page-black.php') or is_page_template('front-page-the-perfect-purse.php') or is_page_template('front-page-the-perfect-purse-2.php') or is_page_template('front-page-the-perfect-purse-3.php')) { ?>
			<script type="text/javascript">
			    function time_nex(){
			      jQuery( ".flex-next" ).trigger( "click" );
			    }
			    setInterval("time_nex()",8000);
			</script>
			<script type=""text/javascript"">
				window._tfa = window._tfa || [];
				_tfa.push({ notify: 'mark',type: 'Retarget' });
			</script>
			<script src=""//cdn.taboola.com/libtrc/vader-sc-sc/tfa.js""></script>
			<script>!function(s,a,e,v,n,t,z){if(s.saq)return;n=s.saq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!s._saq)s._saq=n;n.push=n;n.loaded=!0;n.version='1.0';n.queue=[];t=a.createElement(e);t.async=0;t.src=v;z=a.getElementsByTagName(e)[0];z.parentNode.insertBefore(t,z)}(window,document,'script','https://tags.srv.stackadapt.com/events.js');saq('rt', 'pucX7ZTWNYqGbBSQOfAAJQ');</script><noscript><img src='https://srv.stackadapt.com/rt?sid=pucX7ZTWNYqGbBSQOfAAJQ' width='1' height='1'/></noscript>
		<?php } ?>
		
		<?php if ( is_page_template('page-billing-information.php') ) { ?>
			<?php 
				global $product;
				$args = array(
					'post_type' => 'product',
					'product_cat' => 'upsell',
					'posts_per_page' => 1,
					'order'   => 'DESC'
				);
				$attractions  = new WP_Query($args); 
				while($attractions->have_posts()) : $attractions->the_post(); 
					$add_to_cart_id = $post->ID; 
				endwhile; 
				// Restore original post data.
				wp_reset_postdata();

				$upsellAddCart = "no";
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					if ($add_to_cart_id == $cart_item["product_id"]) {
						$upsellAddCart = "yes";
					}
				}
			?>
			<?php if ($upsellAddCart == "yes"): ?>
				<script type="text/javascript">
					localStorage.setItem('upSellhasBeenOpened',true);
				</script>
			<?php endif ?>
			<script>
				jQuery(document).ready(function(){
					
					// Getting The Quiz Values from local storage
					var purseC = localStorage.getItem('purseColor');
					var purseS = localStorage.getItem('purseSize');
					var purseT = localStorage.getItem('purseType');
					
					jQuery("#purse_color").val(purseC);
					jQuery("#purse_size").val(purseS);
					jQuery("#purse_type").val(purseT);

					var billingCountryValor = jQuery('#billing_country').val();
					if( billingCountryValor == "CA" ){
						jQuery('#billing_postcode').attr("type","text");
					}else{
						jQuery('#billing_postcode').attr("type","number");
					}

					var shippingCountryValor = jQuery('#shipping_country').val();
					if( shippingCountryValor == "CA" ){
						jQuery('#shipping_postcode').attr("type","text");
					}else{
						jQuery('#shipping_postcode').attr("type","number");
					}
				});
				jQuery('#billing_country').on('change',function(){
				    var billingCountryValor = jQuery('#billing_country').val();
					if( billingCountryValor == "CA" ){
						jQuery('#billing_postcode').attr("type","text");
					}else{
						jQuery('#billing_postcode').attr("type","number");
					}
				});
				jQuery('#shipping_country').on('change',function(){
				    var shippingCountryValor = jQuery('#shipping_country').val();
					if( shippingCountryValor == "CA" ){
						jQuery('#shipping_postcode').attr("type","text");
					}else{
						jQuery('#shipping_postcode').attr("type","number");
					}
				});
			</script>
			<script>
				var upsellClicked = localStorage.getItem('upSellhasBeenOpened');
				if(upsellClicked == "true"){
					jQuery("#tpc-script").html("<style>#place-order-container{display: block !important;} .upsell-btn{display: none !important;}</style>");
				}else{
					jQuery("#tpc-script").html("<style>#place-order-container{display: none !important;} .upsell-btn{display: block !important;}</style>");
				}
				jQuery("#terms").live( 'click', function(){
					if( jQuery("#terms").is(':checked') ) {
						jQuery("#tpc-script-validation").html("<style>.validation-box-btn{display: none !important;} .validation-box-action{display: block !important;}</style>");
						jQuery('.validation-hover-popup').css("display", "none");
					} else {
						jQuery("#tpc-script-validation").html("<style>.validation-box-btn{display: block !important;} .validation-box-action{display: none !important;}</style>");
					}
				});
				jQuery('#validation-box-submit').live( 'click', function(event){
					jQuery('.validation-hover-popup').css("display", "block");
					if (jQuery(this).attr('href') == "" || jQuery(this).attr('href')) {
						event.preventDefault();
						event.stopPropagation();
					}
				});
				jQuery('#yes-upsell').live("hover", function(){
					jQuery("#hidden_upsell").val("yes");
				});
				jQuery('#no-upsell').live("hover", function(){
					jQuery("#hidden_upsell").val("no");
				});
				jQuery('#upsellV1BackPopup').live("hover", function(){
					jQuery("#hidden_upsell").val("no");
				});
				jQuery('#yes-upsell input').live("focus", function(){
					jQuery("#hidden_upsell").val("yes");
				});
				jQuery('#no-upsell input').live("focus", function(){
					jQuery("#hidden_upsell").val("no");
				});
				jQuery('#upsellV1BackPopup').live("focus", function(){
					jQuery("#hidden_upsell").val("no");
				});
			</script>
		<?php } ?>
		<script>
			function readCookie(name) {
				var list = document.cookie.split(";");
				var micookie = "";
				for (i in list) {
					var search = list[i].search(name);
					if (search > -1) {micookie=list[i]}
				}
				var same = micookie.indexOf("=");
				var value = "";
				value = micookie.substring(same+1);
				if (micookie == "") {
					return "false";
				}else{
					return value;
				}
			}
			var CookieItemsCart = readCookie("woocommerce_items_in_cart");
			if ( CookieItemsCart == "false") {
				localStorage.setItem('productCartMembership',false); 
			}
		</script>
		<script src="https://vjs.zencdn.net/6.6.0/video.js"></script>
		<script>
			jQuery(document).ready(function(){
				if (/(iPhone|iPod|iPad)/i.test(navigator.userAgent)) {
					if (/OS [2-9]_\d(_\d)? like Mac OS X/i.test(navigator.userAgent)) {
						jQuery('#tpp-video-id').prop("controls", true);
					} else if (/CPU like Mac OS X/i.test(navigator.userAgent)) {
						jQuery('#tpp-video-id').prop("controls", true);
					} else {
						jQuery('#tpp-video-id').click(function() {
							if (jQuery('#tpp-video-id').prop('muted')) {
								jQuery('#tpp-video-id').prop('muted', false);
							} else {
								jQuery('#tpp-video-id').prop('muted', true);
							}
						});
					}
				} else {
					jQuery('#tpp-video-id').click(function() {
						if (jQuery('#tpp-video-id').prop('muted')) {
							jQuery('#tpp-video-id').prop('muted', false);
						} else {
							jQuery('#tpp-video-id').prop('muted', true);
						}
					});
				}

				jQuery(".contact-us a").removeAttr("href");
			});
		</script>
		<div id="tpc-style-content"></div>
	</body>
</html>
