<?php

require __DIR__ . '/../../../../vendor/autoload.php';
use Automattic\WooCommerce\Client;


abstract class API_Custom_Woocommerce extends APITPC {

    protected function get_client() {
        $SDEBUG = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG;
        $DEBUG = defined('WP_DEBUG') && WP_DEBUG;

        return new Client(
            get_site_url(),
            get_option('TPCprivateKey'),
            get_option('TPCpublicKey'),
            [
                'wp_api' => true,
                'version' => 'wc/v2',
                'timeout' => 30,
                'verify_ssl' => !$SDEBUG && !$DEBUG ? true: false
            ]
        );
    }

}

?>
