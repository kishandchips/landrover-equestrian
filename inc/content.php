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
			<div class="divider grey-gradient-bg">
				<?php if(get_sub_field('title')): ?>
				<div class="inner container">
					<h2 class="text-center"><?php the_sub_field('title'); ?></h2>
				</div>
				<?php endif; ?>
			</div>
			<?php break; ?>
		<?php case 'accordion':  ?>
			<?php if(get_sub_field('items', $id)): ?>
			<?php wp_enqueue_script('accordion'); ?>
			<div class="accordion-container">
				<ul class="accordion container">
					<?php while (has_sub_field('items', $id)) : ?>
					<li class="item">
						<button class="btn"><?php the_sub_field('title'); ?></button>
						<img src="http://www.carsuk.net/wp-content/gallery/land-rover-lrx-concept/land-rover-lrx-1.jpg" />
						<div class="content">
							<h2><?php the_sub_field('title'); ?></h2>
							<?php the_sub_field('sub_title'); ?>
						</dov>
					</li>
					<?php endwhile; ?>
				</ul>
			</div>
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