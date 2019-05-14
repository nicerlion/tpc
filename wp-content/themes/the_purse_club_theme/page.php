<?php get_header(); ?>
<main role="main" id="main-wrapper">
	<!-- section -->
	<section>
		<div class="container">
			<div class="row">
				<h1 class="woo-title"><span class="hiphen"></span><?php the_title(); ?><span class="hiphen"></span></h1>
			</div>
		</div>
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php the_content(); ?>
				<?php comments_template( '', true ); // Remove if you don't want comments ?>
				<br class="clear">
				<?php edit_post_link(); ?>
			</article>
			<!-- /article -->
		<?php endwhile; ?>
		<?php else: ?>
			<!-- article -->
			<article>
				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
			</article>
			<!-- /article -->
		<?php endif; ?>
	</section>
	<!-- /section -->
</main>
<?php get_footer(); ?>
