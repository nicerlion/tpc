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
<div class="tpc-top-ads">
    <div class="container">
        <div class="col-sm-4 left-ad" ><?php the_field('column_content_1'); ?></div>
        <div class="col-sm-4 center-ad"><?php the_field('column_content_2'); ?></div>
        <div class="col-sm-4 last-ad"><?php the_field('column_content_3'); ?></div>
    </div>
</div>