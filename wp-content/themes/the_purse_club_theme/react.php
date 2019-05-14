<?php 
/**
 * Template Name: React Integration
 */

add_action('wp_head', 'add_base_header_for_react');
function add_base_header_for_react() {
    ?>
    <base href="<?php echo (defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '/the-purse-club': ''); ?>/wp-content/themes/the_purse_club_theme/js/frontend/build/">
    <link rel="manifest" href="manifest.json">
    <?php
}
get_header();
?>


<?php require get_template_directory() . "/js/frontend/build/index.html"; ?>


<?php get_footer(); ?>
