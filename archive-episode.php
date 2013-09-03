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
<?php global $wp_query;
query_posts( array_merge( $wp_query->query_vars, array( 'orderby' => 'menu_order', 'order' => 'ASC' ) ) );
?>
<?php $i = 0; ?>
<?php while ( have_posts() ) : the_post(); ?>
	<?php 
	$image_id = get_post_thumbnail_id($post->ID);
    $image = wp_get_attachment_image_src( $image_id, 'custom_large' ); ?>
	<?php if($i > 0): ?><div class="divider"></div><?php endif; ?>
	<div class="episode">
		<div class="inner container" style="background: url(<?php echo $image[0]; ?>);">
			<div class="content">
				<h2 class="title"><?php if(get_field('rider_title')): ?><span class="orange"><?php the_field('rider_title') ?></span><br /><?php endif; ?><?php the_title(); ?></h2> 
				<h6 class="sub-title"><?php the_field('sub_title'); ?></h6>
				<p><a href="<?php the_permalink(); ?>" class="white-btn"><?php _e("Watch this film", THEME_NAME); ?></a>
			</div>
			<div class="overlay"></div>
		</div>
	</div>
	<?php $i++; ?>
<?php endwhile; // end of the loop. ?>
</div><!-- #page -->
<?php get_footer(); ?>