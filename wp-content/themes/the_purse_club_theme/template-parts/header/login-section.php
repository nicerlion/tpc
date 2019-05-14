<?php
/**
 * Displays header top
 *
 * @package WordPress
 * @subpackage The Purse Club
 * @since 1.0
 * @version 1.0
 */

?>
<ul>
    
    <?php
        if ( is_user_logged_in() ) {
            
            $current_user = wp_get_current_user();
            
            echo '<li>Hi ' . $current_user->user_firstname . '</li>';
            echo '<li><a href="' . wp_logout_url( home_url() ) . '">Logout</a></li>'; 

        } else {
            
            /* echo '<li><a href="#" data-toggle="modal" data-target="#loginModal">SIGN IN</a></li>'; */
            echo '<li><a href="' . home_url() . '/my-account">SIGN IN</a></li>';
            echo '<li><a href="/take-style-quiz">JOIN NOW</a></li>';
            
        }
    ?>
    
    
</ul>
