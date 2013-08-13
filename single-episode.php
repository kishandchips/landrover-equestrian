<?php
/**
 * The template for displaying single episode pages.
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

<div id="single-episode">
	<?php while ( have_posts() ) : the_post(); ?>
	<?php 
	$episode_date = strtotime(get_field('episode_date'));
    $now = strtotime('now');
    ?>
	<div class="container">
		<div id="video" class="shadow-3d">
			<?php if($episode_date < $now): ?>
			<div class="video-container">
				<iframe src="//www.youtube.com/embed/<?php the_field('youtube_video_id'); ?>" frameborder="0" allowfullscreen></iframe>
			</div>
			<?php else: ?>
			<div class="coming-soon">
				<div class="content">
					<h5 class="orange title landrover-medium"><?php _e("Coming Soon", THEME_NAME); ?></h5>
					<h2 class="white episode-countdown">23 days, 5 hours, 3 minutes</h5>
					<h6 class="white episode-date">10 October 2013, 1pm<?php //echo date('', get_field('episode_date')); ?></h6>
				</div>
				<div class="featured-image">
					<?php 
					$image_id = get_post_thumbnail_id($post->ID);
				    $image = wp_get_attachment_image_src( $image_id, 'custom_medium' ); ?>
					<img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" class="scale"/>
					<div class="overlay"></div>
				</div>
				
			</div>
			<?php endif; ?>
		</div>

		<div id="content" <?php post_class('clearfix'); ?>>
			<div class="span five alpha">
				<h2 class="no-margin title"><?php _e("Episode ", THEME_NAME); the_field('episode_number'); echo ': <span class="orange">'; the_title(); ?></span></h2>
				<p class="landrover-light uppercase sub-title"><?php the_field('sub_title'); ?></p>
				<div class="content">
				<?php if(!$post->post_content == '' && ($episode_date < $now)): ?>
					<?php the_content(); ?>
				<?php else: ?>
					<p class="bold"><?php _e("This episode will premierre on 10/10/13"); ?></p>
				<?php endif; ?>
				</div>
			
			</div>
			<?php if($episode_date < $now): ?>
			<div class="span three right share">
				<h5 class="orange uppercase no-margin landrover-medium"><?php _e("Share this episode", THEME_NAME); ?></h5>
				<p><a class="send-to-friends-btn white-btn"><?php _e("Select Friends", THEME_NAME);?></a></p>
			</div>
			<?php else: ?>
			<div class="span four right notify">
				<h5 class="orange uppercase no-margin landrover-medium"><?php _e("Don't miss this episode", THEME_NAME); ?></h5>
				<!--p class="bold no-margin"><?php _e("Be notified as soon as this episode is available.", THEME_NAME); ?></p-->
				<?php gravity_form(2, false, true); ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="divider grey-gradient-bg"></div>
	<div class="episode-pagination">
		<div class="container">
			<div class="inner">
				<?php $prev_episode = get_the_adjacent_fukn_post('prev', 'episode'); ?>
				<?php if($prev_episode): ?>
				<a href="<?php echo get_permalink($prev_episode->ID); ?>" class="episode alpha span four previous dark-grey">
					<div class="span five featured-image shadow-3d alpha omega">
						<?php
		                $image_id = get_post_thumbnail_id($prev_episode->ID);
		                $image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
		                ?>
		                <img src="<?php echo $image[0]?>" class="scale" />
		                <div class="overlay"></div>
					</div>
					<div class="content span five">
						<p class="landrover-light uppercase no-margin">Previous Episode</p>
						<h4 class="title no-margin"><?php _e("Episode", THEME_NAME); echo ' '; the_field('episode_number', $prev_episode->ID); echo ':<br /><span class="orange">'.get_the_title($prev_episode->ID); ?></spam></h4>
					</div>
				</a>
				<?php endif; ?>
				<?php $next_episode = get_the_adjacent_fukn_post('next', 'episode'); ?>
				<?php if($next_episode): ?>
				<a href="<?php echo get_permalink($next_episode->ID); ?>" class="episode omega span four previous dark-grey right">
					
					<div class="content span five text-right">
						<p class="landrover-light uppercase no-margin">Next Episode</p>
						<h4 class="title no-margin"><?php _e("Episode", THEME_NAME); echo ' '; the_field('episode_number', $next_episode->ID); echo ':<br /><span class="orange">'.get_the_title($prev_episode->ID); ?></spam></h4>
					</div>
					<div class="span five featured-image shadow-3d omega alpha">
						<?php
		                $image_id = get_post_thumbnail_id($next_episode->ID);
		                $image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
		                ?>
		                <img src="<?php echo $image[0]?>" class="scale" />
	   	                <div class="overlay"></div>
					</div>
				</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endwhile; // end of the loop. ?>

</div><!-- #page -->
<?php get_footer(); ?>