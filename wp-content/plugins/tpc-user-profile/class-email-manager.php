<?php


class TPC_Email_Manager {

    public function __construct() {
        define('TPC_EMAIL_TEMPLATE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) . 'templates/' ));

        add_action('tpc_api_user_change_product', array(&$this, 'custom_trigger_email_action'));
        add_filter('woocommerce_email_classes', array(&$this, 'custom_init_emails'));

        $email_actions = array(
            'tpc_select_purse'
        );

        foreach ($email_actions as $action) {
            add_action( $action, array('WC_Emails', 'send_transactional_email'), 10, 10 );
        }

        add_filter('woocommerce_template_directory', array($this, 'custom_template_directory'), 10, 2);
    }

    public function custom_init_emails($emails) {
        if (!isset($emails['TPC_Email'])) {
            $emails['TPC_Email'] = include_once('emails/class-tpc-email.php');
        }
        return $emails;
    }

    public function custom_trigger_email_action($order_id, $posted) {
        if (isset($order_id) && 0 != $order_id) {
            // $order = wc_get_order($order_id);
            new WC_Emails();
            do_action('tpc_select_purse_month', $order_id);
        }
    }

    public function custom_template_directory( $directory, $template ) {
        if (false !== strpos($template, '-custom')) {
            return 'tpc-custom-email';
        }
        return $directory;
    }

}
new TPC_Email_Manager();
?>