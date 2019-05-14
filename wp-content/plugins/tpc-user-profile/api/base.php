<?php


abstract class APITPC extends WP_REST_Controller {

    static $prefix = 'tpc-api';

    public function get_user_logged( $request ) {
        return is_user_logged_in();
    }

    protected function get_images( $product ) {
        $images = array();
        $attachment_ids = array();

        // Add featured image.
        if ( has_post_thumbnail( $product->get_id() ) ) {
            $attachment_ids[] = $product->get_image_id();
        }

        // Add gallery images.
        $attachment_ids = array_merge( $attachment_ids, $product->get_gallery_image_ids() );

        // Build image data.
        foreach ( $attachment_ids as $position => $attachment_id ) {
            $attachment_post = get_post( $attachment_id );
            if ( is_null( $attachment_post ) ) {
                continue;
            }

            $attachment = wp_get_attachment_image_src( $attachment_id, 'full' );
            if ( ! is_array( $attachment ) ) {
                continue;
            }

            $images[] = array(
                'src' => current( $attachment ),
                'alt' => get_post_meta( $attachment_id, '_wp_attachment_image_alt', true )
            );
        }

        // Set a placeholder image if the product has no images set.
        if ( empty( $images ) ) {
            $images[] = array(
                'src' => wc_placeholder_img_src(),
                'alt' => __( 'Placeholder', 'woocommerce' )
            );
        }

        return $images;
    }
    
}

?>