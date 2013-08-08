<?php
/**
 * The template for displaying archive episode pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package landrover
 * @since landrover 1.0
 */
get_header(); ?>

<div id="archive-episode">
<?php $i = 0; ?>
<?php while ( have_posts() ) : the_post(); ?>
	<?php if($i > 0): ?><div class="divider"></div><?php endif; ?>
	<div class="episode">
		<div class="inner container" style="background: url(http://www.carsuk.net/wp-content/gallery/land-rover-lrx-concept/land-rover-lrx-1.jpg);">
			<div class="content">
				<h2 class="title"><?php _e("Episode", THEME_NAME); echo ' '; the_field('episode_number'); echo ': <span class="orange">'; the_title(); ?></span></h2> 
				<h6 class="sub-title"><?php the_field('sub_title'); ?></h6>
				<p><a href="<?php the_permalink(); ?>" class="white-btn"><?php _e("Play this episode", THEME_NAME); ?></a>
			</div>
		</div>
	</div>
	<?php $i++; ?>
<?php endwhile; // end of the loop. ?>
</div><!-- #page -->
<?php get_footer(); ?>