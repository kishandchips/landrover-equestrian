<?php $id = (isset($id)) ? $id : $post->ID; ?>
<?php $i = 0; ?>
<?php if(get_field('content', $id)): ?>
<?php while (has_sub_field('content', $id)) : ?>
<?php
	$layout = get_row_layout();
	switch($layout){

		case 'row':	
			if(get_sub_field('column')):
?>
			<div class="row" style="<?php the_sub_field('css'); ?>">
				<div class="inner container">

				<?php $total_columns = count( get_sub_field('column', $id)); ?>
				<?php while (has_sub_field('column', $id)) : ?>
					<?php
					switch($total_columns){
						case 2:
							$class = 'five';
							break;
						case 3:
							$class = 'one-third';
							break;
						case 4:
							$class = 'one-fourth';
							break;
						case 5:
							$class = 'one-fifth';
							break;
						case 1:
						default:
							$class = 'ten';
							break;
					} ?>
					<div class="break-on-mobile span <?php echo $class; ?>" style="<?php the_sub_field('css'); ?>">
						<?php the_sub_field('content'); ?>
					</div>
				<?php endwhile; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php break; ?>
		<?php case 'divider':  ?>
			<div class="divider">
				<?php if(get_sub_field('title')): ?>
				<div class="inner container">
					<h3 class="text-center"><?php the_sub_field('title'); ?></h3>
				</div>
				<?php endif; ?>
			</div>
			<?php break; ?>
		<?php case 'accordion':  ?>
			<?php if(get_sub_field('items', $id)): ?>
			<?php wp_enqueue_script('accordion'); ?>
			<div class="accordion-container container">
				<ul class="accordion">
					<?php $i = 0; ?>
					<?php while (has_sub_field('items', $id)) : ?>
					<?php $bg_image = get_sub_field('background_image'); ?>
					<?php $ajax_page = get_sub_field('ajax_page', $id); ?>
					<li class="item <?php if($i == 0) echo 'current'; ?> <?php if($ajax_page) echo 'ajax-btn'; ?>" href="<?php echo get_permalink($ajax_page->ID); ?>" style="background-color: #000; background-image: url(<?php echo $bg_image['sizes']['accordion']; ?>);">
						<footer class="footer">
							<button class="btn"><?php the_sub_field('title'); ?></button>
						</footer>
						<div class="content">
							<h2 class="no-margin"><?php the_sub_field('title'); ?></h2>
							<p class="landrover-light uppercase no-margin"><?php the_sub_field('sub_title'); ?></p>
						</div>
						<div class="overlay"></div>
					</li>
					<?php $i++; ?>
					<?php endwhile; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php break; ?>
		<?php case 'ajax_page':  ?>
			<div id="ajax-page" class="<?php if(get_sub_field('show_close_button')) echo 'show-close-btn'; ?>"></div>
			<?php break; ?>
		<?php case 'episodes_scroller': 
			$query = new WP_Query(array('post_type' => 'episode', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' )); 
			if($query->have_posts()):
			?>
			<div class="container episodes">
				<div class="scroller" data-resize="true">
					<div class="scroller-mask">
						<?php while($query->have_posts()): $query->the_post(); ?>
						<?php 
						$image_id = get_post_thumbnail_id($post->ID);
					    $image = wp_get_attachment_image_src( $image_id, 'custom_large' ); ?>
						<div class="scroll-item" data-id="<?php the_ID(); ?>" style="background-image: url(<?php echo $image[0]; ?>);">
							<div class="content">
								<h2 class="episodes-title no-margin"><?php if(get_field('rider_title')): ?><span class="orange"><?php the_field('rider_title') ?></span><br /><?php endif; ?><?php the_title(); ?></h2>
								<p class="landrover-light uppercase sub-title"><?php the_field('sub_title'); ?></p>
								<p><a href="<?php the_permalink(); ?>" class="white-btn"><?php _e("Watch this film", THEME_NAME); ?></a>
							</div>
							<div class="overlay"></div>
						</div>
						<?php endwhile; ?>
					</div>
					<div class="scroller-navigation">
						<button class="prev-btn"></button>
						<button class="next-btn"></button>
					</div>
					<footer class="episode-scroller-footer">
						<div class="scroller-navigation">
							<button class="prev-btn">&nbsp;</button>
							<button class="next-btn">&nbsp;</button>
						</div>
						<ul class="scroller-pagination">
							<?php while($query->have_posts()): $query->the_post(); ?>
							<li><button class="btn" data-id="<?php the_ID(); ?>"></button></li>
							<?php endwhile; ?>
						</ul>
						<a href="<?php the_permalink(); ?>" class="white-btn episodes-btn">Browse all episodes</a>
					</footer>
				</div>
			</div>
			<?php wp_reset_postdata(); ?>
			<?php endif; ?>
			<?php break; ?>
		<?php case 'episodes': 
			$query = new WP_Query(array('post_type' => 'episode', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' )); 
			if($query->have_posts()):
			?>
			<div class="episodes" style="<?php the_sub_field('css');?>">
				<div class="container inner">
					<?php if(get_sub_field('title') || get_sub_field('content')): ?>
					<header class="episodes-header text-center">
						<h2 class="title text-center"><?php the_sub_field('title');?></h2>
						<?php the_sub_field('content'); ?>
					</header>
					<?php endif; ?>
					<ul class="episodes-list">
						<?php while($query->have_posts()): $query->the_post(); ?>
						<?php 
							$episode_date = strtotime(get_field('episode_date'));
						    $now = strtotime('now');
						?>
						<?php 
					//	$image_id = get_post_thumbnail_id($post->ID);
					  //  $image = wp_get_attachment_image_src( $image_id, 'thumbnail' ); ?>
						<li class="episode span one-fourth <?php if($episode_date <= $now) echo 'live'; ?>">
							<a href="<?php the_permalink(); ?>">
								<div class="featured-image shadow-3d">
									<?php the_post_thumbnail('thumbnail', array('class' => 'scale')); ?>
									<?php if($episode_date <= $now): ?>
									<span class="play-btn"></span>
									<?php endif; ?>
									<div class="overlay"></div>
								</div>
								<header class="header episode-header">
									<h6 class="landrover-medium episode-title no-margin"><?php if(get_field('rider_title')): ?><span class="orange"><?php the_field('rider_title') ?></span><br /><?php endif; ?><?php the_title(); ?></h6>
									<p class="tiny uppercase date">
									<?php if($episode_date >= $now): ?>
									<?php _e("Coming", THEME_NAME); ?> <?php echo date('d F', $episode_date); ?></p>
									<?php else: ?>
									<?php _e("Watch this film", THEME_NAME); ?>
									<?php endif; ?>
									</p>
								</header>
							</a>
						</li>
						<?php endwhile; ?>
					</ul>
				</div>
			</div>
			<?php wp_reset_postdata(); ?>
			<?php endif; ?>
			<?php break; ?>
		<?php case 'riders':
			$query = new WP_Query(array('post_type' => 'rider', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' )); 
			if($query->have_posts()):
				wp_enqueue_script('accordion');
			?>
			<div id="riders" class="riders">
				<div class="inner container">
					<header class="riders-header text-center">
						<h2><?php the_sub_field('title'); ?></h2>
						<p class="landrover-light"><?php the_sub_field('sub_title'); ?></p>
					</header>
					<ul class="riders-accordion accordion" data-tab-width="120"  data-height="400"  data-resize-children="false">
						<?php while($query->have_posts()): $query->the_post(); ?>
						<li class="item rider" data-id="<?php the_ID(); ?>">
							<div class="inner">
								<div class="featured-image">
									<?php the_post_thumbnail('full');?>
									<button class="btn blue-btn"><?php the_title(); ?></button>
								</div>
								<div class="content">
									<button class="close-btn btn"></button>
									<div class="inner">
										<?php the_content(); ?>
									</div>
								</div>
								<div class="overlay"></div>
							</div>
						</li>
						<?php endwhile; ?>
					</ul>
				</div>
			</div>
			<?php wp_reset_postdata(); ?>
			<?php endif; ?>
			<?php break; ?>
		<?php case 'disciplines': 
			$query = new WP_Query(array('post_type' => 'discipline', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' )); 
			if($query->have_posts()):
			?>
			<div class="disciplines">
				<div class="inner container">
					<header class="disciplines-header text-center">
						<h2><?php the_sub_field('title'); ?></h2>
						<p class="landrover-light"><?php the_sub_field('sub_title'); ?></p>
					</header>
					<div id="ajax-page" class="show-close-btn"></div>
					<ul class="disciplines-list clearfix">
						<?php while($query->have_posts()): $query->the_post(); ?>
						<li class="span one-third item discipline">
							<a href="<?php the_permalink(); ?>" class="ajax-btn">
								<div class="featured-image">
									<?php the_post_thumbnail('full', array('class' => 'scale'));?>
									<div class="overlay"></div>
								</div>
								<button class="btn blue-btn"><?php the_title(); ?></button>
							</a>
						</li>
						<?php endwhile; ?>
					</ul>
				</div>
			</div>
			<?php wp_reset_postdata(); ?>
			<?php endif; ?>
			<?php break; ?>
		<?php case 'pages':  ?>

			<?php $pages = get_sub_field('pages'); ?>
			<?php if(!empty($pages)): ?>
			<div class="pages">
				<header class="line-header"><h5 class="title"><?php the_sub_field('title'); ?></h5></header>
				<ul class="page-list clearfix">
					<?php foreach($pages as $post): ?>
					<?php setup_postdata($post) ?>
					<li class="page span">
						<a href="<?php the_permalink(); ?>" class="overlay-btn">
							<?php the_post_thumbnail('thumbnail', array('class' => 'scale')); ?>
						</a>
						<h6 class="uppercase"><a href="<?php the_permalink(); ?>" class="uppercase"><?php the_title(); ?></a></h6>
					</li>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php break; ?>

	<?php } ?>

<?php $i++; ?>
<?php endwhile; ?>
<?php endif; ?>