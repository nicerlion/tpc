<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices(); ?>

<div class="container-fluid loginp-main-container">
	<div class="loginp-bar-contain">
		<div class="loginp-subscribe-bar reset-password-subscribe-bar">
			<p>DON'T HAVE AN ACCOUNT?
				<a href="">SUBSCRIBE HERE!</a>
			</p>
		</div>
		<form method="post" class="woocommerce-ResetPassword lost_reset_password reset-password-section">
			<div class="loginp-logo-box">
							<img src="https://www.thepurseclub.com/wp-content/uploads/2017/10/the-purse-club-logo-1.png">
						</div>
			<h3>ACCOUNT LOGIN</h3>
			<div class="loginp-box">
				
				<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first login-fields-sec">
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_1" id="password_1" placeholder="NEW PASSWORD *" />
				</p>
				<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first login-fields-sec">
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_2" id="password_2"  placeholder="RE-ENTER NEW PASSWORD *"/>
				</p>

				<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
				<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />

				<div class="clear"></div>

				<?php do_action( 'woocommerce_resetpassword_form' ); ?>

				<p class="woocommerce-form-row form-row login-fields-sec reset-submit">
					<input type="hidden" name="wc_reset_password" value="true" />
					<input type="submit" class="woocommerce-Button button" value="<?php esc_attr_e( 'Save', 'woocommerce' ); ?>" />
				</p>

				<?php wp_nonce_field( 'reset_password' ); ?>
			</div>
		</form>
	</div> <!-- ends loginp-bar-contain -->
</div> <!-- ends container-fluid loginp-main-container -->