<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package landrover
 * @since landrover 1.0
 */
$lightbox = (isset($_GET['lightbox']) && $_GET['lightbox'] == true) ? true : false;
$ajax = (isset($_GET['ajax']) && $_GET['ajax'] == true) ? true : false;
get_header(); ?>
<?php if(!$lightbox): ?>
<?php if($ajax) : ?><button class="close-btn"></button><?php endif; ?>
<div id="index">
	<?php while ( have_posts() ) : the_post(); ?>
	<div class="content" <?php post_class(); ?>>
		<?php if(!$post->post_content == ''): ?>
		<div class="page-content container">
			<div class="span"><?php the_content(); ?></div>
		</div>
		<?php endif; ?>
		<?php if ( get_field('content')):?>
		<?php get_template_part('inc/content'); ?>
		<?php endif; ?>
	</div>
	<?php endwhile; // end of the loop. ?>
</div><!-- #index -->

<?php else: ?>
<div id="index-lightbox">
	<div class="inner">
		<?php while ( have_posts() ) : the_post(); ?>
		<header class="header">
			<h4 class="no-margin"><?php the_title(); ?></h4>
			<button class="close-btn"></button>
		</header>
		<div class="content" <?php post_class(); ?>>
			<?php if(!$post->post_content == ''): ?>
			<div class="page-content container">
				<div class="span"><?php the_content(); ?></div>
			</div>
			<?php endif; ?>
			<?php if ( get_field('content')):?>
			<?php get_template_part('inc/content'); ?>
			<?php endif; ?>
		</div>
		<footer class="footer">
			<p class="text-center no-margin"><button class="close-btn">&nbsp;&nbsp;<?php _e("Close window", THEME_NAME); ?></button></p>
		</footer>
		<?php endwhile; // end of the loop. ?>
	</div>
</div><!-- #index -->
<?php endif; ?>
<?php get_footer(); ?>