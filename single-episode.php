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

get_header(); 
wp_enqueue_script('youtube');
?>

<div id="single-episode">
	<?php while ( have_posts() ) : the_post(); ?>
	<?php 
	$image_id = get_post_thumbnail_id($post->ID);
	$episode_date = strtotime(get_field('episode_date'));
    $now = strtotime('now');
	$episodes_page = get_field('episodes_page', 'options');
	$about_page = get_field('about_page', 'options');
    ?>
	<div class="container">
		<header class="episode-header">
			
			<h2 class="no-margin title text-center">
				<?php if(get_field('rider_title')): ?><span class="orange"><?php the_field('rider_title') ?> </span> - <?php endif; ?>
				<?php the_title(); ?>
			</h2>
		</header>
		<div id="video" class="shadow-3d">
			<?php if($episode_date <= $now): ?>
			<div class="video-container">
				<div id="youtube-video" data-video-id="<?php the_field('youtube_video_id'); ?>"></div>
				<div class="overlay hide">
					<div class="content">
						<h3 class="title no-margin"><?php _e("Keep up to date", THEME_NAME); ?></h3>
						<p class="landrover-light uppercase sub-title"><?php _e("To be notified when a new feature is released and for the chance to win prizes:", THEME_NAME); ?></p>
						<p><a class="white-btn notify-btn"><?php _e("Notify Me", THEME_NAME); ?></a></p>
					</div>
				</div>
			</div>
			<?php else: ?>
			<div class="coming-soon">
				<div class="content">
					<h5 class="orange title landrover-medium"><?php _e("Coming Soon", THEME_NAME); ?></h5>
					<h2 class="white episode-countdown">
						<?php 
							$remaining = $episode_date - time();
							$days_remaining = floor($remaining / 86400);
							$hours_remaining = floor(($remaining % 86400) / 3600);
							$minutes_remaining = floor((($remaining % 86400) / 3600) / 3600);
							echo sprintf("%s days, %s hours", $days_remaining, $hours_remaining, $minutes_remaining);
						?>
					</h5>
					<h6 class="white episode-date"><?php echo date('d F Y', $episode_date); ?></h6>
				</div>
				<div class="featured-image">
					<?php $image = wp_get_attachment_image_src( $image_id, 'custom_medium' ); ?>
					<img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" class="scale"/>
					<div class="overlay"></div>
				</div>
				
			</div>
			<?php endif; ?>
			<div class="back">
				<a href="<?php echo get_permalink($episodes_page->ID); ?>" class="white-btn btn">See all films</a>
			</div>
		</div>

		<div id="content" <?php post_class('clearfix'); ?>>
			<div class="span six alpha">
				
				<div class="content landrover-medium">
					<h4 class="landrover-light uppercase sub-title"><?php the_field('sub_title'); ?></h4>
				<?php if(!$post->post_content == '' && ($episode_date <= $now)): ?>
					<?php the_content(); ?>
				<?php else: ?>
					<p class="bold"><?php _e("This episode will premiere on"); ?> <?php echo date('d/m/Y', $episode_date) ?></p>
				<?php endif; ?>
					<p><a href="<?php echo get_permalink($about_page->ID); ?>">&laquo; <?php _e("Find out more about this rider", THEME_NAME); ?></a></p>
				</div>
				<div class="like">
					<div class="fb-like" data-href="<?php the_permalink(); ?>" data-width="450" data-show-faces="true" data-send="false"></div>
				</div>
				<div class="comments">
					<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="455"></div>
				</div>
			</div>
			
			<div class="span three right omega alpha">
		
				<?php if($episode_date < $now): ?>
				<div class="share">
					<h5 class="orange uppercase no-margin landrover-medium"><?php _e("Share this film", THEME_NAME); ?></h5>
					<?php $thumbnail = wp_get_attachment_image_src( $image_id, 'thumbnail' ); ?>
					<p><a class="share-btn white-btn" data-url="https://apps.facebook.com/landrover-equestrian/<?php echo get_page_uri($episodes_page->ID).'/'.get_page_uri($post->ID); ?>/" data-description="<?php the_field('sub_title'); ?>" data-image="<?php echo $thumbnail[0] ?>" data-name="<?php if(get_field('rider_title')) echo get_field('rider_title'). ' - '; ?><?php the_title(); ?>"><?php _e("Post to timeline", THEME_NAME);?></a></p>
					<!--p><a class="share-btn white-btn" data-url="https://apps.facebook.com/landrover-equestrian/<?php echo get_page_uri(the_ID()); ?>"><?php _e("Post to timeline", THEME_NAME);?></a></p-->
				</div>
				<?php endif; ?>
				<div class="notify">
					<h5 class="orange uppercase no-margin landrover-medium"><?php _e("Keep up to date as soon as the next episode is available", THEME_NAME); ?></h5>
					<!--p class="bold no-margin"><?php _e("Be notified as soon as this episode is available.", THEME_NAME); ?></p-->
					<?php gravity_form(2, false, false); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="divider grey-gradient-bg"></div>
	<div class="episode-pagination">
		<div class="container">
			<div class="inner">
				<?php $prev_episode = get_the_adjacent_fukn_post('prev', 'episode'); ?>
				<?php $next_episode = get_the_adjacent_fukn_post('next', 'episode'); ?>
				<?php if($prev_episode && get_field('episode_number') != 1): ?>
				<a href="<?php echo get_permalink($prev_episode->ID); ?>" class="<?php if(get_field('episode_number') == 4) echo 'center'; ?> episode alpha span four previous dark-grey">
					<div class="clearfix">
						<div class="span five featured-image shadow-3d alpha omega">
							<?php
			                $image_id = get_post_thumbnail_id($prev_episode->ID);
			                $image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
			                ?>
			                <img src="<?php echo $image[0]?>" class="scale" />
			                <div class="overlay"></div>
						</div>
						<div class="content span five">
							<p class="landrover-light uppercase no-margin">Previous</p>
							<h6 class="title no-margin">
								<?php if(get_field('rider_title', $prev_episode->ID)): ?><span class="orange"><?php the_field('rider_title', $prev_episode->ID) ?></span><br /><?php endif; ?>
								<?php echo get_the_title($prev_episode->ID); ?>
							</h6>
						</div>
					</div>
				</a>
				<?php endif; ?>
				<?php if($next_episode && get_field('episode_number') != 4): ?>
				<a href="<?php echo get_permalink($next_episode->ID); ?>" class="<?php if(get_field('episode_number') == 1) echo 'center'; ?> episode omega span four next dark-grey right">
					<div class="clearfix">
						<div class="content span five text-right">
							<p class="landrover-light uppercase no-margin">Next</p>
							<h6 class="title no-margin">
								<?php if(get_field('rider_title', $next_episode->ID)): ?><span class="orange"><?php the_field('rider_title', $next_episode->ID) ?></span><br /><?php endif; ?>
								<?php echo get_the_title($next_episode->ID); ?>
							</h6>
						</div>
						<div class="span five featured-image shadow-3d omega alpha">
							<?php
			                $image_id = get_post_thumbnail_id($next_episode->ID);
			                $image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
			                ?>
			                <img src="<?php echo $image[0]?>" class="scale" />
		   	                <div class="overlay"></div>
						</div>
					</div>
				</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endwhile; // end of the loop. ?>

</div><!-- #page -->
<?php get_footer(); ?>