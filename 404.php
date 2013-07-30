<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package landrover
 * @since landrover 1.0
 */

get_header(); ?>

<section id="error">
	<div class="container">
		<div class="row">
			<div id="content">
				<div class="inner">
					<h4 class="uppercase brown"><?php _e("404 error - Page not found", THEME_NAME); ?></h4>
					<h2 class="uppercase"><?php _e("You appear to have taken a wrong turn...", THEME_NAME); ?></h2>
					<p><?php _e("The page you are looking for is not here. It may have been deleted, or the address might have been miss-typed. Either way, let’s get you back on track...", THEME_NAME); ?></p>
					<p><?php _e("You can use the navigation bar above, or:", THEME_NAME); ?></p>
					<p>
						<a class="red-btn" href="<?php bloginfo('url') ?>"><?php _e("Go to the Homepage", THEME_NAME); ?> </a>
					</p>

				</div>
			</div><!-- #content .site-content -->
		</div>
	</div>
</section><!-- #error -->
<?php get_footer(); ?>