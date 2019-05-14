<?php

class TPC_Email extends WC_Email {

    function __construct() {
        $this->id = 'tpc_email_customer_select_purse';
        $this->title = 'Customer Select Purse Email';
        $this->description = 'This mail is send when a customer selects a new purse for billing';
        $this->heading = 'Custom Item Email';
        $this->subject = '[{blogname}] Order for {product_title} (Order {order_number}) = {order_date}';
    
        $this->template_html = '/emails/custom-item-email-html.php';
        $this->template_plain = '/emails/custom-item-email-plain.php';

        add_action('tpc_select_purse_month', array( $this, 'queue_notification' ));
        add_action('custom_item_email_notification', array( $this, 'trigger' ));

        parent::__construct();

        $this->template_base = TPC_EMAIL_TEMPLATE_PATH;
        $this->recipient = $this->get_option('recipient', get_option('admin_email'));
    }

    public function queue_notification($order_id) {
        // $order = new WC_Order($order_id);
        // $items = $order->get_items();

        wp_schedule_single_event(time(), 'tpc_select_purse', array('item_id' => $order_id));
    }

    function trigger($item_id) {
        $send_email = true;

        if ($item_id && $send_email) {
            $this->object = $this->create_object( $item_id );
            $key = array_search('{product_title}', $this->find);

            if (false !== $key) {
                unset($this->find[$key]);
                unset($this->replace[$key]);
            }

            $this->find[] = '{product_title}';
            $this->replace[] = $this->object->product_title;

            if ($this->object->order_id) {
                $this->find[] = '{order_date}';
                $this->replace[] = date_i18n(wc_date_format(), strtotime($this->object->order_date));
    
                $this->find[] = '{order_number}';
                $this->replace[] = $this->object->order_id;
            } else {
                $this->find[] = '{order_date}';
                $this->replace[] = 'N/A';
    
                $this->find[] = '{order_number}';
                $this->replace[] = 'N/A';
            }

            if (! $this->get_recipient() ) {
                return;
            }
            $this->send(
                $this->get_recipient(), $this->get_subject(),
                $this->get_content(), $this->get_headers());
        }
    }

    public static function create_object($item_id) {
        global $wpdb;

        $item_object = new stdClass();

        $query_order_id = "SELECT order_id FROM `" . $wpdb->prefix . "woocommerce_order_items` WHERE order_item_id = %d";
        $get_order_id = $wpdb->get_results($wpdb->prepare($query_order_id, $item_id));

        $order_id = 0;
        if (isset($get_order_id) && is_array($get_order_id) && count($get_order_id) > 0) {
            $order_id = $get_order_id[0]->order_id;
        }

        $item_object->order_id = $order_id;
        $order = new WC_Order($order_id);

        $post_data = get_post($order_id);
        $item_object->order_date = $post_data->post_date;
        $item_object->product_id = wc_get_order_item_meta($item_id, '_product_id');
        $_product = wc_get_product($item_object->product_id);
        $item_object->product_title = $_product->get_title();
        $item_object->qty = wc_get_order_item_meta($item_id, '_qty');
        $item_object->total = wc_price(wc_get_order_item_meta($item_id, '_line_total'));
        $item_object->billing_email = ( version_compare( WOOCOMMERCE_VERSION, "3.0.0" ) < 0 ) ? $order->billing_email : $order->get_billing_email();
        $item_object->customer_id = ( version_compare( WOOCOMMERCE_VERSION, "3.0.0" ) < 0 ) ? $order->user_id : $order->get_user_id();
    
        return $item_object;
    }

    function get_content_html() {
        ob_start();
        wc_get_template($this->template_html, array(
            'item_data' => $this->object,
            'email_heading' => $this->get_heading()
        ), 'tpc-custom-email/', $this->template_base);
        return ob_get_clean();
    }

    function get_content_plain() {
        ob_start();
        wc_get_template($this->template_plain, array(
            'item_data' => $this->object,
            'email_heading' => $this->get_heading()
        ), 'tpc-custom-email/', $this->template_base);
        return ob_get_clean();
    }

    function get_subject() {
        $order = new WC_Order($this->object->order_id);
        return apply_filters('woocommerce_email_subject_' . $this->id, $this->format_string($this->subject), $this->object);
    }

    function get_heading() {
        $order = new WC_Order($this->object->order_id);
        return apply_filters('woocommerce_email_heading_' . $this->id, $this->format_string($this->heading), $this->object);
    }

    function init_form_fields() {
        $this->form_fields = array(
            'enabled' => array(
                'title' => 'Enable/Disable',
                'type' => 'checkbox',
                'label' => 'Enable this email notification',
                'default' => 'yes'
            ),
            'recipient' => array(
                'title' => 'Recipient',
                'type' => 'text',
                'description' => sprintf('Enter recipients (comma separated) for this email. Defaults to %s', get_option('admin_email')),
                'default' => get_option('admin_email')
            ),
            'subject' => array(
                'title' => 'Subject',
                'type' => 'text',
                'description' => sprintf('This controls the email subject line. Leave blank to use default subject: <code>%s</code>.', $this->subject),
                'placeholder' => '',
                'default' => ''
            ),
            'heading' => array(
                'title' => 'Email Heading',
                'type' => 'text',
                'description' => sprintf('This controls the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.', $this->heading),
                'placeholder' => '',
                'default' => ''
            ),
            'email_type' => array(
                'title' => 'Email Type',
                'type' => 'select',
                'description' => 'Choose which format of email to send.',
                'default' => 'html',
                'class' => 'email_type',
                'options' => array(
                    'plain' => 'Plain Text',
                    'html' => 'HTML',
                    'multipart' => 'Multipart'
                )
            )
        );
    }
}

return new TPC_Email();
?>